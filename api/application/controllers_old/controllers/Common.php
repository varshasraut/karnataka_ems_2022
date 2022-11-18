<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';

class Common extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model('CommonModel');
        $this->load->model('User');
    }
    public function logintype_get(){
        $data = $this->CommonModel->getLoginType();
        echo json_encode($data);
    }
    public function medicalhistory_post(){
        $data = $this->CommonModel->getPastMedicalHistory();
        $this->response([
            'data' => $data,
            'error' => null
        ],REST_Controller::HTTP_OK);
    }
    public function insertMedicalHistory_post(){
        $MedicalHistory = $this->post(); 
        $pastMed = array();
        foreach($MedicalHistory as $data){
            $historyData['disease'] = $data['disease'];
            $historyData['date'] = date('Y-m-d H:i:s');
            array_push($pastMed,$historyData);
        }
        $data1 = $this->CommonModel->insertPastMedicalHis($pastMed);
        if($data1 == 1){
            $this->response([
                'Data' => null,
                'error' => ([
                    'code' => 1,
                    'message' => 'Insert Successfully'
                ])
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'Data' => null,
                'error' => ([
                    'code' => 2,
                    'message' => 'Data not Insert'
                ])
            ],REST_Controller::HTTP_OK);
        }
    }
    public function medicine_post(){
        if((isset($_COOKIE['cookie']))){
            $data = $this->CommonModel->getMedicine();
            $this->response([
                'data' => $data,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function insertmedicine_post(){
        $Medicine = $this->post(); 
        $pastMed = array();
        foreach($Medicine as $data){
            $medicine1['med_title'] = $data['medicine'];
            $medicine1['med_type'] = 'amb';
            $medicine1['modify_date_sync'] = date('Y-m-d H:i:s');
            $medicine1['med_registered_by'] = $data['id'];
            $medicine1['med_status'] = 1;
            $medicine1['medis_deleted'] = '0';
            array_push($pastMed,$medicine1);
        }
        $data1 = $this->CommonModel->insertMedicine($pastMed);
        if($data1 == 1){
            $this->response([
                'Data' => null,
                'error' => ([
                    'code' => 1,
                    'message' => 'Insert Successfully'
                ])
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'Data' => null,
                'error' => ([
                    'code' => 2,
                    'message' => 'Data not Insert'
                ])
            ],REST_Controller::HTTP_OK);
        }
    }
    public function loc_post(){
        if((isset($_COOKIE['cookie']))){
            $loc = $this->CommonModel->getLocList();
            if(!empty($loc)){
                $this->response([
                    'data' =>  $loc,
                    'error' =>null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => ([]),
                    'error' =>null
                ],REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
        
    }
    public function patientnotcomtohospreason_post(){
        if((isset($_COOKIE['cookie']))){
            $data = $this->CommonModel->getPtnNotComToHospReason();
            $reason = array();
            foreach($data as $data1){
                $reason1 = array(
                    'id' => $data1['id'],
                    'name' => $data1['reason']
                );
                array_push($reason,$reason1);
            } 
            $this->response([
                'data' => $reason,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function interventions_post(){
        if((isset($_COOKIE['cookie']))){
            $interventions = $this->CommonModel->getInterventions();
            $this->response([
                'data' => $interventions,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function patientstatus_post(){
        if((isset($_COOKIE['cookie']))){
            $patientstatus = $this->CommonModel->getPatientStatus();
            $data = array();
            foreach($patientstatus as $patientstatus1){
                $data1 = array(
                    'id' => $patientstatus1['id'],
                    'name' => $patientstatus1['name'],
                );
                array_push($data,$data1);
            }
            $this->response([
                'data' => $data,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }
    public function patientavaornot_post(){
        if((isset($_COOKIE['cookie']))){
            $reason = $this->CommonModel->getPatientAvaOrNot();
            $this->response([
                'data' => $reason,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }
    public function patienthandoverissuelist_post(){
        if((isset($_COOKIE['cookie']))){
            $patientissues = $this->CommonModel->PatientHandoverIssuesList();
            $handover = array();
            foreach($patientissues as $patientissues1){
                $handover1 = array(
                    'id' => (int) $patientissues1['id'],
                    'name' => $patientissues1['name']
                );
                array_push($handover,$handover1);
            }
            $this->response([
                'data' =>  $handover,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }
    public function providerimpression_post(){
        if((isset($_COOKIE['cookie']))){
            $proImp = $this->CommonModel->PatientProviderImpression();
            $this->response([
                'data' =>  $proImp,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }
    public function cheifcomplaints_post(){
        if((isset($_COOKIE['cookie']))){
            $incidentId = $this->post('incidentId');
            $chiefCompliant = $this->CommonModel->getChiefComplaint($incidentId);
            $this->response([
                'data' =>  $chiefCompliant,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }
    public function latlong_post(){
        if((isset($_COOKIE['cookie']))){
            $data['incident_id'] = $this->post('incidentId');
            $data['ambulance_no'] = $this->post('vehicleNumber');
            $data['lat'] = $this->post('lat');
            $data['lng'] = $this->post('long');
            $LatLong = $this->CommonModel->insertLatLong($data);
            if($LatLong == 1){
                $this->response([
                    'Data' => null,
                    'error' => ([
                        'code' => 1,
                        'message' => 'Insert Successfully'
                    ])
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'Data' => null,
                    'error' => ([
                        'code' => 2,
                        'message' => 'Not Inserted'
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
    public function loginvisibility_post(){
        $visible = $this->CommonModel->loginvisibility();
        $a = array();
        foreach($visible as $visible1){
            $b = array(
                'id' => (int) $visible1['id'],
                'name' => $visible1['name'],
                'visibility' => (boolean) $visible1['visibility']
            );
            array_push($a,$b);
        }
        $this->response([
            'data' => $a,
            'error' => null
        ],REST_Controller::HTTP_OK);
    }
    public function equipment_post(){
        if((isset($_COOKIE['cookie']))){
            $data = $this->CommonModel->getEquipment();
            $euip = array();
            foreach($data as $data1){
                $euip1 = array(
                    'id' => (int) $data1['eqp_id'],
                    'name' => $data1['eqp_name']
                );
                array_push($euip,$euip1);
            }
            $this->response([
                'data' => $euip,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }
    public function workstation_post(){
        if((isset($_COOKIE['cookie']))){
            $ambulanceno = $this->post('vehicleNumber');
            $workstation = $this->CommonModel->getWorkStation($ambulanceno);
            $workstationdata1 = array();
            foreach($workstation as $workstation1){
                $workstationdata = array(
                    'id' => (int) $workstation1['ws_id'],
                    'name' => $workstation1['ws_station_name']
                );
                array_push($workstationdata1,$workstationdata);
            }
            $this->response([
                'data' => $workstationdata1,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function paymentmode_post(){
        if((isset($_COOKIE['cookie']))){
            $paymentmode = $this->CommonModel->getPayementMode();
            $data1 = array();
            foreach($paymentmode as $paymentmode1){
                $data = array(
                    'id' => (int) $paymentmode1['id'],
                    'name' => $paymentmode1['payment_name']
                );
                array_push($data1,$data);
            }
            $this->response([
                'data' => $data1,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function cylindertype_post(){
        if((isset($_COOKIE['cookie']))){
            $cylinder = $this->CommonModel->getCylinderType();
            $data1 = array();
            foreach($cylinder as $cylinder1){
                $data = array(
                    'id' => (int) $cylinder1['id'],
                    'name' => $cylinder1['cylinder_name']
                );
                array_push($data1,$data);
            }
            $this->response([
                'data' => $data1,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    /*All Remark for Maintenance*/
    public function standardRemark_post(){
        if((isset($_COOKIE['cookie']))){
            $remarkType = $this->post('remarkType');
            $remark = $this->CommonModel->getRemark($remarkType);
            // print_r($remark);
            $data1 = array();
            foreach($remark as $remark1){
                $data = array(
                    'id' => (int) $remark1['id'],
                    'value' => $remark1['remark_val'],
                    'name' => $remark1['message']
                );
                array_push($data1,$data);
            }
            $this->response([
                'data' => $data1,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function startOdometer_post(){
        /*
        2 - fuel : 2
        */
        // if((isset($_COOKIE['cookie']))){
            $odometerType = $this->post('odometerType');
            $ambulanceno = $this->post('vehicleNumber');
            $startOdometer = $this->CommonModel->getStartOdometer($odometerType,$ambulanceno);
            $this->response([
                'data' => $startOdometer,
                'error' => null
            ],REST_Controller::HTTP_OK);
        // }else{
        //     $this->response([
        //         'data' => ([]),
        //         'error' => null
        //     ],REST_Controller::HTTP_UNAUTHORIZED);
        // }
    }
    public function ambstatusoxyfuel_post(){
         /*
        1 - oxygen : 1
        2 - fuel : 2
        */
        if((isset($_COOKIE['cookie']))){
            $typeValue = $this->post('typeValue');
            $ambulanceno = $this->post('vehicleNumber');
            $data = $this->CommonModel->getAmbStatusOxyFuel($typeValue,$ambulanceno);
            $this->response([
                'data' => $data,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function obviousdeath_post(){
        if((isset($_COOKIE['cookie']))){
            $patientId = $this->post('patientId');
            $incidentId = $this->post('incidentId');
            $obviousdeathlist = $this->CommonModel->getObviusDeath($patientId,$incidentId);
            $this->response([
                'data' => $obviousdeathlist,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function ambulancestatus_post(){
        if((isset($_COOKIE['cookie']))){
            $vehicleNumber = $this->post('vehicleNumber');
            $ambstatus = $this->CommonModel->getAmbulanceStatus($vehicleNumber);
            // print_r($ambstatus);
            if($ambstatus[0]['amb_status'] == 1 || $ambstatus[0]['amb_status'] == 3){
                $this->response([
                    'data' => ([
                        'ambStatus' => 1
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else if($ambstatus[0]['amb_status'] == 2 || (!empty($ambstatus[0]['inc_ref_id']))){
                $this->response([
                    'data' => ([
                        'ambStatus' => 2
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else if($ambstatus[0]['amb_status'] == 7){
                $this->response([
                    'data' => ([
                        'ambStatus' => 7
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else if($ambstatus[0]['amb_status'] == 9){
                $this->response([
                    'data' => ([
                        'ambStatus' => 9
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else if($ambstatus[0]['amb_status'] == 8){
                $this->response([
                    'data' => ([
                        'ambStatus' => 8
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else if($ambstatus[0]['amb_status'] == 12){
                $this->response([
                    'data' => ([
                        'ambStatus' => 12
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
            else if($ambstatus[0]['amb_status'] == 14){
                $this->response([
                    'data' => ([
                        'ambStatus' => 14
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else if($ambstatus[0]['amb_status'] == 16){
                $this->response([
                    'data' => ([
                        'ambStatus' => 16
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else if($ambstatus[0]['amb_status'] == 18){
                $this->response([
                    'data' => ([
                        'ambStatus' => 18
                    ]),
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
    public function tyretype_post(){
        if((isset($_COOKIE['cookie']))){
            $tyre = $this->CommonModel->getTyreType();
            $tyretype = array();
            foreach($tyre as $tyre1){
                $tyretype1 = array(
                    'id' => (int) $tyre1['id'],
                    'name' => $tyre1['name']
                );
                array_push($tyretype,$tyretype1);
            }
            $this->response([
                'data' =>$tyretype,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function informedto_post(){
        if((isset($_COOKIE['cookie']))){
            $informed = $this->CommonModel->getInformedTo();
            $informedto = array();
            foreach($informed as $informed1){
                $informedto1 = array(
                    'id' => (int) $informed1['gid'],
                    'name' => $informed1['ugname'],
                    'value' => $informed1['gcode'],
                );
                array_push($informedto,$informedto1);
            }
            $this->response([
                'data' => $informedto,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function accidentalType_post(){
        if((isset($_COOKIE['cookie']))){
            $accidental = $this->CommonModel->getAccidentalType();
            $accidentalType = array();
            foreach($accidental as $accidental1){
                $accidentalType1 = array(
                    'id' => (int) $accidental1['id'],
                    'name' => $accidental1['name']
                );
                array_push($accidentalType,$accidentalType1);
            }
            $this->response([
                'data' => $accidentalType,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function breakdownType_post(){
        if((isset($_COOKIE['cookie']))){
            $breakdown = $this->CommonModel->getBreakdownType();
            $breakdownType = array();
            foreach($breakdown as $breakdown1){
                $breakdownType1 = array(
                    'id' => (int) $breakdown1['id'],
                    'name' => $breakdown1['name']
                );
                array_push($breakdownType,$breakdownType1);
            }
            $this->response([
                'data' => $breakdownType,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function odometerDifference_post(){
        $this->response([
            'data' => ([
                'odometerDfferance' => (int) 300
            ]),
            'error' => null
        ],REST_Controller::HTTP_OK);
    }
    public function casetype_post(){
        if((isset($_COOKIE['cookie']))){
            $incidentId = $this->post('incidentId');
            $incType = $this->CommonModel->getIncRec($incidentId);
            $casetype = $this->CommonModel->getcasetype($incType[0]['inc_type']);
            $casetype1 = array();
            foreach($casetype as $data1){
                $casetypedata = array(
                    'id' => (int) $data1['case_id'],
                    'name' => $data1['case_name']
                );
                array_push($casetype1,$casetypedata);
            }
            $this->response([
                'data' => $casetype1,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function atSceneTimeDiffOnClosPg_post(){
        if((isset($_COOKIE['cookie']))){
            $vehicleNumber = $this->post('vehicleNumber');
            $getAmbType = $this->CommonModel->getAmbType($vehicleNumber);
            if(!empty($getAmbType)){
                if($getAmbType[0]['ar_name'] == 'Rural'){
                    $time = (int) "30"; //Only accept minutes
                }else{
                    $time = (int) "20"; //Only accept minutes minutes
                }
            }
            $this->response([
                'data' => ([
                    'time' => $time,
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
    public function getAtSceneResponceRemark_post(){
        if((isset($_COOKIE['cookie']))){
            $getAtSceneResRemark = $this->CommonModel->getAtSceneResRemark();
            $getAtSceneResRemark1 = array();
            foreach($getAtSceneResRemark as $data1){
                $data = array(
                    'id' => (int) $data1['id'],
                    'name' => $data1['remark_title']
                );
                array_push($getAtSceneResRemark1,$data);
            }
            $this->response([
                'data' => $getAtSceneResRemark1,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function getpupils_post(){
        if((isset($_COOKIE['cookie']))){
            $getpupils = $this->CommonModel->getpupils();
            $getpupils1 = array();
            foreach($getpupils as $data1){
                $data = array(
                    'id' => (int) $data1['pp_id'],
                    'name' => $data1['pp_type']
                );
                array_push($getpupils1,$data);
            }
            $this->response([
                'data' => $getpupils1,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function getinjurymatrix_post(){
        if((isset($_COOKIE['cookie']))){
            $getinjurymatrix = $this->CommonModel->getinjurymatrix();
            $getinjurymatrix1 = array();
            foreach($getinjurymatrix as $data1){
                $data = array(
                    'id' => (int) $data1['inj_id'],
                    'name' => $data1['inj_name']
                );
                array_push($getinjurymatrix1,$data);
            }
            $this->response([
                'data' => $getinjurymatrix1,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function getgcs_post(){
        if((isset($_COOKIE['cookie']))){
            $getgcs = array();
            for($i = 3; $i<16; $i++){
                $data = array(
                    'id' => (int) $i,
                    'name' => (string) $i
                );
                array_push($getgcs,$data);
            }
            $this->response([
                'data' => $getgcs,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}
?>