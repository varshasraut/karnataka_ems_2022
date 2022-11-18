 

<select id="hp_dis" name="district" class="change-base-xhttp-request filter_required width_full" data-href="{base_url}auto/get_cty_view" data-qr="output_position=get_cities" data-base="ms_city" data-errors="{filter_required:'District should not be blank'}" <?php echo $view; ?> TABINDEX="9">

    
    
     <?php if($option=='') {  ?>
    
    
        <option value="" >Please select state to load district</option>
        <?php }else{ ?>
         <option value="" >Please select district</option>
         <?php }?>

    <?php echo $option;?>


</select>

 