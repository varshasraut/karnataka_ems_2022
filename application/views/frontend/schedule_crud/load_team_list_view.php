<?php 
$count =1;
$start_days = 0;
for($count = 1; $schedule_count >= $count;$count++){
    //var_dump($start_date);
?>


<div class="field_row width100">
<!-- <div class="shift width_15 float_left">   
       <label for=""> &nbsp;</label>             
</div> -->
    <div class="shift width_30 float_left">                   

        <input name="manage_date[]" class="filter_required" value="<?php echo date('Y-m-d', strtotime($start_date. '+'.$start_days.' days')); ?>" type="text" tabindex="2" placeholder="Date" data-errors="{filter_required:'Date should not blank'}" readonly="readonly">
    </div>
    

    <div class="shift width_30 float_left">

        <select name="shift_value[]" class="" tabindex="8" data-errors="{filter_required:'Register Number should not blank'}" <?php echo $view; ?> <?php //echo $edit; ?>> 
            <option value="">Select Shift</option>
            <?php
            foreach ($shift_info as $shift) {
                if($shift->shift_code  == $schedule->shift_value){
                    $selected =  "selected";
                }else{
                    $selected =  "";
                }
                echo "<option ".$selected." value='" . $shift->shift_code . "'  ";
                echo" > " . $shift->shift_name;
                echo "</option>";
            }
            ?>

        </select>
    </div>

</div>
<?php 
$start_days++;
} ?>