   <script>
        $(".mi_loader").fadeOut("slow");
    </script>
<div class="container-fluid" >
    <div class="row text-center">
    <div class="col-md-12 remove_padding_md6">
    <table class="table table-bordered NHM_Dashboard" >
        <thead class="" >
        <tr><th colspan="4">IRTS 108</th></tr>
        <tr id="108">
            <th>Districts</th>
            <th>Patients Served Today</th>
            <th>Patients Served This Month</th>
            <th>Patients Served Till date</th>
        </tr>
        </thead>
    </table>
    <table class="table table-bordered NHM_Dashboard" id="nhm108"> 
        <tr id="108">
            <!--<td><a  style="cursor:pointer" class="click-xhttp-request" data-href="{base_url}dashboard/nhm_division_view" data-qr="output_position=district_data&showprocess=yes" >MAHARASHATRA</a></td>--> 
<td><a  style="cursor:pointer" class="click-xhttp-request" data-href="{base_url}dashboard/nhm_district_view" data-qr="output_position=district_data&dst_state=<?php echo 'MP'; ?>&showprocess=yes" >Madyapradesh</a></td>
            <td><?php echo $today_dispatch_patient_ct; ?></td>
            <td><?php echo $total_dist_closure_tm; ?></td>
            <td><?php echo $total_nhm_data[0]->patient_served_td + $total_nhm_data[0]->patient_servedold_td + $total_nhm_data[0]->patient_servedold1_td; ?></td>
        </tr>
    </table>
    </div>
    
    
    </div>             
    </div>  
    <div class="row text-center">
    <div id="division_view" class="col-md-12 remove_padding_md6">
    </div>
    
    </div>
    <div class="row text-center">
    <div id="district_view" class="col-md-12 remove_padding_md6">
    </div>
    <div id="ambulance_view" class="col-md-12 remove_padding_md6">
    </div>

    </div>
 
<!--<script type="text/javascript">
 $(document).ready(function() {
     window.onload=nhm_dispatch();
     setInterval("nhm_dispatch()",1800000);
     //setInterval("ajaxcall_nhm()",1808);
    });
</script>-->
