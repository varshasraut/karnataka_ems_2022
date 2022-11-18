<script>
    if(typeof H != 'undefined'){
        init_auto_address();
    }
</script>


<?php
$CI = EMS_Controller::get_instance();

$view = ($hp_action == 'view') ? 'disabled' : '';

if($hp_action == 'edit'){
    $edit = 'disabled';
}

$title = ($hp_action == 'edit') ? " Edit Hospital Details " : (($hp_action == 'view') ? "View Hospital Details" : "Add Hospital Details");
?> 
<form enctype="multipart/form-data" action="#" method="post" id="hp_form">

<div class="width1 float_left">

    <div class="box3">

       

            <!--<h2 class="txt_clr2"><?php echo $title; ?></h2>-->
            <h2 class="txt_clr2 width1 txt_pro"><?php echo $title; ?></h2>
            <div class="store_details_box">
                <div class="field_row width100">
                    <div class="width2 float_left">


                        <div class="field_lable float_left width33"> <label for="hp_name">Hospital Name<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                            <input id="hp_name" type="text" name="hp_name" class="filter_required controls filter_word"  data-errors="{filter_required:'Facility name should not be blank',filter_word:'Base Location Name should be valid}" value="<?= @$update[0]->hp_name ?>"<?php echo $view; ?> placeholder="Hospital Name" TABINDEX="1" <?php echo $edit; ?> >
                        </div>


                    </div> 
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="type_hp">Type of hospital<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50 " >
                            <select name="type_hp" class="amb_status filter_required" <?php echo $view; ?> TABINDEX="2" data-errors="{filter_required:'Type of hospitals name should not be blank'}">
                                <option value="">Type of hospital</option>
                                <?php echo get_hosp_type($update[0]->hp_type); ?>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="reg_local_address">Area<span class="md_field">*</span></label></div>
                        <div class="filed_select float_left width50">
                            <select name="area_type" class="amb_status filter_required" <?php echo $view; ?> TABINDEX="3"  data-errors="{filter_required:'Area should not be blank'}">

                                <option value="" >Select Area</option>

                                <?php echo get_area_type($update[0]->hp_area_type); ?>
                            </select>
                        </div>
                    </div> 
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="mb_no">Mobile Number<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50 ">
                            <input id="marks" type="text" name="mb_no" value="<?php echo $update[0]->hp_mobile; ?>" class="filter_required filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace" data-errors="{filter_required:'Mobile Number should not be blank', filter_number:'Mobile Number should be in numeric characters only.', filter_minlength:'Mobile Number should be at least 10 digits long',filter_maxlength:'Mobile Number should less then 11 digits.',filter_no_whitespace:'Mobile Number should not be allowed blank space.', filter_mobile:'Mobile Number should be valid.'}" <?php echo $view; ?> TABINDEX="4" placeholder="Mobile Number">
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                <div class="width2 float_left">


                        <div class="field_lable float_left width33"> <label for="contact_person">Contact Person</label></div>

                        <div class="filed_input float_left width50">
                            <input id="contact_person" type="text" name="contact_person"  value="<?= @$update[0]->hp_contact_person ?>"<?php echo $view; ?> placeholder="Contact person Name" TABINDEX="1" >
                        </div>


                        </div> 
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="mb_no2">Mobile Number</label></div>
                        <div class="filed_input float_left width50 ">
                            <input id="contact_person_mobile" type="text" name="contact_person_mobile" value="<?php echo $update[0]->hp_contact_mobile; ?>"  <?php echo $view; ?> TABINDEX="4" placeholder="Enter Contact person No">
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"> <label for="reg_no">Registration No</label></div>

                        <div class="filed_input float_left width50">
                            <input id="reg_no" type="text" name="reg_no" class="filter_if_not_blank filter_number" value="<?php echo $update[0]->hp_register_no ?>"<?php echo $view; ?> TABINDEX="5" placeholder="Registration No" data-errors="{filter_number:'Allowed only numbers'}">
                        </div>
                    </div> 
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="email">Email ID</label></div>

                        <div class="filed_input  float_left width50 ">
                            <input id="email" type="text" name="hp_email" class="filter_email filter_if_not_blank no_ucfirst" value="<?= @$update[0]->hp_email ?>" data-errors="{filter_email:'Email should be valid.'}" <?php echo $view; ?> TABINDEX="6" placeholder="Email">
                        </div>

                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="hp_url">Hospital URL</label></div>

                        <div class="filed_input float_left width50">
                            <input id="hp_url" type="text" name="hp_url" value="<?php echo $update[0]->hp_url; ?>" class="filter_url filter_if_not_blank no_ucfirst"  data-errors="{filter_url:'Hosiptal URL should be valid.'}" <?php echo $view; ?> placeholder="https://www.yourwebsite.com" TABINDEX="7">

                        </div>

                    </div> 
                    <!-- <div class="width2 float_left">  
                        <div class="field_lable float_left width33"><label for="geo_fence">Radius for Geo-fencing<span class="md_field"></span></label></div>

                        <div class="filed_input  float_left width50">
                            <input id="geo_fence" type="text" name="geo_fence" value="<?php echo $update[0]->geo_fence; ?>" class=""   <?php echo $view; ?> TABINDEX="7.2">
                        </div>
                    </div> -->
                    <!-- <div class="width2 float_left">  
                        <div class="field_lable float_left width33"><label for="geo_fence">Radius for Geo-fencing<span class="md_field">*</span></label></div>

                        <div class="filed_input  float_left width50">
                            <input id="geo_fence" type="text" name="geo_fence" value="<?php echo $update[0]->geo_fence; ?>" class="filter_required filter_number"  data-errors="{filter_required:'Radius for Geo-fencing should not be blank',filter_number:'Radius for Geo-fencing should be in numeric characters only.'}" <?php echo $view; ?> TABINDEX="7.2">
                        </div>
                    </div> -->
                </div>

            </div>   

            <div class="add_details"> Hospital Address:</div>

            <div class="width100">

                <div class="field_row">

                    <div class="field_lable float_left width17"> <label for="address">Address<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width75">

                        <input name="hp_add" value="<?= @$update[0]->hp_address ?>"<?php echo $view; ?> id="pac-input" class="hp_dtl filter_required width97" TABINDEX="8" type="text" placeholder="Address" data-state="yes" data-dist="yes" data-city="yes" data-area="yes" data-lmark="yes" data-lane="yes" data-pin="yes" data-rel="hp_dtl" data-auto="hp_auto_addr"  data-lat="yes" data-log="yes" data-errors="{filter_required:'Address should not be blank.'}"> 

                    </div>
                </div>

            </div>
            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="state">State<span class="md_field">*</span></label></div>


                    <div id="hp_dtl_state" class="float_left filed_input width50">

                        <?php
                            $st = array('st_code' => $update[0]->hp_state, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);

                            echo get_state($st);
                        ?>

                    </div>


                </div>
                <div class="width2 float_left">

                    <div class="field_lable  float_left width33"><label for="district">District<span class="md_field">*</span></label></div>                           

                    <div id="hp_dtl_dist" class="float_left filed_input width50">
                        <?php
                        $dt = array('dst_code' => $update[0]->hp_district, 'st_code' => $update[0]->hp_state, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);

                        echo get_district($dt);
                        ?>


                    </div>

                </div>
                <div class="width2 float_left">

                    <div class="field_lable  float_left width33"><label for="tehsil">Tehsil</label></div>                           

                    <div id="hp_dtl_tahsil" class="float_left filed_input width50">
                        <?php

                        $dt = array('thl_id' => $update[0]->hp_tahsil, 'dst_code' => $update[0]->hp_district, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);

                        echo get_tahshil($dt);
                        ?>


                    </div>

                </div>
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="state">City<span class="md_field"></span></label></div>




                    <div id="hp_dtl_city"  class="float_left filed_input width50">      

                        <?php
                        $ct = array('cty_id' => $update[0]->hp_city, 'dst_code' => $update[0]->hp_district, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);
                        echo get_city($ct);
                        ?>


                    </div>


                </div>

            </div>
            <div class="field_row width100">

                
                <div class="width2 float_left">



                    <div class="field_lable  float_left width33"> <label for="area">Area/Locality</label></div>

                    <div class="float_left filed_input width50" id="hp_dtl_area">


                        <input name="hp_dtl_area" value="<?= @$update[0]->hp_area ?>"<?php echo $view; ?> class="auto_area" type="text" placeholder="Area/Locality" TABINDEX="12">

                    </div>

                </div>

                <div class="width2 float_left">

                    <div class="field_lable float_left width33"><label for="landmark">Landmark</label></div>

                    <div class="float_left filed_input width50" id="hp_dtl_lmark">

                        <input name="hp_dtl_lmark" value="<?= @$update[0]->hp_lmark ?>"<?php echo $view; ?> class="auto_lmark" data-base="" type="text" placeholder="Landmark" TABINDEX="12">

                    </div>
                </div>

            </div>
            <div class="field_row width100">

                   <div class="width2 float_left">
                    <div class="field_lable  float_left width33"> <label for="pincode">Pincode</label></div>

                    <div class="float_left filed_input width50" id="hp_dtl_pincode">


                        <input name="hp_dtl_pincode" value="<?= @$update[0]->hp_pincode ?>" <?php echo $view; ?> class="auto_pcode filter_if_not_blank filter_number" data-errors="{filter_number:'Pincode are allowed only number.'}" type="text" placeholder="Pincode" TABINDEX="15">

                    </div>

                </div>
