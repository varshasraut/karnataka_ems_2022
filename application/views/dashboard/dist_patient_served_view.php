<?php $CI = EMS_Controller::get_instance();?>


<div class="container-fluid" style="margin-top:10px; margin-bottom:55px;">
  <div class="row text-center">
  <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">
      <label style="padding-top:20px;text-align: center;font-size:20px;color:#black;padding-bottom: 20px;"><h3>District-wise Emergency Patients</h3></label>
  </div> 
</div>
<div class="row">
  <div class="col-md-12 paddindOverRide">
    <table class="table table-bordered NHM_Dashboard nhm_table"  >
      <tr style=" color: #f8f9fa">                                      
        <th style="width:20%; ">State</th>
        <th colspan="3">Emergency Patient Served</th>
      </tr>
      <tr style=" color: #f8f9fa"> 
        <th rowspan="1" class="justify-content-center" style="width:20%;">State Name
        </th>                                     
        <th style="width:25%;">Till Date</th>
        <th style="width:25%;" >This Month</th>
        <th style="width:25%;" >Today</th>
      </tr>
      <tr>
      <td><button type="button"   class="btn btn-primary mt-3" data-toggle="collapse" data-target="#demo" style="color: #666; background-color: transparent; border-color: transparent;">Maharashtra</button>
</td>
        <td style="width:25%;"><?php echo emergency_patients('tillDate', "both") ?></td>
        <td style="width:25%;"><?php echo emergency_patients('thismonth', "both") ?></td>
        <td style="width:25%;"><?php echo emergency_patients('today', "both") ?></td>
      </tr>
    </table>
  </div>
</div>

<div id="demo" class="collapse">
  <div class="row">
    <div class="col-md-12 paddindOverRide">

    <table class="table table-bordered NHM_Dashboard nhm_table"  >
    
      <tr style=" color: #f8f9fa">                                      
      <th style="width:20%;">Division</th>
        <th colspan="3">Emergency Patient Served</th>
        

      </tr >
      <tr style=" color: #f8f9fa">                                      
      <th style="width:20%;">Division Name</th>
        <th style="width:25%;">Till Date</th>
        <th style="width:25%;">This Month</th>
        <th style="width:25%;">Today</th>

      </tr>
     </table>
     
      <?php// foreach ($data['div_names'] as $result): ?>
        <table class="table table-bordered NHM_Dashboard"  >
      <tr>
          <th style="width:20%;" class="justify-content-center">
            <button aria-expanded="false" id="11"type="button" class="btn btn-primary" data-toggle="collapse" data-target="#1" style="color: #666; background-color: transparent; border-color: transparent;"><?php echo "Jammu Division"; ?></button>
          </th> 
          <td style="width:25%;"><?php echo emergency_patients_divisionwise_jammu('tillDate', "both") ?></td>
          <td style="width:25%;"><?php echo emergency_patients_divisionwise_jammu('thismonth', "both") ?></td>
          <td style="width:25%;"><?php echo emergency_patients_divisionwise_jammu('today', "both") ?></td>
      </tr>
      </table>
      <!--// start code for jammu div district loop//-->
<div id="1" class="collapse" data-parent="#11">
    <div class="row">
      <div class="col-md-12 paddindOverRide">

          <table class="table table-bordered NHM_Dashboard nhm_table"  >
          <tr style=" color: #f8f9fa">                                      
      <th style="width:20%;">Districts</th>
        <th colspan="3">Emergency Patient Served</th>
        

      </tr>
      <tr style=" color: #f8f9fa">                                      
      <th style="width:20%;">District Name</th>
        <th style="width:25%;">Till Date</th>
        <th style="width:25%;">This Month</th>
        <th style="width:25%;">Today</th>

      </tr>
            </table>
            <?php foreach ($data['district_jammu'] as $res): ?>
              <table class="table table-bordered NHM_Dashboard"  >
            <tr>
              <th  class="justify-content-center" style="width:20%;">
                <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#<?php echo $res->dst_code.$res->dst_name ?>" style="color: #666; background-color: transparent; border-color: transparent;"><?php echo $res->dst_name ?></button>
              </th> 
              
              <td style="width:25%;"><?php echo districtwise_emergency_patients($res->dst_code,'tillDate', "both") ?></td>
              <td style="width:25%;"><?php echo districtwise_emergency_patients($res->dst_code,'thismonth', "both") ?></td>
              <td style="width:25%;"><?php echo districtwise_emergency_patients($res->dst_code,'today', "both") ?></td>
          </tr> 
          
          </table>
          <div id="<?php echo $res->dst_code.$res->dst_name; ?>" class="collapse" >
          <table class="table table-bordered NHM_Dashboard nhm_table"  >
          <tr style=" color: #f8f9fa">                                      
      <th style="width:20%;">Ambulances</th>
        <th colspan="3">Emergency Patient Served</th>
        

      </tr>
      <tr style=" color: #f8f9fa">                                      
      <th style="width:20%;">Ambulance No</th>
        <th style="width:25%;">Till Date</th>
        <th style="width:25%;">This Month</th>
        <th style="width:25%;">Today</th>

      </tr>
            </table>
           <?php  $i=1; ?>
         <?php  foreach ($data['amb_names'] as $amb): ?>
         
         
       <table class="table table-bordered NHM_Dashboard"  >

            <tr >
              <th  class="justify-content-center"style="width:20%;">
                <button type="button"  class="btn btn-primary" style="color: #666; background-color: transparent; border-color: transparent;"><?php echo $amb[$i]->amb_rto_register_no ?></button>
              </th> 
              
              <td style="width:25%;"><?php echo ambwise_emergency_patients($res->dst_code,$amb[$i]->amb_rto_register_no,'tillDate', "both") ?></td>
              <td style="width:25%;"><?php echo ambwise_emergency_patients($res->dst_code,$amb[$i]->amb_rto_register_no,'thismonth', "both") ?></td>
              <td style="width:25%;"><?php echo ambwise_emergency_patients($res->dst_code,$amb[$i]->amb_rto_register_no,'today', "both") ?></td>
          </tr> 
          <?php endforeach; $i++; ?> 
        </table> 
        </div>
        <?php endforeach;   ?> 
    </div>
  </div>
