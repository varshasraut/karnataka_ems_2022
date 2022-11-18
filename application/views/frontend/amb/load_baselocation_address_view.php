<?php
$view =  'disabled'; ?> 

<div class="field_row width100">

                            <div class="width2 float_left">
                                <div class="field_lable float_left width33"><label for="address">Address</label></div>   

                                <div class="field_input float_left width50">
                                    <input name="amb_google_address" value="<?= @$update[0]->hp_address ?>"<?php echo $view; ?> id="pac-input" class="hp_dtl width97" TABINDEX="8" type="text" placeholder="Address" data-state="yes" data-dist="yes" data-city="yes" data-area="yes" data-lmark="yes" data-lane="yes" data-pin="yes" data-lat="yes" data-log="yes" data-rel="hp_dtl" data-auto="hp_auto_addr" > 
                                    <div id="result"><table id="sugg"></table></div>
                                </div>
                            </div>

                            <div class="width2 float_left">
                                <div class="field_lable float_left width33"><label for="state">State</label></div>


                                <div id="hp_dtl_state" class="float_left filed_input width50">


                                    <?php
                                    $st = array('st_code' => $update[0]->hp_state, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);

                                    echo get_state($st);
                                    ?>

                                </div>


                            </div>


                        </div>


                        <div class="field_row width100">
                            <div class="width2 float_left">

                                <div class="field_lable  float_left width33"><label for="district">District</label></div>                           

                                <div id="hp_dtl_dist" class="float_left filed_input width50">


                                    <?php
                                    $dt = array('dst_code' => $update[0]->hp_district, 'st_code' => $update[0]->hp_state, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl','disabled' => 'disabled');

                                    echo get_district($dt);
                                    ?>




                                </div>

                            </div>
                            <div class="width2 float_left">
                                <div class="field_lable  float_left width33"><label for="cty_name">City<span class="md_field"></span></label></div>

                                <div id="hp_dtl_city" class="float_left filed_input width50">      

                                    <?php
                                   /// $ct = array('cty_id' => $update[0]->hp_city, 'dst_code' => $update[0]->hp_district, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);
                                   $ct = array('cty_id' => $update[0]->hp_city, 'dst_code' => $update[0]->hp_district, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => 'disabled'); 
                                   echo get_city($ct);
                                    ?>

                                </div>

                            </div>
                        </div>
                        <div class="field_row width100">
                            <div class="width2 float_left">


                                <div class="field_row">

                                    <div class="field_lable float_left width33"> <label for="area">Locality</label></div>

                                    <div class="float_left filed_input width50" id="hp_dtl_area">
                                        <input  name="hp_dtl_area" value="<?= @$update[0]->hp_lane_street ?>" class="auto_area" type="text" placeholder="Area/Locality" TABINDEX="12" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="width2 float_left">
                                <div class="field_lable  float_left width33"><label for="cty_name">Latitude</label></div>

                                <div id="hp_dtl_lat" class="float_left filed_input width50">      

                                    <input name="lttd" value="<?= @$update[0]->hp_lat ?>" class="auto_area" type="text" placeholder="Area/Locality" TABINDEX="12" disabled>

                                </div>

                            </div>




                        </div>
                        <div class="field_row float_left width100">
                         <div class="width2 float_left">


                                <div class="field_row">

                                    <div class="field_lable float_left width33"> <label for="area">longitude</label></div>

                                    <div class="float_left filed_input width50" id="hp_dtl_log">
                                        <input name="lgtd" value="<?= @$update[0]->hp_long ?>"<?php // echo $view; ?> class="auto_area" type="text" placeholder="longitude" TABINDEX="12" disabled>
                                    </div>
                                </div>
                            </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="reg_local_address">Working Area</label></div>
                            <div  class="filed_select float_left filed_input width50">
                                <select name="working_area" class="amb_status" <?php //echo $view; ?> TABINDEX="4" disabled>
                                    <option value="" >Select Area</option>
                                    <?php echo get_area_type($update[0]->hp_area_type); ?>
                                </select>
                            </div>
                        </div>


                    </div>
<input type="hidden" name="working_area" value="<?php echo $update[0]->hp_area_type;?>">
<input type="hidden" name="amb_google_address" value="<?php echo $update[0]->hp_address;?>">
<input type="hidden" name="lgtd" value="<?php echo $update[0]->hp_long;?>">
<input type="hidden" name="lttd" value="<?php echo $update[0]->hp_lat;?>">
<input type="hidden" name="hp_dtl_area" value="<?php echo $update[0]->hp_lane_street;?>">
<input type="hidden" name="hp_dtl_state" value="<?php echo $update[0]->hp_state;?>">
<input type="hidden" name="hp_dtl_ms_city" value="<?php echo $update[0]->hp_city;?>">
<input type="hidden" name="hp_dtl_district" value="<?php echo $update[0]->hp_district;?>">