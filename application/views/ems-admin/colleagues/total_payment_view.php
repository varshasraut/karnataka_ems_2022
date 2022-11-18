<?php
    $CI = GB_Controller::get_instance();
?>

<span><?php if(@$total_payment){echo $total_payment[0]->total_payment." Rs."; } ?></span>
<?=$CI->modules->get_tool_html('MT-CLG-PMNT-PAY',$CI->active_module,'form-xhttp-request float_right pay_button onpage_popup',"","data-popupwidth='700' data-popupheight='270'");?>
        