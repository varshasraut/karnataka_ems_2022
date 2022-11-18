<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['loc'] = 'common/loc';
$route['patientreason'] = 'common/patientnotcomtohospreason';
$route['interventions'] = 'common/interventions';
$route['patientstatus'] = 'common/patientstatus';
$route['patientnotavareason'] = 'common/patientavaornot';
$route['patienthandoverissuelist'] = 'common/patienthandoverissuelist';
$route['medicalhistory'] = 'common/medicalhistory';
$route['medicinelist'] = 'common/medicine';
$route['providerimpression'] = 'common/providerimpression';
$route['editpatientavailable'] = 'patientavailable/editpatientavailable';
$route['medicinenonunit'] = 'patienteditmedicine/medicinenonunit';
$route['addmedicinenonunit'] = 'patientmedicine/addmedicinenonunit';
$route['cosumablenonunit'] = 'patienteditconsumable/cosumablenonunit';
$route['addconsumablenonunit'] = 'patientconsumable/addconsumablenonunit';
$route['chiefcomplaints'] = 'common/cheifcomplaints';
//$route['latlong'] = 'common/latlong';
$route['loginvisibility'] = 'common/loginvisibility';
$route['workstation'] = 'common/workstation';

/*Common controller*/
$route['paymentmode'] = 'common/paymentmode';
$route['cylindertype'] = 'common/cylindertype';
$route['standardremarkall'] = 'common/standardRemark';/*Remark All for Maintenance*/
$route['odometerall'] = 'common/startOdometer';
$route['ambstatusoxyfuel'] = 'common/ambstatusoxyfuel';
$route['obviousdeath'] = 'common/obviousdeath';
$route['ambulancestatus'] = 'Common/ambulancestatus';
$route['tyretype'] = 'Common/tyretype';
$route['informedto'] = 'Common/informedto';
$route['accidentaltype'] = 'Common/accidentalType';
$route['breakdowntype'] = 'Common/breakdownType';

/*Indent Request*/
$route['indentreqdistmanager'] = 'Ambulance/indentrequest/indentreqdistmanager';
$route['indentrequestlist'] = 'Ambulance/indentrequest/listindentreq';
$route['addindentrequest'] = 'Ambulance/indentrequest/addindentrequest';
$route['editindentrequest'] = 'Ambulance/indentrequest/editindentrequest';
$route['remark'] = 'Ambulance/indentrequest/standardremark';
$route['receiveremark'] = 'Ambulance/indentrequest/indReqRecremark';
$route['indentrequestreceive'] = 'Ambulance/indentrequest/indentrequestreceive';
$route['addindreqreceive'] = 'Ambulance/indentrequest/addindentrequestreceive';

/*Equipment Request*/
$route['equipment'] = 'Common/equipment';
$route['addequipment'] = 'Ambulance/equipment/addequipment';
$route['editequipment'] = 'Ambulance/equipment/editequipment';
$route['equipmentreceive'] = 'Ambulance/equipment/equipmentreceive';
$route['addequipmentreceive'] = 'Ambulance/equipment/addequipmentreceive';
$route['equipmentlist'] = 'Ambulance/equipment/listequipment';
$route['equipmentlistcount'] = 'Ambulance/equipment/editequipmentlist';

/*Oxygen Filling*/
$route['addoxygenfilling'] = 'Ambulance/oxygenfilling';
$route['oxystndremark'] = 'Ambulance/oxygenfilling/oxystndremark';
$route['oxyUpdateremark'] = 'Ambulance/oxygenfilling/oxystndUpdateremark';
$route['oxygenstation'] = 'Ambulance/oxygenfilling/oygentStation';
$route['updateoxygen'] = 'Ambulance/oxygenfilling/updateoxygen';

/*other user*/
$route['listOxygenfilling'] = 'Ambulance/oxygenfilling/listOxygenfilling';
$route['oxygenfillingdetails'] = 'Ambulance/oxygenfilling/oxygenfillingdetails';

/*Fuel Filling*/
$route['addfuelfilling'] = 'Ambulance/Fuelfilling';
$route['fuelstation'] = 'Ambulance/Fuelfilling/fuelStation';
$route['updatefuelfilling'] = 'Ambulance/Fuelfilling/updatefuelfilling';

