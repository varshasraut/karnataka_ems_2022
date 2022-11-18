
<div class="container-fluid" style="margin-bottom:5%;">
<div class="row">
 <label style="padding-top:10px;text-align: center;font-size:20px;color:#black;">AMBULANCE DETAILS</label>
</div>
    <div class="row text-center">
    <div class="col-md-12 remove_padding_md6">
    <table class="table table-bordered NHM_Dashboard" >
        <thead class="" >
        <tr>
            <th>Ambulance No</th>
            <!--<th>Base Location</td>-->
            <th>Patients Served Today</th>
            <th>Patients Served This Month</th>
            <th>Patients Served Till date</th>
        </tr>
        </thead>
    </table>
    <table class="table table-bordered NHM_Dashboard" id="nhm108"> 
        <?php 
        //var_dump($amb_data);
        foreach($amb_data as $key=>$screning){ 
             //var_dump($screning);die();
            ?>
        <tr>
            <!--<td><a style="cursor:pointer" id="dis_<?php //echo $screning['dst_code'];?>" class="click-xhttp-request" data-href="{base_url}dashboard/nhm_ambulance_view" data-qr="output_position=content&dst_code=<?php ////echo $screning['dst_code'];?>"><?php //echo $screning['dst_name'];?></a>-->
            <td><?php echo $screning['amb_rto_register_no']; ?></td>
            
            <!--<td><?php //echo $screning['hp_name']; ?></td>-->
            <td><?php echo $screning['patient_served_today']; ?></td>
            <td><?php echo $screning['patient_served_tm']; ?></td>
            <td><?php echo $screning['patient_served_td']; ?></td>
            <td></td>
            <td></td>
        </tr>
        <?php } ?>
    </table>
    </div>
    
    
    </div>             
    </div>  

<!--<script type="text/javascript">
 $(document).ready(function() {
     window.onload=nhm_dispatch();
     setInterval("nhm_dispatch()",1800000);
     //setInterval("ajaxcall_nhm()",1808);
    });
</script>-->
