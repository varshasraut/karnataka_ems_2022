<script>
if(typeof H != 'undefined'){
    init_auto_address();
}
</script>

<?php
$CI = EMS_Controller::get_instance();

$bgtype[$ptn[0]->ptn_bgroup_type] = "selected='selected'";

$rtncrd[$ptn[0]->ptn_ration_card] = "checked=''";
?>

<div class="head_outer"><h3 class="txt_clr2 width1">Investigations
            <div class="form_field width25 float_right">
                        <div class="input">

                            <select name="hair" class="filter_required"  data-errors="{filter_required:'Please select hair color'}" data-base="" tabindex="6">
                                <option value="">Previous visit</option>
                                <option value="25_agu">25 Aug 2018</option>
                                <option value="25_agu">20 Aug 2018</option>
                                <option value="25_agu">15 Aug 2018</option>
                            </select>

                        </div>
        </div></h3> </div>

<form method="post" name="" id="investigation_form">



    <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>">

    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">



    <div class="half_div_left">

        <div class="display_inlne_block width100">
            <table class="student_screening investigation">
                <tr>
                    <td><div class="style6">Test name</div></td><td><div class="style6"></div></td>
                </tr>
                <?php foreach ($test as $item) { ?>
                <tr>
                    <td><div class="style6"><?php echo stripslashes($item->test_title); ?></div></td>
                    <td>            
<!--                        <div class="pat_width float_left" data-activeerror="">
                            <input name="father_name" value="" class="filter_required" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                        </div>-->
<div class="add_more_investigation">
    <input type="hidden" value="<?php echo $item->id; ?>" class="test_id">
</div>

                    </td>
                </tr>
                <?php }?>
            </table>
        </div>

    </div>


    <div class="half_div_right">
        <div class="investigation_test">
            <table class="student_screening">
                <tr>
                    <td><div class="style6">Test name</div></td><td><div class="style6"></div></td>
                    <?php if($selected_test_list){
                        foreach($selected_test_list as $test){
                            $test_id = $test['id'];
                        ?>
                    <tr id='row_<?php echo $test['id'];?>'>
                        <td><?php echo $test['test_name'];?> <input type='hidden' name='test[<?php echo $test_id;?>][id]' value='<?php echo $test_id;?>'><input type='hidden' name='test[<?php echo $test_id;?>][test_name]' value='<?php echo $test['test_name'];?>'></td>
                        <td><div id='removebutton_<?php echo $test['id'];?>' class='remove_button'></div></td>
                    </tr>
                        <?php
                        }
                    }?>
                </tr>
            </table>
        </div>
            <div class="save_btn_wrapper float_left">


        <input type="button" name="accept" value="Submit" class="accept_btn form-xhttp-request" data-href='{base_url}emt/save_investigation' data-qr="output_position=pat_details_block"  tabindex="25">


    </div>

    </div>

    <div class="width100 float_left">
        <br>
    </div>



</form>
