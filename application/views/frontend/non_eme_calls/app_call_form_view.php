<div class="call_purpose_form_outer">

    <!-- <h3>Appreciation Call</h3> -->
    <label class="headerlbl">Appreciation Call</label>

    <div id="totalnon_div">

        <div id="nonleft_half1">
            <form method="post" name="complnt_call_form" id="complnt_form">
                <input type="hidden" name="incient[inc_type]" id="inc_type" value="APP_CALL">
                <input type="hidden" name="cl_purpose" value="APP_CALL" data-base="search_btn">
                <div class="inline_fields width100" id="inc_filters">
					<div id="nonleft_half">
						<div class="form_field width20">

							<div class="label">Incident Id</div>

							<input value="<?php echo date('Ymd'); ?>" name="inc_id" tabindex="7" id="cinc_id" class="form_input inc_id_filt" placeholder="Incident Id" type="text" data-base="search_btn">

						</div>

						<div class="form_field width20">

							<div class="label">Mobile Number</div>

							<div class="input">

								<input name="clr_mobile" tabindex="8" class="form_input filter_if_not_blank filter_number filter_minlength[9] filter_maxlength[11]" data-errors="{filter_number:'Mobile number should be in numeric characters only.', filter_minlength:'Mobile number should be at least 10 digits long',filter_maxlength:'Mobile number should less then 11 digits.'}" placeholder="Mobile Number" type="text" data-base="search_btn">
							</div>

						</div>

						<div class="form_field width20">

							<div class="label">Incident District</div>


							<input name="inc_district" tabindex="9" class="form_input mi_autocomplete" data-href="{base_url}auto/get_district/<?php echo $default_state; ?>" placeholder="Incident District" type="text" data-base="search_btn" data-nonedit="yes">


						</div>

						<div class="form_field width20">

							<div class="label">Date of Incident

								<!--            <span class="md_field">*</span>-->
							</div>

							<div class="input">

								<input name="inc_date" tabindex="10" class="form_input filter_if_not_blank  mi_calender filter_date inc_date_filt" placeholder="YYYY-MM-DD" type="text" data-errors="{filter_required:'Incident date should not be blank',filter_date:'Date format is not valid'}" data-base="search_btn">

							</div>

						</div>

						<div class="form_field width20">

							<div class="label">Time Of Incident
								<!--            <span class="md_field">*</span>-->
							</div>

							<div class="input">

								<input name="inc_time" tabindex="11" class="mi_autocomplete filter_if_not_blank filter_time inc_time_filt" placeholder="12 AM-12 PM" type="text" data-href="{base_url}auto/get_tinterval" data-errors="{filter_required:'Plase select time from dropdown list',filter_time:'Time format is not valid'}" data-base="search_btn" data-autocom="yes">

							</div>

						</div>
						<div class="form_field width_30">
							<label for="">&nbsp;</label>
						</div>
						<div class="form_field width_20" style="display: flex;">


							<input name="reset_filter" tabindex="12" value="RESET FILTER" class=" click-xhttp-request  width100 float_right" data-href="{base_url}patients/pt_inc_list" data-qr="output_position=inc_details&filter=true" type="reset" style="font-weight: bold;">
						</div>
						<div class="form_field width_15 ml-3" style="display: flex;">

							<input name="search_btn" tabindex="12" value="SEARCH" class=" base-xhttp-request  width100" data-href="{base_url}patients/pt_inc_list" data-qr="output_position=inc_details" type="button" style="padding: 5px !important;">

						</div>
					</div>
					        <div id="nonright_half">
            <table id="script_table">
                <!--<tr>
                    <td id="script_table_td">Standard Remarks Marathi</td>
                    <td>कॉलर ने १०८ सुविधेची स्तुती/ प्रशंसा करण्यासाठी कॉल केलेला आहे.</td>

                </tr>-->
                 <tr>
                    <td id="script_table_td">Standard Remarks Hindi</td>
                    <td>कॉलर ने 108 संजीवनी सुविधा की प्रशंसा करने के लिए कॉल किया हुआ है| </td>

                </tr>
                <!--<tr>
                    <td id="script_table_td">Call Type Wise Handling Script in Marathi</td>
                    <td>वेळ काढून आपण १०८ च्या सुविधेची स्तुती/ प्रशंसा करण्यासाठी कॉल केला आहे त्यासाठी आम्ही आपले आभार मानतो. आपला फीडबॅक आमच्या साठी खूप महत्त्वाचा आहे. भविष्यात हि अशीच आपल्यासाठी उपयुक्त सेवा देण्यासाठी आम्ही नेहमी तत्पर राहू.
                    </td>
                </tr>-->
                <!--<tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>धन्यवाद! आपकी फीडबैक हमारे लिए महत्त्वपूर्ण हैं!
                    </td>
                </tr>-->
                <tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>सुविधा की प्रशंसा करने के लिए 108 संजीवनी पर कॉल करने के लिए समय निकालने के लिए हम आपको धन्यवाद देते हैं।
                        <br><br> आपका फ़ीडबैक हमारे लिए बहुत महत्वपूर्ण है। हम भविष्य में आप की सेवा के लिए तत्पर हैं।
                    </td>
                </tr>


            </table>
        </div>

                </div>

                <div id="inc_details">


                </div>

                <!--  <div class="width100 enquiry_summary">
            <div class="width2 form_field float_left ">
                <div class="label blue float_left width_25">District</div>
                <div class="width75 float_left">
                   <?php

                    $district_id = '';

                    $dt = array('dst_code' => $district_id, 'st_code' => 'MP', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                    echo get_district_tahsil($dt);
                    ?>
                </div>

            </div>
            <div class="width2 form_field float_left">
                <div class="label blue float_left width_16">Call Type</div>

                <div class=" float_left width75" id="ero_summary_other">
                      <select id="call_purpose" name="cl_purpose" class="filter_required"  data-errors="{filter_required:'Please select Call Type from dropdown list'}">
                                  <option value="">Purpose Of calls</option>
                                  <?php

                                    foreach ($purpose_of_calls as $purpose_of_call) {
                                        echo "<option value='" . $purpose_of_call->pcode . "'  ";

                                        echo " >" . $purpose_of_call->pname;
                                        echo "</option>";
                                    }
                                    ?>
                              </select>
                </div>
            </div>

        </div>-->

<div class="width2">
                <div class="width100 enquiry_summary">
                    <div class="width100 form_field float_left ">
                        <div class="label blue float_left width_20">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                        <div class="width75 float_left">
                            <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?= @$inc_details['inc_ero_standard_summary']; ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2" data-href="{base_url}auto/get_ero_standard_summary?call_type=<?php echo $cl_type; ?>" placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8">
                        </div>

                    </div>
                </div>
				<div class="width100 enquiry_summary">
                    <div class="width100 form_field float_left">
                        <div class="label blue float_left width_20">Appreciation<span class="md_field">*</span>&nbsp;</div>

                        <div class=" float_left width75" id="appriciation">
                            <textarea style="height:60px;" name="incient[appriciation]" class="width_100 " TABINDEX="16" data-maxlen="1600" data-errors="{filter_required:'Appriciation should not be blank'}"><?= @$inc_details['appriciation']; ?></textarea>
                        </div>
                    </div>

                </div>
                <div class="width100 enquiry_summary">
                    <div class="width100 form_field float_left">
                        <div class="label blue float_left width_20">ERO Note</div>

                        <div class=" float_left width75" id="ero_summary_other">
                            <textarea style="height:60px;" name="incient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="1600" data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                        </div>
                    </div>

                </div>

</div>

                <div class="button_field_row  text_align_center" style="display: inline-block;">

                    <div class="button_box enquiry_button">

                        <input type="hidden" name="submit" value="sub_enq" />
                        <input type="hidden" name="non_eme_call[cl_type]" value="<?php echo $cl_type; ?>" />
                        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">
                        <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">
                        <input type="hidden" id="hidden_caller_id" name="caller_id" value="<?php echo $caller_id; ?>">
                        <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">
                        <input type="hidden" name="incient[CallUniqueID]" value="<?php echo $CallUniqueID; ?>">
                        <div id="fwdcmp_btn">


                        </div>


                    </div>

                </div>






            </form>


        </div>




    </div>
</div>
</div>