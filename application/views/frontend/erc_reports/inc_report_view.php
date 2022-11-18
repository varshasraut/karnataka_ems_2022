<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function ?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['system']; ?>" name="system">
                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>   
<table class="table report_table">

    <tr>                              
        <?php 
        //var_dump($inc_data);die();
        foreach ($header as $heading) { ?>
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
           $clg_full_name = $inc->clg_first_name . ' ' . $inc->clg_mid_name . ' ' . $inc->clg_last_name;

        ?>

        <tr>         
            <td><?php echo $count; ?></td>
            <td><?php echo $inc->inc_recive_time; ?></td>
            <td><?php echo $inc->inc_ref_id; ?></td>
            <td><?php 
            if($inc->p_parent == 'EMG')
            {
                $parent = 'Emergency';
            }elseif($inc->p_parent == 'COMP'){
                $parent = 'Grievance call';
            }
            elseif($inc->p_parent == 'NON_EME'){
                $parent = 'Non Emergency';
            }
            elseif($inc->p_parent == 'CALL_TRANS'){
                $parent = 'CALL_TRANS';
            }
            echo $parent; ?>
            </td>
            <td><?php echo $inc->pname; ?></td>
            <td><?php echo $inc->clr_mobile; ?></td> 
            <td><?php echo ucfirst($inc->clr_fname.' '.$inc->clr_lname); ?></td> 
            <td><?php echo ptn_count($inc->inc_ref_id); ?></td> 
            <td><?php if($inc->ct_type != '')
            { 
                if($inc->ct_type == 'Other')
                {
                    echo $inc->ct_type.'-'.$inc->inc_complaint_other; 
                }else{ 
                    echo $inc->ct_type; 
                } 
            }else if($inc->ntr_nature != '')
            { echo $inc->ntr_nature; 
            } ?></td> 
            <td><?php echo ucfirst($inc->ptn_fname); ?> </td> 
            <td><?php echo $inc->ptn_age.' '.$inc->ptn_age_type; ?></td> 
            <td><?php  
            if($inc->ptn_gender == 'M'){ 
                echo 'Male'; 
            }else if($inc->ptn_gender == 'F'){ 
                echo 'Female'; 
            }else if($inc->ptn_gender == 'O'){
                echo 'Transgender';
            } ?></td> 
            <td><?php echo $inc->re_name; ?></td> 
            <td><?php echo $inc->inc_ero_summary; ?></td> 
            <td><?php echo $inc->inc_address; ?></td> 
            <td><?php echo $inc->dst_name; ?></td> 
            <td><?php echo $inc->amb_rto_register_no; ?></td> 
            <td><?php 
            if( $report_args['system'] == 'BIKE'){
                if($inc->hp_name == ''){ 
                    $hp_name = $inc->ward_name; 
                }else{ 
                    $hp_name = $inc->hp_name;
                 }
                 echo $hp_name;
            }else{
            echo $inc->base_location_name?$inc->base_location_name:$inc->hp_name;
            }?></td> 
            <!--<td><?php echo $inc->ward_name?$inc->ward_name:$inc->wrd_name; ?></td> -->
            
            <td><?php echo $inc->inc_datetime; ?></td> 
            <td><?php echo $duration; ?></td>
            <td><?php echo ucwords($inc->inc_added_by); ?></td> 
            <td><?php echo $clg_full_name; ?></td>

           <!-- <td><?php
                if ($inc->incis_deleted == '0') {
                    $status = 'Active';
                } else if ($inc->incis_deleted == '1') {
                    $status = 'Deleted';
                } else if ($inc->incis_deleted == '2') {
                    $status = 'Terminated';
                }
                echo $status;
                ?></td> -->
             <!--<td><?php  echo $inc->thirdparty_name; ?></td>-->
            <td><?php
                if ($inc->inc_pcr_status == '0') {
                    $status = 'Not Done';
                } else if ($inc->inc_pcr_status == '1') {
                    $status = 'Done';
                }
                echo $status;
                ?></td>

        </tr>

        <?php
        $inc->ct_type='';
        $inc->ntr_nature='';
        $count++;
    }
    ?>

</table>