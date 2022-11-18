
<div class="width100">
    <h2>Prescription Details</h2>
    
    <div class="form_field width100 select display_inlne_block">
           <div class="label">Diagnosis Name</div>
            <div class="input width100 display_inlne_block ucfirst_letter">
                      <?php  //$diagonosis;
                      $dia_array = array();
                      if($diagonosis){
                      foreach($diagonosis as $dia){
                        $dia_array = array_merge($dia_array,$dia);
                      }
                     echo implode(',',$dia_array);
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
 
    <div class="form_field width100 select display_inlne_block">
           <div class="label">Diat</div>
            <div class="input width100 display_inlne_block">
                      <?php echo $result[0]->diat;?>
                <br><br>
            </div>
      </div>
    
     <div class="width100 form_field  display_inlne_block">
         <div class="width100" >
                 <?php if($result[0]->is_approve == 0){?>
     <a class="click-xhttp-request action_button btn" data-href="<?php echo base_url();?>prescription/approve_prescription" data-qr="output_position=content&amp;pre_id=<?php echo base64_encode($result[0]->id);?>&amp;amb_action=view" >Approve</a>
    <?php }?>
         </div>

     </div>
   
</div>