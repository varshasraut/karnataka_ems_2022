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
                        <th nowrap>Non Covid-19 Bed</th>
                    </tr>
                        
                        
                    </tr>
                    <?php 
                    if($district_bed){
                   
                    $i=0;
                    foreach($district_bed as $key=>$screning){

                      
                       $color_arr = array('#FF0000','#008000','#FFFF00','#00FFFF','#0000FF','#00FF00','#FF00FF','#800080','#A52A2A','#0000A0','#FFA500');

                        $chart_value[] = $screning['total_beds']?$screning['total_beds']:0;
                        $chart_label[] = $screning['hp_name'];
                       
                       
                        $chart_color[] = $color_arr[$i];
                        $i++;
                        if($i == 11)
                        {
                            $i=0;
                        }
                        $chart_ids[] = $screning['hp_id'];?>
                    <tr>
                        
                        
                        <td><?php echo $key+1;?></td>                            
                        <td><a id="dis_<?php echo $screning['district_id'];?>" class="click-xhttp-request" data-href="{base_url}bed/bed_hospital_wise" data-qr="output_position=content&hp_id=<?php echo $screning['hp_id'];?>"><strong><?php echo $screning['hp_name'];?> </strong></a></td> 
                       <td><?php  
                        echo $screning['total_beds'];
                        ?></td>  
                        <td><?php 
                        echo $screning['c19_total_bed'];
                        ?></td>  
                         <td><?php 
                        echo $screning['non_c19_total_bed'];
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
  ids: <?php echo json_encode($chart_ids);?>,
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