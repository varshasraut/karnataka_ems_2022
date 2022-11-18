<div class="page-content--bgf7" >
<div class="container-fluid" style="margin-bottom:3%;">
    <div class="row text-center">
    <div class="col-md-6 remove_padding_md6">
    <table class="table table-bordered NHM_Dashboard" >
        <thead class="" >
        <tr><th colspan="4">MHEMS 108 Seva</th></tr>
        <tr id="108">
            <th style="line-height: 70px;">Districts</th>
            <th style="line-height: 70px;">Dispatch Today</th>
            <th>Patients Served This Month</th>
            <th>Patients Served Till date</th>
        </tr>
        </thead>
    </table>
    <table class="table table-bordered NHM_Dashboard" id="nhm108"> </table>
    </div>
    <div class="col-md-6 remove_padding_md6 ">        
        <table class="table table-bordered NHM_Dashboard" id="">
            <thead class="" >
                <tr><th colspan="4">MHEMS 102 Janani Shishu Seva</th></tr>
            <tr id="102">
                <th style="height: 96px; line-height: 54px;">Districts</th>
                <th style="height: 96px; line-height: 54px;">Dispatch Today</th>
            <th style="height: 96px; line-height: 54px;">Dispatch This Month</th>
            <th style="height: 96px; line-height: 54px;">Dispatch Till date</th>
            </tr>
            </thead>
        </table>
        <table class="table table-bordered NHM_Dashboard" id="nhm102"> </table>
    </div>  
    <!-- <div class="col-md-6 remove_padding_md6">        
        <iframe id="map" src="<?php echo base_url();?>amb/nhm_all" style="width:100%; height: 220px; border-style: solid;"></iframe>      
    </div>
    <div class="col-md-6 remove_padding_md6" >        
        <iframe id="B12data" src="<?php echo base_url();?>amb/B12_data" style="width:100%; height: 120%; border:0px;"></iframe>  
    </div>-->
    </div>             
    </div>  
</div> 
<script type="text/javascript">
 $(document).ready(function() {
     window.onload=nhm_dispatch();
     setInterval("nhm_dispatch()",1800000);
     //setInterval("ajaxcall_nhm()",1808);
    });
</script>

