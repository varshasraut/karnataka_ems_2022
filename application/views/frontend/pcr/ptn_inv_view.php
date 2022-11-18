<script>cur_pcr_step(8);</script>


<?php $CI = EMS_Controller::get_instance(); ?>

<div class="head_outer"><h3 class="txt_clr2 width1">PATIENT MANAGEMENT 2</h3> </div>

<form method="post" name="" id="ptn_inv_mng">
    <div id="script_div">
        <?php echo $script;
        echo $qty_script;
        echo $na_script;
        echo $na_qty_script;
        echo $med_script;
        echo $med_qty_script;
        echo $remove_div; ?>
    </div>

    <input type="hidden" name="pcr_id" value="<?php echo $pcr_id; ?>">


    <div class="width100 head_outer float_left">

        <div class="form_field width25">

            <div class="label">Select Consumables</div>

            <div class="input">

                <input type="text" name="cn_item"  value="" class="mi_autocomplete" data-href="{base_url}auto/get_inv_items/CA"  placeholder="Select Consumables" data-errors="{filter_required:'Consumables should not be blank'}"  tabindex="1"  data-callback-funct="get_ca_item" data-auto="CA">


            </div>

        </div>

        <div class="width56 table_wrp float_left CA_items hide">

            <table class="style5 CA_item_list">

                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Minimum</th>
                    <th>Maximum</th>
                    <th>Unit</th>
                    <th>Action</th>
                </tr>

            </table>

        </div>




        <div class="width40 table_wrp float_right CA_rel_items hide">

            <table class="style5 CA_rel_items_list">

                <tr>
                    <th class="width30">Name</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>


            </table>


        </div>


    </div>


    <div class="width100 head_outer float_left">

        <div class="form_field width25">

            <div class="label">Select Non-Consumables</div>

            <div class="input">

                <input type="text" name="na_cn_item"  value="" class="mi_autocomplete" data-href="{base_url}auto/get_inv_items/NCA"  placeholder="Select Consumables" data-errors="{filter_required:'LOC level should not be blank'}"  tabindex="1"  data-callback-funct="get_nca_item" data-auto="NCA">



            </div>

        </div>



        <div class="width56 table_wrp float_left NCA_items hide">

            <table class="style5 NCA_item_list">

                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Minimum</th>
                    <th>Maximum</th>
                    <th>Unit</th>
                    <th>Action</th>
                </tr>


            </table>

        </div>

        <div class="width40 float_right table_wrp NCA_rel_items hide">

            <table class="style5 NCA_rel_items_list">

                <tr>
                    <th class="width30">Name</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>


            </table>


        </div>


    </div>


    <div class="width100 head_outer float_left">

        <div class="form_field table_wrp width25">

            <div class="label">Select Medication</div>

            <div class="input">

                <input type="text" name="medication"  value="" class="mi_autocomplete" data-href="{base_url}auto/get_inv_med"  placeholder="Select Consumables" data-errors="{filter_required:'LOC level should not be blank'}"  tabindex="1"  data-callback-funct="get_med_item" data-auto="MED">


            </div>

        </div>

        <div class="width56 table_wrp float_left MED_items hide">

            <table class="style5 MED_item_list">

                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Minimum</th>
                    <th>Maximum</th>
                    <th>Unit</th>
                    <th>Action</th>
                </tr>


            </table>

        </div>

        <div class="width40 table_wrp float_right MED_rel_items hide">

            <table class="style5 MED_rel_items_list">

                <tr>
                    <th class="width30">Name</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>


            </table>


        </div>


    </div>
    <div class="width15 margin_auto">
        <div class=" margin_auto">

            <div class="label">&nbsp;</div>

    <!--                    <input name="search_btn" value="Save" class="style3 base-xhttp-request" data-href="{base_url}/pcr/epcr" data-qr="output_position=content" type="button">-->
            <input type="button" name="Save" value="Save" class="accept_btn form-xhttp-request" data-href='{base_url}/pcr/save_ptn_inv' data-qr='' TABINDEX="33">
        </div> 
    </div>
</form>



<div class="next_pre_outer">
<?php
$step = $this->session->userdata('pcr_details');
if (!empty($step)) {
    ?>
        <a href="#" class="prev_btn btn float_left" onclick="load_next_prev_step(7)"> < Prev </a>
        <a href="#" class="next_btn btn float_right" onclick="load_next_prev_step(9)"> Next > </a>
<?php } ?>
</div>