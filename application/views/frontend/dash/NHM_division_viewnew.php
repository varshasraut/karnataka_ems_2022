

<div class="container-fluid" style="margin-bottom:1%;">
<div class="row">
 <label style="padding-top:10px;text-align: center;font-size:20px;color:#black;">DIVISION DETAILS</label>
</div>
    <div class="row text-center">
    <div class="col-md-12 remove_padding_md6">
    <table class="table table-bordered NHM_Dashboard" >
        <thead class="" >
        <tr id="108">
            <th>Division</th>
            <th>Patients Served Today</th>
            <th>Patients Served This Month</th>
            <th>Patients Served Till date</th>
        </tr>
        </thead>
    </table>
    <table class="table table-bordered NHM_Dashboard" id="nhm108"> 
    <?php foreach($div_data as $key=>$screning){ ?>
        <tr>
        <td><a style="cursor:pointer" id="dis_<?php echo $screning['div_code'];?>" class="click-xhttp-request" data-href="{base_url}dashboard/nhm_district_view" data-qr="output_position=content&div_code=<?php echo $screning['div_code'];?>"><?php echo $screning['div_name'];?></a>
            <td><?php echo $screning['patient_served_today']; ?></td>
            <td><?php echo $screning['patient_served_tm']; ?></td>
            <td><?php echo $screning['patient_served_td']; ?></td>
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
