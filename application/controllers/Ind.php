<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ind extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-INV";

        $this->load->model(array('common_model', 'inv_model', 'manufacture_model', 'ind_model', 'inv_stock_model', 'school_model', 'fleet_model'));

        $this->load->helper(array('url', 'comman_helper'));

        $this->load->library(array('session', 'modules'));

        $this->post = $this->input->get_post(NULL);

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->clg = $this->session->userdata('current_user');

        $this->post['base_month'] = get_base_month();

        $this->post['shift'] = get_cur_shift();


        $this->today = date('Y-m-d H:i:s');

        if ($this->session->userdata('filters')['IND']) {
            $this->fdata = $this->session->userdata('filters')['IND'];
        }
        
        $this->indent_path= $this->config->item('indent_path');
    }

    function index($generated = false) {

        echo "This is Indent controller";
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To add stock request.
    // 
    /////////////////////////////////////////

    function req() {


        if ($this->post['submit_req']) {


            $item_key = array('CA', 'NCA', 'MED', 'EQP');


            ////////////////////////////////////////////////

            $eflag = "Yes";

            foreach ($item_key as $key) {

                foreach ($this->post['item'][$key] as $item) {

                    if ($item['id'] != '') {
                        $eflag = "No";
                    }
                }
            }


            if ($eflag == "Yes") {
                $this->output->message = "<div class='error'>Please request for atleast one item.</div>";
                return;
            }

            ////////////////////////////////////////////////


            if ($this->clg->clg_group == 'UG-EMT' || $this->clg->clg_group == 'UG-HEALTH-SUP' || $this->clg->clg_group == 'UG-SICK-SUP') {

                $emt_id = $this->clg->clg_ref_id;
            }

            /////////////////////////////////////////////////////////////


            $args = array(
                'req_emt_id' => $emt_id,
                'req_date' => $this->today,
                'req_base_month' => $this->post['base_month'],
                'req_by' => $this->clg->clg_ref_id,
                'req_type' => $this->post['req_type']
            );

            if ($this->post['req_type'] == 'sick_room') {
                $args['req_school_id'] = $this->post['school_id'];
            }
            if ($this->post['req_type'] == 'amb') {
                $args['req_amb_reg_no'] = $this->post['amb_reg_no'];
            }


            $req = $this->ind_model->insert_ind_req($args);

            /////////////////////////////////////////////////////////////


            foreach ($item_key as $key) {

                foreach ($this->post['item'][$key] as $dt) {

                    if (!empty($dt['id'])) {

                        $ind_data = array(
                            'ind_item_id' => $dt['id'],
                            'ind_quantity' => $dt['qty'],
                            'ind_item_type' => $key,
                            'ind_req_id' => $req,
                        );

                        // var_dump($ind_data);
                        $result = $this->ind_model->insert_ind($ind_data);
                    }
                }
            }

            if ($result) {

                $this->output->message = "<div class='success'>Indent request submit successfully</div>";

                $this->output->add_to_position('', 'content', TRUE);
            }
        } else {

            $args = array(
                'tm_emt_id' => $this->clg->clg_ref_id,
                'tm_shift' => $this->post['shift']
            );

            $data['amb'] = $this->common_model->get_emt_by_shift($args);
            $data['clg_group'] = $this->clg->clg_group;
            $data['cluster_id'] = $this->clg->cluster_id;
            $data['clg_ref_id'] = $this->clg->clg_ref_id;



            /////////////////////////////////////////////////////////////////////

            $this->output->add_to_position($this->load->view('frontend/Inv/Ind/ind_req_view', $data, TRUE), 'content', TRUE);

            ////////////////////////////////////////////////////////////////////

            $this->output->add_to_position('', 'pcr_top_steps', TRUE);

            $this->output->add_to_position('', 'pcr_progressbar', TRUE);
        }


        $this->output->add_to_position('<script>reset_mi_cookie();</script>', 'custom_script', TRUE);
    }

    //////////////MI44//// Purpose : Indent List/////////

    function ind_list($req_type = '') {

        /////////////////filter///////////////////////
        if ($this->post['req_type'] == '') {
            $req_type = $req_type;
        } else {
            $req_type = ($this->post['req_type']);
        }


        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];

        $data['req_type'] = ($this->post['req_type']) ? $this->post['req_type'] : 'amb';

        $indflt['IND'] = $data;

        ///////////set page number//////////////////////////////

        $page_no = 1;

        $page_no = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : ($this->fdata['page_no'] && !$this->post['flt']) ? $this->fdata['page_no'] : "";

        ////////////////////////////////////////////////////////

        $data['get_count'] = TRUE;

        $current_user = $this->session->userdata('current_user');

        if (($current_user->clg_group != 'UG-ADMIN') && ($current_user->clg_group != 'UG-SUPP-CH') && ($current_user->clg_group != 'UG-DM')) {

            $data['ref_id'] = $current_user->clg_ref_id;
        }

        ($current_user->clg_group == 'UG-SUPP-CH') ? $data['cluster_id'] = $current_user->cluster_id : "";
        ($current_user->clg_group == 'UG-DM') ? $data['cluster_id'] = $current_user->cluster_id : "";

        if ($req_type == 'sick_room') {

            $data['total_count'] = $this->ind_model->get_sick_indent_item($data);
        } else {

            $data['total_count'] = $this->ind_model->get_indent_item($data);
        }


        //////////////////////////////////////////////////////////////////

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;


        /////////////////////////////////////////////////////////

        $data['page_no'] = $page_no;

        $indflt['IND'] = $data;

        $this->session->set_userdata('filters', $indflt);

        /////////////////////////////////////////////////////

        unset($data['get_count']);

        //$data['result'] = $this->ind_model->get_indent_item($data, $offset, $limit);
        if ($req_type == 'sick_room') {

            $data['result'] = $this->ind_model->get_sick_indent_item($data, $offset, $limit);
        } else {

            $data['result'] = $this->ind_model->get_indent_item($data, $offset, $limit);
        }



        $pgconf = array(
            'url' => base_url("ind/ind_list"),
            'total_rows' => $data['total_count'],
            'per_page' => $limit,
            'cur_page' => $page_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);

        $data['clg_group'] = $current_user->clg_group;

        $this->output->add_to_position($this->load->view('frontend/Inv/Ind/ind_list_view', $data, TRUE), '', TRUE);

        ////////////////////////////////////////////////////////////////////

        $this->output->add_to_position('', 'pcr_top_steps', TRUE);

        $this->output->add_to_position('', 'pcr_progressbar', TRUE);
    }

    //////////////MI44//// Purpose:View Indent Details/////////

    function view_ind_details() {


        if ($this->post['req_id'] != '') {
            $data['req_id'] = $ref_id = base64_decode($this->post['req_id']);
            $data['indent_data'] = $this->fleet_model->get_all_indent_item($data, $offset, $limit);
        }

        $data1['req_id'] = base64_decode($this->post['req_id']);
         $data1['amb_no'] = base64_decode($this->post['amb_no']);
       // var_dump($data1['req_id']);
        $data['result'] = $this->ind_model->get_indent_data($data1);
        $data['clg_group'] = $this->clg->clg_group;
        $data['action'] = $this->post['action'];
        //var_dump($data['result']);

        $data['amb_no'] = $this->post['amb_no'];

        $data['radmin'] = ($data['action'] == 'rec' && $data['clg_group'] == 'UG-ADMIN') ? 'radmin' : '';


        if ($this->post['action'] == 'rec') {
            $data['action_type'] = 'Receive Indent';
        } elseif ($this->post['action'] == 'view') {
            $data['action_type'] = 'View Indent';
        } elseif ($this->post['action'] == 'apr') {
            $data['action_type'] = 'Approve Indent';
        }  elseif ($this->post['action'] == 'Update') {
            $data['action_type'] = 'Update Indent';
        } else {
            $data['action_type'] = 'Dispatch Indent';
        }

        $this->output->add_to_position($this->load->view('frontend/Inv/Ind/view_indent_details', $data, TRUE), '', TRUE);
    }

    ////////////////MI42////////////////////
    //
    //Purpose:Dispatch Ind request.
    //
    ////////////////////////////////////////

    function dispatch() {

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
                'req_dis_date' => $this->today
            );

            $req = $this->ind_model->update_ind_req($args);


            /////////////////////////////////////////////////////

            $this->output->status = 1;

            $this->output->closepopup = "yes";

            $this->output->message = "<h3>Dispatch Items</h3><br><p>Items dispatched successfully</p>";

            $this->ind_list($req_type);
        }
    }

    ////////////////MI42////////////////////
    //
    //Purpose:Received ind request by EMT.
    //
    ////////////////////////////////////////

    function receive() {



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

            $this->ind_list($req_type);
        }
    }

    function ambulance_stock() {

        if ($this->clg->clg_group == 'UG-EMT') {
            $args = array(
                'tm_emt_id' => $this->clg->clg_ref_id,
                'tm_shift' => $this->post['shift']
            );

            $data['amb'] = $this->common_model->get_emt_by_shift($args);
            $data['inv_amb'] = $data['amb'][0]->tm_amb_rto_reg_id;
        }

        if ($this->clg->clg_group == 'UG-HEALTH-SUP' || $this->clg->clg_group == 'UG-SICK-SUP') {

            $res = $this->school_model->get_school_type(array('health_sup' => $this->clg->clg_ref_id));

            $data['inv_amb'] = $res[0]->school_id;
        }

          $data['inv_amb'] = 'amb';


        $this->output->add_to_position($this->load->view('frontend/Inv/amb_stk_view', $data, TRUE), 'content', TRUE);
    }

    function approve_ind_details() {
        $req_type = $this->post['req_type'];

        $args = array(
            'req_id' => $this->post['req_id'],
            'req_is_approve' => '1',
        );

        $req = $this->ind_model->update_ind_req($args);
        $this->output->message = "<p>Items Approved Successfully</p>";

        $this->ind_list($req_type);
    }
        function download_link(){
        
        $stud_id = base64_decode($this->input->post('student_id'));
        $student_id = base64_decode($this->input->post('student_id'));
        
        $dis_file_name = $this->indent_path.'/indent_'.$student_id.'.pdf';
        
        $url = base_url().'ind/download_ind?student_id='.$stud_id;
        $js_url = FCPATH."healthcard_pdf_script.js";
        $phontam_js = "/var/wamp/www/phantomjs/phantomjs-1.9.8-linux-x86_64/bin/phantomjs";
      
        $output =  shell_exec("$phontam_js $js_url $url $dis_file_name");
        
       // if($output == 'success'){
            
          
            $fullfile = FCPATH.$dis_file_name;
            $pdf_file_name = 'healthcard_'.$student_id.'.pdf';

            $fsize = filesize( $fullfile );
            
            header('Content-Description: File Transfer');
            header('Content-type:application/octet-stream ');
            header("Content-Length:".$fsize); 
            header('Content-Disposition:attachment; filename='.$pdf_file_name);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            readfile($fullfile);
          //  unlink($pdf_file);
            exit();

       // }
        
    }
       function download_ind(){
       
       
        if ($this->post['req_id'] != '') {
            $data['req_id'] = $ref_id = base64_decode($this->post['req_id']);
            $data['indent_data'] = $this->fleet_model->get_all_indent_item($data, $offset, $limit);
        }

        $data1['req_id'] = base64_decode($this->post['req_id']);
         $data1['amb_no'] = base64_decode($this->post['amb_no']);
       // var_dump($data1['req_id']);
        $data['result'] = $this->ind_model->get_indent_data($data1);
        $data['clg_group'] = $this->clg->clg_group;
        $data['action'] = $this->post['action'];
        //var_dump($data['result']);

        $data['amb_no'] = $this->post['amb_no'];

        $data['radmin'] = ($data['action'] == 'rec' && $data['clg_group'] == 'UG-ADMIN') ? 'radmin' : '';


        if ($this->post['action'] == 'rec') {
            $data['action_type'] = 'Receive Indent';
        } elseif ($this->post['action'] == 'view') {
            $data['action_type'] = 'View Indent';
        } elseif ($this->post['action'] == 'apr') {
            $data['action_type'] = 'Approve Indent';
        }  elseif ($this->post['action'] == 'Update') {
            $data['action_type'] = 'Update Indent';
        } else {
            $data['action_type'] = 'Dispatch Indent';
        }

        $this->output->add_to_position($this->load->view('frontend/Inv/Ind/print_view_indent_details', $data, TRUE), '', TRUE);
        
    }
    

}
