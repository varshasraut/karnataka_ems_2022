
<div class="box_head text_align_center width100">
    <h3 class="txt_pro">Ambulance Not Assigned Call</h3>
</div>

<div class="confirm_save width100">

    <div class="summary_info">

        <ul class="dtl_block">
            <li><span>Incident Id :</span>
                <?php echo $inc_ref_id; ?>
            </li>
            <li><span> Incident District :</span><?php echo $dst_name; ?></li>
            <!-- <li><span> Ambulances :</span><?php //echo $inc_amb_not_assgn_ambulances; ?></li> -->
            <li><span> Ambulance Not Assigned Reason  : </span><?php echo $inc_amb_not_assgn_reason; ?></li>
            <li><span> Place  : </span><?php echo $inc_place; ?></li>
        </ul>
        <table>
            <tr>
                <!-- <th scope='col'>#</th> -->
                <th>Ambulance No</th>
                <th>Status</th>
                <th>EMT</th>
                <th>Pilot</th>
                <th>Base-Location</th>
            </tr>
            <?php $arr = count($details); for($i = 0; $i < $arr; $i++){ ?>
            <?php $arr1 = count($details[$i]); for($j = 0; $j < $arr1; $j++){?>
            <tr>
                <?php ?>
                <td name="amb_rto_register_no"><?php echo $details[$i][$j]['amb_rto_register_no']; ?></td>
                <td name="ambs_name"><?php echo $details[$i][$j]['ambs_name']; ?></td>
                <?php if($details[$i][$j]['login_type'] == "P"){ ?>
                <td name="clg_ref_id"><?php echo $details[$i][$j]['clg_ref_id']; ?></td>
                <?php }else{?>
                    <td><?php echo "-"; ?></td>
                <?php }?>
                <?php if($details[$i][$j]['login_type'] == "D"){ ?>
                <td name="clg_ref_id"><?php echo $details[$i][$j]['clg_ref_id']; ?></td>
                <?php }else{?>
                    <td><?php echo "-"; ?></td>
                <?php }?>
                <td name="hp_name"><?php echo $details[$i][$j]['hp_name']; ?></td>
                <?php?>
            </tr>
            <?php }}?>
        </table>
    </div>


    <div class="save_btn_wrapper float_left beforeunload">

        <form name="com_call_fwd" method="post" id="">
            <input type="hidden" name="non_eme_call[cl_type]" value="<?php echo $inc_type; ?>" />
            <?php if ($inc_type == 'NON_MCI'){ ?>
                <input name="" value="SAVE" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>inc/save_amb_not_assign" data-qr="output_position=content" type="button" tabindex="15">
            <?php }elseif($inc_type == 'DROP_BACK'){ ?>
                <input name="" value="SAVE" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>inc102/save_amb_not_assign" data-qr="output_position=content" type="button" tabindex="15">
            <?php }elseif($inc_type == 'IN_HO_P_TR'){ ?>
                <input name="" value="SAVE" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>inc/save_inter_hos_amb_not_assign" data-qr="output_position=content" type="button" tabindex="15">
            <?php }elseif($inc_type == 'MCI'){ ?>
                <input name="" value="SAVE" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>inc/save_inter_hos_amb_not_assign" data-qr="output_position=content" type="button" tabindex="15">
            <?php }elseif($inc_type == 'PICK_UP'){ ?>
                <input name="" value="SAVE" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>inc/save_inter_hos_amb_not_assign" data-qr="output_position=content" type="button" tabindex="15">
            <?php }elseif($inc_type == 'PICK_UP'){ ?>
                <input name="" value="SAVE" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>inc/save_inter_hos_amb_not_assign" data-qr="output_position=content" type="button" tabindex="15">
            <?php }?>
            <input name="" value="CANCEL" class="cancel_btn style3"  type="button" tabindex="16">
        </form>


    </div>
</div>