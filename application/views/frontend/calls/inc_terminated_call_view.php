    <h3 class="txt_clr2 width1">Terminated Call Details</h3>
     
<!--                <div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>calls/all_listing_filter" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="<?php echo $from_date; ?>" name="from_date">
                        <input type="hidden" value="<?php echo $to_date; ?>" name="to_date">
                        <input type="hidden" value="<?php echo $call_purpose; ?>" name="call_purpose">
                        <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
                        <input type="hidden" value="<?php echo $search_chief_comp; ?>" name="search_chief_comp"> 
                        <input type="hidden" value="<?php echo $call_search; ?>" name="call_search"> 
                        <input type="hidden" value="<?php echo $avaya; ?>" name="avaya"> 
                        <input type="hidden" value="<?php echo $team_type; ?>" name="team_type"> 
                       
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>

            </div>
        </div> -->
        <form method="post" name="inc_list_form" id="inc_list">  
            <!--<h2>Export <?php echo $report_name;?> Details</h2> -->
<div class="width100">

        <div class="field_row float_left width75">
               
            <div class="filed_select">
            <div class="width20 drg float_left">
            
            <div class="width100 float_left">
                        <div class="style6 float_left">Select Team Type</div>
                    </div>
                    <select id="team_type" name="team_type"  class="" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7"  <?php echo $view; ?>>

                                        <option value="">Select Team Type</option>
                                        <option value="UG-ERO-102">ERO 102</option>
                                        <option value="UG-ERO">ERO 108</option>
                                        
                                         
                                       
                                    </select>
                </div> 
                <div class="width10 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">From: </div>
                    </div>
                    <div class="width100 float_left">
					<?php //var_dump($ALL_CALLS);?>
                        <input name="from_date" tabindex="1" class="form_input " placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php //echo $from_date;?>" readonly="readonly" id="from_date">
                    </div>
                </div>
                 <div class="width10 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">To : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="to_date" tabindex="2" class="form_input" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php //echo $to_date;?>" readonly="readonly" id="to_date">
                    </div>
                </div>
                <div class="width15 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select User : </div>
                    </div>
                    <div class="width100 float_left" id="ero_list_outer_qality">
                    <!-- <input name="ero" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_eros_data" placeholder="Select ERO" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php //echo $clg_ref_id; ?>" data-value="<?php// echo $clg_ref_id; ?>"> -->
                   <select name="user_id" id="ero_list_qality">
                    <option value="">Select User</option>
                    <?php foreach($ero_clg as $new) { ?>
                            <option value="<?php echo $new->clg_ref_id; ?>"><?php echo $new->clg_first_name." ".$new->clg_last_name." ".$new->clg_ref_id; ?></option>
                        <?php }?>
                    </select>
                    <!-- <select id="parent_call_purpose" name="ero" placeholder="Select ERO" class="mi_autocomplete_input      ui-autocomplete-input"  style="color:#666666" data-errors="{filter_required:'Purpose of call should not blank',filter_either_or:'Mobile numbers or purpose of call should not be blank.'}" data-base="search_btn"  tabindex="2" >
                                                  
                                                  <option value='' selected>Select User</option>
                                                 <option value='all' selected>All call</option> 
                                                  
                                                      <?php


                                                      //foreach ($ero_clg as $ero) {
                                                       //   echo "<option value='" . $ero->clg_ref_id . "'  ";
                                                          //echo $select_group[$purpose_of_call->pcode];
                                                       //   echo" >" . $ero->clg_ref_id;
                                                       //   echo "</option>";
                                                     // }
                                                      ?>
                                              </select> -->
                    </div>
                    
                </div>