<!--                <div class="width2 float_left">

                    <div class="field_lable float_left width33"> <label for="landmark">Lane</label></div>

                    <div class="float_left filed_input width50" >

                        <input name="hp_dtl_lane" value="<?= @$update[0]->hp_lane_street ?>"<?php echo $view; ?> class="auto_lane"  type="text" placeholder="Lane/Street" TABINDEX="14">

                    </div>



                </div>-->

            </div>  
            <div class="field_row width100">

<!--                <div class="width2 float_left">  
                    <div class="field_lable float_left width33"> <label for="house_no">House No</label></div>

                    <div class="float_left filed_input width50">
                        <input id="landmark" type="text" name="hp_dtl_hno" class="" value="<?= @$update[0]->hp_house_no ?>"<?php echo $view; ?> TABINDEX="14" placeholder="House No" id="hp_hno">
                    </div>


                </div>-->
<!--                <div class="width2 float_left">
                    <div class="field_lable  float_left width33"> <label for="pincode">Pincode</label></div>

                    <div class="float_left filed_input width50" id="hp_dtl_pcode">


                        <input name="hp_dtl_pincode" value="<?= @$update[0]->hp_pincode ?>" <?php echo $view; ?> class="auto_pcode filter_if_not_blank filter_number" data-errors="{filter_number:'Pincode are allowed only number.'}" type="text" placeholder="Pincode" TABINDEX="15">

                    </div>

                </div>-->

            </div>
    </div>
