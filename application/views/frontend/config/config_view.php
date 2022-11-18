<script>
    
        initAutocomplete();

</script>


<?php
$setting_checked = array('off' => '', 'on' => 'checked="checked"');



$address_details = unserialize($result["ms_admin_address"]);
$pay_live_setting = unserialize($result["pay_live_setting"]);
$pay_test_setting = unserialize($result["pay_test_setting"]);
$adv_price_setting = unserialize($result["adv_price_setting"]);
$subscription_med_setting=  unserialize($result["subscription_med_setting"]);
$subscription_sms_setting=  unserialize($result["subscription_sms_setting"]);
$subscription_start_date=   unserialize($result["subscription_start_date"]);
$sms_pack_setting=unserialize($result["sms_pack_setting"]);
$service_tax_setting=unserialize($result["service_tax_setting"]);
$msg_setting=unserialize($result["msg_setting"]);
$allow_permission_setting=unserialize($result["allow_permission_setting"]);

$store_reg_cond=unserialize($result["store_reg_cond"]);

$str_con[$store_reg_cond['reg_store_con']]="checked='checked'";


?>
<div class="breadcrumb">
    <ul>
        <li class="setting"><a href="{base_url}ms-admin/setting/config">Setting</a></li>
        <li><span>Config</span></li>
    </ul>
</div>
<br/>
<div class="box3 config_box">
    <div class="config_block">
        <h3 class="txt_clr5"> Config</h3>

        <form method="post" action="#" class="">

            <div class="box4 general personal_details">
                <h4>General Setting:</h4>
               
                <div class="width2 float_left">
               
                <table>
                    
                    <tr>
                        <td>Site down for maintenance :  </td>
                        <td><input type="checkbox" name="setting[ms_site_down_for_maintance]" <?php echo $setting_checked[$result['ms_site_down_for_maintance']] ?>></td>
                    </tr>
                    
                    <tr>
                        <td>Stop contact details sharing on site : </td>
                        <td>  <input type="checkbox" name="setting[ms_stop_contact_details_sharing_on_site]" <?php echo $setting_checked[$result['ms_stop_contact_details_sharing_on_site']] ?>></td>
                    </tr>
                  
                    <tr>
                        <td>Email id for user profile :</td>
                        <td>  <input type="text" name="setting[ms_email_id_for_user_profile]" value="<?php echo $result['ms_email_id_for_user_profile'] ?>" class="filter_required filter_email"  data-errors="{filter_required:'user profile email should not be blank', filter_email:'please enter a valid email'}">
                        </td>
                        
                    </tr>
                    
                    <tr>
                        <td>Email id for OTP :</td>
                        <td>  <input type="text" name="setting[ms_email_id_for_otp]" value="<?php echo $result['ms_email_id_for_otp'] ?>" class="filter_required filter_email"  data-errors="{filter_required:'OTP email should not be blank', filter_email:'please enter a valid email'}"></td>
                        
                    </tr>
                    
                    

                </table>
                    
                </div>     
                
                <div class="width2 float_left">
                    
                       <table>
                    
                        <tr>
                            <td>Allow user registration :  </td>
                            <td><input type="checkbox" name="setting[allow_permission_setting][user_reg]" <?php echo $setting_checked[$allow_permission_setting['user_reg']] ?>></td>
                        </tr>

                        <tr>
                            <td>Allow store registration : </td>
                            <td>  <input type="checkbox" name="setting[allow_permission_setting][store_reg]" <?php echo $setting_checked[$allow_permission_setting['store_reg']] ?>></td>
                        </tr>
                        
                        <tr>
                            <td>Allow advertiser registration :</td>
                            <td><input type="checkbox" name="setting[allow_permission_setting][adv_reg]" <?php echo $setting_checked[$allow_permission_setting['adv_reg']] ?>></td>
                        </tr>
                        
                         <tr>
                            <td>Allow medicine searching for all end user :</td>
                            <td><input type="checkbox" name="setting[allow_permission_setting][med_search_end_user]" <?php echo $setting_checked[$allow_permission_setting['med_search_end_user']] ?>></td>
                        </tr>
                        
                        <tr>
                            <td>Allow medicine searching for registered user :</td>
                            <td><input type="checkbox" name="setting[allow_permission_setting][med_search_reg_user]" <?php echo $setting_checked[$allow_permission_setting['med_search_reg_user']] ?>></td>
                        </tr>
                        
                        
