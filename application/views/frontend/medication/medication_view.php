
<div class="width100">
    <h2>Medication Details</h2>
    <form enctype="multipart/form-data" action="#" method="post" id="medication_form">
    <div class="form_field width100 select display_inlne_block">
           <div class="label">Diagnosis Name</div>
            <div class="input width100 display_inlne_block ucfirst_letter">
                      <?php  //$diagonosis;
                        $dia_array = array();
                        if ($diagonosis) {
                            foreach ($diagonosis as $dia) {
                                $dia_array = array_merge($dia_array, $dia);
                            }
                            echo implode(',', $dia_array);
                        }
                        ?>
                 
                <br><br>
            </div>
      </div>
    <table class="student_screening">
        <tr><td>Drug Name</td><td>Dose</td><td>Days</td></tr>
        <?php 
        $drug_details = json_decode($result[0]->drug_details);

        for($dd=0; $dd <= count($drug_details->days)-2;$dd++){ ?>
        
        <tr>
            <td><?php echo $drug_details->drug_name[$dd] ?></td>
             <td><?php echo $drug_details->dose[$dd] ?></td>
              <td><?php echo $drug_details->days[$dd] ?></td>
        </tr>
        <?php
          
        }
        ?>
        
    </table>
            <?php 
        $drug_details = json_decode($result[0]->drug_details);
        
        $drug_intake_details = json_decode($result[0]->drug_intake);
       // var_dump($drug_intake_details);
     

        $days_data = array();
   
        for($dd=0; $dd <= count($drug_details->days)-2;$dd++){ 
               
            for($dd1=0; $dd1 <= $drug_details->days[$dd]-1;$dd1++){
                
                $days_data[$dd1][] = array('drug_name' => $drug_details->drug_name[$dd],'dose' => $drug_details->dose[$dd],'drug_id' => $drug_details->drug_id[$dd]);
            }
            
        }
   
  
         foreach($days_data as $keys=>$day_data){ 

            ?>
        <h3 class="show_table_row" data-day="<?php echo $keys+1;?>">Day <?php echo $keys+1;?></h3>
        <table class="student_screening drugs_table hide_table" id="day_<?php echo $keys+1;?>">
            <tr><td>Drug Name</td><td>Morning</td><td>Evening</td><td>Night</td></tr>
        <?php
        $day = $keys+1;
        foreach($day_data as $data){ ?>
        <tr>
            <td><?php echo $data['drug_name']; ?></td>
            <?php $dose_time =  explode('-', $data['dose']);
            $drug_id = $data['drug_id'];
            ?>
            
            <td><?php if( $dose_time[0] == '1'){ ?>  
                <select name="dose[<?php echo $day;?>][<?php echo $data['drug_id'];?>][morning]" class=""  data-errors="{filter_required:'Please select Reproductive'}" data-base="" tabindex="6">
                            <option value="" >Select</option>
                            <option value="Y" <?php if($drug_intake_details->$day->$drug_id->morning == 'Y'){ echo "selected";} ?>>Yes</option>
                            <option value="N" <?php if($drug_intake_details->$day->$drug_id->morning== 'N'){ echo "selected";} ?>>No</option>    
                </select><?php } else{ echo "-"; }?>
            </td>
            <td><?php if( $dose_time[1] == '1'){ ?>  
                <select name="dose[<?php echo $day;?>][<?php echo $data['drug_id'];?>][evening]" class=""  data-errors="{filter_required:'Please select Reproductive'}" data-base="" tabindex="6">
                            <option value="" >Select</option>
                            <option value="Y" <?php if($drug_intake_details->$day->$drug_id->evening == 'Y'){ echo "selected";} ?>>Yes</option>
                            <option value="N" <?php if($drug_intake_details->$day->$drug_id->evening == 'N'){ echo "selected";} ?>>No</option>    
                </select><?php } else{ echo "-"; }?>
            </td>
            <td><?php if( $dose_time[2] == '1'){ ?>  
                <select name="dose[<?php echo $day;?>][<?php echo $data['drug_id'];?>][night]" class=""  data-errors="{filter_required:'Please select Reproductive'}" data-base="" tabindex="6">
                            <option value="" >Select</option>
                            <option value="Y" <?php if($drug_intake_details->$day->$drug_id->night == 'Y'){ echo "selected";} ?>>Yes</option>
                            <option value="N" <?php if($drug_intake_details->$day->$drug_id->night == 'N'){ echo "selected";} ?>>No</option>    
                </select><?php }else{ echo "-"; } ?>
            </td>
            
        </tr>
        <?php } ?>
        </table>

    <br>
        <?php
          
       }
        ?>
 
    <div class="form_field width100 select display_inlne_block">
           <div class="label">Diat</div>
            <div class="input width100 display_inlne_block">
                      <?php echo $result[0]->diat;?>
                <br><br>
            </div>
      </div>
    
     <div class="width100 form_field display_inlne_block">
         <div class="width100" >
  <input type="hidden" name="pre_id" id="pre_id" value="<?php echo $result[0]->id; ?>">
                     <input type="button" name="submit" value="Save" class="action_button btn form-xhttp-request" data-href="<?php echo base_url();?>medication/save_medication" data-qr="output_position=content" >
 <br><br>
         </div>

     </div>
    </form>
</div>