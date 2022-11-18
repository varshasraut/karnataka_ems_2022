<?php
$CI = EMS_Controller::get_instance();
?>
<div class="container-fluid" >
    <div class="row text-center">
    <div class="col-md-12 remove_padding_md6">
    <table class="table table-bordered NHM_Dashboard" >
        <thead class="" >
        <tr><th colspan="4">IRTS 108</th></tr>
        <tr id="108">
            <th>State</th>
            <th>Dispatch Today</th>
            <th>Patients Served This Month</th>
            <th>Patients Served Till date</th>
        </tr>
        </thead>
    </table>
    <table class="table table-bordered NHM_Dashboard" id="nhm108"> 
        <tr id="108">
            <!--<td><a  style="cursor:pointer" class="click-xhttp-request" data-href="{base_url}dashboard/nhm108_division_view" data-qr="output_position=district_data&showprocess=yes" >MAHARASHATRA</a></td>-->
            <td><a  style="cursor:pointer" class="click-xhttp-request" data-href="{base_url}dashboard/nhm108_district_view" data-qr="output_position=district_data&dst_state=<?php echo 'MH'; ?>&showprocess=yes" >MP</a></td>
           <!-- <td><?php //echo $today_non_eme?$today_non_eme:0; ?></td>
            <td><?php //echo $b12_patient_served[0]->b12_key_till_month ; ?></td>
            <td><?php //echo $b12_patient_served[0]->b12_key_till_date; ?></td>-->
            <td><?php echo $total_nhm_data[0]->patient_served_today; ?></td>
            <td><?php echo $total_nhm_data[0]->patient_served_tm; ?></td>
            <td><?php echo $total_nhm_data[0]->patient_served_td + $total_nhm_data[0]->patient_servedold_td; ?></td>
        
        </tr>
    </table>
    </div>
  
    
    </div>             
    </div>  
    <div class="row text-center">
    <div id="division108_view" class="col-md-12 remove_padding_md6">
    </div>
  
    </div>
    <div class="row text-center">
    <div id="district108_view" class="col-md-12 remove_padding_md6">
    </div>
    
    </div>
 
<!--<script type="text/javascript">
 $(document).ready(function() {
     window.onload=nhm_dispatch();
     setInterval("nhm_dispatch()",1800000);
     //setInterval("ajaxcall_nhm()",1808);
    });
</script>-->
