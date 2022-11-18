<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/show_corona_call_details" method="post" enctype="multipart/form-data" target="form_frame">
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
    $from_date =  date('Y-m-d', strtotime($report_args['from_date']));
    foreach($data as $inc){
        //var_dump($inc->corona_id_cl);  ?>

        <tr>         
            <td><?php echo $inc->inc_ref_id; ?></td> 
            <td><?php echo $inc->carona_test_date; ?></td> 
            <td><?php echo $inc->follow_up_date; ?></td> 
            <td><?php echo $inc->patient_name; ?></td>
            <td><?php echo $inc->mobile_no; ?></td>
            <td><?php echo $inc->patient_gender; ?></td>
             <td><?php echo $inc->patient_age; ?></td>
            <td><?php echo get_district_by_id($inc->district_id); ?></td> 
            <td><?php echo $inc->address; ?></td> 
            <td><?php echo follow_up_count_corona($inc->corona_id_cl,$from_date); ?></td>
            <td><?php echo $inc->is_phone_connected;?></td>
            <td><?php echo ucfirst($inc->fever); ?></td>
            <td><?php echo ucfirst($inc->cough); ?></td>
            <td><?php echo ucfirst($inc->diarrhoea); ?></td>
             <td><?php echo ucfirst($inc->abdominal_pain); ?></td>
             <td><?php echo ucfirst($inc->breathlessness); ?></td>
             <td><?php echo ucfirst($inc->nausea); ?></td>
             <td><?php echo ucfirst($inc->vomiting); ?></td>
             <td><?php echo ucfirst($inc->chest_pain); ?></td>
              <td><?php echo ucfirst($inc->sputum); ?></td>
               <td><?php echo ucfirst($inc->nasal_discharge); ?></td> 
               <td><?php echo ucfirst($inc->pulse_oxymeter); ?></td> 
               <td><?php echo $inc->oxygen_saturation_value ; ?></td> 
                <td><?php echo $inc->travel_history; ?></td>
               <td><?php echo $inc->current_place; ?></td>
                <td><?php echo $inc->ero_summary; ?></td>
               <td><?php echo $inc->ero_note; ?></td>
               
               
             


        </tr>

        <?php
    }
    ?>

</table>