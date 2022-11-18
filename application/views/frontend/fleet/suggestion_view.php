<script>

    // initAutocomplete();

</script>


<div id="dublicate_id"></div>

<?php
if (@$view_clg == 'view') {
    $view = 'disabled';
}
?>

<form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form">
    <div class="width1">
        <h2 class="txt_clr2 width1 txt_pro"><?php
            if ($action_type) {
                echo $action_type;
            }
            ?></h2>


        <div class="joining_details_box">

            <div class="width100">

 
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Type</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$sugg_data[0]->su_type; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Suggestion Remark</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$sugg_data[0]->su_suggetion_remark; ?>

                        </div>
                    </div>

                </div>
                <?php if($sugg_data[0]->su_other_type != ''){ ?> 
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Other Type</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$sugg_data[0]->su_other_type; ?>

                        </div>
                    </div>
                 

                </div>

                <?php } ?>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Report To HO</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$sugg_data[0]->su_report_to_ho; ?>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Date/Time</label></div>


                        <div class="filed_input float_left width50">
                                 <?= @$sugg_data[0]->su_date_time; ?>


                        </div>
                    </div>


                </div>
            
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Standard Remark </label></div>
                        <div class="filed_input float_left width50">
                            <?php if($sugg_data[0]->su_standard_remark == 'suggestion_register'){
                                echo "Suggestion Register Suceesfully";
                            }?>
                            
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mobile_no">Remark</label></div>


                        <div class="filed_input float_left width50">
                            <?= @$sugg_data[0]->su_remark; ?>

                        </div>
                    </div>

                </div>
                </form>

