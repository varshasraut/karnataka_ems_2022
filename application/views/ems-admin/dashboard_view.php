<?php 

$CI = EMS_Controller::get_instance();
defined('BASEPATH') OR exit('No direct script access allowed');

 
$arr=array(
    'page_no'=>@$page_no,
    'records_on_page'=>@$page_load_count,
    'dashboard'=>'yes'
  );
             
$data=json_encode($arr);
$data=base64_encode($data);

?>

        <div id="container">
            <div class="dashboard_heading">Dashboard</div>

            <div class="dashboard_chart_container">
               
                Coming Soon!!!
                
            </div>
            
            
       
            
        </div>