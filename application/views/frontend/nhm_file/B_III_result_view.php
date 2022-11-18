<h3>B III Report </h3>						

<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>file_nhm/b_iii" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" name="from_date" value="<?php echo $from_date;?>">
                        <input type="hidden" name="to_date" value="<?php echo $to_date;?>">
                        <input type="hidden" name="report_type" value="<?php echo $report_type;?>">
                         <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>
                
            </div>
</div>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>

<table class="table report_table" style="border-collapse: collapse;">

    <tr>                              
             <th>Sr.NO</th>
            <th>Caller No.</th>
            <th>Call Disconnected Time</th>
            <th>Time at which ambulance reached the site</th>
            <th>Response Time</th>
            <th>Registration number of the ambulance to which call was assigned</th>
            <th>Base location of the said ambulance</th>
            <th>Location of the incident</th>
            <th>Hospital in which the patient was admitted</th>
            <th>Code No. of hospital</th>
            <th>Urban /Rural</th>
    </tr>					



    <?php 
    if(is_array($report_info)){
        $cur_page_sr = ($page_no - 1) * 5000;
    foreach ($report_info as $key=>$inc) { 
        
   
     ?>
        <tr>  
            <td><?php echo $cur_page_sr + $key + 1; ?></td>
            <td><?php echo $inc['Caller_no']; ?></td>
            <td><?php echo $inc['Call_disconnected']; ?></td>
            <td><?php echo $inc['At_scene']; ?></td>
            <td><?php echo $inc['Response_time']; ?></td>      
            <td><?php echo $inc['Ambulance_no']; ?></td>
            <td><?php echo $inc['Base_location']; ?></td>
            <td><?php echo $inc['inc_address']; ?></td>
            <td><?php echo $inc['Hospital_name']; ?></td>
            <td><?php echo $inc['Hospital_code']; ?></td>
            <td><?php echo $inc['Area']; ?></td>
           

        </tr>

<?php }}?>


</table>
 <div class="bottom_outer">

                    <div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php
                    if (@$data) {
                        echo $data;
                    }
                    ?>">

                    <div class="width38 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}file_nhm/result_load_file_report_form" data-qr="output_position=content&amp;flt=true&amp;report_type=<?php echo $report_type;?>&from_date=<?php echo $from_date;?>&to_date=<?php echo $to_date;?>">

                                    <?php echo rec_perpg($pg_rec); ?>

                                </select>

                            </div>

                            <div class="float_right">
                                <span> Total records: <?php
                                    if (@$total_count) {
                                        echo $total_count;
                                    } else {
                                        echo"0";
                                    }
                                    ?> </span>
                            </div>

                        </div>

                    </div>

                </div>