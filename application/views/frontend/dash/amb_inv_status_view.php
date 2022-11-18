<?php $CI = EMS_Controller::get_instance();?>
  

<div class="breadcrumb float_left">
        <ul>
            <li class="sms">
                <a class="click-xhttp-request" data-href="{base_url}dash" data-qr="output_position=content&amp;filters=reset">Dashboard</a>
            </li>
            <li>
                <span>Ambulance Inventory Status - Equipment</span>
            </li>

        </ul>
</div>
<br><br>
 <h2>Ambulance Inventory Status - Equipment</h2><br>

 <div class="search">
        <div class="row list_actions">
            <form enctype="multipart/form-data" action="#" method="post" id="ambr_inv_form">
                <div class="grp_actions_width float_left width100">

                    <div class="width20 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">ATC: </div>
                        </div>
                        <div class="width100 float_left">
                              <input name="cluster[atc]" tabindex="17" class="mi_autocomplete form_input " placeholder="ATC " type="text" data-errors="{filter_required:'ATC should not be blank!'}" data-href="<?php echo base_url();?>auto/get_auto_atc" value="<?=@$atc_data[0]->atc_id; ?>" data-value="<?=@$atc_data[0]->atc_name; ?>" data-callback-funct="load_dash_po_by_atc" >
                        </div>
                    </div>
                     <div class="width20 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">PO : </div>
                        </div>
                        <div class="input top_left" id="get_auto_po_by_atc">
               <input name="cluster[po]" tabindex="17" class="mi_autocomplete form_input " placeholder="PO " type="text" data-errors="{filter_required:'PO should not be blank!'}" data-href="<?php echo base_url();?>auto/get_auto_po_by_atc/<?php echo $atc_data[0]->atc_id;?>"  value="<?=@$po_data[0]->po_id; ?>" data-value="<?=@$po_data[0]->po_name; ?>" data-qr="atc_id=<?php echo $atc_id;?>" data-callback-funct="load_cluster_by_po">
                        </div>
                    </div>
                    <div class="width20 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Cluster : </div>
                        </div>
                        <div class="input top_left" id="get_auto_cluster_by_po">
                            <input  name="cluster[cluster_id]" value="<?=@$cluster_data[0]->cluster_id; ?>" class="mi_autocomplete width99" data-href="<?php echo base_url(); ?>auto/get_auto_cluster/<?php echo $po_data[0]->po_id;?>" data-base="" tabindex="7" data-value="<?php echo $cluster_data[0]->cluster_name; ?>" data-nonedit="yes" readonly="readonly" data-errors="{filter_required:'Cluster1 should not be blank'}">
                        </div>
                    </div>
                    <div class="width20 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left"></div>
                        </div>
                        <div class="width100 float_left" style="margin-top: 16px;">
                             <input type="button" class="search_button float_left form-xhttp-request" name="search" value="Search" data-href="<?php echo base_url();?>dash/amb_inv_status" data-qr="output_position=content&amp;flt=true" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<div class="box3">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="amb_form" id="amb_list">  
            
        <div id="dash_filters"></div>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                    <tr>                                      
                        <th nowrap>Sr No</th>
                        <th nowrap>Equipments Name</th>
<!--                        <th nowrap>Total Qty of Equipments</th>-->
                        <th nowrap>Available Equipment Count</th>
<!--                        <th nowrap>Functional Equipment Count</th>-->
                        
                    </tr>
                    <?php foreach($item_list as $key=>$item){ //var_dump($item);?>
                    
                        <tr>   
                           <td><?php echo $key+1;?></td>                            
   <!--                        <td><a class="click-xhttp-request" data-href="{base_url}dash/amb_inv_status_atc" data-qr="output_position=content"><?php echo $total_qty;?></a></td>    -->
                            <td><?php echo $item->eqp_name;?></td>    
                           <td><?php echo $item->available_stk;?></td>    
<!--                           <td><?php echo $avail_qty;?></td>  
                           <td><?php echo $functional_qty;?></td>       -->
                       </tr>
                       <?php } ?>

                  
                </table>

            </div>
        </form>
    </div>
</div>