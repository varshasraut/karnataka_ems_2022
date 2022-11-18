<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fleet extends EMS_Controller {

    var $dtmf, $dtmt; // default time from/to

    function __construct() {

        parent::__construct();

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->load->library(array('session', 'modules','upload',));

        $this->load->model(array('module_model', 'Medadv_model', 'call_model', 'ind_model', 'amb_model', 'colleagues_model', 'cluster_model', 'fleet_model', 'pcr_model', 'colleagues_model', 'inv_stock_model','ambmain_model','battery_model'));

        $this->load->helper(array('comman_helper'));

        $this->post = $this->input->get_post(NULL);

        $this->post['base_month'] = get_base_month();

        $this->clg = $this->session->userdata('current_user');

        $this->today = date('Y-m-d H:i:s');
        $this->default_state = $this->config->item('default_state');
        $this->nozzle_slip = $this->config->item('nozzle_slip');
        
        if ($this->post['ind_filters'] == 'reset') {

            $this->session->unset_userdata('ind_filters')['IND_APP'];
        }



        if ($this->session->userdata('ind_filters')['IND_APP']) {

            $this->fdata = $this->session->userdata('ind_filters')['IND_APP'];
        }
    }

    public function index() {
        
    }

    public function fuel_station() {


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

        $data['total_count'] = $this->fleet_model->get_all_fuel_station($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

//        $clgflt['CLG'] = $data;
//        $this->session->set_userdata('filters', $clgflt);
        ///////////////////////////////////

        unset($data['get_count']);



        $data['fuel_station'] = $this->fleet_model->get_all_fuel_station($data, $offset, $limit);
       

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/fuel_station"),
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

        $data['page_records'] = count($data['fuel_station']);






        $this->output->add_to_position($this->load->view('frontend/fleet/fuel_station_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/fleet/fuel_station_filter_view', $data, TRUE), 'clg_filters', TRUE);
    }

    function registration() {

        if ($this->post['f_id'] != '') {

            $data['f_id'] = $ref_id = base64_decode($this->post['f_id']);
            $data['fuel_station'] = $this->fleet_model->get_all_fuel_station($data, $offset, $limit);
        }


        if ($this->post['action_type'] == 'Update') {
            $data['action_type'] = "Update Fuel Station";
            $data['update'] = 'True';

            $this->output->add_to_position($this->load->view('frontend/fleet/register_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Fuel Station";

            $this->output->add_to_popup($this->load->view('frontend/fleet/register_view', $data, TRUE), '1200', '450');
        }
    }

    function registration_fuel_station() {

        $fuel_data = $this->post['fuel'];

        $fuel_data['f_state_code'] = $this->input->post('incient_state');

        $fuel_data['f_district_code'] = $this->input->post('incient_districts');
        $fuel_data['f_tahsil'] = $this->input->post('incient_tahsil');
        $fuel_data['f_city'] = $this->input->post('incient_ms_city');
        $fuel_data['f_added_date'] = date('Y-m-d H:i:s');
        $fuel_data['f_modify_by'] = $this->clg->clg_ref_id;
        $fuel_data['f_added_by'] = $this->clg->clg_ref_id;
        $fuel_data['f_modify_date'] = date('Y-m-d H:i:s');
        $fuel_data['f_is_deleted'] = '0';
        $fuel_data['f_base_month'] = $this->post['base_month'];

        $register_result = $this->fleet_model->insert_fuel_station($fuel_data);

        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Fuel Station registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->fuel_station();
        }
    }

    function view_fuel_station() {
        $data = array();

        $data['f_id'] = base64_decode($this->post['f_id']);

        $data['action_type'] = 'View Fuel Station';

        $data['fuel_station'] = $this->fleet_model->get_all_fuel_station($data, $offset, $limit);

        $this->output->add_to_position($this->load->view('frontend/fleet/view_fuel_station_view', $data, TRUE), $output_position, TRUE);
    }

    function update_fuel_station_data() {

        $fuel_data = $this->post['fuel'];

        $fuel_data['f_state_code'] = $this->input->post('incient_state');
        $fuel_data['f_district_code'] = $this->input->post('incient_districts');
        $fuel_data['f_tahsil'] = $this->input->post('incient_tahsil');
        $fuel_data['f_city'] = $this->input->post('incient_ms_city');
        $fuel_data['f_modify_by'] = $this->clg->clg_ref_id;
        $fuel_data['f_modify_date'] = date('Y-m-d H:i:s');



        $result = $this->fleet_model->fuel_station_update_data($fuel_data);

        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Fuel station updated successfully</div>";


            $this->fuel_station();
        }
    }

    public function work_station() {


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

        $data['total_count'] = $this->fleet_model->get_all_work_station($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;


        unset($data['get_count']);



        $data['work_station'] = $this->fleet_model->get_all_work_station($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/work_station"),
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

        $data['page_records'] = count($data['work_station']);






        $this->output->add_to_position($this->load->view('frontend/fleet/work_station_list_view', $data, true), $this->post['output_position'], true);

//        $this->output->add_to_position($this->load->view('frontend/fleet/work_station_filter_view', $data, TRUE), 'clg_filters', TRUE);
    }

    function work_station_registration() {


        if ($this->post['ws_id'] != '') {

            $data['ws_id'] = $ref_id = base64_decode($this->post['ws_id']);
            $data['work_station'] = $this->fleet_model->get_all_work_station($data, $offset, $limit);
        }


        if ($this->post['action_type'] == 'Update') {
            $data['action_type'] = "Update Work Station";
            $data['update'] = 'True';

            $this->output->add_to_position($this->load->view('frontend/fleet/work_station_register_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Ambulance Service Center";

            $this->output->add_to_popup($this->load->view('frontend/fleet/work_station_register_view', $data, TRUE), '1200', '800');
        }
    }

    function registration_work_station() {

        $work_data = $this->post['work'];

        $work_data['ws_state_code'] = $this->input->post('incient_state');
        $work_data['ws_district_code'] = $this->input->post('incient_districts');
        $work_data['ws_tahsil'] = $this->input->post('incient_tahsil');
        $work_data['ws_city'] = $this->input->post('incient_ms_city');
        $work_data['ws_added_date'] = date('Y-m-d H:i:s');
        $work_data['ws_modify_by'] = $this->clg->clg_ref_id;
        $work_data['ws_modify_date'] = date('Y-m-d H:i:s');
        $work_data['ws_is_deleted'] = '0';
        $work_data['ws_base_month'] = $this->post['base_month'];



        $register_result = $this->fleet_model->insert_work_station($work_data);

        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Work Station Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->work_station();
        }
    }

    function view_work_station() {
        $data = array();

        $data['ws_id'] = base64_decode($this->post['ws_id']);

        $data['action_type'] = 'View Work Station';

        $data['work_station'] = $this->fleet_model->get_all_work_station($data, $offset, $limit);

        $this->output->add_to_position($this->load->view('frontend/fleet/view_work_station_view', $data, TRUE), $output_position, TRUE);
    }

    function update_work_station_data() {

        $work_data = $this->post['work'];
        $work_data['ws_state_code'] = $this->input->post('incient_state');
        $work_data['ws_district_code'] = $this->input->post('incient_districts');
        $work_data['ws_tahsil'] = $this->input->post('incient_tahsil');
        $work_data['ws_city'] = $this->input->post('incient_ms_city');
        $work_data['ws_modify_by'] = $this->clg->clg_ref_id;
        $work_data['ws_modify_date'] = date('Y-m-d H:i:s');



        $result = $this->fleet_model->work_station_update_data($work_data);

        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Fuel station updated successfully</div>";


            $this->work_station();
        }
    }




// #########--------###########

public function vendor() {


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

    $data['total_count'] = $this->fleet_model->get_all_vendor($data);

    $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

    $page_no = get_pgno($data['total_count'], $limit, $page_no);

    $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

    $data['page_no'] = $page_no;


    unset($data['get_count']);



    $data['vendor'] = $this->fleet_model->get_all_vendor($data, $offset, $limit);

    /////////////////////////

    $data['cur_page'] = $page_no;

    $pgconf = array(
        'url' => base_url("fleet/vendor"),
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

    $data['page_records'] = count($data['vendor']);






    $this->output->add_to_position($this->load->view('frontend/fleet/ambu_vendor_list_view', $data, true), $this->post['output_position'], true);

//        $this->output->add_to_position($this->load->view('frontend/fleet/work_station_filter_view', $data, TRUE), 'clg_filters', TRUE);
}

function vendor_registration() {


    if ($this->post['vendor_id '] != '') {

        $data['vendor_id '] = $ref_id = base64_decode($this->post['vendor_id ']);
        $data['vendor'] = $this->fleet_model->get_all_vendor($data, $offset, $limit);
    }


    if ($this->post['action_type'] == 'Update') {
        $data['action_type'] = "Update Vendor";
        $data['update'] = 'True';

        $data['vendor_id'] = $ref_id = $this->post['vendor_id'];
        $data['vendor'] = $this->fleet_model->get_all_vendor($data, $offset, $limit);

        $this->output->add_to_position($this->load->view('frontend/fleet/vendor_register_view', $data, TRUE), $output_position, TRUE);
    } else {

        $data['action_type'] = "Add Ambulance Vendor";

        $this->output->add_to_popup($this->load->view('frontend/fleet/vendor_register_view', $data, TRUE), '1200', '800');
    }
}

function registration_vendor() {

    // $work_data['vendor_id'] = $this->input->post('vendor_id');
    $work_data['vendor_state'] = $this->input->post('vendor_state');
    $work_data['vendor_district'] = $this->input->post('incient_district');
    $work_data['vendor_tehshil'] = $this->input->post('incient_tahsil');
    $work_data['vendor_city'] = $this->input->post('incient_ms_city');
    $work_data['vendor_name'] = $this->input->post('vendor_name');
    $work_data['vendor_email'] = $this->input->post('vendor_email');
    $work_data['vendor_area'] = $this->input->post('vendor_area');
    $work_data['vendor_pincode'] = $this->input->post('vendor_pincode');
    $work_data['vendor_mob_number'] = $this->input->post('vendor_mob_number');
    $work_data['vendor_added_date'] = date('Y-m-d H:i:s');
    $work_data['vendor_added_by'] = $this->clg->clg_ref_id;
    $work_data['vendor_modify_date'] = date('Y-m-d H:i:s');



    $register_result = $this->fleet_model->insert_vendor($work_data);

    if ($register_result) {

        $this->output->status = 1;

        $this->output->message = "<div class='success'>Vendor Registered Successfully!</div>";

        $this->output->closepopup = 'yes';

        $this->vendor();
    }
}

function view_vendor() {
    $data = array();

    $data['vendor_id'] = $this->post['vendor_id'];
// print_r($data);die;
    $data['action_type'] = 'View Vendor';

    $data['vendor'] = $this->fleet_model->get_all_vendor($data, $offset, $limit);

    $this->output->add_to_position($this->load->view('frontend/fleet/view_vendor_view', $data, TRUE), $output_position, TRUE);
}

function update_vendor_data() {

    $work_data = $this->post['work'];

    $work_data['vendor_state'] = $this->input->post('incient_state');
    $work_data['vendor_district'] = $this->input->post('incient_district');
    $work_data['vendor_tehshil'] = $this->input->post('incient_tahsil');
    $work_data['vendor_city'] = $this->input->post('incient_ms_city');
    // $work_data['vendor_name'] = $this->input->post('vendor_name');
    // $work_data['vendor_email'] = $this->input->post('vendor_email');
    // $work_data['vendor_area'] = $this->input->post('vendor_area');
    // $work_data['vendor_pincode'] = $this->input->post('vendor_pincode');
    // $work_data['vendor_mob_number'] = $this->input->post('vendor_mob_number');
    $work_data['vendor_added_date'] = date('Y-m-d H:i:s');
    $work_data['vendor_added_by'] = $this->clg->clg_ref_id;
    $work_data['vendor_modify_date'] = date('Y-m-d H:i:s');



    $result = $this->fleet_model->vendor_update_data($work_data);

    if ($result) {

        $this->output->status = 1;

        $this->output->closepopup = 'yes';

        $this->output->message = "<div class='success'>Vendor updated successfully</div>";


        $this->vendor();
    }
}

// #########--------###########


    function equipment_service_center() {


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

        $data['total_count'] = $this->fleet_model->get_all_equipment_center_data($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

//        $clgflt['CLG'] = $data;
//        $this->session->set_userdata('filters', $clgflt);
        ///////////////////////////////////

        unset($data['get_count']);



        $data['equi_center'] = $this->fleet_model->get_all_equipment_center_data($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/equipment_service_center"),
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

        $data['page_records'] = count($data['equi_center']);


        $this->output->add_to_position($this->load->view('frontend/fleet/equipment_service_center_list_view', $data, true), $this->post['output_position'], true);
    }

    function equipment_center_registration_view() {


        if ($this->post['es_id'] != '') {

            $data['es_id'] = $ref_id = base64_decode($this->post['es_id']);
            $data['equip_center'] = $this->fleet_model->get_all_equipment_center_data($data, $offset, $limit);
        }


        if ($this->post['action_type'] == 'Update') {
            $data['action_type'] = "Update Equipment Service Center";
            $data['update'] = 'True';

            $this->output->add_to_position($this->load->view('frontend/fleet/equipment_center_register_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Equipment Service Center";

            $this->output->add_to_popup($this->load->view('frontend/fleet/equipment_center_register_view', $data, TRUE), '1200', '350');
        }
    }

    function registration_equipment_center() {

        $equip_data = $this->post['equi'];

        $equip_data['es_state_code'] = $this->input->post('incient_state');

        $equip_data['es_district_code'] = $this->input->post('incient_districts');
        $equip_data['es_tahsil_code'] = $this->input->post('incient_tahsil');
        $equip_data['es_city_code'] = $this->input->post('incient_ms_city');
        $equip_data['es_added_by'] = $this->clg->clg_ref_id;
        $equip_data['es_added_date'] = date('Y-m-d H:i:s');
        $equip_data['es_modify_by'] = $this->clg->clg_ref_id;
        $equip_data['es_modify_date'] = date('Y-m-d H:i:s');
        $equip_data['es_is_deleted'] = '0';
        $equip_data['es_base_month'] = $this->post['base_month'];

        $register_result = $this->fleet_model->insert_equipment_center($equip_data);

        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Equipment Service Center Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->equipment_service_center();
        }
    }

    function view_equipment_center() {

        $data = array();

        $data['es_id'] = base64_decode($this->post['es_id']);

        $data['action_type'] = 'View Equipment Service Center';

        $data['equi_station'] = $this->fleet_model->get_all_equipment_center_data($data, $offset, $limit);
        
        $this->output->add_to_position($this->load->view('frontend/fleet/equipment_center_view', $data, TRUE), $output_position, TRUE);
    }

    function update_equipment_center_data() {

        $equip_data = $this->post['equi'];
        $equip_data['es_state_code'] = $this->input->post('incient_state');
        $equip_data['es_district_code'] = $this->input->post('incient_districts');
        $equip_data['es_tahsil_code'] = $this->input->post('incient_tahsil');
        $equip_data['es_city_code'] = $this->input->post('incient_ms_city');
        $equip_data['es_modify_by'] = $this->clg->clg_ref_id;
        $equip_data['es_modify_date'] = date('Y-m-d H:i:s');



        $result = $this->fleet_model->equipment_center_update_data($equip_data);

        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Equipment Service Center Updated Successfully</div>";

            $this->equipment_service_center();
        }
    }

    function oxygen_service_center() {


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

        $data['total_count'] = $this->fleet_model->get_all_oxygen_center_data($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);



        $data['oxygen_center'] = $this->fleet_model->get_all_oxygen_center_data($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/oxygen_service_center"),
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

        $data['page_records'] = count($data['oxygen_center']);


        $this->output->add_to_position($this->load->view('frontend/fleet/oxygen_service_center_list_view', $data, true), $this->post['output_position'], true);
    }

    function oxygen_center_registration_view() {
        if ($this->post['os_id'] != '') {

            $data['os_id'] = $ref_id = base64_decode($this->post['os_id']);
            $data['oxygen_center'] = $this->fleet_model->get_all_oxygen_center_data($data, $offset, $limit);
        }


        if ($this->post['action_type'] == 'Update') {
            $data['action_type'] = "Update Oxygen Service Center";
            $data['update'] = 'True';

            $this->output->add_to_position($this->load->view('frontend/fleet/oxygen_center_register_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Oxygen Service Center";

            $this->output->add_to_popup($this->load->view('frontend/fleet/oxygen_center_register_view', $data, TRUE), '1200', '350');
        }
    }

    function registration_oxygen_center() {

        $oxy_data = $this->post['oxy'];

        $oxy_data['os_state_code'] = $this->input->post('incient_state');
        $oxy_data['os_district_code'] = $this->input->post('incient_districts');
        $oxy_data['os_tahsil'] = $this->input->post('incient_tahsil');
        $oxy_data['os_city'] = $this->input->post('incient_ms_city');
        $oxy_data['os_added_by'] = $this->clg->clg_ref_id;
        $oxy_data['os_added_date'] = date('Y-m-d H:i:s');
        $oxy_data['os_modify_by'] = $this->clg->clg_ref_id;
        $oxy_data['os_modify_date'] = date('Y-m-d H:i:s');
        $oxy_data['os_is_deleted'] = '0';
        $oxy_data['os_base_month'] = $this->post['base_month'];

        
        $register_result = $this->fleet_model->insert_oxygen_center($oxy_data);

        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Oxygen Service Center Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->oxygen_service_center();
        }
    }

    function view_oxygen_center() {

        $data = array();

        $data['os_id'] = base64_decode($this->post['os_id']);

        $data['action_type'] = 'View Oxygen Service Center';

        $data['oxygen_center'] = $this->fleet_model->get_all_oxygen_center_data($data, $offset, $limit);
        
        $this->output->add_to_position($this->load->view('frontend/fleet/oxygen_center_view', $data, TRUE), $output_position, TRUE);
    }

    function update_oxygen_center_data() {



        $oxy_data = $this->post['oxy'];
        $oxy_data['os_state_code'] = $this->input->post('incient_state');
        $oxy_data['os_district_code'] = $this->input->post('incient_districts');
        $oxy_data['os_tahsil'] = $this->input->post('incient_tahsil');
        $oxy_data['os_city'] = $this->input->post('incient_ms_city');
        $oxy_data['os_modify_by'] = $this->clg->clg_ref_id;
        $oxy_data['os_modify_date'] = date('Y-m-d H:i:s');



        $result = $this->fleet_model->oxygen_center_update_data($oxy_data);

        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Oxygen Service Center Updated Successfully</div>";

            $this->oxygen_service_center();
        }
    }

    function statutory_compliance() {

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
//        $data['to_date'] = date('Y-m-d');
//        $data['from_date'] = date('Y-m-d');



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
        
        $district_id = "";
if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        $data['amb_district'] = $district_id;


        $data['total_count'] = $this->fleet_model->get_all_statutory_compliance_data($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;



        unset($data['get_count']);



        $data['stat_data'] = $this->fleet_model->get_all_statutory_compliance_data($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/statutory_compliance"),
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

        $data['page_records'] = count($data['stat_data']);



        $this->output->add_to_position($this->load->view('frontend/fleet/statutory_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }

    function statutory_compliance_registrartion() {

        if ($this->post['sc_id'] != '') {

            $data['sc_id'] = $ref_id = base64_decode($this->post['sc_id']);
            $data['statutory_data'] = $this->fleet_model->get_all_statutory_compliance_data($data, $offset, $limit);
        }


        if ($this->post['action_type'] == 'Update') {


            $data['action_type'] = "Update Statutory compliance";
            $data['type'] = "Update";
            $data['update'] = 'True';

            $this->output->add_to_position($this->load->view('frontend/fleet/statutory_compliance_register_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Statutory Compliance";

            $this->output->add_to_popup($this->load->view('frontend/fleet/statutory_compliance_register_view', $data, TRUE), '1200', '500');
        }
    }

    function other_supervisor_textbox() {

        $this->output->add_to_position($this->load->view('frontend/fleet/other_supervisor_textbox_view', $data, TRUE), 'other_supervisor_textbox', TRUE);
    }

    function registration_statutory_compliance() {



        $stat_data = $this->post['stat'];
        $stat_data['sc_state_code'] = $this->input->post('incient_state');
        $stat_data['sc_district_code'] = $this->input->post('incient_districts');
        $stat_data['sc_amb_ref_number'] = $this->input->post('incient_ambulance');
        $stat_data['sc_base_location'] = $this->input->post('base_location');
        $stat_data['sc_date_of_renovation'] = date('Y-m-d H:i:s', strtotime($stat_data['sc_date_of_renovation']));
        $stat_data['sc_pilot_name'] = $this->input->post('pilot_id');
        $stat_data['sc_emso_name'] = $this->input->post('emt_name');
        $stat_data['sc_added_by'] = $this->clg->clg_ref_id;
        $stat_data['sc_added_date'] = date('Y-m-d H:i:s');
        $stat_data['sc_modify_by'] = $this->clg->clg_ref_id;
        $stat_data['sc_modify_date'] = date('Y-m-d H:i:s');
        $stat_data['sc_is_deleted'] = '0';
        $stat_data['sc_base_month'] = $this->post['base_month'];

        $register_result = $this->fleet_model->insert_statutory_compliance($stat_data);

        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Statutory Compliance Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->statutory_compliance();
        }
    }

    function statutory_compliance_view() {

        $data = array();

        $data['sc_id'] = base64_decode($this->post['sc_id']);

        $data['action_type'] = 'View Statutory Compliance';

        $data['statutory_data'] = $this->fleet_model->get_all_statutory_compliance_data($data, $offset, $limit);

        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' =>
            $data['statutory_data'][0]->sc_standard_remark));

        $data['re_name'] = $data1['standard_remark'][0]->re_name;

        $this->output->add_to_position($this->load->view('frontend/fleet/statutory_compliance_view', $data, TRUE), $output_position, TRUE);
    }

    function update_statutory_compliance() {
        $stat_data = $this->post['stat'];
        $stat_data['sc_modify_by'] = $this->clg->clg_ref_id;
        $stat_data['sc_modify_date'] = date('Y-m-d H:i:s');
        $stat_data['sc_next_date_of_renovation'] = date('Y-m-d H:i:s', strtotime($stat_data['sc_next_date_of_renovation']));
        $stat_data['sc_cur_date_time'] = date('Y-m-d H:i:s', strtotime($stat_data['sc_cur_date_time']));
        $stat_data['is_updated'] = "1";

        $result = $this->fleet_model->statutory_compliance_update_data($stat_data);

        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Statutory Compliance Updated Successfully</div>";

            $this->statutory_compliance();
        }
    }

    function visitor_update() {

        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];

        if ($this->post['from_date'] != '') {
            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }


        if ($this->post['to_date'] != '') {
            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
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
        
        $district_id = "";
if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        $data['amb_district'] = $district_id;

        $data['total_count'] = $this->fleet_model->get_all_visitor_data($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;



        unset($data['get_count']);



        $data['visitor_data'] = $this->fleet_model->get_all_visitor_data($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/visitor_update"),
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

        $data['page_records'] = count($data['visitor_data']);






        $this->output->add_to_position($this->load->view('frontend/fleet/visitor_list_view', $data, true), $this->post['output_position'], true);
        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }

    function visitor_update_registrartion() {

        $args = array('clg_group' => 'UG-Supervisor');

        $data['supervisor_info'] = $this->colleagues_model->get_clg_data($args);

        if ($this->post['vs_id'] != '') {

            $data['vs_id'] = $ref_id = base64_decode($this->post['vs_id']);
            $data['visitor_data'] = $this->fleet_model->get_all_visitor_data($data, $offset, $limit);
        }


        if ($this->post['action_type'] == 'Update') {

            $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' =>
                $data['visitor_data'][0]->vs_standard_remark));

            $data['re_name'] = $data1['standard_remark'][0]->re_name;
            $data['action_type'] = "Update Visitor";
            $data['update'] = 'True';

            $this->output->add_to_position($this->load->view('frontend/fleet/visitor_registor_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Visitor";

            $this->output->add_to_popup($this->load->view('frontend/fleet/visitor_registor_view', $data, TRUE), '1200', '500');
        }
    }

    function update_amb_base_location() {

        $args = array(
            'amb_ref_id' => $this->post['amb_id'],
        );


        $data['inc_emp_info'] = $this->pcr_model->get_amb_location($args);

        $args_odometer = array('rto_no' => $this->post['amb_id']);
        $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
        
        $amb_type = $this->amb_model->get_amb_make_model_by_regno($args_odometer);
        $data['amb_type']=$amb_type[0]->ambt_name;
        $data['vehical_model']=$amb_type[0]->vehical_model;
        $data['ambt_name']=$amb_type[0]->ambu_type;

        if (empty($data['previous_odometer'])) {
            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
        }
         

        if (empty($data['previous_odometer'])) {
            $data['previous_odometer'] = 0;
        }
      // var_dump($data);die;
        $this->output->add_to_position($this->load->view('frontend/fleet/base_location_view', $data, TRUE), 'amb_base_location', TRUE);
         $this->output->add_to_position($this->load->view('frontend/fleet/amb_type_view', $data, TRUE), 'amb_type_div', TRUE);
          $this->output->add_to_position($this->load->view('frontend/fleet/ambu_type_view', $data, TRUE), 'amb_type_div_outer', TRUE);
         
          $this->output->add_to_position($this->load->view('frontend/fleet/amb_model_view', $data, TRUE), 'amb_amb_model', TRUE);

        $this->output->add_to_position($this->load->view('frontend/maintaince/previous_odometer', $data, TRUE), 'maintance_previous_odometer', TRUE);
        $this->output->add_to_position($this->load->view('frontend/maintaince/previous_odometer1', $data, TRUE), 'maintance_request_previous_odometer', TRUE);
        if($amb_type[0]->ambt_name == 'force'){
            
             $this->output->add_to_position($this->load->view('frontend/maintenance_part/force_maintenance_part', $data, TRUE), 'maintananace_part_list_block', TRUE);
            $this->output->add_to_position($this->load->view('frontend/maintenance_part/force_hidden_maintenance_part', $data, TRUE), 'hidden_maintence_part', TRUE);
             
        }else{
            
             $this->output->add_to_position($this->load->view('frontend/maintenance_part/ashok_maintenance_part', $data, TRUE), 'maintananace_part_list_block', TRUE);
               $this->output->add_to_position($this->load->view('frontend/maintenance_part/ashok_hidden_maintenance_part', $data, TRUE), 'hidden_maintence_part', TRUE);
             
        }
       
    }
    function update_onroad_offroad_base_location() {

        $args = array(
            'amb_ref_id' => $this->post['amb_id'],
        );


        $data['inc_emp_info'] = $this->pcr_model->get_amb_location($args);

        $args_odometer = array('rto_no' => $this->post['amb_id']);
        
        $amb_odometer_fuel = $this->ambmain_model->get_ambulance_onroad_offroad_maintance($args_odometer);
        
        $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
      
        
        $amb_type = $this->amb_model->get_amb_make_model_by_regno($args_odometer);
       $data['amb_type']=$amb_type[0]->ambt_name;
        $data['vehical_model']=$amb_type[0]->vehical_model;
        $data['ambt_name']=$amb_type[0]->ambu_type;;
        
          
        if (!empty($amb_odometer_fuel)) {
            if(!empty($amb_odometer_fuel[0]->mt_in_odometer)){
                $data['current_odometer'] = $amb_odometer_fuel[0]->mt_in_odometer;
            }else {
            $data['current_odometer'] = 0;
            }
            
        }else{
                $data['current_odometer']=0;  
        }

      

        if($amb_odometer[0]->end_odmeter != ''){
            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
        }else{
             $data['previous_odometer'] = 0;
        }


        $this->output->add_to_position($this->load->view('frontend/fleet/base_location_view', $data, TRUE), 'amb_base_location', TRUE);
        
        $this->output->add_to_position($this->load->view('frontend/fleet/ambu_type_view', $data, TRUE), 'amb_type_div_outer', TRUE);
         $this->output->add_to_position($this->load->view('frontend/fleet/amb_type_view', $data, TRUE), 'amb_type_div', TRUE);
          $this->output->add_to_position($this->load->view('frontend/fleet/amb_model_view', $data, TRUE), 'amb_amb_model', TRUE);

        $this->output->add_to_position($this->load->view('frontend/maintaince/previous_odometer_onroad_offroad_filling', $data, TRUE), 'maintance_previous_odometer', TRUE);
    }
 

    function update_amb_base_location_acc() {

        $args = array(
            'amb_ref_id' => $this->post['amb_id'],
        );


        $data['inc_emp_info'] = $this->pcr_model->get_amb_location($args);

        $args_odometer = array('rto_no' => $this->post['amb_id']);
        $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
        $amb_type = $this->amb_model->get_amb_make_model_by_regno($args_odometer);
        $data['amb_type']=$amb_type[0]->ambt_name;
        $data['vehical_model']=$amb_type[0]->vehical_model;
        $data['ambt_name']=$amb_type[0]->ambu_type;

        if (empty($data['previous_odometer'])) {
            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
        }

        if (empty($data['previous_odometer'])) {
            $data['previous_odometer'] = 0;
        }
      // var_dump($data);die;
        $this->output->add_to_position($this->load->view('frontend/fleet/base_location_view', $data, TRUE), 'amb_base_location', TRUE);
        $this->output->add_to_position($this->load->view('frontend/fleet/ambu_type_view', $data, TRUE), 'amb_type_div_outer', TRUE);
        
         $this->output->add_to_position($this->load->view('frontend/fleet/amb_type_view', $data, TRUE), 'amb_type_div', TRUE);
          $this->output->add_to_position($this->load->view('frontend/fleet/amb_model_view', $data, TRUE), 'amb_amb_model', TRUE);
        
        

        $this->output->add_to_position($this->load->view('frontend/maintaince/previous_odometer1', $data, TRUE), 'maintance_previous_odometer', TRUE);
    }
    function update_amb_base_location_fuel_filling() {

        $args = array(
            'amb_ref_id' => $this->post['amb_id'],
        );
        
        $case_fuel_type = $this->post['fuel_filling_type'];


        $data['inc_emp_info'] = $this->pcr_model->get_amb_location($args);
        $data['ff_date_time']= $this->fleet_model->get_pervious_fuel_date_time($args);
        
        $args_odometer = array('rto_no' => $this->post['amb_id']);
        if($case_fuel_type == 'fuel_filling_during_case'){
            
            //$args_odometer['odometer_type'] = 'closure';
            $amb_odometer = $this->amb_model->get_amb_odometer_fuel($args_odometer);
            
            // print_r($amb_odometer);die;
            if($amb_odometer[0]->end_odmeter != ''){
                $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
            }else{
                 $data['previous_odometer'] = 0;
            }
            
            if($amb_odometer[0]->end_odmeter != ''){
                $data['in_odometer'] = $amb_odometer[0]->end_odmeter;
            }else{
                 $data['in_odometer'] = 0;
            }
            
            
        }else{
            $amb_odometer = $this->amb_model->get_amb_odometer_fuel($args_odometer);
            // print_r($amb_odometer);die;
            if($amb_odometer[0]->end_odmeter != ''){
                $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
            }else{
                $data['previous_odometer'] = 0;
            }
        }

        
        
        $amb_odometer_fuel = $this->fleet_model->get_all_fuel_filling_data1($args_odometer);
        $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
        $amb_type = $this->amb_model->get_amb_make_model_by_regno($args_odometer);
        $inc = $data['inc_emp_info'];
        // print_r($amb_odometer_fuel);die;
        $data['amb_type']= $amb_type[0]->ambu_type;
        $data['vehical_model']=$amb_type[0]->vehical_model;
        $data['ambt_name']=$amb_type[0]->ambu_type;
          
        if (!empty($amb_odometer_fuel)) {
               
            if(!empty($amb_odometer_fuel[0]->ff_current_odometer)){
                $data['current_odometer'] = $amb_odometer_fuel[0]->ff_current_odometer;
            }else {
            $data['current_odometer'] = $amb_odometer1[0]->end_odmeter;
            }
            
        }else{
                $data['current_odometer']="0";  
        }
        if($data['current_odometer'] == ''){
            $data['current_odometer']="0";  
        }

        if($case_fuel_type == 'fuel_filling_during_case'){
            // print_r($data);die;
           $this->output->add_to_position($this->load->view('frontend/fleet/fuel_filling_case_type_remark', $data, TRUE), 'fuel_filling_case_type_remark', TRUE); 
        }else{
            // print_r($data);die;
             $this->output->add_to_position('', 'fuel_filling_case_type_remark', TRUE); 
        }
       
        if($data['amb_type'] =='JE'){
            $this->output->add_to_position('', 'emt_id_amb', TRUE);
        }
        
        $this->output->add_to_position($this->load->view('frontend/fleet/base_location_view', $data, TRUE), 'amb_base_location', TRUE);
        $this->output->add_to_position($this->load->view('frontend/fleet/base_location_view', $data, TRUE), 'prev_fuel_dilling_date', TRUE);
        $this->output->add_to_position($this->load->view('frontend/fleet/amb_type', $data, TRUE), 'amb_type_div', TRUE);
        $this->output->add_to_position($this->load->view('frontend/fleet/ambu_type_view', $data, TRUE), 'amb_type_div_outer', TRUE);
        $this->output->add_to_position($this->load->view('frontend/fleet/amb_type_view', $data, TRUE), 'amb_type_div', TRUE);
        $this->output->add_to_position($this->load->view('frontend/fleet/amb_model_view', $data, TRUE), 'amb_amb_model', TRUE);

        $this->output->add_to_position($this->load->view('frontend/maintaince/previous_odometer_fuel_filling', $data, TRUE), 'maintance_previous_odometer', TRUE);
    }
    
    function update_amb_base_location_oxygen(){

        $args = array(
            'amb_ref_id' => $this->post['amb_id'],
        );
        $oxygen_filling_type = $this->post['oxygen_filling_type'];

        $data['inc_emp_info'] = $this->pcr_model->get_amb_location($args);

        $args_odometer = array('rto_no' => $this->post['amb_id']);
        
        $amb_odometer_fuel = $this->fleet_model->get_all_oxygen_filling_data_by_amb($args_odometer);
        //var_dump($amb_odometer_fuel);
        
        $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
        $amb_type = $this->amb_model->get_amb_make_model_by_regno($args_odometer);
        $data['amb_type']=$amb_type[0]->ambt_name;
        $data['vehical_model']=$amb_type[0]->vehical_model;
        $data['ambt_name']=$amb_type[0]->ambu_type;
       // var_dump($amb_odometer);
          
        if (!empty($amb_odometer_fuel)) {
            if(!empty($amb_odometer_fuel[0]->of_in_odometer )){
                $data['current_odometer'] = $amb_odometer_fuel[0]->of_in_odometer;
                
            }else{
                $data['current_odometer'] = 0;
            }
            
        }else{
                $data['current_odometer'] = 0;
        }
        
         if($oxygen_filling_type == 'oxygen_filling_during_case'){
            
            //$args_odometer['odometer_type'] = 'closure';
            $amb_odometer = $this->amb_model->get_amb_odometer_fuel($args_odometer);
            
            
            if($amb_odometer[0]->end_odmeter != ''){
                $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
            }else{
                 $data['previous_odometer'] = 0;
            }
            
            if($amb_odometer[0]->end_odmeter != ''){
                $data['in_odometer'] = $amb_odometer[0]->end_odmeter;
            }else{
                 $data['in_odometer'] = 0;
            }
            
            
        }else{
            $amb_odometer = $this->amb_model->get_amb_odometer_fuel($args_odometer);;
            if($amb_odometer[0]->end_odmeter != ''){
                $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
            }else{
                $data['previous_odometer'] = 0;
            }
        }
        

//        if($amb_odometer[0]->end_odmeter != ''){
//            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
//        }else{
//            $data['previous_odometer'] = 0;
//        }
        //var_dump($case_fuel_type);
        if($oxygen_filling_type == 'oxygen_filling_during_case'){
            
           $this->output->add_to_position($this->load->view('frontend/fleet/oxygen_filling_case_type_remark', $data, TRUE), 'oxygen_filling_during_case', TRUE); 
        }else{
             $this->output->add_to_position('', 'oxygen_filling_during_case', TRUE); 
        }
        $this->output->add_to_position($this->load->view('frontend/fleet/base_location_view', $data, TRUE), 'amb_base_location', TRUE);
        $this->output->add_to_position($this->load->view('frontend/fleet/ambu_type_view', $data, TRUE), 'amb_type_div_outer', TRUE);
         $this->output->add_to_position($this->load->view('frontend/fleet/amb_type_view', $data, TRUE), 'amb_type_div', TRUE);
          $this->output->add_to_position($this->load->view('frontend/fleet/amb_model_view', $data, TRUE), 'amb_amb_model', TRUE);

        $this->output->add_to_position($this->load->view('frontend/maintaince/previous_odometer_oxygen_filling', $data, TRUE), 'maintance_previous_odometer', TRUE);
    }
    
    function update_amb_base_location_vahicle(){

        $args = array(
            'amb_ref_id' => $this->post['amb_id'],
        );

        $data['inc_emp_info'] = $this->pcr_model->get_amb_location($args);

        $args_odometer = array('rto_no' => $this->post['amb_id']);
        
        $amb_odometer_fuel = $this->fleet_model->get_vehical_location_data($args_odometer);
        //var_dump($amb_odometer_fuel);
        
        $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
          $amb_type = $this->amb_model->get_amb_make_model_by_regno($args_odometer);
        $data['amb_type']=$amb_type[0]->ambt_name;
        $data['vehical_model']=$amb_type[0]->vehical_model;
       // var_dump($amb_odometer);
          
        if (!empty($amb_odometer_fuel)) {
            if(!empty($amb_odometer_fuel[0]->vl_in_odometer)){
                $data['current_odometer'] = $amb_odometer_fuel[0]->vl_in_odometer;
                
            }else{
                $data['current_odometer'] = 0;
            }
        }else{
                $data['current_odometer'] = 0;
            }
        

        if($amb_odometer[0]->end_odmeter != ''){
            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
        }else{
            $data['previous_odometer'] = 0;
        }


        $this->output->add_to_position($this->load->view('frontend/fleet/base_location_view', $data, TRUE), 'amb_base_location', TRUE);
        $this->output->add_to_position($this->load->view('frontend/fleet/ambu_type_view', $data, TRUE), 'amb_type_div_outer', TRUE);
         $this->output->add_to_position($this->load->view('frontend/fleet/amb_type_view', $data, TRUE), 'amb_type_div', TRUE);
          $this->output->add_to_position($this->load->view('frontend/fleet/amb_model_view', $data, TRUE), 'amb_amb_model', TRUE);

        $this->output->add_to_position($this->load->view('frontend/maintaince/previous_odometer_vahicle_filling', $data, TRUE), 'maintance_previous_odometer', TRUE);
    }
    function update_amb_base_location_demo(){

        $args = array(
            'amb_ref_id' => $this->post['amb_id'],
        );

        $data['inc_emp_info'] = $this->pcr_model->get_amb_location($args);

        $args_odometer = array('rto_no' => $this->post['amb_id']);
        
        $amb_odometer_fuel = $this->fleet_model->get_demo_training_data($args_odometer);
        
        $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
        $amb_type = $this->amb_model->get_amb_make_model_by_regno($args_odometer);
        $data['amb_type']=$amb_type[0]->ambt_name;
        $data['vehical_model']=$amb_type[0]->vehical_model;
        $data['ambt_name']=$amb_type[0]->ambu_type;
          
        if (!empty($amb_odometer_fuel)) {
            if(!empty($amb_odometer_fuel[0]->dt_in_odometer)){
                $data['current_odometer'] = $amb_odometer_fuel[0]->dt_in_odometer;
                
            }else{
                $data['current_odometer'] = 0;
            }
        }else{
                $data['current_odometer'] = 0;
            }

        if($amb_odometer[0]->end_odmeter != ''){
            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
        }else{
            $data['previous_odometer'] = 0;
        }


        $this->output->add_to_position($this->load->view('frontend/fleet/base_location_view', $data, TRUE), 'amb_base_location', TRUE);
        $this->output->add_to_position($this->load->view('frontend/fleet/ambu_type_view', $data, TRUE), 'amb_type_div_outer', TRUE);
        
         $this->output->add_to_position($this->load->view('frontend/fleet/amb_type_view', $data, TRUE), 'amb_type_div', TRUE);
          $this->output->add_to_position($this->load->view('frontend/fleet/amb_model_view', $data, TRUE), 'amb_amb_model', TRUE);

        $this->output->add_to_position($this->load->view('frontend/maintaince/previous_odometer_demo_filling', $data, TRUE), 'maintance_previous_odometer', TRUE);
    }
    
    function update_amb_base_location_break(){

        $args = array(
            'amb_ref_id' => $this->post['amb_id'],
        );

        $data['inc_emp_info'] = $this->pcr_model->get_amb_location($args);

        $args_odometer = array('rto_no' => $this->post['amb_id']);
        
        $amb_odometer_fuel = $this->ambmain_model->get_ambulance_break_maintance_data_odo($args_odometer);
        
        $amb_break_count = $this->ambmain_model->get_ambulance_break_maintance_data_by_amb($args_odometer);
        $data['amb_break_count'] = $amb_break_count;
    
        
        $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
       // var_dump($amb_odometer);
       // die();
        $amb_type = $this->amb_model->get_amb_make_model_by_regno($args_odometer);
        $data['amb_type']=$amb_type[0]->ambt_name;
        $data['vehical_model']=$amb_type[0]->vehical_model;
        $data['ambt_name']=$amb_type[0]->ambu_type;
        $data['amb_owner']=$amb_type[0]->amb_owner;
        if (!empty($amb_odometer_fuel)) {
            if(!empty($amb_odometer_fuel[0]->mt_in_odometer)){
                $data['current_odometer'] = $amb_odometer_fuel[0]->mt_in_odometer;
                
            }else{
                $data['current_odometer'] = 0;
            }
        }else{
                $data['current_odometer'] = 0;
            }

        if($amb_odometer[0]->end_odmeter != ''){
            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
        }else{
            $data['previous_odometer'] = 0;
        }


        $this->output->add_to_position($this->load->view('frontend/fleet/base_location_view', $data, TRUE), 'amb_base_location', TRUE);
        $this->output->add_to_position($this->load->view('frontend/fleet/ambu_type_view', $data, TRUE), 'amb_type_div_outer', TRUE);
         $this->output->add_to_position($this->load->view('frontend/fleet/amb_type_view', $data, TRUE), 'amb_type_div', TRUE);
          $this->output->add_to_position($this->load->view('frontend/fleet/amb_model_view', $data, TRUE), 'amb_amb_model', TRUE);
           $this->output->add_to_position($this->load->view('frontend/maintaince/amb_breakdown_count', $data, TRUE), 'breakdown_count', TRUE);
        
$this->output->add_to_position($this->load->view('frontend/fleet/amb_owner_view', $data, TRUE), 'amb_owner', TRUE);
        $this->output->add_to_position($this->load->view('frontend/maintaince/previous_odometer_break_filling', $data, TRUE), 'maintance_previous_odometer', TRUE);
        
    }
    
    function update_base_location_accidental(){

        $args = array(
            'amb_ref_id' => $this->post['amb_id'],
        );

        $data['inc_emp_info'] = $this->pcr_model->get_amb_location($args);

        $args_odometer = array('rto_no' => $this->post['amb_id']);
        
        $amb_odometer_fuel = $this->ambmain_model->get_accidental_maintance_data($args_odometer);
        
       // $battery_odometer_fuel = $this->battery_model->get_total_battery($args_odometer);   
        $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
        $amb_type = $this->amb_model->get_amb_make_model_by_regno($args_odometer);
        $data['amb_type']=$amb_type[0]->ambt_name;
        $data['vehical_model']=$amb_type[0]->vehical_model;
        $data['ambt_name']=$amb_type[0]->ambu_type;
          
        if (!empty($amb_odometer_fuel)) {
            if(!empty($amb_odometer_fuel[0]->mt_in_odometer)){
                $data['current_odometer'] = $amb_odometer_fuel[0]->mt_in_odometer;
                
            }else{
                $data['current_odometer'] = 0;
            }
        }else{
                $data['current_odometer'] = 0;
            }
            
            
        if (!empty($battery_odometer_fuel)) {
            if(!empty($battery_odometer_fuel[0]->prev_odo_when_battery_fitted )){
                $data['current_odometer_battery'] = $battery_odometer_fuel[0]->prev_odo_when_battery_fitted ;
                
            }else{
                $data['current_odometer_battery'] = 0;
            }
        }else{
                $data['current_odometer_battery'] = 0;
       }

        if($amb_odometer[0]->end_odmeter != ''){
            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
        }else{
            $data['previous_odometer'] = 0;
        }


        $this->output->add_to_position($this->load->view('frontend/fleet/base_location_view', $data, TRUE), 'amb_base_location', TRUE);
        $this->output->add_to_position($this->load->view('frontend/fleet/ambu_type_view', $data, TRUE), 'amb_type_div_outer', TRUE);
        
         $this->output->add_to_position($this->load->view('frontend/fleet/amb_type_view', $data, TRUE), 'amb_type_div', TRUE);
         $this->output->add_to_position($this->load->view('frontend/fleet/amb_model_view', $data, TRUE), 'amb_amb_model', TRUE);
         

        $this->output->add_to_position($this->load->view('frontend/maintaince/previous_odometer_accidental_filling', $data, TRUE), 'maintance_previous_odometer', TRUE);
        
         $this->output->add_to_position($this->load->view('frontend/battery/previous_odometer_accidental_filling', $data, TRUE), 'battery_previous_odometer', TRUE);
    }
    function update_base_location_tyre(){

        $args = array(
            'amb_ref_id' => $this->post['amb_id'],
        );

        $data['inc_emp_info'] = $this->pcr_model->get_amb_location($args);

        $args_odometer = array('rto_no' => $this->post['amb_id']);
        
        $amb_odometer_fuel = $this->ambmain_model->get_ambulance_tyre_data_auto($args_odometer);
        
        $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
        $amb_type = $this->amb_model->get_amb_make_model_by_regno($args_odometer);
        $data['amb_type']=$amb_type[0]->ambt_name;
        $data['vehical_model']=$amb_type[0]->vehical_model;
        $data['ambt_name']=$amb_type[0]->ambu_type;
          
        if (!empty($amb_odometer_fuel)) {
            if(!empty($amb_odometer_fuel[0]->mt_in_odometer)){
                $data['current_odometer'] = $amb_odometer_fuel[0]->mt_in_odometer;
                
            }else{
                $data['current_odometer'] = 0;
            }
        }else{
                $data['current_odometer'] = 0;
            }

        if($amb_odometer[0]->end_odmeter != ''){
            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
        }else{
            $data['previous_odometer'] = 0;
        }


        $this->output->add_to_position($this->load->view('frontend/fleet/base_location_view', $data, TRUE), 'amb_base_location', TRUE);
        $this->output->add_to_position($this->load->view('frontend/fleet/ambu_type_view', $data, TRUE), 'amb_type_div_outer', TRUE);
         $this->output->add_to_position($this->load->view('frontend/fleet/amb_type_view', $data, TRUE), 'amb_type_div', TRUE);
          $this->output->add_to_position($this->load->view('frontend/fleet/amb_model_view', $data, TRUE), 'amb_amb_model', TRUE);

        $this->output->add_to_position($this->load->view('frontend/maintaince/previous_odometer_tyre_filling', $data, TRUE), 'maintance_previous_odometer', TRUE);
        
    }
        function update_base_location_preventive(){

        $args = array(
            'amb_ref_id' => $this->post['amb_id'],
        );

        $data['inc_emp_info'] = $this->pcr_model->get_amb_location($args);

        $args_odometer = array('rto_no' => $this->post['amb_id'],'mt_approval'=>1);
        $amb_odometer_fuel = $this->ambmain_model->get_preventive_ambulance_maintance_data($args_odometer);

        
        $amb_odometer = $this->amb_model->get_amb_odometer($args_odometer);
        $amb_type = $this->amb_model->get_amb_make_model_by_regno($args_odometer);
        $data['amb_type']=$amb_type[0]->ambt_name;
        $data['vehical_model']=$amb_type[0]->vehical_model;
        $data['ambt_name']=$amb_type[0]->ambu_type;
         $data['amb_owner']=$amb_type[0]->amb_owner;
          
        if (!empty($amb_odometer_fuel)) {
            if(!empty($amb_odometer_fuel[0]->mt_in_odometer)){
                $data['current_odometer'] = $amb_odometer_fuel[0]->mt_in_odometer;
                $data['mt_pre_maintenance_date'] = $amb_odometer_fuel[0]->added_date;
                
            }else{
                $data['current_odometer'] = 0;
                $data['mt_pre_maintenance_date'] = 0;
            }
        }else{
                $data['current_odometer'] = 0;
                $data['mt_pre_maintenance_date'] = 0;
            }

        if($amb_odometer[0]->end_odmeter != ''){
            $data['previous_odometer'] = $amb_odometer[0]->end_odmeter;
        }else{
            $data['previous_odometer'] = 0;
        }


        $this->output->add_to_position($this->load->view('frontend/fleet/base_location_view', $data, TRUE), 'amb_base_location', TRUE);
        $this->output->add_to_position($this->load->view('frontend/fleet/ambu_type_view', $data, TRUE), 'amb_type_div_outer', TRUE);
         $this->output->add_to_position($this->load->view('frontend/fleet/amb_type_view', $data, TRUE), 'amb_type_div', TRUE);
          $this->output->add_to_position($this->load->view('frontend/fleet/amb_model_view', $data, TRUE), 'amb_amb_model', TRUE);
            $this->output->add_to_position($this->load->view('frontend/fleet/amb_owner_view', $data, TRUE), 'amb_owner', TRUE);
          $this->output->add_to_position($this->load->view('frontend/maintaince/pre_maintenance_date_view', $data, TRUE), 'mt_pre_maintenance_date', TRUE);

        $this->output->add_to_position($this->load->view('frontend/maintaince/previous_odometer_preventive_filling', $data, TRUE), 'maintance_previous_odometer', TRUE);
        
       $this->output->add_to_position($this->load->view('frontend/maintaince/previous_odometer_scrape_filling', $data, TRUE), 'maintance_scrape_odometer', TRUE);
    }


    function registration_visitor() {

        $visitor_data = $this->post['visitor'];
        $prev = generate_maintaince_id('ems_visitor_id');
        $visitor_data['vs_code'] = "AV-".$prev;
        $visitor_data['vs_state_code'] = $this->input->post('incient_state');
        $visitor_data['vs_district_code'] = $this->input->post('incient_district');
        $visitor_data['vs_amb_ref_number'] = $this->input->post('incient_ambulance');
        $visitor_data['vs_base_location'] = $this->input->post('base_location');
        $visitor_data['vs_added_by'] = $this->clg->clg_ref_id;
        $visitor_data['vs_added_date'] = date('Y-m-d H:i:s');
        $visitor_data['vs_modify_by'] = $this->clg->clg_ref_id;
        $visitor_data['vs_modify_date'] = date('Y-m-d H:i:s');
        $visitor_data['vs_is_deleted'] = '0';
        $visitor_data['vs_base_month'] = $this->post['base_month'];

        $register_result = $this->fleet_model->insert_visitor($visitor_data);

        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Visitor Registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->visitor_update();
        }
    }

    function update_visitor() {

        $visitor_data = $this->post['visitor'];
        $visitor_data['vs_state_code'] = $this->input->post('incient_state');
        $visitor_data['vs_district_code'] = $this->input->post('incient_districts');
        $visitor_data['vs_base_location'] = $this->input->post('base_location');
        $visitor_data['vs_modify_by'] = $this->clg->clg_ref_id;
        $visitor_data['vs_modify_date'] = date('Y-m-d H:i:s');
        $visitor_data['vs_amb_ref_number'] = $this->input->post('incient_ambulance');




        $result = $this->fleet_model->visitor_update_data($visitor_data);

        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Visitor Updated Successfully</div>";

            $this->visitor_update();
        }
    }

    function visitor_view() {

        $data = array();

        $data['vs_id'] = base64_decode($this->post['vs_id']);

        $data['action_type'] = 'View Visitor';

        $data['visitor_data'] = $this->fleet_model->get_all_visitor_data($data, $offset, $limit);

        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' =>
            $data['visitor_data'][0]->vs_standard_remark));

        $data['re_name'] = $data1['standard_remark'][0]->re_name;

        $this->output->add_to_position($this->load->view('frontend/fleet/visitor_view', $data, TRUE), $output_position, TRUE);
    }

    function patient_handover_issue() {

        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];


        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        if ($this->post['from_date'] != '') {
            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }


        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        }


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

        $data['total_count'] = $this->fleet_model->get_all_patient_handover_data($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);



        $data['ptn_data'] = $this->fleet_model->get_all_patient_handover_data($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/patient_handover_issue"),
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

        $data['page_records'] = count($data['ptn_data']);


        $this->output->add_to_position($this->load->view('frontend/fleet/patient_handover_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }

    function patient_handover_registrartion() {

        if ($this->post['ph_id'] != '') {

            $data['ph_id'] = $ref_id = base64_decode($this->post['ph_id']);
            $data['ptn_data'] = $this->fleet_model->get_all_patient_handover_data($data, $offset, $limit);
        }


        if ($this->post['action_type'] == 'Update') {


            $data['action_type'] = "Update Patient Handover Issue";
            $data['update'] = 'True';
            $data['type'] = 'Update';

            $this->output->add_to_position($this->load->view('frontend/fleet/patient_handover_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Patient Handover Issue";

            $this->output->add_to_popup($this->load->view('frontend/fleet/patient_handover_view', $data, TRUE), '1200', '500');
        }
    }

    function registration_ptn_handover_issue() {


        $ptn_data = $this->post['ptn'];
        $ptn_data['ph_state_code'] = $this->input->post('incient_state');
        $ptn_data['ph_district_code'] = $this->input->post('incient_districts');
        $ptn_data['ph_amb_ref_no'] = $this->input->post('incient_ambulance');
        $ptn_data['ph_base_location'] = $this->input->post('base_location');
        $ptn_data['ph_pilot_name'] = $this->input->post('pilot_id');
        $ptn_data['ph_emso_name'] = $this->input->post('emt_name');
        $ptn_data['ph_added_by'] = $this->clg->clg_ref_id;
        $ptn_data['ph_added_date'] = date('Y-m-d H:i:s');
        $ptn_data['ph_modify_by'] = $this->clg->clg_ref_id;
        $ptn_data['ph_modify_date'] = date('Y-m-d H:i:s');
        $ptn_data['ph_is_deleted'] = '0';
        $ptn_data['ph_base_month'] = $this->post['base_month'];

        $register_result = $this->fleet_model->insert_patient_handover_issue($ptn_data);

        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Patient Handover Issue Added Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->patient_handover_issue();
        }
    }

    function ptn_handover_view() {

        $data = array();

        $data['ph_id'] = base64_decode($this->post['ph_id']);

        $data['action_type'] = 'View Patient Handover Issue ';

        $data['ptn_data'] = $this->fleet_model->get_all_patient_handover_data($data, $offset, $limit);

        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' =>
            $data['ptn_data'][0]->ph_standard_remark));

        $data['re_name'] = $data1['standard_remark'][0]->re_name;

        $this->output->add_to_position($this->load->view('frontend/fleet/ptn_handover_view', $data, TRUE), $output_position, TRUE);
    }

    function update_ptn_handover_issue() {

        $ptn_data = $this->post['ptn'];

        $ptn_data['ph_modify_by'] = $this->clg->clg_ref_id;
        $ptn_data['ph_modify_date'] = date('Y-m-d H:i:s');
        $ptn_data['ph_date_time'] = date('Y-m-d H:i:s', strtotime($ptn_data['ph_date_time']));
        $ptn_data['is_updated'] = "1";

        $result = $this->fleet_model->patient_handover_update_data($ptn_data);

        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Patient Handover Issue Updated Successfully</div>";

            $this->patient_handover_issue();
        }
    }

    function scene_challenges() {


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
        
        $district_id = "";
if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        $data['amb_district'] = $district_id;


        $data['total_count'] = $this->fleet_model->get_all_scene_challenges_data($data);


        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);


        $data['scene_data'] = $this->fleet_model->get_all_scene_challenges_data($data, $offset, $limit);


        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/scene_challenges"),
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

        $data['page_records'] = count($data['scene_data']);


        $this->output->add_to_position($this->load->view('frontend/fleet/scene_challenges_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }

    function scene_challenges_registrartion() {


        if ($this->post['cs_id'] != '') {

            $data['cs_id'] = $ref_id = base64_decode($this->post['cs_id']);
            $data['scene_data'] = $this->fleet_model->get_all_scene_challenges_data($data, $offset, $limit);
        }


        if ($this->post['action_type'] == 'Update') {


            $data['action_type'] = "Update Scene Challenges";
            $data['update'] = 'True';
            $data['type'] = 'Update';

            $this->output->add_to_position($this->load->view('frontend/fleet/scene_challenges_registration_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Scene Challenges";

            $this->output->add_to_popup($this->load->view('frontend/fleet/scene_challenges_registration_view', $data, TRUE), '1200', '550');
        }
    }

    function registration_scene_challenges() {

        $scene_data = $this->post['scene'];
        $scene_data['cs_state_code'] = $this->input->post('incient_state');
        $scene_data['cs_district_code'] = $this->input->post('incient_districts');
        $scene_data['cs_amb_ref_no'] = $this->input->post('incient_ambulance');
        $scene_data['cs_base_location'] = $this->input->post('base_location');
        $scene_data['cs_pilot_name'] = $this->input->post('pilot_id');
        $scene_data['cs_emso_name'] = $this->input->post('emt_name');
        $scene_data['cs_added_by'] = $this->clg->clg_ref_id;
        $scene_data['cs_added_date'] = date('Y-m-d H:i:s');
        $scene_data['cs_modify_by'] = $this->clg->clg_ref_id;
        $scene_data['cs_modify_date'] = date('Y-m-d H:i:s');
        $scene_data['cs_is_deleted'] = '0';
        $scene_data['cs_base_month'] = $this->post['base_month'];
        $scene_data['cs_pre_date_time'] = date('Y-m-d H:i:s', strtotime($scene_data['cs_pre_date_time']));

        $register_result = $this->fleet_model->insert_scene_challenge($scene_data);

        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'> Scene Challenges Added Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->scene_challenges();
        }
    }

    function update_scene_challeges() {

        $scene_data = $this->post['scene'];

        $scene_data['cs_modify_by'] = $this->clg->clg_ref_id;
        $scene_data['cs_modify_date'] = date('Y-m-d H:i:s');
        $scene_data['cs_date_time'] = date('Y-m-d H:i:s', strtotime($scene_data['cs_date_time']));
        $scene_data['is_updated'] = "1";

        $result = $this->fleet_model->scene_challenges_update_data($scene_data);

        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Scene Challeges Updated Successfully</div>";

            $this->scene_challenges();
        }
    }

    function scene_challenges_view() {

        $data = array();

        $data['cs_id'] = base64_decode($this->post['cs_id']);

        $data['action_type'] = 'View Scene Challeges ';

        $data['scene_data'] = $this->fleet_model->get_all_scene_challenges_data($data, $offset, $limit);

        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' =>
            $data['scene_data'][0]->cs_standard_remark));

        $data['re_name'] = $data1['standard_remark'][0]->re_name;

        $this->output->add_to_position($this->load->view('frontend/fleet/scene_challenges_view', $data, TRUE), $output_position, TRUE);
    }

    function suggestion() {

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


        $data['total_count'] = $this->fleet_model->get_all_suggestions_data($data);


        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);


        $data['sugg_data'] = $this->fleet_model->get_all_suggestions_data($data, $offset, $limit);


        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/suggestion"),
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

        $data['page_records'] = count($data['sugg_data']);


        $this->output->add_to_position($this->load->view('frontend/fleet/suggestion_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }

    function suggestion_registration() {


        if ($this->post['su_id'] != '') {

            $data['su_id'] = $ref_id = base64_decode($this->post['su_id']);
            $data['sugg_data'] = $this->fleet_model->get_all_suggestions_data($data, $offset, $limit);
        }


        if ($this->post['action_type'] == 'Update') {

            $data['action_type'] = "Update Suggestion";
            $data['update'] = 'True';

            $this->output->add_to_position($this->load->view('frontend/fleet/suggestion_registration_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Suggestion";

            $this->output->add_to_popup($this->load->view('frontend/fleet/suggestion_registration_view', $data, TRUE), '1200', '300');
        }
    }

    function registration_suggestions() {

        $sugg_data = $this->post['sugg'];

        $sugg_data['su_added_by'] = $this->clg->clg_ref_id;
        $sugg_data['su_added_date'] = date('Y-m-d H:i:s');
        $sugg_data['su_modify_by'] = $this->clg->clg_ref_id;
        $sugg_data['su_modify_date'] = date('Y-m-d H:i:s');
        $sugg_data['su_is_deleted'] = '0';
        $sugg_data['su_base_month'] = $this->post['base_month'];
        if ($this->post['other_type'] != '') {
            $sugg_data['su_other_type'] = $this->post['other_type'];
        }

        $sugg_data['su_date_time'] = date('Y-m-d H:i:s', strtotime($sugg_data['su_date_time']));

        $register_result = $this->fleet_model->insert_suggestion($sugg_data);

        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Suggestions Added Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->suggestion();
        }
    }

    function update_suggestion_data() {

        $sugg_data = $this->post['sugg'];
        $sugg_data['su_modify_by'] = $this->clg->clg_ref_id;
        $sugg_data['su_modify_date'] = date('Y-m-d H:i:s');

        $result = $this->fleet_model->suggestion_update_data($sugg_data);

        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Suggestion Updated Successfully</div>";

            $this->suggestion();
        }
    }

    function view_suggestion() {

        $data = array();

        $data['su_id'] = base64_decode($this->post['su_id']);

        $data['action_type'] = 'View Suggestion ';

        $data['sugg_data'] = $this->fleet_model->get_all_suggestions_data($data, $offset, $limit);

        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' =>
            $data['sugg_data'][0]->su_standard_remark));

        $data['re_name'] = $data1['standard_remark'][0]->re_name;

        $this->output->add_to_position($this->load->view('frontend/fleet/suggestion_view', $data, TRUE), $output_position, TRUE);
    }

    function demo_training() {


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


        $district_id = "";
if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        $args_dash['amb_district'] = $district_id;
        
        $data['total_count'] = $this->fleet_model->get_all_demo_training_data($data);


        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);


        $data['demo_data'] = $this->fleet_model->get_all_demo_training_data($data, $offset, $limit);


        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/scene_challenges"),
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

        $data['page_records'] = count($data['demo_data']);


        $this->output->add_to_position($this->load->view('frontend/fleet/demo_training_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }

    function demo_training_registrartion() {


        if ($this->post['dt_id'] != '') {

            $data['dt_id'] = $ref_id = base64_decode($this->post['dt_id']);
            $data['demo_data'] = $this->fleet_model->get_all_demo_training_data($data, $offset, $limit);
        }

        if ($this->post['action_type'] == 'Update') {


            $data['action_type'] = "Update Demo Training";
            $data['type'] = "Update";
            $data['update'] = 'True';

            $this->output->add_to_position($this->load->view('frontend/fleet/demo_training_register_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Demo Training";

            $this->output->add_to_popup($this->load->view('frontend/fleet/demo_training_register_view', $data, TRUE), '1200', '550');
        }
    }

    function registration_demo_training() {


        $demo_data = $this->post['demo'];
        $demo_data['dt_state_code'] = $this->input->post('maintaince_state');
        $demo_data['dt_district_code'] = $this->input->post('maintaince_district');
        $demo_data['dt_amb_ref_no'] = $this->input->post('maintaince_ambulance');
        $demo_data['dt_base_location'] = $this->input->post('base_location');
        $demo_data['dt_pilot_name'] = $this->input->post('pilot_id');
        $demo_data['dt_emso_name'] = $this->input->post('emt_name');
        $demo_data['dt_previous_odometer'] = $this->input->post('previous_odometer');
        $demo_data['dt_in_odometer'] = $this->input->post('in_odometer');
        $demo_data['dt_added_by'] = $this->clg->clg_ref_id;
        $demo_data['dt_added_date'] = date('Y-m-d H:i:s');
        $demo_data['dt_modify_by'] = $this->clg->clg_ref_id;
        $demo_data['dt_modify_date'] = date('Y-m-d H:i:s');
        $demo_data['dt_is_deleted'] = '0';
        $demo_data['dt_base_month'] = $this->post['base_month'];
        $demo_data['amb_demo_status'] = 'Stand By';
        $demo_data['dt_start_date_time'] = date('Y-m-d H:i:s', strtotime($demo_data['dt_start_date_time']));


        $register_result = $this->fleet_model->insert_demo_training($demo_data);
        //var_dump($demo_data);die;
        $data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 10,
        );

           //var_dump($data);die; 

        if ($register_result) {
            $update = $this->amb_model->update_amb($data);

            $this->output->status = 1;

            $this->output->message = "<div class='success'> Demo Training Added Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->demo_training();
        }
    }

    function demo_training_view() {

        $data = array();

        $data['dt_id'] = base64_decode($this->post['dt_id']);

        $data['action_type'] = 'View Demo Training ';

        $data['demo_data'] = $this->fleet_model->get_all_demo_training_data($data, $offset, $limit);

        $data1['standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' =>
            $data['demo_data'][0]->dt_standard_remark));

        $data['re_name'] = $data1['standard_remark'][0]->re_name;

        $this->output->add_to_position($this->load->view('frontend/fleet/demo_training_view', $data, TRUE), $output_position, TRUE);
    }

    function update_demo_training() {


        $demo_data = $this->post['demo'];
        $demo_data['dt_modify_by'] = $this->clg->clg_ref_id;
        $demo_data['dt_modify_date'] = date('Y-m-d H:i:s');
        $demo_data['is_updated'] = "1";
        $demo_data['dt_amb_ref_no'] = $this->input->post('amb');
        $demo_data['amb_demo_status'] = 'Available';
//        $demo_data['dt_start_date_time'] = date('Y-m-d H:i:s', strtotime($demo_data['dt_start_date_time']));
        $demo_data['dt_current_date_time'] = date('Y-m-d H:i:s', strtotime($demo_data['dt_current_date_time']));
        $total_km = $this->input->post('demo[dt_end_odometer]') - $this->input->post('start_odometer');

        $result = $this->fleet_model->demo_training_update_data($demo_data);
        //var_dump($this->input->post('amb')); die;
        $data = array(
            'amb_rto_register_no' => $this->input->post('amb'),
            'amb_status' => 1,
        );
        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('amb'),
            'start_odmeter' => $this->input->post('start_odometer'),
            'end_odmeter' => $this->input->post('demo[dt_end_odometer]'),
            'total_km' => $total_km,
            'odometer_type'   => 'update demo training',
            'timestamp' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_off_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_off_remark'];
        }
        $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);

      //var_dump($amb_record_data);die;
     
        if ($result) {
           // $update = $this->amb_model->update_amb($data);

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Demo Training Updated Successfully</div>";

            $this->demo_training();
        }
    }

    function fuel_feeling() {
        ///////////////  Filters //////////////////
        $this->post['base_month'] = get_base_month();
         //var_dump($this->post['base_month']);die;
        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];
        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');
        $current_month_date = $current_year . '-' . $current_month . '-01';
        if ($this->post['from_date'] != '') {
            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }

        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        }

        // if($data['to_date'] != '' && $data['from_date'] != ''){
        //     $data = array('from_date' => $data['from_date'],
        //     'to_date' => $data['to_date'],
        //     'base_month' => $this->post['base_month']);
        // }else{

        //     $data = array('from_date' => date('Y-m-d'),
        //         'to_date' => $current_date,
        //         'base_month' => $this->post['base_month']);
        // }
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
          $data['from_date'] = date('Y-m-01');
        }


        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
        } else {
           $data['to_date'] = date('Y-m-d');
        }
        
        $district_id = "";
if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        $data['amb_district'] = $district_id;


        $data['total_count'] = $this->fleet_model->get_all_fuel_filling_data($data);
       // var_dump($data);die;

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);


        $data['fuel_data'] = $this->fleet_model->get_all_fuel_filling_data($data, $offset, $limit);


        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/fuel_feeling"),
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

        $data['page_records'] = count($data['fuel_data']);


        $this->output->add_to_position($this->load->view('frontend/fleet/fuel_filling_list_view', $data, true), $this->post['output_position'], true);
    }

    function fuel_filling_registrartion() {
//var_dump( $this->post['ff_id']); //var_dump($this->post['ff_id']);
//die;
           
        if ($this->post['ff_id'] != '') {

            $data['ff_id'] = $ref_id = base64_decode($this->post['ff_id']); //var_dump($this->post['ff_id']);
            $data['fuel_data'] = $this->fleet_model->get_all_fuel_filling_data($data, $offset, $limit); //var_dump($data['fuel_data'] );die;
        }

        if ($this->post['action_type'] == 'Update') {
            $data['action_type'] = "Update Fuel Filling";
            $data['type'] = "Update";
            $data['update'] = 'True';
            //$this->output->add_to_position($this->load->view('frontend/fleet/fuel_filling_edit', $data, TRUE), $output_position, TRUE);
            $this->output->add_to_position($this->load->view('frontend/fleet/fuel_filling_register_view', $data, TRUE), $output_position, TRUE);
        } else if ($this->post['action_type'] == 'modify') {
            $data['action_type'] = "Update Fuel Filling";
            $data['type'] = "Update";
            $data['update'] = 'True';
            $this->output->add_to_position($this->load->view('frontend/fleet/fuel_filling_edit', $data, TRUE), $output_position, TRUE);
            //$this->output->add_to_position($this->load->view('frontend/fleet/fuel_filling_register_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Fuel Filling";
            // print_r($data);die;
            $this->output->add_to_popup($this->load->view('frontend/fleet/fuel_filling_register_view', $data, TRUE), '1200', '600');
        }
    }

    function get_fuel_station_address() {

        $data = array(
            'f_id' => $this->post['f_id'],
        );

        $data['fuel_station'] = $this->fleet_model->get_all_fuel_station($data);
        $data['f_id'] = $this->post['f_id'];

        $this->output->add_to_position($this->load->view('frontend/fleet/fuel_station_address_view', $data, TRUE), 'fuel_address', TRUE);

        // $this->output->add_to_position($this->load->view('frontend/fleet/fuel_station_mobile_view', $data, TRUE), 'fuel_mobile_no', TRUE);
    }

    function show_other_remark() {

        $this->output->add_to_position($this->load->view('frontend/fleet/other_remark_textbox_view', $data, TRUE), 'remark_other_textbox', TRUE);
    }

    function show_other_police_type() {

        $this->output->add_to_position($this->load->view('frontend/fleet/show_other_police_type', $data, TRUE), 'other_type_textbox', TRUE);
    }

    function show_other_higher_authority() {

        $this->output->add_to_position($this->load->view('frontend/fleet/other_higher_authority_textbox_view', $data, TRUE), 'higher_authority_other_textbox', TRUE);
    }

//     function registration_fuel_filling() {



//         $fuel_data = $this->post['fuel'];

//         if($state == 'RJ'){
//             $prev= generate_maintaince_id('ems_rj_tyre_id');
//            $prev_id = "FF-".$prev;
//        }else if($state == 'MP'){
//            $prev= generate_maintaince_id('ems_pm_tyre_id');
//            $prev_id = "FF-".$prev;
//        }else{
//            $prev= generate_maintaince_id('ems_tyre_id');
//            $prev_id = "FF-".$prev;
//        }
//         $fuel_data['ff_state_code'] = $this->input->post('incient_state');
//         $fuel_data['ff_gen_id'] = $prev_id;
//         $fuel_data['ff_district_code'] = $this->input->post('incient_district');
//         $fuel_data['ff_amb_ref_no'] = $this->input->post('incient_ambulance');
//         $fuel_data['amb_fuel_status'] = 'Stand By Fuel Filling';
//         $fuel_data['ff_base_location'] = $this->input->post('base_location');
//         $fuel_data['ff_pilot_name'] = $this->input->post('pilot_id');
//         $fuel_data['ff_emso_name'] = $this->input->post('emt_name');
//         $fuel_data['ff_previous_odometer'] = $this->input->post('previous_odometer');
//         $fuel_data['ff_current_odometer'] = $this->input->post('in_odometer');
//         $fuel_data['ff_end_odometer'] = $this->input->post('mt_end_odometer');
//         $fuel_data['ff_fuel_mobile_no'] = $this->input->post('fuel_mobile_no');
//         $fuel_data['ff_fuel_address'] = $this->input->post('fuel_address');
//         $fuel_data['ff_added_by'] = $this->clg->clg_ref_id;
//         $fuel_data['ff_added_date'] = date('Y-m-d H:i:s');
//         $fuel_data['ff_modify_by'] = $this->clg->clg_ref_id;
//         $fuel_data['ff_modify_date'] = date('Y-m-d H:i:s');
//         $fuel_data['ff_is_deleted'] = '0';
//         $fuel_data['ff_base_month'] = $this->post['base_month'];
//         $fuel_data['ff_fuel_date_time'] = date('Y-m-d H:i:s', strtotime($fuel_data['ff_fuel_date_time']));
//         $fuel_data['distance_travelled'] = $this->input->post('fuel[distance_travelled]');    
//         $fuel_data['kmpl'] = $this->input->post('fuel[kmpl]');
        
        
//         if($fuel_data['fuel_filling_case'] == 'fuel_filling_during_case'){
//             $fuel_data['amb_fuel_status'] = 'Available';
//         }else{
//             $fuel_data['amb_fuel_status'] = 'Standby Fuel Filling';
//         }
        
//         if( $this->input->post('other_remark') != ''){
//             $fuel_data['ff_other_remark'] = $this->input->post('other_remark');
//         }    
//        if( $this->input->post('other_fuel_station') != ''){
//             $fuel_data['ff_other_fuel_station'] = $this->input->post('other_fuel_station');
//         }  
//    //var_dump($fuel_data);die;
//         $register_result = $this->fleet_model->insert_fuel_filling($fuel_data);
//         //var_dump($register_result);die;
//         $total_km = $this->input->post('in_odometer') - $this->input->post('previous_odometer');

//         $amb_record_data = array(
//             'amb_rto_register_no' => $this->input->post('incient_ambulance'),
//             'start_odmeter' => $this->input->post('previous_odometer'),
//             'end_odmeter' => $this->input->post('in_odometer'),
//             'total_km' => $total_km,
//             'odometer_type' => 'fuel filling',
//             'timestamp' => date('Y-m-d H:i:s'));
        
//         if($fuel_data['fuel_filling_case'] == 'fuel_filling_during_case'){

//             $amb_record_data['odometer_type'] = 'fuel_filling_during_case';
//         }

//         if ($this->input->post('other_remark') != '') {
//             $amb_record_data['other_remark'] = $this->input->post('other_remark');
//         }
//        // var_dump($amb_record_data);die;
//         $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
//        // var_dump($record_data);die;

//         $amb_update_summary = array(
//             'amb_rto_register_no' => $this->input->post('incient_ambulance'),
//             'amb_status' => 9,
//             'start_odometer' => $this->input->post('in_odometer'),
//             'off_road_status' => "Standby Fuel Filling",
//             'off_road_remark' => $fuel_data['ff_standard_remark'],
//             'off_road_date' => date('Y-m-d', strtotime($fuel_data['ff_fuel_date_time'])),
//             'off_road_time' => date('H:i:s', strtotime($fuel_data['ff_fuel_date_time'])),
//             'added_date' => date('Y-m-d H:i:s'));

//         if ($this->input->post('other_remark') != '') {
//             $amb_update_summary['off_road_remark_other'] = $this->input->post('other_remark');
//         }

//         $add_summary = $this->amb_model->insert_amb_staus_summary($amb_update_summary);
       
//         $data = array(
//             'amb_rto_register_no' => $this->input->post('incient_ambulance'),
//             'amb_status' => 9,
//         );
        
//         if($fuel_data['fuel_filling_case'] != 'fuel_filling_during_case'){
            
//             $update = $this->amb_model->update_amb($data);
//         }
//         //var_dump($update);die;


//         if ($register_result) {

//             $this->output->status = 1;

//             $this->output->message = "<div class='success'> Fuel Filling Added Successfully!</div>";

//             $this->output->closepopup = 'yes';

//             $this->fuel_feeling();
//         }
//     }

function registration_fuel_filling() {
    $fuel_data = $this->post['fuel'];
    // print_r($fuel_data);die;
//    if($state == 'RJ'){
//        $prev= generate_maintaince_id('ems_rj_tyre_id');
//       $prev_id = "FF-".$prev;
//   }else if($state == 'MP'){
//       $prev= generate_maintaince_id('ems_pm_tyre_id');
//       $prev_id = "FF-".$prev;
//   }else{
//       $prev= generate_maintaince_id('ems_tyre_id');
//       $prev_id = "FF-".$prev;
//   }
// print_r($_FILES['nozzle_slip']['name']);die;


// image

if(!empty($_FILES['nozzle_slip']['name'])){
    
        $ext = explode(".", $_FILES['nozzle_slip']['name']);
        $image_name = $randomno.'_'.date('Y_m_d_H_i_s').".".$ext[1];
    
        
                
                

               
                $_FILES['photo']['name']= $_FILES['nozzle_slip']['name'];
                $_FILES['photo']['type']= $_FILES['nozzle_slip']['type'];
                $_FILES['photo']['tmp_name']= $_FILES['nozzle_slip']['tmp_name'];
                $_FILES['photo']['error']= $_FILES['nozzle_slip']['error'];
                $_FILES['photo']['size']= $_FILES['nozzle_slip']['size'];
               // $_FILES['photo']['name'] = date('Y-m-d_H:i:s') .'_'.$_FILES['photo']['name'][$key];
               
              
                $_FILES['photo']['name'] = $image_name;
                
                //array_push($image1,$image);
             
                $rsm_config = $this->nozzle_slip;
                $this->upload->initialize($rsm_config);

                if (!$this->upload->do_upload('photo')) {
                             $msg_p =  $this->upload->display_errors();
                              $this->output->message = "<div class='error'>$msg_p .. Please upload again..!</div>";
                            $upload_err = TRUE;
                            return;
                }
              
                if (!$upload_err) {
                    $this->output->message = "<div class='success'>Image uploaded successfully..!</div>"; 
                    $fuel_data['ff_nozzle_image'] = "assets/images/nozzle_slip/" . $image_name; 
                }

            
}

//
    $prev = str_replace('-', '', date('Y-m-d'));
    $prev1 = str_replace(':', '', date('H:i:s'));
  
    $prev_id = "FF-".$prev.'0'.$prev1;
    //$prev_id = 'FF-202210070115539';
     
   $fuel_data['ff_state_code'] = $this->input->post('incient_state');
   $fuel_data['ff_gen_id'] = $prev_id;
   $fuel_data['ff_district_code'] = $this->input->post('incient_district');
   $fuel_data['ff_amb_ref_no'] = $this->input->post('incient_ambulance');
   $fuel_data['amb_fuel_status'] = 'Stand By Fuel Filling';
   $fuel_data['ff_base_location'] = $this->input->post('base_location');
   $fuel_data['ff_pilot_name'] = $this->input->post('pilot_id');
   $fuel_data['ff_emso_name'] = $this->input->post('emt_name');
   $fuel_data['ff_previous_odometer'] = $this->input->post('previous_odometer');
   $fuel_data['ff_current_odometer'] = $this->input->post('in_odometer');
   $fuel_data['ff_end_odometer'] = $this->input->post('mt_end_odometer');
   $fuel_data['ff_gps_odometer'] = $this->input->post('gps_odmeter');
   $fuel_data['ff_fuel_mobile_no'] = $fuel_data['ff_fuel_mobile_no'];
   $fuel_data['ff_fuel_address'] = $fuel_data['ff_fuel_address'];
   $fuel_data['ff_added_by'] = $this->clg->clg_ref_id;
   $fuel_data['ff_added_date'] = date('Y-m-d H:i:s');
   $fuel_data['ff_modify_by'] = $this->clg->clg_ref_id;
   $fuel_data['ff_modify_date'] = date('Y-m-d H:i:s');
   $fuel_data['ff_is_deleted'] = '0';
   $fuel_data['ff_base_month'] = $this->post['base_month'];
   $fuel_data['ff_fuel_date_time'] = date('Y-m-d H:i:s', strtotime($fuel_data['ff_fuel_date_time']));
   $fuel_data['distance_travelled'] = $this->input->post('fuel[distance_travelled]');    
   $fuel_data['kmpl'] = $this->input->post('fuel[kmpl]');
    // print_r($fuel_data);die;
    
    if($fuel_data['fuel_filling_case'] == 'fuel_filling_during_case'){
        $fuel_data['amb_fuel_status'] = 'Available';
        $fuel_data['is_updated'] = '1';
    }else{
        $fuel_data['amb_fuel_status'] = 'Standby Fuel Filling';
    }
    
    if( $this->input->post('other_remark') != ''){
        $fuel_data['ff_other_remark'] = $this->input->post('other_remark');
    }    
   if( $this->input->post('other_fuel_station') != ''){
        $fuel_data['ff_other_fuel_station'] = $this->input->post('other_fuel_station');
    }  
    //var_dump($fuel_data);die;
    
    $register_result = $this->fleet_model->insert_fuel_filling($fuel_data);
    //var_dump($register_result);die;
    $total_km = $this->input->post('in_odometer') - $this->input->post('previous_odometer');

    $amb_record_data = array(
        'amb_rto_register_no' => $this->input->post('incient_ambulance'),
        'start_odmeter' => $this->input->post('previous_odometer'),
        'end_odmeter' => $this->input->post('in_odometer'),
        'total_km' => $total_km,
        'odometer_type' => 'fuel filling',
        'timestamp' => date('Y-m-d H:i:s'));
    
    if($fuel_data['fuel_filling_case'] == 'fuel_filling_during_case'){

        $amb_record_data['odometer_type'] = 'fuel_filling_during_case';
    }

    if ($this->input->post('other_remark') != '') {
        $amb_record_data['other_remark'] = $this->input->post('other_remark');
    }
   // var_dump($amb_record_data);die;
    
    $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
   // var_dump($record_data);die;

    $amb_update_summary = array(
        'amb_rto_register_no' => $this->input->post('incient_ambulance'),
        'amb_status' => 9,
        'start_odometer' => $this->input->post('in_odometer'),
        'off_road_status' => "Standby Fuel Filling",
        'off_road_remark' => $fuel_data['ff_standard_remark'],
        'off_road_date' => date('Y-m-d', strtotime($fuel_data['ff_fuel_date_time'])),
        'off_road_time' => date('H:i:s', strtotime($fuel_data['ff_fuel_date_time'])),
        'added_date' => date('Y-m-d H:i:s'));

    if ($this->input->post('other_remark') != '') {
        $amb_update_summary['off_road_remark_other'] = $this->input->post('other_remark');
    }

    $add_summary = $this->amb_model->insert_amb_staus_summary($amb_update_summary);
   
    $data = array(
        'amb_rto_register_no' => $this->input->post('incient_ambulance'),
        'amb_status' => 9,
    );
    
    if($fuel_data['fuel_filling_case'] != 'fuel_filling_during_case'){
        
        $update = $this->amb_model->update_amb($data);
    }
    //var_dump($update);die;


    if ($register_result) {
        $this->output->status = 1;

        $this->output->message = "<div class='success'> Fuel Filling Added Successfully!</div>";

        $this->output->closepopup = 'yes';

        $this->fuel_feeling();
    }
}

    function fuel_filling_view() {

        $data = array();

        $data['ff_id'] = base64_decode($this->post['ff_id']);

        $data['action_type'] = 'View Fuel Filling ';

        $data['fuel_data'] = $this->fleet_model->get_all_fuel_filling_data($data, $offset, $limit);

        $this->output->add_to_position($this->load->view('frontend/fleet/fuel_filling_view', $data, TRUE), $output_position, TRUE);
    }

    function modify_fuel_filling() {
    //    print_r($_POST);die;
        $fuel_data = $this->post['fuel'];
        // $fuel_stat = $this->input->post('ff_fuel_station');
        // print_r($fuel_data);die;
        $fuel_data['ff_gen_id'] = $fuel_data['ff_gen_id'];
        $fuel_data['ff_modify_by'] = $this->clg->clg_ref_id;
        $fuel_data['is_updated'] = "1";
        $fuel_data['amb_fuel_status'] = 'Available';
        $fuel_data['ff_modify_date'] = date('Y-m-d H:i:s');
        $fuel_data['ff_current_odometer'] = $fuel_data['ff_current_odometer'];
        $fuel_data['ff_fuel_mobile_no'] = $fuel_data['ff_fuel_mobile_no'];
        $fuel_data['ff_previous_odometer'] = $fuel_data['ff_previous_odometer'];
        $fuel_data['ff_end_odometer'] = $fuel_data['ff_end_odometer'];
        $fuel_data['ff_fuel_previous_odometer'] = $fuel_data['ff_fuel_previous_odometer'];
        $fuel_data['ff_amb_ref_no'] = $fuel_data['ff_amb_ref_no'];
        $fuel_data['distance_travelled'] = $fuel_data['distance_travelled'];    
        $fuel_data['kmpl'] = $fuel_data['kmpl'];
        $fuel_data['ff_fuel_station'] = $fuel_data['ff_fuel_station']; 
        $fuel_data['ff_fuel_address'] = $fuel_data['ff_fuel_address']; 
        $fuel_data['fuel_filling_case'] = $fuel_data['fuel_filling_case'];
        // print_r($fuel_data);die;
        $result = $this->fleet_model->fuel_filling_update_data($fuel_data);
        $total_km = $fuel_data['ff_current_odometer'] - $fuel_data['ff_fuel_previous_odometer'];
        if($fuel_data['fuel_filling_case'] == 'fuel_filling_during_case'){
            $fuel_data['amb_fuel_status'] = 'Available';
            $fuel_data['is_updated'] = '1';
        }else if($fuel_data['fuel_filling_case'] == 'fuel_filling_without_case'){
            $fuel_data['amb_fuel_status'] = 'Standby Fuel Filling';
        }
        $register_result = $this->fleet_model->fuel_filling_modify_data($fuel_data);
        // print_r($fuel_data);die;
        $amb_record_data = array(
            'amb_rto_register_no' => $fuel_data['ff_amb_ref_no'],
            'start_odmeter' => $fuel_data['ff_fuel_previous_odometer'],
            // 'end_odmeter' =>  $fuel_data['ff_current_odometer'],
            'total_km' => $total_km,
            'odometer_type'   => 'Update fuel filling',
            'modify_by' => $this->clg->clg_ref_id,
            'timestamp' => date('Y-m-d H:i:s'),
            'remark' => $fuel_data['ff_case_type_remark'],
            'end_odmeter' => $fuel_data['ff_end_odometer']);
            // print_r($amb_record_data);die;
        // if (!empty($maintaince_data['mt_off_remark'])) {
        //     $amb_record_data['other_remark'] = $maintaince_data['mt_off_remark'];
        // }
        $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
        $amb_update_summary = array(
            'amb_rto_register_no' => $fuel_data['ff_amb_ref_no'],
            'amb_status' => '9,1',
            'end_odometer' => $fuel_data['end_odometer'],
            'on_road_status' => "Update Fuel filling",
            // 'on_road_remark' => $fuel_data['mt_on_stnd_remark'],
            'on_road_date' => date('Y-m-d', strtotime($fuel_data['ff_fuel_date_time'])),
            'on_road_time' => date('H:i:s', strtotime($fuel_data['ff_fuel_date_time'])),
            'added_date' => date('Y-m-d H:i:s'));
            // print_r($amb_update_summary);die;
        // if (!empty($fuel_data['mt_on_remark'])) {
        //     $amb_update_summary['on_road_remark_other'] = $fuel_data['mt_on_remark'];
        // }
        // $add_summary = $this->amb_model->insert_amb_staus_summary($amb_update_summary);
        $data = array(
            'amb_rto_register_no' => $fuel_data['ff_amb_ref_no'],
            'amb_status' => 1,
        );
        $off_road_status = "Standby Fuel filling";

        $add_summary = $this->amb_model->update_ambulance_staus_summary($amb_update_summary, $off_road_status);
        // $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
        
        //$update = $this->amb_model->update_amb($data);

        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Fuel Filling Updated Successfully</div>";

            $this->fuel_feeling_modify();
        }
    }
    function update_fuel_filling() {
       
        $fuel_data = $this->post['fuel'];
        // print_r($this->input->post('mt_end_odometer'));
        $fuel_data['ff_id'] = $fuel_data['ff_id'];
        $fuel_data['ff_modify_by'] = $this->clg->clg_ref_id;
        $fuel_data['is_updated'] = "1";
        $fuel_data['amb_fuel_status'] = 'Available';
        $fuel_data['ff_modify_date'] = date('Y-m-d H:i:s');
        $fuel_data['ff_end_odometer'] = $this->input->post('mt_end_odometer');
        // print_r($fuel_data);die;
        $fuel_data['ff_on_road_ambulance'] = date('Y-m-d H:i:s', strtotime($fuel_data['ff_on_road_ambulance']));
        // if($fuel_data['ff_end_odometer'] != ''){
        //     $fuel_data['ff_end_odometer'] = $fuel_data['ff_end_odometer'];
        // }
        // else if($fuel_data['ff_current_odometer'] != ''){
        // $fuel_data['ff_current_odometer'] = $fuel_data['ff_current_odometer'];
        // }
        // print_r($fuel_data);die;
        $result = $this->fleet_model->fuel_filling_update_data($fuel_data);

        $total_km = $this->input->post('mt_end_odometer') - $this->input->post('previos_odometer');

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previos_odometer'),
            'end_odmeter' => $this->input->post('mt_end_odometer'),
            'total_km' => $total_km,
            'odometer_type'   => 'Update fuel filling',
            'timestamp' => date('Y-m-d H:i:s'));

        if (!empty($maintaince_data['mt_off_remark'])) {
            $amb_record_data['other_remark'] = $maintaince_data['mt_off_remark'];
        }

        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => '9,1',
            'end_odometer' => $this->input->post('mt_end_odometer'),
            'on_road_status' => "Update Fuel filling",
            'on_road_remark' => $fuel_data['mt_on_stnd_remark'],
            'on_road_date' => date('Y-m-d', strtotime($fuel_data['ff_on_road_ambulance'])),
            'on_road_time' => date('H:i:s', strtotime($fuel_data['ff_on_road_ambulance'])),
            'added_date' => date('Y-m-d H:i:s'));
         
        if (!empty($fuel_data['mt_on_remark'])) {
            $amb_update_summary['on_road_remark_other'] = $fuel_data['mt_on_remark'];
        }

        $data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
        );
        $off_road_status = "Standby Fuel filling";

        $add_summary = $this->amb_model->update_ambulance_staus_summary($amb_update_summary, $off_road_status);
        $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);
       // var_dump($add_summary);die;
        //$update = $this->amb_model->update_amb($data);

        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Fuel Filling Updated Successfully</div>";

            $this->fuel_feeling_modify();
        }
    }
    function oxygen_feeling() {


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
//
//        $data['to_date'] = date('Y-m-d');
//        $data['from_date'] = date('Y-m-d');


        if ($this->post['from_date'] != '') {

            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date']));
        } else {

           $data['from_date'] = date('Y-m-01');
        }


        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
        } else {
            $data['to_date'] = date('Y-m-d');
        }
        
        $district_id = "";
