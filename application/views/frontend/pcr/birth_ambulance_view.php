 
<select name="birth_amb" class="filter_required" data-errors="{filter_required:'Child birth at ambulance should not be blank'}" tabindex="14">

        <option value="">Select</option>
        
        <?php if($birth_home=='no'){ ?>
        <option value="yes" selected="selected">Yes</option>
        <?php }else{?>
        <option value="no" selected="selected">No</option>
        <?php }?>
</select>