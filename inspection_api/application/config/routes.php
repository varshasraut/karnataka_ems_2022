<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login";
$route['default_controller'] = "welcome";
$route['404_override'] = '';
$route['device'] = 'Device';
$route['medicinelist'] = 'Common_controller';
$route['equipmentlist'] = 'Common_controller/equipment';
$route['districtlist'] = 'Common_controller/district';
$route['ambulancelist'] = 'Common_controller/ambulance';
$route['pilotlist'] = 'Common_controller/pilot';
$route['emsolist'] = 'Common_controller/emso';
$route['grievancetype'] = 'Common_controller/grievancetype';
$route['grievancerelatedto'] = 'Common_controller/grievancerelatedto';
$route['enableloginbtn'] = 'Common_controller/enableloginbtn';
$route['userlogin'] = 'UserLogin';
$route['add_grievance'] = 'grievance/Addgrievance';
$route['inspectioncompcount'] = 'Common_controller/inspectioncompleted';
$route['inspectioninprogcount'] = 'Common_controller/inspectioninprogress';
$route['applunchauth'] = 'Applunchauth';
$route['logout'] = 'Logout';
$route['addfirstforminsp'] = 'inspection/Inspection';
$route['addsecondforminsp'] = 'inspection/Inspection/secondInspFormMainVeh';
$route['addthirdforminsp'] = 'inspection/Inspection/thirdInspFormCleanAmb';
$route['addforthforminspac'] = 'inspection/Inspection/forthInspFormAC';
$route['addfifthforminsptyre'] = 'inspection/Inspection/fifthInspFormTyre';
$route['addsixforminspsiren'] = 'inspection/Inspection/sixInspFormSiren';
$route['addsevenforminspinventor'] = 'inspection/Inspection/sevenInspFormInventory';
$route['addeightforminspbattery'] = 'inspection/Inspection/eightInspFormBattery';
$route['addnineforminspgps'] = 'inspection/Inspection/nineInspFormGPS';
$route['addtenforminsppcrreg'] = 'inspection/Inspection/tenInspFormPCRReg';
$route['addelevenforminspsigatndsheet'] = 'inspection/Inspection/elevenInspFormSigAtndSheet';
$route['incompleteinsplist'] = 'inspection/Editinspection';
$route['editsecondforminsp'] = 'inspection/Editinspection/secondEditInspFormMainVeh';
$route['editthirdformvehmain'] = 'inspection/Editinspection/thirdEditInspFormCleanAmb';
$route['editfourthformac'] = 'inspection/Editinspection/fourthEditInspFormAC';
$route['editfifthformtyre'] = 'inspection/Editinspection/fifthEditInspFormTyre';
$route['editsixformsiren'] = 'inspection/Editinspection/sixEditInspFormSiren';
$route['editsevenforminventory'] = 'inspection/Editinspection/sevenEditInspFormInventory';
$route['editeightformbattery'] = 'inspection/Editinspection/eightEditInspFormBattery';
$route['editnineformgps'] = 'inspection/Editinspection/nineEditInspFormGPS';
$route['edittenformpcrreg'] = 'inspection/Editinspection/tenEditInspFormPCRReg';
$route['editelevenformsignatnsheet'] = 'inspection/Editinspection/elevenEditInspFormSigAtndSheet';
$route['listofviewinspection'] = 'inspection/Viewinspection';
$route['detailslistofviewinsp'] = 'inspection/Viewinspection/detailslistofinsp';
$route['listofcompletedgriv'] = 'grievance/Addgrievance/CompletedGrievanceList';
$route['listofgrivinprog'] = 'grievance/Addgrievance/grievanceListInPro';
$route['griviancedetailsunqid'] = 'grievance/Addgrievance/grievanceDetails';
$route['addtweleforminspmedicine'] = 'inspection/Inspection/tweleInspFormMedicineAdd';
$route['edittweleforminspmedicine'] = 'inspection/Editinspection/tweleInspFormMedicineEdit';
$route['onchangechkambstatus'] = 'Common_controller/onchangeChkAmbStatus';
$route['addthirteenforminspeqp'] = 'inspection/Inspection/thirteenInspFormEqpAdd';
$route['edithirteenforminspeqp'] = 'inspection/Editinspection/thirteenInspFormEquipmentEdit';
$route['detailsofactyresireninvbatt'] = 'inspection/Viewinspection/detailsofactyresireninvbatt';
$route['detailsofequipment'] = 'inspection/Viewinspection/detailsofequipment';
$route['detailsofmedicine'] = 'inspection/Viewinspection/detailsofmedicine';
$route['submitlastinspectionform'] = 'inspection/Inspection/submitlastinspectionform';
$route['colorcodeinspform'] = 'Common_controller/colorcodeinspform';
$route['uploadimgvidofeqp'] = 'inspection/Inspection/thirteenInspFormEqpImgVid';
$route['editequipimgvid'] = 'inspection/Editinspection/thirteenInspFormEqpEditImgVid';
$route['viewInspFormEqpImgVid'] = 'inspection/Viewinspection/viewInspFormEqpImgVid';
$route['checkallformsubmit'] = 'inspection/Inspection/checkAllFormSubmit';
$route['editeqipmentremark'] = 'inspection/Editinspection/editeqipmentremark';
$route['editmedicineremark'] = 'inspection/Editinspection/editmedicineremark';
/* End of file routes.php */
/* Location: ./application/config/routes.php */