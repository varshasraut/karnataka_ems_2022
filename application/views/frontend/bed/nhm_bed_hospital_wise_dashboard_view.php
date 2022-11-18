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
    <th height="104">District Name</th>
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
        <td><a ><strong><?php echo $district_name;?> </strong></a></td>
    </tr>   
</table>
</div>
<div class="col-md-5 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
<tr>
  <td><?php if($district_c19_total_bed !='0' || $district_c19_total_bed !=' '){ echo $district_c19_total_bed;  }else{ echo 'DNA'; }  ?></td>  
  <td><?php if($district_C19_Occupied !='0' || $district_C19_Occupied !=' '){ echo $district_C19_Occupied;  }else{ echo 'DNA'; }  ?></td>  
  <td><?php if($district_C19_Vacant !='0' || $district_C19_Vacant !=' '){ echo $district_C19_Vacant;  }else{ echo 'DNA'; }  ?></td> 
        
</tr>   
</table>
</div>
<div class="col-md-5 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
  <tr>
  <td><?php if($district_non_c19_total_bed !='0' || $district_non_c19_total_bed !=' '){ echo $district_non_c19_total_bed;  }else{ echo 'DNA'; }  ?></td>  
  <td><?php if($district_NonC19_Occupied !='0' || $district_NonC19_Occupied !=' '){ echo $district_NonC19_Occupied;  }else{ echo 'DNA'; }  ?></td>  
  <td><?php if($district_NonC19_Vacant !='0' || $district_NonC19_Vacant !=' '){ echo $district_NonC19_Vacant;  }else{ echo 'DNA'; }  ?></td> 
  </tr>   
</table>
</div>
</div>
    <?php } ?>
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
        <td><a style="cursor:pointer" id="dis_<?php echo $screning['district_id'];?>" class="click-xhttp-request" data-href="{base_url}bed/nhm_bed_hospital_wise" data-qr="output_position=content&hp_id=<?php echo $screning['hp_id'];?>&district_id=<?php echo $screning['district_id']; ?>"><strong><?php echo $screning['hp_name'];?> </strong></a></td>
    </tr>   
</table>
</div>
<div class="col-md-5 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
<tr>
  <td><?php  if($screning['C19_Total_Beds'] !='0' ){ echo $screning['C19_Total_Beds'];  }else{ echo 'DNA'; } ?></td>  
  <td><?php  if($screning['C19_Occupied'] !='0' ){ echo $screning['C19_Occupied'];  }else{ if($screning['c19_total_bed']!='0' || $screning['c19_total_bed']!=' ') { echo '0'; }else{ echo 'DNA'; } } ?></td>   
  <td><?php  if($screning['C19_Vacant'] !='0' ){ echo $screning['C19_Vacant'];  }else{ if($screning['c19_total_bed']!='0' || $screning['c19_total_bed']!=' ') { echo '0'; }else{ echo 'DNA'; } } ?></td>  
        
</tr>   
</table>
</div>
<?php //var_dump($screning['NonC19_Total_Beds']);die(); ?>
<div class="col-md-5 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
  <tr>
    <td><?php if($screning['NonC19_Total_Beds'] !='0' || $screning['NonC19_Total_Beds']!='null' || $screning['NonC19_Total_Beds'] != '' ){ echo $screning['NonC19_Total_Beds'];  }else{ if($screning['NonC19_Total_Beds']!='0' || $screning['NonC19_Total_Beds']!='' || $screning['NonC19_Total_Beds']!='null') { echo '0'; }else{ echo 'DNA'; } } ?></td>   
   <td><?php if($screning['NonC19_Occupied'] !='0' || $screning['NonC19_Occupied']!='null' || $screning['NonC19_Occupied'] != ''){ echo $screning['NonC19_Occupied'];  } else{ if($screning['NonC19_Total_Beds']!='0' || $screning['NonC19_Total_Beds']!='' || $screning['NonC19_Total_Beds']!='null') { echo '0'; }else{ echo 'DNA'; } } ?></td>   
    <td><?php if($screning['NonC19_Vacant'] !='0' || $screning['NonC19_Vacant'] !='null' || $screning['NonC19_Vacant'] != '' ){ echo $screning['NonC19_Vacant'];  }else{ if($screning['NonC19_Total_Beds']!='0' || $screning['NonC19_Total_Beds']!='' || $screning['NonC19_Total_Beds']!='null' ) { echo '0'; }else{ echo 'DNA'; } } ?></td>  
  </tr>   
</table>
</div>
</div>
<?php }

?>
<div class="row">
 <label style="padding-top:10px;text-align: center;font-size:20px;color:#black;">Hospital Details FOR COVID19 & NON COVID19</label>
</div>
<div class="row">
<table class="table table-bordered NHM_Dashboard">

<tr>                
    <th  width="10px">Name</th>
    <th>Type</th>
    <th>Total Beds</th>
    <th>Occupied Beds</th>
    <th>Vacant Beds</th>
    <th >Remarks</th>
   
</tr>

