<?php
$CI = EMS_Controller::get_instance();
?>

 <div class="head_outer"><h3 class="txt_clr2 width1">View Details</h3> </div>

<div class="box3">    

    <div class="permission_list group_list">

<!--        <form method="post" action="#" name="colleagues_list_form" class="colleagues_list_form">  

            <div class="field_row float_left width100">

                <div class="filed_select">
                    <div class="width100 drg float_left">
                        <div class="width_16 float_left">
                            <div class="style6 float_left">Select Date: </div>
                        </div>
                        <div class="width_25 float_left" >
                        <input name="from_date" tabindex="20"  class="form_input mi_calender filter_required" placeholder="Date"  type="text"  data-errors="{filter_required:'Date should not be blank!'}" >
                             <select name="from_date" class="filter_required" data-errors="{filter_required:'Month should not be blank!'}">
                                <option value="">Select Date</option>
                                <?php
                                // for ($i = 0; $i <= 20; $i++) {
                                //     $current_date = time();
                                //     $month = date('M Y', strtotime('-' . $i . ' Months', $current_date));
                                //     $month_value = date('Y-m-01', strtotime('-' . $i . ' Months', $current_date));

                                //     echo '<option value="' . $month_value . '">' . $month . '</option>';
                                // }
                                ?>

                            </select> 
                        </div>
                        <input type="hidden" name="ref_id" value="<?php echo $ref_id; ?>">
                         <div class="filed_input float_left width_25">
                  <label for="search_clg">

                    <input type="button" name="search" value="Search" class="btn clg_search form-xhttp-request" data-href="{base_url}shiftmanager/search_login_details" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_type=View" >

                </label>
            </div>
                    </div>
                </div>
          

            </div>
                </form>-->

            <div id="list_table">

            </div>
     
    </div>
</div>

<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>