/*other user*/
$route['listFuelfilling'] = 'Ambulance/Fuelfilling/listFuelfilling';
$route['fuelfillingdetails'] = 'Ambulance/Fuelfilling/fuelfillingdetails';

/*Ambulance Maintenance*/
$route['addoffroadmaintenance'] = 'Ambulance/Offroadmaintenance';
$route['rerequestoffroad'] = 'Ambulance/Offroadmaintenance/rerequest';
$route['updatererequestoffroad'] = 'Ambulance/Offroadmaintenance/updatererequest';
$route['offroadstndremark'] = 'Ambulance/Offroadmaintenance/offroadstndremark';
$route['offroadstndremarkupdate'] = 'Ambulance/Offroadmaintenance/offroadstndremarkupdate';
$route['tyremaintenance'] = 'Ambulance/tyremaintenance';
$route['maintenancelist'] = 'Ambulance/Tyremaintenance/maintenanceList';
$route['tyrererequest'] = 'Ambulance/Tyremaintenance/tyrerereuqestadd';
$route['rerequestdata'] = 'Ambulance/Tyremaintenance/rerequestdata';
$route['updatetyremaintenance'] = 'Ambulance/Tyremaintenance/tyremaintenanaceupdate';
$route['accidentalmentainance'] = 'Ambulance/accidentalmentainance';
$route['addbreakdownmaintenance'] = 'Ambulance/Breakdownmaintenance';
$route['addpreventivemaintenance'] = 'Ambulance/Preventivemaintenance';
$route['rerequestdetails'] = 'Ambulance/Rerequestdetails';

$route['reportdata'] = 'Report/reportdata';
$route['getleavelist'] = 'Addleave/getlist';
$route['cancleleave'] = 'Addleave/cancleleave';
$route['leavenotification'] = 'Googlenotification/leavenotification';
$route['getvisiterslist'] = 'Addvisitors/getvisiters';
$route['gettraininglist'] = 'Adddemotraining/gettraininglist';

$route['updateleavestatus'] = 'Addleave/actiononleave';
$route['getambincident'] = 'Getamblist/getambincident';
$route['indentreqlistfordispatch'] = 'Ambulancestock/indentreqlistfordispatch';
$route['indentrequestdetails'] = 'Ambulancestock/indentrequestdetails';
$route['indentreqapprove'] = 'Ambulancestock/indentreqapprove';
$route['indentreqdispatch'] = 'Ambulancestock/indentreqdispatch';
$route['equipmentdetails'] = 'Ambulance/equipment/equipmentdetails';
$route['equimentreqapprove'] = 'Ambulance/equipment/equimentreqapprove';
$route['equipmentreqdispatch'] = 'Ambulance/equipment/equipmentreqdispatch';


$route['accidentaldetails'] = 'Ambulance/Accidentalmentainance/accidentaldetails';
$route['breakdowndetails'] = 'Ambulance/Breakdownmaintenance/breakdowndetails';
$route['tyremaintenancedetails'] = 'Ambulance/tyremaintenance/tyremaintenancedetails';
$route['offroadmaintenancedetails'] = 'Ambulance/Offroadmaintenance/offroadmaintenancedetails';
$route['preventivemaintenancedetails'] = 'Ambulance/Preventivemaintenance/preventivemaintenancedetails';

/*Other User*/
$route['maintenanceapproverej'] = 'Ambulance/Maintenanceapproverej';
$route['visitorsdetails'] = 'Addvisitors/visitorsdetails';
$route['demotrainigndetails'] = 'Adddemotraining/demotrainigndetails';
$route['validateUser'] = 'Checkpilotemtotp/validateUser';
$route['usercheckinout'] = 'Checkpilotemtotp/usercheckinout';
$route['getcheckinout'] = 'Checkpilotemtotp/getcheckinout';
$route['getambodometer'] = 'Getamblist/getambodometer';
$route['getquestions'] = 'Getamblist/getquestions';
$route['getattendacewise'] = 'Checkpilotemtotp/getattendacewise';
$route['getdateleaves'] = 'Addleave/getdateleaves';
$route['addqualitycheck'] = 'Getamblist/addqualitycheck';
$route['getuserlistofdocuments'] = 'Uploaddocuments/getuserlistofdocuments';
$route['getuserdocuments'] = 'Uploaddocuments/getuserdocuments';
$route['allambualancedetails'] = 'Allambualancedetails/Getambulancedetails';
$route['ambualancedetails'] = 'Allambualancedetails/allambdetails';
$route['ambstatuscount'] = 'Allambualancedetails/ambstatuscount';

