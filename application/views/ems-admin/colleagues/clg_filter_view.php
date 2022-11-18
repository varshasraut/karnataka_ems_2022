<?php $CI = EMS_Controller::get_instance(); 

?>

<div class="filters_groups">                   

    <div class="search">
         <div class="row list_actions clg_filt">
             
             <div class="group_action_field_btns">

                
                <?php if($CI->modules->get_tool_config('MT-CLG-ACTION-MULTI',$this->active_module,true)!=''){ ?>  

                <input type="button" name="Delete" value="Delete" id="del_clg" class="btn form-xhttp-request" data-href="{base_url}clg/delete_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action=delete&amp;page_no=<?php echo @$page_no;?>" data-confirm='yes' data-confirmmessage="Are you sure to delete colleagues?">

                <?php } ?>



                

             </div>

            <div class="grp_actions_width">
                
                <div class="group_action_field">
                    
                    
                    <select id="filter_dropdown"  name="clg_status" class="list_medicines change-xhttp-request float_right" data-href="{base_url}clg/colleagues" data-qr="output_position=content&amp;flt=true">
                   
                    <option value="" selected="">Select Status</option>
                   
                    <?php echo get_clg_status(@$clg_status); ?>
                   
                   </select>
                    
                    
                </div>
                
                <div class="group_action_field">
                    <select id="Order_by_dropdwn" name="order_clg_by">
                        <?php if(@$order_by){
                                $selected[$order_by] = "selected=selected";
                            }  
                            
                            
                        ?>

                        <option value="">Select Order By</option>

                        <optgroup label="Ascending Order">


                            <option value="asc_clg_first_name" <?php echo $selected['asc_clg_first_name'];?>  class="form-xhttp-request" data-href="{base_url}clg/colleagues" data-qr="output_position=content&amp;filter_order_by=order_by&amp;module_name=clg&amp;tlcode=MT-CLG-ORDER-LIST&clg_data="<?php echo $data; ?>>By First Name</option>

                            <option value="asc_clg_last_name" <?php echo $selected['asc_clg_last_name'];?>  class="form-xhttp-request" data-href="{base_url}clg/colleagues" data-qr="output_position=content&amp;filter_order_by=order_by&amp;module_name=clg&amp;tlcode=MT-CLG-ORDER-LIST">By Last Name</option>

                            <option value="asc_clg_group" <?php echo $selected['asc_clg_group'];?>  class="form-xhttp-request" data-href="{base_url}clg/colleagues" data-qr="output_position=content&amp;filter_order_by=order_by&amp;module_name=colleagues&amp;tlcode=MT-CLG-ORDER-LIST">By Group</option>
                            
                            <option value="asc_clg_joining_date" <?php echo $selected['asc_clg_joining_date'];?> class="form-xhttp-request" data-href="{base_url}clg/colleagues" data-qr="output_position=content&amp;filter_order_by=order_by&amp;module_name=clg&amp;tlcode=MT-CLG-ORDER-LIST">By Joining Date</option>



                        </optgroup>



                        <optgroup label="Descending Order">


                            <option value="desc_clg_first_name" <?php echo $selected['desc_clg_first_name'];?> class="form-xhttp-request" data-href="{base_url}clg/colleagues" data-qr="output_position=content&amp;filter_order_by=order_by&amp;module_name=clg&amp;tlcode=MT-CLG-ORDER-LIST">By First Name</option>

                            <option value="desc_clg_last_name" <?php echo $selected['desc_clg_last_name'];?> class="form-xhttp-request" data-href="{base_url}clg/colleagues" data-qr="output_position=content&amp;filter_order_by=order_by&amp;module_name=clg&amp;tlcode=MT-CLG-ORDER-LIST">By Last Name</option>

                            <option value="desc_clg_group"  <?php echo $selected['desc_clg_group'];?> class="form-xhttp-request" data-href="{base_url}clg/colleagues" data-qr="output_position=content&amp;filter_order_by=order_by&amp;module_name=clg&amp;tlcode=MT-CLG-ORDER-LIST">By Group</option>
                            
                            <option value="desc_clg_joining_date" <?php echo $selected['desc_clg_joining_date'];?> class="form-xhttp-request" data-href="{base_url}clg/colleagues" data-qr="output_position=content&amp;filter_order_by=order_by&amp;module_name=clg&amp;tlcode=MT-CLG-ORDER-LIST">By Joining Date</option>



                        </optgroup>



                    </select>



                </div>



                <div class="group_action_field">

                    
                   

            <select id="filter_dropdown"  name="clg_group" class="order_by_box" >

                        

                    <?php
                    
                       
                         
                        if(@$clg_group){

                            

                            $selected_filter[$clg_group] =  "selected=selected";

                         

                        }
                    

                    ?>

                        <option value="" >Select Group</option>
                        <?php
                          foreach(@$users as $group)
                           {
                             
                         ?>
                           
                       
                         <option value="<?php echo $group->gcode;?>" class="form-xhttp-request" data-href="{base_url}clg/colleagues" <?php echo $selected_filter[$group->gcode]; ?> data-qr="output_position=content&amp;filter_clg_group=clg_group&amp;module_name=clg&amp;tlcode=MT-CLG-ORDER-LIST" ><?php echo $group->ugname;?></option>
                                                    
                         <?php
                         
                           }
                           
                           ?>
                        
                        
                    </select>



                </div>







                <div class="srch_box">



                    <input type="text" id="search_clg" placeholder="Search" value="<?php echo @$search;?>" name="search">



                    <label for="search_clg">



                        <input type="button" name="search_btn" value="Search" class="btn clg_search form-xhttp-request" data-href="{base_url}clg/colleagues" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" >



                    </label>



                </div>



            </div>
             
            

            

            

        </div>
        
            
    </div>

</div>

      