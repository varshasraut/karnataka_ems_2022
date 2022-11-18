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
                        <th nowrap>Sr No</th>
                        <th nowrap>State</th>
                        <th nowrap>Total Bed</th>
                        <th nowrap>Covid-19 Bed</th>
                        <th nowrap>Non Covid-19 Bed</th>
                    </tr>
                    <?php 
                    if($total_bed){
                    foreach($total_bed as $key=>$bed){
                       
                   
                        
                        
                        $total_beds =$total_beds + $bed->C19_Total_Beds + $bed->NonC19_Total_Beds;
                        $c19_total_bed =$c19_total_bed + $bed->C19_Total_Beds;
                        $non_c19_total_bed =$non_c19_total_bed + $bed->NonC19_Total_Beds;

                        if($c19_total_bed >= $non_c19_total_bed)
                        {
                            $chart_value = array($c19_total_bed,$non_c19_total_bed);
                            $chart_label =  array('Covid-19 beds','Non Covid-19 Beds');
                            $chart_color = array('green','red');
                        }
                        else
                        {
                            $chart_value = array($c19_total_bed,$non_c19_total_bed);
                            $chart_label =  array('Covid-19 beds','Non Covid-19 Beds');
                            $chart_color = array('red','green');
                        }
                       // $chart_ids = array('MH');
                         
                    }
                                         }
                    ?>
                    <td><?php echo $key;?></td>                            
                    <td>
<!--                        <a id="MH" class="click-xhttp-request" data-href="{base_url}bed/district_bed" data-qr="output_position=content"><strong>Madhya Pradesh</strong></a>-->
                        
                        <a id="MH" class="click-xhttp-request" data-href="{base_url}bed/division_bed" data-qr="output_position=content"><strong>Madhya Pradesh</strong></a>
                    
                    </td> 
                         <td><?php  
                        echo $total_beds;
                        ?></td>  
                        <td><?php 
                        echo $c19_total_bed;
                        ?></td>  
                         <td><?php 
                        echo $non_c19_total_bed;
                        ?></td> 
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