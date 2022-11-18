<!--<input type="text" name="feedback[fc_standard_type]"  data-value="<?= @$inc_details['chief_complete']; ?>" value="<?= @$inc_details['chief_complete_id']; ?>" class="mi_autocomplete filter_required "  data-href="{base_url}auto/get_feedback_standard_remark?feed_type=<?php echo $feed_type;?>" data-errors="{filter_required:'Standard Remark  should not be blank!'}"  placeholder="Standard Remark" TABINDEX="11" <?php echo $autofocus; ?>>-->
<select name="feedback[fc_standard_type][]" tabindex="10"  class="filter_required" data-errors="{filter_required:'Standard Remark  should not be blank!'}"  <?php echo $update; ?> multiple="multiple" style="height: 180px !important;"> 
    <option value="" <?php echo $disabled; ?>>Standard Remark</option>

    <?php foreach ($feed_stand_remark as $feed) { //var_dump($feed);?>

        <option value="<?php echo $feed->fdsr_id ;?>"  <?php
        if ($feed->fdsr_id == @$demo_data[0]->fc_standard_type) {
            echo "selected";
        }
        ?>><?php echo $feed->fdsr_type; ?></option>

    <?php } ?>


</select>