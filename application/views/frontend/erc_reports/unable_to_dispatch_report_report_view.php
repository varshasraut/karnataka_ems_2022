<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function ?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>   
<table class="table report_table">

    <tr>                              
        <?php foreach ($header as $heading) { ?>
            <th style="line-height: 20px;"><?php echo $heading; ?></th>
            <?php } ?>
    </tr>
    <?php
    $count = 1;
    foreach ($inc_data as $inc) {
        if($inc->inc_recive_time != '' ){
            $d1= new DateTime($inc->inc_recive_time);
            
        
        $d2=new DateTime($inc->inc_datetime);
        $duration=$d2->diff($d1);
        //var_dump($duration);die;
            }
           if($duration != NULL){
           $duration = $duration->h . ':' . $duration->i . ':' . $duration->s;
           $duration = date('H:i:s', strtotime($duration));
           }
           else{
               $duration= "00:00:00";
           }
        $unable_to_dispatch_amb = get_unable_to_dispatch_amb($inc->inc_ref_id);
        ?>

        <tr>         
            <td><?php echo $inc->inc_ref_id; ?></td>
            <td><?php echo $inc->inc_recive_time; ?></td>
            <td><?php echo $inc->inc_datetime; ?></td> 
            <td><?php echo $duration; ?></td>
            <td><?php echo $inc->clr_fname.' '.$inc->clr_lname; ?></td> 
            <td><?php echo $inc->clr_mobile; ?></td> 
            
            <td><?php if($inc->current_district  != ''){ echo get_district_by_id($inc->current_district); }?></td>
             <td><?php if($inc->inc_tahshil_id  != ''){ echo get_tehsil_by_id($inc->inc_tahshil_id); }?></td>
            <td><?php 
            if($inc->inc_back_hospital != ''){
                $hospital = get_hospital_by_id($inc->inc_back_hospital);
                 echo $hospital[0]->hp_name;
            }
            ?></td> 
            <td><?php if($inc->home_district_id  != ''){ echo get_district_by_id($inc->home_district_id); }?></td>
            <td><?php echo get_ero_remark($inc->inc_ero_standard_summary); ?></td> 
            <td><?php echo $inc->inc_ero_summary; ?></td> 
            <?php 
            if($unable_to_dispatch_amb){
            foreach($unable_to_dispatch_amb as $unable){?>
            <td><?php echo $unable->amb_reg_no; ?></td> 
            <td><?php echo $unable->hp_name; ?></td>
            <td><?php echo get_ero_remark($unable->enable_remark); ?></td> 
            <?php } }else{ ?>
            <td></td> 
            <td></td>
            <td></td> 
            <td></td> 
            <td></td>
            <td></td> 
            <td></td> 
            <td></td>
            <td></td> 
            <?php } ?>
            <td><?php echo ucwords($inc->inc_added_by); ?></td> 
            <td><?php $clg_id = get_clg_data_by_ref_id($inc->inc_added_by);
            echo $clg_id[0]->clg_first_name.' '.$clg_id[0]->clg_last_name;
            ?></td> 

        </tr>

        <?php
        $count++;
    }
    ?>

</table>