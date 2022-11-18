<div class="width100">                
    <div class="text_align_center">                    
        <a href="{base_url}"> <div class="ems_logo margin_auto"></div>                    
        </a>                
    </div>                
    <div class="text_align_center">                    
        <h3 class="txt_clr2 width1 txt_pro">Notice / Reminder</h3>                
    </div>               
    <div class="login_inner_box joining_details_box">      
        <?php
        if ($call_res) {


            foreach ($call_res as $call_res) {
                if (date('Y-m-d H:i:s') <= date("Y-m-d H:i:s", strtotime($call_res->notice_exprity_date))) {
                    ?>
                    <div class="field_row width100 line_height float_left">
                        <div class="field_lable float_left width_25 strong"><label for="joining_date">Notice :</label></div>
                        <div class="filed_input float_left width75">
                            <?php echo $call_res->nr_notice; ?>
                        </div>
                    </div>
                    <div class="field_row  width100 line_height float_left">
                        <div class="field_lable float_left  width_25 strong"><label for="joining_date">Expiry Date:</label></div>
                        <div class="filed_input float_left width50">
                            <?php echo date("d-m-Y H:i:s", strtotime($call_res->notice_exprity_date)); ?>
                        </div>
                    </div>
                    <?php
                }
            }
        } else {
            ?>
            <div> No notification or reminder </div> <?php } ?>
    </div>


</div>            
</div>      

