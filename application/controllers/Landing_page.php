<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing_page extends EMS_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Dashboard_model_final', 'dash');
      }
	
	public function index()
	{	
		
		
		$this->load->view('templates/header');
		$this->load->view('dashboard');
		$this->load->view('templates/footer');
		// $data['total_calls'] = $this->dash->get_total_calls();
		// $data['total_calls_handled'] = $this->dash->get_total_calls_handled();
		// $data['total_dispatch'] = $this->dash->get_total_dispatch();
		// $data['agents_available'] = $this->dash->get_agents_available();
		// $data['onRoad_ambulace'] = $this->dash->get_onRoad_available();
		// $data['offRoad_ambulace'] = $this->dash->get_offRoad_available();
		// $data['avg_resp_tm'] = $this->dash->avg_resp_time();
		// $data['total_incoming_call'] = $this->dash->total_incoming_calls();
		// $data['total_active_call'] = $this->dash->total_active_calls();
		// $data['total_closed_call'] = $this->dash->total_closed_calls();
		// $data['queue_call'] = $this->dash->queue_calls();
		// $data['total_dispatch_q'] = $this->dash->total_dispatch_queue();
		// json_encode($data);
		// echo $data['total_calls'];
		
		
	}
	   function logout() {

        //$current_user_data = $this->session->userdata('current_user');
       // $this->session->unset_userdata('temp_usr');

        $this->session->unset_userdata('current_user');

        $this->session->unset_userdata('user_logged_in');

        redirect(base_url()."clg/login");
    }

	public function view()
	{	
		
		$data['total_calls'] = $this->dash->get_total_calls();
		$data['total_calls_handled'] = $this->dash->get_total_calls_handled();
		$data['total_dispatch'] = $this->dash->get_total_dispatch();
		$data['agents_available'] = $this->dash->get_agents_available();
		$data['onRoad_ambulace'] = $this->dash->get_onRoad_available();
		$data['offRoad_ambulace'] = $this->dash->get_offRoad_available();
		$data['avg_resp_tm'] = $this->dash->avg_resp_time();
		$data['total_incoming_call'] = $this->dash->total_incoming_calls();
		$data['total_active_call'] = $this->dash->total_active_calls();
		$data['total_closed_call'] = $this->dash->total_closed_calls();
		$data['queue_call'] = $this->dash->queue_calls();
		$data['total_dispatch_q'] = $this->dash->total_dispatch_queue();
		$data['chart'] = $this->dash->get_data()->result();
		echo json_encode($data);

	}
	public function chartdata()
	{	
		$data['chart'] = $this->dash->get_data()->result();
		echo json_encode($data);
	}

	
}