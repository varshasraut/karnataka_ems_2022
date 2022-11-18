<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>amb/<?php echo $submit_function ?>" method="post" enctype="multipart/form-data" target="form_frame">
                        
                          <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                           <input type="hidden" value="<?php echo $report_args['system'];?>" name="system">
                           <input type="hidden" value="<?php echo $report_args['district'];?>" name="incient_district">
                         
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>
                
            </div>
</div>  
<div>
     Total Denial Ambulance:- <?php echo count($hpcl_data); ?>
</div>
<table class="table report_table">

    <tr>                              
        <?php foreach ($header as $heading) { ?>
            <th style="line-height: 20px;"><?php echo $heading; ?></th>
        <?php } ?>
            <th>Action</th>
    </tr>

    <?php  ?>
    <?php 
    if($hpcl_data){
      ?>
    <?php
    foreach ($hpcl_data as $hpcl) { 

        ?>
            <tr>  
                <td><?php echo $hpcl->amb_no; ?></td>
                <td><?php echo $hpcl->dst_name; ?></td>
                <td><?php echo $hpcl->hp_name; ?></td>
                <td><?php echo $hpcl->challenge_val; ?></td>
                <td><?php echo $hpcl->meaning; ?></td>
                 <td><?php echo $hpcl->denial_remark; ?></td>
                
              
                <td><?php echo $hpcl->added_date; ?></td>
                <?php $tl_group = array('UG-SuperAdmin','UG-ShiftManager','UG-EROSupervisor','UG-FLD-OPE-DESK','UG-ERCHead','UG-ERCManager','UG-Grievance');
        if(in_array($clg_group, $tl_group)){ 
            $clg_senior = '';
            if($hpcl->clg_senior != ''){
                $clg_senior = get_clg_name_by_ref_id($hpcl->clg_senior);
                $clg_senior_data = get_clg_data_by_ref_id($hpcl->clg_senior);
            }
         
             $clg_tl =  "";
            if($clg_senior_data[0]->clg_senior != ''){
                $clg_tl = get_clg_name_by_ref_id($clg_senior_data[0]->clg_senior);
            }
            ?>
               <td><?php echo $hpcl->clg_first_name.' '.$hpcl->clg_mid_name.' '.$hpcl->clg_last_name; ?></td>
               <td><?php echo $clg_senior; ?></td>
               <td><?php echo $clg_tl; ?></td>
            <?php 

        } ?>
                <td>
                    <a class="add_remark click-xhttp-request onpage_popup" data-href="<?php echo base_url(); ?>amb/add_denial_remark" data-qr="position=popup_div&amb=<?php echo $hpcl->amb_no; ?>&denial_id=<?php echo base64_encode($hpcl->id);?>"></a>
                    <a class="view_remark click-xhttp-request onpage_popup" data-href="<?php echo base_url(); ?>amb/view_denial_remark" data-qr="position=popup_div&amb=<?php echo $hpcl->amb_no; ?>&denial_id=<?php echo base64_encode($hpcl->id);?>"></a>
                </td>
            </tr>

<?php }?>
            
<?php 
    }else{
    ?>
    <tr> 
     <td  style="text-align: center;" colspan="17">Record Not Found</td>
     <tr> 
    <?php
} ?>
</table>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>