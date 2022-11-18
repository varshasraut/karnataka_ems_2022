<?php $CI = EMS_Controller::get_instance();?>
  

<div class="breadcrumb float_left">
        <ul>
            <li class="sms">
                <a class="click-xhttp-request" data-href="{base_url}dash" data-qr="output_position=content&amp;filters=reset">Dashboard</a>
            </li>
            <li>
                <span>Total Operational Ambulance</span>
            </li>

        </ul>
</div>
<br><br>
 <h2>Total Operational Ambulance</h2><br>
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

<div class="box3">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="amb_form" id="amb_list">  
            
        <div id="dash_filters"></div>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                    <tr>                                      
                        <th nowrap>Sr No</th>
                        <th nowrap>Total Ambulances</th>
                        <th nowrap>Total On-Road Ambulances</th>
                        <th nowrap>% On-Road Ambulances</th>
                        
                    </tr>

                    <tr>
                        
                        
                        <td>1</td>                            
                        <td><a class="click-xhttp-request" data-href="{base_url}dash/<?php echo $function_name;?>" data-qr="output_position=content" id="amb_1"><?php echo $total_amb;?></a></td>    
                        <td><?php echo $total_onroad_amb;?></td>  
                        <td><?php echo round(($total_onroad_amb/$total_amb)*100,2); ?></td>  
                        <?php $off_road = $total_amb - $total_onroad_amb; ?>
                    </tr>
               
                    
        

                </table>

            </div>
                <canvas id="pie-chart" width="400" height="100"></canvas>
        <script>
        new Chart(document.getElementById("pie-chart"), {
    type: 'pie',
    data: {
      labels: ["On Road Ambulance", "Off Road Ambulance"],
      datasets: [{
        label: "Population (millions)",
        backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
        data: [<?php echo $total_onroad_amb;?>,<?php echo $off_road; ?>]
      }]
    },
    options: {
      title: {
        display: true,
        text: 'Total Operational Ambulance'
      },
      onClick:function($ev,$data){ 
            $('#amb_1').click();
      }
    }
});
</script>
        </form>
    </div>
</div>