/*112*/
$route['emgcalldis'] = 'Policefire/Emergenvehdis';
$route['emgdisambdetails'] = 'Policefire/Emergenvehdis/emgdisambdetails';
$route['emgcallclosedstatus'] = 'Policefire/Emergenvehdis/emgcallclosedstatus';
$route['casetype'] = 'common/casetype';
$route['odometerdifferance'] = 'Common/odometerDifference';
$route['atscenetimediffonclospg'] = 'Common/atSceneTimeDiffOnClosPg';
$route['atsceneresponceremark'] = 'Common/getAtSceneResponceRemark';

$route['nuevasPassData'] = 'Latlong/nuevasPassData';
$route['pupils'] = 'Common/getpupils';
$route['injurymatrix'] = 'Common/getinjurymatrix';
$route['gcs'] = 'Common/getgcs';

$route['applunchauth'] = 'Applunchauth';
$route['medicaladvicegivenby'] = 'Common/medicaladvicegivenby';
$route['ispatientavareason'] = 'common/isPatientAvaReason';
$route['abandonedremark'] = 'Common/abandonedremark';
$route['bloodgrp'] = 'Common/bloodgrp/';
$route['vehiclechecklist'] = 'Common/vehiclechecklist';
$route['ododiffaspercalltype'] = 'Common/ododiffaspercalltype';
$route['pvthosppaymentmode'] = 'Common/pvthosppaymentmode';
$route['pvthospamount'] = 'Common/pvthospamount';
$route['deliveryinambphoto'] = 'Pcrformupload/delivinambphoto';
$route['lastodologinlogout'] = 'Common/getlastodologinlogout';

$route['supv_applunchauth'] = 'supervisory_app_api_controller/Supervisory_Applunchauth';
$route['supv_device'] = 'supervisory_app_api_controller/Supervisory_Device';
$route['supv_login'] = 'supervisory_app_api_controller/Supervisory_UserLogin';
$route['supv_logout'] = 'supervisory_app_api_controller/Supervisory_Logout';
$route['supv_display'] = 'supervisory_app_api_controller/Supervisory_Display_data/Supervisory_display_amb_data';
$route['supv_supervisory_home'] = 'supervisory_app_api_controller/Supervisory_home';
$route['supv_total_calls'] = 'supervisory_app_api_controller/Supervisory_calls';
$route['supv_dispatch'] = 'supervisory_app_api_controller/Supervisory_dispatch';
$route['supv_amb_detail_list'] = 'supervisory_app_api_controller/Supervisory_amb_details_list';
$route['supv_offroad_counts'] = 'supervisory_app_api_controller/Supervisory_amb_details_list/get_offroad_type_counts';
$route['supv_fuel_list'] = 'supervisory_app_api_controller/Supervisory_fuel_list';
// $route['Supv_Erc_reports'] = 'supervisory_app_api_controller/Supv_Erc_reports';
$route['Supv_amb_maintenance'] = 'supervisory_app_api_controller/Supv_amb_maintenance';
$route['supv_patient_served'] = 'supervisory_app_api_controller/Supervisory_patient_served';
$route['supv_distance_travelled'] = 'supervisory_app_api_controller/Supervisory_distance_travelled';
$route['cqnotification'] = 'Cqmessage/cqnotification';
$route['supv_closure_data'] = 'supervisory_app_api_controller/Supervisory_closure';
$route['login_ero_count'] = 'supervisory_app_api_controller/Login_ero_count';
$route['fuelfillingprevodoandlastupdodo'] = 'Common/fuelfillingprevodoandlastupdodo';
$route['shift'] = 'Common/getshift';
$route['fueldistrict'] = 'District/fueldistrict';