<?php $CI = EMS_Controller::get_instance();?>

<div class="width100">
   <h2>Reports</h2><br>

<form enctype="multipart/form-data"  method="post">
    <div class="NHM_report_tables">
        <table class="table report_table">
             <tr>   
                <th>Sr. No</th>
                <th>Report</th>
                <th>Action</th>
            </tr>
              <?php
             
              if($report_info){
                foreach($report_info as $key=>$files){
                    
                   if($files['type'] == 'report'){
                    ?>
                     <tr>

                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $files['report_name']; ?></td>
                            <td>
                                <a class="onpage_popup btn" style="background: #085b80 !important;" data-href="{base_url}file_nhm/load_file_report_form" data-qr="output_position=popup_div&report_type=<?php echo $files['report_code'];?>&year=<?php echo $year;?>&month=<?php echo $month;?>" data-popupwidth="1500" data-popupheight="600">View</a>
                            </td>

                        </tr>
            <?php
                   }
              } } ?>

<!--
                        <tr>

                            <td>ALS Templets </td>
                            <td>

                            </td>

                        </tr>
                        <tr>
                            <td colspan="2">
                                <table style="margin-left: 10%;
width: 90%;
margin-top: -4px; border-bottom: 0px;">


                                    <?php
                                    if ($report_info) {
                                        foreach ($report_info as $key => $files) {
                                            ?>
                                            <?php
                                            if ($files['type'] == 'ALS') {
                                                ?>

                                                <tr style="height: 44px;">

                                                    <td><?php echo $files['report_name']; ?></td>
                                                    <td>
                                                          <a class="onpage_popup btn"  data-href="{base_url}file_nhm/load_file_report_form" data-qr="output_position=popup_div&report_type=<?php echo $files['report_code'];?>&year=<?php echo $year;?>&month=<?php echo $month;?>" data-popupwidth="1200" data-popupheight="600">View</a>
                                                    </td>

                                                </tr>
            <?php
        }
    }
}
?>  </table>
                            </td>
                        </tr>
                        <tr>

                            <td> BLS Templets </td>
                            <td>

                            </td>

                        </tr>
                        <tr>
                            <td colspan="2">
                                <table style="margin-left: 10%;
width: 90%;
margin-top: -4px; border-bottom: 0px;">


                                    <?php
                                    if ($report_info) {
                                        foreach ($report_info as $key => $files) {
                                            ?>
                                            <?php
                                            if ($files['type'] == 'BLS') {
                                                ?>

                                                <tr style="height: 44px;">

                                                    <td><?php echo $files['report_name']; ?></td>
                                                    <td>
                                                          <a class="onpage_popup btn"  data-href="{base_url}file_nhm/load_file_report_form" data-qr="output_position=popup_div&report_type=<?php echo $files['report_code'];?>&year=<?php echo $year;?>&month=<?php echo $month;?>" data-popupwidth="1200" data-popupheight="600">View</a>
                                                    </td>

                                                </tr>
            <?php
        }
    }
}
?>  </table>
                            </td>
                        </tr>-->
                        
                        
            
        </table>
                            
    </div>
</form>