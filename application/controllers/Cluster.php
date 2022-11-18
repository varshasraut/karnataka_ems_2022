<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cluster extends EMS_Controller {
    
    function __construct() {

        parent::__construct();

        $this->active_module = "M-CLUSTER";

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->load->model(array('common_model', 'cluster_model', ));

        $this->load->helper(array('url', 'comman_helper'));

        $this->load->library(array('session', 'modules'));

        $this->clg = $this->session->userdata('current_user');

        $this->post = $this->input->get_post(NULL);

        $this->post['base_month'] = get_base_month();

        $this->cur_usr = $this->session->userdata('current_user');

    }

    public function index($generated = false) {

        echo "This is Cluster controller";
    }
    
    public function list_cluster(){
        
        //////////////////////// Filters operations ///////////////////////////

        $data['cluster_search'] = (isset($this->post['cluster_search'])) ? trim($this->post['cluster_search']) : $this->fdata['cluster_search'];


        $data['pg_rec'] = ($this->post['pg_rec']) ? $this->post['pg_rec'] : $this->fdata['pg_rec'];


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


        $data['cluster_total'] = $this->cluster_model->get_cluster_data($data);


        $pg_no = get_pgno($data['cluster_total'], $limit, $pg_no);


        $offset = ($pg_no == 1) ? 0 : ($pg_no * $limit) - $limit;
        $data['offset'] = $offset;

        //////////////////////////////////////////////////////////////////

        $data['pg_no'] = $pg_no;

        $Cluflt['CLUSTER'] = $data;

        $this->session->set_userdata('filters', $Cluflt);

        ///////////////////////////////////////////////////////////////////

        unset($data['get_count']);

        $data['cluster_list'] = $this->cluster_model->get_cluster_data($data, $offset, $limit);

        $data['cur_page'] = $pg_no;

        $pgconf = array(
            'url' => base_url("cluster/list_cluster"),
            'total_rows' => $data['cluster_total'],
            'per_page' => $limit,
            'cur_page' => $pg_no,
            'attributes' => array('class' => 'click-xhttp-request',
                'data-qr' => "output_position=content&amp;pglnk=true"
            )
        );



        $data['pagination'] = get_pagination($pgconf);


        $this->output->add_to_position($this->load->view('frontend/cluster/cluster_list_view', $data, TRUE), $this->post['output_position'], TRUE);
  
        $this->output->add_to_position($this->load->view('frontend/cluster/cluster_filters_view', $data, TRUE), 'cluster_filters', TRUE);
    }
    function add_cluster(){
        
        if ($this->post['action']) {

            $cluster_info = array('district' => $this->post['cluster_district'],
                'taluka' => $this->post['cluster_tahsil'],
                'isdeleted' => '0',
                'added_by' => $this->clg->clg_ref_id,
                'added_date' => date('Y-m-d H:i:s'),
                'modify_by' => $this->clg->clg_ref_id,
                'modify_date' => date('Y-m-d H:i:s'));


            $args = array_merge($this->post['cluster'], $cluster_info);
            
            $ins = $this->cluster_model->insert_cluster($args);

            if ($ins) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Cluster added successfully</div>";

                $this->list_cluster();
            } else {

                $this->output->message = "<div class='error'>Something going wrong</div>";
            }
        } else {

            $data['action'] = "add";

            $this->output->add_to_popup($this->load->view('frontend/cluster/add_cluster_view', $data, TRUE), '600', '560');
        }
        
        
    }
    function edit_cluster(){
        $data['clu_action'] = $this->post['clu_action'];
        
        if ($this->post['cluster_id'] != '') {
            $cluster_id = array_map("base64_decode", $this->post['cluster_id']);
        }
        if ($this->post['action'] == 'submit') {

            $cluster_info = array('district' => $this->post['cluster_district'],
                'taluka' => $this->post['cluster_tahsil'],
                'isdeleted' => '0',
                'modify_by' => $this->clg->clg_ref_id,
                'modify_date' => date('Y-m-d H:i:s'));


            $args = array_merge($this->post['cluster'], $cluster_info);
            
            $ins = $this->cluster_model->update_cluster($args,$cluster_id);

            if ($ins) {

                $this->output->status = 1;
                $this->output->closepopup = "yes";
                $this->output->message = "<div class='success'>Cluster Updated successfully</div>";

                $this->list_cluster();
            } else {

                $this->output->message = "<div class='error'>Something going wrong</div>";
            }
        }else{
            $arg = array('cluster_id' => $cluster_id[0]);

            $data['cluster'] = $this->cluster_model->get_cluster_data($arg);
            $this->output->add_to_popup($this->load->view('frontend/cluster/add_cluster_view', $data, TRUE), '600', '560');
        }
    }
    public function delete_cluster() {

        if (empty($this->post['cluster_id'])) {
            $this->output->message = "<div class='error'>Please select atleast one Cluster to delete</div>";
            return;
        }


        $del = array('isdeleted' => '1');


        $status = $this->cluster_model->delete_cluster($this->post['cluster_id'], $del);


        if ($status) {

            $this->output->message = "<div class='success'>Cluster deleted successfully</div>";

            $this->medlist();
        } else {

            $this->output->message = "<div class='error'>Something going wrong</div>";
        }
    }
    function get_auto_po(){
        $data['atc_id'] = $this->post['atc_id'];
      
        $this->output->add_to_position($this->load->view('frontend/common/auto_po_view', $data, TRUE), 'get_auto_po_by_atc', TRUE);
    }

}