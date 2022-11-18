<div class="width100">
    <div class="head_outer">
        <h3 class="txt_clr2 width1">Previous Odometer List</h3> 
    </div>
                            <div id="list_table" style="overflow: auto; max-height: 370px;" >

                        <table class="table report_table table-bordered table-responsive tblclr">
                            <tr>

                                <th>Date & Time</th>
                                <th>Incident ID</th>
                                <th>Odometer Type</th>
                                <th>Ambulance No</th>
                                <th>Start Odometer</th>
                                <th>End Odometer</th>
                            </tr>
    <?php 
    if($get_odometer){
        foreach($get_odometer as $odometer){ ?>
<tr>

                                <td><?php echo $odometer->timestamp; ?></td>
                                <td><?php 
                                if($odometer->odometer_type != ''){
                                if(strpos('closure', $odometer->odometer_type) !== false){
        echo $odometer->inc_ref_id; } } ?></td>
                                <td><?php echo ucfirst(str_replace('_',' ',$odometer->odometer_type)); ?></td>
                                <td><?php echo $odometer->amb_rto_register_no; ?></td>
                                <td><?php echo $odometer->start_odmeter; ?></td>
                                <td><?php echo $odometer->end_odmeter; ?></td>
                            </tr>
                            
            
    <?php 
        }
    }
    ?>
                        </table>
                            </div>
    
    
</div>