<?php
$CI = EMS_Controller::get_instance();

$inv_types = array('CA' => 'Consumables', 'NCA' => 'Non Consumables');
?>

<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>reports/res_report" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                        <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
                        <input type="hidden" value="<?php echo $report_args['amb_type'];?>" name="amb_type">
                        <input type="hidden" value="<?php echo $report_args['system_type'];?>" name="system_type">
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>
                
            </div>
</div>   
<div class="box3">    
        <!-- <table class="table report_table"> -->
        <div id="list_table">
        <table class="table table-sm table-bordered" style="width:50%; margin-left:25%;">
                        <tdead class="text-center">
                          
                          <tr><td style="background: lightblue;text-align:center;font-weight:bold;" colspan="2">Basic Life Support (BLS)</th></tr>
                          <tr>
                            <td class="dif" >MP IRTS</th>
                            <td ><?php echo $inc_data['month']; ?></td>
                          </tr>
                          <tr>
                            <td class="dif" >No. of Ambulances Operational under dial 108</th>
                            <td ><?php echo $inc_data['amb_count_bls'][0]->amb;  ?></td>
                          </tr>
                          <tr>
                            <td colspan='2' style="text-align:center;font-weight:bold;">Average Response Time - Urban</th>
                          </tr>
                          <tr>
                            <td class="dif" >Call To Scene Time(Min.Sec)</th>
                            <td ><?php echo (abs ($inc_data['call_to_scene_time_urban_bls'])) ?></td>
                          </tr>
                          <tr>
                            <td class="dif" >Call To Hospital Time(Min.Sec)</th>
                            <td ><?php echo (abs ($inc_data['call_to_hosp_time_urban_bls'])) ?></td>
                          </tr>
                          <tr>
                            <td colspan='2' style="text-align:center;font-weight:bold;">Average Response Time - Rural</th>
                            
                          </tr>
                          <tr>
                            <td class="dif" >Call To Scene Time(Min.Sec)</th>
                            <td ><?php echo (abs ($inc_data['call_to_scene_time_rural_bls'])) ?></td>
                          </tr>
                          <tr>
                            <td class="dif" >Call To Hospital Time(Min.Sec)</th>
                            <td ><?php echo (abs ($inc_data['call_to_hosp_time_rural_bls'])) ?></td>
                          </tr>
                          <tr><td class="dif" >Percentage of calls denied due to shortage/unavaibility of Ambulances</th>
                          	<td ><?php echo $inc_data['amb_unavailability_percentage_bls']. ' %'; ?></td></tr>





                            <tr><td style="background: lightblue;text-align:center;font-weight:bold;" colspan="2">Advanced Life Support (ALS)</th></tr>
                          
                          <tr>
                            <td class="dif" >No. of Ambulances Operational under dial 108</th>
                            <td ><?php echo $inc_data['amb_count_als'][0]->amb;  ?></td>
                          </tr>
                          <tr>
                            <td colspan='2' style="text-align:center;font-weight:bold;">Average Response Time - Urban</th>
                          </tr>
                          <tr>
                            <td class="dif" >Call To Scene Time(Min.Sec)</th>
                            <td ><?php echo (abs ($inc_data['call_to_scene_time_urban_als'])) ?></td>
                          </tr>
                          <tr>
                            <td class="dif" >Call To Hospital Time(Min.Sec)</th>
                            <td ><?php echo (abs ($inc_data['call_to_hosp_time_urban_als'])) ?></td>
                          </tr>
                          <tr>
                            <td colspan='2' style="text-align:center;font-weight:bold;">Average Response Time - Rural</th>
                            
                          </tr>
                          <tr>
                            <td class="dif" >Call To Scene Time(Min.Sec)</th>
                            <td ><?php echo (abs ($inc_data['call_to_scene_time_rural_als'])) ?></td>
                          </tr>
                          <tr>
                            <td class="dif" >Call To Hospital Time(Min.Sec)</th>
                            <td ><?php echo (abs ($inc_data['call_to_hosp_time_rural_als'])) ?></td>
                          </tr>
                          <tr><td class="dif" >Percentage of calls denied due to shortage/unavaibility of Ambulances</th>
                          	<td ><?php echo $inc_data['amb_unavailability_percentage_als']. ' %'; ?></td></tr>
            
        </table>
        </div>
</div>




