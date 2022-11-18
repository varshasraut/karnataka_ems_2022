
<div class="head_outer"><h3 class="txt_clr2 width1">CALL INFORMATION</h3> </div>
            
    <form method="post" name="" id="caller_info">


        <div class="width100 display_inlne_block">
         
            <div class="row width100">
      
                <div class="width20 float_left" data-activeerror="">
                    <div class="style6">Incident ID*</div>
                    <input id="caller_no" name="inc_ref_id" value="<?=@$increfid;?>" class="filter_required" tabindex="1" data-base="" type="text">
                </div>
                     

               <div class="width20 float_left">
                    <div class="style6">Vehicle No*</div>
                   <div id="purpose_of_calls" class="input" data-activeerror="">
                       <select id="" name="amb_reg_no" class="filter_required change-base-xhttp-request"  data-errors="{filter_required:'Purpose of call should not blank'}" data-base="" tabindex="2" data-href="{base_url}pcr/vehical_info" data-qr="output_position=vehical_info">
                           <option value="">Select</option>
                           <?php foreach($vahicle_info as $vahical){?>
                              <option value="<?php echo $vahical->amb_rto_register_no;?>"><?php echo $vahical->amb_rto_register_no;?></option>
                           <?php } ?>
                       </select>
                  </div>

               </div>
                
                <div class="width20 float_left">
                   <div class="style6">Patient ID*</div>
                   <div id="purpose_of_calls" class="input" data-activeerror="">
<!--                       <select name="patient_id" class="filter_required change-base-xhttp-request" data-href="{base_url}pcr/patient_details" data-qr="output_position=inc_details" data-errors="{filter_required:'Purpose of call should not blank'}" data-base="" tabindex="3">-->
                            <select name="patient_id" class="filter_required" data-href="{base_url}pcr/patient_details" data-qr="output_position=inc_details" data-errors="{filter_required:'Purpose of call should not blank'}" data-base="" tabindex="3">
                           
                           <option value="">Select</option>
                           <?php foreach($patient_info as $patient){?>
                              <option value="<?php echo $patient->ptn_id;?>"><?php echo $patient->ptn_id;?></option>
                           <?php } ?>
                           <option value="">Other</option>
                       </select>
                  </div>

               </div>
                
                <div class="date_time">
                   <div class="style6">Date</div>
                   <span class="call_date"><?php echo date('d/m/Y');?></span>
                   
                </div>
                <div class="date_time">
                   <div class="style6">Time</div>
                   <span class="call_date"><?php echo date('g:i A');?></span>
                   
                </div>
           </div>
        </div>
        
         <div id="vehical_info">
                
                
        </div>
        

        <div class="inc_pt_info float_left width100">



            <div class="width47 float_left">

                        <span class="font_weight600">CALLERS DETAILS:</span>

                        <table class="style3">

                            <tr>
                                <td>Caller Name</td>
                                <td><?php echo $pt_info[0]->clr_fname;?> <?php echo $pt_info[0]->clr_mname;?> <?php echo $pt_info[0]->clr_lname;?></td>
                            </tr>

                            <tr>
                                <td>Mobile</td>
                                <td><?php echo $pt_info[0]->clr_mobile;?></td>
                            </tr>

                            <tr>
                                <td>Relation</td>
                                <td><?php echo $pt_info[0]->clr_ralation;?></td>
                            </tr>


                        </table>

            </div>

            <div class="caller_outer">

                <span class="font_weight600"></span>

                <table class="style3">

                    <tr>
                       <td>Police Informed</td>
                       <td>Poonam Mehta</td>
                    </tr>

                    <tr>
                       <td>Fire Informed</td>
                       <td>87654567889</td>
                    </tr>


                    <tr>
                        <td>ERO Summary</td>
                        <td><?php echo $pt_info[0]->inc_ero_summary;?></td>
                    </tr>

                    <tr>
                        <td>MCI/Non MCI</td>
                        <td><?php echo $pt_info[0]->inc_type;?></td>
                    </tr>


                </table>

            </div>
            
            
           

        <div class="accept_outer float_right width100">

            <input type="button" name="accept" value="Accept" class="accept_btn form-xhttp-request" data-href='{base_url}/pcr/save_call_info' data-qr='' TABINDEX="4">


        </div>

        </div>
        
      
    </form>
        <div id="patient_details">

        </div>
            