<!--                <div class="width15 float_left">
                <div class="width100 float_left">
                <div class="style6 float_left">Select Avaya ID : </div>
                    </div>
                    <div class="width100 float_left" id="id_outer_qality">
                     <input name="ero" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_eros_data" placeholder="Select ERO" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php //echo $clg_ref_id; ?>" data-value="<?php// echo $clg_ref_id; ?>"> 
                    <select name="avaya" id="id_qality">
                    <option value="">Select Avaya ID</option>
                    <?php //foreach($ero_clg as $new) { ?>
                            <option value="<?php echo $new->clg_avaya_id; ?>"><?php echo $new->clg_avaya_id; ?></option>
                        <?php //} ?>
                    </select>
                 </div> 
                </div>-->
                <div class="width15 float_left">
                <div class="width100 float_left">
                        <div class="style6 float_left">Search : </div>
                </div>
                <div class="width100 float_left">
                                    <input type="text"  class="controls amb_search" id="mob_no" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search"/>
                                </div> 
                </div>
                     
                <div class="width15 float_left">
                <div class="width100 float_left">
                        <div class="style6 float_left">Call Type : </div>
                </div>
                <div class="width100 float_left">
                <select id="parent_call_purpose" name="call_purpose" placeholder="Select Purpose of call" class="form_input "  style="color:#666666" data-errors="{filter_required:'Purpose of call should not blank',filter_either_or:'Mobile numbers or purpose of call should not be blank.'}" data-base="search_btn"  tabindex="2" >
                                                  
                                                  <option value='' selected>Select Purpose of call</option>
                                                  <option value='all' selected>All call</option>
                                                  
                                                      <?php


                                                      foreach ($all_purpose_of_calls as $purpose_of_call) {
                                                          echo "<option value='" . $purpose_of_call->pcode . "'  ";
                                                          echo $select_group[$purpose_of_call->pcode];
                                                          echo" >" . $purpose_of_call->pname;
                                                          echo "</option>";
                                                      }
                                                      ?>
                                              </select>
                </div> 
                </div>                                                      

            </div>

        </div>
        
        <div class="width_25 float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box">

<!--                    <input type="submit" name="submit" value="Submit" TABINDEX="3">  -->
                    <input type="button" name="submit"  value="Submit" data-qr="output_position=content&amp;reports=view&amp;module_name=reports&amp;showprocess=yes&action=view" data-href="<?php echo base_url(); ?>calls/terminate_calls" class="form-xhttp-request btn clg_search float_left" >
                    <input type="reset" class="search_button btn float_left form-xhttp-request" name="" value="Reset Filter" data-href="{base_url}calls/terminate_calls" data-qr="output_position=content&amp;flt=reset&amp;type=inc" />
                </div>
            </div>
        </div>
