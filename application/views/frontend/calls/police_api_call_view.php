<a style="cursor: pointer" class="minimize_scroll_menu_pda"><div class="head">PDA API Calls</div></a>
<ul class="incoming_calls">

    <?php if($ERO_data){
        foreach ($ERO_data as $data) { ?>

            <li>

                <a class="incoming_call_anchor click-xhttp-request" data-href="{base_url}police_calls/api_police_call_details" data-qr="output_position=content&amp;tool_code=mt_atnd_calls&amp;opt_id=<?php echo $data->asign_pda; ?>&amp;sub_id=<?php echo $data->emg_cad_inc_id; ?>"><span style="color:white;"> <?php echo $data->emg_cad_inc_id; ?></span></a>
            </li>

    <?php } } ?>

</ul>