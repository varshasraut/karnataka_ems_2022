
<a style="cursor: pointer" class="minimize_scroll_menu"><div class="head">Incoming Calls</div></a>
<ul class="incoming_calls">

    <?php
    if($ERO_data){
    foreach ($ERO_data as $data) {

        if ($data->sub_type == 'AMB_TO_ERC') {
            ?>

            <li>

                <a class="incoming_call_anchor click-xhttp-request" data-href="{base_url}ambercp/ercp_incoming_call" data-qr="output_position=content&amp;tool_code=mt_atnd_calls&amp;opt_id=<?php echo $data->operator_id; ?>&amp;sub_id=<?php echo $data->sub_id; ?>&amp;inc_ref_id=<?php echo $data->inc_ref_id; ?>"><span style="color:white;"> <?php echo $data->inc_ref_id; ?></span></a>
            </li>
    <?php } else {
             if ($data->inc_type != 'IN_HO_P_TR' && $data->inc_type  != 'MCI' && $data->inc_type  != 'NON_MCI' && $data->inc_type  != 'AD_SUP_REQ' && $data->inc_type  != 'VIP_CALL' && $data->inc_type  != 'TRANS_PDA') {
                 continue;
             }
        ?>

            <li>

                <a class="incoming_call_anchor click-xhttp-request" data-href="{base_url}police_calls/police_call_details" data-qr="output_position=content&amp;tool_code=mt_atnd_calls&amp;opt_id=<?php echo $data->operator_id; ?>&amp;sub_id=<?php echo $data->sub_id; ?>"><span style="color:white;"> <?php echo $data->inc_ref_id; ?></span></a>
            </li>

    <?php }
    }
} ?>

</ul>