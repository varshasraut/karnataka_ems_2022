 
<?php if($dt_rel =="hp_dtl") { ?>
    <input name="<?php echo $dt_rel; ?>_area" value="<?php echo $area; ?>" class="auto_area" data-base="" type="text" placeholder="Area/Location" tabindex="<?php echo $tab; ?>">

 <?php }else{ ?>
    <input name="<?php echo $dt_rel; ?>[area]" value="<?php echo $area; ?>" class="auto_area" data-base="" type="text" placeholder="Area/Location" tabindex="<?php echo $tab; ?>">

 <?php }?>
