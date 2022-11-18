<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Quality extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-QUALITY";
        $this->pg_limit = $this->config->item('pagination_limit');
        $this->load->library(array('session', 'modules'));
        $this->load->model(array('module_model', 'colleagues_model','quality_model'));
        $this->load->helper(array('comman_helper'));
        $this->post = $this->input->get_post(NULL);
        $this->post['base_month'] = get_base_month();
        $this->clg = $this->session->userdata('current_user');

    }

    public function index($generated = false) {
        echo "You are in the Quality controllers";
    }
    
    function ero_team_list(){
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
        $data['qa_team_type'] = 'ERO';

        $data['total_count'] = $this->quality_model->get_qa_team($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;



        unset($data['get_count']);



        $data['maintance_data'] = $this->quality_model->get_qa_team($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("quality/ero_team_list"),
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

        $data['page_records'] = $data['total_count'];
        
        $this->output->add_to_position($this->load->view('frontend/quality/ero_team_list', $data, TRUE), 'content', TRUE);
    }
    
    function ero_team(){
       //$this->output->add_to_position($this->load->view('frontend/quality/ero_team', $data, TRUE), 'content', TRUE);
        $this->output->add_to_popup($this->load->view('frontend/quality/ero_team', $data, TRUE), '500', '300');
    }
    
    function get_ero_list(){
        //$dd = $this->post();
        
        $parent_id = $this->post['ero_supervisor'];
        //var_dump(strtolower($parent_id)); die;
        $args=array('clg_senior'=>$parent_id,
                    'clg_is_assign_to_qa'=>0,
                    'user_group'=>'UG-ERO,UG-ERO-102');
          
        $data['clg_data'] = $this->colleagues_model->get_clg_data($args);
    
        $this->output->add_to_position($this->load->view('frontend/quality/ero_team_view', $data, TRUE), 'ERO_list', TRUE);
        
    }
    
    function save_ero_team(){
        $team = $this->post['team'];

        $ero_team = json_encode($this->post['team_ero']);
        
        $main_data =  array(
                        'team_member' =>$ero_team,
                        'added_by'=> $this->clg->clg_ref_id,
                        'added_date'=> date('Y-m-d H:i:s'),
                        'modify_by'=> $this->clg->clg_ref_id,
                        'modify_date'=> date('Y-m-d H:i:s'),
                        'is_deleted'=> '0',
                        'qa_team_type'=> 'ERO',
                        'qa_base_month'=> $this->post['base_month']);
        $args = array_merge($team, $main_data);
        
        $register_result = $this->quality_model->insert_qa_team($args);
        
        foreach($this->post['team_ero'] as $team_mem){
            
             $team_data =  array(
                        'qa_team_id'=>$register_result,
                        'team_member' =>$team_mem,
                        'added_by'=> $this->clg->clg_ref_id,
                        'added_date'=> date('Y-m-d H:i:s'),
                        'is_deleted'=> '0');
        
        $team_result = $this->quality_model->insert_qa_assign_team($team_data);
        $update_colleage= $this->colleagues_model->update_clg_field($team_mem,'clg_is_assign_to_qa','1');
        }
//        var_dump($register_result);
         if ($register_result) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>ERO Team Allocated Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->ero_team_list();
        }
    }
    
    function dco_team_list(){
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
         $data['qa_team_type'] = 'DCO';

        $data['total_count'] = $this->quality_model->get_qa_team($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;



        unset($data['get_count']);



        $data['maintance_data'] = $this->quality_model->get_qa_team($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("quality/dco_team_list"),
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

        $data['page_records'] = $data['total_count'];
        
        $this->output->add_to_position($this->load->view('frontend/quality/dco_team_list', $data, TRUE), 'content', TRUE);
    }
    
    function dco_team(){
       //$this->output->add_to_position($this->load->view('frontend/quality/dco_team', $data, TRUE), 'content', TRUE);
        $this->output->add_to_popup($this->load->view('frontend/quality/dco_team', $data, TRUE), '500', '300');
    }
    
    function get_dco_list(){
        $parent_id = $this->post['ero_supervisor'];
        $args=array('clg_senior'=>$parent_id,
                    'clg_is_assign_to_qa'=>0,
                    'user_group'=>'UG-DCO,UG-DCO-102');
        
        $data['clg_data'] = $this->colleagues_model->get_clg_data($args);
        $this->output->add_to_position($this->load->view('frontend/quality/dco_team_view', $data, TRUE), 'ERO_list', TRUE);
        
    }
    
    function save_dco_team(){
        $team = $this->post['team'];

        $ero_team = json_encode($this->post['team_ero']);
        
        $main_data =  array(
                        'team_member' =>$ero_team,
                        'added_by'=> $this->clg->clg_ref_id,
                        'added_date'=> date('Y-m-d H:i:s'),
                        'modify_by'=> $this->clg->clg_ref_id,
                        'modify_date'=> date('Y-m-d H:i:s'),
                        'is_deleted'=> '0',
                        'qa_team_type'=> 'DCO',
                        'qa_base_month'=> $this->post['base_month']);
        
        $args = array_merge($team, $main_data);
        
        $register_result = $this->quality_model->insert_qa_team($args);
        
        foreach($this->post['team_ero'] as $team_mem){
            
             $team_data =  array(
                        'qa_team_id'=>$register_result,
                        'team_member' =>$team_mem,
                        'added_by'=> $this->clg->clg_ref_id,
                        'added_date'=> date('Y-m-d H:i:s'),
                        'is_deleted'=> '0');
        
        $team_result = $this->quality_model->insert_qa_assign_team($team_data);
        
        $update_colleage= $this->colleagues_model->update_clg_field($team_mem,'clg_is_assign_to_qa','1');
        
        }
        
         if ($register_result) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>DCO Team Allocated Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->dco_team_list();
        }
    }
    
    function ercp_team_list(){
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
         $data['qa_team_type'] = 'ERCP';

        $data['total_count'] = $this->quality_model->get_qa_team($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;



        unset($data['get_count']);



        $data['maintance_data'] = $this->quality_model->get_qa_team($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("quality/ercp_team_list"),
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

        $data['page_records'] = $data['total_count'];
        
        $this->output->add_to_position($this->load->view('frontend/quality/ercp_team_list', $data, TRUE), 'content', TRUE);
    }
    
    function ercp_team(){
       //$this->output->add_to_position($this->load->view('frontend/quality/dco_team', $data, TRUE), 'content', TRUE);
        $this->output->add_to_popup($this->load->view('frontend/quality/ercp_team', $data, TRUE), '500', '300');
    }
    
    function get_ercp_list(){
        $parent_id = $this->post['ero_supervisor'];
        $args=array('clg_senior'=>$parent_id,
                    'clg_is_assign_to_qa'=>0,
                    'clg_group'=>'UG-ERCP');
        
        $data['clg_data'] = $this->colleagues_model->get_clg_data($args);
        $this->output->add_to_position($this->load->view('frontend/quality/ercp_team_view', $data, TRUE), 'ERO_list', TRUE);
        
    }
    
    function save_ercp_team(){
        $team = $this->post['team'];

        $ero_team = json_encode($this->post['team_ero']);
        
        $main_data =  array(
                        'team_member' =>$ero_team,
                        'added_by'=> $this->clg->clg_ref_id,
                        'added_date'=> date('Y-m-d H:i:s'),
                        'modify_by'=> $this->clg->clg_ref_id,
                        'modify_date'=> date('Y-m-d H:i:s'),
                        'is_deleted'=> '0',
                        'qa_team_type'=> 'ERCP',
                        'qa_base_month'=> $this->post['base_month']);
        $args = array_merge($team, $main_data);
        
        $register_result = $this->quality_model->insert_qa_team($args);
        
        foreach($this->post['team_ero'] as $team_mem){
            
             $team_data =  array(
                        'qa_team_id'=>$register_result,
                        'team_member' =>$team_mem,
                        'added_by'=> $this->clg->clg_ref_id,
                        'added_date'=> date('Y-m-d H:i:s'),
                        'is_deleted'=> '0');
        
        $team_result = $this->quality_model->insert_qa_assign_team($team_data);
        $update_colleage= $this->colleagues_model->update_clg_field($team_mem,'clg_is_assign_to_qa','1');
        }
        
         if ($register_result) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>ERCP Team Allocated Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->ercp_team_list();
        }
    }
    
    function griviance_team_list(){
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
         $data['qa_team_type'] = 'GRIVIANCE';

        $data['total_count'] = $this->quality_model->get_qa_team($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;



        unset($data['get_count']);



        $data['maintance_data'] = $this->quality_model->get_qa_team($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("quality/ercp_team_list"),
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

        $data['page_records'] = $data['total_count'];
        
        $this->output->add_to_position($this->load->view('frontend/quality/griviance_team_list', $data, TRUE), 'content', TRUE);
    }
    
    function griviance_team(){
       //$this->output->add_to_position($this->load->view('frontend/quality/dco_team', $data, TRUE), 'content', TRUE);
        $this->output->add_to_popup($this->load->view('frontend/quality/griviance_team', $data, TRUE), '500', '300');
    }
    
    function get_griviance_list(){
        $parent_id = $this->post['ero_supervisor'];
        
        $args=array('clg_senior'=>$parent_id,
                    'clg_is_assign_to_qa'=>0,
                    'clg_group'=>'UG-Grievance');
        
        $data['clg_data'] = $this->colleagues_model->get_clg_data($args);
        
        $this->output->add_to_position($this->load->view('frontend/quality/griviance_team_view', $data, TRUE), 'ERO_list', TRUE);
        
    }
    
    function save_griviance_team(){
        $team = $this->post['team'];

        $ero_team = json_encode($this->post['team_ero']);
        
        $main_data =  array(
                        'team_member' =>$ero_team,
                        'added_by'=> $this->clg->clg_ref_id,
                        'added_date'=> date('Y-m-d H:i:s'),
                        'modify_by'=> $this->clg->clg_ref_id,
                        'modify_date'=> date('Y-m-d H:i:s'),
                        'is_deleted'=> '0',
                        'qa_team_type'=> 'GRIVIANCE',
                        'qa_base_month'=> $this->post['base_month']);
        $args = array_merge($team, $main_data);
        
        $register_result = $this->quality_model->insert_qa_team($args);
        
        foreach($this->post['team_ero'] as $team_mem){
            
            $team_data =  array(
                        'qa_team_id'=>$register_result,
                        'team_member' =>$team_mem,
                        'added_by'=> $this->clg->clg_ref_id,
                        'added_date'=> date('Y-m-d H:i:s'),
                        'is_deleted'=> '0');
        
            $team_result = $this->quality_model->insert_qa_assign_team($team_data);
            $update_colleage= $this->colleagues_model->update_clg_field($team_mem,'clg_is_assign_to_qa','1');
        }
        
         if ($register_result) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Griviance  Team Allocated Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->griviance_team_list();
        }
    }
    
    function feedback_team_list(){
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
         $data['qa_team_type'] = 'FEEDBACK';

        $data['total_count'] = $this->quality_model->get_qa_team($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;



        unset($data['get_count']);



        $data['maintance_data'] = $this->quality_model->get_qa_team($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("quality/feedback_team_list"),
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

        $data['page_records'] = $data['total_count'];
        
        $this->output->add_to_position($this->load->view('frontend/quality/feedback_team_list', $data, TRUE), 'content', TRUE);
    }
    
    function feedback_team(){
       //$this->output->add_to_position($this->load->view('frontend/quality/dco_team', $data, TRUE), 'content', TRUE);
        $this->output->add_to_popup($this->load->view('frontend/quality/feedback_team', $data, TRUE), '500', '300');
    }
    
    function get_feedback_list(){
        $parent_id = $this->post['ero_supervisor'];
     
        $args=array('clg_senior'=>$parent_id,
                    'clg_is_assign_to_qa'=>0,
                    'clg_group'=>'UG-Feedback');
        
        $data['clg_data'] = $this->colleagues_model->get_clg_data($args);
        $this->output->add_to_position($this->load->view('frontend/quality/feedback_team_view', $data, TRUE), 'ERO_list', TRUE);
        
    }
    
    function save_feedback_team(){
        $team = $this->post['team'];

        $ero_team = json_encode($this->post['team_ero']);
        
        $main_data =  array(
                        'team_member' =>$ero_team,
                        'added_by'=> $this->clg->clg_ref_id,
                        'added_date'=> date('Y-m-d H:i:s'),
                        'modify_by'=> $this->clg->clg_ref_id,
                        'modify_date'=> date('Y-m-d H:i:s'),
                        'is_deleted'=> '0',
                        'qa_team_type'=> 'FEEDBACK',
                        'qa_base_month'=> $this->post['base_month']);
        $args = array_merge($team, $main_data);
        
        $register_result = $this->quality_model->insert_qa_team($args);
        
        foreach($this->post['team_ero'] as $team_mem){
            
            $team_data =  array(
                        'qa_team_id'=>$register_result,
                        'team_member' =>$team_mem,
                        'added_by'=> $this->clg->clg_ref_id,
                        'added_date'=> date('Y-m-d H:i:s'),
                        'is_deleted'=> '0');
        
            $team_result = $this->quality_model->insert_qa_assign_team($team_data);
            $update_colleage= $this->colleagues_model->update_clg_field($team_mem,'clg_is_assign_to_qa','1');
        }
        
         if ($register_result) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Feedback Team Allocated Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->feedback_team_list();
        }
    }
    
    function police_team_list(){
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
         $data['qa_team_type'] = 'PDA';

        $data['total_count'] = $this->quality_model->get_qa_team($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;



        unset($data['get_count']);



        $data['maintance_data'] = $this->quality_model->get_qa_team($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("quality/police_team_list"),
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

        $data['page_records'] = $data['total_count'];
        
        $this->output->add_to_position($this->load->view('frontend/quality/police_team_list', $data, TRUE), 'content', TRUE);
    }
    
    function police_team(){
       //$this->output->add_to_position($this->load->view('frontend/quality/dco_team', $data, TRUE), 'content', TRUE);
        $this->output->add_to_popup($this->load->view('frontend/quality/police_team', $data, TRUE), '500', '300');
    }
    
    function get_police_list(){
        $parent_id = $this->post['ero_supervisor'];
     
        $args=array('clg_senior'=>$parent_id,
                    'clg_is_assign_to_qa'=>0,
                    'clg_group'=>'UG-PDA');
        
        $data['clg_data'] = $this->colleagues_model->get_clg_data($args);
        $this->output->add_to_position($this->load->view('frontend/quality/police_team_view', $data, TRUE), 'ERO_list', TRUE);
        
    }
    
    function save_police_team(){
        $team = $this->post['team'];

        $ero_team = json_encode($this->post['team_ero']);
        
        $main_data =  array(
                        'team_member' =>$ero_team,
                        'added_date'=> date('Y-m-d H:i:s'),
                        'modify_by'=> $this->clg->clg_ref_id,
                        'modify_date'=> date('Y-m-d H:i:s'),
                        'is_deleted'=> '0',
                        'qa_team_type'=> 'PDA',
                        'qa_base_month'=> $this->post['base_month']);
        $args = array_merge($team, $main_data);
        
        $register_result = $this->quality_model->insert_qa_team($args);
        
        foreach($this->post['team_ero'] as $team_mem){
            
            $team_data =  array(
                        'qa_team_id'=>$register_result,
                        'team_member' =>$team_mem,
                        'added_by'=> $this->clg->clg_ref_id,
                        'added_date'=> date('Y-m-d H:i:s'),
                        'is_deleted'=> '0');
        
            $team_result = $this->quality_model->insert_qa_assign_team($team_data);
            $update_colleage= $this->colleagues_model->update_clg_field($team_mem,'clg_is_assign_to_qa','1');
        }
        
         if ($register_result) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Police Team Allocated Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->police_team_list();
        }
    }
    
    function fire_team_list(){
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
         $data['qa_team_type'] = 'FDA';

        $data['total_count'] = $this->quality_model->get_qa_team($data);

        $config['per_page'] = $limit = ($data['pg_rec']) ? $data['pg_rec'] : $this->pg_limit;

        $page_no = get_pgno($data['total_count'], $limit, $page_no);

        $offset = ($page_no == 1) ? 0 : ($page_no * $limit) - $limit;

        $data['page_no'] = $page_no;



        unset($data['get_count']);



        $data['maintance_data'] = $this->quality_model->get_qa_team($data, $offset, $limit);

        /////////////////////////

        $data['cur_page'] = $page_no;

        $pgconf = array(
            'url' => base_url("quality/fire_team_list"),
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

        $data['page_records'] = $data['total_count'];
        
        $this->output->add_to_position($this->load->view('frontend/quality/fire_team_list', $data, TRUE), 'content', TRUE);
    }
    
    function fire_team(){
       //$this->output->add_to_position($this->load->view('frontend/quality/dco_team', $data, TRUE), 'content', TRUE);
        $this->output->add_to_popup($this->load->view('frontend/quality/fire_team', $data, TRUE), '500', '300');
    }
    
    function get_fire_list(){
        $parent_id = $this->post['ero_supervisor'];
     
        $args=array('clg_senior'=>$parent_id,
                    'clg_is_assign_to_qa'=>0,
                    'clg_group'=>'UG-FDA');
        
        $data['clg_data'] = $this->colleagues_model->get_clg_data($args);
        $this->output->add_to_position($this->load->view('frontend/quality/fire_team_view', $data, TRUE), 'ERO_list', TRUE);
        
    }
    
    function save_fire_team(){
        $team = $this->post['team'];

        $ero_team = json_encode($this->post['team_ero']);
        
        $main_data =  array(
                        'team_member' =>$ero_team,
                        'added_by'=> $this->clg->clg_ref_id,
                        'added_date'=> date('Y-m-d H:i:s'),
                        'modify_by'=> $this->clg->clg_ref_id,
                        'modify_date'=> date('Y-m-d H:i:s'),
                        'is_deleted'=> '0',
                        'qa_team_type'=> 'FDA',
                        'qa_base_month'=> $this->post['base_month']);
        $args = array_merge($team, $main_data);
        
        $register_result = $this->quality_model->insert_qa_team($args);
        
        foreach($this->post['team_ero'] as $team_mem){
            
            $team_data =  array(
                        'qa_team_id'=>$register_result,
                        'team_member' =>$team_mem,
                        'added_by'=> $this->clg->clg_ref_id,
                        'added_date'=> date('Y-m-d H:i:s'),
                        'is_deleted'=> '0');
        
            $team_result = $this->quality_model->insert_qa_assign_team($team_data);
            $update_colleage= $this->colleagues_model->update_clg_field($team_mem,'clg_is_assign_to_qa','1');
        }
        
        if ($register_result) {
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Fire Team Allocated Successfully!</div>";
            $this->output->closepopup = 'yes';
            $this->fire_team_list();
        }
    }

}