
 <select id="select_users"  name="select_users" class="select_users_listing">
                        
                        <option value="" >Select Users</option>
                        
                        <?php if(count(@$sales_person)>0){
                        
                        foreach(@$sales_person as $value){  
                           
                            $sales_person_name = $value->clg_first_name . " ".$value->clg_last_name;
                          
                        ?>

                        <option data-href="{base_url}ms-admin/clg/daily_report_listing" class="form-xhttp-request" data-qr="output_position=daily_list_table&amp;clg_ref_id=<?php echo base64_encode($value->clg_ref_id);?>&amp;page_number=<?php echo @$page_number?>" value="<?php echo base64_encode($value->clg_ref_id); ?><?php //echo $sales_person_name; ?>"<?php echo $filter[$sales_person_name];?>><?php echo $sales_person_name; ?> </option>
                     
                        <?php }}?>    
                                    
 </select>
