
<?php if($steps_cnt>0){$width=(1/$steps_cnt)*100;}?>

<div class="width100 float_left">

    <div class="progress_bar" id="pcr_progress_bar">

        <?php for ($cnt = 1; $cnt <= $steps_cnt; $cnt++) { ?>

        <div class="step" style="width:<?php echo $width;?>%;background:<?php echo ($step_com_cnt>0)?'#3fdc54':''; ?>" id="pcr_step_<?php echo $cnt; ?>">
            
            <span><?php echo ($step_com_cnt>0)?($cnt*10).'%':''; ?></span></div>

        <?php $step_com_cnt--; } ?>

    </div>

</div>