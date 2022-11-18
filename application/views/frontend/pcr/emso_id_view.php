<div class="width33 float_left">
  <div class="style6 float_left">EMT Name : </div><br><br>
  <div class="style6 float_left">EMT Mob No : </div>
</div>
<div class="width_62 float_left">
  <input name="emt_name" tabindex="25" class="form_input " placeholder="EMT Name" type="text" data-base="search_btn" data-errors="{filter_required:'EMT Name should not be blank!'}" value="<?= $emso_name; ?>"  <?php if($emt_id != 'Other'){ echo "readonly='readonly'"; }?>
  <input name="emt_id" tabindex="25" class="form_input"  type="hidden" value="<?=$clg_ref_id; ?>">
  <input name="emt_name_mob" tabindex="25" class="form_input " placeholder="EMT Mob No" type="text" data-base="search_btn" data-errors="{filter_required:'EMT Name should not be blank!'}" value="<?= $clg_mobile_no; ?>"  <?php if($emt_id != 'Other'){ echo "readonly='readonly'"; }?>>
</div>