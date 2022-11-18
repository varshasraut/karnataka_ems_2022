<?php $CI = EMS_Controller::get_instance();?>
<div >
 <div class="row">
 <label style="padding-top:20px;text-align: center;font-size:20px;color:#black;">Report</label>
</div> 
<div class="row">
<div class="col-md-12 paddindOverRide">
<table class="table table-bordered NHM_Dashboard_report"  >
  <tr>                                      
    <th>Prameters</th>
    <th >Today</th>
    <th >Week till today</th>
    <th >Month till today</th>
    <th >Since Launch</th>
  </tr>
  <tr>                                      
    <td>Total Calls</td>
    <td><?php echo $total_call_today[0]->inc_ref_id; ?></td>
    <td><?php echo $total_call_week[0]->inc_ref_id; ?></td>
    <td><?php echo $total_call_month[0]->inc_ref_id; ?></td>
    <td><?php echo $total_call_launch[0]->inc_ref_id; ?></td>
  </tr>
  <tr>                                      
    <td>Total Cases Dispatch</td>
    <td><?php echo $total_call_dispatch_today[0]->inc_ref_id; ?></td>
    <td><?php echo $total_call_dispatch_week[0]->inc_ref_id; ?></td>
    <td><?php echo $total_call_dispatch_month[0]->inc_ref_id; ?></td>
    <td><?php echo $total_call_dispatch_launch[0]->inc_ref_id; ?></td>
  </tr>
  <tr>                                      
    <td>COVID 19 Patient </td>
    <td><?php echo $total_c19_today[0]->inc_ref_id; ?></td>
    <td><?php echo $total_c19_week[0]->inc_ref_id; ?></td>
    <td><?php echo $total_c19_month[0]->inc_ref_id; ?></td>
    <td><?php echo $total_c19_launch[0]->inc_ref_id; ?></td>
  </tr>
 <!-- <tr>                                      
    <td>Non COVID19 Patients</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>-->
  <tr>                                      
    <td>Kilometer’s travelled</td>
    <td><?php echo $total_travel_today_KM; ?></td>
    <td><?php echo $total_travel_week_KM; ?></td>
    <td><?php echo $total_travel_month_km; ?></td>
    <td><?php echo $total_travel_launch_KM; ?></td>
  </tr>
  <!--<tr>                                      
    <td>Active Ambulances</td>
    <td><?php echo $total_amb_today[0]->amb_status; ?></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>-->
</table>

</div>

</div>






 </div>     
<!--
    <table>
  <tr>
    <td>
      <p>This is a paragraph</p>
      <p>This is another paragraph</p>
    </td>
    <td>This cell contains a table:
      <table>
        <tr>
          <td>A</td>
          <td>B</td>
        </tr>
        <tr>
          <td>C</td>
          <td>D</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>This cell contains a list
      <ul>
        <li>apples</li>
        <li>bananas</li>
        <li>pineapples</li>
      </ul>
    </td>
    <td>HELLO</td>
  </tr>
</table>-->

       