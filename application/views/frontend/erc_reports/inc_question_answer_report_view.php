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
        ?>

        <tr>         
            <td><?php echo $count; ?></td>
            <td><?php echo $inc->inc_datetime; ?></td>
            <td><?php echo $inc->inc_ref_id; ?></td>
            <td>
                <?php   
                        $thirdparty = '';
            if($inc->inc_thirdparty  != ''){
                $thirdparty = get_third_party_name($inc->inc_thirdparty );
            }
            echo $thirdparty;
                ?> 
                </td>
            <?php  
            foreach($inc->inc_ques_data as $question){ ?>
            <td>
                
              <?php  echo $question->que_question; echo " : "; if($question->sum_que_ans == "Y" || $question->sum_que_ans == "y" ){ echo "YES"; }else{ echo "NO"; }; ?>
            </td>
            <?php } ?>
           
            
            

        </tr>

        <?php
        $count++;
    }
    ?>

</table>