<div class="width100">                
    <div class="text_align_center">                    
        <a href="{base_url}"> <div class="ems_logo margin_auto"></div>                    
        </a>                
    </div>                
    <div class="text_align_center">                    
        <h3 class="txt_clr2 width1 txt_pro">Message</h3>                
    </div>               
    <div class="login_inner_box joining_details_box">      
        <?php
        if ($call_res) {

           
            foreach ($call_res as $call_res) {
                ?>
                <?php if ($call_res->er_notice != '') { ?>
                    <div class="field_row width100 line_height float_left">
                        <div class="field_lable float_left width_25 strong"><label for="joining_date">Message :</label></div>
                        <div class="filed_input float_left width75">
                            <?php echo $call_res->er_notice; ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($call_res->inc_ref_id != '') { ?>
                    <div class="field_row  width100 line_height float_left">
                        <div class="field_lable float_left  width_25 strong"><label for="joining_date">Inc ref Id:</label></div>
                        <div class="filed_input float_left width50">
                            <?php echo $call_res->inc_ref_id; ?>
                        </div>

                    </div>
                <?php } ?>
                <?php if ($call_res->quality_score != '' && $call_res->er_notice == '') { ?>
                    <div class="field_row  width100 line_height float_left">
                        <div class="field_lable float_left  width_25 strong"><label for="joining_date">Quality Score:</label></div>
                        <div class="filed_input float_left width50">
                            <?php echo $call_res->quality_score; ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($call_res->er_remark != '') { ?>
                    <div class="field_row  width100 line_height float_left">
                        <div class="field_lable float_left  width_25 strong"><label for="joining_date">Remark:</label></div>
                        <div class="filed_input float_left width50">
                            <?php echo $call_res->er_remark; ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($call_res->er_notice_date != '') { ?>
                    <div class="field_row  width100 line_height float_left">
                        <div class="field_lable float_left  width_25 strong"><label for="joining_date"> Date Time:</label></div>
                        <div class="filed_input float_left width50">
                            <?php echo date("d-m-Y H:i:s", strtotime($call_res->er_notice_date)); ?>
                        </div>
                    </div>
                <?php } ?>

                <?php
            }
        } else {
            ?>
            <div> No Records Founds </div> <?php } ?>
    </div>


</div>            
</div>      

