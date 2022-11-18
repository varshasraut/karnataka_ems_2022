<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Biomedical extends EMS_Controller {

    var $dtmf, $dtmt; // default time from/to

    function __construct() {

        parent::__construct();  

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->load->library(array('session', 'modules','upload','image_lib'));

        $this->load->model(array('module_model', 'Medadv_model', 'call_model', 'ind_model', 'amb_model', 'colleagues_model', 'cluster_model', 'fleet_model', 'pcr_model', 'colleagues_model', 'inv_stock_model', 'biomedical_model'));

        $this->load->helper(array('comman_helper'));

       // $this->rsm_config = $this->config->item('rsm_config');

        $this->post = $this->input->get_post(NULL);

        $this->post['base_month'] = get_base_month();

        $this->clg = $this->session->userdata('current_user');

        $this->today = date('Y-m-d H:i:s');
        $this->default_state = $this->config->item('default_state');
        $this->amb_pic = $this->config->item('amb_pic');
    }

    public function index() {
        
    }

    public function equipment() {


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
            //$data['from_date'] = date('Y-m-d', strtotime($this->post['search1']));
        } else {
            //$data['to_date'] = date('Y-m-d');
        }




        $args = array(
            'clg_group' => 'UG-DM'
        );

        //$data['clg'] = $this->colleagues_model->get_type_level($args);


        //$data['group_info'] = $this->colleagues_model->get_higher_groups('', $data['clg'][0]->g_type_level);

        $data['req_group'] = 'EQUP';

        $data['total_count'] = $this->biomedical_model->get_all_equipment_item($data);


        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $data['per_page'] = $config['per_page'];

        unset($data['get_count']);


        $data['equipment_data'] = $this->biomedical_model->get_all_equipment_item($data,$offset,$limit);

       // $data['clg_group'] = trim($this->clg->clg_group);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("biomedical/equipment"),
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

        //$data['page_records'] = count($data['equipment_data']);



        $this->output->add_to_position($this->load->view('frontend/biomedical/bio_medical_equipment_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }

    public function equipment_dispatch() {


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
            //$data['from_date'] = date('Y-m-d', strtotime($this->post['search1']));
        } else {
            //$data['to_date'] = date('Y-m-d');
        }



//
//        $args = array(
//            'clg_group' => 'UG-DM'
//        );
//
//        $data['clg'] = $this->colleagues_model->get_type_level($args);
//
//
//        $data['group_info'] = $this->colleagues_model->get_higher_groups('', $data['clg'][0]->g_type_level);

        $data['req_group'] = 'EQUP';

        $data['total_count'] = $this->biomedical_model->get_all_equipment_item($data);


        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $data['per_page'] = $config['per_page'];
        $data['cur_page'] = $page_no;

        unset($data['get_count']);


        $data['equipment_data'] = $this->biomedical_model->get_all_equipment_item($data,$offset,$limit);

        $data['clg_group'] = trim($this->clg->clg_group);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("biomedical/equipment_dispatch"),
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

        $data['page_records'] = count($data['equipment_data']);



        $this->output->add_to_position($this->load->view('frontend/biomedical/bio_medical_equipment_dispatch_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }

    function add_equipment() {

        if ($this->post['f_id'] != '') {

            $data['f_id'] = $ref_id = base64_decode($this->post['f_id']);
            $data['fuel_station'] = $this->fleet_model->get_all_fuel_station($data, $offset, $limit);
        }


        if ($this->post['action_type'] == 'Update') {
            $data['action_type'] = "Update Fuel Station";
            $data['update'] = 'True';

            $this->output->add_to_position($this->load->view('frontend/fleet/register_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Equipment";

            $this->output->add_to_popup($this->load->view('frontend/biomedical/bio_medical_equipment_register_view', $data, TRUE), '1200', '1000');
        }
    }

    function send_equipment_request() {


        $item_key = array('EQP');

        ////////////////////////////////////////////////

        $eflag = "Yes";

        foreach ($item_key as $key) {
            if (is_array($this->post['item'][$key])) {
                foreach ($this->post['item'][$key] as $item) {

                    if ($item['id'] != '') {
                        $eflag = "No";
                    }
                }
            }
        }

        if ($eflag == "Yes") {
            $this->output->message = "<div class='error'>Please request for atleast one item.</div>";
            return;
        }

        ////////////////////////////////////////////////


        if ($this->clg->clg_group == 'UG-BioMedicalManager') {

            $emt_id = $this->clg->clg_ref_id;
        }

        $ind_data = $this->post['eqiup'];



        $args = array(
            'req_emt_id' => $emt_id,
            'req_date' => $this->today,
            'req_base_month' => $this->post['base_month'],
            'req_by' => $this->clg->clg_ref_id,
            'req_type' => 'amb',
            'req_amb_reg_no' => $this->input->post('incient_ambulance'),
            'req_state_code' => $this->input->post('incient_state'),
            'req_district_code' => $this->input->post('incient_district'),
            'req_base_location' => $this->input->post('base_location'),
            'req_shift_type' => $ind_data['req_shift_type'],
            'req_expected_date_time' => date('Y-m-d H:i:s', strtotime($ind_data['req_expected_date_time'])),
            'req_cur_date_time' => date('Y-m-d H:i:s', strtotime($ind_data['req_cur_date_time'])),
            'req_district_manager' => $ind_data['req_district_manager'],
            'req_standard_remark' => $ind_data['req_standard_remark'],
            'req_supervisor' => $ind_data['req_supervisor'],
            'req_group' => 'EQUP',
            'req_isdeleted' => '0',
        );

        if ($ind_data['req_other_remark'] != '') {
            $args['req_other_remark'] = $ind_data['req_other_remark'];
        }
        

       
        $req = $this->ind_model->insert_ind_req($args);

        foreach ($item_key as $key) {
            if (is_array($this->post['item'][$key])) {
                foreach ($this->post['item'][$key] as $dt) {

                    if (!empty($dt['id'])) {

                        $ind_data = array(
                            'ind_item_id' => $dt['id'],
                            'ind_quantity' => $dt['qty'],
                            'ind_item_type' => $key,
                            'ind_req_id' => $req,
                        );


                        $result = $this->ind_model->insert_ind($ind_data);
                    }
                }
            }
        }

        if ($result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Equipment request send successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->equipment();
        }
    }


    

    function view_eqp_details() {


        if ($this->post['req_id'] != '') {

            $data['req_id'] = $ref_id = base64_decode($this->post['req_id']);
            // print_r($data['req_id']);die;
            //$data['indent_data'] = $this->biomedical_model->get_all_equipment_item($data, $offset, $limit);
             $data['indent_data'] = $this->biomedical_model->get_all_equipment_item_details($data);
        }

        
        $data1['req_id'] = base64_decode($this->post['req_id']);
        $data['amb_no'] = $this->post['amb_no'];
        // print_r($data['req_id']);die;
        $data1['ind_item_type'] = 'EQP';


        $data['result'] = $this->ind_model->get_eqp_data($data1);


        $data['clg_group'] = $this->clg->clg_group;

        $data['action'] = $this->post['action'];

        $data['amb_no'] = $this->post['amb_no'];

        $data['radmin'] = ($data['action'] == 'rec' && $data['clg_group'] == 'UG-ADMIN') ? 'radmin' : '';



        if ($this->post['action'] == 'rec') {
            $data['action_type'] = 'Receive Equipment';
        } elseif ($this->post['action'] == 'view') {
            $data['action_type'] = 'View Equipment';
        } elseif ($this->post['action'] == 'apr') {
            $data['action_type'] = 'Approve Equipment';
        } else {
            $data['action_type'] = 'Dispatch Equipment';
        }


        $this->output->add_to_position($this->load->view('frontend/biomedical/view_equipment_details', $data, TRUE), '', TRUE);
    }

    function approve_equip() {

        $req_type = $this->post['req_type'];

        $ind_data = $this->post['eqiup'];



        $args = array(
            'req_id' => $this->post['req_id'],
            'req_is_approve' => '1',
            'req_apr_date_time' => date('Y-m-d H:i:s', strtotime($ind_data['req_apr_date_time'])),
            'req_dispatch_remark' => $ind_data['req_dispatch_remark'],
        );

        $req = $this->ind_model->update_ind_req($args);


        $this->output->status = 1;

        $this->output->closepopup = "yes";

        $this->output->message = "<p>Items Approved Successfully</p>";

        $this->equipment_approve();
    }

    function dispatch_equipment() {



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

                $this->ind_model->update_ind_item($args, $data);


                /////////////////////////////////////////////////////////

                $ind_data = $this->ind_model->get_ind_data($args);


                $args = array(
                    'stk_inv_id' => $ind_data[0]->ind_item_id,
                    'stk_inv_type' => $ind_data[0]->ind_item_type,
                    'stk_handled_by' => $this->clg->clg_ref_id,
                    'stk_in_out' => 'out',
                    'stk_qty' => $qty,
                    'stk_date' => $this->today,
                    'stk_base_month' => $this->post['base_month']
                );


                $this->inv_stock_model->insert_stock($args);
                
            }


            /////////////////////////////////////////////////////////



            $args = array(
                'req_id' => $this->post['ind_req_id'],
                'req_dis_by' => $this->clg->clg_ref_id,
                'req_dis_date' => $this->today,
                'req_dispatch_remark' => $this->post['eqiup']['req_dispatch_remark']
            );

            $req = $this->ind_model->update_ind_req($args);


            /////////////////////////////////////////////////////

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<h3>Dispatch Items</h3><br><p>Items dispatched successfully</p>";

            $this->equipment();
        }
    }

    function receive_equipment() {

        if ($this->post['ind_opt']) {

            $req_type = $this->post['req_type'];

            $args = array(
                'req_id' => $this->post['ind_req_id'],
                'req_rec_by' => $this->clg->clg_ref_id,
                'req_rec_date' => $this->today
            );

            $req = $this->ind_model->update_ind_req($args);
           



            ////////////////////////////////////////////////////

            foreach ($this->post['rec_qty'] as $ind_id => $qty) {

                $args = array(
                    'ind_id' => $ind_id,
                );

                $data = array(
                    'ind_rec_qty' => $qty,
                    'ind_req_id' => $this->post['ind_req_id']
                );



                $this->ind_model->update_ind_item($args, $data);

                /////////////////////////////////////////////////////

                $ind = $this->ind_model->get_ind_data(array('ind_id' => $ind_id));



                /////////////////////////////////////////////////////

                $args = array(
                    'as_item_id' => $ind[0]->ind_item_id,
                    'as_item_type' => $ind[0]->ind_item_type,
                    'as_stk_in_out' => 'in',
                    'as_item_qty' => $qty,
                    'as_sub_id' => $this->post['ind_req_id'],
                    'as_sub_type' => 'ind',
                    'as_date' => $this->today,
                    'amb_rto_register_no' => base64_decode($this->post['amb_no']),
                    'as_base_month' => $this->post['base_month'],
                );

                $this->ind_model->insert_amb_stock($args);
            }

            /////////////////////////////////////////////////////

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<h3>Receive Items</h3><br><p>Items received successfully</p>";

            $this->equipment();
        }
    }

    function equipment_maintaince() {



        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];

        if ($this->post['search1'] != '') {
            $data['search1'] = date('Y-m-d', strtotime($this->post['search1'])) ? date('Y-m-d', strtotime($this->post['search1'])) : date('Y-m-d', strtotime($this->post['search1']));
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

        if ($this->post['search1'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['search1']));
            $data['from_date'] = date('Y-m-d', strtotime($this->post['search1']));
        } else {
            $data['to_date'] = date('Y-m-d');
            $data['from_date'] = date('Y-m-d');
        }




        $args = array(
            'clg_group' => 'UG-DM'
        );

        //$data['clg'] = $this->colleagues_model->get_type_level($args);


        //$data['group_info'] = $this->colleagues_model->get_higher_groups('', $data['clg'][0]->g_type_level);

        $data['req_group'] = 'EQUP';

        $data['total_count'] = $this->biomedical_model->get_all_equipment_maintaince_data($data);


        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $data['per_page'] = $config['per_page'];

        unset($data['get_count']);


        $data['equipment_data'] = $this->biomedical_model->get_all_equipment_maintaince_data($data,$offset,$limit);

        $data['clg_group'] = trim($this->clg->clg_group);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("biomedical/equipment_maintaince"),
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

        $data['page_records'] = count($data['equipment_data']);



        $this->output->add_to_position($this->load->view('frontend/biomedical/bio_medical_equipment_maintaince_list_view', $data, true), $this->post['output_position'], true);
    }

    function add_equipment_maintance() {


        if ($this->post['eq_id'] != '') {

            $data['eq_id'] = $ref_id = base64_decode($this->post['eq_id']);
            $data['equp_data'] = $this->biomedical_model->get_all_equipment_maintaince_data($data, $offset, $limit);
      
        }


        if ($this->post['action_type'] == 'Update') {
            $data['action_type'] = "Update Equipment Maintenance";
            $data['update'] = 'True';
            $data['action'] = 'view';
            $data['req_group'] = 'EQUP';
            $data['type'] = 'Update';
            $data['result'] = $this->ind_model->get_ind_data($data);


            $this->output->add_to_position($this->load->view('frontend/biomedical/equipment_maintaince_register_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Equipment";
            $data['action'] = 'view';
            $data['req_group'] = 'EQUP';
//            $data['result'] = $this->ind_model->get_ind_data($data);

            $this->output->add_to_popup($this->load->view('frontend/biomedical/equipment_maintaince_register_view', $data, TRUE), '1200', '1000');
        }
    }

    function register_equipment_maintaince() {

        $eq_data = $this->post['main'];
        $eq_data['eq_state_code'] = $this->input->post('incient_state');
        $eq_data['eq_district_code'] = $this->input->post('incient_district');
        $eq_data['eq_amb_ref_no'] = $this->input->post('incient_ambulance');
        $eq_data['eq_base_location'] = $this->input->post('base_location');
        $eq_data['eq_added_by'] = $this->clg->clg_ref_id;
       // $eq_data['mt_breakdown_date'] = $this->input->post('breakdown_date');
       // $eq_data['mt_estimatecost'] = $this->input->post('Estimatecost');
        $eq_data['eq_added_date'] = date('Y-m-d H:i:s');
        $eq_data['eq_modify_by'] = $this->clg->clg_ref_id;
        $eq_data['eq_modify_date'] = date('Y-m-d H:i:s');
        $eq_data['eq_is_deleted'] = '0';
        $eq_data['eq_base_month'] = $this->post['base_month'];
        $eq_data['eq_due_date_time'] = date('Y-m-d H:i:s', strtotime($eq_data['eq_due_date_time']));
        $eq_data['eq_equip_name'] = $eq_data['eq_equip_name'];

        if ($this->input->post('other_remark') != '') {
            $eq_data['eq_other_remark'] = $this->input->post('other_remark');
        }


        $register_result = $this->biomedical_model->insert_equipment_maintaince($eq_data);

        if(!empty($_FILES['amb_photo']['name'])){
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                $media_args = array();


                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];

                $_FILES['photo']['name'] = time() .'_'.  $this->sanitize_string($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                            $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                            $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $register_result;
                $media_args['media_data'] = 'equ_maintainance';
                $this->biomedical_model->insert_media_maintance($media_args);
				

            }
        }
        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'> Equipment Maintenance Added Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->equipment_maintaince();
        }
    }

    function update_equipment_maintaince() {


        $equip_data = $this->post['main'];
        $equip_data['eq_modify_by'] = $this->clg->clg_ref_id;
        $equip_data['eq_modify_date'] = date('Y-m-d H:i:s');
        $equip_data['is_updated'] = "1";
        $equip_data['eq_completed_date_time'] = date('Y-m-d H:i:s', strtotime($equip_data['eq_completed_date_time']));

        $result = $this->biomedical_model->equipment_maintaince_update_data($equip_data);


        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Equipment Maintenance Updated Successfully</div>";

            $this->equipment_maintaince();
        }
    }

    function equipment_maintaince_view() {


        $data = array();
        $data['eq_id'] = base64_decode($this->post['eq_id']);
        $data['action_type'] = 'View Equipment Maintenance ';
        $data['equipment_data'] = $this->biomedical_model->get_all_equipment_maintaince_data($data, $offset, $limit);
        $data['action'] = 'view';
        $data['req_group'] = 'EQUP';
        $data['result'] = $this->ind_model->get_ind_data($data);
        //var_dump($data[$data['result']]);die();
        $this->output->add_to_position($this->load->view('frontend/biomedical/equipement_maintaince_view', $data, TRUE), $output_position, TRUE);
    }

    public function equipment_approve() {


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




        $args = array(
            'clg_group' => 'UG-DM'
        );

       // $data['clg'] = $this->colleagues_model->get_type_level($args);


      //  $data['group_info'] = $this->colleagues_model->get_higher_groups('', $data['clg'][0]->g_type_level);

        $data['req_group'] = 'EQUP';

        $data['req_is_approve'] = '0';

        $data['total_count'] = $this->biomedical_model->get_all_equipment_item($data);


        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $data['per_page'] = $config['per_page'];
        $data['cur_page'] = $page_no;

        unset($data['get_count']);


        $data['equipment_data'] = $this->biomedical_model->get_all_equipment_item($data,$offset,$limit);

        $data['clg_group'] = trim($this->clg->clg_group);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("biomedical/equipment_approve"),
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

        $data['page_records'] = count($data['equipment_data']);



        $this->output->add_to_position($this->load->view('frontend/biomedical/equipment_approve_list_view', $data, true), $this->post['output_position'], true);
        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }

    public function equipment_breakdown() {



        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];
        $data['search_status'] = ($this->post['search_status']) ? $this->post['search_status'] : $this->fdata['search_status'];

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

        if ($this->post['search1'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['search1']));
            $data['from_date'] = date('Y-m-d', strtotime($this->post['search1']));
        } else {
           // $data['to_date'] = date('Y-m-d');
           // $data['from_date'] = date('Y-m-d');
        }

                
        $data['total_count'] = $this->biomedical_model->get_break_equipment_maintaince_data($data);


        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $data['per_page'] = $config['per_page'];

        unset($data['get_count']);


        $data['equipment_data'] = $this->biomedical_model->get_break_equipment_maintaince_data($data,$offset,$limit);

        $data['clg_group'] = trim($this->clg->clg_group);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("biomedical/breakdown_equipment"),
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

        $data['page_records'] = count($data['equipment_data']);



        $this->output->add_to_position($this->load->view('frontend/biomedical/breakdown_equipment_maintaince_list_view', $data, true), $this->post['output_position'], true);
    }

    public function add_break_equipment() {

        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = base64_decode($this->post['mt_id']);
            $data['preventive'] = $this->biomedical_model->get_break_equipment_maintaince_data($data);
            $data['equp_data'] = $this->biomedical_model->get_all_equipment_maintaince_data($data, $offset, $limit);
            
            $eq_equip_name = unserialize($data['preventive'][0]->eq_equip_name);
            if(is_array($eq_equip_name)){
                $eqp_type_id = implode("','",$eq_equip_name);
            }else{
                $eqp_type_id = $data['preventive'][0]->eq_equip_name;
            }
            
             $eqp_type =$data['preventive'][0]->eq_equip_name_type;
             
       //var_dump($data['preventive'][0]->eq_equip_name);die;
        }
       
      
        
        $data['eqp'] = $this->eqp_model->get_eqp(array('eqp_type' => $eqp_type));
        $data['eqp_obs'] = $this->eqp_model->get_eqp_break_type(array('eqp_type_id' => $eqp_type_id,'term'=>$term));

    
        
        $equip_id = $data['preventive'][0]->eq_equip_name;
      //  $spare_part = array('type'=>'material');
        $eq = unserialize($equip_id);
        if(is_array($eq)){
            $eq_id = implode("','", $eq);
        }else{
            $eq_id =$equip_id;
        }
       
        $part = array('type'=>$eq_id);
        //$data['invitem'] = $this->biomedical_model->get_sparepart_list($spare_part);
        
        //$part = array('type'=>$equip_id);
        $data['partitem'] = $this->biomedical_model->get_sparepart_list($part);
         
        if ($this->post['action_type'] == 'Update') {
            $data['action_type'] = "Update Breakdown Equipment Maintenance";
            $data['update'] = 'True';
            $data['action'] = 'Update';
            $data['req_group'] = 'EQUP';
            $data['type'] = 'Update';

            $data['amb_rto_register_no'] = base64_decode($this->post['amb_rto_register_no']);
            $data['amb_odometer'] = $this->amb_model->get_amb_staus_summary($data);
            $data['invitem_update'] = $this->biomedical_model->get_sparepart_list();
//            var_dump($data['amb_odometer']);
            $this->output->add_to_popup($this->load->view('frontend/biomedical/eq_break_main_register_view', $data, TRUE), '1200', '1000');
        }elseif ($this->post['action_type'] == 'Approve') {
            $data['action_type'] = "Approve Breakdown Equipment Maintenance";
            $data['Approve'] = 'True';
            $data['action'] = 'Approve';
            $data['req_group'] = 'EQUP';
            $data['type'] = 'Approve';

            $data['amb_rto_register_no'] = base64_decode($this->post['amb_rto_register_no']);
            $data['amb_odometer'] = $this->amb_model->get_amb_staus_summary($data);
//            var_dump($data['amb_odometer']);
            $this->output->add_to_popup($this->load->view('frontend/biomedical/eq_break_main_register_view', $data, TRUE), '1200', '1000');
        }else {

            $data['action_type'] = "Add Breakdown Equipment";
            $data['action'] = 'view';
            $this->output->add_to_popup($this->load->view('frontend/biomedical/eq_break_main_register_view', $data, TRUE), '1200', '1000');
        }
    }
    public function equipment_maintainance_re_request()
    {
        if ($this->post['eq_id'] != '') {

            $data['eq_id'] = $ref_id = base64_decode($this->post['eq_id']);
            $data['equp_data'] = $this->biomedical_model->get_all_equipment_maintaince_data($data, $offset, $limit);
      
        }
        //var_dump($data['eq_id']);die();
        $args =array(
            'mt_id'=>       $data['eq_id'],
            'mt_type'=>      'equi_break_maintanan'
        );
        $data['app_rej_his'] = $this->biomedical_model->get_app_rej_his($args);
        //var_dump($data['app_rej_his']);
        if ($this->post['action_type'] == 'Update') {
            $data['action_type'] = "Update Equipment Maintenance";
            $data['update'] = 'True';
            $data['action'] = 'view';
            $data['req_group'] = 'EQUP';
            $data['type'] = 'Update';
            $data['result'] = $this->ind_model->get_ind_data($data);
            $this->output->add_to_position($this->load->view('frontend/biomedical/equipment_maintaince_register_view', $data, TRUE), $output_position, TRUE);
        }elseif ($this->post['action_type'] == 'Approve') {
            $data['action_type'] = "Approve Equipment Maintenance";
            $data['Approve'] = 'True';
            $data['action'] = 'Approve';
            $data['req_group'] = 'EQUP';
            $data['type'] = 'Approve';
            $data['result'] = $this->ind_model->get_ind_data($data);
            $this->output->add_to_popup($this->load->view('frontend/biomedical/equipment_maintaince_register_view', $data, TRUE), '1200', '600');
        }elseif ($this->post['action_type'] == 'Re_request') {
            $data['action_type'] = "Approve Equipment Maintenance";
            $data['Re_request'] = 'True';
            $data['action'] = 'Re_request';
            $data['req_group'] = 'EQUP';
            $data['type'] = 'Re_request';
            $data['result'] = $this->ind_model->get_ind_data($data);
            $this->output->add_to_popup($this->load->view('frontend/biomedical/equipment_maintaince_register_view', $data, TRUE), '1200', '600');
        } else {
            $data['action_type'] = "Add Equipment";
            $data['action'] = 'view';
            $data['req_group'] = 'EQUP';
            $this->output->add_to_popup($this->load->view('frontend/biomedical/equipment_maintaince_register_view', $data, TRUE), '1200', '600');
        }
    }
    public function equipment_maintainance_approve()
    {
       // $data = array();
        if ($this->post['eq_id'] != '') {

            $data['eq_id'] = $ref_id = base64_decode($this->post['eq_id']);
            $data['equp_data'] = $this->biomedical_model->get_all_equipment_maintaince_data($data, $offset, $limit);
         }
        //var_dump();die();
        $args =array(
            'mt_id'=>       $data['eq_id'],
            'mt_type'=>      'equipment_maintanance'
        );
        $re_request_id = $this->biomedical_model->get_photo_history($args);
        $data['media'] = $this->biomedical_model->get_media_maintance($data);
        $arr =array(
            'mt_id'=>      $this->post['eq_id'],
            'mt_type'=>      'equipment_maintanance',
            're_request_id'=> $this->post['re_request_id']
        );
        $his = $this->biomedical_model->get_history($arr);
        foreach($his as $history){ //var_dump($history);
        $args = array('mt_id' => $this->post['eq_id'], 're_request_id' => $history->re_request_id);
        $history->his_photo[] = $this->biomedical_model->get_history_photo($args);
        $data['his'][] = $history;
        }
        if ($this->post['action_type'] == 'Update') {
            $data['action_type'] = "Update Equipment Maintenance";
            $data['update'] = 'True';
            $data['action'] = 'view';
            $data['req_group'] = 'EQUP';
            $data['type'] = 'Update';
            $data['result'] = $this->ind_model->get_ind_data($data);
            $this->output->add_to_position($this->load->view('frontend/biomedical/equipment_maintaince_register_view', $data, TRUE), $output_position, TRUE);
        }elseif ($this->post['action_type'] == 'Approve') {
            $data['action_type'] = "Approve Equipment Maintenance";
            $data['Approve'] = 'True';
            $data['action'] = 'Approve';
            $data['req_group'] = 'EQUP';
            $data['type'] = 'Approve';
           $data['result'] = $this->ind_model->get_ind_data($data);
           $this->output->add_to_popup($this->load->view('frontend/biomedical/equipment_maintaince_register_view', $data, TRUE), '1200', '600');
        } else {
            $data['action_type'] = "Add Equipment";
            $data['action'] = 'view';
            $data['req_group'] = 'EQUP';
            $this->output->add_to_popup($this->load->view('frontend/biomedical/equipment_maintaince_register_view', $data, TRUE), '1200', '600');
        }
    }
    public function equipment_breakdown_maintainance_rerequest()
    {
        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = base64_decode($this->post['mt_id']);
            $data['preventive'] = $this->biomedical_model->get_break_equipment_maintaince_data($data);
        //var_dump($data['preventive']);die;
        }
        $args =array(
            'mt_id'=>       $this->post['mt_id'],
            'mt_type'=>      'equi_break_maintanan'
        );
        $data['app_rej_his'] = $this->biomedical_model->get_app_rej_his($args);
        if ($this->post['action_type'] == 'Update') {
            $data['action_type'] = "Update Breakdown Equipment Maintenance";
            $data['update'] = 'True';
            $data['action'] = 'Update';
            $data['req_group'] = 'EQUP';
            $data['type'] = 'Update';

            $data['amb_rto_register_no'] = base64_decode($this->post['amb_rto_register_no']);
            $data['amb_odometer'] = $this->amb_model->get_amb_staus_summary($data);
//            var_dump($data['amb_odometer']);
            $this->output->add_to_popup($this->load->view('frontend/biomedical/eq_break_main_register_view', $data, TRUE), '1200', '600');
        }
        elseif ($this->post['action_type'] == 'Approve') {
            $data['action_type'] = "Approve Breakdown Equipment Maintenance";
            $data['Approve'] = 'True';
            $data['action'] = 'Approve';
            $data['req_group'] = 'EQUP';
            $data['type'] = 'Approve';

            $data['amb_rto_register_no'] = base64_decode($this->post['amb_rto_register_no']);
            $data['amb_odometer'] = $this->amb_model->get_amb_staus_summary($data);
         // var_dump($data['amb_rto_register_no']);
            $this->output->add_to_popup($this->load->view('frontend/biomedical/eq_break_main_register_view', $data, TRUE), '1200', '600');
        } elseif ($this->post['action_type'] == 'Re_request') {
            $data['action_type'] = "Re-Request Breakdown Equipment Maintenance";
            $data['Re_request'] = 'True';
            $data['action'] = 'Re_request';
            $data['req_group'] = 'EQUP';
            $data['type'] = 'Re_request';

            $data['amb_rto_register_no'] = base64_decode($this->post['amb_rto_register_no']);
            $data['amb_odometer'] = $this->amb_model->get_amb_staus_summary($data);
         // var_dump($data['amb_rto_register_no']);
            $this->output->add_to_popup($this->load->view('frontend/biomedical/eq_break_main_register_view', $data, TRUE), '1200', '600');
        }else {

            $data['action_type'] = "Add Breakdown Equipment";
            $data['action'] = 'view';
            $this->output->add_to_popup($this->load->view('frontend/biomedical/eq_break_main_register_view', $data, TRUE), '1200', '600');
        }
    }


    public function equipment_breakdown_maintainance_approve(){
        if ($this->post['mt_id'] != '') {

            $data['mt_id'] = $ref_id = base64_decode($this->post['mt_id']);
            $data['preventive'] = $this->biomedical_model->get_break_equipment_maintaince_data($data);
            $data['equp_data'] = $this->biomedical_model->get_all_equipment_maintaince_data($data, $offset, $limit);
             $data['eqp'] = $this->eqp_model->get_eqp(array('eqp_type' =>  $data['preventive'][0]->type_id));
             
            $eq_equip_name = unserialize($data['preventive'][0]->eq_equip_name);
            if(is_array($eq_equip_name)){
                $eqp_type_id = implode("','",$eq_equip_name);
            }else{
                $eqp_type_id = $data['preventive'][0]->eq_equip_name;
            }
           
             $data['eqp_obs'] = $this->eqp_model->get_eqp_break_type();
        }
        $args =array(
            'mt_id'=>       base64_decode($this->post['mt_id']),
            'mt_type'=>      'equipment_break_maintanance'
        );
        $re_request_id = $this->biomedical_model->get_photo_history($args);
        $data['media'] = $this->biomedical_model->get_media_maintance($data);
        $arr =array(
            'mt_id'=>      base64_decode($this->post['mt_id']),
            'mt_type'=>      $data['mt_type'],
            're_request_id'=> $this->post['re_request_id']
        );
        $his = $this->biomedical_model->get_history($arr);
        foreach($his as $history){ //var_dump($history);
        $args = array('mt_id' => base64_decode($this->post['mt_id']), 're_request_id' => $history->re_request_id);
        $history->his_photo[] = $this->biomedical_model->get_history_photo($args);
        $data['his'][] = $history;
        }
       if ($this->post['action_type'] == 'Update') {
            $data['action_type'] = "Update Breakdown Equipment Maintenance";
            $data['update'] = 'True';
            $data['action'] = 'Update';
            $data['req_group'] = 'EQUP';
            $data['type'] = 'Update';

            $data['amb_rto_register_no'] = base64_decode($this->post['amb_rto_register_no']);
            $data['amb_odometer'] = $this->amb_model->get_amb_staus_summary($data);
            $this->output->add_to_popup($this->load->view('frontend/biomedical/eq_break_main_register_view', $data, TRUE), '1200', '1000');
        }
        elseif ($this->post['action_type'] == 'Approve') {
            $data['action_type'] = "Approve Breakdown Equipment Maintenance";
            $data['Approve'] = 'True';
            $data['action'] = 'Approve';
            $data['req_group'] = 'EQUP';
            $data['type'] = 'Approve';

            $data['amb_rto_register_no'] = base64_decode($this->post['amb_rto_register_no']);
           //$data['amb_odometer'] = $this->amb_model->get_amb_staus_summary($data);
            $this->output->add_to_popup($this->load->view('frontend/biomedical/eq_break_main_register_view', $data, TRUE), '1200', '1000');
        } else {

            $data['action_type'] = "Add Breakdown Equipment";
            $data['action'] = 'view';
            $this->output->add_to_popup($this->load->view('frontend/biomedical/eq_break_main_register_view', $data, TRUE), '1200', '1000');
        }
    }

    public function change_status() {

        $amb_details = $this->input->post();
        $amb_id = $amb_details['amb_reg_no'];
        $args = array(
            'rg_no' => $amb_id,
        );
        $data['status'] = $amb_details['status'];
        $data['amb_id'] = $amb_id;
        $data['get_amb_details'] = $this->amb_model->get_amb_data($args);

        $this->output->add_to_position($this->load->view('frontend/amb/update_bio_amb_status', $data, TRUE), 'change_maintance_status', TRUE);
        //$this->output->add_to_popup($this->load->view('frontend/amb/update_amb_status', $data, TRUE), '600', '560');
    }

    function breakdown_equip_save() {
        if ($this->post['eq_id'] != '') {

            $data['eq_id'] = $ref_id = base64_decode($this->post['eq_id']);
            
            $data['equp_data'] = $this->biomedical_model->get_all_equipment_maintaince_data($data, $offset, $limit);
        }

        $maintaince_data = $this->post['breakdown'];
        $maintaince = $this->input->post();
        $amb_details = $this->input->post();
                
        $amb_id = base64_decode($amb_details['amb_id']);
        //var_dump($this->input->post('maintaince_ambulance'));die();
     $main_data = array('mt_state_id' => $this->input->post('maintaince_state'),
            'mt_district_id' => $this->input->post('maintaince_district'),
            'mt_amb_no' => $this->input->post('maintaince_ambulance'),
            'mt_base_loc' => $this->input->post('base_location'),
            'amb_type' => $this->input->post('amb_type'),
            'ambt_make' => $this->input->post('ambt_make'),
            'amb_model' => $this->input->post('ambt_model'),
            'added_by' => $this->clg->clg_ref_id,
            'added_date' => date('Y-m-d H:i:s'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_isdeleted' => '0',
            'is_amb_offroad' => $this->input->post('breakdown[is_amb_offroad]'),
            'mt_breakdown_date' => $amb_details['breakdown_date'],
            'mt_estimatecost' => $amb_details['Estimatecost'],
            'mt_type' => 'breakdown',
            'eq_equip_name' => $this->input->post('main[eq_equip_name]'),
            'mt_base_month' => $this->post['base_month'],
            'mt_pilot_name'=> $this->input->post('pilot_name'),
            'mt_pilot_id'=>$this->input->post('mt_pilot_id'),
            'mt_emt_name'=> $this->input->post('emt_name'),
            'mt_emt_id'=>$this->input->post('mt_emt_id'),
           // 'mt_stnd_remark'=>$this->input->post('breakdown[mt_stnd_remark]'),
          //  'mt_off_stnd_remark'=> $amb_details['remark'],
            'mt_remark'=>$this->input->post('breakdown[mt_remark]'),
            'mt_ambulance_status' => 'Pending Approval');
         //  var_dump($main_data);die();
    
        if ($maintaince_data['mt_breakdown_type'] != '') {
            $main_data['mt_breakdown_type'] = serialize($maintaince_data['mt_breakdown_type']);
        }
    
        if($amb_details['remark'] != ''){
            $main_data['mt_off_stnd_remark'] = $amb_details['remark'];
        }
     
        if($main_data['is_amb_offroad'] == 'no'){

            $main_data['mt_approval'] = '1';
            $main_data['mt_ambulance_status'] = 'Available';
        }else{
             $main_data['mt_ambulance_status'] = 'Pending Approval';
        }
         if($this->input->post('start_odmeter') != ''){
            $main_data['mt_in_odometer'] = $this->input->post('start_odmeter');
        }
       
           
     
        if ($amb_details['previous_breakdown_odmeter'] != '') {
            $main_data['mt_previous_breakdown_odmeter'] = $amb_details['previous_breakdown_odmeter'];
        }
        
        if ($amb_details['start_odmeter'] != '') {
            $main_data['mt_in_odometer'] = $amb_details['start_odmeter'];
        }

        if ($amb_details['previous_odmeter'] != '') {
            $main_data['mt_previos_odometer'] = $this->input->post('previous_odmeter');
        }
        if ($amb_details['other_offroad_standard_remark'] != '') {
            $main_data['other_offroad_standard_remark'] = $this->input->post('other_offroad_standard_remark');
        }
        
         if ($amb_details['common_remark_other'] != '') {
            $main_data['common_remark_other'] = $this->input->post('common_remark_other');
        }
   
        $args = array_merge($this->post['breakdown'], $main_data);
          
        
         
        $prev= generate_maintaince_id('ems_equipment_break');
        $prev_id = "MHEMS-EBM-".$prev;
        $args['mt_ref_id']=$prev_id;
            
        $register_result = $this->biomedical_model->insert_equipment_break_maintance($args);
      
        $is_amb_offroad=$this->input->post('breakdown[is_amb_offroad]');
        if($is_amb_offroad=='yes')
        {
            //$total_km = '';
            //if ($amb_details['previous_odmeter'] < $amb_details['start_odmeter']) {
                $total_km = $amb_details['previous_odmeter'] - $amb_details['start_odmeter'];
          //  }

            

                $amb_details['previous_odmeter'] = $amb_details['start_odmeter'];

                $amb_update_summary = array(
                    'amb_rto_register_no' => $amb_details['amb_reg_no'],
                    'amb_status' => 1,
                    'start_odometer' => $amb_details['start_odmeter'],
                    'off_road_status' => "Pending for Approval",
                    'off_road_remark' => $amb_details['remark'],
                    'common_other_remark_all' => $amb_details['common_remark_other'],
                    'off_road_date' => date('Y-m-d', strtotime($maintaince_data['mt_offroad_datetime'])),
                    'off_road_time' => date('H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
                    'added_date' => date('Y-m-d H:i:s'));

                if (!empty($amb_details['remark_other'])) {
                    $amb_update_summary['off_road_remark_other'] = $amb_details['remark_other'];
                }

                $add_summary = $this->amb_model->insert_amb_staus_summary($amb_update_summary);
                $amb_record_data = array(
                    'amb_rto_register_no' => $amb_details['amb_reg_no'],
                    'start_odmeter' => $amb_details['start_odmeter'],
                    'end_odmeter' => $amb_details['end_odmeter'],
                    'total_km' => $total_km,
                    'remark' => $amb_details['remark'],
                    'odometer_type'       => 'Equipment Breakdown maintenance off road',
                    'odometer_date' => date('Y-m-d', strtotime($maintaince_data['mt_offroad_datetime'])),
                    'odometer_time' => date('H:i:s', strtotime($maintaince_data['mt_offroad_datetime'])),
                    'timestamp' => date('Y-m-d H:i:s'));
    
//                if ($amb_details['amb_status'] == '13') {
//                    $amb_record_data['start_odmeter'] = $amb_details['start_odmeter'];
//                    $amb_record_data['end_odmeter'] = $amb_details['start_odmeter'];
//                }
                if ($amb_details['amb_status'] == '13') {
                    $amb_record_data['start_odmeter'] = $amb_details['previous_odmeter'];
                    $amb_record_data['end_odmeter'] = $amb_details['start_odmeter'];
                }
    
                if (!empty($amb_details['remark_other'])) {
                    $amb_record_data['other_remark'] = $amb_details['remark_other'];
                }
            
                $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
        }
        

        if(!empty($_FILES['amb_photo']['name'])){
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];
                $_FILES['photo']['name'] = time() .'_'.  $this->sanitize_string($_FILES['photo']['name']);
               $rsm_config = $this->amb_pic;
               $this->upload->initialize($rsm_config);
               if (!$this->upload->do_upload('photo')) {
                $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                $upload_err = TRUE;
                 }
                 $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $register_result;
                $media_args['media_data'] = 'biomedical_breakdown';
                $this->biomedical_model->insert_media_maintance($media_args);
                
                // echo "hi";
            }
            }


        $amb_data = array('amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1);
        if ($register_result) {

            //$update = $this->amb_model->update_amb($amb_data);
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Breakdown Equipment Maintenance Registered Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->equipment_breakdown();
        }
    }
    
    function sanitize_string( $string, $sep = '-' ){
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9 -_\.]+/', '', $string);
        $string = trim($string);
        $string = str_replace(' ', $sep, $string);
        return trim($string, '-_');
    }
    function breakdown_equip_view() {


        $data = array();
   

        $data['action_type'] = 'View Breakdown Equipment';

        $data['mt_id'] = $ref_id = base64_decode($this->post['mt_id']);
        $data['preventive'] = $this->biomedical_model->get_break_equipment_maintaince_data($data);
        
         $data['eqp_obs'] = $this->eqp_model->get_eqp_break_type();
         $data['eqp'] = $this->eqp_model->get_eqp();
       
        //var_dump($data['preventive']);die;
        $this->output->add_to_popup($this->load->view('frontend/biomedical/breakdown_maintaince_view', $data, TRUE), '1200', '500');
    }
    function update_re_request_equipment_maintaince()
    {
     //var_dump("hii");die();
      $equip_data = $this->post['main'];
      //var_dump($this->input->post('main[eq_id]'));die();
       $app_data = array(
           'mt_id' => $this->input->post('main[eq_id]'),
           're_request_remark' => $this->input->post('app[re_request_remark]'),
           're_mt_type' => 'equipment_maintanance',
           're_requestby' => $this->clg->clg_ref_id,
           're_request_date' => date('Y-m-d H:i:s')
       );
       $register_result = $this->biomedical_model->re_request_breakdown_equipment_maintance($app_data);
       if(!empty($_FILES['amb_photo']['name'])){
            
        foreach ($_FILES['amb_photo']['name'] as $key => $image) {
            $media_args = array();
            $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
            $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
            $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
            $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
            $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];
            $_FILES['photo']['name'] = time() .'_'.  $this->sanitize_string($_FILES['photo']['name']);
           //var_dump($_FILES['amb_photo']['name']);
            //die();

            $rsm_config = $this->amb_pic;
            $this->upload->initialize($rsm_config);

            if (!$this->upload->do_upload('photo')) {
                        $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                        $upload_err = TRUE;
            }
           $media_args['re_request_id'] =$register_result;
            $media_args['media_name'] = $_FILES['photo']['name'];
            $media_args['user_id'] = $this->input->post('main[eq_id]');
            $media_args['media_data'] = 'equipment_maintanance';
            $this->biomedical_model->insert_media_maintance($media_args);

        }
    }
       
       if ($register_result) {

        $this->output->status = 1;

        $this->output->closepopup = 'yes';

        $this->output->message = "<div class='success'>Equipment Maintenance Updated Successfully</div>";

        $this->equipment_maintaince();
        }

    }
   function update_approve_equipment_maintaince()
    {
        //var_dump($this->input->post('app[eq_id]')); die();
        $equip_data = $this->post['main'];
        $app_data = array(
            'eq_id' => $this->input->post('app[eq_id]'),
            'eq_approval' => $this->input->post('app[mt_approval]'),
            'eq_app_onroad_datetime' => $this->input->post('app[mt_app_onroad_datetime]'),
            'eq_app_remark' => $this->input->post('app[mt_app_remark]'),
            'eq_app_est_amt' => $this->input->post('app[mt_app_est_amt]'),
           // 'eq_app_rep_time' => $this->input->post('app[mt_app_rep_time]'),
            'approved_by' => $this->clg->clg_ref_id,
            //'modify_by' => $this->clg->clg_ref_id,
            //'modify_date' => date('Y-m-d H:i:s'),
            'approved_date' =>date('Y-m-d H:i:s')
        );
        //var_dump($app_data);die();
        $register_result = $this->biomedical_model->update_equ_maintance($app_data);
       // var_dump($register_result);die();
       $history_data = array(
        're_id' => $app_data['re_id'],
        're_mt_id' =>  $this->input->post('app[eq_id]'),
        're_approval_status' => $this->input->post('app[mt_approval]'),
        're_app_onroad_datetime' => date('Y-m-d H:i:s', strtotime($this->input->post('app[mt_app_onroad_datetime]'))),
        're_remark' => $this->input->post('app[mt_app_remark]'),
        're_rejected_by' => $this->clg->clg_ref_id,
        're_mt_type' => 'equi_break_maintanance',
        're_rejected_date' => date('Y-m-d H:i:s')
    );
    $history_data_detail = $this->biomedical_model->insert_qui_break_maintaince_history($history_data);
    
    
        if ($register_result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Equipment Maintenance Updated Successfully</div>";

            $this->equipment_maintaince();
        }
    } 
    function breakdown_equip_re_request(){
       
        $app_data = $this->post['breakdown'];
       //var_dump($app_data);die();
        $app_data = array(
            //'re_request_id' = > $app_data['re_request_id'],
            'mt_id' => $this->input->post('app[mt_id]'),
            're_request_remark' => $this->input->post('app[re_request_remark]'),
            're_mt_type' => 'equipment_break_maintanance',
            're_requestby' => $this->clg->clg_ref_id,
            're_request_date' => date('Y-m-d H:i:s')
        );
        $register_result = $this->biomedical_model->re_request_breakdown_equipment_maintance($app_data);
        if(!empty($_FILES['amb_photo']['name'])){
            
            foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                $media_args = array();
                $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];
                $_FILES['photo']['name'] = time() .'_'.  $this->sanitize_string($_FILES['photo']['name']);
               //var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                            $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                            $upload_err = TRUE;
                }
               $media_args['re_request_id'] =$register_result;
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $app_data['mt_id'];
                $media_args['media_data'] = 'equipment_break_maintanance';
                $this->biomedical_model->insert_media_maintance($media_args);

            }
        }
        if ($register_result) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Equipment Breakdown maintenance Updated Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->equipment_breakdown();
        }
    }
    function breakdown_equip_approve() {
        $app_data = $this->post['breakdown'];
        $approval=$this->input->post('app[mt_approval]');
        $amb_details = $this->input->post();
        
        if($approval == "1")
        {
            $approval_status = 'In Maintenance-OFF Road';
            $Approved_by = $this->clg->clg_ref_id;
            $approved_date = date('Y-m-d H:i:s');
            $onroaddate = date('Y-m-d H:i:s', strtotime($app_data['mt_app_onroad_datetime']));
        }else if($approval=="0"){
            $approval_status = 'Pending Approval';
        }
             $app_data = array(
            'mt_id' => $this->input->post('app[mt_id]'),
            'mt_approval' => $this->input->post('app[mt_approval]'),
            'mt_app_onroad_datetime' => $this->input->post('mt_app_onroad_datetime'),
            'mt_app_remark' => $this->input->post('app[mt_app_remark]'),
            'mt_app_est_amt' => $this->input->post('app[mt_app_est_amt]'),
            'mt_app_rep_time' => $this->input->post('app[mt_app_rep_time]'),
            'mt_ambulance_status' => $approval_status,
            'approved_by' => $this->clg->clg_ref_id,
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'approved_date' =>date('Y-m-d H:i:s')
        );
        $register_result = $this->biomedical_model->update_equ_breakdown_maintance($app_data);
        $history_data = array(
            're_id' => $app_data['re_id'],
            're_mt_id' =>  $this->input->post('app[mt_id]'),
            're_approval_status' => $this->input->post('app[mt_approval]'),
            're_app_onroad_datetime' => date('Y-m-d H:i:s', strtotime($this->input->post('app[mt_app_onroad_datetime]'))),
            're_remark' => $this->input->post('app[mt_app_remark]'),
            're_rejected_by' => $this->clg->clg_ref_id,
            're_mt_type' => 'equi_break_maintanance',
            're_rejected_date' => date('Y-m-d H:i:s')
        );
        $history_data_detail = $this->biomedical_model->insert_qui_break_maintaince_history($history_data);
        
        if($approval=="1") {
        $amb_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => '7',
            'off_road_status' => "Equipment Breakdown maintenance off road",
            //'on_road_status' => "Equipment Breakdown maintenance on road",
            'on_road_remark' => $this->input->post('app[mt_app_remark]'),
            'common_other_remark_all' => $this->input->post('app[mt_app_remark]'),
            'on_road_date' => date('Y-m-d', strtotime($amb_details['odometer_date'])),
            'on_road_time' => date('H:i:s', strtotime($amb_details['odometer_time'])),
            'modify_date' => date('Y-m-d H:i:s'));
            //var_dump($amb_summary);die();
        if (!empty($amb_details['remark_other'])) {
            $amb_summary['on_road_remark_other'] = $amb_details['remark_other'];
        }
        $off_road_status = "Pending for Approval";
        $add_summary = $this->amb_model->update_ambulance_staus_summary($amb_summary, $off_road_status);
        
        $amb_data = array(
                'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
                'amb_status' => '13',
            );
        $update = $this->amb_model->update_amb($amb_data);
       
    }
