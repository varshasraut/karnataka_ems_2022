<?php //var_dump($extention_no->extension_no);?>

<div class="login_content width100 height100">    
    <div class="login_wrapper auto_margin">       
        <div class="trans_box  margin_auto">          
            <div class="width100">                <!--<div class="text_align_center">                    <a href="{base_url}"> <div class="ems_logo margin_auto"></div>                    </a>                </div> -->               <div class="text_align_center">                    <h3>EMS LOGIN</h3>                </div>                <div class="login_inner_box">  
                   <!--<h2></h2>-->   
                    <?php if($login_count > 5){ ?>
<div class="error"> Too many times try again later</div>
                    <?php } ?>
 <?php echo @$message;
echo "<form action='{base_url}clg/authenticate_password' method='post' class='login_form'>";
?>                    <div class="form_field">               
<!--    <select name="user_group" data-setfocus="true"  class="width100 filter_required" data-errors="{filter_required:'Please select user type'}">                            ?>                            <option value="">Users Group</option>                             <?php foreach ($users as $users_data): ?>                            <option value="<?php echo $users_data->gcode; ?>" <?php echo @$selected_group[$users_data->gcode] ?>><?php echo $users_data->ugname; ?></option>                            <?php endforeach; ?>                        </select>         -->
                    </div>            <?php
                    $ref_id = $this->session->userdata('temp_usr');
                    $password = $this->session->userdata('password');
                    ?>

                    <div class="form_field">                        
                        <input type="text" class="filter_required" name="ref_id" placeholder="Enter User Name" data-errors="{filter_required:'Reference id should not be blank!', filter_string:'Invalid reference id!'}"  value="<?php echo $ref_id; ?>" class="width100"  data-style="line" id="user_name_id">                   
                    </div>                    
                    <div class="form_field">                                                                    
                        <input type="password" class="filter_required filter_minlength[5]" name="password" placeholder="Enter Password" data-errors="{filter_required:'Password should not be blank!', filter_minlength:'Password should be at least 6 characters long!'}" value="<?php echo $password; ?>" class="width100"  data-style="line" id="user_password_id"> 
                    </div> 


<!--                    <div class="form_field">                        
                        <select name="user_group" data-setfocus="true"  class="width100 filter_required" data-errors="{filter_required:'Please select user type'}" id="show_extenstion">                          
                            <option value="">Users Group</option>                            
                            <?php foreach ($users as $users_data): ?>                            
                                <option value="<?php echo $users_data->gcode; ?>" <?php echo @$selected_group[$users_data->gcode] ?>><?php echo $users_data->ugname; ?></option>                           
                            <?php endforeach; ?>                        
                        </select>                   
                    </div>-->
                     <div class="form_field" id="extension_block_outer">                                                                    
<!--                         <select name="extension_no" class="filter_required width100">
                             <option value="">Select</option>

                     <div class="form_field">                                                                    
                         <select name="extension_no" class=" width100">

                             <?php foreach ($extention_no as $ext) { ?>
                             
                                 <option value="<?php echo $ext->extension_no; ?>"><?php echo $ext->extension_no; ?></option>
                             <?php } ?>
                         </select>-->
                     </div> 
                    <div class="text_align_center button_box">                        
                        <input type="submit" name="login[btn_submit]" value="Login" class="validate-form style1" >                    </div>                    </form>                </div>            </div>        </div>    </div>
</div>
<!--                            <span id="siteseal"  class="geDaddy"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=uGDf0LC2h9LSh1CqBzqfsT4N2vgSTjjOWbeOVa67WQMuyUCO72sKFtH0qQ2A"></script></span>-->
                        
<script>
$(document).on("change", "#show_extenstion", function () {
 
    var $provider = $("#show_extenstion").val();
    
      xhttprequest($(this), base_url + 'clg/show_extenstion', 'output_position=extension_block_outer&group='+$provider);
    
});
</script>


