<div class="head_outer"><h3 class="txt_clr2 width1">  <?php echo $report_name ?> </h3> </div>
<div class="width100 float_left width69">
    <form enctype="multipart/form-data" action="#" method="post" id="reports_type">
        <div class="width_20 drg float_left">

            <div class="width100 float_left">
                <div class="style6 float_left">Select System Type </div>
            </div>
            <select id="team_type" name="system"  class="" data-errors="{filter_required:'System should not blank'}" TABINDEX="7" <?php echo $view; ?> >

                <option value="">Select System Type</option>
                <!--<option value="102">102</option>-->
                <option value="108">108</option>
                <!-- <option value="104">104</option> -->

            </select>
        </div> 
        <div class="input float_left width_20">

            <div class="width100 float_left">
                <div class="style6 float_left">Select Purpose of call </div>
            </div>
            <select name="call_purpose" placeholder="Select Purpose of call" class="form_input "  style="color:#666666" data-errors="{filter_required:'Purpose of call should not blank',filter_either_or:'purpose of call should not be blank.'}" data-base="search_btn"  tabindex="2" >

                <option value='' selected>Select Purpose of call</option>
                <option value='all' selected>All call</option>

                <?php
                foreach ($all_purpose_of_calls as $purpose_of_call) {
                    if($purpose_of_call->pcode!="NON_MCI_WITHOUT_AMB"){
                    echo "<option value='" . $purpose_of_call->pcode . "'  ";
                    echo $select_group[$purpose_of_call->pcode];
                        echo" >" . $purpose_of_call->pname;
                      }
                    
                    echo "</option>";
                }
                ?>
            </select>

        </div> 
         <div class="width_20 float_left ">

            <div class="filed_select width100">
                <div class="field_row drg float_left width100">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select </div>
                    </div>
                    <div class="width100 float_left">  
                        <select name="ercp_report_type"  class="change-base-xhttp-request"  data-href="{base_url}erc_reports/hourly_report_form" data-qr="output_position=content">
                            <option value="">Select Report </option>
                            <option value="1">Datewise</option>
                            <option value="2">Weekly/Monthly</option>
                          </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="width100 float_left">
            <div id="Sub_report_block_fields" >
            </div>
        </div>
<!--        <div class="field_row float_left width_25">

            <div class="filed_select">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Date: </div>
                    </div>
                    <div class="width100 float_left" >
                        <input name="from_date" tabindex="20" class="form_input mi_calender filter_required" placeholder="Date" type="text"  data-errors="{filter_required:'Date should not be blank!'}" >
                    </div>
                </div>
            </div>

        </div>

        <div class="width_25 float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <input type="button" name="submit" value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search">
                </div>
            </div>
        </div>-->
    </form>
</div>
<div class="box3 width100">    

    <div class="permission_list group_list">

        <div id="list_table" >

        </div>
         <div id="list_table1" >

        </div>
    </div>
</div>

<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>