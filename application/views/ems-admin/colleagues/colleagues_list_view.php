<?php

$CI = EMS_Controller::get_instance();
$green = array();

$green[$CI->session->userdata('current_user')->clg_ref_id]="green";

//       $arr=array(
//                       'page_no'=>@$page_no,
//                       'page_records'=>@$page_records,
//                       'order_clg_by'=>@$order_by,
//                       'clg_group'=>@$clg_group,
//                       'search'=>@$search
//                 );
//       
//       
//                    $data=json_encode($arr);
//                    $data=base64_encode($data);
// 
  

?>
<div class="width1">
<div class="breadcrumb float_left">
  <ul>
    <li class="colleague"><a href="#">Colleagues</a></li>
    <li><span>Colleagues List</span></li>
  </ul>
</div>
          <div class="width2 float_right">
               <input class="add_button_amb onpage_popup float_right" name="add_amb" value="Register Colleagues" data-href="{base_url}Clg/registration" data-qr="output_position=popup_div&amp;tool_code=mt_clg_add&amp;module_name=clg" type="button" data-popupwidth="1000" data-popupheight="800"> 
           
            
         </div>
 </div>
<br/>
<div class="box3 colleagues_list">
 <div id="sales_earning_list"></div>
  
    <form method="post" action="#" name="colleagues_list_form" class="colleagues_list_form">  
        
        <input type="hidden" name="page_no" value="<?php echo @$page_no; ?>">
        <div class="row list_actions">

            <h2>Group Actions:</h2>

            <div class="group_action_field_btns">

                
                <?php if($CI->modules->get_tool_config('MT-CLG-ACTION-MULTI',$this->active_module,true)!=''){ ?>  

                <input type="button" name="Delete" value="Delete" id="del_clg" class="btn change-base-xhttp-request" data-href="{base_url}clg/update_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action=delete&amp;page_no=<?php echo @$page_no;?>" data-confirm='yes' data-confirmmessage="Are you sure to delete colleagues?">

                <?php } ?>



                <?php if($CI->modules->get_tool_config('MT-CLG-BLOCK',$this->active_module,true)!=''){ ?>  
                
                    <input type="button" name="Block" value="Block" id="block_clg" class="btn change-base-xhttp-request" data-href="{base_url}clg/update_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action=block" data-confirm='yes' data-confirmmessage="Are you sure to block this colleagues?" >
                
                <?php } ?>
                


                <?php if($CI->modules->get_tool_config('MT-CLG-UNBLOCK',$this->active_module,true)!=''){ ?>  
                    <input type="button" name="Unblock" value="Unblock" id="unblock_clg" class="btn change-base-xhttp-request" data-href="{base_url}clg/update_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action=unblock"  data-confirm='yes' data-confirmmessage="Are you sure to unblock this colleagues?">

                <?php } ?>
                

            </div>

            <div class="grp_actions_width">
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
        
         <div id="colleague_search_id">

             
             
        <?php

        

        $i = 0;

        

        if(@$colleagues == null){

            ?>

        <div class="txt_clr5">

            No More Records...

        </div>

                <?php

        }

        
        
        foreach ($colleagues as $colleague) {

            ?>

        <div class="colleague_profile_box">

            

            <div class="clg_profile_background">

                

                <div class="clg_profile_back_img"></div>

                               

                

            </div>

            

            <div class="clg_triangle_box"></div>

                

                <input type="checkbox" data-base="del_clg block_clg unblock_clg" name="ref_id[<?= $colleague->clg_ref_id; ?>]" value="<?=$colleague->clg_ref_id?>" >

                

            <div class="clg_group_name">

                

                

                <br/>

                <?php

                echo $colleague->clg_group;

            ?>

            </div>

                

                

                <div class="colleagues_profile_actions_div">

                    

                </div>

                    <ul class="profile_actions_list">
<?php if($CI->modules->get_tool_config('MT-CLG-VIEW',$this->active_module,true)!=''){ ?>  
                        <li>
 
                            <a class="onpage_popup action_button" data-href="{base_url}clg/profile" data-qr="output_position=popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-VIEW&amp;ref_id=<?php echo $colleague->clg_ref_id; ?>&amp;action=view_profile" data-popupwidth="900" data-popupheight="850">

                    View</a>
               

                        </li>
<?php } ?>
                        <?php if($CI->modules->get_tool_config('MT-CLG-EDIT',$this->active_module,true)!='' ||  $CI->session->userdata('current_user')->clg_ref_id == $colleague->clg_ref_id ){ ?>  
                        <li>

                            <a class="change-base-xhttp-request action_button" data-href="{base_url}clg/update_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-EDIT&amp;ref_id=<?php echo $colleague->clg_ref_id?>&amp;action=edit_data&amp;page_no=<?php echo @$page_no;?>" name="<?php echo $colleague->clg_ref_id;?>">

                    Edit</a>
                         

                        </li>
                        <?php } ?>

                        <?php if(($CI->modules->get_tool_config('MT-CLG-PASSWORD',$this->active_module,true)!='' && $CI->session->userdata('current_user')->clg_ref_id == $colleague->clg_ref_id ) || $CI->modules->get_tool_config('MT-CLG-CHNG-PWD',$this->active_module,true)!=''){ ?>  
                        <li>

                            <a class="onpage_popup action_button" data-href="{base_url}clg/update_clg" data-qr="output_position=popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-UPDATE&amp;ref_id=<?php echo $colleague->clg_ref_id?>&amp;action=change_password" data-popupwidth="480" data-popupheight="400">

                    Password</a>
             
                        </li>
                        <?php } ?>

                        <?php if($CI->modules->get_tool_config('MT-CLG-UPDATE',$this->active_module,true)!=''){ ?>  
                        <li>

                            <?php



                                if(!$colleague->clg_is_active){

                                    ?>



                                        <a class="change-base-xhttp-request action_button" name="<?php echo $colleague->clg_ref_id;?>" data-href="{base_url}clg/update_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-UPDATE&amp;ref_id=<?php echo $colleague->clg_ref_id?>&amp;action=unblock&amp;page_no=<?php echo @$page_no;?>" data-confirm='yes' data-confirmmessage="Are you sure to unblock this user? ID :<?php echo$colleague->clg_ref_id;?>">

                                            Unblock</a>

                                       

                                        <?php



                                }  else {



                                    ?>



                                        <a class="change-base-xhttp-request action_button" name="<?php echo $colleague->clg_ref_id;?>" data-href="{base_url}clg/update_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-UPDATE&amp;ref_id=<?php echo $colleague->clg_ref_id?>&amp;action=block&amp;page_no=<?php echo @$page_no;?>" data-confirm='yes' data-confirmmessage="Are you sure to block this user? ID :<?php echo $colleague->clg_ref_id;?>">                            Block</a>


                                        <?php



                                }

                                ?>

                        </li>
                        <?php } ?>    

                        <?php if($CI->modules->get_tool_config('MT-CLG-DELETE',$this->active_module,true)!='' ||  $CI->session->userdata('current_user')->clg_ref_id == $colleague->clg_ref_id ){ ?>  
                        <li>

                            <a class="change-base-xhttp-request action_button" name="<?php echo $colleague->clg_ref_id;?>" data-href="{base_url}clg/update_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-DELETE&amp;ref_id[0]=<?php echo $colleague->clg_ref_id;?>&amp;action=delete&amp;page_no=<?php echo @$page_no;?>" data-confirm='yes' data-confirmmessage="Are you sure to delete this user? ID :<?php echo $colleague->clg_ref_id;?>">

                    Delete</a>
                   

                        </li>

                        <?php } ?>  

<?php if($CI->modules->get_tool_config('MT-CLG-ADM-LGOUT',$this->active_module,true)!='' && $CI->session->userdata('current_user')->clg_ref_id == $colleague->clg_ref_id ){ ?>  
                      
                        

                        
                        <li>

                            <a class="click-xhttp-request action_button" data-href="{base_url}clg/admin_logout" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-ADM-LGOUT&amp;ref_id=<?php echo $colleague->clg_ref_id;?>" data-confirm='yes' data-confirmmessage="Are you sure to logout this user? ID :<?php echo $colleague->clg_ref_id;?>">

                                Logout</a>

                        </li>
                     
                        
                       
<?php }  ?> 
                     
                        

                    </ul>

                

                <div class="login_status_div <?php if($colleague->clg_ref_id != $CI->session->userdata('current_user')->clg_ref_id){ echo "login_status_inner_div";}?>" style="background: <?php echo $green[$colleague->clg_ref_id]; ?>">

                 
                    

                </div>

            

                <?php 

                    $name = $colleague->clg_photo;



                    $pos = strrpos($name, '.');



                    $thumb_name = substr_replace($name, '_thumb', $pos, 0);

                    

                    $pic_path = FCPATH."upload/colleague_profile/thumb/".$thumb_name;

                    

                    $pic_path = FCPATH."upload/colleague_profile/".$name;

                    

                    if(file_exists($pic_path)){

                         

                        $pic_path1 = base_url()."upload/colleague_profile/thumb/".$thumb_name;

                        

                   }


                    $blank_pic_path = base_url()."themes/backend/images/blank_profile_pic.png";

                    

                    

                    

                    if(file_exists($pic_path))

                    {

                        

                        $img_path = base_url()."upload/colleague_profile/".$name;
                        $profile_pic_name = '';
                        

                    }

                    else

                    {

                        $img_path = base_url()."themes/backend/images/blank_profile_pic.png";
                        $profile_pic_name = substr($colleague->clg_first_name,0,1);

                    }


                ?>

                

                <div class="clg_profile_pic" style="background: url('<?php echo $img_path; ?>') no-repeat center center; background-size: cover;">
                        <?php echo $profile_pic_name; ?>
                 </div>

            <div class="profile_info_box">

                <div class="clg_profile_info">

                    <?php

                    echo $colleague->clg_ref_id.", ".$colleague->clg_first_name." ".$colleague->clg_last_name."<br/>";

                    

                    $last_login_time = $CI->time_date($colleague->clg_last_login_time, TRUE);

                    

                    echo $last_login_time;

                    

                    ?>
</div>
                    <div class="clg_profile_stts_info">

                        <?php

                            if($colleague->clg_is_active){



                                echo "<div class='stts_box' >Status: <span style='color: green;'>Active";



                            }  else {



                                echo "<div class='stts_box' >Status: <span style='color: red;'>Inactive";



                            }


                            
                            echo "</span></div>";
                            


                             echo "<div class='group_box'>".$colleague->ugname.", ".$colleague->city_name."</div><br/>";



                        ?>
                        

                    </div>

                    <div class="clg_profile_stts_info">
                              Profile Activation Date: <?php if($colleague->clg_active_date): echo date("d M Y", strtotime($colleague->clg_active_date)); endif; ?>
                        </div>

                

                                

            </div>

            <div class="box_horizontal_line"></div>

            

            <div class="clg_contact_info_box">

                

                <div class="clg_mobile">

                    Mobile No.:

                    <br/>

                    <?php

                        echo $colleague->clg_mobile_no;

                    ?>

                </div>

                <div class="clg_email">

                    Email address:

                    <br/>

                    <?php

                        echo "<a href='mailto:".$colleague->clg_email."'>".$colleague->clg_email."</a>";

                    ?>

                </div>

                

            </div>

            

        </div>

                <?php

        }

        ?>

            <div class="pagination">



               <?php echo $pagination; ?>



            </div> 
            
             <div class="row float_right">
             Total colleagues : <?php if(@$total_colleagues){ echo $total_colleagues; }else{ echo"0";}?>
             </div>
             <input type="hidden" name="clg_data" value=<?php echo $data; ?>>
        </div>   

    </form>
     

</div>



