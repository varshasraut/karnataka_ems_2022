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
<div class="box3">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="amb_form" id="amb_list">  
        
        <div id="dash_filters"></div>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                    <tr>                                      
                        <th nowrap>Cluster Name</th>
                       <th nowrap>Total Qty of Equipments</th>
                        <th nowrap>Available Equipment Count</th>
                        <th nowrap>Functional Equipment Count</th>
                        
                    </tr>
                    <?php if($cluter_data){
                        foreach($cluter_data as $cluster){ ?>
                              <tr>

<!--                            <td><a class="click-xhttp-request" data-href="{base_url}dash/<?php echo $school_link;?>" data-qr="output_position=content&atc=<?php echo $atc;?>&po=<?php echo $po;?>&cluster_id=<?php echo $cluster->cluster_id;?>"><?php echo $cluster->cluster_name;?></a></td> -->
                             <td><?php echo $cluster->cluster_name;?></td> 
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                      <?php  }?>
                          <tr>

                              <td>Total</td>  
                            <td>	5		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <?php
                        
                    }?>

                    
               
                    
        

                </table>

            </div>
        </form>
    </div>
</div>