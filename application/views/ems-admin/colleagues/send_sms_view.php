


<div class="register_outer_block">
    <div class="breadcrumb">
        <ul>
            <li class="colleague"><a href="{base_url}ms-admin/clg/colleagues">Colleague</a></li>
            <li><span>Send SMS</span></li>
        </ul>
    </div><br>
    <div class="box3">
        <form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form">
            <div class="register_block">
                
          
                <div class="joining_details_box">
                    
                    <div class="width2 center">
                        
                        
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="group">Message Type*</label>
                            </div>
                            <div class="filed_input">
                                <select id="group" name="sms_type"  class="filter_required" data-errors="{filter_required:'Please select sms type'}" TABINDEX="1">
                                    <option value="">Select Type</option>
                                  
                                    <option value="t">Transactional</option>
                                    <option value="p">Promotional</option>
                                    
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="field_row">
                            <div class="field_lable">
                             
                                <label>Enter Mobile Numbers</label>
                            </div>
                            <div class="filed_input">
                                
                                 <textarea id="mbnotxt" class="text_area store_txt filter_either_or[mbnocsv,mbnotxt]" name="sms_numbers" rows="5" cols="30" data-errors="{filter_either_or:'Mobile numbers should not be blank.'}" data-input="textarea"></textarea>
                                
                              
                            </div>
                        </div>
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="password">Import Contact CSV</label>
                            </div>
                            <div class="filed_input">
                                
                                  <input  id="mbnocsv" class="filter_either_or[mbnotxt,mbnocsv]" data-errors="{filter_either_or:'Mobile numbers should not be blank.'}"  type="file" name="sms_csv" >
                                
                            </div>
                        </div>
                      
                        <p class="download_csv"><a class="ms_alink" href="{base_url}ms-admin/clg/download_dummy/<?php echo base64_encode($dummy_csv); ?>/<?php echo base64_encode("dummy_csv"); ?>">[ Download Import CVS Template ]</a></p>
                        
                        
                        <div class="field_row">
                            <div class="field_lable">
                             
                                <label>Enter Message*</label>
                                
                            </div>
                            <div class="filed_input">
                                
                                 <textarea class="filter_required text_area text_area store_txt" name="sms_msg" rows="5" cols="30" data-errors="{filter_required:'Message should not be blank.'}" ></textarea>
                                
                              
                            </div>
                            <span class="note">( Available shortcodes are {user_name} )</span>
                        </div>
                        
                        
                    </div>
                </div>     
                
                <div class="width6">
                    <div class="button_field_row">
                        <div class="button_box">
                        
                            <input type="hidden" name="sms_form" value="sendsms">   
                            
                         <input type="button" name="submit" value="Send Sms" class="btn submit_btnt form-xhttp-request" data-href='{base_url}ms-admin/clg/send_sms' data-qr='output_position=content&amp;module_name=clg&amp;tlcode='  TABINDEX="23" id="">
                          <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">                          
                        </div>
                    </div>
                </div>
        
    </div>
        </form>
</div>
</div>