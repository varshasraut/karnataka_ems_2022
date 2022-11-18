<style>

</style>
<?php $CI = EMS_Controller::get_instance(); 
$clg_status = array('0' => 'Inactive', '1' => 'Active', '2' => 'Deleted');
?>

<body>
<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">

                    <form action="<?php echo base_url(); ?>erc_reports/load_employee_report1" method="post" enctype="multipart/form-data" target="form_frame">
                    <input type="hidden" value="<?php echo $report_args;?>" name="department_name">
               
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right" style="margin: 20px 0 0 0 !important;">
                    </form>
                </div>
                
            </div>
</div>  
    <table class="table report_table">
        <tr>
            <?php foreach ($header as $heading) { ?>
            <th><?php echo $heading; ?></th>
            <?php } ?>

        </tr>
        <?php if (count($inc_data) > 0) {
            foreach ($inc_data as $inc) { 
            ?>
        <tr>
            <td><?php echo $inc['clg_id']; ?></td>
            <td><?php echo strtoupper($inc['clg_ref_id']); ?></td>
            <td><?php if($inc['clg_jaesemp_id'] == '')
            {
                echo '-';
            }
            else{
                echo $inc['clg_jaesemp_id'];
                } 
            ?></td>
            <td><?php echo strtoupper($inc['clg_group']); ?></td>
            <td><?php echo $inc['clg_designation']; ?></td>
            <td><?php echo ucwords($inc['clg_first_name']." ".$inc['clg_mid_name']." ".$inc['clg_last_name']); ?></td>
            <td><?php echo ucwords($inc['clg_mobile_no']); ?></td>
            <td><?php echo ucfirst($inc['clg_gender']); ?></td>
            <td><?php echo ucfirst($inc['clg_marital_status']); ?></td>
            <td><?php if($inc['clg_dob'] == '0000-00-00')
            { 
                echo '-';
            }
            else{
                echo date("d-M-Y", strtotime($inc['clg_dob']));
                }  
            ?></td>
            <td><?php if($inc['clg_joining_date'] == '0000-00-00')
            { echo '-';
            }
            else{
                echo date("d-M-Y",strtotime($inc['clg_joining_date']));
                } 
            ?></td>
            <td><?php if($inc['clg_senior'] == ''){ 
                echo '-';
            }
            else{
                echo ucfirst($inc['clg_senior']);
                } 
            ?></td>
            <td><?php if($inc['clg_user_type'] == '')
            {
                echo '-';
            }
            else{ 
                echo $inc['clg_user_type'];
                } ?></td>
            <td><?php if($inc['clg_avaya_agentid'] == '')
            {
                echo '-';
            } 
            else{ 
                echo $inc['clg_avaya_agentid'];
                } ?></td>
            <td><?php if($inc['clg_address'] == '')
            {
                echo '-';
            }else{ 
                echo ucfirst($inc['clg_address']);
                } ?></td>
            <td><?php echo $inc['clg_district_id'];; ?></td>
            <td><?php echo ucfirst($inc['clg_city']); ?></td>
            <td><?php echo $inc['clg_is_active']; ?></td>
            <td><?php echo $inc['clg_thirdparty']; ?></td> 
            <?php } ?>  
        </tr>
        <?php } else { ?>
            <tr>
                <td colspan="18" class="no_record_text">No Records Found</td>
            </tr>
                    <?php } ?>
    </table>
             
</body>

