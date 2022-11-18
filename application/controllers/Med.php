<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Med extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-INV";

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->load->model(array('common_model', 'med_model', 'inv_model', 'manufacture_model'));

        $this->load->helper(array('url', 'comman_helper'));

        $this->load->library(array('session', 'modules'));

        $this->clg = $this->session->userdata('current_user');

        $this->post = $this->input->get_post(NULL);

        $this->post['base_month'] = get_base_month();

        $this->cur_usr = $this->session->userdata('current_user');

        if ($this->post['filters'] == 'reset') {

            $this->session->unset_userdata('filters')['INV_MED'];
        }

        if ($this->session->userdata('filters')['INV_MED']) {

            $this->fdata = $this->session->userdata('filters')['INV_MED'];
        }
    }

    public function index($generated = false) {

        echo "This is Medicines controller";
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To manage medications(Inventory medicines).
    // 
    /////////////////////////////////////////

    function medlist() {


        //////////////////////// Filters operations ///////////////////////////

        $data['inv_type'] = ($this->post['inv_type']) ? trim($this->post['inv_type']) : $this->fdata['inv_type'];

        $data['med_amb'] = (isset($this->post['med_amb'])) ? trim($this->post['med_amb']) : $this->fdata['med_amb'];

        $data['med_man'] = ($this->post['med_man']) ? $this->post['med_man'] : $this->fdata['med_man'];

        $data['med_name'] = (isset($this->post['med_name'])) ? trim($this->post['med_name']) : $this->fdata['med_name'];

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['filters'] = ($this->post['filters']) ? $this->post['filters'] : 'yes';


        ////////////////////////////// Set page number /////////////////////////
        
        if($this->clg->clg_group == 'UG-EMT' &&  $data['med_amb'] == ''){
                $args = array(
                'tm_emt_id' => $this->clg->clg_ref_id,
                'tm_shift' => $this->post['shift']
            );
          
        $data['amb'] = $this->common_model->get_emt_by_shift($args);
        $data['med_amb'] =  $data['amb'][0]->tm_amb_rto_reg_id;
        }
        

        $pg_no = 1;

        if ($this->uri->segment(3)) {
            $pg_no = $this->uri->segment(3);
        } else if ($this->fdata['pg_no'] && !$this->post['flt']) {
            $pg_no = $this->fdata['pg_no'];
        }


        /////////////////////////// Set limit & offset /////////////////////////


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $data['get_count'] = TRUE;


        //$data['med_total'] = $this->med_model->get_med($data);
        $data['med_total'] = $this->med_model->get_med_item($data);
        


        $pg_no = get_pgno($data['med_total'], $limit, $pg_no);


        $offset = ($pg_no == 1) ? 0 : ($pg_no * $limit) - $limit;

        //////////////////////////////////////////////////////////////////

        $data['pg_no'] = $pg_no;

        $medflt['INV_MED'] = $data;

        $this->session->set_userdata('filters', $medflt);

        ///////////////////////////////////////////////////////////////////

        unset($data['get_count']);

        //$data['med_list'] = $this->med_model->get_med($data, $offset, $limit);
        $data['med_list'] = $this->med_model->get_med_item($data, $offset, $limit);

        $data['cur_page'] = $pg_no;

        $pgconf = array(
            'url' => base_url("med/medlist"),
            'total_rows' => $data['med_total'],
            'per_page' => $limit,
            'cur_page' => $pg_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );



        $data['pagination'] = get_pagination($pgconf);


        if ($data['med_amb'] != '') {


            $this->output->add_to_position($this->load->view('frontend/Inv/Med/amb_med_view', $data, TRUE), $this->post['output_position'], TRUE);
        } else {


            $this->output->add_to_position($this->load->view('frontend/Inv/Med/med_list_view', $data, TRUE), $this->post['output_position'], TRUE);
        }

        if($data['filters'] != 'no'){
            $this->output->add_to_position($this->load->view('frontend/Inv/Med/med_filters_view', $data, TRUE), 'med_filters', TRUE);
        }
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To manage add medicines.
    // 
    /////////////////////////////////////////

    function add() {




        if ($this->post['submit_med']) {

            $med_info = array('med_title' => addslashes($this->post['med_title']),
                'med_quantity_unit' => $this->post['med_unit'],
                'med_manufacture' => $this->post['med_manid'],
                'med_base_quantity' => $this->post['med_base_qty'],
                'med_manufacturing_date' => date('Y-m-d', strtotime($this->post['inv_manufacturing_date'])),
                'med_exp_date' => date('Y-m-d', strtotime($this->post['inv_exp_date'])),
                'med_registered_by' => $this->cur_usr->clg_ref_id,
                'med_status' => '1',
                'medis_deleted' => '0');



            $ins = $this->med_model->insert_med($med_info);

            if ($ins) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Medicine added successfully</div>";

                $this->medlist();
            } else {

                $this->output->message = "<div class='error'>Something going wrong</div>";
            }
        } else {

            $data['med_action'] = "add";

            $this->output->add_to_position($this->load->view('frontend/Inv/Med/add_med_view', $data, TRUE), $this->post['output_position'], TRUE);
        }
    }

    //// Created by MI42 /////////////////////////
    // 
    // Purpose : To edit/view inventory medicines
    // 
    //////////////////////////////////////////////


    public function edit() {

        $data['med_action'] = $this->post['med_action'];

        if ($this->post['submit_med']) {




            $med_info = array('med_title' => addslashes($this->post['med_title']),
                'med_quantity_unit' => $this->post['med_unit'],
                'med_manufacture' => $this->post['med_manid'],
                'med_base_quantity' => $this->post['med_base_qty']
            );


            $up = $this->med_model->upadte_med($this->post['med_id'], $med_info);

            if ($up) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Medicine details updated successfully</div>";

                $this->medlist();
            } else {

                $this->output->message = "<div class='error'>Something going wrong</div>";
            }
        } else {


            $data['med'] = $this->med_model->get_med(array('med_id' => $this->post['med_id']));

            $this->output->add_to_position($this->load->view('frontend/Inv/Med/add_med_view', $data, TRUE), $this->post['output_position'], TRUE);
        }
    }

    //// Created by MI42 //////////////////////
    // 
    // Purpose : To delete inventory medicines.
    // 
    ///////////////////////////////////////////

    public function del() {

        if (empty($this->post['med_id'])) {
            $this->output->message = "<div class='error'>Please select atleast one medicine to delete</div>";
            return;
        }


        $del = array('medis_deleted' => '1');


        $status = $this->med_model->delete_med($this->post['med_id'], $del);


        if ($status) {

            $this->output->message = "<div class='success'>Medicine deleted successfully</div>";

            $this->medlist();
        } else {

            $this->output->message = "<div class='error'>Something going wrong</div>";
        }
    }

    //// Created by MI42 ////////////////////////////////////////////////
    // 
    // Purpose : To update inventory medicines status (Active/Inactive).
    // 
    /////////////////////////////////////////////////////////////////////


    function status() {

        $sts = get_toggle_sts();

        $status = array('med_status' => $sts[$this->post['med_sts']]);

        $status = $this->med_model->upadte_med($this->post['med_id'], $status);

        if ($status) {

            $this->output->message = "<div class='success'>Medicine status updated successfully</div>";

            $this->medlist();
        } else {

            $this->output->message = "<div class='error'>Something going wrong</div>";
        }
    }
    function medlist_amb() {


        //////////////////////// Filters operations ///////////////////////////

        $data['inv_type'] = ($this->post['inv_type']) ? trim($this->post['inv_type']) : $this->fdata['inv_type'];

        $data['med_amb'] = (isset($this->post['med_amb'])) ? trim($this->post['med_amb']) : $this->fdata['med_amb'];

        $data['med_man'] = ($this->post['med_man']) ? $this->post['med_man'] : $this->fdata['med_man'];

        $data['med_name'] = (isset($this->post['med_name'])) ? trim($this->post['med_name']) : $this->fdata['med_name'];

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['filters'] = ($this->post['filters']) ? $this->post['filters'] : 'yes';



        

        $pg_no = 1;

        if ($this->uri->segment(3)) {
            $pg_no = $this->uri->segment(3);
        } else if ($this->fdata['pg_no'] && !$this->post['flt']) {
            $pg_no = $this->fdata['pg_no'];
        }


        /////////////////////////// Set limit & offset /////////////////////////


        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $data['get_count'] = TRUE;


        $data['med_total'] = $this->med_model->get_med($data);


        $pg_no = get_pgno($data['med_total'], $limit, $pg_no);


        $offset = ($pg_no == 1) ? 0 : ($pg_no * $limit) - $limit;

        //////////////////////////////////////////////////////////////////

        $data['pg_no'] = $pg_no;

        $medflt['INV_MED'] = $data;

        $this->session->set_userdata('filters', $medflt);

        ///////////////////////////////////////////////////////////////////

        unset($data['get_count']);

        $data['med_list'] = $this->med_model->get_med($data, $offset, $limit);

        $data['cur_page'] = $pg_no;

        $pgconf = array(
            'url' => base_url("med/medlist_amb"),
            'total_rows' => $data['med_total'],
            'per_page' => $limit,
            'cur_page' => $pg_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );



        $data['pagination'] = get_pagination($pgconf);

            $this->output->add_to_position($this->load->view('frontend/Inv/Med/amb_med_view', $data, TRUE), $this->post['output_position'], TRUE);


            $this->output->add_to_position($this->load->view('frontend/Inv/Med/med_amb_filters_view', $data, TRUE), 'med_filters', TRUE);
    }

}
