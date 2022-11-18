<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>reports/export_emp_report" method="post" enctype="multipart/form-data" target="form_frame">
                    <!-- <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_funtion ?>" method="post" enctype="multipart/form-data" target="form_frame"> -->
                    <input type="hidden" name="team_type" value="<?php echo $team_type?>" >
                   <?php //print_r($team_type);?>
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    
                </div>
                
            </div>
</div>

<table class="table report_table">

                    <tr>                              
                    <?php foreach ($header as $heading) { ?>
            <th style="line-height: 20px;"><?php echo $heading; ?></th>
            <?php } ?>
                    </tr>
                    <?php if(is_array($inc_data)){
                    foreach($inc_data as $inc){ ?>
                         <tr>         
                         <td><?php echo ucwords($inc['Employee_ID']);?></td>
                        <td><?php echo ucwords($inc['Employee_Name']);?></td>
                        <td><?php echo $inc['Designation'];?></td> 
                        <td><?php echo $inc['Department'];?></td>
                        <td><?php echo $inc['Position'];?></td> 
                        <td><?php if($inc['avaya_id'] != NULL){echo $inc['avaya_id'];} else {echo "NA";}?></td> 
                        <td><?php echo $inc['Date_of_Joining'];?></td>
                        <td><?php echo $inc['Experience'];?></td> 
                        <td><?php echo $inc['Qualificaton'];?></td> 
                        <td><?php echo $inc['Age'];?></td> 
   
                        
                         </tr>
                    <?php }}?>

</table></form>