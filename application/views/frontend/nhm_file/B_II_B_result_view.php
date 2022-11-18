<h3>B II B Report </h3>						

<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>file_nhm/b_ii_b" method="post" enctype="multipart/form-data" target="form_frame">
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
            <th>Event id</th>
            <th>Caller Number</th>
            <th>Whether the Call Was Disconnected</th>
            <th>Whether any Counselling was done</th>
            <th>Whether it Was a Prank Call</th>
            <th>Whether the call was meant for any city  corporation disaster cell</th>
            <th>Whether it was diverted to concerned city corporation disaster cell
</th>
            
    </tr>					



    <?php 
    
    if(is_array($report_info)){
        $cur_page_sr = ($page_no - 1) * 5000;
    foreach ($report_info as $key=>$inc) { 
   
     ?>
        <tr>  
               <td><?php echo $cur_page_sr + $key + 1; ?></td>
            <td><?php echo $inc['inc_id']; ?></td>
            <td><?php echo $inc['caller_no']; ?></td>
            <td><?php echo $inc['disconnected']; ?></td>
            <td><?php echo $inc['counselling']; ?></td>      
            <td><?php echo $inc['prank_call']; ?></td>
            <td><?php echo $inc['disaster']; ?></td>
            <td><?php echo $inc['transfer']; ?></td>
           

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
