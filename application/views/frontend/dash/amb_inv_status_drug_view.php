<?php $CI = EMS_Controller::get_instance();?>
  

<div class="breadcrumb float_left">
        <ul>
            <li class="sms">
                <a class="click-xhttp-request" data-href="{base_url}dash" data-qr="output_position=content&amp;filters=reset">Dashboard</a>
            </li>
            <li>
                <span>Ambulance Inventory Status - Medicines</span>
            </li>

        </ul>
</div>
<br><br>
 <h2>Ambulance Inventory Status - Medicines</h2><br>
 <div class="filters_groups">                   

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
                             <input type="button" class="search_button float_left form-xhttp-request" name="search" value="Search" data-href="<?php echo base_url();?>dash/amb_inv_status_drug" data-qr="output_position=content&amp;flt=true" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
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
                        <th nowrap>Name of Medicines</th>
<!--                         <th nowrap>min qty</th>-->
                        <th nowrap>Balance</th>
                        
                    </tr>
                   

                    <?php
                    $count = 0;
                    foreach($item_list as $key=>$drug){ ?>
                        <tr>
                            <td><?php echo $count+1;?></td>      
<!--                          <td><a class="click-xhttp-request" data-href="{base_url}dash/amb_inv_status_drug_atc" data-qr="output_position=content"><?php echo $drug->med_title;?></a></td>  -->
                            <td><?php echo $drug->med_title;?></td> 
<!--                            <td><?php  //echo $drug->med_base_quantity; ?></td> -->
                            <td><?php  echo $drug->available_stk?$drug->available_stk:0; ?></td> 
                        </tr>
                        <?php 
                        $count++;
                         } ?>
                    
               
                    
        

                </table>

            </div>
        </form>
    </div>
</div>