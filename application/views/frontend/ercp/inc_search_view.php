<style>
    .head_outer1 {
    border-bottom: 1px solid #c7c3c2;
    margin-bottom: 10px;
    padding: 5px 0; 
    background: #2F419B;
    /* height: 27px; */
}
.head_outer1 .txt_clr2 {
    display: inline-block;
    margin-left: 0px;
    color: white;
    text-align: center;
    margin-top: 2px;
}
.headerlbl{
    margin: 7px 0 0 0 !important;
}
input[type='text'] {
    margin-top : 4px !important;
}
</style>
<div class="call_purpose_form_outer">
            
    <div class="head_outer1"><h4 class="txt_clr2 width1 mb-0">CALL INFORMATION</h4> </div>
            
    <form method="post" name="" id="call_dls_info">

<!--        <div class="inline_fields width50">

            <div class="form_field width100 pos_rel">
                
               <div class="outer_id">

                    <div class="label">Incident Id<span class="md_field">*</span></div>


                    <div class="input float_left width50">

                        <input name="inc_ref_id" tabindex="1" class="form_input filter_required" placeholder="Enter Incident Id" type="text" data-base="search_btn" data-errors="{filter_required:'Incident Id should not be blank!'}" >

                    </div>
               </div>



                <div class="float_left search_btn width50">

                    <div class="label">&nbsp;</div>
                    
                     <input name="search_btn" value="SEARCH" class="style3 base-xhttp-request" data-href="{base_url}medadv/call_details" data-qr="output_position=content" type="button">
                   
                </div> 

            </div>
             </div>-->
          <div class="inline_fields width100">

            <div class="form_field width100 pos_rel">
                
               <div class="outer_id width100">

                   <div class="float_left width_10">
                       <label class="headerlbl">Incident Id <span class="md_field">*</span></label>
                        <!-- <h3>Incident Id <span class="md_field">*</span></h3> -->
                    </div>


                   
                    <div class="input float_left width_16">

                      <input name="inc_ref_id" tabindex="1" class="form_input " placeholder="Enter Incident Id" type="text" data-base="search_btn" data-errors="{filter_required:'Incident Id should not be blank!'}" value='<?php echo $date;?>'>

                    </div>
                    <div class="input float_left width_16">

                        <input name="mobile_no" tabindex="1" id="inc_ref_id" class="form_input" placeholder="Enter Caller Number" type="text" data-base="search_btn" data-errors="{filter_required:' Caller Number should not be blank!'}" autocomplete="off" value="<?php echo $m_no;?>">

                    </div>
                    <div class="float_left  ">

<!--                    <div class="label">&nbsp;</div>-->
                    
                       <input name="search_btn" value="SEARCH" class="style3 base-xhttp-request" data-href="{base_url}medadv/call_details" data-qr="output_position=content" type="button">
                   
                </div> 
               </div>



               

            </div>

        </div>

       
        
    </form>
    
<!--    <div class="float_right">
                         
        <input type="button" name="" value="NEXT>" class="next_btn form-xhttp-request" data-href='{base_url}/pcr/call_info' data-qr='' TABINDEX="12">
                         
                       
    </div>-->
</div>
