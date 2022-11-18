<?php
$view = ($clu_action == 'view') ? 'disabled' : '';

$CI = EMS_Controller::get_instance();

$title = ($clu_action == 'edit') ? " Edit Cluster Details " : (($clu_action == 'view') ? "View Cluster Details" : "Add Cluster Details");

?>
<div class="width100">
    <h2><?php echo $title;?></h2> 
    <form enctype="multipart/form-data" action="#" method="post" id="cluster_ad_form">

        <div class="form_field width2">

            <div class="label">Cluster Name</div>

            <div class="input top_left">

                <input name="cluster[cluster_name]" value="<?=@$cluster[0]->cluster_name; ?>" class="form_input filter_required" placeholder="Cluster Name"  data-errors="{filter_required:'Cluster Name Should not blank'}" type="text"  tabindex="6" <?php echo $view;?>>

            </div>

        </div>
        <div class="form_field width2">
            <div class="label">District</div>
            <div id="cluster_dist">
                <?php

                if($cluster[0]->district != ''){
                    $district_id = $cluster[0]->district;
                }
                $dt = array('dst_code' => $district_id, 'st_code' => 'MP', 'auto' => 'clu_auto_addr', 'rel' => 'cluster', 'disabled' => $view);

                echo get_district_tahsil($dt);
                ?>
            </div>
        </div>
        <div class="form_field width2">
            <div class="label">Tahshil</div>
            <div id="cluster_tahsil">
                <?php
                 if($cluster[0]->taluka != ''){
                    $tahsil_id = $cluster[0]->taluka;
                }
                $thl = array('thl_id' =>$tahsil_id, 'dst_code' => '', 'st_code' => 'MP', 'auto' => 'clu_auto_addr', 'rel' => 'cluster', 'disabled' => $view);

                echo get_tahshil($thl);
                ?>
            </div>
        </div>
        <div class="form_field width2">

            <div class="label">ATC</div>

            <div class="input top_left">
                
   <input name="cluster[atc]" tabindex="17" class="mi_autocomplete form_input filter_required" placeholder="ATC " type="text" data-errors="{filter_required:'ATC should not be blank!'}" data-href="<?php echo base_url();?>auto/get_auto_atc" data-value="<?=@$cluster[0]->atc; ?>" data-callback-funct="load_po_by_atc" >
   
<!--                <input name="cluster[atc]" value="<?=@$cluster[0]->atc; ?>" class="form_input filter_required" placeholder="ATC"  data-errors="{filter_required:'ATC Should not blank'}" type="text"  tabindex="6" <?php echo $view;?>>-->

            </div>

        </div>
        <div class="form_field width2">

            <div class="label">PO</div>

            <div class="input top_left" id="get_auto_po_by_atc">

                         <?php 
                
                $po = array();
                if($cluster[0]->atc != ''){
                    $po['atc_id']= $cluster[0]->atc;
                }
              //echo get_auto_po($po);
                ?>
<!--'<input name="cluster[po]" value="<?php echo $po_id;?>" class="mi_autocomplete width97 filter_required" data-href="<?php echo base_url();?>auto/get_auto_po_by_atc/<?php echo $po['atc_id'];?>" placeholder="PO" data-errors="{filter_required:\'Please select PO from dropdown list\'}" data-base=""  data-value="<?php echo $po_name;?>">-->
   <input name="cluster[po]" tabindex="17" class="mi_autocomplete form_input filter_required" placeholder="ATC " type="text" data-errors="{filter_required:'PO should not be blank!'}" data-href="<?php echo base_url();?>auto/get_auto_po_by_atc/<?php echo $po['po_id'];?>" data-value="<?=@$cluster[0]->atc; ?>" data-qr="atc_id=<?php echo $atc_id;?>" >

            </div>

        </div>
   <?php if (!(@$clu_action == 'view')) { ?>
        <div class="width_25 margin_auto">
            <div class="button_field_row">
                <div class="button_box">
                    <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url(); ?>cluster/<?php if ($cluster) { ?>edit_cluster<?php } else { ?>add_cluster<?php } ?>' data-qr='output_position=content&action=submit&cluster_id[0]=<?php echo base64_encode($cluster[0]->cluster_id); ?>' TABINDEX="12">  
                </div>
            </div>
        </div>
   <?php }?>
    </form>
</div>