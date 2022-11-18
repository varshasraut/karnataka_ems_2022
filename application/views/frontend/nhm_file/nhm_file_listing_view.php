<?php $CI = EMS_Controller::get_instance();?>

<div class="width100">
   <h2>Reports</h2><br>

<form enctype="multipart/form-data"  method="post">
    <div class="NHM_report_tables">
        <table class="report_table width100" style="width:100%;">
            <tr>   
                
                <th>Report</th>
                <th>Action</th>
            </tr>
            <?php if($file_listing){
                foreach($file_listing as $key=>$files){ 
                    
                    if($key == 'files'){
                         // var_dump($key);
                        foreach($files as $key=>$file){  ?>
                        <tr>

                            <td><?php echo basename($file,'.xlsx');

                            ?></td>
                            <td><a class="onpage_popup btn" style="background: #085b80 !important;" data-href="{base_url}file_nhm/load_report_form" data-qr="output_position=popup_div&report_type=<?php echo $file;?>" data-popupwidth="1700" data-popupheight="800">View</a></td>

                        </tr>
                    <?php //} 
                        }
                    }else{ 
                      // var_dump($file_listing['dir']);
                        
                        foreach($file_listing['dir'] as $key=>$dir_file){
                         
                        ?>
                          <tr>

                            <td><?php echo $key; ?></td>
                            <td>
                                
                            </td>

                        </tr>
                        <tr>
                            <td colspan="2">
                                <table style="margin-left: 10%;
width: 90%;
margin-top: -6px;">
                                    <?php foreach($dir_file as $files){
                                        foreach($files as $file){
                                       
                                        ?>
                                <tr>
                                <td><?php echo basename($file,'.xlsx');

                            ?></td>
                            <td><a class="onpage_popup btn" style="background: #085b80 !important;"  data-href="{base_url}file_nhm/load_report_form" data-qr="output_position=popup_div&report_type=<?php echo $file;?>" data-popupwidth="1700" data-popupheight="800">View</a></td>
</tr>
                                        <?php } } ?>
                                </table>
                                </td>
                        </tr>
                        <?php
                        }
                    }
                    
                } } ?>
        </table>
       
    </div>
</form>