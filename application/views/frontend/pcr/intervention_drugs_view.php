<!--<div class="unit_drugs_box">
<?php 
if($invitem){ ?>
    <ul class="width100">
    <?php foreach($invitem as $item){?>
        <li class="non_unit_block">
            <label for="unit_<?php echo $item->inv_id;?>" class="chkbox_check">


                        <input type="checkbox" name="non_unit[<?php echo $item->inv_id;?>][id]" class="check_input unit_checkbox" value="<?php echo $item->inv_id;?>"  id="unit_<?php echo $item->inv_id;?>">


                        <span class="chkbox_check_holder"></span><?php echo $item->inv_title;?><br>
            </label>
            <input type="hidden" name="unit[<?php echo $item->inv_id;?>][value]" value="" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}">

                 <input type="hidden" name="non_unit[<?php echo $item->inv_id;?>][type]" value="<?php echo $item->inv_type;?>" class="width50" >
          
        </li>
    <?php } ?>
    </ul>
<?php } ?>
</div>-->
<div class="table_wrp">
<table class="style5">
    <tr>
        <th class="width40">Intervention Id</th>
        <th>Intervention Title</th>
    </tr>
   
        <?php foreach($cons_data as $cons){?>
     <tr>
        <td><?php echo $cons['inv_id'];?></td>
        <td><?php echo $cons['int_name'];?> </td>
    </tr>
        <?php } ?>

</table>
</div><br>