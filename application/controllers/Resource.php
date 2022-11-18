<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Resource extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->load->model(array('call_model','pet_model', 'add_res_model', 'colleagues_model', 'inc_model', 'pcr_model', 'amb_model'));

        $this->load->helper(array('url', 'comman_helper'));

        $this->post = $this->input->get_post(NULL);

        $this->clg = $this->session->userdata('current_user');
        $this->post['base_month'] = get_base_month();
    }

    public function index($generated = false) {

        echo "This is Add Resources controller";
    }

    ///////////MI44 and MI13////////////////////////
    //
    //Purpose : Get incident and patient info
    //
    ///////////////////////////////////////


    function petinfo() {

        $args = array(
            'inc_ref_id' => trim($this->post['inc_id']),
            'base_month' => $this->post['base_month'],
        );



        if ($this->agent->is_mobile()) {

            $data['agent_mobile'] = 'yes';
        } else {

            $data['agent_mobile'] = 'no';
        }

        $data['pt_info'] = $this->pet_model->get_ptinc_info($args);
        //$data['pt_info'] = $this->Pet_model->get_pt_inc_search($this->post);


        $data['increfid'] = $this->post['inc_id'];

        $data['resource'] = true;

        $data['resource_type'] = $this->post['resource_type'];
        $data['inc_amb'] = $this->inc_model->get_inc_ambulance($args);



        $this->output->add_to_position($this->load->view('frontend/common/incident_info_view', $data, TRUE), 'inc_pt_info', TRUE);
        $this->output->add_to_position($this->load->view('frontend/resource/amb_map_view', $data, TRUE), 'amb_map_view', TRUE);
    }

    ///////////MI44 and MI13////////////////////////
    //
    //Purpose:To save additional details
    //
    ///////////////////////////////////////


    function save() {


        $inc_old_id = $this->post['inc_id'];
        $inc_id = $this->session->userdata('inc_ref_id');
        $caller_details = $this->session->userdata('caller_details');
        $base_month = $this->post['base_month'];
        $call_type = $this->input->get();

        if (is_array($this->post['resource_type'])) {
            $resource_type = $this->post['resource_type'];
        }

        $inc_post_details = $this->session->userdata('inc_post_details');

        $inc_details = $this->session->userdata('mic_details');
        $patient= $this->session->userdata('patient');




        $resource_type = $this->session->userdata('resource_type');

        $call_id = $inc_post_details['call_id'];

        $dup_inc = $inc_details['dup_inc'];
        $EMT = "";
        $pilot = '';

        $district_id = "0";
        $city_id = "0";
        $state_id = "0";

        $state_id = $inc_post_details['incient_state'];
        $district_id = $this->inc_model->get_district_id($inc_details['inc_district'], $state_id->st_code);


        $city_id = $this->inc_model->get_city_id($inc_details['inc_city'], $inc_post_details['incient_district'], $state_id);


        $district_id = $inc_post_details['incient_districts'];


        if (isset($city_id)) {

            $city_id = $city_id->cty_id;
        } else {

            $city_id = "0";
        }



        $inc_details_service = serialize($inc_details['service']);


        if ($inc_post_details['incient_state'] == '') {
            $inc_post_details['incient_state'] = "MP";
        }

        $inc_id = $this->session->userdata('inc_ref_id');
        
         $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_id));
        if(!empty($is_exits)){
            $this->session->set_userdata('inc_ref_id','');
            $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
            return;
        }
        
        $datetime = date('Y-m-d H:i:s');
        $incidence_details = array('inc_cl_id' => $call_id,
            'inc_ref_id' => $inc_id,
            'inc_type' => 'AD_SUP_REQ',
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_avaya_uniqueid' => $this->session->userdata('CallUniqueID'),
            'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
            'inc_dispatch_time' => $inc_details['caller_dis_timer'],
            'inc_city_id' => $city_id,
            'inc_state_id' => $state_id,
            'inc_address' => $inc_details['place'],
            'inc_district_id' => $district_id,
            'inc_area' => $inc_details['area'],
            'inc_landmark' => $inc_details['landmark'],
            'inc_lane' => $inc_details['lane'],
            'inc_h_no' => $inc_details['h_no'],
            'inc_pincode' => $inc_details['pincode'],
            'inc_lat' => $inc_details['lat'],
            'inc_long' => $inc_details['lng'],
            'inc_datetime' => $datetime,
            'inc_service' => $inc_details_service,
            'inc_base_month' => $this->post['base_month'],
            'inc_set_amb' => '1',
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'pre_inc_ref_id' => $inc_old_id,
            'inc_thirdparty' => $this->clg->thirdparty,
            'inc_suggested_amb' => $inc_details['inc_suggested_amb'],
        );
        
        if ($this->post['termination_reason'] != '') {
            $incidence_details['termination_reason'] = $this->post['termination_reason'];
        }
        if ($this->post['termination_reason_other'] != '') {
            $incidence_details['termination_reason_other'] = $this->post['termination_reason_other'];
        }

        if ($this->post['terminate'] == 'yes') {
            $incidence_details['incis_deleted'] = '2';
        }

        $inc_data = $this->inc_model->insert_inc($incidence_details);


        update_inc_ref_id($inc_id);

        $last_insert_pat_id = $this->pet_model->last_insert_pat_id();
        $last_pat_id = $last_insert_pat_id[0]->p_id + 1;
        $last_pat_id = generate_ptn_id();

        $incidence_patient_details = array('ptn_fname' => ucfirst($patient['first_name']),
                        'ptn_mname' => ucfirst($patient['middle_name']),
                        'ptn_lname' => ucfirst($patient['last_name']),
                        'ptn_gender' => $patient['gender'],
                        'ptn_fullname' => ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . $patient['last_name'],
                        'ptn_age' => $patient['age'],
                        // 'ptn_dob' => $patient['dob'],
                        'ptn_id' => $last_pat_id,
                        'ptn_added_by' => $this->clg->clg_ref_id,
                        'ptn_added_date' => date('Y-m-d H:i:s')
                    );

                    $patient_full_name = $patient['first_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['last_name'];
        $pat_details = $this->pet_model->insert_patient_details($incidence_patient_details);

        $incidence_patient = array('inc_id' => $inc_id,
            'ptn_id' => $last_pat_id);

        $this->pet_model->insert_inc_pat($incidence_patient);

        update_inc_ref_id($inc_id);

        $ads_id = $this->add_res_model->insert($inc_id, $inc_old_id, $base_month, $resource_type);

        $clg_ref_id = $this->clg->clg_ref_id;

        $clg_senior = $this->add_res_model->select_senior($clg_ref_id, $resource_type);

        //if senior are not available fetach all police or fire and assign one member -senior are not available//



        if (count($clg_senior) > 0) {

            foreach ($clg_senior as $senior) {


                $args = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $senior->clg_ref_id,
                    'operator_type' => $senior->clg_group,
                    'base_month' => $this->post['base_month'],
                    'sub_type' => 'AD_SUP_REQ'
                );

                $res = $this->common_model->assign_operator($args);
            }
        }

        //MI13 Add ambulance to incident
        $datetime = date('Y-m-d H:i:s');
        $sft_id = '';
        $shift_time = explode(":", date('H:i:s'));
        if ($shift_time[0] >= 0 && $shift_time[0] <= 6) {
            $sft_id = 3;
        }if ($shift_time[0] >= 6 && $shift_time[0] <= 16) {
            $sft_id = 1;
        }if ($shift_time[0] >= 16 && $shift_time[0] <= 23) {
            $sft_id = 2;
        }

        $inc_details = $this->input->get_post('incient');
        $inc_details = $this->post['incient'];

        $inc_details = $this->session->userdata('add_incient');

        if (!empty($inc_details)) {

            if ($inc_details['amb_id']) {

                foreach ($inc_details['amb_id'] as $select_amb) {
                    $inc_details['amb_id'] = $select_amb;
                }
                $tm_team_date = date('Y-m-d');

                $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                $EMT = $emp_inc_data[0]->tm_pilot_id;
                $pilot = $emp_inc_data[0]->tm_emt_id;

//                if ($EMT == '' && $pilot == '') {
//                    $this->output->message = "<div class='error'>Please Assign Pilot and EMT to Ambulance OR Select another ambulance</div>";
//                    return;
//                }
                $amb_details = $this->inc_model->get_ambulance_details_API($inc_details['amb_id']);
                $amb_lat = $amb_details[0]->amb_lat;
                $amb_log = $amb_details[0]->amb_log;
                $thirdparty = $amb_details[0]->thirdparty;
                $ward_id = $amb_details[0]->ward_id;
                $ward_name = $amb_details[0]->ward_name;
                $hp_id = $amb_details[0]->hp_id;
                $hp_name = $amb_details[0]->hp_name;

                $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                    'inc_ref_id' => $inc_id,
                    'ward_id' => $ward_id,
                    'ward_name' => $ward_name,
                    'base_location_id' => $hp_id,
                    'base_location_name' => $hp_name,
                    'amb_pilot_id' => $pilot,
                    'amb_emt_id' => $EMT,
                    'inc_base_month' => $this->post['base_month'],
                    'assigned_time' => $datetime);

                $this->inc_model->insert_inc_amb($incidence_amb_details);

                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);

                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                if($pilot != ""){
                    $args_operator1 = array(
                        'sub_id' => $inc_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'AD_SUP_REQ',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }
                if($EMT != ""){
                    $args_operator2 = array(
                        'sub_id' => $inc_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'AD_SUP_REQ',
                        'base_month' => $this->post['base_month']
                    );
                    
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }
            }

            if ($inc_details['stand_amb_id']) {
                foreach ($inc_details['stand_amb_id'] as $stand_amb_id) {

                    $inc_details['stand_amb_id'] = $stand_amb_id;


                    $EMT = "EMT";
                    $pilot = 'Pilot';

                    //$emp_inc_data = $this->inc_model->get_amb_default_emp(trim($inc_details['amb_id']), $sft_id);
                    $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['stand_amb_id'], $sft_id);

                    $pilot = $emp_inc_data[0]->tm_pilot_id;
                    $EMT = $emp_inc_data[0]->tm_emt_id;


                    $incidence_amb_details = array('amb_rto_register_no' => $inc_details['stand_amb_id'],
                        'inc_ref_id' => $inc_id,
                        'amb_pilot_id' => $pilot,
                        'amb_emt_id' => $EMT,
                        'inc_base_month' => $this->post['base_month'],
                        'assigned_time' => $datetime);

                    $this->inc_model->insert_inc_amb($incidence_amb_details);
                    if($pilot != ""){
                        $args_operator1 = array(
                            'sub_id' => $inc_id,
                            'operator_id' => $pilot,
                            'operator_type' => 'UG-PILOT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'AD_SUP_REQ',
                            'base_month' => $this->post['base_month']
                        );
                         $args_operator1 = $this->common_model->assign_operator($args_operator1);
                    }
                    
                    if($EMT != ""){
                        $args_operator2 = array(
                            'sub_id' => $inc_id,
                            'operator_id' => $EMT,
                            'operator_type' => 'UG-EMT',
                            'sub_status' => 'ASG',
                            'sub_type' => 'AD_SUP_REQ',
                            'base_month' => $this->post['base_month']
                        );
                       
                        $args_operator2 = $this->common_model->assign_operator($args_operator2);
                    }
                }
            }
            
            $ero_args = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'base_month' => $this->post['base_month'],
                    'sub_type' => 'AD_SUP_REQ'
                );

            $assign_ero = $this->common_model->assign_operator($ero_args);

            if ($call_type['cl_type'] == 'forword') {
                $super_user = $this->inc_model->get_user_by_group('UG-SUPP-CH');


                $args = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $super_user->clg_ref_id,
                    'operator_type' => $super_user->clg_group,
                    'base_month' => $this->post['base_month'],
                    'sub_type' => 'AD_SUP_REQ'
                );

                $forword_res = $this->common_model->assign_operator($args);

                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);
                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
            }
             /* send sms to patient  */
            $sms_amb = $inc_details['amb_id'];
            $get_mobile_no = array('rg_no' => $sms_amb);
            $get_driver_no = $this->amb_model->get_amb_data($get_mobile_no);
            $driver = $this->colleagues_model->get_user_info($pilot);
            $sms_driver = $driver[0]->clg_first_name . ' ' . $driver[0]->clg_mid_name . ' ' . $driver[0]->clg_last_name;
            $sms_driver_contact_no = $get_driver_no[0]->amb_default_mobile;
    
    
            $amb_dir_url = base_url() . "amb/amb_dir/" . $inc_id;
    
    
    
    
            $doctor = $this->colleagues_model->get_user_info($EMT);
            $sms_doctor = $doctor[0]->clg_first_name;
            $sms_doctor_contact_no = $get_driver_no[0]->amb_default_mobile;
            $patient_full_name = $caller_details['clr_fname'] . ' ' . $caller_details['clr_mname'] . ' ' . $caller_details['clr_lname'];
            $patient_mobile_no = $caller_details['clr_mobile'];
            $inc_address = $inc_details['place'];
            //$patient_mobile_no = "9730015484";
            if($patient_full_name==' '){
                $patient_full_name = 'Unkonown';
            }
            $patient_name = $caller_details['clr_fname'];
                $sms_amb1 = implode('',(explode("-",$sms_amb)));
                $txtMsg1 = '';
                $txtMsg1.= "Dear ".$patient_full_name.", \n";
                $txtMsg1.= "Ambulance dispatched: ".$sms_amb1 .", \n";
                $txtMsg1.= "Ambulance Contact: ".$sms_doctor_contact_no .", \n" ;
                //$txtMsg1.= "Link: ".$amb_dir_url."\n" ;
                $txtMsg1 .= "Please click on the following link for downloading the 108 Sanjeevani app on your mobile Android User - https://tinyurl.com/2p87kfu6 and iOS User- https://tinyurl.com/3pup8pp4\n";
                $txtMsg1.= "JAES" ;
           $patient_sms_to = $caller_details['clr_mobile'];
             $args = array(
                 'inc_id' => $inc_id,
                 'msg' => $txtMsg1,
                 'mob_no' => $patient_sms_to,
                 'sms_user'=>'patient',
             );
            
             $sms_data = sms_send($args);
             $mno = $caller_details['clr_mobile'];
            $mno = substr($mno, -10);
            $inc_link_args = array( 'mobile_no'=>$mno,
                                    'incident_id'=>$inc_id,
                                    'track_link'=>$amb_dir_url,
                                    'added_date' =>   date('Y-m-d H:i:s'));
            //var_dump($inc_link_args);
            $inc_link = $this->call_model->insert_track_link($inc_link_args); 
            /* send sms to doctor  */
        $patient_name = $caller_details['clr_fname'];
     
        $chief_complaint = get_cheif_complaint($inc_details['inc_complaint']);
        // $hospital_name = $inc_details['hos_name'];
        if($inc_details['hospital_id'] != ''){
            $pri_hospital_data = get_hospital_by_id($inc_details['hospital_id']);
            $hospital_name = $pri_hospital_data[0]->hp_name;
            $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
            $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
        }else{
            $pri_hospital_data = get_hospital_by_id($inc_details['hospital_two_id']);
            $hospital_name = '';
            
        }
        if($inc_details['hospital_id'] != ''){
            $pri_hospital_data = get_hospital_by_id($inc_details['hospital_id']);
            $pri_hosp_name = $pri_hospital_data[0]->hp_name;
            $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
            $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
        }else{
            $pri_hospital_data = get_hospital_by_id($inc_details['hospital_two_id']);
            $pri_hosp_name = $pri_hospital_data[0]->hp_name;
            $pri_hosp_lat = $pri_hospital_data[0]->hp_lat;
            $pri_hosp_lng = $pri_hospital_data[0]->hp_long;
        }
        
        $datetime = date('d-m-Y H:i:s');
        $args = array(
            'inc_ref_id' => $inc_old_id,
            'base_month' => $this->post['base_month']
        );
		$pt_info = $this->pet_model->get_ptinc_info($args);
        if($pt_info[0]->inc_type=='mci'){
            $label ="MCI Nature"; 
            if($pt_info[0]->inc_mci_nature == 9)
            {
                $chief_complaint = 'Mass Activity-Riots/Stampede';
                $patient_name = ucfirst($pt_info[0]->ptn_fname) . ' ' . $pt_info[0]->ptn_lname;
            }else{
                $chief_complaint = ($pt_info[0]->ntr_nature) ? $pt_info[0]->ntr_nature : "-";
                $patient_name = ucfirst($pt_info[0]->ptn_fname) . ' ' . $pt_info[0]->ptn_lname;
            }
            
        }else{
             $label ="Chief Complaint Name"; 
             
             $Chief_Complaint_extra_length = array('32','4','15','89','92','50');
             if(in_array($pt_info[0]->inc_complaint,$Chief_Complaint_extra_length))
             {
                if($pt_info[0]->inc_complaint==32)
                {
                    $chief_complaint = 'Child/Pediatric Patient';
                }
                if($pt_info[0]->inc_complaint==4)
                {
                    $chief_complaint = 'Altered Mental Status';
                }
                if($pt_info[0]->inc_complaint==15)
                {
                    $chief_complaint = 'Lightning Strike';
                }
                if($pt_info[0]->inc_complaint==89 || $pt_info[0]->inc_complaint==89 )
                {
                    $chief_complaint = 'Children/Infacts/Newborn sick';
                }
                if($pt_info[0]->inc_complaint==50)
                {
                    $chief_complaint = 'Unconscious Patient';
                }
            }else{
                $chief_complaint= ($pt_info[0]->ct_type) ? $pt_info[0]->ct_type : "-"; 
                $patient_name = ucfirst($pt_info[0]->ptn_fname) . ' ' . $pt_info[0]->ptn_lname;
            }
            $chief_complaint= ($pt_info[0]->ct_type) ? $pt_info[0]->ct_type : "-"; 
            $patient_name = ucfirst($pt_info[0]->ptn_fname) . ' ' . $pt_info[0]->ptn_lname;
        }
            $txtMsg2 ='';
            $txtMsg2.= "Patient name: ".$patient_name.",\n"; 
            $txtMsg2.= " Address: ".$inc_address.",\n";
            $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
            $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
            $txtMsg2.= " Incident id: ".$inc_id.",\n";
            $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
            $txtMsg2.= " Hospital Name- ".'NA'.",\n";
            $txtMsg2.= " JAES" ;
      
        $sms_to = $sms_doctor_contact_no;
        $args = array(
            'msg' => $txtMsg2,
            'mob_no' => $sms_to,
            'sms_user'=>'EMT',
            'inc_id'=>$inc_id,
        );
        
        $sms_data = sms_send($args);

         /* send sms to Pilot  */
        
         $sms_pilot_contact_no = $get_driver_no[0]->amb_pilot_mobile; 
         $sms_pilot_contact_no = ltrim($sms_pilot_contact_no, '0');
 
 
         //$patient_name = $caller_details['clr_fname'];
         
        // $patient_name = ucfirst($patient['first_name']) . ' ' . ucfirst($patient['middle_name']) . ' ' . $patient['last_name'];
        $datetime = date('d-m-Y H:i:s');
        $txtMsg2 ='';
        $txtMsg2.= "Patient name: ".$patient_name.",\n"; 
        $txtMsg2.= " Address: ".$inc_address.",\n";
        $txtMsg2.= " Caller No: ".$patient_mobile_no.",\n";
        $txtMsg2.= " Incident Date Time: ".$datetime.",\n";
        $txtMsg2.= " Incident id: ".$inc_id.",\n";
        $txtMsg2.= " Chief Complaint: ".$chief_complaint.",\n";
        $txtMsg2.= " Hospital Name- ".'NA'.",\n";
        $txtMsg2.= " JAES" ;
       
         $sms_to_pilot = $sms_pilot_contact_no;
         $args = array(
             'msg' => $txtMsg2,
             'mob_no' => $sms_to_pilot,
              'sms_user'=>'Pilot',
              'inc_id'=>$inc_id,
         );
         $sms_data = sms_send($args);
         
         $mno = $caller_details['clr_mobile'];
         $mno = substr($mno, -10);
         $inc_link_args = array( 'mobile_no'=>$mno,
                                 'incident_id'=>$inc_id,
                                 'track_link'=>$amb_dir_url,
                                 'added_date' =>   date('Y-m-d H:i:s'));
         
         $inc_link = $this->call_model->insert_track_link($inc_link_args);
         //die();
         $caller_lat = $inc_details['lat'];
        $caller_lng = $inc_details['lng'];
         $args = array(
            'LastActivityTime' => "$datetime" ,
            'JobStatus' => 'Dispatched' ,
            'onRoadStatus' =>'1' ,
            'Caller_Location' => "$inc_address",
            'Hospital_Location' => "$pri_hosp_name",
            'JobNo' => "$inc_id",
            'HospitalLatlong' => "$pri_hosp_lat".','."$pri_hosp_lng",
            'stateCode' => 'MP',
            'AmbulanceNo' =>"NA",
            'CallerLatlong' =>"$caller_lat".','."$caller_lng"
           
        );
        $send_API = send_API($args);
            if ($update_amb) {
                $this->output->status = 1;

                $this->output->closepopup = "yes";
                $url = base_url("calls");
                
                if ($this->post['terminate'] == 'yes') {
                    $this->output->message = "<h3>ADDITIONAL RESOURCES</h3><br><p>Additional Ambulance is dispatch successfully</p><script>  window.location.href = '".$url."';</script>";
                }else{
                    $this->output->message = "<h3>ADDITIONAL RESOURCES</h3><br><p>Additional Ambulance is dispatch successfully</p><script>  window.location.href = '".$url."';</script>";
                }

                $this->output->moveto = 'top';

                $this->output->add_to_position('', 'content', TRUE);
            }
        }
    }
    function confirm_followup_save(){
        /*
        $this->session->unset_userdata('add_incient');
        $this->session->unset_userdata('resource_type');

        $inc_details = $this->post['incient'];
        $patient = $this->post['patient'];
        $post_details = $this->input->post();
        //var_dump($inc_details);die();
        if ($inc_details['amb_id'] == '') {

            $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

            return;
        }
        */
         $this->session->unset_userdata('inc_ref_id');
        $inc_id = $this->post['inc_id'];
        $base_month = $this->post['base_month'];
        $call_type = $this->input->get();

        if (is_array($this->post['resource_type'])) {
            $resource_type = $this->post['resource_type'];
        }
        $post_details = $this->input->post();
        $this->session->set_userdata('inc_post_details', $post_details);

        $inc_post_details = $this->session->userdata('inc_post_details');
       
        $inc_details = $this->session->userdata('mic_details');
        $patient= $this->session->userdata('patient');




        $resource_type = $this->session->userdata('resource_type');

        $call_id = $inc_post_details['call_id'];

        $dup_inc = $inc_details['dup_inc'];
        $EMT = "";
        $pilot = '';

        $district_id = "0";
        $city_id = "0";
        $state_id = "0";

        $state_id = $inc_post_details['incient_state'];
        $district_id = $this->inc_model->get_district_id($inc_details['inc_district'], $state_id->st_code);


        $city_id = $this->inc_model->get_city_id($inc_details['inc_city'], $inc_post_details['incient_district'], $state_id);


        $district_id = $inc_post_details['incient_districts'];


        if (isset($city_id)) {

            $city_id = $city_id->cty_id;
        } else {

            $city_id = "0";
        }



        $inc_details_service = serialize($inc_details['service']);


        if ($inc_post_details['incient_state'] == '') {
            $inc_post_details['incient_state'] = "MP";
        }

       // $inc_id = $this->session->userdata('inc_ref_id');
        $is_exits = $this->inc_model->get_inc(array('inc_ref_id'=>$inc_id));
        if(!empty($is_exits)){
            $this->session->set_userdata('inc_ref_id','');
            $this->output->message = "<div class='error'>Incident Id alredy exists</div>";
            return;
        }
        
        $datetime = date('Y-m-d H:i:s');
        $incidence_details = array('inc_cl_id' => $call_id,
            'inc_ref_id' => $inc_id,
            'inc_ero_summary' => $inc_details['inc_ero_summary'],
            'inc_ero_standard_summary' => $inc_details['inc_ero_standard_summary'],
            'inc_city_id' => $city_id,
            'inc_state_id' => $state_id,
            'inc_address' => $inc_details['place'],
            'inc_district_id' => $district_id,
            'inc_area' => $inc_details['area'],
            'inc_landmark' => $inc_details['landmark'],
            'inc_lane' => $inc_details['lane'],
            'inc_h_no' => $inc_details['h_no'],
            'inc_pincode' => $inc_details['pincode'],
            'inc_lat' => $inc_details['lat'],
            'inc_long' => $inc_details['lng'],
            'inc_datetime' => $datetime,
            'inc_service' => $inc_details_service,
            'inc_base_month' => $this->post['base_month'],
            'inc_set_amb' => '1',
            'inc_recive_time' => $inc_details['inc_recive_time'],
            'inc_added_by' => $this->clg->clg_ref_id,
            'pre_inc_ref_id' => $inc_old_id,
            'inc_thirdparty' => $this->clg->thirdparty,
            
        );
        
        if ($this->post['termination_reason'] != '') {
            $incidence_details['termination_reason'] = $this->post['termination_reason'];
        }
        if ($this->post['termination_reason_other'] != '') {
            $incidence_details['termination_reason_other'] = $this->post['termination_reason_other'];
        }

        
        $incidence_details['incis_deleted'] = '0';
       
        $inc_data = $this->inc_model->insert_inc($incidence_details);


        update_inc_ref_id($inc_id);

       
        $clg_ref_id = $this->clg->clg_ref_id;

        

        //MI13 Add ambulance to incident
        $datetime = date('Y-m-d H:i:s');
        

        $inc_details = $this->input->get_post('incient');
        $inc_details = $this->post['incient'];

        
       // var_dump($inc_details);die();
        if (!empty($inc_details)) {

            if ($inc_details['amb_id']) {

                foreach ($inc_details['amb_id'] as $select_amb) {
                    $inc_details['amb_id'] = $select_amb;
                }
                $tm_team_date = date('Y-m-d');

                $emp_inc_data = $this->inc_model->get_amb_default_emp($inc_details['amb_id'], $sft_id,$tm_team_date);
                $EMT = $emp_inc_data[0]->tm_pilot_id;
                $pilot = $emp_inc_data[0]->tm_emt_id;


                $amb_details = $this->inc_model->get_ambulance_details_API($inc_details['amb_id']);
                $amb_lat = $amb_details[0]->amb_lat;
                $amb_log = $amb_details[0]->amb_log;
                $thirdparty = $amb_details[0]->thirdparty;
                $ward_id = $amb_details[0]->ward_id;
                $ward_name = $amb_details[0]->ward_name;
                $hp_id = $amb_details[0]->hp_id;
                $hp_name = $amb_details[0]->hp_name;

                $incidence_amb_details = array('amb_rto_register_no' => $inc_details['amb_id'],
                    'inc_ref_id' => $inc_id,
                    'ward_id' => $ward_id,
                    'ward_name' => $ward_name,
                    'base_location_id' => $hp_id,
                    'base_location_name' => $hp_name,
                    'amb_pilot_id' => $pilot,
                    'amb_emt_id' => $EMT,
                    'inc_base_month' => $this->post['base_month'],
                    'assigned_time' => $datetime);
                    $this->inc_model->insert_inc_amb($incidence_amb_details);

                $upadate_amb_data = array('amb_rto_register_no' => $inc_details['amb_id'], 'amb_status' => 2);
                //var_dump($upadate_amb_data);die();
                $update_amb = $this->pcr_model->update_amb_by_reg($upadate_amb_data);
                if($pilot != ""){
                    $args_operator1 = array(
                        'sub_id' => $inc_id,
                        'operator_id' => $pilot,
                        'operator_type' => 'UG-PILOT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'FOLLOWUP',
                        'base_month' => $this->post['base_month']
                    );
                    $args_operator1 = $this->common_model->assign_operator($args_operator1);
                }
                if($EMT != ""){
                    $args_operator2 = array(
                        'sub_id' => $inc_id,
                        'operator_id' => $EMT,
                        'operator_type' => 'UG-EMT',
                        'sub_status' => 'ASG',
                        'sub_type' => 'FOLLOWUP',
                        'base_month' => $this->post['base_month']
                    );
                    
                    $args_operator2 = $this->common_model->assign_operator($args_operator2);
                }
            }

            $ero_args = array(
                    'sub_id' => $inc_id,
                    'operator_id' => $this->clg->clg_ref_id,
                    'operator_type' => $this->clg->clg_group,
                    'base_month' => $this->post['base_month'],
                    'sub_type' => 'FOLLOWUP'
                );

            $assign_ero = $this->common_model->assign_operator($ero_args);

           
             //   var_dump($update_amb);die();
            if ($update_amb) {
                $this->output->status = 1;

                $this->output->closepopup = "yes";
                $url = base_url("calls");
                
                if ($this->post['terminate'] == 'yes') {
                    $this->output->message = "<h3>Followup Call</h3><br><p>Followup call Ambulance is dispatch successfully</p><script>  window.location.href = '".$url."';</script>";
                }else{
                    $this->output->message = "<h3>Followup Call</h3><br><p>Followup call is dispatch successfully</p><script>  window.location.href = '".$url."';</script>";
                }

                $this->output->moveto = 'top';

                $this->output->add_to_position('', 'content', TRUE);
            }
        }
        
       



        
        
    } 
    function confirm_save() {

        $this->session->unset_userdata('add_incient');
        $this->session->unset_userdata('resource_type');
        $this->session->unset_userdata('inc_ref_id');

        $inc_details = $this->post['incient'];
        $patient = $this->post['patient'];
        
        $post_details = $this->input->post();


        if ($inc_details['amb_id'] == '') {

            $this->output->message = "<div class='error'>Please select Ambulance in Map</div>";

            return;
        }

        //var_dump($inc_details);
        //  die();
        $resource_type_details = $this->post['resource_type'];
        $call_type = $this->input->post('call_type');


        $this->session->set_userdata('inc_post_details', $post_details);
        $this->session->set_userdata('mic_details', $inc_details);
        $this->session->set_userdata('add_incient', $inc_details);
        $this->session->set_userdata('resource_type', $resource_type_details);
        $this->session->set_userdata('call_type', $call_type);
         $this->session->set_userdata('patient', $patient);
         //$this->session->userdata('pt_info',  $data['pt_info']);

        $this->session->set_userdata('call_type', $call_type);


        $args = array(
            'inc_ref_id' => $this->post['inc_id'],
            'base_month' => $this->post['base_month']
        );

        $inc_id = $this->session->userdata('inc_ref_id');
        
        if ($inc_id == '') {
            $inc_id = generate_inc_ref_id();
            $this->session->set_userdata('inc_ref_id', $inc_id);
        }
        $data['inc_ref_id'] = $inc_id;

        $data['increfid'] = $this->post['inc_id'];
        $data['resource_type'] = $this->post['resource_type'];

        if ($inc_details["amb_id"]) {
            foreach ($inc_details["amb_id"] as $amb_reg) {
                $amb_reg_args = array('rg_no' => $amb_reg);
                $current_amb_data = $this->inc_model->get_ambulance_details($amb_reg_args);
                $current_amb[] = $current_amb_data[0];
            }
        }
       // var_dump($args);

        $data['current_amb'] = $current_amb;



        $data['resource'] = false;
        $data['pt_info'] = $this->pet_model->get_ptinc_info($args);
       // var_dump($data['pt_info']);
        $data['patient'] = $patient;
        $data['pre_inc_amb'] = $this->inc_model->get_inc_ambulance($args);
        $data['cl_type'] = $call_type;

        $this->output->add_to_popup($this->load->view('frontend/resource/confirm_add_view', $data, TRUE), '600', '560');
        $this->output->add_to_position($this->load->view('frontend/common/incident_info_view_pop', $data, TRUE), 'summary_div', TRUE);
        // $this->output->add_to_position($this->load->view('frontend/patient/pt_inc_summary_view', $data, TRUE), 'summary_div', TRUE);
    }

    function load_amb_view() {

        if ($this->agent->is_mobile()) {

            $data['agent_mobile'] = 'yes';
        } else {

            $data['agent_mobile'] = 'no';
        }

        $get_data = $this->input->post();
        $get_data['inc_type'] = 'add_sup';
        //  var_dump($get_data);

        if ($get_data['checked'] == 'checked') {
            $this->output->add_to_position($this->load->view('frontend/resource/amb_map_view', $data, TRUE), 'amb_map_view', TRUE);
        } else {

            $this->output->add_to_position(' ', 'amb_map_view', TRUE);
        }
    }

}
