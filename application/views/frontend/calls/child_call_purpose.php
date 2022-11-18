
<div class="width30 float_left">
<label class="headerlbl">Type Of Call</label>
</div>
<!-- <h3>Type of Call</h3> -->
<div id="purpose_of_calls" class="input width70 float_left">
    <select id="call_purpose" name="caller[cl_purpose]" class="filter_required" data-href="{base_url}calls/save_call_details" data-qr="output_position=content&amp;module_name=calls&amp;showprocess=no" data-errors="{filter_required:'Purpose of call should not blank'}" data-base="" TABINDEX="1.1"  onchange="submit_caller_form()">
        <option value="">Type Of Calls</option>
        <?php
        
        if ($cl_purpose) {
            $select_group[$cl_purpose] = "selected = selected";
        } 

        foreach ($parent_purpose_of_calls as $purpose_child) {
            echo "<option value='" . $purpose_child->pcode . "'  ";
            echo $select_group[$purpose_child->pcode];
            echo" >" . $purpose_child->pname;
            echo "</option>";
        }
        ?>
    </select>
</div>
