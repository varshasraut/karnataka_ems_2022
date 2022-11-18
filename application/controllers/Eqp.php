<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Eqp extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-INV";

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->load->model(array('common_model', 'eqp_model'));

        $this->load->helper(array('url', 'comman_helper'));

        $this->load->library(array('session', 'modules'));

        $this->post = $this->input->get_post(NULL);

        $this->post['base_month'] = get_base_month();

        $this->clg = $this->session->userdata('current_user');



        if ($this->post['filters'] == 'reset') {

            $this->session->unset_userdata('filters')['INV_EQP'];
        }

        if ($this->session->userdata('filters')['INV_EQP']) {

            $this->fdata = $this->session->userdata('filters')['INV_EQP'];
        }
    }

    public function index($generated = false) {

        echo "This is Equipment controller";
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To manage equipment(Inventory equipments).
    // 
    /////////////////////////////////////////

    function eqplist() {


        //////////////////////// Filters operations ///////////////////////////

        $data['inv_type'] = ($this->post['inv_type']) ? trim($this->post['inv_type']) : $this->fdata['inv_type'];

        $data['eqp_amb'] = (isset($this->post['eqp_amb'])) ? trim($this->post['eqp_amb']) : $this->fdata['eqp_amb'];

        $data['eqp_name'] = (isset($this->post['eqp_name'])) ? trim($this->post['eqp_name']) : $this->fdata['eqp_name'];

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['filters'] = ($this->post['filters']) ? $this->post['filters'] : 'yes';
        //var_dump($data['filters']);die();
        ////////////////////////////////////
        
        if($this->clg->clg_group == 'UG-EMT' &&  $data['eqp_amb'] == ''){
                $args = array(
                'tm_emt_id' => $this->clg->clg_ref_id,
                'tm_shift' => $this->post['shift']
            );
          
        $data['amb'] = $this->common_model->get_emt_by_shift($args);
        $data['eqp_amb'] =  $data['amb'][0]->tm_amb_rto_reg_id;
        }

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


        $data['eqp_total'] = $this->eqp_model->get_eqp($data);


        $pg_no = get_pgno($data['eqp_total'], $limit, $pg_no);


        $offset = ($pg_no == 1) ? 0 : ($pg_no * $limit) - $limit;
        $data['per_page'] = $limit;

        //////////////////////////////////////////////////////////////////

        $data['pg_no'] = $pg_no;

        $eqpflt['INV_EQP'] = $data;

        $this->session->set_userdata('filters', $eqpflt);

        ///////////////////////////////////////////////////////////////////

        unset($data['get_count']);

        $data['eqp_list'] = $this->eqp_model->get_eqp($data, $offset, $limit);



        $data['cur_page'] = $pg_no;

        $pgconf = array(
            'url' => base_url("eqp/eqplist"),
            'total_rows' => $data['eqp_total'],
            'per_page' => $limit,
            'cur_page' => $pg_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );



        $data['pagination'] = get_pagination($pgconf);

        if ($data['eqp_amb'] != '') {


            $this->output->add_to_position($this->load->view('frontend/Inv/Eqp/amb_eqp_view', $data, TRUE), $this->post['output_position'], TRUE);
        } else {


            $this->output->add_to_position($this->load->view('frontend/Inv/Eqp/eqp_list_view', $data, TRUE), $this->post['output_position'], TRUE);
        }


        if($data['filters'] != 'no'){
            $this->output->add_to_position($this->load->view('frontend/Inv/Eqp/eqp_filters_view', $data, TRUE), 'eqp_filters', TRUE);
        }
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To add inventory equipment.
    // 
    /////////////////////////////////////////

    function add() {

        $data['mas_inv_type'] = $this->eqp_model->get_inv_type();

        if ($this->post['submit_eqp']) {

            $eqp_info = array('eqp_name' => addslashes($this->post['eqp_title']),
                'eqp_base_quantity' => $this->post['eqp_base_qty'],
                'eqp_type' => $this->post['eqpp_type'],
                'eqp_status' => '1',
                'eqpis_deleted' => '0');



            $ins = $this->eqp_model->insert_eqp($eqp_info);

            if ($ins) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Equipment added successfully</div>";

                $this->eqplist();
            } else {

                $this->output->message = "<div class='error'>Something going wrong</div>";
            }
        } else {

            $data['eqp_action'] = "add";

            $this->output->add_to_position($this->load->view('frontend/Inv/Eqp/add_eqp_view', $data, TRUE), $this->post['output_position'], TRUE);
        }
    }

    //// Created by MI42 /////////////////////////
    // 
    // Purpose : To edit/view inventory equipment.
    // 
    //////////////////////////////////////////////


    function edit() {

        $data['eqp_action'] = $this->post['eqp_action'];

        if ($this->post['submit_eqp']) {

            $eqp_info = array('eqp_name' => addslashes($this->post['eqp_title']),
                'eqp_base_quantity' => $this->post['eqp_base_qty']
            );

            $up = $this->eqp_model->upadte_eqp($this->post['eqp_id'], $eqp_info);

            if ($up) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Equipment details updated successfully</div>";

                $this->eqplist();
            } else {

                $this->output->message = "<div class='error'>Something going wrong</div>";
            }
        } else {


            $data['eqp'] = $this->eqp_model->get_eqp(array('eqp_id' => $this->post['eqp_id']));

            $this->output->add_to_position($this->load->view('frontend/Inv/Eqp/add_eqp_view', $data, TRUE), $this->post['output_position'], TRUE);
        }
    }

    //// Created by MI42 //////////////////////
    // 
    // Purpose : To delete inventory equipment.
    // 
    ///////////////////////////////////////////

    function del() {

        if (empty($this->post['eqp_id'])) {
            $this->output->message = "<div class='error'>Please select atleast one equipment to delete</div>";
            return;
        }


        $del = array('eqpis_deleted' => '1');


        $status = $this->eqp_model->delete_eqp($this->post['eqp_id'], $del);


        if ($status) {

            $this->output->message = "<div class='success'>Equipment deleted successfully</div>";

            $this->eqplist();
        } else {

            $this->output->message = "<div class='error'>Something going wrong</div>";
        }
    }

    //// Created by MI42 ////////////////////////////////////////////////
    // 
    // Purpose : To update inventory equipment status (Active/Inactive).
    // 
    /////////////////////////////////////////////////////////////////////


    function status() {

        $sts = get_toggle_sts();

        $status = array('eqp_status' => $sts[$this->post['eqp_sts']]);

        $status = $this->eqp_model->upadte_eqp($this->post['eqp_id'], $status);

        if ($status) {

            $this->output->message = "<div class='success'>Equipment status updated successfully</div>";

            $this->eqplist();
        } else {

            $this->output->message = "<div class='error'>Something going wrong</div>";
        }
    }
    
    function eqplist_amb() {


        //////////////////////// Filters operations ///////////////////////////

        $data['inv_type'] = ($this->post['inv_type']) ? trim($this->post['inv_type']) : $this->fdata['inv_type'];

        $data['eqp_amb'] = (isset($this->post['eqp_amb'])) ? trim($this->post['eqp_amb']) : $this->fdata['eqp_amb'];

        $data['eqp_name'] = (isset($this->post['eqp_name'])) ? trim($this->post['eqp_name']) : $this->fdata['eqp_name'];

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['filters'] = ($this->post['filters']) ? $this->post['filters'] : 'yes';
       
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


        $data['eqp_total'] = $this->eqp_model->get_eqp($data);


        $pg_no = get_pgno($data['eqp_total'], $limit, $pg_no);


        $offset = ($pg_no == 1) ? 0 : ($pg_no * $limit) - $limit;

        //////////////////////////////////////////////////////////////////

        $data['pg_no'] = $pg_no;

        $eqpflt['INV_EQP'] = $data;

        $this->session->set_userdata('filters', $eqpflt);

        ///////////////////////////////////////////////////////////////////

        unset($data['get_count']);

        $data['eqp_list'] = $this->eqp_model->get_eqp($data, $offset, $limit);



        $data['cur_page'] = $pg_no;

        $pgconf = array(
            'url' => base_url("eqp/eqplist_amb"),
            'total_rows' => $data['eqp_total'],
            'per_page' => $limit,
            'cur_page' => $pg_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );



        $data['pagination'] = get_pagination($pgconf);

        $this->output->add_to_position($this->load->view('frontend/Inv/Eqp/amb_eqp_view', $data, TRUE), $this->post['output_position'], TRUE);

            $this->output->add_to_position($this->load->view('frontend/Inv/Eqp/eqp_amb_filters_view', $data, TRUE), 'eqp_filters', TRUE);
        
    }

}
