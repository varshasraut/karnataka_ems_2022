<div class="width100 float_left open_greet_quality" id="amb_medicine_model">

                            <div class="width100 float_left blue_bar_new " id="open_greet_ques_outer">
                                <div class="width70 float_left ">
                                    <div class="label  float_left   white strong">&nbsp;&nbsp;Medicine Status</div>
                                </div>
                                <div class="width30 float_left">
                                    <div class="quality_arrow_back"></div>
                                </div>
                            </div><br>
                            <div class="checkbox_div hide"><br>
                                <div class="width25 float_left">
                                    <label class="" for=""><b>Medicine List</b></label>
                                </div>
                                <div class="width10 float_left">
                                <label class="" for=""><b>Stock</b></label>
                                </div>
                                <div class="width15 float_left">
                                    <div class="width50 float_left">
                                    <label class="" for=""><b>Status</b></label>
                                    </div>
                                    <div class="width50 float_left">
                                    <label class="" for=""><b>Available Stock    </b></label>
                                    </div>
                                </div>

                                <div class="width25 float_left">
                                    <label class="" for=""><b>Medicine List</b></label>
                                </div>
                                <div class="width10 float_left">
                                <label class="" for=""><b>Stock</b></label>
                                </div>
                                <div class="width15 float_left">
                                    <div class="width50 float_left">
                                    <label class="" for=""><b>Status</b></label>
                                    </div>
                                    <div class="width50 float_left">
                                    <label class="" for=""><b>Available Stock    </b></label>
                                    </div>
                                </div>

                                <?php foreach ($medicine_list as $medicine) {
                                    if ($result[0]->id != '') {
                                        $medicine_data = get_ins_med_records(array('ins_id' => $result[0]->id, 'med_id' => $medicine->med_id));
                                    }
                                ?>
                                    <div class="width25 float_left">
                                        <label><?php echo $medicine->med_title; ?></label>
                                    </div>
                                    <div class="width10 float_left">
                                        <label><?php echo $medicine->exp_stock; ?></label>
                                    </div>
                                    <div class="width15 float_left">

                                        <div class="width50 float_left">
                                            <label for="open_<?php echo $medicine->med_title; ?>_yes" class="radio_check width2 float_left">
                                                <input id="open_<?php echo $medicine->med_title; ?>_yes" <?php echo $read; ?> type="radio" name="ins_med[<?php echo $medicine->med_id; ?>][med]" class="radio_check_input" value="Y" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key; ?>" <?php
                                                                                                                                                                                                                                                                                                                                if ($medicine_data->med_status == 'Y') {
                                                                                                                                                                                                                                                                                                                                    echo "checked=checked disabled";
                                                                                                                                                                                                                                                                                                                                }

                                                                                                                                                                                                                                                                                                                                ?>>
                                                <span class="radio_check_holder"></span><span>Yes</span>
                                            </label>
                                            <label for="open_<?php echo $medicine->med_title; ?>_no" class="radio_check width2 float_left">
                                                <input id="open_<?php echo $medicine->med_title; ?>_no" type="radio" name="ins_med[<?php echo $medicine->med_id; ?>][med]" class="radio_check_input" value="N" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key; ?>" <?php
                                                                                                                                                                                                                                                                                                        if ($medicine_data->med_status == 'N') {
                                                                                                                                                                                                                                                                                                            echo "checked=checked disabled";
                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                        ?> <?php echo $read; ?>>
                                                <span class="radio_check_holder"></span><span>No</span>
                                            </label>
                                        </div>
                                        <div class="width50 float_left">

                                            <input name="ins_med[<?php echo $medicine->med_id; ?>][qty]" tabindex="23" class="form_input filter_if_not_blank filter_maxlength[8] filter_number" placeholder="Enter Qty" type="text" data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 7 digit long',filter_number:'Enter only number only.'}" value="<?= @$medicine_data->med_qty; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo $rerequest; ?>>
                                        </div>
                                    </div> <?php } ?>


                                <div class="width100">
                                    <div class="field_lable float_left width33"><label for="">Remark<span class="md_field">*</span></label></div>
                                    <div class="width50 float_left">

                                        <input name="med_Remark" tabindex="23" class="form_input Remark filter_required classremoval" placeholder="Enter Remark" type="text" data-errors="{filter_required:'Remark should not be blank!',filter_maxlength:'Amount at max 7 digit long',filter_number:'Enter only number only.'}" value="<?= @$result[0]->med_Remark; ?>" <?php echo $view; ?> <?php echo $update;
                                                                                                                                                                                                                                                                                                                                                                                                echo $approve;
                                                                                                                                                                                                                                                                                                                                                                                                echo $rerequest; ?>>
                                    </div>
                                </div>
                            </div>
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