<!--    <div class="field_row width100">
        <div class="width2 float_left">
            <div class="field_lable  float_left width33"><label for="cty_name">Latitude<span class="md_field">*</span></label></div>

            <div id="hp_dtl_lat" class="float_left filed_input width50">      

                <input name="hp_dtl_area" value="<?= @$update[0]->amb_lat ?>"<?php echo $view; ?> class="auto_area" type="text" placeholder="Area/Locality" TABINDEX="12">

            </div>

        </div>


        <div class="width2 float_left">


            <div class="field_row">

                <div class="field_lable float_left width33"> <label for="area">longitude</label></div>

                <div class="float_left filed_input width50" id="hp_dtl_log">
                    <input name="hp_dtl_area" value="<?= @$update[0]->amb_log ?>"<?php echo $view; ?> class="auto_area" type="text" placeholder="longitude" TABINDEX="12">
                </div>
            </div>
        </div>

    </div>-->

<!--    <h4 class="add_details">Select Hospital location On Map(lang,lattd)<span class="md_field">*</span></h4>

    <div class="width100 float_left">


        <div class="field_row">

            <div class="field_lable">&nbsp;</div>

        </div>


        <input type="hidden" value="<?php echo $update[0]->hp_lat; ?>" id="drag" class="map_drag_edit"  data-errors="{filter_required:'Move Drag Location'}"> 

        <div class="map_box">

            <div id="googleMap" class="load_googleMap" style="width: 100%; height: 250px; background: #5A8E4A; "></div>

            <script>
                var i = 0;
                var drag;
                if (i == 0) {

                    setTimeout(function () {
                        var map_obj = document.getElementById('googleMap');

    <?php
    if ($update[0]->hp_lat && $update[0]->hp_long) {

        $lat = $update[0]->hp_lat;
        $lng = $update[0]->hp_long;
    } else {
        $lat = 18.5204;
        $lng = 73.8567;
    }
    ?>

                        var ltlng = {lat:<?= $lat ?>, lng:<?= $lng ?>};

                        initMap(ltlng, map_obj);


                    }, 1000);

                    i++;
                }
            </script>

            <input type="hidden" name="lttd" value="<?php echo $update[0]->hp_lat; ?>" id="lttd" class="">
            <input type="hidden" name="lgtd" value="<?php echo $update[0]->hp_long; ?>" id="lgtd" class="">    
        </div>
    </div>  -->

    <div class="width_25 margin_auto">
        <div class="button_field_row text_center">
            <div class="button_box ">

                 <input type="hidden" name="req" value="<?php echo $req; ?>">
                <?php if (!(@$hp_action == 'view')) { ?>

                    <input type="hidden" name="sub_hp" value="user_registration" />

    <!--                    <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url(); ?>hp/<?php if ($update) { ?>edit_hp<?php } else { ?>add_hp<?php } ?>' data-qr='hp_id[0]=<?php echo base64_encode($update[0]->hp_id); ?>&amp;page_no=<?php echo @$page_no; ?>&amp;req=<?php echo @$req; ?>&amp;fc_type=<?php echo @$fc_type; ?>&amp;output_position=content' TABINDEX="20">-->
                    
                                <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url(); ?>hp/<?php if ($update) { ?>edit_hp<?php } else { ?>add_hp<?php } ?>'  data-qr='hp_id[0]=<?php echo base64_encode($update[0]->hp_id); ?>&amp;page_no=<?php echo $page_no; ?>&amp;req=<?php echo @$req; ?>&amp;fc_type=<?php echo @$fc_type; ?>&amp;output_position=content' TABINDEX="12">
                    
                             

                    <!--<input type="reset" name="reset" value="Reset" class="register_view_reset" TABINDEX="21">-->
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</form>
</div>
</div>