
    <select name="ms_city" class="map_canvas change-base-xhttp-request controls width_full filter_required" data-qr="" data-errors="{filter_required:'City should not be blank'}" <?php echo $view;?>>
                
        <?php if($option=='') {  ?>
            
            <option value="">Please select tehsil to load city</option>
                    
        <?php }else{ ?>
                    
            <option value="" >Please select city</option>
            
        <?php }?>
            
        <?php echo $option;?>
                  
    </select>