<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inv extends EMS_Controller {

    function __construct() {
 
        parent::__construct();

        $this->active_module = "M-INV";

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->load->model(array('common_model', 'inv_model', 'manufacture_model','school_model'));

        $this->load->helper(array('url', 'comman_helper'));

        $this->load->library(array('session', 'modules'));

        $this->clg = $this->session->userdata('current_user');

        $this->post = $this->input->get_post(NULL);

        $this->post['base_month'] = get_base_month();


        if ($this->post['filters'] == 'reset') {

            $this->session->unset_userdata('filters')['INV'];
        }


        if ($this->session->userdata('filters')['INV']) {

            $this->fdata = $this->session->userdata('filters')['INV'];
        }
    }

    public function index($generated = false) {

        echo "This is Inventory controller";
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To manage inventory items
    // 
    /////////////////////////////////////////


    function invlist() {

        //////////////////////// Filters operations ///////////////////////////


        $data['inv_type'] = ($this->post['inv_type']) ? trim($this->post['inv_type']) : $this->fdata['inv_type'];

        $data['inv_man'] = (isset($this->post['inv_man'])) ? trim($this->post['inv_man']) : $this->fdata['inv_man'];

        $data['inv_amb'] = (isset($this->post['inv_amb'])) ? trim($this->post['inv_amb']) : $this->fdata['inv_amb'];

        $data['inv_item'] = (isset($this->post['inv_item'])) ? trim($this->post['inv_item']) : $this->fdata['inv_item'];

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        
        $data['filters'] = ($this->post['filters']) ? $this->post['filters'] : 'yes';

        
        ////////////////////////////////////
        if($this->clg->clg_group == 'UG-EMT' &&  $data['inv_amb'] == ''){
            
                $args = array(
                'tm_emt_id' => $this->clg->clg_ref_id,
                'tm_shift' => $this->post['shift']
            );
          
        $data['amb'] = $this->common_model->get_emt_by_shift($args);
        $data['inv_amb'] =  $data['amb'][0]->tm_amb_rto_reg_id;
       
        }
        
        if($this->clg->clg_group == 'UG-HEALTH-SUP' || $this->clg->clg_group == 'UG-SICK-SUP'){
           
            $res = $this->school_model->get_school_type(array('health_sup' => $this->clg->clg_ref_id));
         
            $data['inv_amb'] =  $res[0]->school_id;
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
        
        
      
       // $data['item_total'] = $this->inv_model->get_inv($data);
        $data['item_total'] = $this->inv_model->get_inv_details_list($data);


        $pg_no = get_pgno($data['item_total'], $limit, $pg_no);


        $offset = ($pg_no == 1) ? 0 : ($pg_no * $limit) - $limit;

        //////////////////////////////////////////////////////////////////

        $data['pg_no'] = $pg_no;

        $invflt['INV'] = $data;

        $this->session->set_userdata('filters', $invflt);

        ///////////////////////////////////////////////////////////////////

        unset($data['get_count']);

      
        
        //$data['item_list'] = $this->inv_model->get_inv($data, $offset, $limit);
        $data['item_list'] = $this->inv_model->get_inv_details_list($data, $offset, $limit);




        $data['cur_page'] = $pg_no;

        $pgconf = array(
            'url' => base_url("inv/invlist"),
            'total_rows' => $data['item_total'],
            'per_page' => $limit,
            'cur_page' => $pg_no,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);




        if ($data['inv_amb'] != '') {

            $this->output->add_to_position($this->load->view('frontend/Inv/amb_inv_view', $data, TRUE), $this->post['output_position'], TRUE);
        } else {



            $this->output->add_to_position($this->load->view('frontend/Inv/inv_list_view', $data, TRUE), $this->post['output_position'], TRUE);
        }

        if($data['filters'] != 'no'){
            $this->output->add_to_position($this->load->view('frontend/Inv/inv_filters_view', $data, TRUE), 'inv_filters', TRUE);    
        }
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To add inventory items
    // 
    /////////////////////////////////////////


    function add() {


        $data['inv_type'] = $this->fdata['inv_type'];


        if ($this->post['submit_inv']) {

            $inv_info = array('inv_title' => addslashes($this->post['inv_title']),
                'inv_type' => $data['inv_type'],
                'inv_unit' => $this->post['inv_unit'],
                'inv_manufacture' => $this->post['inv_manid'],
                'inv_base_quantity' => $this->post['inv_base_qty'],
                'inv_manufacturing_date' => date('Y-m-d', strtotime($this->post['inv_manufacturing_date'])),
                'inv_exp_date' => date('Y-m-d', strtotime($this->post['inv_exp_date'])),
                'inv_added_date' => date('Y-m-d H:i:s'),
                'inv_status' => '1',
                'invis_deleted' => '0');


            $ins = $this->inv_model->insert_inv($inv_info);

            if ($ins) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Item added successfully</div>";

                $this->invlist();
            } else {

                $this->output->message = "<div class='error'>Something going wrong</div>";
            }
        } else {

            $data['action'] = "add";
            $data['item'] = array();

            $this->output->add_to_position($this->load->view('frontend/Inv/add_inv_view', $data, TRUE), 'popup_div', TRUE);
        }
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To edit/view inventory items
    // 
    /////////////////////////////////////////

    function edit_tyre(){
        $data['inv_type'] = $this->fdata['inv_type'];

        $data['action'] = $this->post['action'];


        
        if ($this->post['submit_inv']) {

            $inv_info = array('tyre_title' => addslashes($this->post['tyre_title']),
                'tyre_manufacture' => $this->post['tyre_manid'],
                'tyre_base_quantity' => $this->post['tyre_base_qty']
            );

            

            $up = $this->inv_model->update_tyre($this->post['tyre_id_new'], $inv_info);

            if ($up) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Item details updated successfully</div>";

                $this->tyrelist();
            } else {

                $this->output->message = "<div class='error'>Something going wrong</div>";
            }
        } else {


            $data['item'] = $this->inv_model->get_tyre(array('inv_id' => $this->post['tyre_id_new']));

            $this->output->add_to_position($this->load->view('frontend/Inv/add_tyre_view', $data, TRUE), $this->post['output_position'], TRUE);
        }
    }
    function edit() {


        $data['inv_type'] = $this->fdata['inv_type'];

        $data['action'] = $this->post['action'];



        if ($this->post['submit_inv']) {

            $inv_info = array('inv_title' => addslashes($this->post['inv_title']),
                'inv_type' => $data['inv_type'],
                'inv_unit' => $this->post['inv_unit'],
                'inv_manufacture' => $this->post['inv_manid'],
                'inv_base_quantity' => $this->post['inv_base_qty']
            );



            $up = $this->inv_model->upadte_inv($this->post['invid'], $inv_info);

            if ($up) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Item details updated successfully</div>";

                $this->invlist();
            } else {

                $this->output->message = "<div class='error'>Something going wrong</div>";
            }
        } else {


            $data['item'] = $this->inv_model->get_inv(array('inv_id' => $this->post['invid']));

            $this->output->add_to_position($this->load->view('frontend/Inv/add_inv_view', $data, TRUE), $this->post['output_position'], TRUE);
        }
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To delete inventory items.
    // 
    /////////////////////////////////////////
    function del_tyre(){
        // print_r($this->post['tyre_id_new']);die();
        if (empty($this->post['tyre_id_new'])) {
            $this->output->message = "<div class='error'>Please select atleast one item to delete</div>";
            return;
        }
        $ids = $this->post['tyre_id_new'];
        $id = $ids[0];

        $del = array('tyreis_deleted' => '1');


        $status = $this->inv_model->delete_tyre($id, $del);
// die;

        if ($status) {

            $this->output->message = "<div class='success'>Item deleted successfully</div>";

            $this->tyrelist();
        } else {

            $this->output->message = "<div class='error'>Something going wrong</div>";
        }
    }
    function del() {

        if (empty($this->post['invid'])) {
            $this->output->message = "<div class='error'>Please select atleast one item to delete</div>";
            return;
        }


        $del = array('invis_deleted' => '1');


        $status = $this->inv_model->delete_inv($this->post['invid'], $del);


        if ($status) {

            $this->output->message = "<div class='success'>Item deleted successfully</div>";

            $this->invlist();
        } else {

            $this->output->message = "<div class='error'>Something going wrong</div>";
        }
    }

    //// Created by MI42 //////////////////////////////////////////
    // 
    // Purpose : To update inventory items status (Active/Inactive).
    // 
    //////////////////////////////////////////////////////////////


    function status() {

        $sts = get_toggle_sts();

        $status = array('inv_status' => $sts[$this->post['inv_sts']]);

        $status = $this->inv_model->upadte_inv($this->post['invid'], $status);

        if ($status) {

            $this->output->message = "<div class='success'>Item status updated successfully</div>";

            $this->invlist();
        } else {

            $this->output->message = "<div class='error'>Something going wrong</div>";
        }
    }
    
     function invlist_amb() {

        //////////////////////// Filters operations ///////////////////////////


        $data['inv_type'] = ($this->post['inv_type']) ? trim($this->post['inv_type']) : $this->fdata['inv_type'];

       // $data['inv_man'] = (isset($this->post['inv_man'])) ? trim($this->post['inv_man']) : $this->fdata['inv_man'];

        $data['inv_amb'] = (isset($this->post['inv_amb'])) ? trim($this->post['inv_amb']) : $this->fdata['inv_amb'];

       // $data['inv_item'] = (isset($this->post['inv_item'])) ? trim($this->post['inv_item']) : $this->fdata['inv_item'];

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
        
        
      
        //$data['item_total'] = $this->inv_model->get_inv($data);
         $data['item_list'] = $this->inv_model->get_inv_details_list($data );


        $pg_no = get_pgno($data['item_total'], $limit, $pg_no);


        $offset = ($pg_no == 1) ? 0 : ($pg_no * $limit) - $limit;

        //////////////////////////////////////////////////////////////////

        $data['pg_no'] = $pg_no;

        $invflt['INV'] = $data;

        $this->session->set_userdata('filters', $invflt);

        ///////////////////////////////////////////////////////////////////

        unset($data['get_count']);

     
        
       // $data['item_list'] = $this->inv_model->get_inv($data, $offset, $limit);
         $data['item_list'] = $this->inv_model->get_inv_details_list($data, $offset, $limit);




        $data['cur_page'] = $pg_no;

        $pgconf = array(
            'url' => base_url("inv/invlist_amb"),
            'total_rows' => $data['item_total'],
            'per_page' => $limit,
            'cur_page' => $pg_no,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);

            $this->output->add_to_position($this->load->view('frontend/Inv/amb_inv_view', $data, TRUE), $this->post['output_position'], TRUE);

            $this->output->add_to_position($this->load->view('frontend/Inv/inv_amb_filters_view', $data, TRUE), 'inv_filters', TRUE);    
    }
    function tyrelist() {

        //////////////////////// Filters operations ///////////////////////////


        $data['inv_type'] = ($this->post['inv_type']) ? trim($this->post['inv_type']) : $this->fdata['inv_type'];

        $data['inv_man'] = (isset($this->post['inv_man'])) ? trim($this->post['inv_man']) : $this->fdata['inv_man'];

        $data['inv_amb'] = (isset($this->post['inv_amb'])) ? trim($this->post['inv_amb']) : $this->fdata['inv_amb'];

        $data['inv_item'] = (isset($this->post['inv_item'])) ? trim($this->post['inv_item']) : $this->fdata['inv_item'];

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        
        $data['filters'] = ($this->post['filters']) ? $this->post['filters'] : 'yes';

        
        ////////////////////////////////////
        if($this->clg->clg_group == 'UG-EMT' &&  $data['inv_amb'] == ''){
            
                $args = array(
                'tm_emt_id' => $this->clg->clg_ref_id,
                'tm_shift' => $this->post['shift']
            );
          
        $data['amb'] = $this->common_model->get_emt_by_shift($args);
        $data['inv_amb'] =  $data['amb'][0]->tm_amb_rto_reg_id;
       
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
        
        
      
       // $data['item_total'] = $this->inv_model->get_inv($data);
        $data['item_total'] = $this->inv_model->get_tyre_details_list($data);


        $pg_no = get_pgno($data['item_total'], $limit, $pg_no);


        $offset = ($pg_no == 1) ? 0 : ($pg_no * $limit) - $limit;

        //////////////////////////////////////////////////////////////////

        $data['pg_no'] = $pg_no;

        $invflt['INV'] = $data;

        $this->session->set_userdata('filters', $invflt);

        ///////////////////////////////////////////////////////////////////

        unset($data['get_count']);

      
        
        //$data['item_list'] = $this->inv_model->get_inv($data, $offset, $limit);
        $data['item_list'] = $this->inv_model->get_tyre_details_list($data, $offset, $limit);




        $data['cur_page'] = $pg_no;

        $pgconf = array(
            'url' => base_url("inv/tyrelist"),
            'total_rows' => $data['item_total'],
            'per_page' => $limit,
            'cur_page' => $pg_no,
            'attributes' => array('class' => 'click-xhttp-request',
            'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);




        if ($data['inv_amb'] != '') {

            //$this->output->add_to_position($this->load->view('frontend/Inv/amb_inv_view', $data, TRUE), $this->post['output_position'], TRUE);
        } else {



            $this->output->add_to_position($this->load->view('frontend/Inv/tyre_list_view', $data, TRUE), $this->post['output_position'], TRUE);
        }

        if($data['filters'] != 'no'){
            //$this->output->add_to_position($this->load->view('frontend/Inv/inv_filters_view', $data, TRUE), 'inv_filters', TRUE);    
        }
    }
    function add_tyre() {


        //'] = $this->fdata['inv_type'];


        if ($this->post['submit_inv']) {

            $inv_info = array('tyre_title' => addslashes($this->post['tyre_title']),
               // 'tyre_unit' => $this->post['tyre_unit'],
                'tyre_manufacture' => $this->post['tyre_manid'],
                'tyre_base_quantity' => $this->post['tyre_base_qty'],
                'tyre_manufacturing_date' => date('Y-m-d', strtotime($this->post['tyre_manufacturing_date'])),
                'tyre_exp_date' => date('Y-m-d', strtotime($this->post['tyre_exp_date'])),
                'tyre_added_date' => date('Y-m-d H:i:s'),
                'tyreis_status' => '1',
                'tyreis_deleted' => '0');


            $ins = $this->inv_model->insert_tyre($inv_info);

            if ($ins) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Item added successfully</div>";

                $this->tyrelist();
            } else {

                $this->output->message = "<div class='error'>Something going wrong</div>";
            }
        } else {

            $data['action'] = "add";
            $data['item'] = array();

            $this->output->add_to_position($this->load->view('frontend/Inv/add_tyre_view', $data, TRUE), 'popup_div', TRUE);
        }
    }

}
