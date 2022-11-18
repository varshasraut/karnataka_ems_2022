

<div class="inc_pt_info float_left width100">


    <?php if (!empty($pt_info[0])) { ?>

        <div class="width47 float_left">

            <span class="font_weight600">Incident Information</span>

            <table class="style3">

                <tr>
                    <td>No Of Patients</td>
                    <td><?php echo ($pt_info[0]->inc_patient_cnt) ? $pt_info[0]->inc_patient_cnt : "-"; ?></td>
                </tr>


                <tr>

                    <?php
                   // var_dump($pt_info);
                    
                    if (trim($pt_info[0]->ntr_nature) != '') {
                        $label = "MCI Nature";
                        $value = ($pt_info[0]->ntr_nature) ? $pt_info[0]->ntr_nature : "-";
                    } else if(trim($pt_info[0]->ptn_condition) != ''){
                        $label = "Patient Condition";
                        $value = ($pt_info[0]->ptn_condition) ? $pt_info[0]->ptn_condition : "-";
                    }else {
                        $label = "Chief Complaint Name";
                        $value = ($pt_info[0]->ct_type) ? $pt_info[0]->ct_type : "-";
                    }
                    ?>
                    <td><?php echo $label; ?></td>
                    <td class="ucfirst_letter"><?php echo $value; ?></td>
                </tr>

                <tr>
                    <td>Incident Address</td>
                    <td><?php echo ($pt_info[0]->inc_address) ? $pt_info[0]->inc_address : "-"; ?></td>
                </tr>

                <?php if (@$resource == 'true') {
                    foreach($inc_amb as $amb){
                    ?>

                    <tr>
                        <td>Current Ambulance</td>
                        <td><?php echo ($amb->amb_rto_register_no) ? $amb->amb_rto_register_no : "-"; ?></td>
                    </tr>

                    <tr>
                        <td>Base location</td>
                        <td><?php echo ($amb->hp_name) ? $amb->hp_name : "-"; ?></td>
                    </tr>
                    <?php } } ?>

            </table>

        </div>

        <div class="width47 float_right">

            <span class="font_weight600">Old Patient Information</span>

            <table class="style3">

                <tr>
                    <td class="width30">Patient Name</td>
                    <td><?php echo ($pt_info[0]->ptn_fname) ? $pt_info[0]->ptn_fname . " " . $pt_info[0]->ptn_lname : "-"; ?></td>
                </tr>

                <tr>
                    <td>Age</td>
                    <td><?php echo ($pt_info[0]->ptn_age) ? $pt_info[0]->ptn_age : "-"; ?></td>
                </tr>

                <tr>
                    <td>Gender</td>
                    <td><?php echo ($pt_info[0]->ptn_gender) ? get_gen($pt_info[0]->ptn_gender) : "-"; ?></td>
                </tr>

                <tr>
                    <td>ERO Summary</td>
                    <td><?php echo ($pt_info[0]->inc_ero_summary) ? $pt_info[0]->inc_ero_summary : "-"; ?></td>
                </tr>

            </table>

        </div>
    
        <?php if ($resource_type['medical']) { ?>
            <div id="amb_map_view">

            </div>
        <?php } ?>
    <?php } else { ?>

        <div class="width100 text_align_center"><span> No records found. </span></div>


    <?php } ?>

</div>

<input type="hidden" name="incaddress" id="IncAddress" value="<?php echo $pt_info[0]->inc_address; ?>">
<?php if (!empty($pt_info[0]) && !(@$resource)) { ?>

    <input name="search_btn" value="FORWARD TO ERCP" class="style4 form-xhttp-request" data-href="{base_url}medadv/save" data-qr="" type="button" >

    <input type="hidden" name="increfid" value="<?php echo $increfid; ?>">
        


<?php } if (@$resource == 'true' && $pt_info[0]) { ?> 


    <div class="button_field_row text_align_center">

        <div class="button_box">

            <input type="hidden" name="inc_id" value="<?php echo $increfid; ?>">
            <input type="hidden" name="submit" value="sub_test"/>

        <!--            <input type="button" name="submit" value="Save" class="style5 form-xhttp-request" data-href='{base_url}resource/save' data-qr="output_position=content">-->

        <!--            <input type="button" name="submit" value="Dispatch" class="btn submit_btnt form-xhttp-request" data-href='{base_url}resource/confirm_save' data-qr='output_position=content' TABINDEX="5">-->
            <input type="reset" name="reset" id="reset" value="Reset" class="btn test_rst_btn register_view_reset">
        </div>

    </div>
    <div class="save_btn_wrapper" style="margin-bottom: 20px;">
        <input type="button" name="submit" value="DISPATCH" class="btn submit_btnt form-xhttp-request" data-href='{base_url}resource/confirm_save' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD&amp;call_type=dispatch'  TABINDEX="27" >
        
        <input type="button" name="submit" value="Termination Call" class="btn submit_btnt form-xhttp-request" data-href='{base_url}resource/confirm_save' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD&amp;call_type=terminate'  TABINDEX="27" >
    <!--                      <input value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}inc/confirm_mci_save" output_position="content" tabindex="20" type="button">-->
<!--        <input name="search_btn" value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}resource/confirm_save?cl_type=forword" data-qr="output_position=content" tabindex="28" type="button">-->
    </div>


<?php } ?>




