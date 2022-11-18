<?php
$view = ($amb_action == 'view') ? 'disabled' : '';

if ($amb_action == 'edit') {
    $edit = 'disabled';
}
//var_dump($update);
$CI = EMS_Controller::get_instance();

$title = "Add Mobile Number";
?>

<form enctype="multipart/form-data" action="#" method="post" id="usr_ad_form">
    <div class="register_outer_block">

        <div class="box3">


            <div class="width1 float_left ">
                <h2 class="txt_clr2 width1 txt_pro"><?php echo $title; ?></h2>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="registration_number">Mobile Number<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" name="mobile_number" class="filter_required filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace" data-errors="{filter_required:'Mobile Number should not be blank', filter_minlength:'Ambulance Mobile Number should be at least 10 digits long',filter_maxlength:'Ambulance Mobile Number should less then 11 digits.'}" value="<?php echo $update[0]->amb_rto_register_no; ?>" tabindex="1" autocomplete="off" <?php echo $view; ?> <?php echo $edit; ?>>
                                  

                            </div>
                        </div> 
            </div>
            <div class="width_11 margin_auto">
                <div class="button_field_row">
                    <div class="button_box">

                         <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url(); ?>coral/save_blocked_number'  data-qr='page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12">

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>       