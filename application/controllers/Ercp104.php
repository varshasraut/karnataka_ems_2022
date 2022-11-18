<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ercp104 extends EMS_Controller {

    var $dtmf, $dtmt; // default time from/to

    function __construct() {

        parent::__construct();

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->load->library(array('session', 'modules'));

        $this->load->model(array('module_model', 'Medadv_model','colleagues_model'));

        $this->load->helper(array('comman_helper'));

        $this->post = $this->input->get_post(NULL);

        $this->post['base_month'] = get_base_month();

        $this->clg = $this->session->userdata('current_user');

        $this->today = date('Y-m-d H:i:s');
    }

    public function index($generated = false) {

        $user_group=$this->clg->clg_group;  
        if ($user_group == 'UG-ERCP-104') {
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

        $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;


        $args['get_count'] = TRUE;
        
        if($this->clg->clg_group == 'UG-ERCPSupervisor'){           
            
            //$args['ercp_id'] = ($this->post['ercp_id']) ? $this->post['ercp_id'] : $this->fdata['ercp_id'];
            $args['clg_senior'] = $this->clg->clg_ref_id;
            $data['clg_senior'] = $this->clg->clg_ref_id;
            
            
            $clg_args = array('clg_senior'=>$this->clg->clg_ref_id,'clg_group'=>'UG-ERCP-104');
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


        $data['inc_total'] = $this->Medadv_model->get_inc_by_helpdesk_ercp($args);

        $pg_no = get_pgno($data['inc_total'], $limit, $pg_no);


        $offset = ($pg_no == 1) ? 0 : ($pg_no * $limit) - $limit;

        /////////////////////////////////////////////////////////////

        $data['pg_no'] = $pg_no;

        unset($args['get_count']);



        $data['inc_list_help'] = $this->Medadv_model->get_inc_by_helpdesk_ercp($args, $offset, $limit);
 

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
                'adv_cl_inc_id' => $inc->inc_ref_id,
                'base_month' => $this->post['base_month']
            );
            
            $data['prev_cl_dtl'][$inc->inc_ref_id] = $this->Medadv_model->prev_call_adv_help($args);
        }


        $this->output->add_to_position($this->load->view('frontend/ercp/dashboard_view', $data, TRUE), 'content', TRUE);
         // $this->output->template = "pcr"; 
        if($this->clg->clg_group != 'UG-ERCPSupervisor'){
            $this->output->template = "calls"; 
        }
        }else{
             dashboard_redirect($user_group,$this->base_url );
        }
        
    }

    function call_his() {

    }
    function search_call(){
        $data['date'] = str_replace('-', '', date('Y-m-d'));
         
        $this->output->add_to_position($this->load->view('frontend/ercp/inc_search_view', $data, TRUE), 'content', TRUE);
        $this->output->template = "calls";
    }

}
