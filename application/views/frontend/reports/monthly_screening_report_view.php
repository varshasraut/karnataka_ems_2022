<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>reports/monthly_screening_report" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                        <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>
                
            </div>
</div>   
<table class="table report_table">

                    <tr>                              
                        <?php foreach($header as $heading){?>
                        <th style="line-height: 20px;"><?php echo $heading;?></th>
                        <?php }?>
                    </tr>
                            
                    <?php 
                    foreach($school_data as $key=>$school){
                       // var_dump($school);
                        
                     ?>
                        <tr>  
                        <td><?php echo $key+1;?></td>
                        <td><?php echo $school->school_name;?></td>
                        <td><?php echo $school->atc_name;?></td>
                        <td><?php echo $school->po_name;?></td>
                        <td><?php echo $school->screen_count?></td>
                   
                        
                           </tr>
                    <?php }?>
                      

</table>