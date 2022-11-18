<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inv_stock extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-INV";

        $this->load->model(array('common_model', 'inv_stock_model'));

        $this->load->helper(array('url'));

        $this->load->library(array('session', 'modules'));

        $this->clg = $this->session->userdata('current_user');

        $this->post = $this->input->get_post(NULL);

        $this->post['base_month'] = get_base_month();

        $this->today = date('Y-m-d H:i:s');
    }

    public function index($generated = false) {

        echo "This is Inventory Stock controller";
    }

    //// Created by MI42 ////////////////////////////////
    // 
    // Purpose : To manage consumable/non-consumable stock.
    // 
    /////////////////////////////////////////////////////


    function add() {

        $data['inv_type'] = $this->post['inv_type'];

        if ($this->post['submit_inv']) {

            $this->post['inv_stock']['stk_inv_type'] = $data['inv_type'];

            $this->post['inv_stock']['stk_handled_by'] = $this->clg->clg_ref_id;

            $this->post['inv_stock']['stk_base_month'] = $this->post['base_month'];

            $this->post['inv_stock']['stk_in_out'] = 'in';

            $this->post['inv_stock']['stk_date'] = ($this->post['inv_stock']['stk_date']) ? date('Y-m-d', strtotime($this->post['inv_stock']['stk_date'])) : $this->today;

            $ins = $this->inv_stock_model->insert_stock($this->post['inv_stock']);
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


            if ($data['inv_type'] == 'CA' || $data['inv_type'] == 'NCA') {

                $item_field = "<input type='text' name='inv_stock[stk_inv_id]'  value='' class='mi_autocomplete filter_required' data-href='" . base_url() . "auto/get_inv_items/" . $data['inv_type'] . "'  data-errors=\"{filter_required:'Please select item name from dropdown list'}\"  tabindex='1'>";
            } else if ($data['inv_type'] == 'MED') {

                $item_field = "<input type='text' name='inv_stock[stk_inv_id]'  value='' class='mi_autocomplete filter_required' data-href='" . base_url() . "auto/get_inv_med/'  data-errors=\"{filter_required:'Please select item name from dropdown list'}\"  tabindex='1'>";
            } else if ($data['inv_type'] == 'EQP') {

                $item_field = "<input type='text' name='inv_stock[stk_inv_id]'  value='' class='mi_autocomplete filter_required' data-href='" . base_url() . "auto/get_inv_eqp/'  data-errors=\"{filter_required:'Please select item name from dropdown list'}\"  tabindex='1'>";
            }

            /////////////////////////////////////////////////////////////////////////

            $this->output->add_to_position($this->load->view('frontend/Inv_stock/add_stock_view', $data, TRUE), $this->post['output_position'], TRUE);

            $this->output->add_to_position($item_field, 'item_type', TRUE);
        }
    }

    //// Created by MI42 ////////////////////////////////
    // 
    // Purpose : Get consumable/non consumable stock..
    // 
    /////////////////////////////////////////////////////

    function get_con_item() {

        $args = array(
            'inv_id' => $this->post['inv_id'],
            'inv_type' => $this->post['inv_type'],
        );

        $res = $this->inv_model->get_inv($args);

        $max = $res[0]->stk_in - $res[0]->stk_out;
        $min = $res[0]->inv_base_quantity;

        $str = '\"';

        $res_tpl = "<tr><td> " . $res[0]->inv_title . " </td><td><input type='text' name='item_qty'  class='filter_required'  placeholder='Qty' value='' data-base='select_" . $res[0]->inv_type . $res[0]->inv_id . "' data-errors='{filter_required:$str Item quanity should not be blank$str,filter_rangelength:$str Item range should be $min to $max $str}'></td><td> " . $res[0]->inv_base_quantity . "</td><td> " . $max . " </td><td> " . $res[0]->unt_title . " </td><td><input name='select_" . $res[0]->inv_type . $res[0]->inv_id . "' class='base-xhttp-request style6' data-href='" . base_url() . "/inv_stock/release_stock' data-qr='inv_id=" . $res[0]->inv_id . "&inv_type=" . $res[0]->inv_type . "&item_name=" . $res[0]->inv_title . "' value='SELECT' type='button'></td></tr>";


        //////////////////////////////////////////////////////////////////////////////

        if ($this->post['inv_type'] == 'CA') {

            $consumables_selected_inv_list = $this->session->userdata('consumables_selected_inv_list');
            if ($consumables_selected_inv_list == '') {
                $consumables_selected_inv_list = array();
            }

            if (isset($consumables_selected_inv_list[$res[0]->inv_id])) {
                $script = "<script></script>";
            } else {
                $consumables_selected_inv_list[$res[0]->inv_id] = array('inv_id' => $res[0]->inv_id, 'inv_name' => $res[0]->inv_title);

                $inp_tpl = "<input type='hidden' name='' data-auto='CA' value='" . $res[0]->inv_id . "'>";
                $script = "<script>$('.CA_items').show().append(\"" . $inp_tpl . "\");$('.CA_items table tbody').append(\"" . $res_tpl . "\");</script>";
            }

            $this->session->set_userdata('consumables_selected_inv_list', $consumables_selected_inv_list);

            $this->output->add_to_position($script, 'custom_script', TRUE);
        } else if ($this->post['inv_type'] == 'NCA') {

            $na_consumables_selected_inv_list = $this->session->userdata('na_consumables_selected_inv_list');
            if ($na_consumables_selected_inv_list == '') {
                $na_consumables_selected_inv_list = array();
            }

            if (isset($na_consumables_selected_inv_list[$res[0]->inv_id])) {
                $script = "<script></script>";
            } else {
                $na_consumables_selected_inv_list[$res[0]->inv_id] = array('inv_id' => $res[0]->inv_id, 'inv_name' => $res[0]->inv_title);

                $inp_tpl = "<input type='hidden' name='' data-auto='NCA' value='" . $res[0]->inv_id . "'>";
                $script = "<script>$('.NCA_items').show().append(\"" . $inp_tpl . "\");$('.NCA_items table tbody').append(\"" . $res_tpl . "\");</script>";
            }

            $this->session->set_userdata('na_consumables_selected_inv_list', $na_consumables_selected_inv_list);

            $this->output->add_to_position($script, 'custom_script', TRUE);
        }
    }

    //// Created by MI42 ////////////////////////////////
    // 
    // Purpose : To get medication stock.
    // 
    /////////////////////////////////////////////////////

    function get_med_item() {

        $args = array(
            'med_id' => $this->post['med_id'],
            'inv_type' => 'MED'
        );

        $res = $this->med_model->get_med($args);


        //////////////////////////////////////////////////////////////////////////////

        $max = $res[0]->stk_in - $res[0]->stk_out;
        $min = $res[0]->med_base_quantity;

        $str = '\"';


        $res_tpl = "<tr><td> " . $res[0]->med_title . " </td><td><input type='text' name='item_qty'  class='filter_required'  placeholder='Qty' value='' data-base='select_MED" . $res[0]->med_id . "' data-errors='{filter_required:$str Item quanity should not be blank$str,filter_rangelength:$str Item range should be $min to $max $str}'></td><td>" . $min . "</td><td>" . $max . "</td><td> " . $res[0]->unt_title . " </td><td><input name='select_MED" . $res[0]->med_id . "' class='base-xhttp-request style6' data-href='" . base_url() . "/inv_stock/release_stock' data-qr='inv_id=" . $res[0]->med_id . "&inv_type=MED&item_name=" . $res[0]->med_title . "' value='SELECT' type='button'></td></tr>";

        $med_item_selected_inv_list = $this->session->userdata('med_item_selected_inv_list');

        // if($med_item_selected_inv_list == '' ){ $med_item_selected_inv_list = array(); }

        if (isset($med_item_selected_inv_list[$res[0]->med_id])) {
            $script = "<script></script>";
        } else {
            $med_item_selected_inv_list[$res[0]->med_id] = array('med_id' => $res[0]->med_id, 'med_title' => $res[0]->med_title);

            $inp_tpl = "<input type='hidden' name='' data-auto='MED' value='" . $res[0]->med_id . "'>";
            $script = "<script>$('.MED_items').show().append(\"" . $inp_tpl . "\");$('.MED_items table tbody').append(\"" . $res_tpl . "\");</script>";
        }

        $this->session->set_userdata('med_item_selected_inv_list', $med_item_selected_inv_list);

        $this->output->add_to_position($script, 'custom_script', TRUE);

        //$this->output->add_to_position($script, 'custom_script', TRUE);
    }

    //// Created by MI42 ////////////////////////////////
    // 
    // Purpose : Update stock details.
    // 
    /////////////////////////////////////////////////////


    function release_stock() {

        $args = array(
            'stk_inv_id' => $this->post['inv_id'],
            'stk_inv_inv_type' => $this->post['inv_type']
        );

        $data = array('stk_out' => $this->post['item_qty']);

        // $this->session->set_userdata('consumables_selected_qty_inv_list', array());



        $rel_item_tpl = "<tr id=" . $this->post['inv_type'] . '_' . $this->post['inv_id'] . "><td>" . $this->post['item_name'] . "</td><td>" . $this->post['item_qty'] . "</td><td><input name='remove_$this->post['inv_type']" . $this->post['inv_id'] . "' class='base-xhttp-request style6' data-href='" . base_url() . "/inv_stock/remove_stock?id=" . $this->post['inv_type'] . '_' . $this->post['inv_id'] . "' data-qr='' value='REMOVE' type='button'></td></tr>";

        if ($this->post['inv_type'] == 'CA') {

            $consumables_selected_qty_inv_list = $this->session->userdata('consumables_selected_qty_inv_list');
            // var_dump($consumables_selected_qty_inv_list[$this->post['inv_id']]['inv_qty']);
            // var_dump($this->post['item_qty']);

            if ($consumables_selected_qty_inv_list == '') {
                $consumables_selected_qty_inv_list = array();
            }

            if ($consumables_selected_qty_inv_list[$this->post['inv_id']]) {

                $script = "<script>$('.CA_rel_items #{$this->post['inv_type']}_{$this->post['inv_id']}').remove(); $('.CA_rel_items table tbody').append(\"" . $rel_item_tpl . "\"); </script>";
            } else {
                $consumables_selected_qty_inv_list[$this->post['inv_id']] = array('inv_id' => $this->post['inv_id'], 'inv_qty' => $this->post['item_qty'], 'item_name' => $this->post['item_name'], 'item_type' => $this->post['inv_type']);

                $script = "<script>$('.CA_rel_items').show();$('.CA_rel_items table tbody').append(\"" . $rel_item_tpl . "\");</script>";
            }
            $this->session->set_userdata('consumables_selected_qty_inv_list', $consumables_selected_qty_inv_list);
        } else if ($this->post['inv_type'] == 'NCA') {

            $na_consumables_selected_qty_inv_list = $this->session->userdata('na_consumables_selected_qty_inv_list');

            if ($na_consumables_selected_qty_inv_list == '') {
                $na_consumables_selected_qty_inv_list = array();
            }

            if ($na_consumables_selected_qty_inv_list[$this->post['inv_id']]) {
                $script = "<script>$('.NCA_rel_items #{$this->post['inv_type']}_{$this->post['inv_id']}').remove(); $('.NCA_rel_items table tbody').append(\"" . $rel_item_tpl . "\"); </script>";
            } else {
                $na_consumables_selected_qty_inv_list[$this->post['inv_id']] = array('inv_id' => $this->post['inv_id'], 'inv_qty' => $this->post['item_qty'], 'item_name' => $this->post['item_name'], 'item_type' => $this->post['inv_type']);

                $script = "<script>$('.NCA_rel_items').show();$('.NCA_rel_items table tbody').append(\"" . $rel_item_tpl . "\");</script>";
            }
            $this->session->set_userdata('na_consumables_selected_qty_inv_list', $na_consumables_selected_qty_inv_list);
        } else if ($this->post['inv_type'] == 'MED') {

            $med_selected_qty_inv_list = $this->session->userdata('med_selected_qty_inv_list');

            if ($med_selected_qty_inv_list == '') {
                $med_selected_qty_inv_list = array();
            }

            if ($med_selected_qty_inv_list[$this->post['inv_id']]) {
                $script = "<script>$('.MED_rel_items #{$this->post['inv_type']}_{$this->post['inv_id']}').remove(); $('.MED_rel_items table tbody').append(\"" . $rel_item_tpl . "\"); </script>";
            } else {
                $med_selected_qty_inv_list[$this->post['inv_id']] = array('inv_id' => $this->post['inv_id'], 'inv_qty' => $this->post['item_qty'], 'item_name' => $this->post['item_name'], 'item_type' => $this->post['inv_type']);

                $script = "<script>$('.MED_rel_items').show();$('.MED_rel_items table tbody').append(\"" . $rel_item_tpl . "\");</script>";
            }
            $this->session->set_userdata('med_selected_qty_inv_list', $med_selected_qty_inv_list);
        }

        //////////////////////////////////////////////////////////////////

        $this->output->add_to_position($script, 'custom_script', TRUE);
    }

    function remove_stock() {

        $div_id = $this->input->post();
        $div = $div_id['id'];
        $remove_div = "<script>$( 'tr#" . $div . "' ).remove();</script>";
        $data['med_qty_script'] = $remove_div;
        $type = explode('_', $div_id['id']);


        if ($type[0] == 'MED') {
            $med_selected_qty_inv_list = $this->session->userdata('med_selected_qty_inv_list');
            unset($med_selected_qty_inv_list[$type[1]]);
        }
        if ($type[0] == 'NCA') {
            $na_consumables_selected_qty_inv_list = $this->session->userdata('na_consumables_selected_qty_inv_list');
            unset($na_consumables_selected_qty_inv_list[$type[1]]);
        }
        if ($type[0] == 'CA') {
            $consumables_selected_qty_inv_list = $this->session->userdata('consumables_selected_qty_inv_list');
            unset($consumables_selected_qty_inv_list[$type[1]]);
        }

        $this->output->add_to_position($remove_div, "custom_script", TRUE);
        $this->output->template = "";
        //die();
    }
    function add_tyre() {
// print_r($this->post);die;
        $data['inv_type'] = $this->post['inv_type'];
        
        if ($this->post['submit_inv']) {

            //$this->post['inv_stock']['stk_inv_type'] = $data['inv_type'];

            $this->post['tyre_stock']['tyre_handled_by'] = $this->clg->clg_ref_id;

            $this->post['tyre_stock']['tyre_base_month'] = $this->post['base_month'];

            $this->post['tyre_stock']['tyre_in_out'] = 'In';

            // $this->post['tyre_stock']['tyre_date'] = ($this->post['tyre_stock']['stk_date']) ? date('Y-m-d', strtotime($this->post['tyre_stock']['stk_date'])) : $this->today;
            $this->post['tyre_stock']['tyre_date'] = ($this->post['tyre_stock']['tyre_date']) ? date('Y-m-d', strtotime($this->post['tyre_stock']['tyre_date'])) : $this->today;

            $ins = $this->inv_stock_model->insert_tyre_stock($this->post['tyre_stock']);
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


            $item_field = "<input type='text' name='tyre_stock[stk_tyre_id]'  value='' class='mi_autocomplete filter_required' data-href='" . base_url() . "auto/get_tyre_item/'  data-errors=\"{filter_required:'Please select item name from dropdown list'}\"  tabindex='1'>";
            

            /////////////////////////////////////////////////////////////////////////

            $this->output->add_to_position($this->load->view('frontend/Inv_stock/add_tyre_stock_view', $data, TRUE), $this->post['output_position'], TRUE);

            $this->output->add_to_position($item_field, 'item_type', TRUE);
        }
    }

}
