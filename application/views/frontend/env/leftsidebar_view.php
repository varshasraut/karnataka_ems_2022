<div class="navigation" >

  <ul>

    <?php 

if(is_array($modulebar)){

$cnt = 0;	

foreach($modulebar as $module_name => $module){

	?>

<li class="module_<?=$module_name?>" data-index="<?=$cnt++?>"> <?=$module?> <p class="unapproval_count" id="unapproved_module_count_<?=$module_name?>"><?php echo $unapproved_count[$module_name."_unapproved_count"]; ?></p></li>

    <?php }

}

 ?>

  </ul>

</div>

