<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-API";
        $this->pg_limit = $this->config->item('pagination_limit');

        $this->gps_url = $this->config->item('amb_gps_url');

        $this->bvgtoken = $this->config->item('bvgtoken');

 

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper'));



        $this->load->model(array('call_model','inc_model', 'get_city_state_model', 'options_model', 'module_model', 'common_model', 'Pet_model', 'Ercp_model', 'amb_model'));



        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));


	    $this->clg = $this->session->userdata('current_user');
        //$this->post = $this->input->get_post(NULL);



    }



    public function index($generated = false) {



        echo "This is API controller";

    }

	

	public function regcaller(){

	

		$caller = array();
        $post = json_decode( file_get_contents( 'php://input' ));

		$caller["clr_mobile"] = $post->caller;

		$caller["clr_fullname"] = $post->caller_name;


		$caller["clr_type"] = "NOR";

		$caller["clr_tahshil"] = 0;
   

		

		$clr_id = $this->call_model->insert_caller_details($caller);

		

	    return $clr_id;

	}

	

	public function regcall($caller_id){

		   

		    $current_date = date('Y-m-d');



            $base_month = $this->common_model->get_base_month($current_date);

			

            $call_data = array('cl_base_month' => $base_month[0]->months,

                    'cl_clr_id' => $caller_id,

                    'clr_ralation' => 1,

                    'cl_purpose' => "nonmci",

                    'cl_datetime' => date('Y-m-d H:i:s')

                );

		$call_id = $this->call_model->insert_call_details($call_data);

	    return $call_id;

		}

		

    public function _record_call(){

		$output = array();

		$post = array();

		$post  = json_decode( file_get_contents( 'php://input' ));

		

	     $clr_id = $this->regcaller();

		 

		 if($clr_id != ""){

			 

			 $call_id = $this->regcall($clr_id);

			 

		 }

		

        

        $district_id = "0";

        $city_id = "0";

        $state_id = "0";
        



        $state_id = $this->inc_model->get_state_id($post->inc_state);

        $district_id = $this->inc_model->get_district_id($post->inc_district);

        $city_id = $this->inc_model->get_city_id($post->inc_city_villege_town);



        if (isset($district_id)) {



            $district_id = $district_id->dst_code;

        } else {



            $district_id = "0";

        }



        if (isset($city_id)) {



            $city_id = $city_id->cty_id;

        } else {



            $city_id = "0";

        }



        if (isset($state_id)) {



            $state_id = $state_id->st_code;

        } else {



            $state_id = "0";

        }



        $datetime = date('Y-m-d H:i:s');

      ///  $inc_details_service = serialize($inc_details['service']);



        $sft_id = '';



        $shift_time = explode(":", date('H:i:s'));



        if ($shift_time[0] >= 0 && $shift_time[0] <= 6) {



            $sft_id = 3;

        }if ($shift_time[0] >= 6 && $shift_time[0] <= 16) {



            $sft_id = 1;

        }if ($shift_time[0] >= 16 && $shift_time[0] <= 23) {



            $sft_id = 2;

        }

        if( $inc_post_details['incient_state'] == ''){

             $inc_post_details['incient_state'] = "MP";

        }



        $current_date = date('Y-m-d');



        $base_month = $this->common_model->get_base_month($current_date);

        $incidence_details = array('inc_cl_id' => $call_id,

            'inc_ref_id' => 'INC-' . $call_id,

            'inc_patient_cnt' => $post->inc_no_of_patient,

			'inc_complaint' => '79',

            'inc_type' => 'non-mci',

            'inc_ero_summary' => $post->ero_summary,

            'inc_city' => $post->inc_city_villege_town,

            'inc_city_id' => $city_id,

            'inc_state' => $state_id,

            'inc_state_id' => $state_id,

            'inc_address' => "",

            'inc_district' => $district_id,

            'inc_district_id' => $district_id,

			'inc_tahshil' => "",

            'inc_area' => $post->inc_area_location,

            'inc_landmark' => $post->inc_landmark,

            'inc_lane' => $post->inc_lane_street,

            'inc_h_no' => $post->inc_house_number,

            'inc_pincode' => $post->inc_pin_code,

            'inc_lat' => $post->inc_lat,

            'inc_long' => $post->inc_long,

            'inc_datetime' => date('Y-m-d H:i:s'),

            'inc_service' => "",

            'inc_duplicate' => "",

            'inc_base_month' => $base_month[0]->months,

			'inc_bvg_ref_number'=> $post->event_id

        );


		$incidenace_id = $this->inc_model->insert_inc($incidence_details);

		 

		if($incidenace_id){	

		$output["status"] = 1;

		$output["inc_id"] = $incidence_details['inc_ref_id'];

		$output["msg"] = "Incidence recorded successfully!";

		return $output;

		}else{

  		$output["status"] = 0;

		$output["msg"] = "Incidence recorded successfully!";

		return $output;



		  

		}

		

		}

	

    public function receiver(){

		
//
//		$output = array();
//
//		$post = array();
//
		$post = json_decode( file_get_contents( 'php://input' ));
  
        
		if($post->token == ""){

		$output["status"] = 0;

		$output["msg"] = "Token Missing";

		echo json_encode($output);

		die();

		

		

		}else if($post->token != "4b128c26f9757ecaa07c688d9c5b71aa70c060bf2e3a16d70838442cf963cf1f"){

		$output["status"] = 0;

		$output["msg"] = "Incorrect Token";

		echo json_encode($output);

		die();

		}

      		

		if($post->event_id == ""){

		$output["status"] = 0;

		$output["msg"] = "event Id  Missing";

		echo json_encode($output);

		die();

		

		

		}



   		if(!in_array($post->type,array("call","sms"))){

			

				$output["status"] = 0;

				$output["msg"] = "Invalid Request";

				echo json_encode($output);

				die();

		

		}



	 

		if($post->type == "call"){

			

			$output = $this->_record_call();

			}

		

		if($post->type == "sms"){

			$output =  $this->_send_sms();

			}

			

		echo json_encode($output);

		die();

    }
     function police_api_receiver(){
       
        $php_input =  file_get_contents( 'php://input' );       
        $post = json_decode( $php_input,true);
      
        
        if(json_last_error()){ 
            echo json_encode(array('status'=>'fail','message'=>"Wrong json data!"));
            die();  
        }
       
		$post_encode = json_encode($post);
        
        if (!is_dir('./logs/' . date("Y-m-d"))) {
            mkdir('./logs/' . date("Y-m-d"), 0755, true);
        }
       
       
		file_put_contents('./logs/'.date("Y-m-d").'/police_api_log.log', $post_encode.",\r\n", FILE_APPEND);
       
         
        $pda = $this->call_model->get_pda_free_user_exists();
        $pda_user = $this->call_model->get_pda_user_exists();
        if(!empty($pda)){
            $pda_name  = $pda[0]->user_ref_id;
        }else if(!empty($pda_user)){
            $pda_name  = $pda_user[0]->user_ref_id;
        }else{
            $pda_name  = "NOT_ASSIGN";
        }
       
        $pda_api_ref_id = generate_pda_api_ref_id();
        $data['emg_callerno'] = $post['callerNo'];
        $data['emg_callername'] =$post['callerName'];
        $data['emg_patientname'] =$post['patientName'];
        $data['emg_patientage'] =$post['patientAge'];
        $data['emg_patientgender'] =$post['patientGender'];
        $data['emg_incidentadd'] =$post['incidentAdd'];
        $data['emg_incidentlat'] =$post['incidentLat'];
        $data['emg_incidentlng'] =$post['incidentLng'];
        $data['emg_cheifcompliant'] =$post['incidentDist'];
        $data['emg_typeofcall'] =$post['eventType'];
        $data['emg_cheifcompliant'] =$post['subeventType'];
        $data['emg_added_date'] = date('Y-m-d H:i:s');
        $data['call_status']='assign';
        $data['asign_pda']=$pda_name;
        $data['emg_cad_inc_id']=$post['CADIncidentID'];
        $data['pda_api_ref_id']=$pda_api_ref_id;
       
        $rec = $this->inc_model->insertEmgVehDis($data);

        if($rec == 1){
            echo json_encode(array('code'=>'1','IncidentID'=>$pda_api_ref_id,'message'=>"Record Successfully Added"));
            die();
        }else{
             echo json_encode(array('code'=>'0','message'=>"Wrong data!"));
            die();
        }
    
    }

    


} 

