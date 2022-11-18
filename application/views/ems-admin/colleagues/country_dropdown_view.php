<div class="field_row">
    <div class="field_lable">
        <label for="country">Country*</label>
    </div>
    <div class="filed_input">
        <select id="country" name="city[country]" class="filter_required" data-href='{base_url}gb-admin/city/city_details' data-qr='output_position=content&amp;module_name=city_model&amp;tlcode=MT-CLG-GET-STATES' data-errors="{filter_required:'please select country'}">
            <?php 
                foreach($city_select as $city){
                    echo "<option value=".$city->country_name.">".$city->country_name."</option>";
                }
            ?> 
        </select>
    </div>
</div>