</div> 
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
<script>;
    jQuery(document).ready(function(){  
        
    var dateFormat = "mm/dd/yy",
      from = jQuery( "#from_date" )
        .datepicker({
          defaultDate: new Date(),
          changeMonth: true,
          numberOfMonths: 2
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = jQuery( "#to_date" ).datepicker({
        defaultDate: new Date(),
        changeMonth: true,
        numberOfMonths: 2
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
      return date;
    }
  } );

</script>
           <div class="width100" id="ero_dash">

         

                  <table class="table report_table">



                       <tr>                                     

                            <th>Date</th>
                            <th nowrap>Call Type</th>
                           <th nowrap>Incidence ID</th>

                           <th nowrap>Caller Name</th>
                            <th nowrap>District</th>
<!--                           <th nowrap>Patient Name</th>-->
<!--                          <th nowrap>108 Ref ID</th>-->

                           <th nowrap>Caller Mobile No</th>

<!--                           <th width="18%">Incident Address</th>-->
                            

                           <th nowrap>EMT NAME</th>
                           <th nowrap>EMT Mobile</th>
                           <th>ERO Name</th>
                           <th>Ameyo ID</th>
                            <th>Audio File</th>

<!--                            <th nowrap>Pilot</th>
                            <th nowrap>Pilot Mobile</th>-->

                           <th nowrap>Ambulance</th>
                           <th nowrap>Call Time</th>
                           <th nowrap>Incident<br> status</th>
                        <th nowrap>Closure<br> Status</th>
                          
                       </tr>


        
                       <?php  if(count(@$inc_info)>0){  


                       $total = 0;
                       foreach($inc_info as $key=>$inc){
                          
                        
                           if($inc['clr_fullname'] != ''){
                               $caller_name = $inc['clr_fullname'];
                           }else{
                               $caller_name = ucwords($inc['clr_fname']." ".$inc['clr_mname']." ".$inc['clr_lname']);
                           }
                          
                          ?>

                       <tr>




                            <td ><?php echo $inc['inc_datetime'];?></td>
                            <td ><?php echo ucwords($inc['pname']);?></td>
                           <td ><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc['inc_ref_id']; ?>" style="color:#000;"><?php echo $inc['inc_ref_id'];?></a></td>

                          <td ><?php echo ucwords($caller_name);?></td>
                           
                          <td ><?php if($inc['inc_district_id'] == "0"){echo "NA";}else{echo get_district_by_id($inc['inc_district_id']);}?></td>
<!--                           <td ><?php echo ucwords($patient_name);?></td>-['
<!--                           <td  style="background: #FFD4A2;;"><?php echo $inc['inc_bvg_ref_number'];?></td>-->
                           <td ><?php echo $inc['clr_mobile'];?></td>

<!--                           <td ><?php echo $inc['inc_address'];?></td>-->

                           
                           <td ><?php echo $inc['amb_emt_id'];?><?php //echo ucwords($inc['emt_first_name']." ".$inc['emt_last_name']);?></td>
                           <td  nowrap><?php echo $inc['amb_default_mobile'];?></td>
<!--                            <td ><?php echo $inc['amb_pilot_id'];?><?php //echo ucwords($inc['clg_first_name']." ".$inc['clg_last_name']);?></td>
                        <td ><?php echo $inc['amb_pilot_mobile'];?><?php //echo ucwords($inc['clg_first_name." ".$inc['clg_last_name);?></td>-->

                           <td  nowrap><?php echo ucwords(strtolower($inc['clg_first_name']." ".$inc['clg_last_name'])); ?></td>
                           <td  nowrap><?php echo ($inc['clg_avaya_id']); ?></td>
                            <td>
                                    <?php  
                                        $inc_datetime = date("Y-m-d", strtotime($inc['inc_datetime']));
                                        $pic_path =  "{base_url}uploads/audio_files/".$inc['inc_audio_file'] ;
                                        $pic_path =  get_inc_recording($inc['inc_avaya_uniqueid'],$inc_datetime);
                                      if($pic_path != ""){       
                                        ?>
                                     <audio controls controlsList="nodownload" style="width: 185px;">
                                      <source src="<?php echo $pic_path;?>" type="audio/wav">
                                    Your browser does not support the audio element.
                                    </audio> 
                                    <?php
                                    } ?>
                                  
                           </td>
                           <td  nowrap><?php echo $inc['amb_rto_register_no'];?></td>


                           <td ><?php echo $inc['inc_dispatch_time'];?></td>
                       
   <?php                        if($inc['inc_district_id'] != "0"){
                                      if($inc['incis_deleted'] == 0){
                                          $disptched = "Dispatched";
                                      }
                                      if($inc['incis_deleted'] == 2){
                                          $disptched = "Terminated";
                                      }
                                      if($inc['incis_deleted'] == 1){
                                          $disptched = "Deleted";
                                      }
                                      
                                    }else{
                                    $disptched ="NA";
                                }
                                if($inc['inc_district_id'] != "0"){
                                if($inc['inc_pcr_status'] == '0' || $inc['inc_pcr_status'] == 0){
                                    $closer = "Closure Pending";
                                }else{
                                    $closer = "Closure Done";
                                }
                            }else{
$closer ="Closed";
                            }
                                      ?>
                                  <td><?php echo $disptched; ?></td>
                                 <td><?php echo $closer; ?></td>
                                



                          </tr>

                        <?php } ?>

                   <?php }else{   ?>



                       <tr><td colspan="13" class="no_record_text">No Record Found</td></tr>



                    <?php } ?>   





                   </table>
              

      
      <div class="bottom_outer">
            
                    <div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php if(@$data){ echo $data; }?>">
 
                    <div class="width33 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}calls/terminate_calls" data-qr="output_position=content&amp;flt=true&amp;type=inc&amp;action=view&from_date=<?php echo $from_date;?>&to_date=<?php echo $to_date;?>&pg_rec=<?php echo $pg_rec;?>">

                                    <?php echo rec_perpg($pg_rec); ?>

                                </select>

                            </div>

                                <div class="float_right">
                                    <span> Total records: <?php if(@$inc_total_count){ echo $inc_total_count; }else{ echo"0";}?> </span>
                                </div>
                        </div>

                    </div>
                    
                </div>

               
           </div>
        </form>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>