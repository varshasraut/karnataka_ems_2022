<!--<input name="amb_reg_id"  id="amb_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_baselocation?dist_code=<?php echo $dist_code; ?>" placeholder="Search Ambulance"  tabindex="2" autocomplete="off" value="" data-value="" data-callback-funct="serch_by_baselocation_no">-->
<div class="col-md-12" style="height: 40px; padding: 0px;">
    <div class="col-md-6 float_left" style="padding: 0px;">
<input name="amb_reg_id"  id="amb_id_base" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_baselocation" placeholder="Search Baselocation"  tabindex="2" autocomplete="off" value="" data-value="" data-callback-funct="serch_by_baselocation_no">
</div>

<div class="col-md-6 float_left" id="baselocation_ambulance" style="padding: 0px;">
<input name="amb_reg_id"  id="amb_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Search Ambulance"  tabindex="2" autocomplete="off" value="" data-value="" data-callback-funct="serch_by_amb_no">
</div>
</div>