if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        $data['amb_district'] = $district_id;


        $data['total_count'] = $this->fleet_model->get_all_oxygen_filling_data($data);

//var_dump($data);die;
        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);


        $data['oxygen_data'] = $this->fleet_model->get_all_oxygen_filling_data($data, $offset, $limit);


        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/oxygen_feeling"),
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

        $data['page_records'] = count($data['oxygen_data']);


        $this->output->add_to_position($this->load->view('frontend/fleet/oxygen_filling_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }

    function oxygen_filling_registrartion() {


        if ($this->post['of_id'] != '') {

            $data['of_id'] = $ref_id = base64_decode($this->post['of_id']); //var_dump($this->post['of_id']);die;
            $data['oxygen_data'] = $this->fleet_model->get_all_oxygen_filling_data($data, $offset, $limit);
        }

        if ($this->post['action_type'] == 'Update') {


            $data['action_type'] = "Update Oxygen Filling";
            $data['type'] = "Update";
            $data['update'] = 'True';

            $this->output->add_to_position($this->load->view('frontend/fleet/oxygen_filling_register_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Oxygen Filling";

            $this->output->add_to_popup($this->load->view('frontend/fleet/oxygen_filling_register_view', $data, TRUE), '1200', '600');
        }
    }

    function registration_oxygen_filling() {



        $oxygen_data = $this->post['oxygen'];
        $oxygen_data['of_state_code'] = $this->input->post('incient_state');
        $oxygen_data['of_district_code'] = $this->input->post('incient_districts');
        $oxygen_data['of_amb_ref_no'] = $this->input->post('incient_ambulance');
        $oxygen_data['amb_oxygen_status'] = 'Stand By Oxygen Filling';
        $oxygen_data['of_base_location'] = $this->input->post('base_location');
        $oxygen_data['of_prevoius_odometer'] = $this->input->post('previous_odometer');
        $oxygen_data['of_in_odometer'] = $this->input->post('in_odometer');
        $oxygen_data['of_added_by'] = $this->clg->clg_ref_id;
        $oxygen_data['of_added_date'] = date('Y-m-d H:i:s');
        $oxygen_data['of_modify_by'] = $this->clg->clg_ref_id;
        $oxygen_data['of_modify_date'] = date('Y-m-d H:i:s');
        $oxygen_data['of_is_deleted'] = '0';
        $oxygen_data['of_base_month'] = $this->post['base_month'];
        //$oxygen_data['of_card_date'] = date('Y-m-d H:i:s', strtotime($oxygen_data['of_card_date']));
        $oxygen_data['of_card_date'] = $oxygen_data['of_card_date'];
        $oxygen_data['of_filling_date'] = date('Y-m-d H:i:s', strtotime($oxygen_data['of_filling_date']));
        $oxygen_data[ 'of_pilot_name'] = $this->input->post('pilot_id');
        
        if($oxygen_data['oxygen_filling_case'] == 'oxygen_filling_during_case'){
            $oxygen_data['amb_oxygen_status'] = 'Available';
        }else{
            $oxygen_data['amb_oxygen_status'] = 'Stand By Oxygen Filling';
        }

       // var_dump($oxygen_data);die;
        $register_result = $this->fleet_model->insert_oxgen_filling($oxygen_data);

        $total_km = $this->input->post('in_odometer') - $this->input->post('previous_odometer');

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('incient_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
            'end_odmeter' => $this->input->post('in_odometer'),
            'total_km' => $total_km,
            'odometer_type' => 'oxygen filling',
            'timestamp' => date('Y-m-d H:i:s'));

        if ($this->input->post('other_remark') != '') {
            $amb_record_data['other_remark'] = $this->input->post('other_remark');
        }
        if($oxygen_data['oxygen_filling_case'] == 'oxygen_filling_during_case'){
            $amb_record_data['odometer_type'] = 'oxygen_filling_during_case';
        }
        $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);


        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('incient_ambulance'),
            'amb_status' => 8,
            'start_odometer' => $this->input->post('in_odometer'),
            'off_road_status' => "Standby Oxygen Filling",
            'off_road_remark' => $oxygen_data['of_standard_remark'],
            'off_road_date' => date('Y-m-d', strtotime($oxygen_data['of_filling_date'])),
            'off_road_time' => date('H:i:s', strtotime($oxygen_data['of_filling_date'])),
            'added_date' => date('Y-m-d H:i:s'));

        if ($this->input->post('other_remark') != '') {
            $amb_update_summary['off_road_remark_other'] = $this->input->post('other_remark');
        }

        $add_summary = $this->amb_model->insert_amb_staus_summary($amb_update_summary);

        $data = array(
            'amb_rto_register_no' => $this->input->post('incient_ambulance'),
            'amb_status' => 8,
        );
        
        if($oxygen_data['oxygen_filling_case'] != 'oxygen_filling_during_case'){
            $update = $this->amb_model->update_amb($data);
        }
       



        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'> Oxygen Filling Added Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->oxygen_feeling();
        }
    }

    function oxygen_filling_view() {


        $data = array();

        $data['of_id'] = base64_decode($this->post['of_id']);

        $data['action_type'] = 'View oxygen Filling ';

        $data['oxygen_data'] = $this->fleet_model->get_all_oxygen_filling_data($data, $offset, $limit);

        $this->output->add_to_position($this->load->view('frontend/fleet/oxygen_filling_view', $data, TRUE), $output_position, TRUE);
    }

    function update_oxygen_filling() {

        $oxygen_data = $this->post['oxygen'];
        $oxygen_data['of_modify_by'] = $this->clg->clg_ref_id;
        $oxygen_data['of_modify_date'] = date('Y-m-d H:i:s');
        $oxygen_data['is_updated'] = "1";
        $oxygen_data['amb_oxygen_status'] = 'Available';
        $oxygen_data['of_on_road_ambulance'] = date('Y-m-d H:i:s', strtotime($oxygen_data['of_on_road_ambulance']));
        $oxygen_data['of_end_odometer'] = $this->input->post('mt_end_odometer');
        $result = $this->fleet_model->oxygen_filling_update_data($oxygen_data);
        $total_km = $this->input->post('mt_end_odometer') - $this->input->post('previos_odometer');

        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previos_odometer'),
            'end_odmeter' => $this->input->post('mt_end_odometer'),
            'total_km' => $total_km,
            'odometer_type' => 'update oxygen filling',
            'timestamp' => date('Y-m-d H:i:s'));

        if (!empty($oxygen_data['mt_off_remark'])) {
            $amb_record_data['other_remark'] = $oxygen_data['mt_off_remark'];
        }

        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => '8,1',
            'end_odometer' => $this->input->post('mt_end_odometer'),
            'on_road_status' => "Oxygen filling  on road",
            'on_road_remark' => $oxygen_data['mt_on_stnd_remark'],
            'on_road_date' => date('Y-m-d', strtotime($oxygen_data['of_on_road_ambulance'])),
            'on_road_time' => date('H:i:s', strtotime($oxygen_data['of_on_road_ambulance'])),
            'added_date' => date('Y-m-d H:i:s'));

        if (!empty($oxygen_data['mt_on_remark'])) {
            $amb_update_summary['on_road_remark_other'] = $oxygen_data['mt_on_remark'];
        }

        $data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
        );
        $off_road_status = "Standby Oxygen Filling";

        $add_summary = $this->amb_model->update_ambulance_staus_summary($amb_update_summary, $off_road_status);
        $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);

        //$update = $this->amb_model->update_amb($data);

        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Oxygen Filling Updated Successfully</div>";

            $this->oxygen_feeling();
        }
    }

    function vehicle_location_change() {


        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];


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

        $data['total_count'] = $this->fleet_model->get_all_vehical_location_data($data);


        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);


        $data['vehical_data'] = $this->fleet_model->get_all_vehical_location_data($data, $offset, $limit);


        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/vehicle_location_change"),
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

        $data['page_records'] = count($data['vehical_data']);


        $this->output->add_to_position($this->load->view('frontend/fleet/vehical_location_change_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }

    function vehical_location_change_registrartion() {

        if ($this->post['vl_id'] != '') {

            $data['vl_id'] = $ref_id = base64_decode($this->post['vl_id']);
            $data['vehical_data'] = $this->fleet_model->get_all_vehical_location_data($data, $offset, $limit);
        }

        if ($this->post['action_type'] == 'Update') {


            $data['action_type'] = "Update Vehicle location Change";
            $data['type'] = "Update";
            $data['update'] = 'True';

            $this->output->add_to_position($this->load->view('frontend/fleet/vehical_location_chnage_register_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Vehicle Location Change";

            $this->output->add_to_popup($this->load->view('frontend/fleet/vehical_location_chnage_register_view', $data, TRUE), '1200', '400');
        }
    }

    function registration_vehical_location_change() {


        $vehical_data = $this->post['vehical'];
        $vehical_data['vl_pilot_name'] = $this->input->post('pilot_id');
        $vehical_data['vl_state_code'] = $this->input->post('incient_state');
        $vehical_data['vl_district_code'] = $this->input->post('incient_districts');
        $vehical_data['vl_amb_ref_no'] = $this->input->post('incient_ambulance');
        $vehical_data['amb_vechicle_status'] = 'Stand By';
        $vehical_data['vl_base_location'] = $this->input->post('base_location');
        $vehical_data['vl_previous_odometer'] = $this->input->post('previous_odometer');
        $vehical_data['vl_in_odometer'] = $this->input->post('in_odometer');
        $vehical_data['vl_added_by'] = $this->clg->clg_ref_id;
        $vehical_data['vl_added_date'] = date('Y-m-d H:i:s');
        $vehical_data['vl_modify_by'] = $this->clg->clg_ref_id;
        $vehical_data['vl_modify_date'] = date('Y-m-d H:i:s');
        $vehical_data['vl_is_deleted'] = '0';
        //$vehical_data['vl_base_month'] = $this->post['base_month'];
        $vehical_data['vl_expecteed_date_time'] = date('Y-m-d H:i:s', strtotime($vehical_data['vl_expecteed_date_time']));



        $register_result = $this->fleet_model->insert_vehical_location_change($vehical_data);
        //var_dump($register_result);
        

        $total_km = $this->input->post('in_odometer') - $this->input->post('previous_odometer');
//die();
        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('incient_ambulance'),
            'start_odmeter' => $this->input->post('previous_odometer'),
            'end_odmeter' => $this->input->post('in_odometer'),
            'total_km' => $total_km,
            'odometer_type' => 'vehical location change',
            'timestamp' => date('Y-m-d H:i:s'));

        if ($this->input->post('other_remark') != '') {
            $amb_record_data['other_remark'] = $this->input->post('other_remark');
        }
        $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);


        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('incient_ambulance'),
            'amb_status' => 9,
            'start_odometer' => $this->input->post('in_odometer'),
            'off_road_status' => "location change",
            'off_road_remark' => $vehical_data['vl_standard_remark'],
            'off_road_date' => date('Y-m-d', strtotime($vehical_data['vl_expecteed_date_time'])),
            'off_road_time' => date('H:i:s', strtotime($vehical_data['vl_expecteed_date_time'])),
            'added_date' => date('Y-m-d H:i:s'));

        if ($this->input->post('other_remark') != '') {
            $amb_update_summary['off_road_remark_other'] = $this->input->post('other_remark');
        }

        $add_summary = $this->amb_model->insert_amb_staus_summary($amb_update_summary);

        $data = array(
            'amb_id' => $this->input->post('incient_ambulance'),
            'amb_status' => 9,
        );
        $update = $this->amb_model->update_amb($data);



        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'> Vehival Location Change Added Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->vehicle_location_change();
        }
    }

    function update_vehical_location() {

        $vehical_data = $this->post['vehical'];
        $vehical_data['vl_modify_by'] = $this->clg->clg_ref_id;
        $vehical_data['is_updated'] = "1";
        $vehical_data['amb_vechicle_status'] = "Available";
        $vehical_data['vl_modify_date'] = date('Y-m-d H:i:s');
        $vehical_data['vl_on_road_ambulance'] = date('Y-m-d H:i:s', strtotime($vehical_data['vl_on_road_ambulance']));


        $vehical_data['vl_end_odometer'] = $this->input->post('vl_end_odometer');

        $result = $this->fleet_model->vehical_location_update_data($vehical_data);



        $total_km = (int)$this->input->post('vl_end_odometer') - (int)$this->input->post('previos_odometer');
              
        $amb_record_data = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'start_odmeter' => $this->input->post('previos_odometer'),
            'end_odmeter' => $this->input->post('vl_end_odometer'),
            'total_km' => $total_km,
            'odometer_type' => 'vehical location change',
            'timestamp' => date('Y-m-d H:i:s'));

        if (!empty($vehical_data['vl_off_remark'])) {
            $amb_record_data['other_remark'] = $vehical_data['vl_off_remark'];
        }

        $amb_update_summary = array(
            'amb_rto_register_no' => $this->input->post('maintaince_ambulance'),
            'amb_status' => '4,1',
            'end_odometer' => $this->input->post('vl_end_odometer'),
            'on_road_status' => "Vehical on road",
            'on_road_remark' => $vehical_data['vl_on_stnd_remark'],
            'on_road_date' => date('Y-m-d', strtotime($vehical_data['vl_on_road_ambulance'])),
            'on_road_time' => date('H:i:s', strtotime($vehical_data['vl_on_road_ambulance'])),
            'added_date' => date('Y-m-d H:i:s'));

        if (!empty($vehical_data['vl_on_remark'])) {
            $amb_update_summary['on_road_remark_other'] = $vehical_data['vl_on_remark'];
        }

        $data = array(
            'amb_id' => $this->input->post('maintaince_ambulance'),
            'amb_status' => 1,
        );
        $off_road_status = "Location Chnage";

        $add_summary = $this->amb_model->update_ambulance_staus_summary($amb_update_summary, $off_road_status);
        $record_data = $this->amb_model->insert_amb_timestamp_record($amb_record_data);

        //$update = $this->amb_model->update_amb($data);

        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Vehical location Updated Successfully</div>";

            $this->vehicle_location_change();
        }
    }

    function vehical_change_view() {


        $data = array();

        $data['vl_id'] = base64_decode($this->post['vl_id']);

        $data['action_type'] = 'View Vehicle Location Change ';

        $data['vehical_data'] = $this->fleet_model->get_all_vehical_location_data($data, $offset, $limit);

        $this->output->add_to_position($this->load->view('frontend/fleet/vehical_change_view', $data, TRUE), $output_position, TRUE);
    }

    function indent_request() {


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

        $data['req_group'] = 'IND';

        $data['clg'] = $this->colleagues_model->get_type_level($args);


        $data['group_info'] = $this->colleagues_model->get_higher_groups('', $data['clg'][0]->g_type_level);


        $data['total_count'] = $this->fleet_model->get_all_indent_item($data);


        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);


        $data['indent_data'] = $this->fleet_model->get_all_indent_item($data,$offset,$limit);
       // die();

        $data['clg_group'] = trim($this->clg->clg_group);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/indent_request"),
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


        $this->output->add_to_position($this->load->view('frontend/fleet/indent_request_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }

    function indent_request_registrartion() {


        if ($this->post['of_id'] != '') {

            $data['of_id'] = $ref_id = base64_decode($this->post['of_id']);
            $data['oxygen_data'] = $this->fleet_model->get_all_oxygen_filling_data($data, $offset, $limit);
        }

        if ($this->post['action'] == 'Update') {


            $data['action_type'] = "Update Indent Request";
            $data['type'] = "Update";
            $data['update'] = 'True';
            
            if ($this->post['req_id'] != '') {
                $data['req_id'] = $ref_id = $this->post['req_id'];
                $data['indent_data'] = $this->fleet_model->get_all_indent_item($data, $offset, $limit);
            }

            $data1['req_id'] = $this->post['req_id'];

            $data['result'] = $this->ind_model->get_indent_data($data1);

            $this->output->add_to_position($this->load->view('frontend/fleet/indent_request_register_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Indent Request";

            $this->output->add_to_popup($this->load->view('frontend/fleet/indent_request_register_view', $data, TRUE), '1500', '500');
           $this->output->add_to_position('<script>reset_mi_cookie();</script>', 'custom_script', TRUE);

        }
    }

    function register_indent_request() {

        $item_key = array('CA', 'NCA', 'MED', 'EQP');

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

            $emt_id = $this->clg->clg_ref_id;
        //}

        $ind_data = $this->post['ind'];

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
            'req_district_manager' => $ind_data['req_district_manager'],
            'req_standard_remark' => $ind_data['req_standard_remark'],
          //  'req_supervisor' => $ind_data['req_supervisor'],
            'req_isdeleted' => '0',
        );

        if ($ind_data['req_other_remark'] != '') {
            $args['req_other_remark'] = $ind_data['req_other_remark'];
        }

        $req = $this->ind_model->insert_ind_req($args);

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


                        $result = $this->ind_model->insert_ind($ind_data);
                    }
                }
            }
        }

        if ($result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Indent request submit successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->indent_request();
        }
    }
    
    function edit_indent_request() {
        
        
        if ($this->post['ind_opt']) {


            $req_type = $this->post['req_type'];

            foreach ($this->post['in_qty'] as $ind_id => $qty) {

                $args = array(
                    'ind_id' => $ind_id,
                );


                $data = array(
                    'ind_quantity' => $qty,
                    'ind_req_id' => $this->post['ind_req_id']
                );

                $this->ind_model->update_ind_item($args, $data);


                /////////////////////////////////////////////////////////

                $ind_data = $this->ind_model->get_ind_data($args);


            }


            /////////////////////////////////////////////////////////

            $ind_data = $this->post['eqiup'];

//            $args = array(
//                'req_id' => $this->post['ind_req_id'],
//                'req_dis_by' => $this->clg->clg_ref_id,
//                'req_dis_date' => $this->today,
//                'req_dispatch_date_time' => date('Y-m-d H:i:s', strtotime($ind_data['req_dispatch_date_time'])),
//                'req_dispatch_remark' => $ind_data['req_dispatch_remark']
//            );
//
//
//            $req = $this->ind_model->update_ind_req($args);


            /////////////////////////////////////////////////////

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<h3>Update Items</h3><br><p>Items Update successfully</p>";

            $this->indent_request();
        }
    }

    function approve_ind() {

        $req_type = $this->post['req_type'];

        $args = array(
            'req_id' => $this->post['req_id'],
            'req_is_approve' => '1',
            'req_apr_date_time' => date('Y-m-d H:i:s', strtotime($req_type['req_apr_date_time'])),
            'req_approve_remark' => $req_type['req_approve_remark']
        );


        $req = $this->ind_model->update_ind_req($args);
        $this->output->status = 1;
        $this->output->message = "<p>Items Approved Successfully</p>";
        $this->output->closepopup = 'yes';


        $this->indent_approve();
    }

    function dispatch_ambulance() {

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

            $ind_data = $this->post['eqiup'];

            $args = array(
                'req_id' => $this->post['ind_req_id'],
                'req_dis_by' => $this->clg->clg_ref_id,
                'req_dis_date' => $this->today,
                'req_dispatch_date_time' => date('Y-m-d H:i:s', strtotime($ind_data['req_dispatch_date_time'])),
                'req_dispatch_remark' => $ind_data['req_dispatch_remark']
            );


            $req = $this->ind_model->update_ind_req($args);


            /////////////////////////////////////////////////////

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<h3>Dispatch Items</h3><br><p>Items dispatched successfully</p>";

            $this->indent_dispatch();
        }
    }

    function receive_quantity() {

        if ($this->post['ind_opt']) {

            $req_type = $this->post['eqiup'];

            $args = array(
                'req_id' => $this->post['ind_req_id'],
                'req_rec_by' => $this->clg->clg_ref_id,
                'req_rec_date' => $this->today,
                'req_receive_date_time' => date('Y-m-d H:i:s', strtotime($req_type['req_receive_date_time'])),
                'req_receive_remark' => $req_type['req_receive_remark']
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
                
                //die();

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

            $this->indent_request();
        }
    }

    function indent_approve() {


        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];

        if ($this->post['from_date'] != '') {
            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }else{
             $data['from_date'] = $this->fdata['from_date'];
        }

        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        }else{
            $data['to_date'] = $this->fdata['to_date'];
        }
        
        $ambflt['IND_APP'] = $data;

        $this->session->set_userdata('ind_filters', $ambflt);


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

