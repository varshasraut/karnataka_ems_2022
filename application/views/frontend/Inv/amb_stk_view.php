<div class="box3">    
    
    <div class="emt_landing_page">
        
        <div class="emergency_call_buttons">
<!--            <a class="action_button click-xhttp-request" data-href="{base_url}bike" data-qr="output_position=content" >Emergency Call</a>-->
              <a class="action_button click-xhttp-request" data-href="{base_url}inv/invlist_amb" data-qr="output_position=content&amp;filters=no&amp;inv_type=CA&amp;inv_amb=<?php echo $inv_amb;?>">Consumables Stock </a>
            
        </div>
        <div class="emergency_call_buttons">
   <a class="action_button click-xhttp-request" data-href="{base_url}inv/invlist_amb" data-qr="output_position=content&amp;filters=no&amp;inv_type=NCA&amp;inv_amb=<?php echo $inv_amb;?>">Non-Consumables Stock </a>
            
        </div>
        <div class="emergency_call_buttons">
  <a class="action_button click-xhttp-request" data-href="{base_url}med/medlist_amb" data-qr="output_position=content&amp;filters=no&amp;inv_type=MED&amp;med_amb=<?php echo $inv_amb;?>">Medicines Stock </a>
            
        </div>
        <div class="emergency_call_buttons">
           <a class="action_button click-xhttp-request" data-href="{base_url}eqp/eqplist_amb" data-qr="output_position=content&amp;filters=no&amp;inv_type=EQP&amp;eqp_amb=<?php echo $inv_amb;?>"> Equipment Stock </a>
            
        </div>
      
    </div>
    
</div>
  