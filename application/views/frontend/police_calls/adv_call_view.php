
<a style="cursor: pointer" class="minimize_scroll_menu"><div class="head">ERO CALLS</div></a>
<ul class="incoming_calls">

    <?php foreach ($ERO_data as $data) { ?>

        <li>

            <a class="incoming_call_anchor click-xhttp-request" data-href="{base_url}medadv/call_details" data-qr="output_position=content&amp;tool_code=mt_atnd_calls&amp;opt_id=<?php echo $data->operator_id; ?>&amp;sub_id=<?php echo $data->sub_id; ?>"><?php echo $data->operator_id; ?> <span> [<?php echo $data->adv_inc_ref_id; ?>]</span></a>
        </li>

    <?php } ?>

</ul>