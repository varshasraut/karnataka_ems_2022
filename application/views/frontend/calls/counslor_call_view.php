
<a style="cursor: pointer " class="minimize_scroll_menu"><div class="head" style="font-size: 13px !important;">COUNSELOR CALLS</div></a>
<ul class="incoming_calls">

    <?php
    //var_dump($COUNSLOR_DATA);
   /* if($COUNSLOR_DATA){
    foreach ($COUNSLOR_DATA as $data) {
        if ($data->sub_type == 'COUNSELOR') {
            ?>
            <li>
            <a class="incoming_call_anchor click-xhttp-request" data-href="{base_url}counselor104/counslor_incoming_call" data-qr="output_position=content&amp;tool_code=mt_atnd_calls&amp;opt_id=<?php echo $data->operator_id; ?>&amp;sub_id=<?php echo $data->sub_id; ?>&amp;inc_ref_id=<?php echo $data->sub_id; ?>"><span style="color:white;"> <?php echo $data->sub_id; ?></span></a>
            </li>
    <?php }
        }
    }*/
    if($COUNSLOR_CALL_DATA){
         foreach ($COUNSLOR_CALL_DATA as $data) {
             //var_dump($data);
        ?>
             <li>

               <a class="incoming_call_anchor click-xhttp-request" data-href="{base_url}medadv/ero_call_details" data-qr="output_position=content&amp;tool_code=mt_atnd_calls&amp;opt_id=<?php echo $data->operator_id; ?>&amp;sub_id=<?php echo $data->sub_id; ?>&amp;inc_ref_id=<?php echo $data->sub_id; ?>"><span style="color:white;"> <?php echo $data->sub_id; ?></span></a>
            </li>
        
    <?php
        }
    } 
     ?>

</ul>