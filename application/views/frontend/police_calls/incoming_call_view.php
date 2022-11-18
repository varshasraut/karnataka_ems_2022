
<a style="cursor: pointer" class="minimize_scroll_menu"><div class="head">Incoming Calls</div></a>
<ul class="incoming_calls">
<!--    <li><a class="incoming_call_anchor click-xhttp-request" data-href="{base_url}calls/atnd_cls?m_no=<?php echo $call_queue; ?>" data-qr="output_position=content&amp;tool_code=mt_atnd_calls&amp;module_name=calls&amp;showprocess=no"><?php echo $call_queue; ?></a></li>-->
    <li><a class="incoming_call_anchor click-xhttp-request" data-href="{base_url}calls/call_dialer" data-qr="output_position=content&amp;tool_code=mt_dialer&amp;module_name=calls&amp;showprocess=yes" >Dialer</a></li>
    <?php
    foreach($call_queue as $que){
    $call_queue = explode('_', $que);?>
    <li><a class="incoming_call_anchor click-xhttp-request" id="<?php echo $call_queue[0]; ?>" data-href="{base_url}calls/atnd_cls?inc_ref_no=<?php echo $call_queue[0]; ?>&amp;id=<?php echo $call_queue[1]; ?>" data-qr="output_position=content&amp;tool_code=mt_atnd_calls&amp;module_name=calls&amp;showprocess=yes" ><?php echo $call_queue[0]; ?></a></li>
    <?php } ?>
        
    

</ul>
<script>
    if( AUTO_CALL_PICKUP == 1 ){
        $('.incoming_calls .incoming_call_anchor').click();
    }
     $('.incoming_calls #<?php echo $last_inc_data;?>').click();
</script>