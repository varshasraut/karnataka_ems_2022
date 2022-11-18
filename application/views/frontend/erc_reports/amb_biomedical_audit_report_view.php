<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/boimedical_audit_report" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['amb_no']; ?>" name="amb_no">
                <input type="hidden" value="<?php echo $report_args['current_audit_date']; ?>" name="audit_date">
                
                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>   
<table class="table report_table">

    <tr>                              
        <?php foreach ($header as $heading) { ?>
            <th style="line-height: 20px;"><?php echo $heading; ?></th>
            <?php } ?>
    </tr>
    <?php 

?>

        <tr>         

            <td><?php echo get_clg_name_by_ref_id($ambulance->added_by); ?></td> 
            <td><?php echo $ambulance->ambulance_no; ?></td> 
            <td><?php echo $ambulance->current_audit_date; ?></td> 
            <td><?php echo get_district_by_id($ambulance->district_id); ?></td> 
            <td><?php echo $ambulance->base_location; ?></td> 
            <td><?php echo show_amb_type_name($ambulance->ambulance_type); ?></td> 
            <td><?php echo $ambulance->emt_name; ?></td> 
            <td><?php echo $ambulance->pilot_name; ?></td> 



        </tr>
        <tr>                              
        <?php foreach ($second_header as $second_heading) { ?>
            <th style="line-height: 20px;"><?php echo $second_heading; ?></th>
            <?php } ?>
        </tr>
        
                    
        <?php 
       
        
        foreach ($audit_item as $key=>$item) {
          
            ?>
             <tr>
             <td style="line-height: 20px;"><?php echo $key+1; ?></td>                 
            <td style="line-height: 20px;"><?php echo $item->item_name; ?></td>
            <td style="line-height: 20px;"><?php echo $item->availability; ?></td>
            <td style="line-height: 20px;"><?php echo $item->working_status; ?></td>
             <td style="line-height: 20px;"><?php echo $item->damage_broken; ?></td>
              <td style="line-height: 20px;"><?php echo $item->not_working_reason; ?></td>
               <td style="line-height: 20px;"><?php echo $item->damage_reason; ?></td>
                <td style="line-height: 20px;"><?php echo $item->other_remark; ?></td>
            </tr>
            <?php } ?>
        



</table>