/*
        $amb_record_data = array(
            'amb_rto_register_no' => $amb_details['amb_reg_no'],
            'start_odmeter' => $amb_details['previous_odmeter'],
            'end_odmeter' => $amb_details['end_odmeter'],
            'total_km' => $total_km,
            'remark' => $amb_details['remark'],
            
            'odometer_date' => date('Y-m-d', strtotime($amb_details['odometer_date'])),
            'odometer_time' => date('H:i:s', strtotime($amb_details['odometer_time'])),
            'timestamp' => date('Y-m-d H:i:s'));

        if ($amb_details['amb_status'] == '6') {
            $amb_record_data['start_odmeter'] = $amb_details['start_odmeter'];
            $amb_record_data['end_odmeter'] = $amb_details['start_odmeter'];
        }
        if ($amb_details['amb_status'] == '7') {
            $amb_record_data['start_odmeter'] = $amb_details['previous_odmeter'];
            $amb_record_data['end_odmeter'] = $amb_details['end_odmeter'];
        }

        if (!empty($amb_details['remark_other'])) {
            $amb_record_data['other_remark'] = $amb_details['remark_other'];
        }
        $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
        } */
        if ($register_result) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Equipment Breakdown maintenance Updated Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->equipment_breakdown();
        }

    }
       function breakdown_equip_update() {

        $maintaince_data = $this->post['breakdown'];
        $unit_data = $this->post['unit'];
        $part_data = $this->post['unit_hq'];
//        $part_data = $this->post['part'];
//        var_dump($unit_data);
//           var_dump($part_data);
//        die();
       

        $main_data = array(
            //'mt_end_odometer' => $this->input->post('mt_end_odometer'),
            'mt_onroad_datetime' => date('Y-m-d H:i:s', strtotime($maintaince_data['mt_onroad_datetime'])),
            'mt_isupdated' => '1',
           // 'eq_equip_name'=>$this->input->post('main[eq_equip_name]'),
            'modify_by' => $this->clg->clg_ref_id,
            'modify_date' => date('Y-m-d H:i:s'),
            'mt_ambulance_status' => 'Available');
         if($maintaince_data['mt_complaint_current_status'] == '28'){
            $main_data['mt_isupdated'] = '1';
        }else{
              $main_data['mt_isupdated'] = '0';
        }
        
        if($this->input->post('mt_end_odometer') != ''){
         $main_data['mt_end_odometer '] = $this->input->post('mt_end_odometer');
     }

        $args = array_merge($this->post['breakdown'], $main_data);

        

        $register_result = $this->biomedical_model->update_ambulance_maintance($args);

      

        $total_km = (int)$this->input->post('mt_end_odometer') - (int)$this->input->post('previos_odometer');

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previos_odometer'),
            'end_odmeter' => $this->input->post('mt_end_odometer'),
            'total_km' => $total_km,
            'remark' => $maintaince_data['mt_on_stnd_remark'],
            'odometer_type' => "Equipment Breakdown maintenance on road",
            'timestamp' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_off_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_off_remark'];
        }

        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => '13,1',
            'end_odometer' => $this->input->post('mt_end_odometer'),
            'on_road_status' => "Equipment Breakdown maintenance on road",
            'on_road_remark' => $maintaince_data['mt_on_stnd_remark'],
            'on_road_date' => date('Y-m-d', strtotime($maintaince_data['mt_onroad_datetime'])),
            'on_road_time' => date('H:i:s', strtotime($maintaince_data['mt_onroad_datetime'])),
            'added_date' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_on_remark'])) {
            $amb_update_summary['on_road_remark_other'] = $maintaince_data['mt_on_remark'];
        }

        $data = array('amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1);

        $off_road_status = "Equipment Breakdown maintenance off road";
        $add_summary = $this->amb_model->update_ambulance_staus_summary($amb_update_summary, $off_road_status);
        
        if($maintaince_data['is_amb_offroad'] == 'yes'){
         
            $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
              //$update = $this->amb_model->update_amb($data);
        }
        
        if (isset($unit_data)) {
            foreach ($unit_data as $unit) {
                if ($unit['value'] != '') {
                    $unit_args = array(
                        'spare_part_name' => $unit['id'],
                        'spare_part_quintity' => $unit['value'],
                        'break_eqp_id' => $maintaince_data['mt_id'],
                    );

                    $this->biomedical_model->insert_spare_part($unit_args);
                }
            }
        }
        
        if (isset($part_data)) {
            foreach ($part_data as $part) {
                if ($part['value'] != '') {
                    $part_args = array(
                        'spare_part_name' => $part['id'],
                        'spare_part_quintity' => $part['value'],
                        'break_eqp_id' => $maintaince_data['mt_id'],
                    );

                    $this->biomedical_model->insert_spare_part($part_args);
                }
            }
        }
        //$record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
        if(!empty($_FILES['pmc_snap_shot']['name'])){
            foreach ($_FILES['pmc_snap_shot']['name'] as $key => $image) {
                $media_args = array();
                $_FILES['photo']['name']= $_FILES['pmc_snap_shot']['name'][$key];
                $_FILES['photo']['type']= $_FILES['pmc_snap_shot']['type'][$key];
                $_FILES['photo']['tmp_name']= $_FILES['pmc_snap_shot']['tmp_name'][$key];
                $_FILES['photo']['error']= $_FILES['pmc_snap_shot']['error'][$key];
                $_FILES['photo']['size']= $_FILES['pmc_snap_shot']['size'][$key];

                $_FILES['photo']['name'] = time() .'_'.  $this->sanitize_string($_FILES['photo']['name']);
               // var_dump($_FILES['amb_photo']['name']);
                //die();

                $rsm_config = $this->amb_pic;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                            $this->output->message = "<div class='error'>Photo type is invalid .. Please upload again..!</div>";
                            $upload_err = TRUE;
                }
                $media_args['media_name'] = $_FILES['photo']['name'];
                $media_args['user_id'] = $register_result;
                $media_args['media_data'] = 'equ_main_up_pmc_snap_shot';
                $this->biomedical_model->insert_media_maintance($media_args);
				

            }
        }
        

      

        if ($register_result) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Equipment Breakdown maintenance Updated Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->equipment_breakdown();
        }
    }
    function show_equipments_by_type(){
        
        $data['id'] = $this->post['id'];
          $eqp_type = $data['id'] ;
       $data['eqp'] = $this->eqp_model->get_eqp(array('eqp_type' => $eqp_type));
       
           $data['eqp_obs'] = $this->eqp_model->get_eqp_break_type(array('eqp_type' => $eqp_type));
        
        $this->output->add_to_position($this->load->view('frontend/biomedical/show_equipments_by_type_view', $data, true), 'show_equipments_by_type', true);
        
        $this->output->add_to_position($this->load->view('frontend/biomedical/show_equipments_break_type_view', $data, true), 'show_breakdown_type', true);
    }
    
    function equipments_by_type(){
        
        $data['id'] = explode('_', $this->post['id']);
        if($data['id'][0]==''){
            unset($data['id'][0]);
        }
 
        $eqp_type = $data['id'][0];
   

        $data['eqp_obs'] = $this->eqp_model->get_eqp_break_type(array('eqp_type_id' => $eqp_type,'term'=>$term));

        
        $this->output->add_to_position($this->load->view('frontend/biomedical/show_equipments_break_type_view', $data, true), 'show_breakdown_type', true);
    }
    
    function show_spare_part_list() {

        $epcr_info = $this->input->post();
 

        $na_con_data = array();
        $cons_data = array();

        if (isset($epcr_info['unit'])) {
            foreach ($epcr_info['unit'] as $key => $unit) {

                if ($unit['value'] != '') {

                        $cons_data[$key] = array('inv_id' => $unit['id'],
                            'inv_title' => $unit['title'],
                             'inv_qty' => $unit['value'],
                              'type'=>'material',
                            'inv_type' => $unit['type']);
                }
            }
        }



        $data['cons_data'] = $cons_data;

        $this->output->add_to_position($this->load->view('frontend/biomedical/spare_part_list_view', $data, TRUE), 'show_selected_unit_item_ca', TRUE);
    }
        function show_part_list() {

        $epcr_info = $this->input->post();
 

        $na_con_data = array();
        $cons_data = array();

        if (isset($epcr_info['part'])) {
            foreach ($epcr_info['part'] as $key => $unit) {

                if ($unit['value'] != '') {

                        $cons_data[$key] = array('inv_id' => $unit['id'],
                            'inv_title' => $unit['title'],
                             'inv_qty' => $unit['value'],
                            'type'=>'part',
                            'inv_type' => $unit['type']);
                }
            }
        }



        $data['cons_data'] = $cons_data;

        $this->output->add_to_position($this->load->view('frontend/biomedical/spare_part_list_view', $data, TRUE), 'show_selected_unit_item', TRUE);
    }
        function equip_name_wise_details(){
        
        $equip_id = $this->post['equip_id'];
        $output_position = $this->post['output_position'];
        $data['equp_data'] = $this->eqp_model->get_eqp(array('eqp_id' => $equip_id));

       
        $this->output->add_to_position($this->load->view('frontend/biomedical/equip_name_wise_details_view', $data, true), $output_position, true);
        
    }
    function view_eqp_audit_details(){
        $equip_id = base64_decode($this->post['req_id']);
        $data= array('req_id'=>$equip_id);
        $data['eqp_audit'] = $this->biomedical_model->get_equipment_audit($data);
        $data['equp_data'] = $this->biomedical_model->get_equipment_audit_item($data);
        $this->output->add_to_popup($this->load->view('frontend/biomedical/view_equipment_audit_view', $data, TRUE), '1200', '800');

    }
    function equipment_audit() {



        ///////////////  Filters //////////////////

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
        
        $district_id = "";
if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        $data['amb_district'] = $district_id;

        $data['total_count'] = $this->biomedical_model->get_equipment_audit($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

//        $clgflt['CLG'] = $data;
//        $this->session->set_userdata('filters', $clgflt);
        ///////////////////////////////////

        unset($data['get_count']);



        $data['equipment_data'] = $this->biomedical_model->get_equipment_audit($data, $offset, $limit);
        //var_dump($data['equipment_data']);
       

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("biomedical/equipment_audit"),
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

        $data['page_records'] = count($data['equipment_data']);


        $this->output->add_to_position($this->load->view('frontend/biomedical/equipment_audit_list_view', $data, true),'content', true);

       // $this->output->add_to_position($this->load->view('frontend/biomedical/equipment_audit_filter_view', $data, TRUE), 'clg_filters', TRUE);
    }
     function add_equipment_audit(){
        
        $equip_id = $this->post['equip_id'];
        $output_position = $this->post['output_position'];
      

        $this->output->add_to_popup($this->load->view('frontend/biomedical/add_equipment_audit_view', $data, TRUE), '1200', '800');
        
    }
    function save_equipment_audit(){
        $post_data = $this->input->post();
        $audit_info = $this->input->post('audit');
        
        
        $audit_data = array('state_id'=>$post_data['incient_state'], 
            'district_id'=>$post_data['incient_district'],
            'ambulance_no'=>$post_data['incient_ambulance'],
            'base_location'=>$post_data['base_location'],
            'ambulance_type'=>$post_data['amb_type'],
            'aom'=>$post_data['aom'],
            'emt_id'=>$post_data['mt_emt_id'],
            'emt_name'=>$post_data['emt_name'],
            'pilot_id'=>$post_data['mt_pilot_id'],
            'pilot_name'=>$post_data['pilot_name'],
            'previous_audit_date'=>$post_data['previous_audit_date'],
            'current_audit_date'=>$post_data['current_audit_date'],
        );
        $audit_data['added_by '] = $this->clg->clg_ref_id;
        $audit_data['added_date'] = date('Y-m-d H:i:s');
        $audit_data['is_deleted'] = '0';
        $audit_data['base_month'] = $this->post['base_month'];

        $register_result = $this->biomedical_model->insert_equipment_audit($audit_data);
         
        foreach ($audit_info as $audit) {
             //var_dump($audit_info);
            $audit_data = array('item_name'=>$audit['item_name'], 
                'availability'=>$audit['availability'],
                'working_status'=>$audit['working_status'],
                'damage_broken'=>$audit['damage_broken'],
                'not_working_reason'=>$audit['not_working_reason'],
                'damage_reason'=>$audit['damage_reason'],
                'other_remark'=>$audit['other_remark'],
                'equipment_audit_id'=>$register_result
                );
          
            $register_result_item = $this->biomedical_model->insert_equipment_audit_item($audit_data);
          
               
        }
        
         if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Equipment Audit registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->equipment_audit();
        }
        
    }
    
    function show_problem_observed() {

        $epcr_info = $this->input->post('breakdown');

        $na_con_data = array();
        $cons_data = array();
  
        if (isset($epcr_info['mt_breakdown_type'])) {
            foreach ($epcr_info['mt_breakdown_type'] as $key => $unit) {

              
                if ($unit['id'] != '') {
                      
                        $cons_data[$key] = array('inv_id' => $unit['id']);

                        $invitem = $this->eqp_model->get_eqp_break_type(array('eb_type_id' =>$unit['id']));

                        $cons_data[$key]['inv_title'] = $invitem[0]->eb_name;
                    
                }
            }
        }

        $data['cons_data'] = $cons_data;

        $this->output->add_to_position($this->load->view('frontend/biomedical/show_problem_observed_view', $data, TRUE), 'show_selected_unit_item', TRUE);
    }


    #################### Tyre ##################

    public function tyre() {


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
            //$data['from_date'] = date('Y-m-d', strtotime($this->post['search1']));
        } else {
            //$data['to_date'] = date('Y-m-d');
        }




        $args = array(
            'clg_group' => 'UG-DM'
        );

        //$data['clg'] = $this->colleagues_model->get_type_level($args);


        //$data['group_info'] = $this->colleagues_model->get_higher_groups('', $data['clg'][0]->g_type_level);

        $data['req_group'] = 'EQUP';

        $data['total_count'] = $this->biomedical_model->get_all_tyre_item($data);


        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $data['per_page'] = $config['per_page'];

        unset($data['get_count']);


        $data['equipment_data'] = $this->biomedical_model->get_all_tyre_item($data,$offset,$limit);

       // $data['clg_group'] = trim($this->clg->clg_group);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("biomedical/equipment"),
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

        //$data['page_records'] = count($data['equipment_data']);



        $this->output->add_to_position($this->load->view('frontend/biomedical/bio_medical_tyre_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }


    

    function add_tyre() {

        if ($this->post['f_id'] != '') {

            $data['f_id'] = $ref_id = base64_decode($this->post['f_id']);
            $data['fuel_station'] = $this->fleet_model->get_all_fuel_station($data, $offset, $limit);
        }


        if ($this->post['action_type'] == 'Update') {
            $data['action_type'] = "Update Fuel Station";
            $data['update'] = 'True';

            $this->output->add_to_position($this->load->view('frontend/fleet/register_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Tyre";

            $this->output->add_to_popup($this->load->view('frontend/biomedical/bio_medical_tyre_register_view', $data, TRUE), '1200', '1000');
        }
    }

    function send_tyre_request() {


        $item_key = array('EQP');

        ////////////////////////////////////////////////

        $eflag = "Yes";

        foreach ($item_key as $key) {
            if (is_array($this->post['item'][$key])) {
                foreach ($this->post['item'][$key] as $item) {

                    if ($item['id'] != '') {
                        $eflag = "No";
                    }
                }
            }
        }

        if ($eflag == "Yes") {
            $this->output->message = "<div class='error'>Please request for atleast one item.</div>";
            return;
        }

        ////////////////////////////////////////////////


        if ($this->clg->clg_group == 'UG-BioMedicalManager') {

            $emt_id = $this->clg->clg_ref_id;
        }

        $ind_data = $this->post['eqiup'];



        $args = array(
            'req_emt_id' => $emt_id,
            'req_date' => $this->today,
            'req_base_month' => $this->post['base_month'],
            'req_by' => $this->clg->clg_ref_id,
            'req_type' => 'amb',
            'req_amb_reg_no' => $this->input->post('incient_ambulance'),
            'req_state_code' => $this->input->post('incient_state'),
            'req_district_code' => $this->input->post('incient_district'),
            'req_base_location' => $this->input->post('base_location'),
            'req_shift_type' => $ind_data['req_shift_type'],
            'req_expected_date_time' => date('Y-m-d H:i:s', strtotime($ind_data['req_expected_date_time'])),
            'req_cur_date_time' => date('Y-m-d H:i:s', strtotime($ind_data['req_cur_date_time'])),
            'req_district_manager' => $ind_data['req_district_manager'],
            'req_standard_remark' => $ind_data['req_standard_remark'],
            'req_supervisor' => $ind_data['req_supervisor'],
            'req_group' => 'EQUP',
            'req_isdeleted' => '0',
        );

        if ($ind_data['req_other_remark'] != '') {
            $args['req_other_remark'] = $ind_data['req_other_remark'];
        }
        

       
        $req = $this->ind_model->insert_tyre_req($args);

        foreach ($item_key as $key) {
            if (is_array($this->post['item'][$key])) {
                foreach ($this->post['item'][$key] as $dt) {

                    if (!empty($dt['id'])) {

                        $ind_data = array(
                            'tyre_item_id' => $dt['id'],
                            'tyre_quantity' => $dt['qty'],
                            'tyre_item_type' => $key,
                            'tyre_req_id' => $req,
                        );


                        $result = $this->ind_model->insert_tyre($ind_data);
                    }
                }
            }
        }

        if ($result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Tyre request send successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->tyre();
        }
    }


    public function tyre_approve() {


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




        $args = array(
            'clg_group' => 'UG-DM'
        );

       // $data['clg'] = $this->colleagues_model->get_type_level($args);


      //  $data['group_info'] = $this->colleagues_model->get_higher_groups('', $data['clg'][0]->g_type_level);

        $data['req_group'] = 'EQUP';

        $data['req_is_approve'] = '0';

        $data['total_count'] = $this->biomedical_model->get_all_tyre_item($data);


        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $data['per_page'] = $config['per_page'];
        $data['cur_page'] = $page_no;

        unset($data['get_count']);


        $data['equipment_data'] = $this->biomedical_model->get_all_tyre_item($data,$offset,$limit);

        $data['clg_group'] = trim($this->clg->clg_group);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("biomedical/tyre_approve"),
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

        $data['page_records'] = count($data['equipment_data']);



        $this->output->add_to_position($this->load->view('frontend/biomedical/tyre_approve_list_view', $data, true), $this->post['output_position'], true);
        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }


    function view_tyr_details() {


        if ($this->post['req_id'] != '') {

            $data['req_id'] = $ref_id = base64_decode($this->post['req_id']);
            // print_r($data['req_id']);die;
            //$data['indent_data'] = $this->biomedical_model->get_all_equipment_item($data, $offset, $limit);
             $data['indent_data'] = $this->biomedical_model->get_all_tyre_item_details($data);
        }

        
        $data1['req_id'] = base64_decode($this->post['req_id']);
        $data['amb_no'] = $this->post['amb_no'];
        // print_r($data['req_id']);die;
        $data1['ind_item_type'] = 'EQP';


        $data['result'] = $this->ind_model->get_tyr_data($data1);


        $data['clg_group'] = $this->clg->clg_group;

        $data['action'] = $this->post['action'];

        $data['amb_no'] = $this->post['amb_no'];

        $data['radmin'] = ($data['action'] == 'rec' && $data['clg_group'] == 'UG-ADMIN') ? 'radmin' : '';



        if ($this->post['action'] == 'rec') {
            $data['action_type'] = 'Receive Tyre';
        } elseif ($this->post['action'] == 'view') {
            $data['action_type'] = 'View Tyre';
        } elseif ($this->post['action'] == 'apr') {
            $data['action_type'] = 'Approve Tyre';
        } else {
            $data['action_type'] = 'Dispatch Tyre';
        }


        $this->output->add_to_position($this->load->view('frontend/biomedical/view_tyre_details', $data, TRUE), '', TRUE);
    }

    function approve_tyre() {

        $req_type = $this->post['req_type'];

        $ind_data = $this->post['eqiup'];



        $args = array(
            'req_id' => $this->post['req_id'],
            // 'req_id' => 1,
            'req_is_approve' => '1',
            'req_apr_date_time' => date('Y-m-d H:i:s', strtotime($ind_data['req_apr_date_time'])),
            'req_dispatch_remark' => $ind_data['req_dispatch_remark'],
        );

        $req = $this->ind_model->update_tyre_req($args);


        $this->output->status = 1;

        $this->output->closepopup = "yes";

        $this->output->message = "<p>Tyre Approved Successfully</p>";

        $this->equipment_approve();
    }


    public function tyre_dispatch() {


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
            //$data['from_date'] = date('Y-m-d', strtotime($this->post['search1']));
        } else {
            //$data['to_date'] = date('Y-m-d');
        }



//
//        $args = array(
//            'clg_group' => 'UG-DM'
//        );
//
//        $data['clg'] = $this->colleagues_model->get_type_level($args);
//
//
//        $data['group_info'] = $this->colleagues_model->get_higher_groups('', $data['clg'][0]->g_type_level);

        $data['req_group'] = 'EQUP';

        $data['total_count'] = $this->biomedical_model->get_all_tyre_item($data);


        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;
        $data['per_page'] = $config['per_page'];
        $data['cur_page'] = $page_no;

        unset($data['get_count']);


        $data['equipment_data'] = $this->biomedical_model->get_all_tyre_item($data,$offset,$limit);

        $data['clg_group'] = trim($this->clg->clg_group);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("biomedical/tyre_dispatch"),
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

        $data['page_records'] = count($data['equipment_data']);



        $this->output->add_to_position($this->load->view('frontend/biomedical/bio_medical_tyre_dispatch_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }

    function dispatch_tyre() {



        if ($this->post['ind_opt']) {


            $req_type = $this->post['req_type'];
            // print_r($this->post['dis_qty']);die;

            foreach ($this->post['dis_qty'] as $ind_id => $qty) {

                $args = array(
                    'ind_id' => $ind_id,
                );

                // print_r($args);die;
                $data = array(
                    'tyre_dis_qty' => $qty,
                    'tyre_req_id' => $this->post['ind_req_id']
                );

                $this->ind_model->update_tyre_item($args, $data);


                /////////////////////////////////////////////////////////

                $ind_data = $this->ind_model->get_tyr_data($args);
// print_r($ind_data);die;

                $args = array(
                    'stk_tyre_id' => $ind_data[0]->tyre_item_id,
                    // 'stk_inv_type' => $ind_data[0]->ind_item_type,
                    'tyre_handled_by' => $this->clg->clg_ref_id,
                    'tyre_in_out' => 'out',
                    'tyre_qty' => $qty,
                    'tyre_date' => $this->today,
                    'tyre_base_month' => $this->post['base_month']
                );


                $this->inv_stock_model->insert_tyre_stock($args);
                
            }


            /////////////////////////////////////////////////////////



            $args = array(
                'req_id' => $this->post['ind_req_id'],
                'req_dis_by' => $this->clg->clg_ref_id,
                'req_dis_date' => $this->today,
                'req_dispatch_remark' => $this->post['eqiup']['req_dispatch_remark']
            );
// print_r($args);die;
            $req = $this->ind_model->update_tyre_req($args);


            /////////////////////////////////////////////////////

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<h3>Dispatch Items</h3><br><p>Items dispatched successfully</p>";

            $this->tyre();
        }
    }



    function receive_tyre() {

        if ($this->post['ind_opt']) {

            $req_type = $this->post['req_type'];

            $args = array(
                'req_id' => $this->post['ind_req_id'],
                'req_rec_by' => $this->clg->clg_ref_id,
                'req_rec_date' => $this->today
            );

            $req = $this->ind_model->update_tyre_req($args);
           


// print_r($this->post['rec_qty']);die;
            ////////////////////////////////////////////////////

            foreach ($this->post['rec_qty'] as $ind_id => $qty) {

                $args = array(
                    'tyre_id' => $ind_id,
                );

                $data = array(
                    'tyre_rec_qty' => $qty,
                    'tyre_req_id' => $this->post['ind_req_id']
                );



                $this->ind_model->update_tyre_item($args, $data);

                /////////////////////////////////////////////////////

                $ind = $this->ind_model->get_tyr_data(array('ind_id' => $ind_id));



                /////////////////////////////////////////////////////

                $args = array(
                    'as_item_id' => $ind[0]->tyre_item_id,
                    // 'as_item_type' => $ind[0]->ind_item_type,
                    'as_stk_in_out' => 'in',
                    'as_item_qty' => $qty,
                    'as_sub_id' => $this->post['ind_req_id'],
                    'as_sub_type' => 'tyre',
                    'as_date' => $this->today,
                    'amb_rto_register_no' => base64_decode($this->post['amb_no']),
                    'as_base_month' => $this->post['base_month'],
                );

                // print_r($args);die;

                $this->ind_model->insert_amb_tyre_stock($args);
            }

            /////////////////////////////////////////////////////

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<h3>Receive Items</h3><br><p>Items received successfully</p>";

            $this->tyre();
        }
    }

}
