<?php  
 
   //  $filter=array(); if(@$users_type!=''){ $filter[$users_type['clg_first_name']." ".$users_type['clg_last_name']]="selected=selected";  }
    
?>         

<select id="select_users"  name="select_users" class="select_users_listing">

    <option value="">Select Users</option>

        <?php  
        if(count(@$all_users) > 0){
            foreach($all_users as $value){ 
                
                $sales_person_name = $value->clg_first_name. " ".$value->clg_last_name;
              
           ?>
                     
                <option data-href="{base_url}ms-admin/clg/report_list" class="form-xhttp-request" data-qr="output_position=list_table&amp;report_date_filter='true'&amp;page_number=<?php echo @$page_number?>&amp;<?php if(@$visit_report=='true'){?>users=visit<?php }else{?>users=daily<?php }?>" value="<?php echo base64_encode($value->clg_ref_id); ?>"<?php echo $filter[$sales_person_name];?>><?php echo $sales_person_name; ?> </option>


       <?php }}?>    

</select>