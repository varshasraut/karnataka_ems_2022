<?php $CI = EMS_Controller::get_instance();?>
<div >
 <div class="row">
 <label style="padding-top:20px;text-align: center;font-size:20px;color:#black;">STATE  DETAILS FOR COVID19 & NON COVID19</label>
</div> 
<div class="row">
<div class="col-md-2 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
  <tr>                                      
    <th height="120">STATE</th>
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
<?php 
  if($total_bed)
    {
      foreach($total_bed as $key=>$bed)
      {
        //$total_beds =$total_beds + $bed->C19_Total_Beds + $bed->NonC19_Total_Beds;

        $C19_Total_Beds =$C19_Total_Beds + $bed->C19_Total_Beds;
        $C19_Occupied =$C19_Occupied + $bed->C19_Occupied;
        $C19_Vacant =$C19_Vacant + $bed->C19_Vacant;

        $NonC19_Total_Beds =$NonC19_Total_Beds + $bed->NonC19_Total_Beds;
        $NonC19_Occupied =$NonC19_Occupied + $bed->NonC19_Occupied;
        $NonC19_Vacant =$NonC19_Vacant + $bed->NonC19_Vacant;
      } 
    }
    ?>
    <tr>
        <td>
        <!--<a id="MH" style="cursor:pointer" class="click-xhttp-request" data-href="{base_url}bed/nhm_district_bed" data-qr="output_position=district_data" >Madhya Pradesh</a>-->
        <a id="MH" style="cursor:pointer" class="click-xhttp-request" data-href="{base_url}bed/nhm_division_bed" data-qr="output_position=district_data&showprocess=yes" >Madhya Pradesh</a>
        
        </td>
    </tr>   
</table>
</div>
<div class="col-md-5 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
<tr>
  <td><?php  echo $C19_Total_Beds; ?></td>  
  <td><?php echo $C19_Occupied; ?></td>  
  <td><?php echo $C19_Vacant; ?></td> 
        
</tr>   
</table>
</div>
<div class="col-md-5 paddindOverRide">
<table class="table table-bordered NHM_Dashboard"  >
  <tr>
    <td><?php  echo $NonC19_Total_Beds; ?></td>  
    <td><?php echo $NonC19_Occupied; ?></td>  
    <td><?php echo $NonC19_Vacant; ?></td> 
  </tr>   
</table>
</div>
</div>
<div class="row">
<div class="col-md-1">
<a  style="" id="MH" style="cursor:pointer;color:black;font-size:6%" class="btn click-xhttp-request" data-href="{base_url}bed/nhm_district_bed_blank" data-qr="output_position=district_data" ><strong>Back</strong></a>
</div>
</div>
<div  id="division_data">
</div>
<div  id="district_data">
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

       