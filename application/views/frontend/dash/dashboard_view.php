<?php
$CI = EMS_Controller::get_instance();
defined('BASEPATH') OR exit('No direct script access allowed');


$arr = array(
    'page_no' => @$page_no,
    'records_on_page' => @$page_load_count,
    'dashboard' => 'yes'
);

$data = json_encode($arr);
$data = base64_encode($data);
?>
        <?php
     
        $url = "#";
        //var_dump($user_group);
        if ($user_group == 'UG-EMT') {

            $url = $this->base_url . "emt/emt_home";
        } else if ($user_group == 'UG-ERO' || $user_group == 'UG-BIKE-ERO' || $user_group == 'UG-ERO-104') {

            $url = $this->base_url . "calls";
        } else if ($user_group == 'UG-ERCP') {

            $url = $this->base_url . "ercp";
        } else if ($user_group == 'UG-ERCP-104') {

            $url = $this->base_url . "ercp104";
        } 
        else if ($user_group == 'UG-COUNSELOR-104') {

            $url = $this->base_url . "counselor104";
        } 
        else if ($user_group == 'UG-Dashboard') {
          
            $url = $this->base_url . "dashboard";
        }else if ($user_group == 'UG-ERO-108') {

            $url = $this->base_url . "calls/ero108";
        } else if ($user_group == 'UG-DCO' || $user_group == 'UG-BIKE-DCO') {

            $url = $this->base_url . "job_closer";
            //redirect($this->base_url . "pcr", 'location');
        } else if ($user_group == 'UG-SHAM') {

            $url = $this->base_url . "schedule/schedule_listing";
        } else if ($user_group == 'UG-Supervisor' || $user_group == 'UG-SuperAdmin' || $user_group == 'UG-IT-HEAD' ||$user_group == 'UG-ADMIN' || $user_group == 'UG-ShiftManager' || $user_group == 'UG-ANALYTICS') {

            $url = $this->base_url . "supervisor";
        } else if ($user_group == 'UG-FLEET-SUGARFCTORY' || $user_group == 'UG-FleetManagement') {

            $url = $this->base_url . "fleet";
        } else if ($user_group == 'UG-PDA') {

            $url = $this->base_url . "police_calls";
        } else if ($user_group == 'UG-FDA') {

            $url = $this->base_url . "fire_calls";
        }else if ($user_group == 'UG-Grievance'  || $user_group == 'UG-GrievianceManager' ) {
            
            $url = $this->base_url . "grievance/grievance_call_list";
            
        }else if ($user_group == 'UG-Feedback' || $user_group == 'UG-FeedbackManager') {
            
         $url = $this->base_url . "feedback/feedback_list";
            
        }
        else if ($user_group == 'UG-ERO-HD') {
             $url = $this->base_url . "corona/corona_list";
        }
        else if ( $user_group == 'UG-FOLLOWUPERO') {

            $url = $this->base_url . "calls/erorfollowup_list";
        }
        else if ($user_group == 'UG-Dashboard-view') {
          
            $url = $this->base_url . "dashboard/dash";
        }
        else if ($user_group == 'UG-HOSP') {
          
            $url = $this->base_url . "hospital";
        }else if ($user_group == 'UG-MemsDashboard') {
            //var_dump($user_group ,"under");die();
            $url = $this->base_url . "dashboard/memsdashboard";
        }else if ($user_group == 'UG-COMPLIANCE') {
             //var_dump($user_group ,"under");die();
            $url = $this->base_url . "grievance/grievance_call_list";
            
        }else if ($user_group == 'UG-INSPECTION') {
            $url = $this->base_url . "inspection/dashboard";
            // $url = $this->base_url . "inspection/load_dashboard";
         }else if ($user_group == 'UG-CLINICAL_GOV') {
            $url = $this->base_url . "clinical/clinical_list";
            // $url = $this->base_url . "inspection/load_dashboard";
         }else if ($user_group == 'UG-VENDOR') {
            $url = $this->base_url . "ambulance_maintaince/vendor_view";
         }else if ($user_group == 'UG-SAM_DASH') {
            $url = $this->base_url . "Sam_dash/maha_dash";
         }
         else if ($user_group == 'UG-JAES-DASHBOARD') {
            $url = $this->base_url . "erc_dashboards/erc_dash";
         }
         else if ($user_group == 'UG-JAES-NHM-DASHBOARD') {
            $url = $this->base_url . "erc_dashboards/nhm_dash";
         }
         else if ($user_group == 'UG-KPI-DASHBOARD') {
            $url = $this->base_url . "erc_dashboards/kpi_dash";
         }
         else if ($user_group == 'UG-CM') {
            $url = $this->base_url . "erc_dashboards/CM_dash";
         }
         else if ($user_group == 'UG-RTM') {
            $url = $this->base_url . "job_closer/rtm";
         }
         else if ($user_group == 'UG-CENTERDASH') {
            $url = $this->base_url . "erc_dashboards/centralized_dash";
         }
        ?>

    <script>
        <?php 
          $login_url = $this->base_url . "clg";
        ?>
//        if(!is_clg_login()){
//            
//           window.location = '<?php echo $login_url;?>';
//        }else{
//            window.location = '<?php echo $url; ?>';
//        }
        
    </script>
<div id="container">
    <!--<div class="dashboard_heading">Dashboard</div>

    <div class="dashboard_chart_container">

        Redirecting ...

    </div>-->
    <a id="click_trigger" href="<?php echo $url; ?>" class="hide">dash trigger</a>


</div>