</div>
<!--// start code for jammu div district loop//-->
      <table class="table table-bordered NHM_Dashboard"  >  
      <tr>
          <th style="width:20%;" class="justify-content-center">
            <button  id="22"type="button" class="btn btn-primary" data-toggle="collapse" data-target="#2" style="color: #666; background-color: transparent; border-color: transparent;"><?php echo "Kashmir Division"; ?></button>
          </th> 
          <td style="width:25%;"><?php echo emergency_patients_divisionwise_kashmir('tillDate', "both") ?></td>
          <td style="width:25%;"><?php echo emergency_patients_divisionwise_kashmir('thismonth', "both") ?></td>
          <td style="width:25%;"><?php echo emergency_patients_divisionwise_kashmir('today', "both") ?></td>
      </tr> 
      </table>
<!--// start code for Kasmir div district loop//-->
<div id="2" class="collapse" data-parent="#22">
    <div class="row">
      <div class="col-md-12 paddindOverRide">

      <table class="table table-bordered NHM_Dashboard nhm_table"  >
          <tr style=" color: #f8f9fa">                                      
      <th style="width:20%;">Districts</th>
        <th colspan="3">Emergency Patient Served</th>
        

      </tr>
      <tr style=" color: #f8f9fa">                                      
      <th style="width:20%;">District Name</th>
        <th style="width:25%;">Till Date</th>
        <th style="width:25%;">This Month</th>
        <th style="width:25%;">Today</th>

      </tr>
            </table>
            
            <?php foreach ($data['district_kashmir'] as $res): ?>
              <table class="table table-bordered NHM_Dashboard"  >
            <tr>
              <th  class="justify-content-center" style="width:20%;">
                <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#<?php echo $res->dst_code.$res->dst_name ?>" style="color: #666; background-color: transparent; border-color: transparent;"><?php echo $res->dst_name ?></button>
              </th> 
              <td style="width:25%;"><?php echo districtwise_emergency_patients($res->dst_code,'tillDate', "both") ?></td>
              <td style="width:25%;"><?php echo districtwise_emergency_patients($res->dst_code,'thismonth', "both") ?></td>
              <td style="width:25%;"><?php echo districtwise_emergency_patients($res->dst_code,'today', "both") ?></td>
          </tr> 
          
          </table>
          <div id="<?php echo $res->dst_code.$res->dst_name; ?>" class="collapse" >
          <table class="table table-bordered NHM_Dashboard nhm_table"  >
          <tr style=" color: #f8f9fa">                                      
      <th style="width:20%;">Ambulances</th>
        <th colspan="3">Emergency Patient Served</th>
        

      </tr>
      <tr style=" color: #f8f9fa">                                      
      <th style="width:20%;">Ambulance No</th>
        <th style="width:25%;">Till Date</th>
        <th style="width:25%;">This Month</th>
        <th style="width:25%;">Today</th>

      </tr>
          </table>
   <?php  $i=1; ?>
  <?php foreach ($data['amb_names'] as $amb): ?>
