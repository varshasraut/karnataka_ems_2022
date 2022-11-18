<?php if ($inc_data) { ?>
    <table class="style5">
        <tr>
            <th colspan="7" style="color:#8786fb;"><h6>Last 12 Hours Incident</h6></th>
        </tr>
        <tr>
            <th>Incident Id</th>
            <th>Complaint Type</th>
            <th>Caller Name</th>
            <th>Caller Mobile</th>
            <th width="30%">Address</th>
            <th>Call Type</th>
            <th>Date And Time</th>
        </tr>

        <?php
        if ($inc_data) {
            foreach ($inc_data as $inc) {
                ?>

                <tr>
                    <td><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#666666;"><?php echo $inc->inc_ref_id; ?></a></td>

                    <?php if ($inc->inc_complaint != '' && $inc->inc_complaint != '0') { ?>
                    <td><?php echo get_cheif_complaint($inc->inc_complaint); ?></td>
                    <?php } else if ($inc->inc_mci_nature != '' ) { ?>
                        <td><?php echo get_mci_nature_service($inc->inc_mci_nature); ?></td>
                    <?php } ?>  


                    <td><?php echo $inc->clr_fname; ?> <?php echo $inc->clr_mname; ?> <?php echo $inc->clr_lname; ?></td>
                    <td><?php echo $inc->clr_mobile; ?></td>   
                    <td><?php echo $inc->inc_address; ?></td>
                    <td><?php echo ucwords(get_purpose_of_call($inc->inc_type)); ?></td>
                    <td><?php echo $inc->inc_datetime; ?></td>
                    <!-- <td><?php echo date('d-m-y', strtotime($inc->inc_datetime)); ?></td> -->
                </tr>
                <?php
            }
        } else {
            ?>
            <tr><td colspan="7" style="text-align: center;" class="no_record">No Duplicate record found for "<?php echo $chief_complete; ?>"</td></tr> 
        <?php } ?>

    </table><br>
<?php } ?>