<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>reports/b12_type_report" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                        <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
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
    <tr>  
        <td>Accident(Vehicle)</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
    </tr>
    <tr>  
        <td>Assault</td>
        <td><?php echo $inc_data['Amravati']['assault']; ?></td>
        <td><?php echo $inc_data['Gadchiroli']['assault']; ?></td>
        <td><?php echo $inc_data['Mumbai']['assault']; ?></td>
        <td><?php echo $inc_data['Palghar']['assault']; ?></td>
        <td><?php echo $inc_data['Solapur']['assault']; ?></td>
        <td><?php echo $inc_data['Solapur']['assault']+$inc_data['Amravati']['assault']+$inc_data['Gadchiroli']['assault']+$inc_data['Mumbai']['assault']+$inc_data['Palghar']['assault']; ?></td>
    </tr>
    
    <tr>  
        <td>Medical</td>
        <td><?php echo $inc_data['Amravati']['medical']; ?></td>
        <td><?php echo $inc_data['Gadchiroli']['medical']; ?></td>
        <td><?php echo $inc_data['Mumbai']['medical']; ?></td>
        <td><?php echo $inc_data['Palghar']['medical']; ?></td>
        <td><?php echo $inc_data['Solapur']['medical']; ?></td>
        <td><?php echo $inc_data['Solapur']['medical']+$inc_data['Amravati']['medical']+$inc_data['Gadchiroli']['medical']+$inc_data['Mumbai']['medical']+$inc_data['Palghar']['medical']; ?></td>
    </tr>
    <tr>  
        <td>Poly Trauma</td>
        <td><?php echo $inc_data['Amravati']['poly_truama']; ?></td>
        <td><?php echo $inc_data['Gadchiroli']['poly_truama']; ?></td>
        <td><?php echo $inc_data['Mumbai']['poly_truama']; ?></td>
        <td><?php echo $inc_data['Palghar']['poly_truama']; ?></td>
        <td><?php echo $inc_data['Solapur']['poly_truama']; ?></td>
        <td><?php echo $inc_data['Solapur']['poly_truama']+$inc_data['Amravati']['poly_truama']+$inc_data['Gadchiroli']['poly_truama']+$inc_data['Mumbai']['poly_truama']+$inc_data['Palghar']['poly_truama']; ?></td>
    </tr>
    <tr>  
        <td>Labour/Pregnancy</td>
        <td><?php echo $inc_data['Amravati']['labour_pregnancy']; ?></td>
        <td><?php echo $inc_data['Gadchiroli']['labour_pregnancy']; ?></td>
        <td><?php echo $inc_data['Mumbai']['labour_pregnancy']; ?></td>
        <td><?php echo $inc_data['Palghar']['labour_pregnancy']; ?></td>
        <td><?php echo $inc_data['Solapur']['labour_pregnancy']; ?></td>
        <td><?php echo $inc_data['Solapur']['labour_pregnancy']+$inc_data['Amravati']['labour_pregnancy']+$inc_data['Gadchiroli']['labour_pregnancy']+$inc_data['Mumbai']['labour_pregnancy']+$inc_data['Palghar']['labour_pregnancy']; ?></td>
    </tr>
    <tr>  
        <td>Others</td>
        <td><?php echo $inc_data['Amravati']['other']; ?></td>
        <td><?php echo $inc_data['Gadchiroli']['other']; ?></td>
        <td><?php echo $inc_data['Mumbai']['other']; ?></td>
        <td><?php echo $inc_data['Palghar']['other']; ?></td>
        <td><?php echo $inc_data['Solapur']['other']; ?></td>
        <td><?php echo $inc_data['Solapur']['other']+$inc_data['Amravati']['other']+$inc_data['Gadchiroli']['other']+$inc_data['Mumbai']['other']+$inc_data['Palghar']['other']; ?></td>
    </tr>
    <tr>  
        <td>Cardiac</td>
        <td><?php echo $inc_data['Amravati']['cardiac']; ?></td>
        <td><?php echo $inc_data['Gadchiroli']['cardiac']; ?></td>
        <td><?php echo $inc_data['Mumbai']['cardiac']; ?></td>
        <td><?php echo $inc_data['Palghar']['cardiac']; ?></td>
        <td><?php echo $inc_data['Solapur']['cardiac']; ?></td>
        <td><?php echo $inc_data['Solapur']['cardiac']+$inc_data['Amravati']['cardiac']+$inc_data['Gadchiroli']['cardiac']+$inc_data['Mumbai']['cardiac']+$inc_data['Palghar']['cardiac']; ?></td>
    </tr>
    <tr>  
        <td>Lighting/Electrocution</td>
        <td><?php echo $inc_data['Amravati']['lighting']; ?></td>
        <td><?php echo $inc_data['Gadchiroli']['lighting']; ?></td>
        <td><?php echo $inc_data['Mumbai']['lighting']; ?></td>
        <td><?php echo $inc_data['Palghar']['lighting']; ?></td>
        <td><?php echo $inc_data['Solapur']['lighting']; ?></td>
        <td><?php echo $inc_data['Solapur']['lighting']+$inc_data['Amravati']['lighting']+$inc_data['Gadchiroli']['lighting']+$inc_data['Mumbai']['lighting']+$inc_data['Palghar']['lighting']; ?></td>
    </tr>
    <tr>  
        <td>Intoxication/Poisoning</td>
        <td><?php echo $inc_data['Amravati']['intoxication']; ?></td>
        <td><?php echo $inc_data['Gadchiroli']['intoxication']; ?></td>
        <td><?php echo $inc_data['Mumbai']['intoxication']; ?></td>
        <td><?php echo $inc_data['Palghar']['intoxication']; ?></td>
        <td><?php echo $inc_data['Solapur']['intoxication']; ?></td>
        <td><?php echo $inc_data['Solapur']['intoxication']+$inc_data['Amravati']['intoxication']+$inc_data['Gadchiroli']['intoxication']+$inc_data['Mumbai']['intoxication']+$inc_data['Palghar']['intoxication']; ?></td>
    </tr>
    <tr>  
        <td>Suicide/Self Inflicted Injury</td>
        <td><?php echo $inc_data['Amravati']['suicide']; ?></td>
        <td><?php echo $inc_data['Gadchiroli']['suicide']; ?></td>
        <td><?php echo $inc_data['Mumbai']['suicide']; ?></td>
        <td><?php echo $inc_data['Palghar']['suicide']; ?></td>
        <td><?php echo $inc_data['Solapur']['suicide']; ?></td>
        <td><?php echo $inc_data['Solapur']['suicide']+$inc_data['Amravati']['suicide']+$inc_data['Gadchiroli']['suicide']+$inc_data['Mumbai']['suicide']+$inc_data['Palghar']['suicide']; ?></td>
    </tr>
   <tr>  
        <td>Burn</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
    </tr>
      <tr>  
        <td>Fall</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
    </tr>
     <tr>  
        <td>Mass casualty</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
    </tr>
    
     <tr>  
        <td>Unavailed Call</td>
        <td><?php echo $inc_data['Amravati']['unavailed_call']; ?></td>
        <td><?php echo $inc_data['Gadchiroli']['unavailed_call']; ?></td>
        <td><?php echo $inc_data['Mumbai']['unavailed_call']; ?></td>
        <td><?php echo $inc_data['Palghar']['unavailed_call']; ?></td>
        <td><?php echo $inc_data['Solapur']['unavailed_call']; ?></td>
        <td><?php echo $inc_data['Solapur']['unavailed_call']+$inc_data['Amravati']['unavailed_call']+$inc_data['Gadchiroli']['unavailed_call']+$inc_data['Mumbai']['unavailed_call']+$inc_data['Palghar']['unavailed_call']; ?></td>
    </tr>
    <tr>  
        <td>Patient already shifted by 108 </td>
        <td><?php echo $inc_data['Amravati']['patient_108']; ?></td>
        <td><?php echo $inc_data['Gadchiroli']['patient_108']; ?></td>
        <td><?php echo $inc_data['Mumbai']['patient_108']; ?></td>
        <td><?php echo $inc_data['Palghar']['patient_108']; ?></td>
        <td><?php echo $inc_data['Solapur']['patient_108']; ?></td>
        <td><?php echo $inc_data['Solapur']['patient_108']+$inc_data['Amravati']['patient_108']+$inc_data['Gadchiroli']['patient_108']+$inc_data['Mumbai']['patient_108']+$inc_data['Palghar']['patient_108']; ?></td>
    </tr>
     <tr>  
        <td>Patient already shifted other vehicle</td>
        <td><?php echo $inc_data['Amravati']['patient_vahicle']; ?></td>
        <td><?php echo $inc_data['Gadchiroli']['patient_vahicle']; ?></td>
        <td><?php echo $inc_data['Mumbai']['patient_vahicle']; ?></td>
        <td><?php echo $inc_data['Palghar']['patient_vahicle']; ?></td>
        <td><?php echo $inc_data['Solapur']['patient_vahicle']; ?></td>
        <td><?php echo $inc_data['Solapur']['patient_vahicle']+$inc_data['Amravati']['patient_vahicle']+$inc_data['Gadchiroli']['patient_vahicle']+$inc_data['Mumbai']['patient_vahicle']+$inc_data['Palghar']['patient_vahicle']; ?></td>
    </tr>

</table>