<div class="width100">                
    <div class="text_align_center">                    
        <a href="{base_url}"> <div class="ems_logo margin_auto"></div>                    
        </a>                
    </div>                
    <div class="text_align_center">                    
        <h3 class="txt_clr2 width1 txt_pro">Notice / Reminder</h3>                
    </div>             
    <form action='#' method='post' class='break_form' id="break_function">   
        <div class="login_inner_box joining_details_box">                    <!--<h2></h2>-->                    

            <div class="multiselect  field_row">
                <div class="selectBox" onclick="showCheckboxes()">
                    <select>
                        <option value="">Select  Application User </option>  
                    </select>
                    <div class="overSelect"></div>
                </div>
                <div id="checkboxes">
                      <label for="selectall" class="chkbox_check">
                        <input type="checkbox" name="selectall"  id="selectall"  class="check_input unit_checkbox"  >
                        <span class="chkbox_check_holder"></span>Selectall<br>
                    </label>
                    <label for="one" class="chkbox_check">
                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-ERO"   id="one" >
                        <span class="chkbox_check_holder"></span>ERO 108<br>
                    </label>
                    <label for="eleven" class="chkbox_check">
                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-ERO-102"   id="eleven" >
                        <span class="chkbox_check_holder"></span>ERO 102<br>
                    </label>
                    <label for="two" class="chkbox_check">
                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-DCO"   id="two" >
                        <span class="chkbox_check_holder"></span>DCO 108<br>
                    </label>
                    <label for="twelve" class="chkbox_check">
                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-DCO-102"   id="twelve" >
                        <span class="chkbox_check_holder"></span>DCO 102<br>
                    </label>
                    <label for="three" class="chkbox_check">
                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-PDA"   id="three" >
                        <span class="chkbox_check_holder"></span>Police Desk<br>
                    </label>
                    <label for="four" class="chkbox_check">
                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-FDA"   id="four" >
                        <span class="chkbox_check_holder"></span>Fire Desk<br>
                    </label>
                    <label for="five" class="chkbox_check">
                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-Feedback"   id="five" >
                        <span class="chkbox_check_holder"></span>Feedback<br>
                    </label> 
                    <label for="six" class="chkbox_check">
                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-ERCP"   id="six" >
                        <span class="chkbox_check_holder"></span>ERCP<br>
                    </label> 
                    <label for="seven" class="chkbox_check">
                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-Grievance"   id="seven" >
                        <span class="chkbox_check_holder"></span>Grievance<br>
                    </label> 
                    <label for="eight" class="chkbox_check">
                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-Qualityr"   id="eight" >
                        <span class="chkbox_check_holder"></span>Quality<br>
                    </label> 
                    <label for="nine" class="chkbox_check">
                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-QualityManager"   id="nine" >
                        <span class="chkbox_check_holder"></span>Quality Manager<br>
                    </label> 
                    <label for="ten" class="chkbox_check">
                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-EROSupervisor"   id="ten" >
                        <span class="chkbox_check_holder"></span>ERO Supervisor<br>
                    </label> 
                </div>
            </div>
            <div class="field_row">                        
                <textarea   rows="4" name="notice" placeholder="Noice / Reminder"   TABINDEX="3" > </textarea>  
            </div>  
            <div class="field_row  ">

                <div class="field_lable float_left  width_23 strong"><label for="joining_date">Expiry Date:</label></div>

                <div class="filed_input float_left  width75">
                    <input id="joining_date"   type="text" value="<?= @$current_data[0]->clg_joining_date ?>" name="expiry_date" class="cur_datetimecalender filter_required" data-errors="{filter_required:'Joining date should not be blank'}" TABINDEX="4"   >
                </div>

            </div>
        </div>


        <div class="text_align_center button_box">                 
            <input type="button" name="submit" value="Send" class="btn submit_btnt form-xhttp-request" data-href='{base_url}clg/save_notice' data-qr='output_position=content'  TABINDEX="2" id="<?php echo @$current_data[0]->clg_ref_id; ?>">

        </div> 
    </form>   
</div>            
</div>      
<script>

    var expanded = false;

    function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
        } else {
            checkboxes.style.display = "none";
            expanded = false;
        }
    }
    
    $("#selectall").click(function(){
        //alert("just for check");
        if(this.checked){
            $('.checkboxall').each(function(){
                this.checked = true;
            })
        }else{
            $('.checkboxall').each(function(){
                this.checked = false;
            })
        }
    });


 $('#container').on('focus', '.cur_datetimecalender', function () {

        $(this).datetimepicker({
            changeMonth: true,
            changeYear: true,
            showAnim: 'slideDown',
            dateFormat: 'yy-mm-dd',
            timeFormat: "HH:mm:ss",
            minDate: new Date(),

        });

        return false;

    });


</script>
