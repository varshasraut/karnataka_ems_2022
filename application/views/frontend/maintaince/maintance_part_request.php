<div class="field_row width100" id="maintananace_part_list_block">

                    <div class="width33 float_left stock_req_form">

                        <div class="width_78 float_left">

                            <fieldset>

                                <legend>Force</legend>

                                <div class="CA_item text_align_center">
                                    <input type="hidden" class="item_type" name="item_type" value="CA">

                                    <div class="CA_blk">

                                        <div class="field_row">

                                            <div class="filed_input" >

                                                <input  type="text" name="req[Force][0][id]" tabindex="1"   value="" class="mi_autocomplete width100 caauto filter_required consumables_drugs" data-href="<?php echo base_url(); ?>auto/get_maintance_part_items/Force/dp"  data-qr="output_position=forcecode_0"  placeholder="Item Name" data-auto="Force" data-nonedit="yes" id="ForceI_0" data-callback-funct="forceReq" data-errors="{filter_required:'At least one field is required'}">

                                            </div>

                                        </div>
<!--                                            <div class="field_row">

                                            <div class="filed_input forcecode" id="forcecode_0">

                                                <input type="text" name="req[Force][0][item_code]" tabindex="1" value="" class="width1 filter_if_not_empty[ForceI_0] filter_required filter_number" placeholder="Item Code" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}">  

                                            </div>

                                         </div>-->

                                        <div class="field_row">

                                            <div class="filed_input">

                                                <input type="text" name="req[Force][0][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[ForceI_0] filter_required filter_number" placeholder="Item Quantity" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}">  

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="width1 text_align_center add_more_ind">

                                    <a class="CA_more">Add more item +</a>

                                </div>

                            </fieldset>

                        </div>

                    </div>

                    <div class="width33 float_left stock_req_form">

                        <div class="width_78 float_left">

                            <fieldset>

                                <legend>Ashok Leyland</legend>


                                <div class="NCA_item text_align_center">
                                    <input type="hidden" class="item_type" name="item_type" value="NCA">

                                    <div class="NCA_blk">

                                        <div class="field_row">

                                            <div class="filed_input" >

                                                <input  type="text" name="req[Ashok_Leyland][0][id]" tabindex="1" value="" class="mi_autocomplete width100 filter_required non_consumable_drugs" data-href="<?php echo base_url(); ?>auto/get_maintance_part_items/Ashok Leyland/dp"  data-qr="" placeholder="Item Name" data-auto="Ashok_Leyland" data-nonedit="yes" id="NCAI_0" data-callback-funct="NCAReq" data-errors="{filter_required:'At least one field is required!'}" >

                                            </div>

                                        </div>
<!--                                            <div class="field_row">

                                            <div class="filed_input" >

                                                <input type="text" name="req[Ashok_Leyland][0][item_code]" tabindex="1" value="" class="width1 filter_if_not_empty[ForceI_0] filter_required filter_number" placeholder="Item Code" data-errors="{filter_if_not_empty:'Item code should not be blank',filter_required:'Item code should not be blank','filter_number':'Item code should be in numbers'}">  

                                            </div>

                                         </div>-->


                                        <div class="field_row">

                                            <div class="filed_input">

                                                <input type="text" name="req[Ashok_Leyland][0][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[NCAI_0] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Item Quantity" >

                                            </div>

                                        </div>

                                    </div>


                                </div>


                                <div class="width1 text_align_center add_more_ind">

                                    <a class="NCA_more">Add more item +</a>

                                </div>

                            </fieldset>

                        </div>

                    </div>

                </div>

<div id="hidden_maintence_part">
<div id="CA_tmp" class="hide">



    <div class="CA_blk blk ind_class"><div class="width100 display_inlne_block"><div class="remove_button_ind" style="float:right; cursor: pointer; height: 20px; width: 70px;">Remove</div></div><div class="field_row"><div class="filed_input"><input type="text" name="req[Force][indx][id]" tabindex="1" value="" class="autocls width100" data-href="<?php echo base_url() ?>auto/get_maintance_part_items/Force/dp"  data-qr="output_position=content" placeholder="Item Name" data-auto="CA" data-nonedit="yes" id="CAI_indx" data-callback-funct="CAReq"></div></div><div class="field_row"><div class="filed_input"><input type="text" name="req[Force][indx][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[CAI_indx] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Item Quantity" ></div></div></div>

</div>

<div id="NCA_tmp" class="hide">

    <div class="NCA_blk blk ind_class"><div class="width100 display_inlne_block"><div class="remove_button_ind" style="float:right; cursor: pointer; height: 20px; width: 70px;">Remove</div></div><div class="field_row"><div class="filed_input"><input type="text" name="req[Ashok_Leyland][indx][id]" tabindex="1" value="" class="autocls width100" data-href="<?php echo base_url() ?>auto/get_maintance_part_items/Ashok Leyland/dp"  data-qr="" placeholder="Item Name" data-auto="NCA" data-nonedit="yes" id="NCAI_indx" data-callback-funct="NCAReq"></div></div><div class="field_row"><div class="filed_input"><input type="text" name="req[Ashok_Leyland][indx][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[NCAI_indx] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Item Quantity"></div></div></div>

</div>
</div>