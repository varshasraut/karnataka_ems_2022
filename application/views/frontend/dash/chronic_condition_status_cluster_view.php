<?php $CI = EMS_Controller::get_instance();
$chron_type = array('chronic_birth_defects'=> 'Birth Defects',
                    'chronic_birth_defects' => 'Difficiencies',
                    'skin_condition' => 'Skin Condtion',
                    'childhood_disease'=> 'Childhood Disease',
                    'opthalmological'=> 'Vision',
                    'ent_check_if_present'=>'ENT');?>
  

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
                <a class="click-xhttp-request" data-href="{base_url}dash/<?php echo $bread_title_link_atc;?>" data-qr="output_position=content&atc=<?php echo $atc;?>&action=<?php echo $action;?>"> <?php echo $atc_name;?> ATC</a>
            </li>
            <li>
                <a class="click-xhttp-request" data-href="{base_url}dash/<?php echo $bread_title_link_po;?>" data-qr="output_position=content&atc=<?php echo $atc;?>&po=<?php echo $po;?>&action=<?php echo $action;?>"><?php echo $po_name;?> PO</a>
            </li>
              <li>
                <span>Cluster</span>
            </li>

        </ul>
</div>
<br><br>
 <h2>Cluster</h2><br>


<div class="box3 dashboard_outer">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="amb_form" id="amb_list">  
        
        <div id="dash_filters"></div>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                    <tr>       
                        <th nowrap>Sr No</th>
                        <th nowrap>Cluster Name</th>
                        <th nowrap>Today</th>
                        <th nowrap>Month Till Date <?php echo $current_date;?></th>
                        <th nowrap>Year Till Date <?php echo $current_date;?></th>
                        <th nowrap>Since Beginning Till Date <?php echo $current_date;?></th>
                        
                    </tr>
                    <?php if($atc_screening){
                        $sr_no = 0;
                        foreach($atc_screening as $key=>$cluster){ 
                            ?>
                        <tr>
                            <td><?php echo $sr_no+1;?></td>
<!--                            <td><?php echo $cluster['cluster_name'];?></td>-->
                            <td><a id="cluster_<?php echo $cluster['cluster_id'];?>" class="click-xhttp-request" data-href="{base_url}dash/<?php echo $school_link;?>" data-qr="output_position=content&atc=<?php echo $atc;?>&po=<?php echo $po;?>&cluster_id=<?php echo $cluster['cluster_id'];?>&action=<?php echo $action;?>"><?php echo $cluster['cluster_name'];?></a></td>  
                            <?php if($action == 'chronic_birth_defects'){
                          $chart_value[] = $cluster['total_screening']['birth_defect']?$cluster['total_screening']['birth_defect']:0;
                          $chart_label[] = $cluster['cluster_name'];
                          $chart_color[] = rand_color();
                          $chart_ids[] = $cluster['cluster_id'];
                          ?>
                            <td><?php echo $cluster['today']['birth_defect']?$cluster['today']['birth_defect']:0; ?></td>  
                            <td><?php echo $cluster['current_month']['birth_defect']?$cluster['current_month']['birth_defect']:0; ?></td>  
                            <td><?php echo $cluster['current_year']['birth_defect']?$cluster['current_year']['birth_defect']:0; ?></td>    
                            <td><?php echo $cluster['total_screening']['birth_defect']?$cluster['total_screening']['birth_defect']:0; ?></td>   
                        <?php }else if($action == 'deficiencies'){ 
                            
                            $chart_value[] = $cluster['total_screening']['deficiencies']?$cluster['total_screening']['deficiencies']:0;
                            $chart_label[] = $cluster['cluster_name'];
                            $chart_color[] = rand_color();
                            $chart_ids[] = $cluster['cluster_id'];
                            ?>
                            <td><?php echo $cluster['today']['deficiencies']?$cluster['today']['deficiencies']:0; ?></td>  
                            <td><?php echo $cluster['current_month']['deficiencies']?$cluster['current_month']['deficiencies']:0;; ?></td>  
                            <td><?php echo $cluster['current_year']['deficiencies']?$cluster['current_year']['deficiencies']:0;; ?></td>    
                            <td><?php echo $cluster['total_screening']['deficiencies']?$cluster['total_screening']['deficiencies']:0;; ?></td>   
                        <?php }else if($action == 'skin_condition'){
                            $chart_value[] = $cluster['total_screening']['skin_condition']?$cluster['total_screening']['skin_condition']:0;
                            $chart_label[] = $cluster['cluster_name'];
                            $chart_color[] = rand_color();
                            $chart_ids[] = $cluster['cluster_id'];
                            ?>
                            <td><?php echo $cluster['today']['skin_condition']?$cluster['today']['skin_condition']:0; ?></td>  
                            <td><?php echo $cluster['current_month']['skin_condition']?$cluster['current_month']['skin_condition']:0;; ?></td>  
                            <td><?php echo $cluster['current_year']['skin_condition']?$cluster['current_year']['skin_condition']:0;; ?></td>    
                            <td><?php echo $cluster['total_screening']['skin_condition']?$cluster['total_screening']['skin_condition']:0;; ?></td>   
                        <?php }else if($action == 'childhood_disease'){
                             $chart_value[] = $cluster['total_screening']['childhood_disease']?$cluster['total_screening']['childhood_disease']:0;
                            $chart_label[] = $cluster['cluster_name'];
                            $chart_color[] = rand_color();
                            $chart_ids[] = $cluster['cluster_id'];
                            ?>
                            <td><?php echo $cluster['today']['childhood_disease']?$cluster['today']['childhood_disease']:0; ?></td>  
                            <td><?php echo $cluster['current_month']['childhood_disease']?$cluster['current_month']['childhood_disease']:0;; ?></td>  
                            <td><?php echo $cluster['current_year']['childhood_disease']?$cluster['current_year']['childhood_disease']:0;; ?></td>    
                            <td><?php echo $cluster['total_screening']['childhood_disease']?$cluster['total_screening']['childhood_disease']:0;; ?></td>   
                         <?php }else if($action == 'opthalmological'){
                               $chart_value[] = $cluster['total_screening']['opthalmological']?$cluster['total_screening']['opthalmological']:0;
                            $chart_label[] = $cluster['cluster_name'];
                            $chart_color[] = rand_color();
                            $chart_ids[] = $cluster['cluster_id'];
                             ?>
                            <td><?php echo $cluster['today']['opthalmological']?$cluster['today']['opthalmological']:0; ?></td>  
                            <td><?php echo $cluster['current_month']['opthalmological']?$cluster['current_month']['opthalmological']:0;; ?></td>  
                            <td><?php echo $cluster['current_year']['opthalmological']?$cluster['current_year']['opthalmological']:0;; ?></td>    
                            <td><?php echo $cluster['total_screening']['opthalmological']?$cluster['total_screening']['opthalmological']:0;; ?></td>   
                      
                            <?php }else if($action == 'ent_check_if_present'){
                                $chart_value[] = $cluster['total_screening']['ent_check_if_present']?$cluster['total_screening']['ent_check_if_present']:0;
                            $chart_label[] = $cluster['cluster_name'];
                            $chart_color[] = rand_color();
                            $chart_ids[] = $cluster['cluster_id'];?>
                            <td><?php echo $cluster['today']['ent_check_if_present']?$cluster['today']['ent_check_if_present']:0; ?></td>  
                            <td><?php echo $cluster['current_month']['ent_check_if_present']?$cluster['current_month']['ent_check_if_present']:0;; ?></td>  
                            <td><?php echo $cluster['current_year']['ent_check_if_present']?$cluster['current_year']['ent_check_if_present']:0;; ?></td>    
                            <td><?php echo $cluster['total_screening']['ent_check_if_present']?$cluster['total_screening']['ent_check_if_present']:0;; ?></td>   
                        <?php }?>
                        </tr>
                      <?php 
                          $sr_no++;
                      
                        }?>
                        <?php
                        
                    }?>
                    
               
                    
        

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
              $('#cluster_'+$click_id).click();
          }
      }
    });
        </script>
</div>