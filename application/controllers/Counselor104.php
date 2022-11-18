<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Counselor104 extends EMS_Controller {

    var $dtmf, $dtmt; // default time from/to

    function __construct() {

        parent::__construct();

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->load->library(array('session', 'modules'));

        $this->load->model(array('module_model', 'counslor_model','colleagues_model'));

        $this->load->helper(array('comman_helper'));

        $this->post = $this->input->get_post(NULL);

        $this->post['base_month'] = get_base_month();

        $this->clg = $this->session->userdata('current_user');

        $this->today = date('Y-m-d H:i:s');
    }

    public function index($generated = false) {

        $user_group=$this->clg->clg_group;  
        if ($user_group == 'UG-COUNSELOR-104') {
        $pg_no = 1;

        if ($this->uri->segment(3)) {
            $pg_no = $this->uri->segment(3);
        } else if ($this->fdata['pg_no'] && !$this->post['flt']) {
            $pg_no = $this->fdata['pg_no'];
        }

        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];
        $data['from_date'] = ($this->post['from_date']) ? $this->post['from_date'] : $this->fdata['from_date'];
        $data['to_date'] = ($this->post['to_date']) ? $this->post['to_date'] : $this->fdata['to_date'];
        $data['filter']  = ($this->post['filter']) ? $this->post['filter'] : $this->fdata['filter'];
        // var_dump($data['to_date']);die();


        $args = array(
           
            'sub_type' => 'adv'
        );
        $args['filter']=$data['filter'];
        
        if( $data['to_date']  == ''){
            $args['to_date'] = $data['to_date'];
        }
        
        if( $data['from_date']  == ''){
            $args['from_date'] = $data['from_date'];
        }
        $this->pg_limit =10;
        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args['get_count'] = TRUE;
        
        if($this->clg->clg_group == 'UG-COUNSELOR-SUPERVISOR'){           
            
            //$args['ercp_id'] = ($this->post['ercp_id']) ? $this->post['ercp_id'] : $this->fdata['ercp_id'];
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-COUNSELOR-104');
            $data['epcr_clg'] = $this->colleagues_model->get_clg_data($clg_args);
            foreach($data['epcr_clg'] as $ercp){
                $child_ercp[] = $ercp->clg_ref_id;
            }

            if(is_array($child_ercp)){
                $child_ercp = implode("','", $child_ercp);
            }
            //$args['child_ercp'] = $child_ercp;
            
            
        }else{
             $args['opt_id'] = $this->clg->clg_ref_id;
        }

        $args['base_month'] = $this->post['base_month'];
        $data['inc_total'] = $this->counslor_model->get_inc_by_counslor($args);

        $pg_no = get_pgno($data['inc_total'], $limit, $pg_no);


        $offset = ($pg_no == 1) ? 0 : ($pg_no * $limit) - $limit;

        /////////////////////////////////////////////////////////////

        $data['pg_no'] = $pg_no;

        unset($args['get_count']);



        $data['inc_list_help'] = $this->counslor_model->get_inc_by_counslor($args, $offset, $limit);
 

        $data['cur_page'] = $pg_no;

        $pgconf = array(
            'url' => base_url("ercp/index"),
            'total_rows' => $data['inc_total'],
            'per_page' => $limit,
            'cur_page' => $pg_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );

        $data['pagination'] = get_pagination($pgconf);


        /////////////////////////////// Prev Calls /////////////////////////////

        $data['prev_cl_dtl']=array();
        
        foreach ($data['inc_list_help'] as $inc) {

            $args = array(
                'cons_cl_inc_id' => $inc->inc_ref_id,
                'base_month' => $this->post['base_month']
            );
            
            $data['prev_cl_dtl'][$inc->inc_ref_id] = $this->counslor_model->prev_call_cons_list($args);
        } 


        $this->output->add_to_position($this->load->view('frontend/ercp/dashboard_view', $data, TRUE), 'content', TRUE);
         // $this->output->template = "pcr"; 
        if($this->clg->clg_group != 'UG-ConslorSupervisor'){
            $this->output->template = "calls"; 
        }
        }else{
             dashboard_redirect($user_group,$this->base_url );
        }
        
    }
    function prev_counslor_call_info() {


        $args = array(
            'base_month' => $this->post['base_month'],
            'cons_cl_adv_id' => $this->post['cons_cl_adv_id'],
            'cons_cl_id' => $this->post['cons_cl_id']
        );
        $data['cl_dtl'] = $this->counslor_model->prev_call_cons_list($args);
        $this->output->add_to_position($this->load->view('frontend/medadv/prev_call_dtl_counsler_view', $data, TRUE), $this->post['output_position'], TRUE);
    }
    
    function search_call(){
        $data['date'] = str_replace('-', '', date('Y-m-d'));
         
        $this->output->add_to_position($this->load->view('frontend/ercp/inc_search_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "calls";
    }
    function counslor_incoming_call(){
        if (!isset($this->post['inc_ref_id'])) {

            $data['opt_id'] = $this->post['opt_id'];

            $data['sub_id'] = $this->post['sub_id'];

            $args = array('opt_id' => $data['opt_id'],
                'sub_id' => $data['sub_id'],
                'sub_type' => 'ADV');

            update_opt_status($args);

            $args = array(
                'sub_id' => $data['sub_id'],
                'operator_id' => $this->clg->clg_ref_id,
                'operator_type' => $this->clg->clg_group,
                'base_month' => $this->post['base_month'],
                'sub_type' => 'ADV',
                'sub_status' => 'ATNG'
            );



            $this->common_model->assign_operator($args);


            $args = array(
                'opt_id' => $data['opt_id'],
                'sub_id' => $data['sub_id'],
                'base_month' => $this->post['base_month']
            );

            $data['cl_dtl'] = $this->Medadv_model->call_detials($args);
        } else {

            $args = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
            );

            $data['inc_ref_id'] = trim($this->post['inc_ref_id']);

            $this->session->set_userdata('es_inc_ref_id', $this->post['inc_ref_id']);

            //$data['cl_dtl'] = $this->problem_reporting_model->get_grivance_call_detials($args);

            $this->session->set_userdata('caller_information', $data['cl_dtl']);
            $this->session->set_userdata('inc_ref_id', $data['inc_ref_id']);

           // $args_remark = array('re_id' => $data['cl_dtl'][0]->inc_ero_standard_summary);
           // $standard_remark = $this->call_model->get_ero_summary_remark($args_remark);
           // $data['re_name'] = $standard_remark[0]->re_name;
        }

       /* if (empty($data['cl_dtl'])) {
            $this->output->message = "<p>No Record Found</p>";

            return;
        }*/
        $this->output->add_to_position($this->load->view('frontend/amb_erc/incoming_counslor_inc_details_view', $data, TRUE), 'content', TRUE);
    }
    function ero_call_details() {


        
            $data['opt_id'] = $this->post['opt_id'];
            
            $data['sub_id'] = $this->post['sub_id'];
        if (!isset($this->post['inc_ref_id'])) {
           // echo "jo";
            //var_dump($this->post['sub_id']);
           // die();

            $data['opt_id'] = $this->post['opt_id'];
            
            $data['sub_id'] = $this->post['sub_id'];
            

            ////////////////////////////////////////////////////////////


            $args = array(
                'opt_id' => $data['opt_id'],
                'sub_id' => $data['sub_id'],
                //'inc_ref_id' => $data['adv_inc_ref_id'],
                'clr_mobile' => $data['mobile_no'],
                'base_month' => $this->post['base_month']
            );

            $data['cl_dtl'] = $this->Medadv_model->call_detials($args);
            
            

            $this->session->set_userdata('ercp_inc_ref_id', $data['cl_dtl'][0]->adv_inc_ref_id);

            $inc_args = array(
                'inc_ref_id' => $data['cl_dtl'][0]->adv_inc_ref_id,
                'base_month' => $this->post['base_month']
            );

            $data['pt_info'] = $this->Pet_model->get_ptinc_info($inc_args);

            $data['patient_id'] = $data['pt_info'][0]->ptn_id;

            $args_pur = array('pcode' => $data['pt_info'][0]->inc_type);
            $call_pur = $this->inc_model->get_purpose_call($args_pur);
            $data['pname'] = $call_pur[0]->pname;

            $data['patient_info'] = $this->pcr_model->get_pat_by_inc($inc_args);
            $data['amb_data'] = $this->inc_model->get_inc_details($inc_args);
        } else {
           // echo "jqwo";
            $data['sub_id'] = $this->post['sub_id'];

            $args_ercp = array(
                'inc_ref_id' => trim($this->post['inc_ref_id']),
                'clr_mobile' => trim($this->post['mobile_no']),
                
                // 'base_month' => $this->post['base_month']
            );


            $this->session->set_userdata('ercp_inc_ref_id', $this->post['inc_ref_id']);
            //var_dump($args_ercp);

            $data['cl_dtl'] = $this->Medadv_model->get_ercp_call_detials($args_ercp);
            
            
           $args = array(
                'inc_ref_id' => $data['cl_dtl'][0]->adv_inc_ref_id,
  
            );


            $data['pt_info'] = $this->Pet_model->get_ptinc_info($args);
            $data['amb_data'] = $this->inc_model->get_inc_details($args);

            $data['questions'] = $this->inc_model->get_inc_summary($args);

            $data['patient_info'] = $this->pcr_model->get_pat_by_inc($args);
            $data['patient_id'] = $data['pt_info'][0]->ptn_id;
            $args_pur = array('pcode' => $data['pt_info'][0]->cl_purpose);
            //  $args_pur = array('pcode' =>trim($data['pt_info'][0]->inc_type));
            $call_pur = $this->inc_model->get_purpose_call($args_pur);
            $data['pname'] = $call_pur[0]->pname;


            $args_remark = array('re_id' => $data['pt_info'][0]->inc_ero_standard_summary);
            $standard_remark = $this->call_model->get_ero_summary_remark($args_remark);
            $data['re_name'] = $standard_remark[0]->re_name;
        }

        if (empty($data['cl_dtl'])) {
            $this->output->message = "<p>No Record Found</p>";

            return;
        }
        $args = array(
            'adv_cl_inc_id' => $data['cl_dtl'][0]->adv_inc_ref_id,
            'base_month' => $this->post['base_month']
        );


        $data['prev_cl_dtl'] = $this->Medadv_model->prev_call_adv($args);


        $args_pat = array(
            'adv_cl_ptn_id' => $data['pt_info'][0]->ptn_id,
            'adv_cl_base_month' => $this->post['base_month'],
            'adv_cl_inc_id' => $this->post['inc_ref_id'],
        );

        $data['medadv_info'] = $this->Medadv_model->get_medadv_by_inc($args_pat);

        ////////////////////////////////////////////////////////////////
        $data['help_standard_remark'] = $this->call_model->get_ero_summary_remark(array('re_id' => $data['pt_info'][0]->help_standard_summary));

        $this->output->add_to_position($this->load->view('frontend/medadv/amb_details_view', $data, TRUE), 'content', TRUE);

        $this->output->set_focus_to = "madv_loc";

        $this->output->add_to_position($this->load->view('frontend/medadv/inc_details_view', $data, TRUE), 'content', TRUE);

//        $this->output->add_to_position("<span>ERCP Call </span>", 'section_title', TRUE);
    }

}