<tr>
    <td style="text-align:left;font-weight:bold">Facility Type</td>                            
    <td style="text-align:left;font-weight:bold">COVID-19</td> 
    <!-- <td> <?php //if($screning['C19Ward_Vacant'] != '0' && $screning['C19Ward_Vacant'] != 'null' && $screning['C19Ward_Vacant'] != ''){ echo $screning['C19Ward_Vacant']; }else{ echo '0'; }  ?> </td> -->
    <td style="font-weight:bold"> <?php if($screning['C19_Total_Beds'] !='0' && $screning['C19_Total_Beds'] != 'null' && $screning['C19_Total_Beds'] != ''){ echo $screning['C19_Total_Beds']; }else{ if($screning['C19_Total_Beds'] !='0' && $screning['C19_Total_Beds'] != 'null' && $screning['C19_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td style="font-weight:bold"> <?php if($screning['C19_Occupied'] !='0' && $screning['C19_Occupied'] != 'null' && $screning['C19_Occupied'] != ''){ echo $screning['C19_Occupied']; }else{ if($screning['C19_Total_Beds'] !='0' && $screning['C19_Total_Beds'] != 'null' && $screning['C19_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td style="font-weight:bold"> <?php if($screning['C19_Vacant'] !='0' && $screning['C19_Vacant'] != 'null' && $screning['C19_Vacant'] != ''){ echo $screning['C19_Vacant']; }else{ if($screning['C19_Total_Beds'] !='0' && $screning['C19_Total_Beds'] != 'null' && $screning['C19_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td style="font-weight:bold"> <?php if($screning['C19_Remarks'] !='0' && $screning['C19_Remarks'] != 'null' && $screning['C19_Remarks'] != ''){ echo $screning['C19_Remarks']; }else{ echo 'NA'; } ?> </td> 
    </tr>

<tr>
    <td style="text-align:left">ICU beds without ventilator</td> 
    <td></td> 
    <td> <?php  if($screning['ICUWoVenti_Total_Beds'] !='0' && $screning['ICUWoVenti_Total_Beds'] != 'null' && $screning['ICUWoVenti_Total_Beds'] != '' ){ echo $screning['ICUWoVenti_Total_Beds']; }else{ if($screning['ICUWoVenti_Total_Beds'] !='0' && $screning['ICUWoVenti_Total_Beds'] != 'null' && $screning['ICUWoVenti_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php  if($screning['ICUWoVenti_Occupied'] !='0' && $screning['ICUWoVenti_Occupied'] != 'null' && $screning['ICUWoVenti_Occupied'] != ''){ echo $screning['ICUWoVenti_Occupied']; }else{ if($screning['ICUWoVenti_Total_Beds'] !='0' && $screning['ICUWoVenti_Total_Beds'] != 'null' && $screning['ICUWoVenti_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php  if($screning['ICUWoVenti_Vacant'] !='0' && $screning['ICUWoVenti_Vacant'] != 'null' && $screning['ICUWoVenti_Vacant'] != ''){ echo $screning['ICUWoVenti_Vacant']; }else{ if($screning['ICUWoVenti_Total_Beds'] !='0' && $screning['ICUWoVenti_Total_Beds'] != 'null' && $screning['ICUWoVenti_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php  if($screning['ICUWoVenti_Remarks'] !='0' && $screning['ICUWoVenti_Remarks'] != 'null' && $screning['ICUWoVenti_Remarks'] != ''){ echo $screning['ICUWoVenti_Remarks']; }else{ echo 'NA'; } ?> </td> 
                           
   
    </tr>
<tr>
    <td style="text-align:left">ICU beds with ventilator</td>                            
    <td></td> 
    <td> <?php if($screning['ICUwithVenti_Total_Beds'] !='0' && $screning['ICUwithVenti_Total_Beds'] != 'null' && $screning['ICUwithVenti_Total_Beds'] != ''){ echo $screning['ICUwithVenti_Total_Beds']; }else{ if($screning['ICUwithVenti_Total_Beds'] !='0' && $screning['ICUwithVenti_Total_Beds'] != 'null' && $screning['ICUwithVenti_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['ICUwithVenti_Occupied'] !='0' && $screning['ICUwithVenti_Occupied'] != 'null' && $screning['ICUwithVenti_Occupied'] != ''){ echo $screning['ICUwithVenti_Occupied']; }else{ if($screning['ICUwithVenti_Total_Beds'] !='0' && $screning['ICUwithVenti_Total_Beds'] != 'null' && $screning['ICUwithVenti_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['ICUwithVenti_Vacant'] !='0' && $screning['ICUwithVenti_Vacant'] != 'null' && $screning['ICUwithVenti_Vacant'] != ''){ echo $screning['ICUwithVenti_Vacant']; }else{ if($screning['ICUwithVenti_Total_Beds'] !='0' && $screning['ICUwithVenti_Total_Beds'] != 'null' && $screning['ICUwithVenti_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['ICUwithVenti_Remarks'] !='0' && $screning['ICUwithVenti_Remarks'] != 'null' && $screning['ICUwithVenti_Remarks'] != ''){ echo $screning['ICUwithVenti_Remarks']; }else{ echo 'NA'; } ?> </td> 
</tr>
<tr>
    <td style="text-align:left">Dialysis bed</td>                            
    <td></td> 
    <td> <?php if($screning['ICUwithdialysisBed_Total_Beds'] !='0' && $screning['ICUwithdialysisBed_Total_Beds'] != 'null' && $screning['ICUwithdialysisBed_Total_Beds'] != ''){ echo $screning['ICUwithdialysisBed_Total_Beds']; }else{ if($screning['ICUwithdialysisBed_Total_Beds'] !='0' && $screning['ICUwithdialysisBed_Total_Beds'] != 'null' && $screning['ICUwithdialysisBed_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['ICUwithdialysisBed_Occupied'] !='0' && $screning['ICUwithdialysisBed_Occupied'] != 'null' && $screning['ICUwithdialysisBed_Occupied'] != ''){ echo $screning['ICUwithdialysisBed_Occupied']; }else{ if($screning['ICUwithdialysisBed_Total_Beds'] !='0' && $screning['ICUwithdialysisBed_Total_Beds'] != 'null' && $screning['ICUwithdialysisBed_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['ICUwithdialysisBed_Vacant'] !='0' && $screning['ICUwithdialysisBed_Vacant'] != 'null' && $screning['ICUwithdialysisBed_Vacant'] != ''){ echo $screning['ICUwithdialysisBed_Vacant']; }else{ if($screning['ICUwithdialysisBed_Total_Beds'] !='0' && $screning['ICUwithdialysisBed_Total_Beds'] != 'null' && $screning['ICUwithdialysisBed_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['ICUwithdialysisBed_Remarks'] !='0' && $screning['ICUwithdialysisBed_Remarks'] != 'null' && $screning['ICUwithdialysisBed_Remarks'] != ''){ echo $screning['ICUwithdialysisBed_Remarks']; }else{ echo 'NA'; } ?> </td> 
</tr>

<tr>
    <td style="text-align:left">Ward</td>                            
    <td></td> 
    <td> <?php if($screning['C19Ward_Total_Beds'] !='0' && $screning['C19Ward_Total_Beds'] != 'null' && $screning['C19Ward_Total_Beds'] != ''){ echo $screning['C19Ward_Total_Beds']; }else{ if($screning['C19Ward_Total_Beds'] !='0' && $screning['C19Ward_Total_Beds'] != 'null' && $screning['C19Ward_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td>  
    <td> <?php if($screning['C19Ward_Occupied'] !='0' && $screning['C19Ward_Occupied'] != 'null' && $screning['C19Ward_Occupied'] != ''){ echo $screning['C19Ward_Occupied']; }else{ if($screning['C19Ward_Total_Beds'] !='0' && $screning['C19Ward_Total_Beds'] != 'null' && $screning['C19Ward_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['C19Ward_Vacant'] !='0' && $screning['C19Ward_Vacant'] != 'null' && $screning['C19Ward_Vacant'] != ''){ echo $screning['C19Ward_Vacant']; }else{ if($screning['C19Ward_Total_Beds'] !='0' && $screning['C19Ward_Total_Beds'] != 'null' && $screning['C19Ward_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['C19Ward_Remarks'] !='0' && $screning['C19Ward_Remarks'] != 'null' && $screning['C19Ward_Remarks'] != ''){ echo $screning['C19Ward_Remarks']; }else{ echo 'NA'; } ?> </td> 
</tr>
 <tr>
    <td style="text-align:left">Isolation beds </td>                            
    <td style="text-align:left">COVID19 positive</td> 
    <td> <?php if($screning['C19Positive_Total_Beds'] !='0' && $screning['C19Positive_Total_Beds'] != 'null' && $screning['C19Positive_Total_Beds'] != ''){ echo $screning['C19Positive_Total_Beds']; }else{ if($screning['C19Positive_Total_Beds'] !='0' && $screning['C19Positive_Total_Beds'] != 'null' && $screning['C19Positive_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td>  
    <td> <?php if($screning['C19Positive_Occupied'] !='0' && $screning['C19Positive_Occupied'] != 'null' && $screning['C19Positive_Occupied'] != ''){ echo $screning['C19Positive_Occupied']; }else{ if($screning['C19Positive_Total_Beds'] !='0' && $screning['C19Positive_Total_Beds'] != 'null' && $screning['C19Positive_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['C19Positive_Vacant'] !='0' && $screning['C19Positive_Vacant'] != 'null' && $screning['C19Positive_Vacant'] != ''){ echo $screning['C19Positive_Vacant']; }else{ if($screning['C19Positive_Total_Beds'] !='0' && $screning['C19Positive_Total_Beds'] != 'null' && $screning['C19Positive_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td>  
    <td> <?php if($screning['C19Positive_Remarks'] !='0' && $screning['C19Positive_Remarks'] != 'null' && $screning['C19Positive_Remarks'] != ''){ echo $screning['C19Positive_Remarks']; }else{ echo 'NA'; } ?> </td> 
</tr>
<tr>
    <td style="text-align:left"></td>                            
    <td style="text-align:left">Central Oxygen</td> 
    <td> <?php if($screning['central_oxygen_Total_Beds'] !='0' && $screning['central_oxygen_Total_Beds'] != 'null' && $screning['central_oxygen_Total_Beds'] != ''){ echo $screning['central_oxygen_Total_Beds']; }else{ if($screning['central_oxygen_Total_Beds'] !='0' && $screning['central_oxygen_Total_Beds'] != 'null' && $screning['central_oxygen_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['central_oxygen_Occupied'] !='0' && $screning['central_oxygen_Occupied'] != 'null' && $screning['central_oxygen_Occupied'] != ''){ echo $screning['central_oxygen_Occupied']; }else{ if($screning['central_oxygen_Total_Beds'] !='0' && $screning['central_oxygen_Total_Beds'] != 'null' && $screning['central_oxygen_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td>  
    <td> <?php if($screning['central_oxygen_Vacant'] !='0' && $screning['central_oxygen_Vacant'] != 'null' && $screning['central_oxygen_Vacant'] != ''){ echo $screning['central_oxygen_Vacant']; }else{ if($screning['central_oxygen_Total_Beds'] !='0' && $screning['central_oxygen_Total_Beds'] != 'null' && $screning['central_oxygen_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['central_oxygen_Remarks'] !='0' && $screning['central_oxygen_Remarks'] != 'null' && $screning['central_oxygen_Remarks'] != '' ){ echo $screning['	central_oxygen_Remarks']; }else{ echo 'NA'; } ?> </td> 
</tr>
<tr>
    <td style="text-align:left">Quarantine Ward </td>                            
    <td style="text-align:left">Suspected COVID</td> 
    <td> <?php if($screning['SspectC19_Total_Beds'] !='0' && $screning['SspectC19_Total_Beds'] != 'null' && $screning['SspectC19_Total_Beds'] != ''){ echo $screning['SspectC19_Total_Beds']; }else{ if($screning['SspectC19_Total_Beds'] !='0' && $screning['SspectC19_Total_Beds'] != 'null' && $screning['SspectC19_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td>  
    <td> <?php if($screning['SspectC19_Occupied'] !='0' && $screning['SspectC19_Occupied'] != 'null' && $screning['SspectC19_Occupied'] != ''){ echo $screning['SspectC19_Occupied']; }else{ if($screning['SspectC19_Total_Beds'] !='0' && $screning['SspectC19_Total_Beds'] != 'null' && $screning['SspectC19_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['SspectC19_Vacant'] !='0' && $screning['SspectC19_Vacant'] != 'null' && $screning['SspectC19_Vacant'] != ''){ echo $screning['SspectC19_Vacant']; }else{ if($screning['SspectC19_Total_Beds'] !='0' && $screning['SspectC19_Total_Beds'] != 'null' && $screning['SspectC19_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td>  
    <td> <?php if($screning['SspectC19_Remarks'] !='0' && $screning['SspectC19_Remarks'] != 'null' && $screning['SspectC19_Remarks'] != ''){ echo $screning['SspectC19_Remarks']; }else{ echo 'NA'; } ?> </td> </tr>
<tr>
    <td style="text-align:left">CCC1 - </td>                            
    <td style="text-align:left">Suspected Symptomatic without Comorbidity</td> 
    <td> <?php if($screning['SspectSymptWoComorbid_Total_Beds'] !='0' && $screning['SspectSymptWoComorbid_Total_Beds'] != 'null' && $screning['SspectSymptWoComorbid_Total_Beds'] != ''){ echo $screning['SspectSymptWoComorbid_Total_Beds']; }else{ if($screning['SspectSymptWoComorbid_Total_Beds'] !='0' && $screning['SspectSymptWoComorbid_Total_Beds'] != 'null' && $screning['SspectSymptWoComorbid_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['SspectSymptWoComorbid_Occupied'] !='0' && $screning['SspectSymptWoComorbid_Occupied'] != 'null' && $screning['SspectSymptWoComorbid_Occupied'] != ''){ echo $screning['SspectSymptWoComorbid_Occupied']; }else{ if($screning['SspectSymptWoComorbid_Total_Beds'] !='0' && $screning['SspectSymptWoComorbid_Total_Beds'] != 'null' && $screning['SspectSymptWoComorbid_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td>  
    <td> <?php if($screning['SspectSymptWoComorbid_Vacant'] !='0' && $screning['SspectSymptWoComorbid_Vacant'] != 'null' && $screning['SspectSymptWoComorbid_Vacant'] != ''){ echo $screning['SspectSymptWoComorbid_Vacant']; }else{ if($screning['SspectSymptWoComorbid_Total_Beds'] !='0' && $screning['SspectSymptWoComorbid_Total_Beds'] != 'null' && $screning['SspectSymptWoComorbid_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['SspectSymptWoComorbid_Remarks'] !='0' && $screning['SspectSymptWoComorbid_Remarks'] != 'null' && $screning['SspectSymptWoComorbid_Remarks'] != ''){ echo $screning['SspectSymptWoComorbid_Remarks']; }else{ echo 'NA'; } ?> </td> </tr>
<tr>
    <td style="text-align:left"></td>                            
    <td>Suspected Asymptomatic without Comorbidity</td> 
    <td> <?php if($screning['SspectASymptWoComorbid_Total_Beds'] !='0' && $screning['SspectASymptWoComorbid_Total_Beds'] != 'null' && $screning['SspectASymptWoComorbid_Total_Beds'] != ''){ echo $screning['SspectASymptWoComorbid_Total_Beds']; }else{ if($screning['SspectASymptWoComorbid_Total_Beds'] !='0' && $screning['SspectASymptWoComorbid_Total_Beds'] != 'null' && $screning['SspectASymptWoComorbid_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td>  
    <td> <?php if($screning['SspectASymptWoComorbid_Occupied'] !='0' && $screning['SspectASymptWoComorbid_Occupied'] != 'null' && $screning['SspectASymptWoComorbid_Occupied'] != ''){ echo $screning['SspectASymptWoComorbid_Occupied']; }else{ if($screning['SspectASymptWoComorbid_Total_Beds'] !='0' && $screning['SspectASymptWoComorbid_Total_Beds'] != 'null' && $screning['SspectASymptWoComorbid_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['SspectASymptWoComorbid_Vacant'] !='0' && $screning['SspectASymptWoComorbid_Vacant'] != 'null' && $screning['SspectASymptWoComorbid_Vacant'] != ''){ echo $screning['SspectASymptWoComorbid_Vacant']; }else{ if($screning['SspectASymptWoComorbid_Total_Beds'] !='0' && $screning['SspectASymptWoComorbid_Total_Beds'] != 'null' && $screning['SspectASymptWoComorbid_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['SspectASymptWoComorbid_Remarks'] !='0' && $screning['SspectASymptWoComorbid_Remarks'] != 'null' && $screning['SspectASymptWoComorbid_Remarks'] != ''){ echo $screning['SspectASymptWoComorbid_Remarks']; }else{ echo 'NA'; } ?> </td> </tr>
<tr>
    <td style="text-align:left">CCC2 - </td>                            
    <td style="text-align:left">Positive Symptomatic without Comorbidity</td> 
    <td> <?php if($screning['PositiveSymptWoComorbid_Total_Beds'] !='0' && $screning['PositiveSymptWoComorbid_Total_Beds'] != 'null' && $screning['PositiveSymptWoComorbid_Total_Beds'] != '' ){ echo $screning['PositiveSymptWoComorbid_Total_Beds']; }else{ if($screning['PositiveSymptWoComorbid_Total_Beds'] !='0' && $screning['PositiveSymptWoComorbid_Total_Beds'] != 'null' && $screning['PositiveSymptWoComorbid_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td>  
    <td> <?php if($screning['PositiveSymptWoComorbid_Occupied'] !='0' && $screning['PositiveSymptWoComorbid_Occupied'] != 'null' && $screning['PositiveSymptWoComorbid_Occupied'] != '' ){ echo $screning['PositiveSymptWoComorbid_Occupied']; }else{ if($screning['PositiveSymptWoComorbid_Total_Beds'] !='0' && $screning['PositiveSymptWoComorbid_Total_Beds'] != 'null' && $screning['PositiveSymptWoComorbid_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td>  
    <td> <?php if($screning['PositiveSymptWoComorbid_Vacant'] !='0' && $screning['PositiveSymptWoComorbid_Vacant'] != 'null' && $screning['PositiveSymptWoComorbid_Vacant'] != '' ){ echo $screning['PositiveSymptWoComorbid_Vacant']; }else{ if($screning['PositiveSymptWoComorbid_Total_Beds'] !='0' && $screning['PositiveSymptWoComorbid_Total_Beds'] != 'null' && $screning['PositiveSymptWoComorbid_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td>  
    <td> <?php if($screning['PositiveSymptWoComorbid_Remarks'] !='0' && $screning['PositiveSymptWoComorbid_Remarks'] != 'null' && $screning['PositiveSymptWoComorbid_Remarks'] != ''){ echo $screning['PositiveSymptWoComorbid_Remarks']; }else{ echo 'NA'; }  ?> </td> </tr>
<tr>
    <td></td>                            
    <td style="text-align:left">Positive Asymptomatic without Comorbidity</td> 
    <td> <?php if($screning['PositiveASymptWoComorbid_Total_Beds'] !='0' && $screning['PositiveASymptWoComorbid_Total_Beds'] != 'null' && $screning['PositiveASymptWoComorbid_Total_Beds'] != ''){ echo $screning['PositiveASymptWoComorbid_Total_Beds']; }else{ if($screning['PositiveASymptWoComorbid_Total_Beds'] !='0' && $screning['PositiveASymptWoComorbid_Total_Beds'] != 'null' && $screning['PositiveASymptWoComorbid_Total_Beds'] != ''){ echo '0'; }else { echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['PositiveASymptWoComorbid_Occupied'] !='0' && $screning['PositiveASymptWoComorbid_Occupied'] != 'null' && $screning['PositiveASymptWoComorbid_Occupied'] != ''){ echo $screning['PositiveASymptWoComorbid_Occupied']; }else{ if($screning['PositiveASymptWoComorbid_Total_Beds'] !='0' && $screning['PositiveASymptWoComorbid_Total_Beds'] != 'null' && $screning['PositiveASymptWoComorbid_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA'; } } ?> </td> 
    <td> <?php if($screning['PositiveASymptWoComorbid_Vacant'] !='0' && $screning['PositiveASymptWoComorbid_Vacant'] != 'null' && $screning['PositiveASymptWoComorbid_Vacant'] != ''){ echo $screning['PositiveASymptWoComorbid_Vacant']; }else{ if($screning['PositiveASymptWoComorbid_Total_Beds'] !='0' && $screning['PositiveASymptWoComorbid_Total_Beds'] != 'null' && $screning['PositiveASymptWoComorbid_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['PositiveASymptWoComorbid_Remarks'] !='0' && $screning['PositiveASymptWoComorbid_Remarks'] != 'null' && $screning['PositiveASymptWoComorbid_Remarks'] != ''){ echo $screning['PositiveASymptWoComorbid_Remarks']; }else{ echo 'NA'; } ?> </td> </tr>
<tr>
    <td style="text-align:left">DCHC - </td>                            
    <td style="text-align:left">Asymptomatic COVID suspected with Comorbidity stable</td> 
    <td> <?php if($screning['ASymptC19SspectwithComorbidStable_Total_Beds'] !='0' && $screning['ASymptC19SspectwithComorbidStable_Total_Beds'] != 'null' && $screning['ASymptC19SspectwithComorbidStable_Total_Beds'] != ''){ echo $screning['ASymptC19SspectwithComorbidStable_Total_Beds']; }else{ if($screning['ASymptC19SspectwithComorbidStable_Total_Beds'] !='0' && $screning['ASymptC19SspectwithComorbidStable_Total_Beds'] != 'null' && $screning['ASymptC19SspectwithComorbidStable_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['ASymptC19SspectwithComorbidStable_Occupied'] !='0' && $screning['ASymptC19SspectwithComorbidStable_Occupied'] != 'null' && $screning['ASymptC19SspectwithComorbidStable_Occupied'] != ''){ echo $screning['ASymptC19SspectwithComorbidStable_Occupied']; }else{ if($screning['ASymptC19SspectwithComorbidStable_Total_Beds'] !='0' && $screning['ASymptC19SspectwithComorbidStable_Total_Beds'] != 'null' && $screning['ASymptC19SspectwithComorbidStable_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['ASymptC19SspectwithComorbidStable_Vacant'] !='0' && $screning['ASymptC19SspectwithComorbidStable_Vacant'] != 'null' && $screning['ASymptC19SspectwithComorbidStable_Vacant'] != '' ){ echo $screning['ASymptC19SspectwithComorbidStable_Vacant']; }else{ if($screning['ASymptC19SspectwithComorbidStable_Total_Beds'] !='0' && $screning['ASymptC19SspectwithComorbidStable_Total_Beds'] != 'null' && $screning['ASymptC19SspectwithComorbidStable_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td>  
    <td> <?php if($screning['ASymptC19SspectwithComorbidStable_Remarks'] !='0' && $screning['ASymptC19SspectwithComorbidStable_Remarks'] != 'null' && $screning['ASymptC19SspectwithComorbidStable_Remarks'] != ''){ echo $screning['ASymptC19SspectwithComorbidStable_Remarks']; }else{ echo 'NA'; } ?> </td> </tr>
<tr>
    <td></td>                            
    <td style="text-align:left">Symptomatic COVID suspected with Comorbidity stable</td> 
    <td> <?php if($screning['SymptC19SspectwithComorbidStable_Total_Beds'] !='0' && $screning['SymptC19SspectwithComorbidStable_Total_Beds'] != 'null' && $screning['SymptC19SspectwithComorbidStable_Total_Beds'] != ''){ echo $screning['SymptC19SspectwithComorbidStable_Total_Beds']; }else{ if($screning['SymptC19SspectwithComorbidStable_Total_Beds'] !='0' && $screning['SymptC19SspectwithComorbidStable_Total_Beds'] != 'null' && $screning['SymptC19SspectwithComorbidStable_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td>  
    <td> <?php if($screning['SymptC19SspectwithComorbidStable_Occupied'] !='0' && $screning['SymptC19SspectwithComorbidStable_Occupied'] != 'null' && $screning['SymptC19SspectwithComorbidStable_Occupied'] != ''){ echo $screning['SymptC19SspectwithComorbidStable_Occupied']; }else{ if($screning['SymptC19SspectwithComorbidStable_Total_Beds'] !='0' && $screning['SymptC19SspectwithComorbidStable_Total_Beds'] != 'null' && $screning['SymptC19SspectwithComorbidStable_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['SymptC19SspectwithComorbidStable_Vacant'] !='0' && $screning['SymptC19SspectwithComorbidStable_Vacant'] != 'null' && $screning['SymptC19SspectwithComorbidStable_Vacant'] != '' ){ echo $screning['SymptC19SspectwithComorbidStable_Vacant']; }else{ if($screning['SymptC19SspectwithComorbidStable_Total_Beds'] !='0' && $screning['SymptC19SspectwithComorbidStable_Total_Beds'] != 'null' && $screning['SymptC19SspectwithComorbidStable_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['SymptC19SspectwithComorbidStable_Remarks'] !='0' && $screning['SymptC19SspectwithComorbidStable_Remarks'] != 'null' && $screning['SymptC19SspectwithComorbidStable_Remarks'] != ''){ echo $screning['SymptC19SspectwithComorbidStable_Remarks']; }else{ echo 'NA'; } ?> </td> </tr>
<tr>
    <td></td>                            
    <td style="text-align:left">Asymptomatic positive with  Comorbidity stable</td> 
    <td> <?php if($screning['ASymptPositivewithComorbidStable_Total_Beds'] !='0' && $screning['ASymptPositivewithComorbidStable_Total_Beds'] != 'null' && $screning['ASymptPositivewithComorbidStable_Total_Beds'] != '' ){ echo $screning['ASymptPositivewithComorbidStable_Total_Beds']; }else{ if($screning['ASymptPositivewithComorbidStable_Total_Beds'] !='0' && $screning['ASymptPositivewithComorbidStable_Total_Beds'] != 'null' && $screning['ASymptPositivewithComorbidStable_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['ASymptPositivewithComorbidStable_Occupied'] !='0' && $screning['ASymptPositivewithComorbidStable_Occupied'] != 'null' && $screning['ASymptPositivewithComorbidStable_Occupied'] != ''){ echo $screning['ASymptPositivewithComorbidStable_Occupied']; }else{ if($screning['ASymptPositivewithComorbidStable_Total_Beds'] !='0' && $screning['ASymptPositivewithComorbidStable_Total_Beds'] != 'null' && $screning['ASymptPositivewithComorbidStable_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['ASymptPositivewithComorbidStable_Vacant'] !='0' && $screning['ASymptPositivewithComorbidStable_Vacant'] != 'null' && $screning['ASymptPositivewithComorbidStable_Vacant'] != ''){ echo $screning['ASymptPositivewithComorbidStable_Vacant']; }else{ if($screning['ASymptPositivewithComorbidStable_Total_Beds'] !='0' && $screning['ASymptPositivewithComorbidStable_Total_Beds'] != 'null' && $screning['ASymptPositivewithComorbidStable_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['ASymptPositivewithComorbidStable_Remarks'] !='0' && $screning['ASymptPositivewithComorbidStable_Remarks'] != 'null' && $screning['ASymptPositivewithComorbidStable_Remarks'] != ''){ echo $screning['ASymptPositivewithComorbidStable_Remarks']; }else{ echo 'NA'; } ?> </td> </tr>
<tr>
    <td></td>                            
    <td style="text-align:left">Symptomatic positive with  Comorbidity stable   </td> 
    <td> <?php if($screning['SymptPositivewithComorbidStable_Total_Beds'] !='0' && $screning['SymptPositivewithComorbidStable_Total_Beds'] != 'null' && $screning['SymptPositivewithComorbidStable_Total_Beds'] != ''){ echo $screning['SymptPositivewithComorbidStable_Total_Beds']; }else{ if($screning['SymptPositivewithComorbidStable_Total_Beds'] !='0' && $screning['SymptPositivewithComorbidStable_Total_Beds'] != 'null' && $screning['SymptPositivewithComorbidStable_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['SymptPositivewithComorbidStable_Occupied'] !='0' && $screning['SymptPositivewithComorbidStable_Occupied'] != 'null' && $screning['SymptPositivewithComorbidStable_Occupied'] != ''){ echo $screning['SymptPositivewithComorbidStable_Occupied']; }else{ if($screning['SymptPositivewithComorbidStable_Total_Beds'] !='0' && $screning['SymptPositivewithComorbidStable_Total_Beds'] != 'null' && $screning['SymptPositivewithComorbidStable_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['SymptPositivewithComorbidStable_Vacant'] !='0' && $screning['SymptPositivewithComorbidStable_Vacant'] != 'null' && $screning['SymptPositivewithComorbidStable_Vacant'] != ''){ echo $screning['SymptPositivewithComorbidStable_Vacant']; }else{ if($screning['SymptPositivewithComorbidStable_Total_Beds'] !='0' && $screning['SymptPositivewithComorbidStable_Total_Beds'] != 'null' && $screning['SymptPositivewithComorbidStable_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td>  
    <td> <?php if($screning['SymptPositivewithComorbidStable_Remarks'] !='0' && $screning['SymptPositivewithComorbidStable_Remarks'] != 'null' && $screning['SymptPositivewithComorbidStable_Remarks'] != ''){ echo $screning['SymptPositivewithComorbidStable_Remarks']; }else{ echo 'NA'; } ?> </td> </tr>
<tr>
    <td style="text-align:left">DCH -  </td>                            
    <td style="text-align:left">Asymptomatic COVID suspected with Comorbidity Critical</td> 
    <td> <?php if($screning['ASymptC19SspectwithComorbidCritical_Total_Beds'] !='0' && $screning['ASymptC19SspectwithComorbidCritical_Total_Beds'] != 'null' && $screning['ASymptC19SspectwithComorbidCritical_Total_Beds'] != ''){ echo $screning['ASymptC19SspectwithComorbidCritical_Total_Beds']; }else{ if($screning['ASymptC19SspectwithComorbidCritical_Total_Beds'] !='0' && $screning['ASymptC19SspectwithComorbidCritical_Total_Beds'] != 'null' && $screning['ASymptC19SspectwithComorbidCritical_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['ASymptC19SspectwithComorbidCritical_Occupied'] !='0' && $screning['ASymptC19SspectwithComorbidCritical_Occupied'] != 'null' && $screning['ASymptC19SspectwithComorbidCritical_Occupied'] != ''){ echo $screning['ASymptC19SspectwithComorbidCritical_Occupied']; }else{ if($screning['ASymptC19SspectwithComorbidCritical_Total_Beds'] !='0' && $screning['ASymptC19SspectwithComorbidCritical_Total_Beds'] != 'null' && $screning['ASymptC19SspectwithComorbidCritical_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['ASymptC19SspectwithComorbidCritical_Vacant'] !='0' && $screning['ASymptC19SspectwithComorbidCritical_Vacant'] != 'null' && $screning['ASymptC19SspectwithComorbidCritical_Vacant'] != '' ){ echo $screning['ASymptC19SspectwithComorbidCritical_Vacant']; }else{ if($screning['ASymptC19SspectwithComorbidCritical_Total_Beds'] !='0' && $screning['ASymptC19SspectwithComorbidCritical_Total_Beds'] != 'null' && $screning['ASymptC19SspectwithComorbidCritical_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td>  
    <td> <?php if($screning['ASymptC19SspectwithComorbidCritical_Remarks'] !='0' && $screning['ASymptC19SspectwithComorbidCritical_Remarks'] != 'null' && $screning['ASymptC19SspectwithComorbidCritical_Remarks'] != ''){ echo $screning['ASymptC19SspectwithComorbidCritical_Remarks']; }else{ echo 'NA'; } ?> </td> </tr>
<tr>
    <td></td>                            
    <td style="text-align:left">Symptomatic COVID suspected with Comorbidity Critical</td> 
    <td> <?php if($screning['SymptC19SspectwithComorbidCritical_Total_Beds'] !='0' && $screning['SymptC19SspectwithComorbidCritical_Total_Beds'] != 'null' && $screning['SymptC19SspectwithComorbidCritical_Total_Beds'] != ''){ echo $screning['SymptC19SspectwithComorbidCritical_Total_Beds']; }else{ if($screning['SymptC19SspectwithComorbidCritical_Total_Beds'] !='0' && $screning['SymptC19SspectwithComorbidCritical_Total_Beds'] != 'null' && $screning['SymptC19SspectwithComorbidCritical_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['SymptC19SspectwithComorbidCritical_Occupied'] !='0' && $screning['SymptC19SspectwithComorbidCritical_Occupied'] != 'null' && $screning['SymptC19SspectwithComorbidCritical_Occupied'] != ''){ echo $screning['SymptC19SspectwithComorbidCritical_Occupied']; }else{ if($screning['SymptC19SspectwithComorbidCritical_Total_Beds'] !='0' && $screning['SymptC19SspectwithComorbidCritical_Total_Beds'] != 'null' && $screning['SymptC19SspectwithComorbidCritical_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td>  
    <td> <?php if($screning['SymptC19SspectwithComorbidCritical_Vacant'] !='0' && $screning['SymptC19SspectwithComorbidCritical_Vacant'] != 'null' && $screning['SymptC19SspectwithComorbidCritical_Vacant'] != ''){ echo $screning['SymptC19SspectwithComorbidCritical_Vacant']; }else{ if($screning['SymptC19SspectwithComorbidCritical_Total_Beds'] !='0' && $screning['SymptC19SspectwithComorbidCritical_Total_Beds'] != 'null' && $screning['SymptC19SspectwithComorbidCritical_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['SymptC19SspectwithComorbidCritical_Remarks'] !='0' && $screning['SymptC19SspectwithComorbidCritical_Remarks'] != 'null' && $screning['SymptC19SspectwithComorbidCritical_Remarks'] != ''){ echo $screning['SymptC19SspectwithComorbidCritical_Remarks']; }else{ echo 'NA'; }  ?> </td> </tr>
<tr>
    <td></td>                            
    <td style="text-align:left">Asymptomatic COVID Positive with Comorbidity Critical</td> 
    <td> <?php if($screning['ASymptC19PositivewithComorbidCritical_Total_Beds'] !='0' && $screning['ASymptC19PositivewithComorbidCritical_Total_Beds'] != 'null' && $screning['ASymptC19PositivewithComorbidCritical_Total_Beds'] != ''){ echo $screning['ASymptC19PositivewithComorbidCritical_Total_Beds']; }else{ if($screning['ASymptC19PositivewithComorbidCritical_Total_Beds'] !='0' && $screning['ASymptC19PositivewithComorbidCritical_Total_Beds'] != 'null' && $screning['ASymptC19PositivewithComorbidCritical_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['ASymptC19PositivewithComorbidCritical_Occupied'] !='0' && $screning['ASymptC19PositivewithComorbidCritical_Occupied'] != 'null' && $screning['ASymptC19PositivewithComorbidCritical_Occupied'] != ''){ echo $screning['ASymptC19PositivewithComorbidCritical_Occupied']; }else{ if($screning['ASymptC19PositivewithComorbidCritical_Total_Beds'] !='0' && $screning['ASymptC19PositivewithComorbidCritical_Total_Beds'] != 'null' && $screning['ASymptC19PositivewithComorbidCritical_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['ASymptC19PositivewithComorbidCritical_Vacant'] !='0' && $screning['ASymptC19PositivewithComorbidCritical_Vacant'] != 'null' && $screning['ASymptC19PositivewithComorbidCritical_Vacant'] != ''){ echo $screning['ASymptC19PositivewithComorbidCritical_Vacant']; }else{ if($screning['ASymptC19PositivewithComorbidCritical_Total_Beds'] !='0' && $screning['ASymptC19PositivewithComorbidCritical_Total_Beds'] != 'null' && $screning['ASymptC19PositivewithComorbidCritical_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td>  
    <td> <?php if($screning['ASymptC19PositivewithComorbidCritical_Remarks'] !='0' && $screning['ASymptC19PositivewithComorbidCritical_Remarks'] != 'null' && $screning['ASymptC19PositivewithComorbidCritical_Remarks'] != ''){ echo $screning['ASymptC19PositivewithComorbidCritical_Remarks']; }else{ echo 'NA'; } ?> </td> </tr>
<tr>
    <td></td>                            
    <td style="text-align:left">Symptomatic COVID Positive with Comorbidity Critical</td> 
    <td> <?php if($screning['SymptC19PositivewithComorbidCritical_Total_Beds'] !='0' && $screning['SymptC19PositivewithComorbidCritical_Total_Beds'] != 'null' && $screning['SymptC19PositivewithComorbidCritical_Total_Beds'] != ''){ echo $screning['SymptC19PositivewithComorbidCritical_Total_Beds']; }else{ if($screning['SymptC19PositivewithComorbidCritical_Total_Beds'] !='0' && $screning['SymptC19PositivewithComorbidCritical_Total_Beds'] != 'null' && $screning['SymptC19PositivewithComorbidCritical_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td>  
    <td> <?php if($screning['SymptC19PositivewithComorbidCritical_Occupied'] !='0' && $screning['SymptC19PositivewithComorbidCritical_Occupied'] != 'null' && $screning['SymptC19PositivewithComorbidCritical_Occupied'] != ''){ echo $screning['SymptC19PositivewithComorbidCritical_Occupied']; }else{ if($screning['SymptC19PositivewithComorbidCritical_Total_Beds'] !='0' && $screning['SymptC19PositivewithComorbidCritical_Total_Beds'] != 'null' && $screning['SymptC19PositivewithComorbidCritical_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['SymptC19PositivewithComorbidCritical_Vacant'] !='0' && $screning['SymptC19PositivewithComorbidCritical_Vacant'] != 'null' && $screning['SymptC19PositivewithComorbidCritical_Vacant'] != ''){ echo $screning['SymptC19PositivewithComorbidCritical_Vacant']; }else{ if($screning['SymptC19PositivewithComorbidCritical_Total_Beds'] !='0' && $screning['SymptC19PositivewithComorbidCritical_Total_Beds'] != 'null' && $screning['SymptC19PositivewithComorbidCritical_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['SymptC19PositivewithComorbidCritical_Remarks'] !='0' && $screning['SymptC19PositivewithComorbidCritical_Remarks'] != 'null' && $screning['SymptC19PositivewithComorbidCritical_Remarks'] != ''){ echo $screning['SymptC19PositivewithComorbidCritical_Remarks']; }else{ echo 'NA'; } ?> </td> </tr>
<tr>
    <td style="text-align:left">Mortury Beds</td>                            
    <td></td> 
    <td> <?php if($screning['MorturyBeds_Total_Beds'] !='0' && $screning['MorturyBeds_Total_Beds'] != 'null' && $screning['MorturyBeds_Total_Beds'] != ''){ echo $screning['MorturyBeds_Total_Beds']; }else{ if($screning['MorturyBeds_Total_Beds'] !='0' && $screning['MorturyBeds_Total_Beds'] != 'null' && $screning['MorturyBeds_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['MorturyBeds_Occupied'] !='0' && $screning['MorturyBeds_Occupied'] != 'null' && $screning['MorturyBeds_Occupied'] != ''){ echo $screning['MorturyBeds_Occupied']; }else{ if($screning['MorturyBeds_Total_Beds'] !='0' && $screning['MorturyBeds_Total_Beds'] != 'null' && $screning['MorturyBeds_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td>  
    <td> <?php if($screning['MorturyBeds_Vacant'] !='0' && $screning['MorturyBeds_Vacant'] != 'null' && $screning['MorturyBeds_Vacant'] != ''){ echo $screning['MorturyBeds_Vacant']; }else{ if($screning['MorturyBeds_Total_Beds'] !='0' && $screning['MorturyBeds_Total_Beds'] != 'null' && $screning['MorturyBeds_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['MorturyBeds_Remarks'] !='0' && $screning['MorturyBeds_Remarks'] != 'null' && $screning['MorturyBeds_Remarks'] != ''){ echo $screning['MorturyBeds_Remarks']; }else{ echo 'NA'; } ?> </td> </tr>
<tr>
    <td style="text-align:left">Other</td>                            
    <td></td> 
    <td> <?php if($screning['Others_Total_Beds'] !='0' && $screning['Others_Total_Beds'] != 'null' && $screning['Others_Total_Beds'] != ''){ echo $screning['Others_Total_Beds']; }else{ if($screning['Others_Total_Beds'] !='0' && $screning['Others_Total_Beds'] != 'null' && $screning['Others_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['Others_Occupied'] !='0' && $screning['Others_Occupied'] != 'null' && $screning['Others_Occupied'] != ''){ echo $screning['Others_Occupied']; }else{ if($screning['Others_Total_Beds'] !='0' && $screning['Others_Total_Beds'] != 'null' && $screning['Others_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['Others_Vacant'] !='0' && $screning['Others_Vacant'] != 'null' && $screning['Others_Vacant'] != ''){ echo $screning['Others_Vacant']; }else{ if($screning['Others_Total_Beds'] !='0' && $screning['Others_Total_Beds'] != 'null' && $screning['Others_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
    <td> <?php if($screning['Others_Remarks'] !='0' && $screning['Others_Remarks'] != 'null' && $screning['Others_Remarks'] != ''){ echo $screning['Others_Remarks']; }else{ echo 'NA'; } ?> </td> </tr>
</table>
</div> <br>
<div class="row">
<table class="table table-bordered NHM_Dashboard">
                <tr>                
                <th>Name</th>
    <th>Type</th>
    <th>Total Beds</th>
    <th>Occupied Beds</th>
    <th>Vacant Beds</th>
    <th >Remarks</th>
                       
                    </tr>
                    <tr>
                        <td style="text-align:left;font-weight:bold">Facility Type</td>                            
                        <td style="text-align:left;font-weight:bold">Non-COVID-19</td> 
                        <td style="font-weight:bold"> <?php if($screning['NonC19_Total_Beds'] !='0' && $screning['NonC19_Total_Beds'] != 'null' && $screning['NonC19_Total_Beds'] != ''){ echo $screning['NonC19_Total_Beds']; }else{ if($screning['NonC19_Total_Beds'] !='0' && $screning['NonC19_Total_Beds'] != 'null' && $screning['NonC19_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
                        <td style="font-weight:bold"> <?php if($screning['NonC19_Occupied'] !='0' && $screning['NonC19_Occupied'] != 'null' && $screning['NonC19_Occupied'] != ''){ echo $screning['NonC19_Occupied']; }else{ if($screning['NonC19_Total_Beds'] !='0' && $screning['NonC19_Total_Beds'] != 'null' && $screning['NonC19_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
                        <td style="font-weight:bold"> <?php if($screning['NonC19_Vacant'] !='0' && $screning['NonC19_Vacant'] != 'null' && $screning['NonC19_Vacant'] != ''){ echo $screning['NonC19_Vacant']; }else{ if($screning['NonC19_Total_Beds'] !='0' && $screning['NonC19_Total_Beds'] != 'null' && $screning['NonC19_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
                        <td style="font-weight:bold"> <?php if($screning['NonC19_Remarks'] !='0' && $screning['NonC19_Remarks'] != 'null' && $screning['NonC19_Remarks'] != ''){ echo $screning['NonC19_Remarks']; }else{ echo 'NA'; } ?> </td>
                    </tr>
                    <tr>
                        <td style="text-align:left">ICU beds without ventilator</td>                            
                        <td></td> 
                        <td> <?php if($screning['NonC19ICUWoVenti_Total_Beds'] !='0' && $screning['NonC19ICUWoVenti_Total_Beds'] != 'null' && $screning['NonC19ICUWoVenti_Total_Beds'] != ''){ echo $screning['NonC19ICUWoVenti_Total_Beds'];  }else{ if($screning['NonC19ICUWoVenti_Total_Beds'] !='0' && $screning['NonC19ICUWoVenti_Total_Beds'] != 'null' && $screning['NonC19ICUWoVenti_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
                        <td> <?php if($screning['NonC19ICUWoVenti_Occupied'] !='0' && $screning['NonC19ICUWoVenti_Occupied'] != 'null' && $screning['NonC19ICUWoVenti_Occupied'] != ''){ echo $screning['NonC19ICUWoVenti_Occupied'];  }else{ if($screning['NonC19ICUWoVenti_Total_Beds'] !='0' && $screning['NonC19ICUWoVenti_Total_Beds'] != 'null' && $screning['NonC19ICUWoVenti_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
                        <td> <?php if($screning['NonC19ICUWoVenti_Vacant'] !='0' && $screning['NonC19ICUWoVenti_Vacant'] != 'null' && $screning['NonC19ICUWoVenti_Vacant'] != ''){ echo $screning['NonC19ICUWoVenti_Vacant'];  }else{ if($screning['NonC19ICUWoVenti_Total_Beds'] !='0' && $screning['NonC19ICUWoVenti_Total_Beds'] != 'null' && $screning['NonC19ICUWoVenti_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
                        <td> <?php if($screning['NonC19ICUWoVenti_Remarks'] !='0' && $screning['NonC19ICUWoVenti_Remarks'] != 'null' && $screning['NonC19ICUWoVenti_Remarks'] != ''){ echo $screning['NonC19ICUWoVenti_Remarks'];  }else{ echo 'NA'; } ?> </td> 
                    </tr>
                    <tr>
                        <td style="text-align:left">ICU bedswith ventilator</td>                            
                        <td></td> 
                        <td> <?php if($screning['NonC19ICUwithVenti_Total_Beds'] !='0' && $screning['NonC19ICUwithVenti_Total_Beds'] != 'null' && $screning['NonC19ICUwithVenti_Total_Beds'] != ''){ echo $screning['NonC19ICUwithVenti_Total_Beds'];  }else{ if($screning['NonC19ICUwithVenti_Total_Beds'] !='0' && $screning['NonC19ICUwithVenti_Total_Beds'] != 'null' && $screning['NonC19ICUwithVenti_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
                        <td> <?php if($screning['NonC19ICUwithVenti_Occupied'] !='0' && $screning['NonC19ICUwithVenti_Occupied'] != 'null' && $screning['NonC19ICUwithVenti_Occupied'] != ''){ echo $screning['NonC19ICUwithVenti_Occupied'];  }else{ if($screning['NonC19ICUwithVenti_Total_Beds'] !='0' && $screning['NonC19ICUwithVenti_Total_Beds'] != 'null' && $screning['NonC19ICUwithVenti_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
                        <td> <?php if($screning['NonC19ICUwithVenti_Vacant'] !='0' && $screning['NonC19ICUwithVenti_Vacant'] != 'null' && $screning['NonC19ICUwithVenti_Vacant'] != ''){ echo $screning['NonC19ICUwithVenti_Vacant'];  }else{ if($screning['NonC19ICUwithVenti_Total_Beds'] !='0' && $screning['NonC19ICUwithVenti_Total_Beds'] != 'null' && $screning['NonC19ICUwithVenti_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
                        <td> <?php if($screning['NonC19ICUwithVenti_Remarks'] !='0' && $screning['NonC19ICUwithVenti_Remarks'] != 'null' && $screning['NonC19ICUwithVenti_Remarks'] != ''){ echo $screning['NonC19ICUwithVenti_Remarks'];  }else{ echo 'NA'; } ?> </td> 
                    </tr>
                    <tr>
                        <td style="text-align:left">Dialysis bed</td>                            
                        <td></td> 
                        <td> <?php if($screning['NonC19ICUwithdialysisBed_Total_Beds'] !='0' && $screning['NonC19ICUwithdialysisBed_Total_Beds'] != 'null' && $screning['NonC19ICUwithdialysisBed_Total_Beds'] != ''){ echo $screning['NonC19ICUwithdialysisBed_Total_Beds'];  }else{ if($screning['NonC19ICUwithdialysisBed_Total_Beds'] !='0' && $screning['NonC19ICUwithdialysisBed_Total_Beds'] != 'null' && $screning['NonC19ICUwithdialysisBed_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
                        <td> <?php if($screning['NonC19ICUwithdialysisBed_Occupied'] !='0' && $screning['NonC19ICUwithdialysisBed_Occupied'] != 'null' && $screning['NonC19ICUwithdialysisBed_Occupied'] != ''){ echo $screning['NonC19ICUwithdialysisBed_Occupied'];  }else{ if($screning['NonC19ICUwithdialysisBed_Total_Beds'] !='0' && $screning['NonC19ICUwithdialysisBed_Total_Beds'] != 'null' && $screning['NonC19ICUwithdialysisBed_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
                        <td> <?php if($screning['NonC19ICUwithdialysisBed_Vacant'] !='0' && $screning['NonC19ICUwithdialysisBed_Vacant'] != 'null' && $screning['NonC19ICUwithdialysisBed_Vacant'] != ''){ echo $screning['NonC19ICUwithdialysisBed_Vacant'];  }else{ if($screning['NonC19ICUwithdialysisBed_Total_Beds'] !='0' && $screning['NonC19ICUwithdialysisBed_Total_Beds'] != 'null' && $screning['NonC19ICUwithdialysisBed_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
                        <td> <?php if($screning['NonC19ICUwithdialysisBed_Remarks'] !='0' && $screning['NonC19ICUwithdialysisBed_Remarks'] != 'null' && $screning['NonC19ICUwithdialysisBed_Remarks'] != ''){ echo $screning['NonC19ICUwithdialysisBed_Remarks'];  }else{ echo 'NA'; } ?> </td> 
                    </tr>
                     <tr>
                        <td style="text-align:left">Ward</td>                            
                        <td></td> 
                        <td> <?php if($screning['NonC19Ward_Total_Beds'] !='0' && $screning['NonC19Ward_Total_Beds'] != 'null' && $screning['NonC19Ward_Total_Beds'] != ''){ echo $screning['NonC19Ward_Total_Beds'];  }else{ if($screning['NonC19Ward_Total_Beds'] !='0' && $screning['NonC19Ward_Total_Beds'] != 'null' && $screning['NonC19Ward_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
                        <td> <?php if($screning['NonC19Ward_Occupied'] !='0' && $screning['NonC19Ward_Occupied'] != 'null' && $screning['NonC19Ward_Occupied'] != ''){ echo $screning['NonC19Ward_Occupied'];  }else{ if($screning['NonC19Ward_Total_Beds'] !='0' && $screning['NonC19Ward_Total_Beds'] != 'null' && $screning['NonC19Ward_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
                        <td> <?php if($screning['NonC19Ward_Vacant'] !='0' && $screning['NonC19Ward_Vacant'] != 'null' && $screning['NonC19Ward_Vacant'] != ''){ echo $screning['NonC19Ward_Vacant'];  }else{ if($screning['NonC19Ward_Total_Beds'] !='0' && $screning['NonC19Ward_Total_Beds'] != 'null' && $screning['NonC19Ward_Total_Beds'] != ''){ echo '0'; }else{ echo 'DNA';} } ?> </td> 
                        <td> <?php if($screning['C19_OccuNonC19Ward_Remarks'] !='0' && $screning['C19_OccuNonC19Ward_Remarks'] != 'null' && $screning['C19_OccuNonC19Ward_Remarks'] != ''){ echo $screning['C19_OccuNonC19Ward_Remarks'];  }else{ echo 'NA'; } ?> </td> 
                        </tr>
                </table>
</div><br><br> <br> <br> <br>  <?php
} 
else{ ?>
<div class="row">
 <label style="padding-top:10px;text-align: center;font-size:20px;color:blue;">Data not found for Hospital FOR COVID19 & NON COVID19</label>
</div> 
<?php }
?>
