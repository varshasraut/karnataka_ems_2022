



<div class="width1 float_left">

<form action="#" method="post" id="">

    
    <input type="hidden" name="inv_type" value="<?php echo $inv_type;?>">
    
    <div class="width1 float_left">

        <h2 class="txt_clr2 width1 txt_pro hheadbg">Add Stock</h2>

        <div class="field_row">

            <div class="field_lable">

                <label>Item Name<span class="md_field">*</span> :</label>

            </div>

            <div class="filed_input" id="item_type">

              

            </div>

        </div>
        


        <div class="field_row">

            <div class="field_lable">

                <label>Set Quantity<span class="md_field">*</span> :</label>

            </div>

            <div class="input">

                <input type="text" name="tyre_stock[tyre_qty]"  value=""  class="filter_required filter_number" data-errors="{filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" tabindex="2">

            </div>

        </div>


        <div class="field_row">

            <div class="field_lable">

                <label>Date : </label>



            </div>

            <div class="input"> 

                <input name="tyre_stock[tyre_date]" value="" class="mi_calender" type="text" tabindex="3">

            </div>

        </div>


        <div class="width2 margin_auto">

            <div class="button_field_row">

                <div class="button_box">

                    <input type="hidden" name="submit_inv" value="sub_inv">

                    <input type="button" name="submit" id="btnsave" value="Submit" class="btn submit_btnt form-xhttp-request" data-href="{base_url}Inv_stock/add_tyre" data-qr="">

                    <input type="reset" name="Reset" value="Reset" class="btn">

                </div>

            </div>
        </div>


    </div>

</form>

</div>




