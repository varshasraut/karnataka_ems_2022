<div class="width33 float_left">
  <div class="style6 float_left">PILOT Name : </div><br><br>
  <div class="style6 float_left">PILOT Mob No : </div>
</div>
<div class="width_62 float_left">
<input name="pilot_name" tabindex="25" class="form_input" placeholder="Pilot Name" type="text" data-base="search_btn" data-errors="{filter_required:'Pilot Name should not be blank!'}" value="<?= $pilot_name; ?>" readonly="readonly">
  <input name="pilot_id" tabindex="25" class="form_input"  type="hidden" value="<?=$clg_ref_id; ?>">
  <input name="pilot_mob" tabindex="25" class="form_input" placeholder="Pilot Mob No" type="text" data-base="search_btn" data-errors="{filter_required:'Pilot Name should not be blank!'}" value="<?= $clg_mobile_no; ?>" readonly="readonly">
</div>
  