//            $data['from_date'] = date('Y-m-d');
        }

        $args = array(
            'clg_group' => 'UG-DM'
        );

        $data['req_group'] = 'IND';

        $data['clg'] = $this->colleagues_model->get_type_level($args);


        $data['group_info'] = $this->colleagues_model->get_higher_groups('', $data['clg'][0]->g_type_level);

        $data['req_is_approve'] = '0';
        
        
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        $data['amb_district'] = $district_id;

        $data['total_count'] = $this->fleet_model->get_all_indent_item($data);


        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);


        $data['indent_data'] = $this->fleet_model->get_all_indent_item($data,$offset,$limit);

        $data['clg_group'] = trim($this->clg->clg_group);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/indent_request"),
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


        $this->output->add_to_position($this->load->view('frontend/fleet/indent_approve_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }

    function indent_dispatch() {


        ///////////////  Filters //////////////////

        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];

        if ($this->post['from_date'] != '') {
            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }else{
             $data['from_date'] = $this->fdata['from_date'];
        }

        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        }else{
            $data['to_date'] = $this->fdata['to_date'];
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
            //$data['from_date'] = date('Y-m-d');
        }

        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
        } else {
            //$data['from_date'] = date('Y-m-d');
        }

        $args = array(
            'clg_group' => 'UG-DM'
        );

        $data['req_group'] = 'IND';

        $data['clg'] = $this->colleagues_model->get_type_level($args);


        $data['group_info'] = $this->colleagues_model->get_higher_groups('', $data['clg'][0]->g_type_level);

        $district_id = "";
