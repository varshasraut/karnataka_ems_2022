<?php $CI = EMS_Controller::get_instance();?>
  

<div class="breadcrumb float_left">
        <ul>
            <li class="sms">
                <a class="click-xhttp-request" data-href="{base_url}dash" data-qr="output_position=content&amp;filters=reset">Dashboard</a>
            </li>
            <li>
                      <a class="click-xhttp-request" data-href="{base_url}dash/<?php echo $bread_title_link;?>" data-qr="output_position=content"><?php echo $bread_title;?></a>
            </li>
             <li>
                <a class="click-xhttp-request" data-href="{base_url}dash/<?php echo $bread_title_link_atc;?>" data-qr="output_position=content&atc=<?php echo $atc;?>"><?php echo $atc_name;?> ATC</a>
            </li>
              <li>
                <span>PO</span>
            </li>

        </ul>
</div>
<br><br>
 <h2>PO</h2><br>
<div class="box3 dashboard_outer">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="amb_form" id="amb_list">  
            
        <div id="dash_filters"></div>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                    <tr>                                      
                        <th nowrap>PO Name</th>
                        <th nowrap>Total Ambulances</th>
                        <th nowrap>Total On-Road Ambulances</th>
                        <th nowrap>% On-Road Ambulances</th>
                        
                    </tr>
                                         <?php  
                    $color_array = array("#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#c45777","#158F2E","#2acfca");
                     if($atc_screening){
                         $pie_chart = array();
                         $color_key = 0;
                     foreach($atc_screening as $key=>$screning){ 
                          
                          $chart_value[] = $screning['total_onroad_amb']?$screning['total_onroad_amb']:0;
                          $chart_label[] = $screning['po_name'];
                          $chart_color1[] = rand_color();
                          $chart_color[] = $color_array[$color_key];
                          $chart_ids[] = $screning['po_id'];
                          
                         ?>
                    <tr>
                         <td><a class="click-xhttp-request" id="po_<?php echo  $screning['po_id'];?>" data-href="{base_url}dash/<?php echo $cluster_link_atc;?>" data-qr="output_position=content&atc=<?php echo $screning['atc_id'];?>&po=<?php echo $screning['po_id'];?>"><?php echo $screning['po_name'];?></a></td>  

                           <td><?php echo $screning['total_amb'];?></td>  
                        <td><?php echo $screning['total_onroad_amb'];?></td>   
                        <td><?php if($screning['total_amb'] >0 ) { echo round(($screning['total_onroad_amb']/$screning['total_amb'])*100,2); } else { echo '0';}?>%</td>    
                    </tr>
                    
                    <?php  
                      $total = $total+$screning['total_amb'];
                      $total_onroad_amb = $total_onroad_amb+$screning['total_onroad_amb'];
                      
                      $color_key++;
                    }
                     }

                    ?>
                    <tr>                                      
                        <td nowrap>Total</td>
                        <td nowrap><?php echo $total;?></td>
                        <td nowrap><?php echo $total_onroad_amb;?></td>
                        <td><?php if($total >0 ) { echo round(($total_onroad_amb/$total*100),2); } else { echo '0';}?>%</td>    
                        
                    </tr>
                </table>

            </div>
        </form>

    </div>
         <canvas id="pie-chart" width="400" height="100"></canvas>
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
            text: 'Total Operational Ambulance'
          },
          onClick:function($ev,$ele){ 
              var $_index = $ele[0]['_index'];
              var $click_id = $data['ids'][$_index];
              $('#po_'+$click_id).click();
          }
      }
    });
        </script>
</div>