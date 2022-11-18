<select name="extension_no" class="filter_required width100" data-errors="{filter_required:'Please select user type'}">
    <option value="">Select</option>  
    <optgroup label="Last login Extension" id="last_login_ext">
    </optgroup>
    <optgroup label="All Extension">
        <?php foreach ($extention_no as $ext) { ?>
            <option value="<?php echo $ext->extension_no; ?>"><?php echo $ext->extension_no; ?></option>
        <?php } ?>
    </optgroup>
</select>
<script>
var $last_login_ext = sessionStorage.getItem('last_login_ext');
if($last_login_ext != null){
    $("#last_login_ext").html('<option value="' + $last_login_ext + '">' + $last_login_ext + '</option>');
    $("#last_login_ext option").prop('selected',true);
}
</script>