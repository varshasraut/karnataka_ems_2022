<?php $CI = EMS_Controller::get_instance();
$chron_type = array('chronic_birth_defects'=> 'Birth Defects',
                    'chronic_birth_defects' => 'Difficiencies',
                    'skin_condition' => 'Skin Condtion',
                    'childhood_disease'=> 'Childhood Disease',
                    'opthalmological'=> 'Vision',
                    'ent_check_if_present'=>'ENT');
?>
  

<div class="breadcrumb float_left">
        <ul>
            <li class="sms">
                <a class="click-xhttp-request" data-href="{base_url}dash" data-qr="output_position=content&amp;filters=reset">Dashboard</a>
            </li>
            <li>
                      <a class="click-xhttp-request" data-href="{base_url}dash/<?php echo $bread_title_link;?>" data-qr="output_position=content"><?php echo $bread_title;?></a>
            </li>
              <li>
                <a class="click-xhttp-request" data-href="{base_url}dash/<?php echo $bread_title_link;?>" data-qr="output_position=content"><?php echo $chron_type[$action];?></a>
            </li>
             <li>
                <a class="click-xhttp-request" data-href="{base_url}dash/<?php echo $bread_title_link_atc;?>" data-qr="output_position=content&atc=<?php echo $atc;?>&action=<?php echo $action;?>"><?php echo $atc_name;?> ATC</a>
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
                        <th nowrap>Today</th>
                        <th nowrap>Month Till Date <?php echo $current_date;?></th>
                        <th nowrap>Year Till Date <?php echo $current_date;?></th>
                        <th nowrap>Since Beginning Till Date <?php echo $current_date;?></th>
                        
                    </tr>
                   <?php  
                     if($atc_screening){
                         $pie_chart = array();
                         $color_key = 0;
                     foreach($atc_screening as $key=>$screning){ 
                          
                         ?>
                    <tr>
                        <td><a class="click-xhttp-request" id="po_<?php echo  $screning['po_id'];?>" data-href="{base_url}dash/<?php echo $cluster_link_atc;?>" data-qr="output_position=content&atc=<?php echo $screning['atc_id'];?>&po=<?php echo $screning['po_id'];?>&action=<?php echo $action;?>"><?php echo $screning['po_name'];?></a></td>  

                      <?php if($action == 'chronic_birth_defects'){
                          $chart_value[] = $screning['total_screening']['birth_defect']?$screning['total_screening']['birth_defect']:0;
                          $chart_label[] = $screning['po_name'];
                          $chart_color[] = rand_color();
                          $chart_ids[] = $screning['po_id'];
                          ?>
                            <td><?php echo $screning['today']['birth_defect']?$screning['today']['birth_defect']:0; ?></td>  
                            <td><?php echo $screning['current_month']['birth_defect']?$screning['current_month']['birth_defect']:0; ?></td>  
                            <td><?php echo $screning['current_year']['birth_defect']?$screning['current_year']['birth_defect']:0; ?></td>    
                            <td><?php echo $screning['total_screening']['birth_defect']?$screning['total_screening']['birth_defect']:0; ?></td>   
                        <?php }else if($action == 'deficiencies'){ 
                            
                            $chart_value[] = $screning['total_screening']['deficiencies']?$screning['total_screening']['deficiencies']:0;
                            $chart_label[] = $screning['po_name'];
                            $chart_color[] = rand_color();
                            $chart_ids[] = $screning['po_id'];
                            ?>
                            <td><?php echo $screning['today']['deficiencies']?$screning['today']['deficiencies']:0; ?></td>  
                            <td><?php echo $screning['current_month']['deficiencies']?$screning['current_month']['deficiencies']:0;; ?></td>  
                            <td><?php echo $screning['current_year']['deficiencies']?$screning['current_year']['deficiencies']:0;; ?></td>    
                            <td><?php echo $screning['total_screening']['deficiencies']?$screning['total_screening']['deficiencies']:0;; ?></td>   
                        <?php }else if($action == 'skin_condition'){
                            $chart_value[] = $screning['total_screening']['skin_condition']?$screning['total_screening']['skin_condition']:0;
                            $chart_label[] = $screning['po_name'];
                            $chart_color[] = rand_color();
                            $chart_ids[] = $screning['po_id'];
                            ?>
                            <td><?php echo $screning['today']['skin_condition']?$screning['today']['skin_condition']:0; ?></td>  
                            <td><?php echo $screning['current_month']['skin_condition']?$screning['current_month']['skin_condition']:0;; ?></td>  
                            <td><?php echo $screning['current_year']['skin_condition']?$screning['current_year']['skin_condition']:0;; ?></td>    
                            <td><?php echo $screning['total_screening']['skin_condition']?$screning['total_screening']['skin_condition']:0;; ?></td>   
                        <?php }else if($action == 'childhood_disease'){
                             $chart_value[] = $screning['total_screening']['childhood_disease']?$screning['total_screening']['childhood_disease']:0;
                            $chart_label[] = $screning['po_name'];
                            $chart_color[] = rand_color();
                            $chart_ids[] = $screning['po_id'];
                            ?>
                            <td><?php echo $screning['today']['childhood_disease']?$screning['today']['childhood_disease']:0; ?></td>  
                            <td><?php echo $screning['current_month']['childhood_disease']?$screning['current_month']['childhood_disease']:0;; ?></td>  
                            <td><?php echo $screning['current_year']['childhood_disease']?$screning['current_year']['childhood_disease']:0;; ?></td>    
                            <td><?php echo $screning['total_screening']['childhood_disease']?$screning['total_screening']['childhood_disease']:0;; ?></td>   
                         <?php }else if($action == 'opthalmological'){
                               $chart_value[] = $screning['total_screening']['opthalmological']?$screning['total_screening']['opthalmological']:0;
                            $chart_label[] = $screning['po_name'];
                            $chart_color[] = rand_color();
                            $chart_ids[] = $screning['po_id'];
                             ?>
                            <td><?php echo $screning['today']['opthalmological']?$screning['today']['opthalmological']:0; ?></td>  
                            <td><?php echo $screning['current_month']['opthalmological']?$screning['current_month']['opthalmological']:0;; ?></td>  
                            <td><?php echo $screning['current_year']['opthalmological']?$screning['current_year']['opthalmological']:0;; ?></td>    
                            <td><?php echo $screning['total_screening']['opthalmological']?$screning['total_screening']['opthalmological']:0;; ?></td>   
                      
                            <?php }else if($action == 'ent_check_if_present'){
                            $chart_value[] = $screning['total_screening']['ent_check_if_present']?$screning['total_screening']['ent_check_if_present']:0;
                            $chart_label[] = $screning['po_name'];
                            $chart_color[] = rand_color();
                            $chart_ids[] = $screning['po_id'];?>
                            <td><?php echo $screning['today']['ent_check_if_present']?$screning['today']['ent_check_if_present']:0; ?></td>  
                            <td><?php echo $screning['current_month']['ent_check_if_present']?$screning['current_month']['ent_check_if_present']:0;; ?></td>  
                            <td><?php echo $screning['current_year']['ent_check_if_present']?$screning['current_year']['ent_check_if_present']:0;; ?></td>    
                            <td><?php echo $screning['total_screening']['ent_check_if_present']?$screning['total_screening']['ent_check_if_present']:0;; ?></td>   
                        <?php }?>
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
            text: 'Chronic Conditions Status'
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