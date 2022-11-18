
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

                

                <input type="checkbox" name="clg_id_select[<?php echo $i++;?>]" value="<?=$colleague->clg_ref_id?>" class="base-select">

                

            <div class="clg_group_name">

                

                

                <br/>

                <?php

                echo $colleague->clg_group;

            ?>

            </div>

                

                

                <div class="colleagues_profile_actions_div">

                    

                </div>

                    <ul class="profile_actions_list">

                        <li>

                            <a class="onpage_popup action_button" data-href="{base_url}gb-admin/clg/profile" data-qr="output_position=popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-UPDATE&amp;ref_id=<?=$colleague->clg_ref_id?>&amp;action=view_profile" data-popupwidth="900" data-popupheight="850">

                    View</a>

                        </li>

                        <li>

                            <a class="click-xhttp-request action_button" data-href="{base_url}gb-admin/clg/update_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-UPDATE&amp;ref_id=<?=$colleague->clg_ref_id?>&amp;action=edit_data">

                    Edit</a>

                        </li>

                        <li>

                            <a class="onpage_popup action_button" data-href="{base_url}gb-admin/clg/update_clg" data-qr="output_position=popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-UPDATE&amp;ref_id=<?=$colleague->clg_ref_id?>&amp;action=change_password" data-popupwidth="480" data-popupheight="470">

                    Password</a>

                        </li>

                        <li>

                            <?php



                                if(!$colleague->clg_is_active){

                                    ?>



                                        <a class="click-xhttp-request action_button" data-href="{base_url}gb-admin/clg/update_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-UPDATE&amp;ref_id=<?=$colleague->clg_ref_id?>&amp;action=unblock" data-confirm='yes' data-confirmmessage="Are you sure to unblock this user? ID :<?php echo$colleague->clg_ref_id;?>">

                                            Unblock</a>



                                        <?php



                                }  else {



                                    ?>



                                        <a class="click-xhttp-request action_button" data-href="{base_url}gb-admin/clg/update_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-UPDATE&amp;ref_id=<?=$colleague->clg_ref_id?>&amp;action=block" data-confirm='yes' data-confirmmessage="Are you sure to block this user? ID :<?php echo$colleague->clg_ref_id;?>">                            Block</a>



                                        <?php



                                }

                                ?>

                        </li>

                        <li>

                            <a class="click-xhttp-request action_button" data-href="{base_url}gb-admin/clg/update_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-UPDATE&amp;ref_id=<?=$colleague->clg_ref_id?>&amp;action=delete" data-confirm='yes' data-confirmmessage="Are you sure to delete this user? ID :<?php echo$colleague->clg_ref_id;?>">

                    Delete</a>

                        </li>

                        

                        <li>

                            <a class="click-xhttp-request action_button" data-href="{base_url}gb-admin/clg/admin_logout" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-ADM-LGOUT&amp;ref_id=<?=$colleague->clg_ref_id?>" data-confirm='yes' data-confirmmessage="Are you sure to logout this user? ID :<?php echo$colleague->clg_ref_id;?>">

                                Logout</a>

                        </li>

                    </ul>

                

                <div class="login_status_div" style="background: <?php echo $green[$colleague->clg_ref_id]; ?>">

                    

                    <div class="login_status_inner_div">

                        

                    </div>

                    

                </div>

            

                <?php 

                    $name = $colleague->clg_photo;

                    $pic_path = FCPATH."upload/colleague_profile/".$name;


                    if(file_exists($pic_path))

                    {

                        

                        $img_path = base_url()."upload/colleague_profile/".$name;

                        

                    }

                    else

                    {

                        $img_path = base_url()."themes/backend/images/blank_profile_pic.png";

                    }


                ?>

                

                <div class="clg_profile_pic" style="background: url('<?php echo $img_path; ?>') no-repeat center center; background-size: cover;">

            </div>

            <div class="profile_info_box">

                <div class="clg_profile_info">

                    <?php

                    echo $colleague->clg_ref_id.", ".$colleague->clg_first_name." ".$colleague->clg_last_name."<br/>";

                    

                    $last_login_time = $CI->time_date($colleague->clg_last_login_time, TRUE);

                    

                    echo $last_login_time;

                    

                    ?>

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
            
             <div class="row float_right" style="margin-right:80px;">
             Total colleagues : <?php if(@$total_colleagues){ echo $total_colleagues; }?>
             </div>

        
