
<div class="container-fluid" style="margin-bottom:5%;">
<div class="row">
 <label style="padding-top:10px;text-align: center;font-size:20px;color:#black;">DISTRICT DETAILS</label>
</div>
    <div class="row text-center">
    <div class="col-md-12 remove_padding_md6">
    <table class="table table-bordered NHM_Dashboard" >
        <thead class="" >
        <tr id="108">
            <th>District</th>
            <th>Dispatch Today</th>
            <th>Patients Served This Month</th>
            <th>Patients Served Till date</th>
        </tr>
        </thead>
    </table>
    <table class="table table-bordered NHM_Dashboard" id="nhm108"> 
        <?php foreach($dis_data as $key=>$screning){ ?>
        <tr>
        
            <!--<td><a style="cursor:pointer" id="dis_<?php echo $screning['dst_name'];?>" class="click-xhttp-request" data-href="{base_url}dashboard/nhm108_district_view" data-qr="output_position=content&dst_name=<?php echo $screning['dst_name'];?>"><strong><?php echo $screning['dst_name'];?> </strong></a>-->
            <td><?php echo $screning['dst_name']; ?></td>
            <td><?php echo $screning['dispatch_today_102']; ?></td>
            <td><?php echo $screning['dispatch_tm']; ?></td>
            <td><?php echo $screning['dispatch_td']; ?></td>
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
