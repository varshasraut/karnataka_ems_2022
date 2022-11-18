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
                <span>ATC</span>
            </li>
<!--            <li>
                <span>Distance Travelled by Ambulances</span>
            </li>-->

        </ul>
</div>
<br><br>
 <h2>Distance Travelled by Ambulances</h2><br>
<!--<div class="filters_groups">                   

    <div class="search">

        <div class="row list_actions">


            <div class="grp_actions_width float_left">

                <div class="width40 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">From: </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="from_date" tabindex="1" class="form_input mi_calender filter_required" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly">
                    </div>
                </div>
                 <div class="width40 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">To : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="to_date" tabindex="2" class="form_input mi_calender filter_required" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" >
                    </div>
                </div>
                <div class="width_14 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left"></div>
                    </div>
                    <div class="width100 float_left" style="margin-top: 16px;">
                         <input type="button" class="search_button float_left form-xhttp-request" name="" value="Search" data-href="#" data-qr="output_position=content&amp;flt=true" />
                    </div>
                </div>

                <div class="width_14 float_left">
                     <input type="text" class="search_catalog" name="amb_item" value="" placeholder="Search"/> 

                    <input type="button" class="search_button float_right form-xhttp-request" name="" value="Search" data-href="{base_url}amb/amb_listing" data-qr="output_position=content&amp;flt=true" />
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
                        <th nowrap>Sr No</th>
                        <th nowrap>ATC</th>
                        <th nowrap>Today</th>
                        <th nowrap>Month Till Date <?php echo $current_date;?></th>
                        <th nowrap>Year Till Date <?php echo $current_date;?></th>
                        <th nowrap>Since Beginning Till Date <?php echo $current_date;?></th>
                        
                        
                    </tr>
                    <?php 
                    if($atc_screening){
                    foreach($atc_screening as $key=>$screning){
                        $chart_value[] = $screning['total_distance']?$screning['total_distance']:0;
                        $chart_label[] = $screning['atc_name'];
                        $chart_color[] = rand_color();
                        $chart_ids[] = $screning['atc_id'];?>
                    <tr>
                        
                        
                        <td><?php echo $key;?></td>                            
                        <td><a id="atc_<?php echo $screning['atc_id'];?>" class="click-xhttp-request" data-href="{base_url}dash/<?php echo $atc_po_linke;?>" data-qr="output_position=content&atc=<?php echo $screning['atc_id'];?>"><?php echo $screning['atc_name'];?> ATC</a></td> 
                        <td><?php echo $screning['today_distance'];?></td>  
                        <td><?php echo $screning['current_month_distance'];?></td>   
                        <td><?php echo $screning['current_year_distance'];?></td>   
                        <td><?php echo $screning['total_distance'];?></td>   
                    </tr>
                    
                    <?php    
                    }
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
              $('#atc_'+$click_id).click();
          }
      }
    });
        </script>
</div>