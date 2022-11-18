<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Viewinspection extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('Inspection_model','Login_model','Common_model'));
        $this->load->helper('string');
        $this->load->helper('number');
        $this->load->library('upload');
    }
    public function index_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $username = $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $viewdata = $this->Inspection_model->getlistofinspection($username);
            $this->response([
                'data' => $viewdata,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function detailslistofinsp_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inspUnqId =  $this->post('inspUnqId');
            $viewdata = $this->Inspection_model->getdetailslistofinspectionview($inspUnqId);
            // print_r($viewdata);
            $ambdetails = array();
            $mainofveh = array();
            $cleanlinessofamb = array();
            $pcr = array();
            $atndsheet = array();
            if(!empty($viewdata)){
                foreach($viewdata as $viewdata1){
                    $ambdetails1 = array(
                        'inspUnqId' => $viewdata1->id,
                        'vehicleNumber' => $viewdata1->ins_amb_no,
                        'ambCurrentStatus' => $viewdata1->ins_amb_current_status,
                        'gpsworking' => $viewdata1->ins_gps_status,
                        'pilotpres' => $viewdata1->ins_pilot,
                        'emsopres' => $viewdata1->ins_emso,
                        'date' => $viewdata1->added_date,
                        'baseLoc' => $viewdata1->ins_baselocation,
                        'disName' => $viewdata1->dst_name
                    );
                    array_push($ambdetails,$ambdetails1);
                    $url = 'http://irts.jaesmp.com/JAEms/inspection_api/insp_upload_file/';
                    $formNo= '2';
                    $imgVid = $this->Inspection_model->getMainOfVehImg($inspUnqId,$formNo);
                    if(!empty($imgVid)){
                        $ins_main_img = isset($imgVid[0]['upload_img_path']) ? $url.$imgVid[0]['upload_img_path'] : '';
                        $ins_main_vid = isset($imgVid[0]['upload_video_path']) ? $url.$imgVid[0]['upload_video_path'] : '';
                    }
                    $mainofveh1 = array(
                        'dateOfMaintenance' => $viewdata1->ins_main_date,
                        'mainDoneDueDateOrNot' => $viewdata1->ins_main_due_status,
                        'presentStatus' => $viewdata1->ins_main_status,
                        'ins_main_remark' => $viewdata1->ins_main_remark,
                        'ins_main_img' => isset($ins_main_img) ? $ins_main_img : '',
                        'ins_main_vid' => isset($ins_main_vid) ? $ins_main_vid : '',
                    );
                    array_push($mainofveh,$mainofveh1);
                    $inscleanformNo= '3';
                    $inscleanimgVid = $this->Inspection_model->getMainOfVehImg($inspUnqId,$inscleanformNo);
                    if(!empty($imgVid)){
                        $ins_clean_img = isset($inscleanimgVid[0]['upload_img_path']) ? $url.$inscleanimgVid[0]['upload_img_path'] : '';
                        $ins_clean_vid = isset($inscleanimgVid[0]['upload_video_path']) ? $url.$inscleanimgVid[0]['upload_video_path'] : '';
                    }
                    $cleanlinessofamb1 = array(
                        'ins_clean_date' => $viewdata1->ins_clean_date,
                        'ins_clean_status' => $viewdata1->ins_clean_status,
                        'ins_clean_remark' => $viewdata1->ins_clean_remark,
                        'ins_clean_img' => isset($ins_clean_img) ? $ins_clean_img : '',
                        'ins_clean_vid' => isset($ins_clean_vid) ? $ins_clean_vid : '',
                    );
                    array_push($cleanlinessofamb,$cleanlinessofamb1);
                    $pcrformNo= '10';
                    $pcrImgVid = $this->Inspection_model->getMainOfVehImg($inspUnqId,$pcrformNo);
                    if(!empty($imgVid)){
                        $pcr_img = isset($pcrImgVid[0]['upload_img_path']) ? $url.$pcrImgVid[0]['upload_img_path'] : '';
                        $pcr_vid = isset($pcrImgVid[0]['upload_video_path']) ? $url.$pcrImgVid[0]['upload_video_path'] : '';
                    }
                    $pcr1 = array(
                        'ins_pcs_stock_date' => $viewdata1->ins_pcs_stock_date,
                        'ins_pcs_stock_status' => $viewdata1->ins_pcs_stock_status,
                        'ins_pcs_stock_remark' => $viewdata1->ins_pcs_stock_remark,
                        'pcr_img' => isset($pcr_img) ? $pcr_img : '',
                        'pcr_vid' => isset($pcr_vid) ? $pcr_vid : '',
                    );
                    array_push($pcr,$pcr1);
                    $atndsheetformNo= '11';
                    $atndsheetImgVid = $this->Inspection_model->getMainOfVehImg($inspUnqId,$atndsheetformNo);
                    if(!empty($imgVid)){
                        $atndsheetImgVid_img = isset($atndsheetImgVid[0]['upload_img_path']) ? $url.$atndsheetImgVid[0]['upload_img_path'] : '';
                        $atndsheetImgVid_vid = isset($atndsheetImgVid[0]['upload_video_path']) ? $url.$atndsheetImgVid[0]['upload_video_path'] : '';
                    }
                    $atndsheet1 = array(
                        'ins_sign_attnd_date' => $viewdata1->ins_sign_attnd_date,
                        'ins_sign_attnd_due_status' => $viewdata1->ins_sign_attnd_due_status,
                        'ins_sign_attnd_status' => $viewdata1->ins_sign_attnd_status,
                        'ins_sign_attnd_remark' => $viewdata1->ins_sign_attnd_remark,
                        'atndsheet_img' => isset($atndsheetImgVid_img) ? $atndsheetImgVid_img : '',
                        'atndsheet_vid' => isset($atndsheetImgVid_vid) ? $atndsheetImgVid_vid : '',
                    );
                    array_push($atndsheet,$atndsheet1);
                }
            }
            $finalArray = array(
                "ambDetail" => $ambdetails,
                "mainOfVeh" => $mainofveh,
                "cleanlinessOfAmb" => $cleanlinessofamb,
                'pcr' => $pcr,
                'atndsheet' => $atndsheet
            );
            $this->response([
                'data' => ([
                    $finalArray
                ]),
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function detailsofactyresireninvbatt_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inspUnqId =  $this->post('inspUnqId');
            $viewdata = $this->Inspection_model->getdetailslistofinspectionview($inspUnqId);
            $ac = array();
            $tyre = array();
            $siren = array();
            $inventory = array();
            $battery = array();
            $gps = array();
            if(!empty($viewdata)){
                foreach($viewdata as $viewdata1){
                    $url = 'http://irts.jaesmp.com/JAEms/inspection_api/insp_upload_file/';
                    $acformNo= '4';
                    $acimgVid = $this->Inspection_model->getMainOfVehImg($inspUnqId,$acformNo);
                    if(!empty($acimgVid)){
                        $ac_img = isset($acimgVid[0]['upload_img_path']) ? $url.$acimgVid[0]['upload_img_path'] : '';
                        $ac_vid = isset($acimgVid[0]['upload_video_path']) ? $url.$acimgVid[0]['upload_video_path'] : '';
                    }
                    $ac1 = array(
                        'ac_status' => $viewdata1->ac_status,
                        'ac_working_date' => $viewdata1->ac_working_date,
                        'ac_remark' => $viewdata1->ac_remark,
                        'ac_img' => isset($ac_img) ? $ac_img : '',
                        'ac_vid' => isset($ac_vid) ? $ac_vid : '',
                    );
                    array_push($ac,$ac1);
                    $tyreformNo= '5';
                    $tyreimgVid = $this->Inspection_model->getMainOfVehImg($inspUnqId,$tyreformNo);
                    if(!empty($tyreimgVid)){
                        $tyre_img = isset($tyreimgVid[0]['upload_img_path']) ? $url.$tyreimgVid[0]['upload_img_path'] : '';
                        $tyre_vid = isset($tyreimgVid[0]['upload_video_path']) ? $url.$tyreimgVid[0]['upload_video_path'] : '';
                    }
                    $tyre1 = array(
                        'tyre_status' => $viewdata1->tyre_status,
                        'tyre_working_date' => $viewdata1->tyre_working_date,
                        'tyre_remark' => $viewdata1->tyre_remark,
                        'tyre_img' => isset($tyre_img) ? $tyre_img : '',
                        'tyre_vid' => isset($tyre_vid) ? $tyre_vid : '',
                    );
                    array_push($tyre,$tyre1);
                    $sirenformNo= '6';
                    $sirenimgVid = $this->Inspection_model->getMainOfVehImg($inspUnqId,$sirenformNo);
                    if(!empty($sirenimgVid)){
                        $siren_img = isset($sirenimgVid[0]['upload_img_path']) ? $url.$sirenimgVid[0]['upload_img_path'] : '';
                        $siren_vid = isset($sirenimgVid[0]['upload_video_path']) ? $url.$sirenimgVid[0]['upload_video_path'] : '';
                    }
                    $siren1 = array(
                        'siren_status' => $viewdata1->siren_status,
                        'siren_working_date' => $viewdata1->siren_working_date,
                        'siren_remark' => $viewdata1->siren_remark,
                        'siren_img' => isset($siren_img) ? $siren_img : '',
                        'siren_vid' => isset($siren_vid) ? $siren_vid : '',
                    );
                    array_push($siren,$siren1);
                    $invformNo= '7';
                    $invimgVid = $this->Inspection_model->getMainOfVehImg($inspUnqId,$invformNo);
                    if(!empty($invimgVid)){
                        $inv_img = isset($invimgVid[0]['upload_img_path']) ? $url.$invimgVid[0]['upload_img_path'] : '';
                        $inv_vid = isset($invimgVid[0]['upload_video_path']) ? $url.$invimgVid[0]['upload_video_path'] : '';
                    }
                    $inventory1 = array(
                        'inv_status' => $viewdata1->siren_status,
                        'inv_working_date' => $viewdata1->siren_working_date,
                        'inv_remark' => $viewdata1->siren_remark,
                        'inv_img' => isset($inv_img) ? $inv_img : '',
                        'inv_vid' => isset($inv_vid) ? $inv_vid : '',
                    );
                    array_push($inventory,$inventory1);
                    $battformNo= '8';
                    $battimgVid = $this->Inspection_model->getMainOfVehImg($inspUnqId,$battformNo);
                    if(!empty($battimgVid)){
                        $batt_img = isset($battimgVid[0]['upload_img_path']) ? $url.$battimgVid[0]['upload_img_path'] : '';
                        $batt_vid = isset($battimgVid[0]['upload_video_path']) ? $url.$battimgVid[0]['upload_video_path'] : '';
                    }
                    $battery1 = array(
                        'batt_status' => $viewdata1->batt_status,
                        'batt_working_date' => $viewdata1->batt_working_date,
                        'batt_remark' => $viewdata1->batt_remark,
                        'batt_img' => isset($batt_img) ? $batt_img : '',
                        'batt_vid' => isset($batt_vid) ? $batt_vid : '',
                    );
                    array_push($battery,$battery1);
                    $gpsformNo= '9';
                    $gpsImgVid = $this->Inspection_model->getMainOfVehImg($inspUnqId,$gpsformNo);
                    if(!empty($gpsImgVid)){
                        $gps_img = isset($gpsImgVid[0]['upload_img_path']) ? $url.$gpsImgVid[0]['upload_img_path'] : '';
                        $gps_vid = isset($gpsImgVid[0]['upload_video_path']) ? $url.$gpsImgVid[0]['upload_video_path'] : '';
                    }
                    $gps1 = array(
                        'gps_status' => $viewdata1->gps_status,
                        'gps_working_date' => $viewdata1->gps_working_date,
                        'gps_remark' => $viewdata1->gps_remark,
                        'gps_img' => isset($gps_img) ? $gps_img : '',
                        'gps_vid' => isset($gps_vid) ? $gps_vid : '',
                    );
                    array_push($gps,$gps1);
                }
            }
            $finalArray = array(
                "ac" => $ac,
                "tyre" => $tyre,
                "siren" => $siren,
                "inventory" => $inventory,
                "battery" => $battery,
                "gps" => $gps
            );
            $this->response([
                'data' => ([
                    $finalArray
                ]),
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function detailsofequipment_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inspUnqId =  $this->post('inspUnqId');
            $viewdata = $this->Inspection_model->getdetailslistofinspectionview($inspUnqId);
            if(!empty($viewdata)){
                $minoreqp = array();
                $majoreqp = array();
                $criticaleqp = array();
                $minor_eqp_List_id = '1';
                $major_eqp_List_id = '2';
                $critical_eqp_List_id = '3';
                $minor_eqp_List = $this->Common_model->getequipment($minor_eqp_List_id);
                $major_eqp_List = $this->Common_model->getequipment($major_eqp_List_id);
                $critical_eqp_List = $this->Common_model->getequipment($critical_eqp_List_id);
                $minor_eqp = $this->Common_model->getMinorEquipListAsPerInspId($inspUnqId,$minor_eqp_List_id);
                $major_eqp = $this->Common_model->getMajorEquipListAsPerInspId($inspUnqId,$major_eqp_List_id);
                $critical_eqp = $this->Common_model->getCriticalEquipListAsPerInspId($inspUnqId,$critical_eqp_List_id);
                // $minor_eqp = json_decode($viewdata[0]->eqp_minor);
                // $major_eqp = json_decode($viewdata[0]->eqp_major);
                // $critical_eqp = json_decode($viewdata[0]->eqp_critical);
                // print_r($minor_eqp_List);die;
                foreach($minor_eqp_List as $key=>$minor_eqp_List1){
                    if(!empty($minor_eqp)){
                        for($i=0;$i<count($minor_eqp);$i++){
                            if($minor_eqp_List1->eqp_id == $minor_eqp[$i]->eqp_id){
                                $minoreqp1['eqp_id'] = $minor_eqp[$i]->eqp_id;
                                $minoreqp1['eqp_name'] = $minor_eqp_List1->eqp_name;
                                $minoreqp1['ins_id'] = $minor_eqp[$i]->ins_id;
                                $minoreqp1['eqp_status'] = $minor_eqp[$i]->status;
                                $minoreqp1['eqp_status_oprational'] = $minor_eqp[$i]->oprational;
                                $minoreqp1['eqp_status_date_from'] = $minor_eqp[$i]->date_from;
                                array_push($minoreqp,$minoreqp1);
                            }
                        }
                    }
                }
                foreach($major_eqp_List as $key=>$major_eqp_List1){
                    if(!empty($major_eqp)){
                        for($i=0;$i<count($major_eqp);$i++){
                            if($major_eqp_List1->eqp_id == $major_eqp[$i]->eqp_id){
                                $majoreqp1['eqp_id'] = $major_eqp[$i]->eqp_id;
                                $majoreqp1['eqp_name'] = $major_eqp_List1->eqp_name;
                                $majoreqp1['ins_id'] = $major_eqp[$i]->ins_id;
                                $majoreqp1['eqp_status'] = $major_eqp[$i]->status;
                                $majoreqp1['eqp_status_oprational'] = $major_eqp[$i]->oprational;
                                $majoreqp1['eqp_status_date_from'] = $major_eqp[$i]->date_from;
                                array_push($majoreqp,$majoreqp1);
                            }
                        }
                    }
                }
                foreach($critical_eqp_List as $key=>$critical_eqp_List1){
                    if(!empty($critical_eqp)){
                        for($i=0;$i<count($critical_eqp);$i++){
                            if($critical_eqp_List1->eqp_id == $critical_eqp[$i]->eqp_id){
                                $criticaleqp1['eqp_id'] = $critical_eqp[$i]->eqp_id;
                                $criticaleqp1['eqp_name'] = $critical_eqp_List1->eqp_name;
                                $criticaleqp1['ins_id'] = $critical_eqp[$i]->ins_id;
                                $criticaleqp1['eqp_status'] = $critical_eqp[$i]->status;
                                $criticaleqp1['eqp_status_oprational'] = $critical_eqp[$i]->oprational;
                                $criticaleqp1['eqp_status_date_from'] = $critical_eqp[$i]->date_from;
                                array_push($criticaleqp,$criticaleqp1);
                            }
                        }
                    }
                }
                $finalArray = array(
                    'eqpMajor' => $majoreqp,
                    'eqpMinor' => $minoreqp,
                    'eqpCritical' => $criticaleqp,
                    'eqpMajorRemark' => $viewdata[0]->eqp_minor_remark,
                    'eqpMinorRemark' => $viewdata[0]->eqp_major_remark,
                    'eqpCriticalRemark' => $viewdata[0]->eqp_critical_remark
                );
                $this->response([
                    'data' => ([$finalArray]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => null,
                    'error' => ([
                        "code" => 1,
                        "message" => "Inspection Unique Id Does Not Exist"
                    ])
                ],REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function detailsofmedicine_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inspUnqId =  $this->post('inspUnqId');
            $viewdata = $this->Inspection_model->getdetailslistofinspectionview($inspUnqId);
            $inj_med_List1 = 1;
            $tab_med_List1 = 2;
            $consu_med_List1 = 3;
            $inj_med_List = $this->Common_model->getmedicine($inj_med_List1);
            $tab_med_List = $this->Common_model->getmedicine($tab_med_List1);
            $consu_med_List = $this->Common_model->getmedicine($consu_med_List1);
            $injmed = array();
            $tabmed = array();
            $consumed = array();
            if(!empty($viewdata)){
                $inj_med = $this->Common_model->getInjMedAsPerInspId($inspUnqId,$inj_med_List1);
                $tab_med = $this->Common_model->getTabMedAsPerInspId($inspUnqId,$tab_med_List1);
                $consu_med = $this->Common_model->getConsuMedAsPerInspId($inspUnqId,$consu_med_List1);
                // $inj_med = json_decode($viewdata[0]->med_Injectables);
                // $tab_med = json_decode($viewdata[0]->med_Tablets);
                // $consu_med = json_decode($viewdata[0]->med_Consumables);
                if(!empty($inj_med_List)){
                    foreach($inj_med_List as $key=>$inj_med_List1){
                        if(!empty($inj_med)){
                            for($i=0;$i<count($inj_med);$i++){
                                if($inj_med_List1->med_id == $inj_med[$i]->med_id){
                                    if($inj_med[$i]->med_status == 'Y'){
                                        $status = 'Yes';
                                    }else{
                                        $status = 'No';
                                    }
                                    $injmed1['med_id'] = $inj_med[$i]->med_id;
                                    $injmed1['med_name'] = $inj_med_List1->med_title;
                                    $injmed1['ins_id'] = $inj_med[$i]->ins_id;
                                    $injmed1['med_status'] = $status;
                                    $injmed1['med_qty'] = $inj_med[$i]->med_qty;
                                    array_push($injmed,$injmed1);
                                }
                            }
                        }
                    }
                }
                if(!empty($tab_med_List)){
                    foreach($tab_med_List as $key=>$tab_med_List1){
                        if(!empty($tab_med)){
                            for($i=0;$i<count($tab_med);$i++){
                                if($tab_med_List1->med_id == $tab_med[$i]->med_id){
                                    if($tab_med[$i]->med_status == 'Y'){
                                        $status = 'Yes';
                                    }else{
                                        $status = 'No';
                                    }
                                    $tabmed1['med_id'] = $tab_med[$i]->med_id;
                                    $tabmed1['med_name'] = $tab_med_List1->med_title;
                                    $tabmed1['ins_id'] = $tab_med[$i]->ins_id;
                                    $tabmed1['med_status'] = $status;
                                    $tabmed1['med_qty'] = $tab_med[$i]->med_qty;
                                    array_push($tabmed,$tabmed1);
                                }
                            }
                        }
                    }
                }
                if(!empty($consu_med_List)){
                    foreach($consu_med_List as $key=>$consu_med_List1){
                        if(!empty($consu_med)){
                            for($i=0;$i<count($consu_med);$i++){
                                if($consu_med_List1->med_id == $consu_med[$i]->med_id){
                                    if($consu_med[$i]->med_status == 'Y'){
                                        $status = 'Yes';
                                    }else{
                                        $status = 'No';
                                    }
                                    $consumed1['med_id'] = $consu_med[$i]->med_id;
                                    $consumed1['med_name'] = $consu_med_List1->med_title;
                                    $consumed1['ins_id'] = $consu_med[$i]->ins_id;
                                    $consumed1['med_status'] = $status;
                                    $consumed1['med_qty'] = $consu_med[$i]->med_qty;
                                    array_push($consumed,$consumed1);
                                }
                            }
                        }
                    }
                }
                $finalArray = array(
                    'medInjectable' => $injmed,
                    'medTablets' => $tabmed,
                    'medConsumable' => $consumed,
                    'medInjectableRemark' => $viewdata[0]->med_Remark,
                    'medTabletsRemark' => $viewdata[0]->tab_med_Remark,
                    'medConsumableRemark' => $viewdata[0]->cons_med_Remark
                );
                $this->response([
                    'data' => ([$finalArray]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => null,
                    'error' => ([
                        "code" => 1,
                        "message" => "Inspection Unique Id Does Not Exist"
                    ])
                ],REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function viewInspFormEqpImgVid_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inspUnqId =  $this->post('inspUnqId');
            $formNo = $this->post('formNo');
            $rec = $this->Inspection_model->getImgVidInsp($inspUnqId,$formNo);
            if(!empty($rec)){
                $img = explode(",",$rec[0]['upload_img_path']);
                $url = 'http://irts.jaesmp.com/JAEms/inspection_api/insp_upload_file/';
		//echo $url;die;
                $image = array();
                if(!empty($img[0])){
                    foreach($img as $img1){
                        $imgpath['img'] = $url.$img1;
                        array_push($image, $imgpath);
                    }
                }else{
                    $image = [];
                }
                if(!empty($rec[0]['upload_video_path'])){
                    $video = $url.$rec[0]['upload_video_path'];
                }else{
                    $video = null;
                }
                $this->response([
                    'data' => [
                        "image" => $image,
                        'video' => $video
                    ],
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}