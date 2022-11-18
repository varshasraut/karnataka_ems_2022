<?php $CI = EMS_Controller::get_instance();?>
  

<div class="breadcrumb float_left">
        <ul>
            <li class="sms">
                <a class="click-xhttp-request" data-href="{base_url}dash" data-qr="output_position=content&amp;filters=reset">Dashboard </a>
            </li>
             
             <li>
                <span>Hospital Bed Avaibility</span>
            </li>

        </ul>
</div>
<br><br>
<div class="box3 dashboard_outer">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="amb_form" id="amb_list">  
            
        <div id="dash_filters"></div>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                    <tr>                                      
                       <tr>                                      
                        <th nowrap>Sr No</th>
                        <th nowrap>Hospital</th>
                        <th nowrap>Total Bed</th>
                        <th nowrap>Covid-19 Bed</th>
                        <th nowrap>Covid-19 Occupied</th>
                        <th nowrap>Covid-19 Vaccant</th>
                        <th nowrap>Non Covid-19 Bed</th>
                        <th nowrap>Non Covid-19 Occupied</th>
                        <th nowrap>Non Covid-19 Vaccant</th>
                    </tr>
                        
                        
                    </tr>
                    <?php 
                    //var_dump($district_bed);
                    if($district_bed){
                    foreach($district_bed as $key=>$screning){
                      $non_c19_total_bed = $screning['non_c19_total_bed'];
                      $c19_total_bed = $screning['c19_total_bed'];

                      if($c19_total_bed >= $non_c19_total_bed)
                      {
                          $chart_value = array($c19_total_bed,$non_c19_total_bed);
                          $chart_label =  array('Covid-19 beds','Non Covid-19 Beds');
                          $chart_color = array('green','red');
                          $chart_ids[] = array('c19','nc19');
                      }
                      else
                      {
                          $chart_value = array($c19_total_bed,$non_c19_total_bed);
                          $chart_label =  array('Covid-19 beds','Non Covid-19 Beds');
                          $chart_color = array('red','green');
                          $chart_ids[] = array('c19','nc19');
                      }
                      ?>
                      
                       
                    <tr>
                        
                        
                        <td><?php echo $key+1;?></td>                            
                        <td><?php echo $screning['hp_name'];?></td> 
                       <td><?php  
                        echo $screning['total_beds'];
                        ?></td>  
                        <td><?php 
                        echo $screning['c19_total_bed'];
                        ?></td>  
                         <td><?php 
                        echo $screning['C19_Occupied'];
                        ?></td>  
                          <td><?php 
                        echo $screning['C19_Vacant'];
                        ?></td>  
                         <td><?php 
                        echo $screning['non_c19_total_bed'];
                        
                        ?></td>  
                           <td><?php 
                        echo $screning['NonC19_Occupied'];
                        ?></td>  
                          <td><?php 
                        echo $screning['NonC19_Vacant'];
                        ?></td>  
                    </tr>
                    
                    <?php    
                    }
                                         }
                    ?>
                </table>

            </div>
        </form>
    </div>
        <canvas id="pie-chart" width="400" height="150"></canvas>
        <script>

var $data = {
  datasets: [{
    data: <?php echo json_encode($chart_value);?>,
    backgroundColor:  <?php echo json_encode($chart_color);?>
  }],
  labels:  <?php echo json_encode($chart_label);?>,
  //ids: <?php echo json_encode($chart_ids);?>,
};
  //console.log($data);
    var canvas = document.getElementById("pie-chart");
    var ctx = canvas.getContext("2d");
    var myNewChart = new Chart(ctx, {
      type: 'pie',
      data: $data,
      options:{
          title: {
        display: true,
        text: 'Hospital Bed Avaibility'
      },
          onClick:function($ev,$ele){ 
              var $_index = $ele[0]['_index'];
              var $click_id = $data['ids'][$_index];
              $('#atc_'+$click_id).click();
          }
      }
    });
        </script>
</div>