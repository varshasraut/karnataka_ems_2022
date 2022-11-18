<script>cur_pcr_step(1);</script>

<div class="call_purpose_form_outer">
            
    <div class="head_outer"><h3 class="txt_clr2 width1">CALL INFORMATION</h3> </div>
            
    <form method="post" name="" id="call_dls_info">

        <div class="inline_fields width50">

            <div class="form_field width100 pos_rel">
                
               <div class=" width50 float_left">

                    <div class="label">Incident Id<span class="md_field">*</span></div>


                    <div class="input float_left width1">

                        <input value="<?php echo date('Ymd'); ?>" name="inc_ref_id" tabindex="1" class="form_input filter_required" placeholder="Enter Incident Id" type="text" data-base="search_btn" data-errors="{filter_required:'Incident Id should not be blank!'}" >

                    </div>
               </div>



                <div class="float_left ">

                    <div class="label">&nbsp;</div>
                    <?php 
                    if($user_group != 'UG-DCO'){ ?>
                    <input name="search_btn" value="SEARCH" class="style3 base-xhttp-request" data-href="{base_url}/pcr/epcr" data-qr="output_position=content" type="button">
                    <?php }else{?>
                     <input name="search_btn" value="SEARCH" class="style3 base-xhttp-request" data-href="{base_url}/bike/epcr" data-qr="output_position=content" type="button">
                    
                    <?php }?>
                </div> 

            </div>

        </div>
        
    </form>
    
<!--    <div class="float_right">
                         
        <input type="button" name="" value="NEXT>" class="next_btn form-xhttp-request" data-href='{base_url}/pcr/call_info' data-qr='' TABINDEX="12">
                         
                       
    </div>-->
</div>