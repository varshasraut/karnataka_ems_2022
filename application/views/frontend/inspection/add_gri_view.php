<?php
$view = ($action == 'view') ? 'disabled' : '';

if ($amb_action == 'edit') {
    $edit = 'disabled';
}
//var_dump($update);
$CI = EMS_Controller::get_instance();

$title = ($amb_action == 'edit') ? " Edit Ambulance Details " : (($amb_action == 'view') ? "View Grievance Details" : "Add Grievance Details");
//var_dump($result);
?>


<script>
     if(typeof H != 'undefined'){
         init_auto_address();
     }
</script>
<form enctype="multipart/form-data" action="#" method="post" id="usr_ad_form" style="position:relative; top:0; bottom:0;">
    <div class="register_outer_block">
     <input type="hidden" name="gri[ins_id]" value="<?php echo $id; ?>" >
     <input type="hidden" name="gri[amb_no]" value="<?php echo $amb_no; ?>" >
        <div class="box3">


            <div class="width1 float_left ">
                <h2 class="txt_clr2 width1 txt_pro"><?php echo $title; ?></h2>
                <div class="store_details_box">
                
                    <div class="field_row width100">
                    <div class="width100 float_left">
                            <div class="filed_input float_left width100">
                            <input type="text" name="gri[grievance_type]" data-value="<?= @$result[0]->grievance_type; ?>" value="<?= @$result[0]->grievance_type; ?>" class="mi_autocomplete "  data-href="{base_url}auto/get_grievance_type"  placeholder="Grievance Type" TABINDEX="8" <?php echo $autofocus; ?>  <?php echo $update; ?> <?php echo $view; ?>>

                            </div>
                        </div>
    </div>
                        <div class="field_row width100">
                        <div class="width100 float_left">
                        <div class="filed_input float_left width100">
                        <input type="text" name="gri[grievance_sub_type]"  data-value="<?= @$result[0]->grievance_sub_type; ?>" value="<?= @$result[0]->grievance_sub_type; ?>" class="mi_autocomplete "  data-href="{base_url}auto/get_grievance_sub_type"  placeholder="Grievance Related To" TABINDEX="8" <?php echo $autofocus; ?>  <?php echo $update; ?> <?php echo $view; ?>>

                            </div>
                        </div>
                    </div><br>
                    <div class="width100 float_left ">
                <div class="width100 float_left">
                            <div class="filed_input float_left width100" id="amb_base_location">
                            <select name="gri[prilimnari_inform]" tabindex="8" class="filter_required" data-errors="{filter_required:'Preliminary inform should not be blank!'}"  <?php echo $update; ?> <?php echo $view; ?>> 
                                <option value="">Preliminary Inform To</option>
                                <option value="1" <?php if($result[0]->prilimnari_inform == '1'){ echo "selected"; } ?>>Manager</option>
                            </select> 
                            </div>
                        </div>
         </div>
                    <br>
                    <div class="field_row width100">
                        <div class="width100 float_left">
                        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Details Of Grievance<span class="md_field"></span></label></div>


                    </div>
                 
                </div><br>
                <div class="field_row width100">
                        <div class="width100 float_left">
                        
                        <div class="filed_input float_left width100" >
                        <textarea name="gri[remark]" class="filter_required"  <?php echo $update; ?> <?php echo $view; ?> data-errors="{filter_required:'Remark should not be blank!'}"><?php echo $result[0]->remark; ?></textarea>
                     </div>
                    </div>
                 
                </div><br>
 
                

                </div>

                

            </div>

        </div>     

        

        <?php if (!($action == 'view')) { ?>

            <div class="width_11 margin_auto">
                <div class="button_field_row">
                    <div class="button_box">

                        <input type="hidden" name="submit_amb" value="amb_reg" />

<!--                        <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='{base_url}amb/<?php if ($update) { ?>edit_amb<?php } else { ?>add_amb<?php } ?>' data-qr='amb_id[0]=<?php echo base64_encode($update[0]->amb_id); ?>&amp;page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12">-->
                        
                         <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url(); ?>inspection/<?php if ($update) { ?>edit_amb<?php } else { ?>save_grievance_ins<?php } ?>'  data-qr='amb_id[0]=<?php echo base64_encode($update[0]->amb_id); ?>&amp;page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12">

                            <!--<input type="reset" name="reset" value="Reset" class="reset_btn" TABINDEX="13">-->
                    </div>
                </div>
            </div>

        <?php } ?>

    </div>
</form>
<script>

    
    jQuery(document).ready(function () {
    var jsDate = $("#offroad_datetime").val();
        var $mindate = new Date(jsDate);


        $('.OnroadDate').datepicker({
            dateFormat: "yy-mm-dd",
            minDate: $mindate,
            // minTime: jsDate[1],

        });
   $("#offroad_datetime").change(function(){
        var jsDate = $("#offroad_datetime").val();
        var $mindate = new Date(jsDate);


        
    });

    $('input[type=radio][name="app[mt_approval]"]').change(function(){
        //$("#ap").show();
        var app = $("input[name='app[mt_approval]']:checked").val();
        if(app == "1"){
            $(".ap").show();
        }else{
            $(".ap").hide();
        }
    });
    });
    function sum() {
      var txtFirstNumberValue = document.getElementById('part_cost').value;
      var txtSecondNumberValue = document.getElementById('labour_cost').value;
      var result =  parseInt(txtSecondNumberValue) + parseInt(txtFirstNumberValue);
      if (!isNaN(result)) {
         document.getElementById('total_cost').value = result;
      }
}
</script>