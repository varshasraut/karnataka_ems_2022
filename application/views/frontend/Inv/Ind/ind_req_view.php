<?php
$CI = EMS_Controller::get_instance();
?>


<div class="breadcrumb float_left">

    <ul>

        <li class="sms">

            <a class="click-xhttp-request" data-href="{base_url}IndReq/add_ind_req" data-qr="">Inventory</a>

        </li>

        <li>

            <span>Add Indent Request</span>

        </li>

    </ul>

</div>

<form method="post" name="stock_req_form" id="stock_req_form">


    <div class="width1">    

        <h2>&nbsp;</h2>

        <div class="fieldset_wrapper width1 float_left">

            <div class="form_field width100 float_left">

                <div class="width100">


                    <?php //if ($clg_group == 'UG-ADMIN') { ?>

<!--                        <select name="amb_reg_no" class="filter_required" data-errors="{filter_required:'Please select ambulance'}">
                            <option value="">Select Ambulance</option>

                            <?php echo get_all_amb(); ?>

                        </select>-->
                      <input name="amb_reg_no" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Select Ambulance" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php echo $amb_reg_no; ?>" data-value="<?php echo $amb_reg_no; ?>">

                    <?php //} else if ($clg_group == 'UG-EMT') { $eqp_type = 'amb';?>


<!--                        <div class="label">Ambulance Reg. No. : <?php echo ($amb[0]->tm_amb_rto_reg_id) ? $amb[0]->tm_amb_rto_reg_id : " Not available"; ?></div>

                        <input type="hidden" name="amb_reg_no" value="<?php echo $amb[0]->tm_amb_rto_reg_id; ?>">-->
                        <input type="hidden" name="req_type" value="amb">


                    <?php //}else if ($clg_group == 'UG-HEALTH-SUP' || $this->clg->clg_group == 'UG-SICK-SUP') {  $eqp_type = 'sickroom'; ?>
                        
