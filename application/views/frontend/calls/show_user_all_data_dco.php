<?php
$CI = EMS_Controller::get_instance();

?>

<div class="width100 single_record">
                    <form action="<?php echo base_url(); ?>calls/download_login_details_link" method="post" enctype="multipart/form-data" target="form_frame">
                    <input type="hidden" value="<?php echo $clg_data[0]->clg_ref_id; ?>" name="clg_ref_id">
                    <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                   
                </form>

    <div id="list_table">

        <table class="table report_table">

            <tr class="single_record_back">                                     
                <td colspan="3">User details</td>
            </tr>
            <tr>                                     
                <td><strong>User Name</strong></td>
                <td colspan="2"><?php echo ucwords(strtolower($clg_data[0]->clg_first_name));?> <?php echo ucwords(strtolower($clg_data[0]->clg_last_name));?></td>
            </tr>
            <tr>                                     
                <td><strong>User Current Status</strong></td>
                <td colspan="2"><?php if($user_status[0]->status == 'free'){ echo "Free"; } else if($user_status[0]->status == 'atnd'){ echo "On Call"; }else if($user_status[0]->status == 'break'){ echo "Break"; }?></td>
            </tr>
            
        </table>
        <table class="table report_table">

                <tr class="single_record_back">     
        <!--        <th style="line-height: 20px;">Date</th>-->
                    <th style="line-height: 20px;">Call Type</th>
                    <th style="line-height: 20px;">Total Closure(Today)</th>
                    <th style="line-height: 20px;">Total Closure(This Month)</th>
                </tr>
                <?php

                foreach ($call_details as $calls) { //var_dump($calls);
                    
                    if($calls->p_parent =='EMG'){ ?>
                    <tr>         
                        <td><?php echo ucwords($calls->pname); ?></td>
                        <td><?php 
                        $calls_total = get_total_by_call_type_closure($clg_data[0]->clg_ref_id,$calls->pcode,$dur="to",$fr="",$to="",$inc_system_type=""); 
                        if($calls_total){
                            echo $calls_total;
                        }else{
                            echo "0";
                        }
                        ?></td>
                        <td><?php $calls_total = get_total_by_call_type_closure($clg_data[0]->clg_ref_id,$calls->pcode,$dur="tm",$fr="",$to="",$inc_system_type=""); 
                        if($calls_total){
                            echo $calls_total;
                        }else{
                            echo "0";
                        }
                        ?></td>
                    </tr>
                    <?php
                }
                }
                ?>

        </table>
        <table class="table report_table">

        <tr class="single_record_back">     
<!--        <th style="line-height: 20px;">Date</th>-->
            <th style="line-height: 20px;">Name</th>
            <th style="line-height: 20px;">Login time</th>
            <th style="line-height: 20px;">Logout Time</th>
        </tr>
        <?php
        
        foreach ($login_details as $inc) { //var_dump($inc);?>
            <tr>         
<!--            <td><?php echo $inc->clg_login_time; ?></td> -->
                <td><?php echo ucwords($inc->clg_first_name . ' ' . $inc->clg_mid_name . ' ' . $inc->clg_last_name); ?></td> 
                <td><?php echo $inc->clg_login_time; ?></td>
                <td><?php if($inc->clg_logout_time == "0000-00-00 00:00:00"){echo "Currently Login";}else{echo $inc->clg_logout_time;} ?></td>
            </tr>
            <?php
        }
        ?>

    </table>
         <table class="table report_table">

        <tr class="single_record_back">     
<!--        -->
            <th style="line-height: 20px;">Name</th>
            <th style="line-height: 20px;">Break time</th>
            <th style="line-height: 20px;">Back to Break Time</th>
            <th style="line-height: 20px;">Break type</th>
        </tr>
        <?php
        foreach ($break_details as $break) { //var_dump($break);?>
            <tr>         
<!--            <td><?php echo $break->clg_login_time; ?></td> -->
                <td><?php echo $break->clg_first_name . ' ' . $break->clg_mid_name . ' ' . $break->clg_last_name ?></td> 
                <td><?php echo $break->clg_break_time; ?></td>
                <td><?php echo $break->clg_back_to_break_time; ?></td>
                <td><?php echo $break->break_name; ?></td>

            </tr>
            <?php
        }
        ?>

    </table>
    </div>
</div>
    <iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>