<div class="width100 float_left open_greet_quality"  id="amb_equipment_model">

                            <div class="width100 float_left blue_bar_new " id="open_greet_ques_outer">
                                <div class="width70 float_left ">
                                    <div class="label  float_left   white strong">&nbsp;&nbsp;Equipment Status </div>
                                </div>
                                <div class="width30 float_left">
                                    <div class="quality_arrow_back">
                                    </div>
                                </div>
                            </div><br>

                            <div class="checkbox_div hide">
                                <div class="width100 float_left open_greet_quality_new">
                                    <div class="width100 float_left  green_bar" id="open_greet_ques_outer">
                                        <div class="width50 float_left ">
                                            <div class="label  float_left   white strong">&nbsp;&nbsp;Critical Equipment Status </div>
                                        </div>
                                        <!-- <div class="width20 float_left ">
                                            <div class="label  float_left   white strong">Complete&nbsp;&nbsp; &nbsp;&nbsp; </div>
                                            <label class="switch">
                                                <?php if ($result != '') { ?>
                                                    <input type="checkbox" id="check6" onclick="checkfuc6()" disabled>
                                                    <span class="slider round"></span>

                                                <?php } else {
                                                ?>
                                                    <input type="checkbox" id="check6" onclick="checkfuc6()">
                                                    <span class="slider round"></span>

                                                <?php  } ?>

                                            </label>
                                        </div> -->
                                        <div class="width50 float_left">
                                            <div class="quality_arrow_back_new">
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="checkbox_div_new hide"><br>
                                        <div class="width50 float_left">
                                            <div class="width40 float_left">
                                                <label for="" >Equipment List</label>
                                            </div>
                                            <div class="width60 float_left">
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Availability Status</label>
                                                </div>
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Functional Status</label>
                                                </div>
                                                <div class="width50 float_left">
                                                    <label class="lblhead_eqp" for="" >Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="width50 float_left">
                                            <div class="width40 float_left">
                                                <label class="lblhead_eqp" for="">Equipment List</label>
                                            </div>
                                            <div class="width60 float_left">
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Availability Status</label>
                                                </div>
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Functional Status</label>
                                                </div>
                                                <div class="width50 float_left">
                                                    <label class="lblhead_eqp" for="" >Date</label>
                                                </div>
                                            </div>
                                        </div>

                                        <?php foreach ($equipment_list_critical as $key => $equipment_critical) {
                                            if (!empty($result[0]->id)) {
                                                $ec_data =  show_critical_data_para($equipment_critical->eqp_id, $result[0]->id);
                                                $ec_ope =  show_oprational_data_para($equipment_critical->eqp_id, $result[0]->id);
                                                $ec_dt =  show_date_data_para($equipment_critical->eqp_id, $result[0]->id);
                                            }
                                            //var_dump($data);
                                        ?>
                                            <div class="width50 float_left" style="border-left:3px solid black;">
                                                <div class="width40 float_left">
                                                    <label><?php echo $equipment_critical->eqp_name; ?></label>
                                                </div>
                                                <div class="width60 float_left">
                                                    <div class="width25 float_left">
                                                        <select name="critical_eqp_status[<?php echo $equipment_critical->eqp_id; ?>][status]" tabindex="8" id="critsts<?php echo $equipment_critical->eqp_id; ?>" class="filter_required classremoval" data-errors="{filter_required:'Equipment Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                        echo $approve;
                                                                                                                                                                                                                                                                                                                                                        echo $rerequest; ?>>
                                                            <option value="">Select Option</option>

                                                            <option value="Available" <?php if ($ec_data == 'Available') {
                                                                                            echo "selected";
                                                                                        } ?>>Available</option>
                                                            <option value="Not_Available" <?php if ($ec_data == 'Not_Available') {
                                                                                                echo "selected";
                                                                                            } ?>>Not Available</option>

                                                        </select>
                                                    </div>
                                                    <div class="width25 float_left">
                                                        <select name="critical_eqp_status[<?php echo $equipment_critical->eqp_id; ?>][oprational]" id="critopl<?php echo $equipment_critical->eqp_id; ?>" tabindex="8" class="filter_required imp_select classremoval" data-id="<?= $equipment_critical->eqp_id ?>" data-errors="{filter_required:'Equipment Critical Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                                                            echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                                                            echo $rerequest; ?>>
                                                            <option value="">Select Option</option>
                                                            <option value="Functional" <?php if ($ec_ope == 'Functional') {
                                                                                            echo "selected";
                                                                                        } ?>>Functional</option>
                                                            <option value="Non_Functional" <?php if ($ec_ope == 'Non_Functional') {
                                                                                                echo "selected";
                                                                                            } ?>>Non-Functional</option>

                                                        </select>
                                                    </div>
                                                    <div class="width50 float_left">
                                                        <div class="field_lable float_left width20"> <label for="mt_estimatecost">Date<span class="md_field"></span></label></div>
                                                        <div class="filed_input float_left width70">
                                                            <input type="text" name="critical_eqp_status[<?php echo $equipment_critical->eqp_id; ?>][date_from]" value=" <?php if ($ec_dt != '0000-00-00 00:00:00' && $ec_dt != '') {
                                                                                                                                                                                echo $ec_dt;
                                                                                                                                                                            } ?>" class="OnroadDate imp_class removedt6 disdate" placeholder="Please select date" data-errors="{filter_required:' Date should not be blank'}" TABINDEX="8" <?php if ($ec_dt != '0000-00-00 00:00:00' && $ec_dt != '') {
                                                                                                                                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                                                                                                                                            } ?> id="">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php } ?>
                                        <input type="text" id="critical" value="<?= $key + 1 ?>" hidden>
                                        <div class="width100">
                                            <div class="width50 float_left">
                                                <input name="critical_eqp_status_remark" tabindex="23" class="form_input Remark filter_required classremoval" id="critrem" placeholder="Enter Remark*" type="text" data-errors="{filter_required:'Remark should not be blank!'}" value="<?= $result_equip[0]->remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                                                                                                $rerequest; ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="width100 float_left open_greet_quality_new">
                                    <div class="width100 float_left green_bar " id="open_greet_ques_outer">
                                        <div class="width50 float_left ">
                                            <div class="label  float_left   white strong">&nbsp;&nbsp;Major Equipment Status </div>
                                        </div>
                                        <!-- <div class="width20 float_left ">
                                            <div class="label  float_left   white strong">Complete&nbsp;&nbsp; &nbsp;&nbsp; </div>
                                            <label class="switch">
                                                <?php if ($result != '') { ?>
                                                    <input type="checkbox" id="check7" onclick="checkfuc7()" disabled>
                                                    <span class="slider round"></span>

                                                <?php } else {
                                                ?>
                                                    <input type="checkbox" id="check7" onclick="checkfuc7()">
                                                    <span class="slider round"></span>

                                                <?php  } ?>

                                            </label>
                                        </div> -->
                                        <div class="width50 float_left">
                                            <div class="quality_arrow_back_new">
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="checkbox_div_new hide"><br>
                                        <div class="width50 float_left">
                                            <div class="width40 float_left">
                                                <label class="lblhead_eqp" for="" >Equipment List</label>
                                            </div>
                                            <div class="width60 float_left">
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Availability Status</label>
                                                </div>
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Functional Status</label>
                                                </div>
                                                <div class="width50 float_left">
                                                    <label class="lblhead_eqp" for="" >Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="width50 float_left">
                                            <div class="width40 float_left">
                                                <label class="lblhead_eqp" for="" >Equipment List</label>
                                            </div>
                                            <div class="width60 float_left">
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Availability Status</label>
                                                </div>
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Functional Status</label>
                                                </div>
                                                <div class="width50 float_left">
                                                    <label class="lblhead_eqp" for="" >Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php foreach ($equipment_list_major as $key => $equipment_major) {
                                            if (!empty($result[0]->id)) {
                                                $em_data =  show_critical_data_para($equipment_major->eqp_id, $result[0]->id);
                                                $em_ope =  show_oprational_data_para($equipment_major->eqp_id, $result[0]->id);
                                                $em_dt =  show_date_data_para($equipment_major->eqp_id, $result[0]->id);
                                            }

                                        ?>
                                            <div class="width50 float_left" style="border-left:3px solid black;">
                                                <div class="width40 float_left">
                                                    <label><?php echo $equipment_major->eqp_name; ?></label>
                                                </div>
                                                <div class="width60 float_left">
                                                    <div class="width25 float_left">
                                                        <select name="major_eqp_status[<?php echo $equipment_major->eqp_id; ?>][status]" tabindex="8" id="majorsts<?php echo $equipment_major->eqp_id; ?>" class="filter_required classremoval" data-errors="{filter_required:'Equipment Major Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                    echo $approve;
                                                                                                                                                                                                                                                                                                                                                    echo $rerequest; ?>>
                                                            <option value="">Select Option</option>
                                                            <option value="Available" <?php if ($em_data  == 'Available') {
                                                                                            echo "selected";
                                                                                        } ?>>Available</option>
                                                            <option value="Not_Available" <?php if ($em_data  == 'Not_Available') {
                                                                                                echo "selected";
                                                                                            } ?>>Not Available</option>

                                                        </select>
                                                    </div>

                                                    <div class="width25 float_left">
                                                        <select name="major_eqp_status[<?php echo $equipment_major->eqp_id; ?>][oprational]" tabindex="8" id="majoropl<?php echo $equipment_major->eqp_id; ?>" class="filter_required imp_select classremoval" data-id="<?= $equipment_major->eqp_id ?>" data-errors="{filter_required:'Equipment Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                                        echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                                        echo $rerequest; ?>>
                                                            <option value="">Select Option</option>
                                                            <option value="Functional" <?php if ($em_ope == 'Functional') {
                                                                                            echo "selected";
                                                                                        } ?>>Functional</option>
                                                            <option value="Non_Functional" <?php if ($em_ope == 'Non_Functional') {
                                                                                                echo "selected";
                                                                                            } ?>>Non-Functional</option>

                                                        </select>
                                                    </div>
                                                    <div class="width50 float_left">
                                                        <div class="field_lable float_left width20"> <label for="mt_estimatecost">Date<span class="md_field"></span></label></div>
                                                        <div class="filed_input float_left width70">
                                                            <input type="text" name="major_eqp_status[<?php echo $equipment_major->eqp_id; ?>][date_from]" value=" <?php if ($em_dt != '0000-00-00 00:00:00' && $em_dt != '') {
                                                                                                                                                                        echo $em_dt;
                                                                                                                                                                    } ?>" class="OnroadDate imp_class2 removedt7" placeholder="Please select date" data-errors="{filter_required:' Date should not be blank'}" TABINDEX="8" <?php if ($em_dt != '0000-00-00 00:00:00' && $em_dt != '') {
                                                                                                                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                                                                                                                            } ?> id="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <?php } ?>
                                        <input type="text" id="major" value="<?= $key + 1 ?>" hidden>

                                        <div class="width100">
                                            <div class="width50 float_left">
                                                <input name="major_eqp_status_remark" tabindex="23" class="form_input filter_required classremoval" id="majorrem" placeholder="Enter Remark*" type="text" data-errors="{filter_required:'Remark should not be blank!'}" value="<?= $result_equip[0]->remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                        echo $approve;
                                                                                                                                                                                                                                                                                                                                        echo $rerequest; ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="width100 float_left open_greet_quality_new">
                                    <div class="width100 float_left green_bar " id="open_greet_ques_outer">
                                        <div class="width50 float_left ">
                                            <div class="label  float_left   white strong">&nbsp;&nbsp;Minor Status </div>
                                        </div>
                                        <!-- <div class="width20 float_left ">
                                                <div class="label  float_left   white strong">Complete&nbsp;&nbsp; &nbsp;&nbsp; </div>
                                                <label class="switch">
                                                    <?php if ($result != '') { ?>
                                                        <input type="checkbox" id="check8" onclick="checkfuc8()" disabled>
                                                        <span class="slider round"></span>

                                                    <?php } else {
                                                    ?>
                                                        <input type="checkbox" id="check8" onclick="checkfuc8()">
                                                        <span class="slider round"></span>

                                                    <?php  } ?>

                                                </label>
                                            </div> -->
                                        <div class="width50 float_left">
                                            <div class="quality_arrow_back_new">
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="checkbox_div_new hide"><br>
                                        <div class="width50 float_left">
                                            <div class="width40 float_left">
                                                <label class="lblhead_eqp" for="" >Equipment List</label>
                                            </div>
                                            <div class="width60 float_left">
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Availability Status</label>
                                                </div>
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Functional Status</label>
                                                </div>
                                                <div class="width50 float_left">
                                                    <label class="lblhead_eqp" for="" >Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="width50 float_left">
                                            <div class="width40 float_left">
                                                <label class="lblhead_eqp" for="" >Equipment List</label>
                                            </div>
                                            <div class="width60 float_left">
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Availability Status</label>
                                                </div>
                                                <div class="width25 float_left">
                                                    <label class="lblhead_eqp" for="" >Functional Status</label>
                                                </div>
                                                <div class="width50 float_left">
                                                    <label class="lblhead_eqp" for="" >Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php foreach ($equipment_list_minor as $key => $equipment_minor) {
                                            // var_dump($result[0]->id);
                                            if (!empty($result[0]->id)) {
                                                $eq_data =  show_critical_data_para($equipment_minor->eqp_id, $result[0]->id);
                                                $eq_dt =  show_date_data_para($equipment_minor->eqp_id, $result[0]->id);

                                                $eq_ope =  show_oprational_data_para($equipment_minor->eqp_id, $result[0]->id);
                                            }
                                        ?>
                                            <div class="width50 float_left" style="border-left:3px solid black;">
                                                <div class="width40 float_left">
                                                    <label><?php echo $equipment_minor->eqp_name; ?></label>
                                                </div>
                                                <div class="width60 float_left">
                                                    <div class="width25 float_left">
                                                        <select name="minor_eqp_status[<?php echo $equipment_minor->eqp_id; ?>][status]" id="minor<?php echo $equipment_minor->eqp_id; ?>" tabindex="8" class="filter_required minorsts classremoval" data-errors="{filter_required:'Equipment Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                    echo $approve;
                                                                                                                                                                                                                                                                                                                                                    echo $rerequest; ?>>
                                                            <option value="">Select Option</option>
                                                            <?php if ($key == 1) { ?>

                                                            <?php } ?>
                                                            <option value="Available" <?php if ($eq_data === 'Available') {
                                                                                            echo "selected";
                                                                                        } ?>>Available</option>
                                                            <option value="Not_Available" <?php if ($eq_data === 'Not_Available') {
                                                                                                echo "selected";
                                                                                            } ?>>Not Available</option>

                                                        </select>
                                                    </div>
                                                    <div class="width25 float_left">
                                                        <select name="minor_eqp_status[<?php echo $equipment_minor->eqp_id; ?>][oprational]" id="minor<?php echo $equipment_minor->eqp_id; ?>" tabindex="8" class="filter_required imp_select3 minoropl classremoval" data-id="<?= $equipment_minor->eqp_id ?>" data-errors="{filter_required:'Equipment Status should not be blank!'}" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                                                echo $rerequest; ?>>
                                                            <option value="">Select Option</option>
                                                            <option value="Functional" <?php if ($eq_ope == 'Functional') {
                                                                                            echo "selected";
                                                                                        } ?>>Functional</option>
                                                            <option value="Non_Functional" <?php if ($eq_ope == 'Non_Functional') {
                                                                                                echo "selected";
                                                                                            } ?>>Non-Functional</option>

                                                        </select>
                                                    </div>
                                                    <div class="width50 float_left">
                                                        <div class="field_lable float_left width20"> <label for="mt_estimatecost">Date<span class="md_field"></span></label></div>
                                                        <div class="filed_input float_left width70">
                                                            <input type="text" name="minor_eqp_status[<?php echo $equipment_minor->eqp_id; ?>][date_from]" value=" <?php if ($eq_dt != '0000-00-00 00:00:00' && $eq_dt != '') {
                                                                                                                                                                        echo $eq_dt;
                                                                                                                                                                    } ?>" class="OnroadDate imp_class3 removedt8" placeholder="Please select date" data-errors="{filter_required:' Date should not be blank'}" TABINDEX="8" <?php if ($eq_dt != '0000-00-00 00:00:00' && $eq_dt != '') {
                                                                                                                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                                                                                                                            } ?> id="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <?php } ?>
                                        <input type="text" id="minor" value="<?= $key + 1 ?>" hidden>

                                        <div class="width100">
                                            <div class="width50 float_left">
                                                <input name="minor_eqp_status_remark" tabindex="23" class="form_input filter_required classremoval" id="minorrem" placeholder="Enter Remark*" type="text" data-errors="{filter_required:'Remark should not be blank!'}" value="<?= $result_equip[0]->remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                        echo $approve;
                                                                                                                                                                                                                                                                                                                                        echo $rerequest; ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>

                                </div>


                            </div>

                            <!--<div id="maintaince_ambulance_type_view">
                            </div>-->
                        </div>

                        <script>
    jQuery(document).ready(function() {
        var jsDate = $("#offroad_datetime").val();
        var $mindate = new Date(jsDate);

        $('.OnroadDate').datepicker({
            dateFormat: "yy-mm-dd",
            minDate: $mindate,
            // minTime: jsDate[1],

        });
        $("#offroad_datetime").change(function() {
            var jsDate = $("#offroad_datetime").val();
            var $mindate = new Date(jsDate);
        });

        $('input[type=radio][name="app[mt_approval]"]').change(function() {
            //$("#ap").show();
            var app = $("input[name='app[mt_approval]']:checked").val();
            if (app == "1") {
                $(".ap").show();
            } else {
                $(".ap").hide();
            }
        });



    });

    $('#vehsts').change(function() {
        var vehsts = $("#vehsts").val();
        if (vehsts == 'amb_offroad') {

            $('.hideon').hide();
            $(".classremoval").removeClass("filter_required");

        } else {
            $('.hideon').show();
            $(".classremoval").addClass("filter_required");
        }
    });

    function checkfuc1() {
        var checkBox1 = document.getElementById("check1");
        var text1 = "Done";
        if (checkBox1.checked == true) {
            document.getElementById("main1").selectedIndex = "1";
            document.getElementById("status1").selectedIndex = "1";
            document.getElementById("remark1").value = text1;
            $(".removedt1").removeClass("filter_required");

        } else {
            document.getElementById("main1").selectedIndex = "";
            document.getElementById("status1").selectedIndex = "";
            document.getElementById("remark1").value = "";
            $(".removedt1").addClass("filter_required");

        }
    }

    function checkfuc2() {
        var checkBox2 = document.getElementById("check2");
        var text1 = "Done";
        if (checkBox2.checked == true) {
            document.getElementById("status2").selectedIndex = "1";
            document.getElementById("remark2").value = text1;
            $(".removedt2").removeClass("filter_required");

        } else {
            document.getElementById("status2").selectedIndex = "";
            document.getElementById("remark2").value = "";
            $(".removedt2").addClass("filter_required");

        }
    }

    function checkfuc3() {
        var checkBox3 = document.getElementById("check3");
        var text1 = "Done";
        if (checkBox3.checked == true) {
            document.getElementById("comp1").selectedIndex = "1";
            document.getElementById("comp2").selectedIndex = "1";
            document.getElementById("comp3").selectedIndex = "1";
            document.getElementById("comp4").selectedIndex = "1";
            document.getElementById("comp5").selectedIndex = "1";
            document.getElementById("comp6").selectedIndex = "1";
            document.getElementById("remcomp1").value = text1;
            document.getElementById("remcomp2").value = text1;
            document.getElementById("remcomp3").value = text1;
            document.getElementById("remcomp4").value = text1;
            document.getElementById("remcomp5").value = text1;
            document.getElementById("remcomp6").value = text1;
            $(".removedt3").removeClass("filter_required");

        } else {
            document.getElementById("comp1").selectedIndex = "";
            document.getElementById("comp2").selectedIndex = "";
            document.getElementById("comp3").selectedIndex = "";
            document.getElementById("comp4").selectedIndex = "";
            document.getElementById("comp5").selectedIndex = "";
            document.getElementById("comp6").selectedIndex = "";
            document.getElementById("remcomp1").value = "";
            document.getElementById("remcomp2").value = "";
            document.getElementById("remcomp3").value = "";
            document.getElementById("remcomp4").value = "";
            document.getElementById("remcomp5").value = "";
            document.getElementById("remcomp6").value = "";
            $(".removedt3").addClass("filter_required");

        }
    }

    function checkfuc4() {
        var checkBox4 = document.getElementById("check4");
        var text1 = "Done";
        if (checkBox4.checked == true) {
            document.getElementById("status4").selectedIndex = "1";
            document.getElementById("remark4").value = text1;
            $(".removedt4").removeClass("filter_required");

        } else {
            document.getElementById("status4").selectedIndex = "";
            document.getElementById("remark4").value = "";
            $(".removedt4").addClass("filter_required");

        }
    }

    function checkfuc5() {
        var checkBox5 = document.getElementById("check5");
        var text1 = "Done";
        if (checkBox5.checked == true) {
            document.getElementById("main2").selectedIndex = "1";

            document.getElementById("status5").selectedIndex = "1";
            document.getElementById("remark5").value = text1;
            $(".removedt5").removeClass("filter_required");

        } else {
            document.getElementById("main2").selectedIndex = "";

            document.getElementById("status5").selectedIndex = "";
            document.getElementById("remark5").value = "";
            $(".removedt5").addClass("filter_required");

        }
    }

    function checkfuc6() {
        var checkBox6 = document.getElementById("check6");
        var text1 = "Done";
        var critical = $('#critical').val();
        if (checkBox6.checked == true) {
            for (var i = 1; i <= critical; i++) {
                var critopl1 = "critopl" + i;
                var critopl2 = "critsts" + i;
                document.getElementById(critopl1).selectedIndex = "1";
                document.getElementById(critopl2).selectedIndex = "1";

            }
            document.getElementById("critrem").value = text1;
            $(".removedt6").removeClass("filter_required");
            $(".disdate").attr("disabled", "disabled");


        } else {
            for (var i = 1; i <= critical; i++) {
                var critopl1 = "critopl" + i;
                var critopl2 = "critsts" + i;
                document.getElementById(critopl1).selectedIndex = "";
                document.getElementById(critopl2).selectedIndex = "";

            }
            document.getElementById("critrem").value = "";
            $(".removedt6").addClass("filter_required");
            $(".disdate").removeAttr("disabled");


        }
    }

    function checkfuc7() {
        var checkBox7 = document.getElementById("check7");
        var text1 = "Done";
        var major = $('#major').val();

        if (checkBox7.checked == true) {
            for (var i = 1; i <= major; i++) {
                var majorsts1 = "majorsts" + i;
                var majoropl2 = "majoropl" + i;
                console.log(majorsts1);
                document.getElementById(majorsts1).selectedIndex = "1";
                document.getElementById(majoropl2).selectedIndex = "1";

            }
            document.getElementById("majorrem").value = text1;
            $(".removedt7").removeClass("filter_required");

        } else {
            for (var i = 1; i <= major; i++) {
                var majorsts1 = "majorsts" + i;
                var majoropl2 = "majoropl" + i;
                document.getElementById(majorsts1).selectedIndex = "";
                document.getElementById(majoropl2).selectedIndex = "";

            }
            document.getElementById("majorrem").value = "";
            $(".removedt7").addClass("filter_required");

        }
    }

    function checkfuc8() {
        var checkBox8 = document.getElementById("check8");
        var text1 = "Done";
        var major = $('#minor').val();
        if (checkBox8.checked == true) {
            for (var i = 1; i <= minor; i++) {
                var minorsts1 = "minorsts" + i;
                var minoropl2 = "minoropl" + i;
                document.getElementById(minorsts1).selectedIndex = "1";
                document.getElementById(minoropl2).selectedIndex = "1";

            }
            document.getElementById("minorrem").value = text1;
            $(".removedt8").removeClass("filter_required");

        } else {
            for (var i = 1; i <= minor; i++) {
                var minorsts1 = "minorsts" + i;
                var minoropl2 = "minoropl" + i;
                ss
                document.getElementById(minorsts1).selectedIndex = "";
                document.getElementById(minoropl2).selectedIndex = "";

            }
            document.getElementById("minorrem").value = "";
            $(".removedt8").addClass("filter_required");

        }
    }

    function sum() {
        var txtFirstNumberValue = document.getElementById('part_cost').value;
        var txtSecondNumberValue = document.getElementById('labour_cost').value;
        var result = parseInt(txtSecondNumberValue) + parseInt(txtFirstNumberValue);
        if (!isNaN(result)) {
            document.getElementById('total_cost').value = result;
        }
    }

    function ac_main() {
        var ac_sts = document.getElementById('comp1').value;

        if (ac_sts == "Working") {
            // alert(ac_sts);
            $(".stschange1").attr("disabled", "disabled");
            $(".stschange1").removeClass("filter_required");

        } else {
            $(".stschange1").removeAttr("disabled");
            $(".stschange1").addClass("filter_required");
        }
    }

    function tyre_main() {
        var tyre_sts = document.getElementById('comp2').value;

        if (tyre_sts == "Replaced" ||tyre_sts == "NA"  ) {
            // alert(ac_sts);
            $(".stschange2").attr("disabled", "disabled");
            $(".stschange2").removeClass("filter_required");

        } else {
            $(".stschange2").removeAttr("disabled");
            $(".stschange2").addClass("filter_required");
        }
    }

    function siren_main() {
        var siren_sts = document.getElementById('comp3').value;

        if (siren_sts == "Working") {
            // alert(ac_sts);
            $(".stschange3").attr("disabled", "disabled");
            $(".stschange3").removeClass("filter_required");

        } else {
            $(".stschange3").removeAttr("disabled");
            $(".stschange3").addClass("filter_required");
        }
    }

    function inv_main() {
        var inv_sts = document.getElementById('comp4').value;

        if (inv_sts == "Working") {
            // alert(ac_sts);
            $(".stschange4").attr("disabled", "disabled");
            $(".stschange4").removeClass("filter_required");

        } else {
            $(".stschange4").removeAttr("disabled");
            $(".stschange4").addClass("filter_required");
        }
    }

    function batt_main() {
        var batt_sts = document.getElementById('comp5').value;

        if (batt_sts == "Working") {
            // alert(ac_sts);
            $(".stschange5").attr("disabled", "disabled");
            $(".stschange5").removeClass("filter_required");

        } else {
            $(".stschange5").removeAttr("disabled");
            $(".stschange5").addClass("filter_required");
        }
    }

    function gps_main() {
        var gps_sts = document.getElementById('comp6').value;

        if (gps_sts == "Working") {
            // alert(ac_sts);
            $(".stschange6").attr("disabled", "disabled");
            $(".stschange6").removeClass("filter_required");

        } else {
            $(".stschange6").removeAttr("disabled");
            $(".stschange6").addClass("filter_required");
        }
    }
