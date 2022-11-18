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
 <h2>Total Emergency Dispatch</h2><br>
<!--<div class="filters_groups">                   

    <div class="search">

        <div class="row list_actions">


            <div class="grp_actions_width float_left">

                <div class="width30 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">From: </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="from_date" tabindex="1" class="form_input mi_calender filter_required" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly">
                    </div>
                </div>
                 <div class="width30 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">To : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="to_date" tabindex="2" class="form_input mi_calender filter_required" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" >
                    </div>
                </div>
                <div class="width30 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left"></div>
                    </div>
                    <div class="width100 float_left" style="margin-top: 16px;">
                         <input type="button" class="search_button float_left form-xhttp-request" name="" value="Search" data-href="#" data-qr="output_position=content&amp;flt=true" />
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>-->

<div class="box3 dashboard_outer">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="amb_form" id="amb_list">  
            
        <div id="dash_filters"></div>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                    <tr>                                      
                        <th nowrap>PO Name</th>
                        <th nowrap>Today</th>
                        <th nowrap>Month Till Date <?php echo $current_date;?></th>
                        <th nowrap>Year Till Date <?php echo $current_date;?></th>
                        <th nowrap>Since Beginning Till Date <?php echo $current_date;?></th>
                        
                    </tr>
                    <?php  foreach($atc_screening as $key=>$screning){ 
                         $chart_value[] = $screning['total_inc']?$screning['total_inc']:0;
                          $chart_label[] = $screning['po_name'];
                          $chart_color[] = rand_color();
                          $chart_ids[] = $screning['po_id'];?>
                    <tr>
                         <td><a id='po_<?php echo $screning['po_id'];?>'  class="click-xhttp-request" data-href="{base_url}dash/<?php echo $cluster_link_atc;?>" data-qr="output_position=content&atc=<?php echo $atc;?>&po=<?php echo $screning['po_id'];?>"><?php echo $screning['po_name'];?></a></td>  
                        <td><?php echo $screning['today_inc'];?></td>  
                        <td><?php echo $screning['current_month_inc'];?></td>   
                        <td><?php echo $screning['year_total_inc'];?></td> 
                        <td><?php echo $screning['total_inc'];?></td> 
                    </tr>
                    
                    <?php    
                    }
                    ?>
                  
        

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
        text: 'Distance Travelled by Ambulances'
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