<table class="table table-bordered NHM_Dashboard"   >

     <tr >
       <th  class="justify-content-center" style="width:20%;">
         <button type="button"  class="btn btn-primary" style="color: #666; background-color: transparent; border-color: transparent;"><?php echo $amb[$i]->amb_rto_register_no ?></button>
       </th> 
       <td style="width:25%;"><?php echo ambwise_emergency_patients($res->dst_code,$amb[$i]->amb_rto_register_no,'tillDate', "both") ?></td>
       <td style="width:25%;"><?php echo ambwise_emergency_patients($res->dst_code,$amb[$i]->amb_rto_register_no,'thismonth', "both") ?></td>
       <td style="width:25%;"><?php echo ambwise_emergency_patients($res->dst_code,$amb[$i]->amb_rto_register_no,'today', "both") ?></td>
   </tr> 
   <?php endforeach; $i++; ?>
          
          
          </table>
          </div>
        <?php endforeach;   ?> 
    </div>
  </div>
</div>
<!--// start code for Kasmir div district loop//-->
      <table class="table table-bordered NHM_Dashboard"  >
      <tr>
          <th style="width:20%;" class="justify-content-center">
            <button aria-expanded="false" id="33"type="button" class="btn btn-primary" data-toggle="collapse" data-target="#3" style="color: #666; background-color: transparent; border-color: transparent;"><?php echo "Leh Division"; ?></button>
          </th> 
          <td style="width:25%;"><?php echo emergency_patients_divisionwise_leh('tillDate', "both") ?></td>
          <td style="width:25%;"><?php echo emergency_patients_divisionwise_leh('thismonth', "both") ?></td>
          <td style="width:25%;"><?php echo emergency_patients_divisionwise_leh('today', "both") ?></td>
      </tr> 
      </table>
<!--// start code for Leh div district loop//-->
<div id="3" class="collapse"  data-parent="#33">
    <div class="row">
      <div class="col-md-12 paddindOverRide">

      <table class="table table-bordered NHM_Dashboard nhm_table"  >
          <tr style=" color: #f8f9fa">                                      
      <th style="width:20%;">Districts</th>
        <th colspan="3">Emergency Patient Served</th>
        

      </tr>
      <tr style=" color: #f8f9fa">                                      
      <th style="width:20%;">District Name</th>
        <th style="width:25%;">Till Date</th>
        <th style="width:25%;">This Month</th>
        <th style="width:25%;">Today</th>

      </tr>
            </table>
            <?php foreach ($data['district_leh'] as $res): ?>
              <table class="table table-bordered NHM_Dashboard"  >
            <tr>
              <th  class="justify-content-center" style="width:20%;">
                <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#<?php echo $res->dst_code.$res->dst_name ?>" style="color: #666; background-color: transparent; border-color: transparent;"><?php echo $res->dst_name ?></button>
              </th> 
              <td style="width:25%;"><?php echo districtwise_emergency_patients($res->dst_code,'tillDate', "both") ?></td>
              <td style="width:25%;"><?php echo districtwise_emergency_patients($res->dst_code,'thismonth', "both") ?></td>
              <td style="width:25%;"><?php echo districtwise_emergency_patients($res->dst_code,'today', "both") ?></td>
          </tr> 
          
          </table>
          <div id="<?php echo $res->dst_code.$res->dst_name; ?>" class="collapse" >
          <table class="table table-bordered NHM_Dashboard nhm_table"  >
          <tr style=" color: #f8f9fa">                                      
      <th style="width:20%;">Ambulances</th>
        <th colspan="3">Emergency Patient Served</th>
        

      </tr>
      <tr style=" color: #f8f9fa">                                      
      <th style="width:20%;">Ambulance No</th>
        <th style="width:25%;">Till Date</th>
        <th style="width:25%;">This Month</th>
        <th style="width:25%;">Today</th>

      </tr>
          </table>
   <?php  $i=1; ?>
  <?php foreach ($data['amb_names'] as $amb): ?>
<table class="table table-bordered NHM_Dashboard"  >

     <tr >
       <th  class="justify-content-center" style="width:20%;">
         <button type="button"  class="btn btn-primary" style="color: #666; background-color: transparent; border-color: transparent;"><?php echo $amb[$i]->amb_rto_register_no ?></button>
       </th> 
       <td style="width:25%;"><?php echo ambwise_emergency_patients($amb[$i]->amb_rto_register_no,'tillDate', "both") ?></td>
       <td style="width:25%;"><?php echo ambwise_emergency_patients($amb[$i]->amb_rto_register_no,'thismonth', "both") ?></td>
       <td style="width:25%;"><?php echo ambwise_emergency_patients($amb[$i]->amb_rto_register_no,'today', "both") ?></td>
   </tr> 
   <?php endforeach; $i++; ?>
          
          
          </table>
          </div>
          <?php endforeach;?> 
    </div>
  </div>
</div>
<!--// start code for Leh div district loop//-->
          <?php// endforeach;?>                                   

    
    </div>
  </div>
</div>





 </div> <!--/container fluid end div -->


       