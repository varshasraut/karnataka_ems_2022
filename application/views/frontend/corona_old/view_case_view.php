<ul>
    <?php foreach($patient_calls as $key=>$patient){ ?>
    <li>
     <a href="{base_url}corona/view_call_details?id=<?php echo $patient->follow_up_id; ?>" class="strong onpage_popup" data-qr="output_position=content&id=<?php echo $patient->follow_up_id; ?>" data-popupwidth="1200" data-popupheight="700" style="color:#000;"> Call <?php echo $key+1;?> - <?php echo $patient->follow_up_date;?></a>
    </li>
    <?php  } ?>
</ul>
