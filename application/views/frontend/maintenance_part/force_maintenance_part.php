
                <div class="field_row width100">

                    <div class="width33 float_left stock_req_form">

                        <div class="width_78 float_left">

                            <fieldset>

                                <legend>Force BSIII</legend>

                                <div class="CA_item text_align_center">
                                    <input type="hidden" class="item_type" name="item_type" value="BSIII">

                                    <div class="CA_blk">

                                        <div class="field_row">

                                            <div class="filed_input" >

                                                <input  type="text" name="req[Force_BSIII][0][id]" tabindex="1"   value="" class="mi_autocomplete width100 caauto filter_required consumables_drugs" data-href="<?php echo base_url(); ?>auto/get_maintance_part_items/Force/BSIII"  data-qr="output_position=forcecode_0"  placeholder="Item Name" data-auto="Force" data-nonedit="yes" id="ForceI_0" data-callback-funct="forceReq" data-errors="{filter_required:'At least one field is required'}">

                                            </div>

                                        </div>
<!--                                            <div class="field_row">

                                            <div class="filed_input forcecode" id="forcecode_0">

                                                <input type="text" name="req[Force][0][item_code]" tabindex="1" value="" class="width1 filter_if_not_empty[ForceI_0] filter_required filter_number" placeholder="Item Code" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}">  

                                            </div>

                                         </div>-->

                                        <div class="field_row">

                                            <div class="filed_input">

                                                <input type="text" name="req[Force_BSIII][0][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[ForceI_0] filter_required filter_number" placeholder="Item Quantity" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}">  

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

                                <legend>Force BSIV</legend>


                                <div class="NCA_item text_align_center">
                                    <input type="hidden" class="item_type" name="item_type" value="BSIV">

                                    <div class="NCA_blk">

                                        <div class="field_row">

                                            <div class="filed_input" >

                                                <input  type="text" name="req[Force_BSIV][0][id]" tabindex="1" value="" class="mi_autocomplete width100 filter_required non_consumable_drugs" data-href="<?php echo base_url(); ?>auto/get_maintance_part_items/Force/BSIV"  data-qr="" placeholder="Item Name" data-auto="Ashok_Leyland" data-nonedit="yes" id="NCAI_0" data-callback-funct="NCAReq" data-errors="{filter_required:'At least one field is required!'}" >

                                            </div>

                                        </div>
<!--                                            <div class="field_row">

                                            <div class="filed_input" >

                                                <input type="text" name="req[Ashok_Leyland][0][item_code]" tabindex="1" value="" class="width1 filter_if_not_empty[ForceI_0] filter_required filter_number" placeholder="Item Code" data-errors="{filter_if_not_empty:'Item code should not be blank',filter_required:'Item code should not be blank','filter_number':'Item code should be in numbers'}">  

                                            </div>

                                         </div>-->


                                        <div class="field_row">

                                            <div class="filed_input">

                                                <input type="text" name="req[Force_BSIV][0][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[NCAI_0] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Item Quantity" >

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