</script>
<script>
    function changebg() {
        var cng1 = document.getElementById('mvdate').value;
        var main1 = document.getElementById('main1').value;
        var status1 = document.getElementById('status1').value;
        var remark1 = document.getElementById('remark1').value;
        if (cng1 != " " && main1 != " " && status1 != " " && remark1 != " ") {
            document.getElementById("bgchange1").style.backgroundColor = "rgb(213 140 140)";
        } else {
            document.getElementById("bgchange1").style.backgroundColor = "#0ab9b9";
        }
    };

    function changebg2() {
        var cng2 = document.getElementById('mvdate2').value;
        var status2 = document.getElementById('status2').value;
        var remark2 = document.getElementById('remark2').value;
        if (cng2 != " " && status2 != " " && remark2 != " ") {
            document.getElementById("bgchange2").style.backgroundColor = "rgb(213 140 140)";
        } else {
            document.getElementById("bgchange2").style.backgroundColor = "#0ab9b9";
        }
    };

    function changebg3() {
        var comp1 = document.getElementById('comp1').value;
        var comp2 = document.getElementById('comp2').value;
        var comp3 = document.getElementById('comp3').value;
        var comp4 = document.getElementById('comp4').value;
        var comp5 = document.getElementById('comp5').value;
        var comp6 = document.getElementById('comp6').value;

        var stschange1 = document.getElementsByClassName('stschange1').value;
        var stschange2 = document.getElementsByClassName('stschange2').value;
        var stschange3 = document.getElementsByClassName('stschange3').value;
        var stschange4 = document.getElementsByClassName('stschange4').value;
        var stschange5 = document.getElementsByClassName('stschange5').value;
        var stschange6 = document.getElementsByClassName('stschange6').value;

        var remcomp1 = document.getElementById('remcomp1').value;
        var remcomp2 = document.getElementById('remcomp2').value;
        var remcomp3 = document.getElementById('remcomp3').value;
        var remcomp4 = document.getElementById('remcomp4').value;
        var remcomp5 = document.getElementById('remcomp5').value;
        var remcomp6 = document.getElementById('remcomp6').value;


        if (comp1 == " " || comp1 != " " && comp2 == " " || comp2 != " " && comp3 == " " || comp3 != " " && comp4 == " " || comp4 != " " && comp5 == " " || comp5 != " " && comp6 == " " || comp6 != " " &&
            stschange1 != " " && stschange2 != " " && stschange3 != " " && stschange4 != " " && stschange5 != " " && stschange6 != " " &&
            remcomp1 != " " && remcomp2 != " " && remcomp3 != " " && remcomp4 != " " && remcomp5 != " " && remcomp6 != " ") {
            document.getElementById("bgchange3").style.backgroundColor = "rgb(213 140 140)";
        } else {
            document.getElementById("bgchange3").style.backgroundColor = "#0ab9b9";
        }
    };

    function changebg4() {
        var cng4 = document.getElementById('mvdate4').value;
        var status4 = document.getElementById('status4').value;
        var remark4 = document.getElementById('remark4').value;
        if (cng4 != " " && status4 != " " && remark4 != " ") {
            document.getElementById("bgchange4").style.backgroundColor = "rgb(213 140 140)";
        } else {
            document.getElementById("bgchange4").style.backgroundColor = "#0ab9b9";
        }
    };

    function changebg5() {
        var cng5 = document.getElementById('mvdate5').value;
        var main5 = document.getElementById('main2').value;
        var status5 = document.getElementById('status5').value;
        var remark5 = document.getElementById('remark5').value;
        if (cng5 != " " && main5 != " " && status5 != " " && remark5 != " ") {
            // alert("hiii");
            document.getElementById("bgchange5").style.backgroundColor = "rgb(213 140 140)";
        } else {
            document.getElementById("bgchange5").style.backgroundColor = "#0ab9b9";
        }
    };
    $(".imp_select").change(function() {
        var id = $(this).attr("data-id");
        var a = 'critical_eqp_status[' + id + '][oprational]';
        var na = 'critical_eqp_status[' + id + '][date_from]';

        var status1 = (document.getElementsByName(a)[0].value);

        if (status1 == "Functional") {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");

        } else if (status1 == "Non_Functional") {

            $("input[name='" + na + "']").addClass("filter_required");
            // $('.imp_class').addClass("filter_required");
            $("input[name='" + na + "']").addClass("has_error");
        } else if (status1 == "   ") {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");

        } else {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");
        }
    });

    $(".imp_select2").change(function() {
        var id = $(this).attr("data-id");
        var a = 'major_eqp_status[' + id + '][oprational]';
        var na = 'major_eqp_status[' + id + '][date_from]';

        var status2 = (document.getElementsByName(a)[0].value);

        if (status2 == "Functional") {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");

        } else if (status2 == "Non_Functional") {
            $("input[name='" + na + "']").addClass("filter_required");
            $("input[name='" + na + "']").addClass("has_error");

        } else if (status2 == "") {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");

        } else {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");

        }
    });

    $(".imp_select3").change(function() {
        var id = $(this).attr("data-id");
        var a = 'minor_eqp_status[' + id + '][oprational]';
        var na = 'minor_eqp_status[' + id + '][date_from]';

        var status3 = (document.getElementsByName(a)[0].value);


        if (status3 == "Functional") {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");
        } else if (status3 == "Non_Functional") {
            $("input[name='" + na + "']").addClass("filter_required");
            $("input[name='" + na + "']").addClass("has_error");

        } else if (status3 == " ") {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");

        } else {
            $("input[name='" + na + "']").removeClass("filter_required");
            $("input[name='" + na + "']").removeClass("has_error");

        }
    });
</script>                   