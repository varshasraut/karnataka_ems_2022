<?php $CI = EMS_Controller::get_instance();?>
<?php 
if($district_bed){
if($clg_group == 'UG-DIVISIONAL-OPERATION-HEAD' || $clg_group == 'UG-NHM-DASHBOARD') { ?>
<div class="row">
 <label style="padding-top:10px;text-align: center;font-size:20px;color:#black;">District FOR COVID19 & NON COVID19</label>
</div> 

<div class="row">
<div class="col-md-2 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
  <tr>                                      
    <th height="120">District Name</th>
  </tr>
  <tr>                                      
  </tr>
</table>
</div>
<div class="col-md-5 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
  <tr>                                      
    <th colspan="3">Covid-19 Bed</th>
  </tr>
  <tr>                                      
    <th>Total Bed</th>
    <th >Occupied</th>
    <th >Vacant</th>
  </tr>
</table>
</div>
<div class="col-md-5 paddindOverRide" >
<table class="table table-bordered NHM_Dashboard"  >
  <tr>                                      
    <th colspan="3">Non Covid-19 Bed</th>
  </tr>
  <tr>                                      
    <th >Total Bed</th>
    <th >Occupied</th>
    <th >Vacant</th>
  </tr>  
</table>
</div>
</div>
<div class="row">
<div class="col-md-2 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
    <tr>
    <td><a style="cursor:pointer" id="dis_<?php echo $screning['district_id'];?>" class="click-xhttp-request" data-href="{base_url}bed/nhm_district_bed_hospital" data-qr="output_position=content&district_id=<?php echo $district_id ;?>"><strong><?php echo $district_name; ?> </strong></a></td>
       <!-- <td><a ><strong><?php echo $district_name;?> </strong></a></td>-->
    </tr>   
</table>
</div>
<div class="col-md-5 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
<tr>
  <td><?php if($district_c19_total_bed !='0' || $district_c19_total_bed !=' '){ echo $district_c19_total_bed; }else{ echo 'DNA'; }   ?></td>  
  <td><?php if($district_C19_Occupied !='0' || $district_C19_Occupied !=' '){ echo $district_C19_Occupied; }else{ echo 'DNA'; }   ?></td>  
  <td><?php if($district_C19_Vacant !='0' || $district_C19_Vacant !=' '){ echo $district_C19_Vacant; }else{ echo 'DNA'; }   ?></td> 
        
</tr>   
</table>
</div>
<div class="col-md-5 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
  <tr>
  <td><?php if($district_non_c19_total_bed !='0' || $district_non_c19_total_bed !=' '){ echo $district_non_c19_total_bed; }else{ echo 'DNA'; }   ?></td>  
  <td><?php if($district_NonC19_Occupied !='0' || $district_NonC19_Occupied !=' '){  echo $district_NonC19_Occupied; }else{ echo 'DNA'; }   ?></td>  
  <td><?php if($district_NonC19_Vacant !='0' || $district_NonC19_Vacant !=' '){  echo $district_NonC19_Vacant; }else{ echo 'DNA'; }   ?></td> 
  </tr>   
</table>
</div>
</div> <?php } ?>
<div class="row">
 <label style="padding-top:10px;text-align: center;font-size:20px;color:#black;">Hospital FOR COVID19 & NON COVID19</label>
</div> 
<div class="row">
<div class="col-md-2 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
  <tr>                                      
    <th height="104">Hospital Name</th>
  </tr>
  <tr>                                      
  </tr>
</table>
</div>
<div class="col-md-5 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
  <tr>                                      
    <th colspan="3">Covid-19 Bed</th>
  </tr>
  <tr>                                      
    <th>Total Bed</th>
    <th >Occupied</th>
    <th >Vacant</th>
  </tr>
</table>
</div>
<div class="col-md-5 paddindOverRide" >
<table class="table table-bordered NHM_Dashboard"  >
  <tr>                                      
    <th colspan="3">Non Covid-19 Bed</th>
  </tr>
  <tr>                                      
    <th >Total Bed</th>
    <th >Occupied</th>
    <th >Vacant</th>
  </tr>  
</table>
</div>
</div>
  <?php
  //var_dump($district_bed);die();

    $i=0;
foreach($district_bed as $key=>$screning){
?>
<div class="row">
<div class="col-md-2 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
    <tr>
        <td><a style="cursor:pointer" id="dis_<?php echo $screning['district_id'];?>" class="click-xhttp-request" data-href="{base_url}bed/nhm_bed_hospital_wise" data-qr="output_position=content&hp_id=<?php echo $screning['hp_id'];?>&district_id=<?php echo $district_id; ?>"><strong><?php echo $screning['hp_name'];  ?> </strong></a></td>
    </tr>   
</table>
</div>
<div class="col-md-5 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
<tr>
  <td><?php if($screning['c19_total_bed']!='0' || $screning['c19_total_bed']!=' '){ echo $screning['c19_total_bed']; }else{ echo 'DNA'; } ?></td>  
  <td><?php if($screning['C19_Occupied']!='0' || $screning['C19_Occupied']!=' '){ echo $screning['C19_Occupied']; }else{ if($screning['c19_total_bed']!='0' || $screning['c19_total_bed']!=' ') { echo '0'; }else{ echo 'DNA'; } } ?></td>  
  <td><?php if($screning['C19_Vacant']!='0' || $screning['C19_Vacant']!=' '){ echo $screning['C19_Vacant']; }else{ if($screning['c19_total_bed']!='0' || $screning['c19_total_bed']!=' ') { echo '0'; }else{ echo 'DNA'; } } ?></td> 
        
</tr>   
</table>
</div>
<div class="col-md-5 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
  <tr>
    <td><?php if($screning['non_c19_total_bed']!='0' || $screning['non_c19_total_bed']!=' '){ echo $screning['non_c19_total_bed']; }else{ echo 'DNA'; } ?></td>  
    <td><?php if($screning['NonC19_Occupied']!='0' || $screning['NonC19_Occupied']!=' '){ echo $screning['NonC19_Occupied']; }else{ if($screning['non_c19_total_bed']!='0' || $screning['non_c19_total_bed']!=' ') { echo '0'; }else{ echo 'DNA'; } } ?></td> 
    <td><?php if($screning['NonC19_Vacant']!='0' || $screning['NonC19_Vacant']!=' '){ echo $screning['NonC19_Vacant']; }else{ if($screning['non_c19_total_bed']!='0' || $screning['non_c19_total_bed']!=' ') { echo '0'; }else{ echo 'DNA'; } } ?></td>  
  </tr>   
</table>
</div>
</div>
<?php }

?> <br><br> <?php
} 
else{ ?>
<div class="row">
 <label style="padding-top:10px;text-align: center;font-size:20px;color:blue;">Data not found for Hospital FOR COVID19 & NON COVID19</label>
</div> 
<?php }
?><br><br>
