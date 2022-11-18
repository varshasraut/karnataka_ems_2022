 <?php echo $call_res; ?>
<div class="width100">                
    <div class="text_align_center">                    
        <a href="{base_url}"> <div class="ems_logo margin_auto"></div>                    
        </a>                
    </div>                
    <div class="text_align_center">                    
        <h3 class="txt_clr2 width1 txt_pro">Notice / Reminder</h3>                
    </div>               
    <div class="login_inner_box joining_details_box">                    <!--<h2></h2>-->                    
        <div class="field_row line_height">

            <div class="field_lable float_left width_25 strong"><label for="joining_date">Notice :</label></div>

            <div class="filed_input float_left width75">

                <?php echo $call_res; ?>

            </div>


        </div>

             <div class="field_row  line_height">

            <div class="field_lable float_left  width_25 strong"><label for="joining_date">Expiry Date:</label></div>

            <div class="filed_input float_left width50">
                <?php echo date('d-m-Y'); ?>
            </div>
        </div>
    </div>
</div>            
</div>      