<!--                            <div class="label">School Name: </div>
                             <input name="school_id" value="<?=@$amb[0]->school_id;?>" class="mi_autocomplete width99 filter_required" data-href="{base_url}auto/get_school_by_healthsupervisor?health_sup=<?php echo $clg_ref_id;?>"  data-base="" tabindex="7" data-value="<?php echo $amb[0]->school_name; ?>" data-nonedit="yes" readonly="readonly" data-errors="{filter_required:'School should not be blank'}"  >
                            <input type="hidden" name="req_type" value="sick_room">-->
                    <?php //}?>

                </div>

            </div>


            <div class="width49 float_left stock_req_form">

                <div class="width49 float_left">

                    <fieldset>

                        <legend>Consumables</legend>

                        <div class="CA_item text_align_center">

                            <div class="CA_blk">

                                <div class="field_row">

                                    <div class="filed_input">

                                        <input type="text" name="item[CA][0][id]" tabindex="1" value="" class="mi_autocomplete width100 caauto" data-href="{base_url}auto/get_inv_items/CA/dq"  data-qr="output_position=content"  placeholder="Item Name" data-auto="CA" data-nonedit="yes" id="CAI_0" data-callback-funct="CAReq">

                                    </div>

                                </div>


                                <div class="field_row">

                                    <div class="filed_input">

                                        <input type="text" name="item[CA][0][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[CAI_0] filter_required filter_number" placeholder="Item Quantity" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}">  

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="width1 text_align_center">

                            <a class="CA_more">Add more item +</a>

                        </div>

                    </fieldset>

                </div>






                <div class="width49 float_right">

                    <fieldset>

                        <legend>Non Consumables</legend>


                        <div class="NCA_item text_align_center">

                            <div class="NCA_blk">

                                <div class="field_row">

                                    <div class="filed_input">

                                        <input type="text" name="item[NCA][0][id]" tabindex="1" value="" class="mi_autocomplete width100" data-href="{base_url}auto/get_inv_items/NCA/dq"  data-qr="" placeholder="Item Name" data-auto="NCA" data-nonedit="yes" id="NCAI_0" data-callback-funct="NCAReq">

                                    </div>

                                </div>


                                <div class="field_row">

                                    <div class="filed_input">

                                        <input type="text" name="item[NCA][0][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[NCAI_0] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Item Quantity">

                                    </div>

                                </div>

                            </div>


                        </div>


                        <div class="width1 text_align_center">

                            <a class="NCA_more">Add more item +</a>

                        </div>

                    </fieldset>

                </div>

            </div>

            <div class="width2 float_right stock_req_form">

                <div class="width49 float_left">

                    <fieldset>

                        <legend>Medicines</legend>

                        <div class="MED_item text_align_center">


                            <div class="MED_blk">

                                <div class="field_row">

                                    <div class="filed_input">

                                        <input type="text" name="item[MED][0][id]" tabindex="1" value="" class="mi_autocomplete width1" data-href="{base_url}auto/get_inv_med/dq"  placeholder="Medicine Name" autocomplete="off" data-auto="MED" data-nonedit="yes"  id="MEDI_0" data-callback-funct="MEDReq"> 

                                    </div>

                                </div>


                                <div class="field_row">

                                    <div class="filed_input">

                                        <input type="text" name="item[MED][0][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[MEDI_0] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}"   placeholder="Medicine Quantity">

                                    </div>

                                </div>

                            </div>


                        </div> 


                        <div class="width1 text_align_center">

                            <a class="MED_more">Add more medicines +</a>

                        </div>


                    </fieldset>

                </div>

                <div class="width49 float_right">

                    <fieldset>

                        <legend>Equipments</legend>

                        <div class="EQP_item text_align_center">

                            <div class="EQP_blk">

                                <div class="field_row">

                                    <div class="filed_input">


                                        <input type="text" name="item[EQP][0][id]" tabindex="1" value="" class="mi_autocomplete width1" data-href="{base_url}auto/get_inv_eqp/dq/<?php echo $eqp_type;?>"  placeholder="Equipment Name" autocomplete="off" data-auto="EQP"  data-nonedit="yes" id="EQPI_0" data-callback-funct="EQPReq">


                                    </div>

                                </div>


                                <div class="field_row">

                                    <div class="filed_input">

                                        <input type="text" name="item[EQP][0][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[EQPI_0] filter_required filter_number"  data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Equipment Quantity">

                                    </div>

                                </div>

                            </div>


                        </div>

                        <div class="width1 text_align_center">

                            <a class="EQP_more">Add more equipment +</a>

                        </div>

                    </fieldset>

                </div>

            </div>

        </div>

        <?php if (($clg_group == 'UG-EMT' && $amb[0]->tm_amb_rto_reg_id) || $clg_group == 'UG-ADMIN' || $clg_group== 'UG-HEALTH-SUP' || $this->clg->clg_group == 'UG-SICK-SUP') { ?>

            <div class="width1 margin_auto text_align_center float_left">

                <div class="button_field_row">

                    <div class="button_box">

                        <input type="hidden" name="submit_req" value="sub_req">

                        <input type="button" name="submit" id="btnsave" value="Send Request" class="btn submit_btnt1 form-xhttp-request " data-href="{base_url}Ind/req" data-qr="">

                        <input type="reset" name="Reset" value="Reset" class="btn">

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</form>


<div id="CA_tmp" class="hide">



    <div class="CA_blk blk ind_class"><div class="width100 display_inlne_block"><div class="remove_button_ind" style="float:right; cursor: pointer; height: 20px; width: 70px;">Remove</div></div><div class="field_row"><div class="filed_input"><input type="text" name="item[CA][indx][id]" tabindex="1" value="" class="autocls width100" data-href="{base_url}auto/get_inv_items/CA/dq"  data-qr="output_position=content" placeholder="Item Name" data-auto="CA" data-nonedit="yes" id="CAI_indx" data-callback-funct="CAReq"></div></div><div class="field_row"><div class="filed_input"><input type="text" name="item[CA][indx][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[CAI_indx] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Item Quantity" ></div></div></div>

</div>

<div id="NCA_tmp" class="hide">

    <div class="NCA_blk blk ind_class"><div class="width100 display_inlne_block"><div class="remove_button_ind" style="float:right; cursor: pointer; height: 20px; width: 70px;">Remove</div></div><div class="field_row"><div class="filed_input"><input type="text" name="item[NCA][indx][id]" tabindex="1" value="" class="autocls width100" data-href="{base_url}auto/get_inv_items/NCA/dq"  data-qr="" placeholder="Item Name" data-auto="NCA" data-nonedit="yes" id="NCAI_indx" data-callback-funct="NCAReq"></div></div><div class="field_row"><div class="filed_input"><input type="text" name="item[NCA][indx][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[NCAI_indx] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Item Quantity"></div></div></div>

</div>

<div id="MED_tmp" class="hide">

    <div class="MED_blk blk ind_class"><div class="width100 display_inlne_block"><div class="remove_button_ind" style="float:right; cursor: pointer; height: 20px; width: 70px;">Remove</div></div><div class="field_row"><div class="filed_input"><input type="text" name="item[MED][indx][id]" tabindex="1" value="" class="autocls width1" data-href="{base_url}auto/get_inv_med/dq"  placeholder="Medicine Name" autocomplete="off" data-auto="MED" data-nonedit="yes" id="MEDI_indx" data-callback-funct="MEDReq"></div></div><div class="field_row"><div class="filed_input"><input type="text" name="item[MED][indx][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[MEDI_indx] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Medicine Quantity"></div></div></div>

</div> 

<div id="EQP_tmp" class="hide">

    <div class="EQP_blk blk ind_class"><div class="width100 display_inlne_block"><div class="remove_button_ind" style="float:right; cursor: pointer; height: 20px; width: 70px;">Remove</div></div><div class="field_row"><div class="filed_input"><input type="text" name="item[EQP][indx][id]" tabindex="1" value="" class="autocls width1" data-href="{base_url}auto/get_inv_eqp/dq/<?php echo $eqp_type;?>"  placeholder="Equipment Name" autocomplete="off" data-auto="EQP" data-nonedit="yes" id="EQPI_indx" data-callback-funct="EQPReq"></div></div><div class="field_row"><div class="filed_input"><input type="text" name="item[EQP][indx][qty]" tabindex="1" value="" class="width1 filter_if_not_empty[EQPI_indx] filter_required filter_number" data-errors="{filter_if_not_empty:'Item quantity should not be blank',filter_required:'Item quantity should not be blank','filter_number':'Item quantity should be in numbers'}" placeholder="Equipment Quantity"></div></div></div>

</div> 