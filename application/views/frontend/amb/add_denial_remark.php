<form enctype="multipart/form-data" action="#" method="post" id="usr_ad_form">
               <div class="width1 float_left ">
                <h2 class="txt_clr2 width1 txt_pro">Add Remark</h2>
                <div class="store_details_box">
                    <div class="field_row width100">
                        <div class="width100 float_left">
                            <div class="filed_lable float_left width33"><label for="amb_number">Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 " >

                                <textarea name="remark" placeholder="Remark ..." id="remark" style="font-family:sans-serif;font-size:1.2em;"></textarea>

                            </div>

                        </div>
                    </div>
                </div>
                
            <div class="width_11 margin_auto">
                <div class="button_field_row">
                    <div class="button_box">

                        <input type="hidden" name="denial_id" value="<?php echo $denial_id; ?>">
                        <input type="hidden" name="amb_id" value="<?php echo $amb_id; ?>">
                        
                        <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url(); ?>amb/save_denial_remark' data-qr='page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12">

                    </div>
                </div>
            </div>
               </div>
</form>