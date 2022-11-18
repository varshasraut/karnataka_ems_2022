
<div class="col-md-12">Select Ambulance : </div>
<select name="amb_reg_id" id="amb_reg_id" data-errors="{filter_required:'Amb type should not blank'}" TABINDEX="7"  >
    <option value="">Select Ambulance</option>
    <?php foreach($amb_data as $ambulance_data){?>
        <option value="<?php echo $ambulance_data->amb_id  ;?>"><?php echo $ambulance_data->amb_rto_register_no ;?></option>
    <?php } ?>     
</select>

<script>
$(document).ready(function () {
      $('select').selectize({
          sortField: 'text'
      });
  });
</script>