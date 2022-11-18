    <select id="state" name="clg[state]" class="filter_required change-xhttp-request" data-href='{base_url}gb-admin/colleagues/get_city' data-qr='output_position=cities_dropdown_list&amp;module_name=colleagues&amp;tlcode=MT-CLG-GET-CITY' data-errors="{filter_required:'please select state'}">
        <option value="">select state</option>
            <?php
            
                foreach ($states as $state) {
                    
                    echo "<option value='".$state->state_code."'>";
                    echo $state->state_name."</option>";
                }
            ?>
    </select>