<!--                        <tr>
                            <td>Activation store joining session :</td>
                            <td><input type="checkbox" name="setting[allow_permission_setting][active_store_join]" <?php //echo  $setting_checked[$allow_permission_setting['active_store_join']] ?>></td>
                        </tr>-->
                        
                        
                        
                        <tr>
                            <td>Registration with subscription :</td>
                            <td><input type="radio" name="setting[store_reg_cond][reg_store_con]" value="reg_sub" <?php echo $str_con['reg_sub']; ?>></td>
                        </tr>
                        
                        <tr>
                            <td>Registration session without subscription :</td>
                            <td><input type="radio" name="setting[store_reg_cond][reg_store_con]" value="reg_sess" <?php echo $str_con['reg_sess']; ?>></td>
                        </tr>
                        
                         <tr>
                            <td>Registration with post date subscription :</td>
                            <td><input type="radio" name="setting[store_reg_cond][reg_store_con]" value="post_sub" <?php echo $str_con['post_sub']; ?>></td>
                        </tr>
                        
                          <tr>
                            <td>Subscription start date: </td>
                            <td>
                            
                            <input type="text"  name="setting[subscription_start_date][sub_start_date]" value="<?php echo $subscription_start_date['sub_start_date']; ?>" class="mi_calender">
                            
                            
                            </td>
                        </tr>
                        
                        
                        
                        <tr>
                            <td>User registration block message :</td>
                            <td>
                                <input type="text" name="setting[msg_setting][user_msg]" value="<?php echo $msg_setting['user_msg'] ?>" class=""  data-errors="">
                            </td>
                            
                        </tr>
                        
                        <tr>
                            <td>Store registration block message :</td>
                            <td>
                            <input type="text" name="setting[msg_setting][store_msg]" value="<?php echo $msg_setting['store_msg'] ?>" class=""  data-errors="">
                            </td>
                            
                        </tr>
                        
                        <tr>
                            <td>Advertiser registration block message :</td>
                            <td>
                                <input type="text" name="setting[msg_setting][adv_msg]" value="<?php echo $msg_setting['adv_msg'] ?>" class=""  data-errors="">
                            </td>
                            
                        </tr>
                 

                    </table>
                    
                </div>
                    
            </div>

   
            
            <div class="payment_container_outer">
              <div class="box4 general payment_container">
                  
                <h4> PayUMoney Setting:</h4>
               
                    <?php
                                    
                            $filter[$result['pay_mode']] = "checked";
                    ?>
                
                     <div class="width2 pay_mode float_left">
                  
                   <table>
                   
                    
                        <tr>
                            <td><input type="radio" name="setting[pay_mode]" value="live" <?php echo $filter['live'];?>> Live</td>
                        </tr>

                        <tr>
                            <td>Live url: </td>
                            <td><input type="text" name="setting[pay_live_setting][live_url]" value="<?php echo $pay_live_setting['live_url'] ?>"></td>
                        </tr>

                        <tr>
                            <td>Merchant id: </td>
                            <td><input type="text" name="setting[pay_live_setting][live_merchant_id]" value="<?php echo $pay_live_setting['live_merchant_id'] ?>"></td>
                        </tr>

                        <tr>
                            <td>Live key: </td>
                            <td><input type="text" name="setting[pay_live_setting][live_key]" value="<?php echo $pay_live_setting['live_key'] ?>"></td>
                        </tr>
                    
                </table>
                   
             </div>
                
                <div class="width2 pay_mode float_right">
                 
                       
                <table>
                      
                    <tr>
                        <td><input type="radio" name="setting[pay_mode]" value="test" <?php echo $filter['test'];?>> Test</td>
                    </tr>

                    <tr>
                        <td>Test url: </td>
                        <td><input type="text" name="setting[pay_test_setting][test_url]" value="<?php echo $pay_test_setting['test_url'] ?>"></td>
                    </tr>

                    <tr>
                        <td>Merchant id: </td>
                        <td><input type="text" name="setting[pay_test_setting][test_merchant_id]" value="<?php echo $pay_test_setting['test_merchant_id'] ?>"></td>
                    </tr>

                    <tr>
                        <td>Test key: </td>
                        <td><input type="text" name="setting[pay_test_setting][test_key]" value="<?php echo $pay_test_setting['test_key'] ?>" ></td>
                    </tr>
                
                </table>
                
                </div>
        
             </div>
                 
            </div>
            
            
            

            <div class="payment_container_outer">
                <div class="box4 general payment_container">
                <h4>Address Setting:</h4>
                <table>
                    <tr>
                        <td>Flat No./House No: </td>
                        <td><input type="text" name="setting[ms_admin_address][ms_flat_house_no]" value="<?php echo $address_details['ms_flat_house_no'] ?>" class="filter_required filter_string"  data-errors="{filter_required:'Should not be blank', filter_string:'Special characters are not allowed'}"></td>
                    </tr>
                    <tr>
                        <td>House name: </td>
                        <td><input type="text" name="setting[ms_admin_address][ms_house_aparment_hotel_name]" value="<?php echo $address_details['ms_house_aparment_hotel_name'] ?>" class="filter_required filter_string"  data-errors="{filter_required:'Should not be blank', filter_string:'Special characters are not allowed'}"></td>
                    </tr>
                    <tr>
                        <td>Ward/Area: </td>
                        <td><input type="text" name="setting[ms_admin_address][ms_ward_area]" value="<?php echo $address_details['ms_ward_area'] ?>" class="filter_required filter_string"  data-errors="{filter_required:'Should not be blank', filter_string:'Special characters are not allowed'}"></td>
                    </tr>
                    <tr>
                        <td>Landmark: </td>
                        <td><input type="text" name="setting[ms_admin_address][ms_landmark]" value="<?php echo $address_details['ms_landmark'] ?>" class="filter_required filter_string"  data-errors="{filter_required:'Should not be blank', filter_string:'Special characters are not allowed'}"></td>
                    </tr>
                    <tr>
                        <td>Colony/Society: </td>
                        <td><input type="text" name="setting[ms_admin_address][ms_colony_society]" value="<?php echo $address_details['ms_colony_society'] ?>" class="filter_required filter_string"  data-errors="{filter_required:'Should not be blank', filter_string:'Special characters are not allowed'}"></td>
                    </tr>
                    <tr>
                        <td>Street: </td>
                        <td><input type="text" name="setting[ms_admin_address][ms_street]" value="<?php echo $address_details['ms_street'] ?>" class="filter_required filter_string"  data-errors="{filter_required:'Should not be blank', filter_string:'Special characters are not allowed'}"></td>
                    </tr>
                    <tr>
                        <td>Suburb: </td>
                        <td><input type="text" name="setting[ms_admin_address][ms_suburb]" value="<?php echo $address_details['ms_suburb'] ?>" class="filter_required filter_string"  data-errors="{filter_required:'Should not be blank', filter_string:'Special characters are not allowed'}"></td>
                    </tr>
                    <tr>
                        <td>Primary Mobile No: </td>
                        <td><input type="text" name="setting[ms_admin_address][ms_primary_mobile_no]" value="<?php echo $address_details['ms_primary_mobile_no'] ?>" class="filter_required filter_string"  data-errors="{filter_required:'Should not be blank', filter_string:'Special characters are not allowed'}"></td>
                    </tr>
                    <tr>
                        <td>City: </td>
                        <td><input type="text" name="setting[ms_admin_address][ms_city]" value="<?php echo $address_details['ms_city'] ?>" class="filter_required filter_string"  data-errors="{filter_required:'Should not be blank', filter_string:'Special characters are not allowed'}"></td>
                    </tr>
                </table>
            </div>
            </div>
            
            
            
            
            <div class="adv_setting_container_outer">
              <div class="box4 general adv_setting_container">
                  
                <h4> Advertise Setting:</h4>
               
                    <?php
                                    
                            $filter[$result['pay_mode']] = "checked";
                    ?>
                
                     <div class="width2 setting float_left">
                  
                   <table>
                   
                    
                        <tr>
                            <td class="adv_type">Advertise type - Image  </td>
                        </tr>

                        <tr>
                            <td>Price per click: </td>
                            <td>
                               
                                
                          <input type="text"  name="setting[adv_price_setting][per_img_click]" value="<?php echo $adv_price_setting['per_img_click']; ?>" class="filter_required filter_number filter_greater_than_zero" data-errors="{filter_required:'Should not be blank', filter_number:'Only number allowed',filter_greater_than_zero:'Price should greater than zero'}">           
                                
                            </td>
                        </tr>

                        <tr>
                            <td>Price per visit: </td>
                            <td>
                                
                <input type="text"  name="setting[adv_price_setting][per_img_visit]" value="<?php echo $adv_price_setting['per_img_visit']; ?>" class="filter_required filter_number filter_greater_than_zero" data-errors="{filter_required:'Should not be blank', filter_number:'Only number allowed',filter_greater_than_zero:'Price should greater than zero'}">
                                
                            </td>
                        </tr>

                       
                </table>
                   
             </div>
                
                <div class="width2 setting float_right">
                 
                       
                            
                    
                <table>
                      
                    <tr>
                        <td class="adv_type"> Advertise type - Video  </td>
                    </tr>
                        
                      
                        <tr>
                            <td>Price per visit: </td>
                            <td>
                            
                            <input type="text"  name="setting[adv_price_setting][per_vid_visit]" value="<?php echo $adv_price_setting['per_vid_visit']; ?>" class="filter_required filter_number filter_greater_than_zero" data-errors="{filter_required:'Should not be blank', filter_nuber:'Only numbers allowed',filter_greater_than_zero:'Price should greater than zero'}">
                            
                            
                            </td>
                        </tr>
                
                
                </table>
                
                </div>
        
             </div>
                 
            </div>
            
            
            <div class="sub_setting_container_outer">
                
                <div class="box4 general sub_setting_container">

                <h4> Subscription Setting:</h4>

                <div class="width2 setting float_left">
                  
                   <table>
                   
                    
                        <tr>
                            <td class="adv_type">Select number of medicine for plan</td>
                        </tr>

                       <?php  
                
                        if(@$sub_plan_details){
                            
                            
                           
                            foreach($sub_plan_details as $sub){ 
                    
                                
                                
                               $filter1=array();
                               $filter1[$subscription_med_setting[$sub->sub_token]]="selected='selected'";
                       
                           
                               
                      ?>
                         <!--<option value="1000" <?php // echo $filter1['1000'];?> >1000</option>-->
                        <tr>
                            <td><?php echo $sub->sub_name; ?>: </td>
                            <td>
                                <select name="setting[subscription_med_setting][<?php echo $sub->sub_token;?>]">
                                <?php     $count=1000; $cnt=1;
                                 
                                 
                                 while($cnt<=10){ ?>
                               
                                    <option value="<?php echo $count*$cnt;?>"<?php echo $filter1[$count*$cnt];?> ><?php echo $count*$cnt; ?></option>
                                   <?php $cnt++;   } ?>
                                    
                                      <option value="unlimited" <?php echo $filter1['unlimited'];?>>unlimited</option>
                              
                     
                          
                                </select> 
                            </td>
                        </tr>
                        
                   
                        <?php
                            
                            }
                        }
                     ?>  
                        
                        
                      
                        
                        
      
                    </table>
                   
                </div>
                
                
                  <div class="width2 setting float_left">
                  
                   <table>
                   
                    
                        <tr>
                            <td class="adv_type">Select number of sms for plan  </td>
                        </tr>

                      <?php  
                
                        if(@$sub_plan_details){
                            
                            foreach($sub_plan_details as $sub){  
                               
                               $filter2=array();
                               $filter2[$subscription_sms_setting[$sub->sub_token]]="selected='selected'";
                                
                      ?>
                        
                        <tr>
                            <td><?php echo $sub->sub_name; ?>: </td>
                            <td>
                                
                                <select name="setting[subscription_sms_setting][<?php echo $sub->sub_token;?>]">
                                    <option value="100" <?php echo $filter2['100'];?>>100</option>
                                    <option value="500" <?php echo $filter2['500'];?>>500</option>
                                    <option value="1000" <?php echo $filter2['1000'];?>>1000</option>
                                    <option value="10000" <?php echo $filter2['10000'];?>>10000</option>
                                </select>
                                
                            </td>
                        </tr>
                        
                     <?php
                     
                        }
                        
                        }
                     ?>  
      
                    </table>
                   
                </div>
                    
                          

               </div>
                 
            </div>
            
            
            
             <div class="sms_pack_setting_container_outer">
              <div class="box4 general sms_pack_setting_container">
                  
                <h4> SMS pack Setting:</h4>
               
                    <div class="width2 setting float_left">
                  
                    <table>
                  
                        <tr>
                            <td> 100 SMS pack price per sms: </td>
                            <td>
                               
                                
                          <input type="text"  name="setting[sms_pack_setting][100_sms_pack]" value="<?php echo $sms_pack_setting['100_sms_pack']; ?>" class="filter_required filter_number filter_greater_than_zero" data-errors="{filter_required:'Should not be blank', filter_number:'Only number allowed',filter_greater_than_zero:'Price should greater than zero'}">           
                                
                            </td>
                        </tr>
                        
                        <tr>
                            <td> 200 SMS pack price per sms : </td>
                            <td>
                               
                                
                          <input type="text"  name="setting[sms_pack_setting][200_sms_pack]" value="<?php echo $sms_pack_setting['200_sms_pack']; ?>" class="filter_required filter_number filter_greater_than_zero" data-errors="{filter_required:'Should not be blank', filter_number:'Only number allowed',filter_greater_than_zero:'Price should greater than zero'}">           
                                
                            </td>
                        </tr>
                        
                        <tr>
                            <td> 500 SMS pack price per sms : </td>
                            <td>
                               
                                
                          <input type="text"  name="setting[sms_pack_setting][500_sms_pack]" value="<?php echo $sms_pack_setting['500_sms_pack']; ?>" class="filter_required filter_number filter_greater_than_zero" data-errors="{filter_required:'Should not be blank', filter_number:'Only number allowed',filter_greater_than_zero:'Price should greater than zero'}">           
                                
                            </td>
                        </tr>
                        
                        <tr>
                            <td> 1000 SMS pack price per sms : </td>
                            <td>
                               
                                
                          <input type="text"  name="setting[sms_pack_setting][1000_sms_pack]" value="<?php echo $sms_pack_setting['1000_sms_pack']; ?>" class="filter_required filter_number filter_greater_than_zero" data-errors="{filter_required:'Should not be blank', filter_number:'Only number allowed',filter_greater_than_zero:'Price should greater than zero'}">           
                                
                            </td>
                        </tr>

              
                    </table>
                   
                </div>
                
             </div>
                 
            </div>
            
            
              <div class="txt_setting_container_outer">
                
                <div class="box4 general tax_setting_container">

                  <h4> GST Setting:</h4>

                      <div class="width2 setting float_left">

                        <table>
                            
                            <tr>
                                <td>GST(in %): </td>
                                <td>

                              <input type="text"  name="setting[service_tax_setting][service_tax]" value="<?php echo $service_tax_setting['service_tax']; ?>" class="filter_required filter_number filter_greater_than_zero" data-errors="{filter_required:'Should not be blank',filter_nuber:'Only numbers allowed',filter_greater_than_zero:'Tax should greater than zero'}">           

                                </td>
                            </tr>
                            
                            
                        </table>
                         
                      </div>

               </div>
                 
            </div>
            
            
            
             <div class="block_city_setting_container_outer">
              
              <div class="box4 general block_city_setting_container">
                  
                     <h4> Block Cities Setting:</h4>
                  
                   <div class="add_city_box_container">
                     
                       
                    <?php 
                    
              
                    
                        if(count(@$blocked_cities)>0){
                            
                            $cnt=0;
                            
                            foreach($blocked_cities as $city){
                                
                                
                                if($cnt%2==0){
                     ?>
                       
                       
                                <div class="width2 float_left text_align_center blk_city">

                                 <input type="text" id="pac-input" name="setting[block_cities][]"  class="controls" value="<?php echo $city;?>"    placeholder="Enter City">

                                 <a href="{base_url}ms-admin/setting/remove_blocked_city"  class="click-xhttp-request delete_img"  data-confirm="yes" data-confirmmessage="Are you sure to remove this city?" data-qr="city_name=<?php echo $city;?>"></a>


                              </div>
                       
                                <?php }else{ ?>
                     
                                <div class="width2 float_left text_align_center blk_city">

                                  <input type="text" id="pac-input" name="setting[block_cities][]"  value="<?php echo $city;?>" class="controls" placeholder="Enter City">   

                                  <a href="{base_url}ms-admin/setting/remove_blocked_city"  class="click-xhttp-request delete_img"  data-confirm="yes" data-confirmmessage="Are you sure to remove this city?" data-qr="city_name=<?php echo $city;?>"></a>


                               </div>
                       
                                <?php }
                                
                                $cnt++;
                            
                            }
                            
                            if(count($blocked_cities)%2!=0){
                                
                    ?>            
                                
                          <div class="width2 float_left text_align_center blk_city">
                     
                        <input type="text" id="pac-input"  name="setting[block_cities][]"  class="controls" value="" data-href="" placeholder="Enter City">   
                    
                        <a class="delete_img"></a>
                        
                     
                          </div>
                       
                       
                                
                    <?php        }
                        }
                        else{
                    ?>   
                       
                     <div class="width2 float_left text_align_center blk_city">
                     
                        <input type="text" id="pac-input" name="setting[block_cities][]"  class="controls" value="" data-href=""  placeholder="Enter City">  
                        
                        <a class="delete_img"></a>
                        
                     
                     </div>
                     
                      <div class="width2 float_left text_align_center blk_city">
                     
                        <input type="text" id="pac-input" name="setting[block_cities][]"  class="controls" value="" data-href=""  placeholder="Enter City"> 
                    
                        <a class="delete_img"></a>
                        
                        
                     </div>
                       
                        <?php } ?>   
                   
                   </div>
            
                      <div class="width1 float_right add_more_option">
                         <a class="float_right add_more_cities">Add more cities</a>
                     </div>
                         
                  
              </div>
                    
             </div>
                 
            
            <div class="config_button">
                <input type="hidden" name="submit_setting" value="submit_setting" />
                <input type="button" name="submit_setting" id="btnsave" value="Save" class="btn submit_btn form-xhttp-request" data-href="{base_url}ms-admin/setting/config" data-qr="output_position=content&amp;module_name=setting&amp;tlcode=MT-SET-CONFIG">
            </div>
        </form>
    </div>
</div>



</div>

