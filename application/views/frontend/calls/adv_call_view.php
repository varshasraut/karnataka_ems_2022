
<a style="cursor: pointer" class="minimize_scroll_menu"><div class="head">ERO CALLS</div></a>
<ul class="incoming_calls">

    <?php
    if($ERO_data){
    foreach ($ERO_data as $data) {
        if ($data->sub_type == 'AMB_TO_ERC') {
            ?>

            <li>

                <a class="incoming_call_anchor click-xhttp-request" data-href="{base_url}ambercp/ercp_incoming_call" data-qr="output_position=content&amp;tool_code=mt_atnd_calls&amp;opt_id=<?php echo $data->operator_id; ?>&amp;sub_id=<?php echo $data->sub_id; ?>&amp;inc_ref_id=<?php echo $data->sub_id; ?>"><span style="color:white;"> <?php echo $data->sub_id; ?></span></a>
            </li>
    <?php }
        }
    }
    if($ERO_data_calls){
         foreach ($ERO_data_calls as $data) {
             //var_dump($data);
        ?>
             <li>

               <a class="incoming_call_anchor click-xhttp-request" data-href="{base_url}medadv/ero_call_details" data-qr="output_position=content&amp;tool_code=mt_atnd_calls&amp;opt_id=<?php echo $data->operator_id; ?>&amp;sub_id=<?php echo $data->sub_id; ?>&amp;inc_ref_id=<?php echo $data->sub_id; ?>"><span style="color:white;"> <?php echo $data->sub_id; ?></span></a>
            </li>
        
    <?php
        }
    } 
    if ($dco_ERO_data){
        foreach($dco_ERO_data as $data){
             //var_dump($data);
        ?>

            <li>

                <a class="incoming_call_anchor click-xhttp-request" data-href="{base_url}medadv/call_details" data-qr="output_position=content&amp;tool_code=mt_atnd_calls&amp;opt_id=<?php echo $data->operator_id; ?>&amp;sub_id=<?php echo $data->sub_id; ?>&amp;inc_ref_id=<?php echo $data->inc_ref_id; ?>"> <span style="color:white;"> <?php echo $data->inc_ref_id; ?></span></a>
            </li>

        <?php } } ?>

</ul>