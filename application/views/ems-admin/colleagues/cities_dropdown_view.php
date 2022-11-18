
    <select id="city" name="clg[city]" class="filter_required" data-errors="{filter_required:'please select city'}">
        <option value="">select city</option>
        <?php
        
                foreach ($cities as $city) {
                    
                    echo "<option value='".$city->city_id."'>";
                    echo $city->city_name."</option>";
                }
        ?>
    </select>