if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        $data['amb_district'] = $district_id;

        $data['total_count'] = $this->fleet_model->get_all_indent_item($data);


        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);


        $data['indent_data'] = $this->fleet_model->get_all_indent_item($data,$offset,$limit);

        $data['clg_group'] = trim($this->clg->clg_group);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/indent_dispatch"),
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


        $this->output->add_to_position($this->load->view('frontend/fleet/indent_dispatch_list_view', $data, true), 'content', true);


        $this->output->add_to_position($this->load->view('frontend/fleet/date_filter_view', $data, true), 'date_filter', true);
    }

    function police_station() {


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

        $data['total_count'] = $this->fleet_model->get_all_police_station($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

//        $clgflt['CLG'] = $data;
//        $this->session->set_userdata('filters', $clgflt);
        ///////////////////////////////////

        unset($data['get_count']);



        $data['police_station'] = $this->fleet_model->get_all_police_station($data, $limit,$offset);
       

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/police_station"),
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

        $data['page_records'] = count($data['police_station']);






        $this->output->add_to_position($this->load->view('frontend/fleet/police_station_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/fleet/police_station_filter_view', $data, TRUE), 'clg_filters', TRUE);
    }

    function police_registration() {
        

        if ($this->post['p_id'] != '') {

            $data['p_id'] = $ref_id = base64_decode($this->post['p_id']);
            $data['police_station'] = $this->fleet_model->get_all_police_station($data, $offset, $limit);
        }


        if ($this->post['action_type'] == 'Update') {
            $data['action_type'] = "Update Police Station";
            $data['update'] = 'True';

            $this->output->add_to_position($this->load->view('frontend/fleet/police_register_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Police Station";

            $this->output->add_to_popup($this->load->view('frontend/fleet/police_register_view', $data, TRUE), '1200', '450');
        }
        $this->output->set_focus_to = "police_station_name";
    }

    function registration_police_station() {


        $police_data = $this->post['police'];

        $police_data['p_state_code'] = $this->input->post('incient_state');

        $police_data['p_district_code'] = $this->input->post('incient_districts');
        $police_data['p_tahsil'] = $this->input->post('incient_tahsil');
        $police_data['p_city'] = $this->input->post('incient_ms_city');
       // $police_data['p_landmark'] = $this->input->post('incient_state');
        //$police_data['p_pincode'] = $this->input->post('incient_state');
        $police_data['p_added_date'] = date('Y-m-d H:i:s');
        $police_data['p_modify_by'] = $this->clg->clg_ref_id;
        $police_data['p_added_by'] = $this->clg->clg_ref_id;
        $police_data['p_modify_date'] = date('Y-m-d H:i:s');
        $police_data['p_is_deleted'] = '0';
        $police_data['p_base_month'] = $this->post['base_month'];

        $register_result = $this->fleet_model->insert_police_station($police_data);

        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Police Station registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->police_station();
        }
    }

    function view_police_station() {

        $data = array();

        $data['p_id'] = base64_decode($this->post['p_id']);

        $data['action_type'] = 'View Police Station';

        $data['police_station'] = $this->fleet_model->get_all_police_station($data, $offset, $limit);

        $this->output->add_to_position($this->load->view('frontend/fleet/view_police_station_view', $data, TRUE), $output_position, TRUE);
    }

    function update_police_station_data() {


        $police_data = $this->post['police'];

        $police_data['p_state_code'] = $this->input->post('incient_state');
        $police_data['p_district_code'] = $this->input->post('incient_district');
        $police_data['p_tahsil'] = $this->input->post('incient_tahsil');
        $police_data['p_city'] = $this->input->post('incient_ms_city');
        $police_data['p_modify_by'] = $this->clg->clg_ref_id;
        $police_data['p_modify_date'] = date('Y-m-d H:i:s');



        $result = $this->fleet_model->police_station_update_data($police_data);

        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Police station updated successfully</div>";


            $this->police_station();
        }
    }

    function fire_station() {

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

        $data['total_count'] = $this->fleet_model->get_all_fire_station($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

//        $clgflt['CLG'] = $data;
//        $this->session->set_userdata('filters', $clgflt);
        ///////////////////////////////////

        unset($data['get_count']);



        $data['fire_station'] = $this->fleet_model->get_all_fire_station($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/fire_station"),
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

        $data['page_records'] = count($data['fire_station']);






        $this->output->add_to_position($this->load->view('frontend/fleet/fire_station_list_view', $data, true), $this->post['output_position'], true);

        $this->output->add_to_position($this->load->view('frontend/fleet/fire_station_filter_view', $data, TRUE), 'clg_filters', TRUE);
    }

    function fire_registration() {

        if ($this->post['f_id'] != '') {

            $data['f_id'] = $ref_id = base64_decode($this->post['f_id']);
            $data['fire_station'] = $this->fleet_model->get_all_fire_station($data, $offset, $limit);
        }


        if ($this->post['action_type'] == 'Update') {
            $data['action_type'] = "Update Fire Station";
            $data['update'] = 'True';

            $this->output->add_to_position($this->load->view('frontend/fleet/fire_register_view', $data, TRUE), $output_position, TRUE);
        } else {

            $data['action_type'] = "Add Fire Station";

            $this->output->add_to_popup($this->load->view('frontend/fleet/fire_register_view', $data, TRUE), '1200', '450');
        }
    }

    function registration_fire_station() {


        $fire_data = $this->post['fire'];
        $fire_data['f_state_code'] = $this->input->post('incient_state');
        $fire_data['f_district_code'] = $this->input->post('incient_districts');
        $fire_data['f_tahsil'] = $this->input->post('incient_tahsil');
        $fire_data['f_city'] = $this->input->post('incient_ms_city');
        $fire_data['f_added_date'] = date('Y-m-d H:i:s');
        $fire_data['f_modify_by'] = $this->clg->clg_ref_id;
        $fire_data['f_added_by'] = $this->clg->clg_ref_id;
        $fire_data['f_modify_date'] = date('Y-m-d H:i:s');
        $fire_data['f_is_deleted'] = '0';
        $fire_data['f_base_month'] = $this->post['base_month'];

        $register_result = $this->fleet_model->insert_fire_station($fire_data);

        if ($register_result) {

            $this->output->status = 1;

            $this->output->message = "<div class='success'>Fire Station registered Successfully!</div>";

            $this->output->closepopup = 'yes';

            $this->fire_station();
        }
    }

    function view_fire_station() {

        $data = array();

        $data['f_id'] = base64_decode($this->post['f_id']);

        $data['action_type'] = 'View Fire Station';

        $data['fire_station'] = $this->fleet_model->get_all_fire_station($data, $offset, $limit);

        $this->output->add_to_position($this->load->view('frontend/fleet/view_fire_station_view', $data, TRUE), $output_position, TRUE);
    }

    function update_fire_station_data() {

        $fire_data = $this->post['fire'];
        $fire_data['f_tahsil'] = $this->input->post('incient_tahsil');
        $fire_data['f_city'] = $this->input->post('incient_ms_city');
        $fire_data['f_modify_by'] = $this->clg->clg_ref_id;
        $fire_data['f_modify_date'] = date('Y-m-d H:i:s');



        $result = $this->fleet_model->fire_station_update_data($fire_data);

        if ($result) {

            $this->output->status = 1;

            $this->output->closepopup = 'yes';

            $this->output->message = "<div class='success'>Fire station updated successfully</div>";


            $this->fire_station();
        }
    }
    
    function onscene_care_baselocation(){

        $args = array(
            'amb_ref_id' => $this->post['amb_id'],
        );

        $data['inc_emp_info'] = $this->pcr_model->get_amb_location($args);



        $this->output->add_to_position($this->load->view('frontend/fleet/base_location_view', $data, TRUE), 'amb_base_location', TRUE);
         $this->output->add_to_position($this->load->view('frontend/fleet/district_view', $data, TRUE), 'amb_district', TRUE);
      
    }
     function fuel_feeling_modify() {
        ///////////////  Filters //////////////////
        $this->post['base_month'] = get_base_month();
        
        $data['search'] = ($this->post['search']) ? $this->post['search'] : $this->fdata['search'];
        // print_r($data['search']);die;
        $current_date = date('Y-m-d');
        $current_month = date('m');
        $current_year = date('Y');
        $current_month_date = $current_year . '-' . $current_month . '-01';
        if ($this->post['from_date'] != '') {
            $data['from_date'] = date('Y-m-d', strtotime($this->post['from_date'])) ? date('Y-m-d', strtotime($this->post['from_date'])) : date('Y-m-d', strtotime($this->post['from_date']));
        }

        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date'])) ? date('Y-m-d', strtotime($this->post['to_date'])) : date('Y-m-d', strtotime($this->post['to_date']));
        }

        // if($data['to_date'] != '' && $data['from_date'] != ''){
        //     $data = array('from_date' => $data['from_date'],
        //     'to_date' => $data['to_date'],
        //     'base_month' => $this->post['base_month']);
        // }else{

        //     $data = array('from_date' => date('Y-m-d'),
        //         'to_date' => $current_date,
        //         'base_month' => $this->post['base_month']);
        // }
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
          $data['from_date'] = date('Y-m-01');
        }


        if ($this->post['to_date'] != '') {
            $data['to_date'] = date('Y-m-d', strtotime($this->post['to_date']));
        } else {
           $data['to_date'] = date('Y-m-d');
        }
        
        $district_id = "";
        if($this->clg->clg_group ==  'UG-DM' ||$this->clg->clg_group ==  'UG-ZM' || $this->clg->clg_group == 'UG-DIS-FILD-MANAGER'){
            
            $district_code= $this->clg->clg_district_id;
            $clg_district_id = json_decode($district_code);
            if(is_array($clg_district_id)){
                $district_id = implode("','",$clg_district_id);
            }
        }
        $data['amb_district'] = $district_id;


        $data['total_count'] = $this->fleet_model->get_all_modif_fuel_filling_data($data);
    //    var_dump($data);die;

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;

        unset($data['get_count']);


        $data['fuel_data'] = $this->fleet_model->get_all_modif_fuel_filling_data($data, $offset, $limit);


        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("fleet/fuel_feeling_modify"),
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

        $data['page_records'] = count($data['fuel_data']);


        $this->output->add_to_position($this->load->view('frontend/fleet/fuel_modify_filling_list_view', $data, true), $this->post['output_position'], true);
    }

    function get_odometer_by_gps(){

        $vehicle_no =  $this->input->post('vehicle_no');
        $prev_time = $this->input->post('prev_time');
        $end_time = $this->input->post('end_time');

        $prev_time = date('d-m-Y H:i:s', strtotime($prev_time));
        $end_time = date('d-m-Y H:i:s', strtotime($end_time));

        $vehicle_no = urlencode($vehicle_no);
        $prev_time = urlencode($prev_time);
        $end_time = urlencode($end_time);
        
        //$form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$mobile_no&text=$text_msg&entityid=1701164198802150041&templateid=$tmp_id&rpt=1&summary=1&output=json";
        $form_url= "http://3.6.6.255/webservice?token=getTracknovateHistoryData&vehicle_no=$vehicle_no&start_time=$prev_time&end_time=$end_time";
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

}
