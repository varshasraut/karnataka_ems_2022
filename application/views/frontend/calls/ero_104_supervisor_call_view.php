
<a style="cursor: pointer" class="minimize_scroll_menu"><div class="head">Incoming calls</div></a>
<ul class="incoming_calls">
    <li><a class="incoming_call_anchor click-xhttp-request" data-href="{base_url}calls/call_dialer" data-qr="output_position=content&amp;tool_code=mt_dialer&amp;module_name=calls&amp;showprocess=yes" >Dialer</a></li>

    <?php foreach ($ERO_data as $data) {?>

        <li>

            <a class="incoming_call_anchor click-xhttp-request" data-href="{base_url}ambercp/supervisor104_incoming_call" data-qr="output_position=content&amp;tool_code=mt_atnd_calls&amp;opt_id=<?php echo $data->operator_id; ?>&amp;sub_id=<?php echo $data->sub_id; ?>&amp;inc_ref_id=<?php echo $data->inc_ref_id; ?>"><span style="color:white;"> <?php echo $data->inc_ref_id; ?></span></a>
        </li>

    <?php } ?>

</ul>