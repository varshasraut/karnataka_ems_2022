<?php $CI = EMS_Controller::get_instance();?>
  

<div class="breadcrumb float_left">
        <ul>
            <li class="sms">
                <a class="click-xhttp-request" data-href="{base_url}dash" data-qr="output_position=content&amp;filters=reset">Dashboard</a>
            </li>
            <li>
                <span>Chronic Conditions Status</span>
            </li>

        </ul>
</div>
<br><br>
 <h2>Chronic Conditions Status</h2><br>
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
                    <th nowrap>Disease/Condition</th>
                    <th nowrap>Today</th>
                    <th nowrap>Month Till Date <?php echo $current_date;?></th>
                    <th nowrap>Year Till Date <?php echo $current_date;?></th>
                    <th nowrap>Since Beginning Till Date <?php echo $current_date;?></th>
                </tr>
                <tr><td><a id="chronic_birth_defects" class="click-xhttp-request" data-href="{base_url}dash/chronic_condition_atc" data-qr="output_position=content&action=chronic_birth_defects">Birth Defects</a></td><td><?php echo $today['birth_defect']?$today['birth_defect']:0;?></td><td><?php echo $current_month['birth_defect']?$current_month['birth_defect']:0;?></td><td><?php echo ($current_year['birth_defect']?$current_year['birth_defect']:0);?></td><td><?php echo ($total_screening['birth_defect']?$total_screening['birth_defect']:0);?></td></tr>
                
                <tr><td><a id="deficiencies" class="click-xhttp-request" data-href="{base_url}dash/chronic_condition_atc" data-qr="output_position=content&action=deficiencies">Difficiencies</td></a><td><?php echo $today['deficiencies']?$today['deficiencies']:0;?></td><td><?php echo $current_month['deficiencies']?$current_month['deficiencies']:0;?></td><td><?php echo ($current_year['deficiencies']?$current_year['deficiencies']:0);?></td><td><?php echo ($total_screening['deficiencies']?$total_screening['deficiencies']:0);?></td></tr>
                
                <tr><td><a id="skin_condition" class="click-xhttp-request" data-href="{base_url}dash/chronic_condition_atc" data-qr="output_position=content&action=skin_condition">Skin Condtion</a></td><td><?php echo $today['skin_condition']?$today['skin_condition']:0;?></td><td><?php echo $current_month['skin_condition']?$current_month['skin_condition']:0;?></td><td><?php echo ($current_year['skin_condition']?$current_year['skin_condition']:0);?></td><td><?php echo ($total_screening['skin_condition']?$total_screening['skin_condition']:0);?></td></tr>
                
                <tr><td><a id="childhood_disease" class="click-xhttp-request" data-href="{base_url}dash/chronic_condition_atc" data-qr="output_position=content&action=childhood_disease">Childhood Disease</a></td><td><?php echo $today['childhood_disease']?$today['childhood_disease']:0;?></td><td><?php echo $current_month['childhood_disease']?$current_month['childhood_disease']:0;?></td><td><?php echo ($current_year['childhood_disease']?$current_year['childhood_disease']:0);?></td><td><?php echo ($total_screening['childhood_disease']?$total_screening['childhood_disease']:0);?></td></tr>
                
                <tr><td><a id="opthalmological" class="click-xhttp-request" data-href="{base_url}dash/chronic_condition_atc" data-qr="output_position=content&action=opthalmological">Vision</a></td><td><?php echo $today['opthalmological']?$today['opthalmological']:0;?></td><td><?php echo $current_month['opthalmological']?$current_month['opthalmological']:0;?></td><td><?php echo ($current_year['opthalmological']?$current_year['opthalmological']:0);?></td><td><?php echo ($total_screening['opthalmological']?$total_screening['opthalmological']:0);?></td></tr>
                  
                <tr><td><a id="ent_check_if_present" class="click-xhttp-request" data-href="{base_url}dash/chronic_condition_atc" data-qr="output_position=content&action=ent_check_if_present">ENT</a></td><td><?php echo $today['ent_check_if_present']?$today['ent_check_if_present']:0;?></td><td><?php echo $current_month['ent_check_if_present']?$current_month['ent_check_if_present']:0;?></td><td><?php echo ($current_year['ent_check_if_present']?$current_year['ent_check_if_present']:0);?></td><td><?php echo ($total_screening['ent_check_if_present']?$total_screening['ent_check_if_present']:0);?></td></tr>
                  
                  

                </table>

            </div>
        </form>
    </div>
     <canvas id="pie-chart" width="400" height="100"></canvas>
        <script>

var $data = {
  datasets: [{
    data:[<?php echo $total_screening['ent_check_if_present'];?>,<?php echo $total_screening['opthalmological'];?>,<?php echo $total_screening['childhood_disease'];?>,<?php echo $total_screening['skin_condition'];?>,<?php echo $total_screening['deficiencies'];?>,<?php echo $total_screening['birth_defect'];?>],
    backgroundColor:  ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#ff4533"]
  }],
  labels:  ["ENT Since Beginning","Vision Since Beginning","Childhood Disease Since Beginning","Skin Condtion Since Beginning","Difficiencies Since Beginning","Birth Defects Since Beginning"],
  ids: ['ent_check_if_present','opthalmological','childhood_disease','skin_condition','deficiencies','chronic_birth_defects'],
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
            text: 'Chronic Conditions Status'
          },
          onClick:function($ev,$ele){ 
              var $_index = $ele[0]['_index'];
              var $click_id = $data['ids'][$_index];
              $('#'+$click_id).click();
          }
      }
    });
        </script>
</div>