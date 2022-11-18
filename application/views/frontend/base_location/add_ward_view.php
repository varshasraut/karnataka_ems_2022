<script> if(typeof H != 'undefined'){ init_auto_address(); }</script>


<?php
$CI = EMS_Controller::get_instance();

$view = ($wrd_action == 'view') ? 'disabled' : '';

if($wrd_action == 'edit'){
    $edit = 'disabled';
}

$title = ($wrd_action == 'edit') ? " Edit Ward Location Details " : (($wrd_action == 'view') ? "View Ward Location Details" : "Add Ward Location Details");
?> 
<form enctype="multipart/form-data" action="#" method="post" id="hp_form">

<div class="width1 float_left">

    <div class="box3">

            <!--<h2 class="txt_clr2"><?php echo $title; ?></h2>-->
            <h2 class="txt_clr2 width1 txt_pro"><?php echo $title; ?></h2>
            <div class="store_details_box">
                <div class="field_row width100">
                    <div class="width2 float_left">


                        <div class="field_lable float_left width33"> <label for="ward_name">Ward Name<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                            <input id="wrd_name" type="text" name="wrd_name" class="filter_required controls"  data-errors="{filter_required:'Ward Name should not be blank'}" value="<?= @$update[0]->ward_name ?>"<?php echo $view; ?> placeholder="Ward Name" TABINDEX="1" <?php echo $edit; ?> >
                        </div>
                    </div> 
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="mb_no">Mobile Number<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50 ">
                            <input id="marks" type="text" name="mb_no" value="<?php echo $update[0]->mob_no; ?>" class="filter_required filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace" data-errors="{filter_required:'Mobile Number should not be blank', filter_number:'Mobile Number should be in numeric characters only.', filter_minlength:'Mobile Number should be at least 10 digits long',filter_maxlength:'Mobile Number should less then 11 digits.',filter_no_whitespace:'Mobile Number should not be allowed blank space.', filter_mobile:'Mobile Number should be valid.'}" <?php echo $view; ?> TABINDEX="4" placeholder="Mobile Number">
                        </div>
                    </div>
                </div>
                
                <div class="field_row width100">
                    <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="reg_local_address">Working Area<span class="md_field">*</span></label></div>
                            <div  class="filed_select float_left filed_input width50">
                                <select name="working_area" class="amb_status filter_required" data-errors="{filter_required:'Working area should not be blank'}" <?php echo $view; ?> TABINDEX="4">
                                    <option value="" >Select Area</option>
                                    <?php echo get_area_type($update[0]->wrd_area_type); ?>
                                </select>
                            </div>
                    </div>
                </div>

            </div>   

            <div class="add_details"> Ward Location Address:</div>

            <div class="width100">

                <div class="field_row">

                    <div class="field_lable float_left width17"> <label for="address">Address<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width75">

                        <input name="hp_add" value="<?= @$update[0]->wrd_address ?>"<?php echo $view; ?> id="pac-input" class="hp_dtl filter_required width97" TABINDEX="8" type="text" placeholder="Address" data-state="yes" data-dist="yes" data-city="yes" data-area="yes" data-lmark="yes" data-lane="yes" data-pin="yes" data-rel="hp_dtl" data-auto="hp_auto_addr"  data-lat="yes" data-log="yes" data-errors="{filter_required:'Address should not be blank.'}"> 
                        <div id="result"><table id="sugg"></table></div>
                    </div>
                </div>

            </div>
            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="state">State<span class="md_field">*</span></label></div>


                    <div id="hp_dtl_state" class="float_left filed_input width50">

                        <?php
                        $st = array('st_code' => $update[0]->wrd_state, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);

                        echo get_state($st);
                        ?>

                    </div>


                </div>
                <div class="width2 float_left">

                    <div class="field_lable  float_left width33"><label for="district">District<span class="md_field">*</span></label></div>                           

                    <div id="hp_dtl_dist" class="float_left filed_input width50">
                        <?php
                        
                        $dt = array('dst_code' => $update[0]->wrd_district, 'st_code' => $update[0]->hp_state, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);

                        echo get_district($dt);
                        ?>


                    </div>

                </div>

            </div>
            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="state">City</label></div>




                    <div id="hp_dtl_city"  class="float_left filed_input width50">      

                        <?php
                        $ct = array('cty_id' => $update[0]->wrd_city, 'dst_code' => $update[0]->hp_district, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);
                        echo get_city($ct);
                        ?>


                    </div>


                </div>
                <div class="width2 float_left">



                    <div class="field_lable  float_left width33"> <label for="area">Area/Locality</label></div>

                    <div class="float_left filed_input width50" id="hp_dtl_area">


                        <input name="hp_dtl_area" value="<?= @$update[0]->wrd_area ?>"<?php echo $view; ?> class="auto_area" type="text" placeholder="Area/Locality" TABINDEX="12">

                    </div>

                </div>

            </div>
            <div class="field_row width100">

                <div class="width2 float_left">

                    <div class="field_lable float_left width33"><label for="landmark">Landmark</label></div>

                    <div class="float_left filed_input width50" id="hp_dtl_lmark">

                        <input name="hp_dtl_lmark" value="<?= @$update[0]->wrd_lmark ?>"<?php echo $view; ?> class="auto_lmark" data-base="" type="text" placeholder="Landmark" TABINDEX="12">

                    </div>
                </div>
                   <div class="width2 float_left">
                    <div class="field_lable  float_left width33"> <label for="pincode">Pincode</label></div>

                    <div class="float_left filed_input width50" id="hp_dtl_pcode">


                        <input name="hp_dtl_pincode" value="<?= @$update[0]->wrd_pincode ?>" <?php echo $view; ?> class="auto_pcode filter_if_not_blank filter_number" data-errors="{filter_number:'Pincode are allowed only number.'}" type="text" placeholder="Pincode" TABINDEX="15">

                    </div>

                </div>

            </div>  
            <div class="field_row width100">

                <div class="width2 float_left">

                <div class="field_lable float_left width33"><label for="lat">Lat</label></div>

                <div class="float_left filed_input width50" id="hp_dtl_lat">

                    <input name="lttd" value="<?= @$update[0]->wrd_lat ?>"<?php echo $view; ?> class="auto_lmark" data-base="" type="text" placeholder="hp_lat" TABINDEX="12">

                </div>
                </div>
                <div class="width2 float_left">
                <div class="field_lable  float_left width33"> <label for="long">Longpp</label></div>

                <div class="float_left filed_input width50" id="hp_dtl_log">


                    <input name="lgtd" value="<?= @$update[0]->wrd_long ?>" <?php echo $view; ?> class="auto_pcode filter_if_not_blank filter_number" data-errors="{filter_number:'Pincode are allowed only number.'}" type="text" placeholder="hp_long" TABINDEX="15">

                </div>

                </div>
        </div> 
    </div>
    <div class="width_25 margin_auto">
        <div class="button_field_row text_center">
            <div class="button_box ">

                <?php if (!(@$wrd_action == 'view')) { ?>

                    <input type="hidden" name="sub_hp" value="user_registration" />

                    <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url(); ?>base_location/<?php if ($update) { ?>edit_wrd<?php } else { ?>add_ward<?php } ?>'  data-qr='ward_id[0]=<?php echo base64_encode($update[0]->ward_id); ?>&amp;page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12">
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</form>
</div>
</div>