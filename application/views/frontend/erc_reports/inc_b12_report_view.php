<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>erc_reports/b12_type_report" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                        <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
                        <!-- <input type="hidden" value="<?php echo $report_args['incient_district'];?>" name="incient_district"> -->
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>
                
            </div>
</div>   
<?php //var_dump($inc_data);?>
<table class="table report_table">
    <tr>                              
        <?php if(is_array($header)){foreach ($header as $heading) { ?>
            <th style="line-height: 20px;"><?php echo $heading; ?></th>
        <?php }} ?>
    </tr>
    <!-- <tr>  
        <td>Accident(Vehicle)</td>
        <td>0</td>
    </tr> -->
    <?php if(is_array($inc_data)){foreach ($inc_data as $inc) { ?>
    
    <tr>  
        <td>Medical</td>
        <td><?php  if($inc['medical']!= NULL){echo $inc['medical'];}else {echo "0";} ?></td>
    </tr>
    <tr>  
        <td>Others</td>
        <td><?php if($inc['other']!= NULL){echo $inc['other'];}else{echo "0";} ?></td>
    </tr>
    <tr>  
        <td>Assault</td>
        <td><?php if($inc_data[$district_id]['assault']!= NULL){echo $inc_data[$district_id]['assault'];}else{echo "0";} ?></td>
    </tr>
    <tr>  
        <td>Labour/Pregnancy</td>
        <td><?php if($inc_data[$district_id]['labour_pregnancy']!= NULL){echo $inc_data[$district_id]['labour_pregnancy'];}else{echo "0";} ?></td>
    </tr>
    <tr>  
        <td>Lighting/Electrocution</td>
        <td><?php if($inc_data[$district_id]['lighting']!= NULL){echo  $inc_data[$district_id]['lighting'];}else{echo "0";}  ?></td>
    </tr>
    <tr>  
        <td>Intoxication/Poisoning</td>
        <td><?php if($inc_data[$district_id]['lighting']!= NULL){echo  $inc_data[$district_id]['intoxication'];} else{echo "0";} ?></td>
    </tr>
    <tr>  
        <td>Trauma (Vehicle)</td>
        <td><?php if($inc_data[$district_id]['truama_vechicle']!= NULL){echo $inc_data[$district_id]['truama_vechicle'];}else{echo "0";}?></td>
    </tr>
    
    
    <tr>  
        <td>Trauma ( Non-Vehicle)</td>
        <td><?php if($inc_data[$district_id]['truama_non_vechicle']!= NULL){ echo $inc_data[$district_id]['truama_non_vechicle'];}else{echo "0";} ?></td>
    </tr>
    <tr>  
        <td>Animal Attack</td>
        <td><?php if($inc_data[$district_id]['animal_attack']!= NULL){echo  $inc_data[$district_id]['animal_attack'];} else{echo "0";} ?></td>
    </tr>
    
    <tr>  
        <td>Suicide/Self Inflicted Injury</td>
        <td><?php if($inc_data[$district_id]['suicide']!= NULL){echo  $inc_data[$district_id]['suicide'];} else{echo "0";} ?></td>
    </tr>
   <tr>  
        <td>Burn</td>
        <td><?php if($inc_data[$district_id]['burn']!= NULL){echo  $inc_data[$district_id]['burn'];} else{echo "0";} ?></td>

    </tr>
      
     <tr>  
        <td>Mass casualty</td>
        <td><?php if($inc_data[$district_id]['mass_casualty']!= NULL){echo  $inc_data[$district_id]['mass_casualty'];} else{echo "0";} ?></td>

    </tr>
    <?php } }?>
     

</table>