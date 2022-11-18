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
                <a class="click-xhttp-request" data-href="{base_url}dash/<?php echo $bread_title_link_po;?>" data-qr="output_position=content&atc=<?php echo $atc;?>&po=<?php echo $po;?>"><?php echo $po_name;?> PO</a>
            </li>
              <li>
                <span>Cluster</span>
            </li>

        </ul>
</div>
<br><br>
 <h2>Cluster</h2><br>
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
                        <th nowrap>Cluster Name</th>
                        <th nowrap>Today</th>
                        <th nowrap>Month Till Date <?php echo $current_date;?></th>
                        <th nowrap>Year Till Date <?php echo $current_date;?></th>
                         <th nowrap>Since Beginning Till Date <?php echo $current_date;?></th>
                        
                    </tr>

                    <?php   
                    $color_array = array("#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#c45777","#158F2E","#2acfca");
                     if($atc_screening){
                        $pie_chart = array();
                        $color_key = 0;
                        foreach($atc_screening as $key=>$cluster){  
                            $chart_value[] = $cluster['total_screening'];
                            $chart_label[] = $cluster['cluster_name'];
                            $chart_color[] = rand_color();
                            $chart_ids[] = $cluster['cluster_id'];?>
                            <tr>
                                <td><a id='clus_<?php echo $cluster['cluster_id'];?>' class="click-xhttp-request" data-href="{base_url}dash/<?php echo $school_link;?>" data-qr="output_position=content&atc=<?php echo $atc;?>&po=<?php echo $po;?>&cluster_id=<?php echo $cluster['cluster_id'];?>"><?php echo $cluster['cluster_name'];?></a></td>  
                                <td><?php echo $cluster['today_screening'];?></td>  
                                <td><?php echo $cluster['month_screening'];?></td>   
                                <td><?php echo $cluster['year_total_screening'];?></td>   
                                <td><?php echo $cluster['total_screening'];?></td>   
                            </tr>
                      <?php
                      
                      $color_key++;
                        }?>
                        <?php
                        
                    }else{?>
                         <tr>
   
                             <td colspan="5" style="text-align: center;">
                                 No record found
                             </td>
                         </tr>
                        <?php } ?>
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
                        text: 'Students Screening Status'
                      },
                      onClick:function($ev,$ele){ 
                          var $_index = $ele[0]['_index'];
                          var $click_id = $data['ids'][$_index];
                          $('#clus_'+$click_id).click();
                      }
                  }
                });
        </script>
</div>