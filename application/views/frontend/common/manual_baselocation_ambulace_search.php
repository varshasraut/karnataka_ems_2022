<!--<input name="amb_reg_id"  id="amb_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance?dist_code=<?php echo $dist_code; ?>" placeholder="Search Ambulance"  tabindex="2" autocomplete="off" value="" data-value="" data-callback-funct="serch_by_amb_no">-->
<div>
<input name="amb_reg_id"  id="amb_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance?base_id=<?php echo $base_id; ?>" placeholder="Search Ambulance"  tabindex="2" autocomplete="off" value="<?php echo $amb_data[0]->amb_rto_register_no;?>" data-value="<?php echo $amb_data[0]->amb_rto_register_no;?>" data-callback-funct="serch_by_amb_no">
</div>

<script type="text/javascript">
show_default_ambulance(<?php echo $amb_data[0]->amb_rto_register_no;?>);
</script>