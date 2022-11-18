<?php
$view = ($amb_action == 'view') ? 'disabled' : '';

if ($amb_action == 'edit') {
    $edit = 'disabled';
}
//var_dump($update);
$CI = EMS_Controller::get_instance();

$title = "Change Ambulance Status On-road/Off Road";
?>


<form enctype="multipart/form-data" action="#" method="post" id="usr_ad_form">
    <div class="box3">


            <div class="width1 float_left ">
                <h2 class="txt_clr2 width1 txt_pro"><?php echo $title; ?></h2>
                <div class="store_details_box">
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="registration_number">Ambulance Status<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                             
                                <?php var_dump($amb_sts); ?>
                              
                                  <select name="amb_type" class="filter_required" data-errors="{filter_required:'Ambulance type should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>

                                   <?php echo get_amb_status($amb_sts); ?>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
</form>