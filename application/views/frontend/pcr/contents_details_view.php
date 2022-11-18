
<div class="contents_details">
    
    <?php  $lng_array= get_lang();
    
    if(count($consent_info)>0){
        
         foreach($consent_info as $con_value){  
    
            $serialize_data = $con_value->cons_value;
            
            $data = nl2br(get_lang_data($serialize_data,$lng_array[$lang]));           
            
            ?>
            <p><?php echo str_replace("{amb_services}",@$amb_services[0]->ovalue,$data);?> </p>
    
    <?php } }?>
</div>