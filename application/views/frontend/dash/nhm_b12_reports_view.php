<div id="b12_data_block">
<script>
        $(".mi_loader").fadeOut("slow");
        // clearInterval(refreshIntervalId);
   
        jQuery(document).ready(function() {

            var dateFormat = "mm/dd/yy",
                from = jQuery("#from_date")
                .datepicker({
                    dateFormat: 'dd-mm-yy',
                    defaultDate: new Date(),
                    changeMonth: true,
                    numberOfMonths: 1,
                    minDate: new Date(2021, 07 - 1, 01),
                    maxDate:-2
                })
                .on("change", function() {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
                    dateFormat: 'dd-mm-yy',
                    defaultDate: new Date(),
                    changeMonth: true,
                    numberOfMonths: 1,
                    minDate: new Date(2021, 07 - 1, 01),
                
                    maxDate:-2
                })
                .on("change", function() {
                    from.datepicker("option", "maxDate", getDate(this));
                });

            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }
                return date;
            }
        });
    </script>
<?php
    $CI = EMS_Controller::get_instance();
    ?>

<div class="row">
    <form action="" id="b12_data" class="col-md-12" method="post">
    <div class="col-md-2 float_left" style="margin-top: 5px;">
    <input name="from_date" tabindex="1" class="form_input" placeholder="From Date" type="text" value="<?php echo $from_date; ?>" readonly="readonly" id="from_date">

    </div>
    <div class="col-md-2 float_left" style="margin-top: 5px;">
    <input name="to_date" tabindex="2" class="form_input" placeholder="To Date" type="text" data-base="search_btn" value="<?php echo $to_date; ?>" readonly="readonly" id="to_date">

    </div>

    <div class="col-md-2 float_left">
  
        <input type="button" name="submit" value="Submit" class="form-xhttp-request button_print2" data-href='<?php echo base_url(); ?>dashboard/B12_data'>
       
    </div>
    <div class="col-md-4 float_left">
    </div>
    <div class="col-md-2 float_left">
<div id="print">
   <button class="button_print" onclick="window.print()">Download</button>
   </div>
   </div>
    </form>
</div>
<div class="left-half">
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered NHM_Dashboard B12_report_dash">
                <thead>
                    <tr>
                        <th id="rttblmain" colspan="6" scope="col">108 Emergency Type Wise Patient Served</th>
                    </tr>
                </thead>
                <tr style="width: 100%;">
                <?php
                 $date_before1 = date('d-m-Y', mktime(0, 0, 0, date("m") , date("d") - 2, date("Y")));
                if($to_date != '' && $from_date != ''){
                    $to_date =  date('d-m-Y', strtotime($to_date));
                    $from_date =  date('d-m-Y', strtotime($from_date));
                    $date_before = $from_date.'-<br>'.$to_date;
                }else{
                $date_before = date('d-m-Y', strtotime(' -2 day'));
                }
                
                ?>
                    <th id="rttblmain1">Emergency Type</th>
                    <th id="rttblmain2">Closure <br> Today</th>
                    <th id="rttblmain" ><?php echo $date_before?></th>
                    <th id="rttblmain3">Month Till Date</th>
                    <th id="rttblmain4">Till Date</th>
                </tr>

                <!-- <tr><?php foreach ($header as $heading) { ?><th><?php echo $heading; ?></th><?php } ?> </tr>-->
                <?php

                $Accident_data_today = 0;
                $assault_data_today = 0;
                $burn_data_today = 0;
                $attack_data_today = 0;
                $fall_data_today = 0;
                $poision_data_today = 0;
                $labour_data_today = 0;
                $light_data_today = 0;
                $mass_data_today = 0;
                $report_data_today = 0;
                $other_data_today = 0;
                $trauma_data_today = 0;
                $suicide_data_today = 0;
                $delivery_in_amb_data_today = 0;
                $pt_manage_on_veti_data_today = 0;
                $unavail_call_data_today = 0;

                $Accident_data = 0;
                $assault_data = 0;
                $burn_data = 0;
                $attack_data = 0;
                $fall_data = 0;
                $poision_data = 0;
                $labour_data = 0;
                $light_data = 0;
                $mass_data = 0;
                $report_data = 0;
                $other_data = 0;
                $trauma_data = 0;
                $suicide_data = 0;
                $delivery_in_amb_data = 0;
                $pt_manage_on_veti_data = 0;
                $unavail_call_data = 0;

                $Accident_data_tm = 0;
                $assault_data_tm = 0;
                $burn_data_tm = 0;
                $attack_data_tm = 0;
                $fall_data_tm = 0;
                $poision_data_tm = 0;
                $labour_data_tm = 0;
                $light_data_tm = 0;
                $mass_data_tm = 0;
                $report_data_tm = 0;
                $other_data_tm = 0;
                $trauma_data_tm = 0;
                $suicide_data_tm = 0;
                $delivery_in_amb_data_tm = 0;
                $pt_manage_on_veti_data_tm = 0;
                $unavail_call_data_tm = 0;

                $Accident_data_td = 0;
                $assault_data_td = 0;
                $burn_data_td = 0;
                $attack_data_td = 0;
                $fall_data_td = 0;
                $poision_data_td = 0;
                $labour_data_td = 0;
                $light_data_td = 0;
                $mass_data_td = 0;
                $report_data_td = 0;
                $other_data_td = 0;
                $trauma_data_td = 0;
                $suicide_data_td = 0;
                $delivery_in_amb_data_td = 0;
                $pt_manage_on_veti_data_td = 0;
                $unavail_call_data_td = 0;

                if (is_array($inc_data)) {
                    foreach ($inc_data as $inc) { ?>
                        <tbody>
                            <tr>
                                <td id="righttblh">&nbsp;Accident Vehicle</td>
                                
                                <td id="righttbl"><?php echo $inc['Accident_data_today'];
                                                    $Accident_data_today = $Accident_data_today + $inc['Accident_data_today']; ?></td>
                               
                                <td id="righttbl"><?php echo $inc['Accident_data'];
                                                    $Accident_data = $Accident_data + $inc['Accident_data']; ?></td>
                                <td id="righttbl"><?php echo $inc['Accident_data_tm'] + $Accident_data_today;
                                                    $Accident_data_tm = $Accident_data_tm + $inc['Accident_data_tm']; ?></td>
                                <td id="righttbl"><?php echo $inc['Accident_data_td'] + $Accident_data_today;
                                                    $Accident_data_td = $Accident_data_td + $inc['Accident_data_td']; ?></td>
                            </tr>
                            <tr>
                                <td id="righttblh">&nbsp;Assault</td>
                              
                                <td id="righttbl"><?php echo $inc['assault_data_today'];
                                                    $assault_data_today = $assault_data_today + $inc['assault_data_today']; ?></td>
                        
                                <td id="righttbl"><?php echo $inc['assault_data'];
                                                    $assault_data = $assault_data + $inc['assault_data']; ?></td>
                                <td id="righttbl"><?php echo $inc['assault_data_tm'] + $assault_data_today;
                                                    $assault_data_tm = $assault_data_tm + $inc['assault_data_tm']; ?></td>
                                <td id="righttbl"><?php echo $inc['assault_data_td'] + $assault_data_today;
                                                    $assault_data_td = $assault_data_td + $inc['assault_data_td']; ?></td>
                            </tr>
                            <tr>
                                <td id="righttblh">&nbsp;Burns</td>
                             
                                <td id="righttbl"><?php echo $inc['burn_data_today'];
                                                    $burn_data_today = $burn_data_today + $inc['burn_data_today']; ?></td>
                              
                                <td id="righttbl"><?php echo $inc['burn_data'];
                                                    $burn_data = $burn_data + $inc['burn_data']; ?></td>
                                <td id="righttbl"><?php echo $inc['burn_data_tm'] + $burn_data_today;
                                                    $burn_data_tm = $burn_data_tm + $inc['burn_data_tm']; ?></td>
                                <td id="righttbl"><?php echo $inc['burn_data_td'] + $burn_data_today;
                                                    $burn_data_td = $burn_data_td + $inc['burn_data_td']; ?></td>
                            </tr>
                            <tr>
                                <td id="righttblh">&nbsp;Cardiac</td>
                               
                                <td id="righttbl"><?php echo $inc['attack_data_today'];
                                                    $attack_data_today = $attack_data_today + $inc['attack_data_today']; ?></td>
                             
                                <td id="righttbl"><?php echo $inc['attack_data'];
                                                    $attack_data = $attack_data + $inc['attack_data']; ?></td>
                                <td id="righttbl"><?php echo $inc['attack_data_tm'] + $attack_data_today;
                                                    $attack_data_tm = $attack_data_tm + $inc['attack_data_tm']; ?></td>
                                <td id="righttbl"><?php echo $inc['attack_data_td'] + $attack_data_today;
                                                    $attack_data_td = $attack_data_td + $inc['attack_data_td']; ?></td>
                            </tr>
                            <tr>
                                <td id="righttblh">&nbsp;Fall</td>
                               
                                <td id="righttbl"><?php echo $inc['fall_data_today'];
                                                    $fall_data_today = $fall_data_today + $inc['fall_data_today']; ?></td>
                              
                                <td id="righttbl"><?php echo $inc['fall_data'];
                                                    $fall_data = $fall_data + $inc['fall_data']; ?></td>
                                <td id="righttbl"><?php echo $inc['fall_data_tm'] + $fall_data_today;
                                                    $fall_data_tm = $fall_data_tm + $inc['fall_data_tm']; ?></td>
                                <td id="righttbl"><?php echo $inc['fall_data_td']+$fall_data_today;
                                                    $fall_data_td = $fall_data_td + $inc['fall_data_td']; ?></td>
                            </tr>

                            <tr>
                                <td id="righttblh">&nbsp;Intoxication/Poisoning</td>
                               
                                <td id="righttbl"><?php echo $inc['poision_data_today'];
                                                    $poision_data_today = $poision_data_today + $inc['poision_data_today']; ?></td>
                                
                                <td id="righttbl"><?php echo $inc['poision_data'];
                                                    $poision_data = $poision_data + $inc['poision_data']; ?></td>
                                <td id="righttbl"><?php echo $inc['poision_data_tm'] + $poision_data_today;
                                                    $poision_data_tm = $poision_data_tm + $inc['poision_data_tm']; ?></td>
                                <td id="righttbl"><?php echo $inc['poision_data_td'] + $poision_data_today;
                                                    $poision_data_td = $poision_data_td + $inc['poision_data_td']; ?></td>
                            </tr>
                            <tr>
                                <td id="righttblh">&nbsp;Labour/Pregnancy</td>
                               
                                <td id="righttbl"><?php echo $inc['labour_data_today'];
                                                    $labour_data_today = $labour_data_today + $inc['labour_data_today']; ?></td>
                               
                                <td id="righttbl"><?php echo $inc['labour_data'];
                                                    $labour_data = $labour_data + $inc['labour_data']; ?></td>
                                <td id="righttbl"><?php echo $inc['labour_data_tm'] + $labour_data_today;
                                                    $labour_data_tm = $labour_data_tm + $inc['labour_data_tm']; ?></td>
                                <td id="righttbl"><?php echo $inc['labour_data_td'] + $labour_data_today;
                                                    $labour_data_td = $labour_data_td + $inc['labour_data_td']; ?></td>
                            </tr>
                            <tr>
                                <td id="righttblh">&nbsp;Lighting/Electrocution</td>
                                
                                <td id="righttbl"><?php echo $inc['light_data_today'];
                                                    $light_data_today = $light_data_today + $inc['light_data_today']; ?></td>
                                
                                <td id="righttbl"><?php echo $inc['light_data'];
                                                    $light_data = $light_data + $inc['light_data']; ?></td>
                                <td id="righttbl"><?php echo $inc['light_data_tm'] + $light_data_today;
                                                    $light_data_tm = $light_data_tm + $inc['light_data_tm']; ?></td>
                                <td id="righttbl"><?php echo $inc['light_data_td'] + $light_data_today;
                                                    $light_data_td = $light_data_td + $inc['light_data_td']; ?></td>

                            </tr>
                            <tr>
                                <td id="righttblh">&nbsp;Mass Casualty</td>
                               
                                <td id="righttbl"><?php echo $inc['mass_data_today'];
                                                    $mass_data_today = $mass_data_today + $inc['mass_data_today']; ?></td>
                                
                                <td id="righttbl"><?php echo $inc['mass_data'];
                                                        $mass_data = $mass_data + $inc['mass_data']; ?></td>
                                                        <!-- <td id="righttbl"></td> -->
                                <td id="righttbl"><?php echo $inc['mass_data_tm'] + $mass_data_today;
                                                    $mass_data_tm = $mass_data_tm + $inc['mass_data_tm']; ?></td>   
                                <td id="righttbl"><?php echo $inc['mass_data_td'] + $mass_data_today;
                                                    $mass_data_td = $mass_data_td + $inc['mass_data_td']; ?></td>
                            </tr>
                            <tr>
                                <td id="righttblh">&nbsp;Medical</td>
                                
                                <td id="righttbl"><?php echo $inc['report_data_today'];
                                                    $report_data_today = $report_data_today + $inc['report_data_today']; ?></td>
                               
                                <td id="righttbl"><?php echo $inc['report_data'];
                                                    $report_data = $report_data + $inc['report_data']; ?></td>
                                <td id="righttbl"><?php echo $inc['report_data_tm'] + $report_data_today;
                                                    $report_data_tm = $report_data_tm + $inc['report_data_tm']; ?></td>
                                <td id="righttbl"><?php echo $inc['report_data_td'] + $report_data_today;
                                                    $report_data_td = $report_data_td + $inc['report_data_td']; ?></td>
                            </tr>

                            <tr>
                                <td id="righttblh">&nbsp;Poly Trauma</td>
                               
                                <td id="righttbl"><?php echo $inc['trauma_data_today'];
                                                    $trauma_data_today = $trauma_data_today + $inc['trauma_data_today']; ?></td>
                               
                                <td id="righttbl"><?php echo $inc['trauma_data'];
                                                    $trauma_data = $trauma_data + $inc['trauma_data']; ?></td>
                                <td id="righttbl"><?php echo $inc['trauma_data_tm'] + $trauma_data_today;
                                                    $trauma_data_tm = $trauma_data_tm + $inc['trauma_data_tm']; ?></td>
                                <td id="righttbl"><?php echo $inc['trauma_data_td'] + $trauma_data_today;
                                                    $trauma_data_td = $trauma_data_td + $inc['trauma_data_td']; ?></td>
                            </tr>
                            <tr>
                                <td id="righttblh">&nbsp;Suicide/Self Inflicted Injury</td>
                               
                                <td id="righttbl"><?php echo $inc['suicide_data_today'];
                                                    $suicide_data_today = $suicide_data_today + $inc['suicide_data_today']; ?></td>
                               
                                <td id="righttbl"><?php echo $inc['suicide_data'];
                                                    $suicide_data = $suicide_data + $inc['suicide_data']; ?></td>
                                <td id="righttbl"><?php echo $inc['suicide_data_tm'] + $suicide_data_today;
                                                    $suicide_data_tm = $suicide_data_tm + $inc['suicide_data_tm']; ?></td>
                                <td id="righttbl"><?php echo $inc['suicide_data_td'] + $suicide_data_today;
                                                    $suicide_data_td = $suicide_data_td + $inc['suicide_data_td']; ?></td>
                            </tr>
                            <tr>
                                <td id="righttblh">&nbsp;Others</td>
                              
                                <td id="righttbl"><?php echo $inc['other_data_today'];
                                                    $other_data_today = $other_data_today + $inc['other_data_today']; ?></td>
                                
                                <td id="righttbl"><?php echo $inc['other_data'];
                                                    $other_data = $other_data + $inc['other_data']; ?></td>
                                <td id="righttbl"><?php echo $inc['other_data_tm'] + $other_data_today;
                                                    $other_data_tm = $other_data_tm + $inc['other_data_tm']; ?></td>
                                <td id="righttbl"><?php echo $inc['other_data_td'] + $other_data_today;
                                                    $other_data_td = $other_data_td + $inc['other_data_td']; ?></td>
                            </tr>
                            <!--<tr>
                            <td>Unavail Call</td>
                            <td><?php echo $inc['unavail_call_data'];
                                $unavail_call_data = $unavail_call_data + $inc['unavail_call_data']; ?></td>
                            <td><?php echo $inc['unavail_call_data_tm'];
                                $unavail_call_data_tm = $unavail_call_data_tm + $inc['unavail_call_data_tm']; ?></td>
                            <td><?php echo $inc['unavail_call_data_td'];
                                $unavail_call_data_td = $unavail_call_data_td + $inc['unavail_call_data_td']; ?></td>
                        </tr>-->


                    <?php } }?>
                    <tr>
                        <th id="rttblmain" style="text-align:left"><b>Total</b></th>
                     
                        <th id="rttblmain"><b><?php echo $Accident_data_today + $assault_data_today + $burn_data_today + $attack_data_today + $fall_data_today + $poision_data_today + $labour_data_today + $light_data_today + $mass_data_today + $report_data_today + $other_data_today + $trauma_data_today + $suicide_data_today; ?></b></th>
                       <?php $today = $Accident_data_today + $assault_data_today + $burn_data_today + $attack_data_today + $fall_data_today + $poision_data_today + $labour_data_today + $light_data_today + $mass_data_today + $report_data_today + $other_data_today + $trauma_data_today + $suicide_data_today; ?>
                        <th id="rttblmain"><b><?php echo $Accident_data + $assault_data + $burn_data + $attack_data + $fall_data + $poision_data + $labour_data + $light_data + $mass_data + $report_data + $other_data + $trauma_data + $suicide_data; ?></b></th>
                        <th id="rttblmain"><b><?php echo $today + $Accident_data_tm + $assault_data_tm + $burn_data_tm + $attack_data_tm + $fall_data_tm + $poision_data_tm + $labour_data_tm + $light_data_tm + $mass_data_tm + $report_data_tm + $other_data_tm + $trauma_data_tm + $suicide_data_tm; ?></b></th>
                        <th id="rttblmain"><b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $today+$Accident_data_td + $assault_data_td + $burn_data_td + $attack_data_td + $fall_data_td + $poision_data_td + $labour_data_td + $light_data_td + $mass_data_td + $report_data_td + $other_data_td + $trauma_data_td + $suicide_data_td ; ?>&nbsp;&nbsp;&nbsp;&nbsp;</b></th>
                    </tr>
                        </tbody>
            </table>
        </div>
    </div>
    <!-- <div class="etwpsnb">NB : TODAY AND TILL MONTH BASED ON TOTAL CLOSURE</div><br> -->

</div>


<div class="right-half">
    <div style="padding-left:50px;">
        <div id="ETWPS">
            <label>Emergency Types</label><br>
            <button type="button" id="frmbtm" onclick="funto();" class="btn-outline-primary"><?php echo $date_before?></button>
            <button type="button" id="frmbtm" onclick="funto2()" class="btn-outline-primary">Till Month</button>
            <button type="button" id="frmbtm" onclick="funto3()" class="btn-outline-primary">Till Date</button>
        </div>
        <div id="pie">
            <canvas id="pieChart" style="max-width:500px;display:inline;"></canvas>
        </div>
        <div id="pie2">
            <canvas id="pieChart2" style="max-width:500px;display:inline;"></canvas>
        </div>
        <div id="pie3">
            <canvas id="pieChart3" style="max-width:500px;display:inline;"></canvas>
        </div>
    </div>
    <div class="desctbl">
        <table class="table table-bordered NHM_Dashboard B12_report_dash">
            <tr>
                <th id="lefttbl" style="width: 50%">Descriptions</th>
                
                    <th id="rttblmain">Closure<br> Today</th>
                   
                <th id="lefttbl"><?php echo $date_before; ?></th>
                <th id="lefttbl" style="width: 10%">Till Month</th>
                <th id="lefttbl" style="width: 20%">Till Date</th>
            </tr>
            <?php
            $delivery_in_amb_data = 0;
            $pt_manage_on_veti_data = 0;

            $delivery_in_amb_data_tm = 0;
            $pt_manage_on_veti_data_tm = 0;

            $delivery_in_amb_data_td = 0;
            $pt_manage_on_veti_data_td = 0;

            if (is_array($inc_data)) {
                foreach ($inc_data as $inc) { ?>
                    <tbody>
                        <tr>
                            <td id="lefttbltdh">&nbsp;Deliveries In Ambulance</td>
                            
                            <td id="lefttbltd" style="padding: 0px;"><?php echo $inc['delivery_in_amb_data_today'];
                                                                        $delivery_in_amb_data_today = $delivery_in_amb_data_today + $inc['delivery_in_amb_data_today']; ?></td>
                           
                            <td id="lefttbltd" style="padding: 0px;"><?php echo $inc['delivery_in_amb_data'];
                                                                        $delivery_in_amb_data = $delivery_in_amb_data + $inc['delivery_in_amb_data']; ?></td>
                            <td id="lefttbltd" style="padding: 0px;"><?php echo $inc['delivery_in_amb_data_tm'] + $delivery_in_amb_data_today;
                                                                        $delivery_in_amb_data_tm = $delivery_in_amb_data_tm + $inc['delivery_in_amb_data_tm']; ?></td>
                            <td id="lefttbltd" style="padding: 0px;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $inc['delivery_in_amb_data_td'] + $delivery_in_amb_data_today;
                                                                        $delivery_in_amb_data_td = $delivery_in_amb_data_td + $inc['delivery_in_amb_data_td']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>

<!-- <td id="lefttbltd" style="padding: 0px;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "37740" ?>&nbsp;&nbsp;&nbsp;&nbsp;</td> -->
                        </tr>
                        <tr>
                            <td id="lefttbltdh">&nbsp;Patient Manage on Ventilator</td>
                            
                            <td id="lefttbltd" style="padding: 0px;"><?php echo $inc['pt_manage_on_veti_data_today'];
                                                                        $pt_manage_on_veti_data_today = $pt_manage_on_veti_data_today + $inc['pt_manage_on_veti_data_today']; ?></td>
                           

                           <!-- <td id="lefttbltd" style="padding: 0px;">0</td> -->
                            <td id="lefttbltd" style="padding: 0px;"><?php echo $inc['pt_manage_on_veti_data'];
                                                                        $pt_manage_on_veti_data = $pt_manage_on_veti_data + $inc['pt_manage_on_veti_data']; ?></td> 
                                                                        
                            <td id="lefttbltd" style="padding: 0px;"><?php echo $inc['pt_manage_on_veti_data_tm'] + $pt_manage_on_veti_data_today;
                                                                        $pt_manage_on_veti_data_tm = $pt_manage_on_veti_data_tm + $inc['pt_manage_on_veti_data_tm']; ?></td>
                            <td id="lefttbltd" style="padding: 0px;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $inc['pt_manage_on_veti_data_td'] + $pt_manage_on_veti_data_today;
                                                                        $pt_manage_on_veti_data_td = $pt_manage_on_veti_data_td + $inc['pt_manage_on_veti_data_td']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <!-- <td id="lefttbltd" style="padding: 0px;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "3811" ?>&nbsp;&nbsp;&nbsp;&nbsp;</td> -->

                        </tr>
                    </tbody>
            <?php }
            } ?>
            <tr>
                <th id="lefttbl" style="left:5px;"><b>Total</b></th>
                <th id="lefttbl"><b><?php echo $pt_manage_on_veti_data_today + $delivery_in_amb_data_today; ?></b></th>
                <?php $today_ct = $pt_manage_on_veti_data_today + $delivery_in_amb_data_today;?>
                <th id="lefttbl"><b><?php echo $delivery_in_amb_data + $pt_manage_on_veti_data; ?></b></th>
                <th id="lefttbl"><b><?php echo $today_ct+$delivery_in_amb_data_tm + $pt_manage_on_veti_data_tm; ?></b></th>
                <th id="lefttbl"><b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $today_ct+$delivery_in_amb_data_td + $pt_manage_on_veti_data_td; ?>&nbsp;&nbsp;&nbsp;&nbsp;</b></th>
            </tr> 
        </table>
    </div>
    <div>
        <label for="">&nbsp;</label>
    </div>
</div>

<script>
    // Chart.defaults.global.legend.display = false;
    var ctxP = document.getElementById("pieChart").getContext('2d');
    //alert();
    var myPieChart = new Chart(ctxP, {
        type: 'pie',
        data: {
            labels: ["Accident Vehicle", "Assault", "Burns", "Cardiac", "Fall", "Intoxication/Poisoning", "Labour/Pregnancy",
                "Lighting/Electrocution", "Mass Casualty", "Medical", "Poly Trauma", "Suicide/Self Inflicted Injury", "Others"
            ],
            datasets: [{
                data: [<?php echo $inc['Accident_data'];
                        $Accident_data = $Accident_data + $inc['Accident_data']; ?>,
                    <?php echo $inc['assault_data'];
                    $assault_data = $assault_data + $inc['assault_data']; ?>,
                    <?php echo $inc['burn_data'];
                    $burn_data = $burn_data + $inc['burn_data']; ?>,
                    <?php echo $inc['attack_data'];
                    $attack_data = $attack_data + $inc['attack_data']; ?>,
                    <?php echo $inc['fall_data'];
                    $fall_data = $fall_data + $inc['fall_data']; ?>,
                    <?php echo $inc['poision_data'];
                    $poision_data = $poision_data + $inc['poision_data']; ?>,
                    <?php echo $inc['labour_data'];
                    $labour_data = $labour_data + $inc['labour_data']; ?>,
                    <?php echo $inc['light_data'];
                    $light_data = $light_data + $inc['light_data']; ?>,
                    <?php echo $inc['mass_data'];
                    $mass_data = $mass_data + $inc['mass_data']; ?>,
                    <?php echo $inc['report_data'];
                    $report_data = $report_data + $inc['report_data']; ?>,
                    <?php echo $inc['trauma_data'];
                    $trauma_data = $trauma_data + $inc['trauma_data']; ?>,
                    <?php echo $inc['suicide_data'];
                    $suicide_data = $suicide_data + $inc['suicide_data']; ?>,
                    <?php echo $inc['other_data'];
                    $other_data = $other_data + $inc['other_data']; ?>

                ],
                backgroundColor: ["#AFC8C4", "#B19FF9", "#93A387", "#A9A9A9", "#7982B9", "#57167E", "#9B3192", "#AADEA7", "#E6F69D", "#FF6B45", "#FF2E7E", "#D52DB7", "#6050DC"],
                // hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5"]
            }]
        },
        options: {
            responsive: true,
            // labels: false
        }
    });
</script>
<script>
    // Chart.defaults.global.legend.display = false;
    var ctxP = document.getElementById("pieChart2").getContext('2d');
    var myPieChart = new Chart(ctxP, {
        type: 'pie',
        data: {
            labels: ["Accident Vehicle", "Assault", "Burns", "Cardiac", "Fall", "Intoxication/Poisoning", "Labour/Pregnancy",
                "Lighting/Electrocution", "Mass Casualty", "Medical", "Poly Trauma", "Suicide/Self Inflicted Injury", "Others"
            ],
            datasets: [{
                data: [<?php echo $inc['Accident_data_tm'];
                        $Accident_data_tm = $Accident_data_tm + $inc['Accident_data_tm']; ?>,
                    <?php echo $inc['assault_data_tm'];
                    $assault_data_tm = $assault_data_tm + $inc['assault_data_tm']; ?>,
                    <?php echo $inc['burn_data_tm'];
                    $burn_data_tm = $burn_data_tm + $inc['burn_data_tm']; ?>,
                    <?php echo $inc['attack_data_tm'];
                    $attack_data_tm = $attack_data_tm + $inc['attack_data_tm']; ?>,
                    <?php echo $inc['fall_data_tm'];
                    $fall_data_tm = $fall_data_tm + $inc['fall_data_tm']; ?>,
                    <?php echo $inc['poision_data_tm'];
                    $poision_data_tm = $poision_data_tm + $inc['poision_data_tm']; ?>,
                    <?php echo $inc['labour_data_tm'];
                    $labour_data_tm = $labour_data_tm + $inc['labour_data_tm']; ?>,
                    <?php echo $inc['light_data_tm'];
                    $light_data_tm = $light_data_tm + $inc['light_data_tm']; ?>,
                    <?php echo $inc['mass_data_tm'];
                    $mass_data_tm = $mass_data_tm + $inc['mass_data_tm']; ?>,
                    <?php echo $inc['report_data_tm'];
                    $report_data_tm = $report_data_tm + $inc['report_data_tm']; ?>,
                    <?php echo $inc['trauma_data_tm'];
                    $trauma_data_tm = $trauma_data_tm + $inc['trauma_data_tm']; ?>,
                    <?php echo $inc['suicide_data_tm'];
                    $suicide_data_tm = $suicide_data_tm + $inc['suicide_data_tm']; ?>,
                    <?php echo $inc['other_data_tm'];
                    $other_data_tm = $other_data_tm + $inc['other_data_tm']; ?>
                ],
                backgroundColor: ["#AFC8C4", "#B19FF9", "#93A387", "#A9A9A9", "#7982B9", "#57167E", "#9B3192", "#AADEA7", "#E6F69D", "#FF6B45", "#FF2E7E", "#D52DB7", "#6050DC"],
                // hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5"]
            }]
        },
        options: {
            responsive: true,
            // labels: false
        }
    });
</script>
<script>
    // Chart.defaults.global.legend.display = false;
    var ctxP = document.getElementById("pieChart3").getContext('2d');
    var myPieChart = new Chart(ctxP, {
        type: 'pie',
        data: {
            labels: ["Accident Vehicle", "Assault", "Burns", "Cardiac", "Fall", "Intoxication/Poisoning", "Labour/Pregnancy",
                "Lighting/Electrocution", "Mass Casualty", "Medical", "Poly Trauma", "Suicide/Self Inflicted Injury", "Others"
            ],
            datasets: [{
                data: [<?php echo $inc['Accident_data_td'];
                        $Accident_data_td = $Accident_data_td + $inc['Accident_data_td']; ?>,
                    <?php echo $inc['assault_data_td'];
                    $assault_data_td = $assault_data_td + $inc['assault_data_td']; ?>,
                    <?php echo $inc['burn_data_td'];
                    $burn_data_td = $burn_data_td + $inc['burn_data_td']; ?>,
                    <?php echo $inc['attack_data_td'];
                    $attack_data_td = $attack_data_td + $inc['attack_data_td']; ?>,
                    <?php echo $inc['fall_data_td'];
                    $fall_data_td = $fall_data_td + $inc['fall_data_td']; ?>,
                    <?php echo $inc['poision_data_td'];
                    $poision_data_td = $poision_data_td + $inc['poision_data_td']; ?>,
                    <?php echo $inc['labour_data_td'];
                    $labour_data_td = $labour_data_td + $inc['labour_data_td']; ?>,
                    <?php echo $inc['light_data_td'];
                    $light_data_td = $light_data_td + $inc['light_data_td']; ?>,
                    <?php echo $inc['mass_data_td'];
                    $mass_data_td = $mass_data_td + $inc['mass_data_td']; ?>,
                    <?php echo $inc['report_data_td'];
                    $report_data_td = $report_data_td + $inc['report_data_td']; ?>,
                    <?php echo $inc['trauma_data_td'];
                    $trauma_data_td = $trauma_data_td + $inc['trauma_data_td']; ?>,
                    <?php echo $inc['suicide_data_td'];
                    $suicide_data_td = $suicide_data_td + $inc['suicide_data_td']; ?>,
                    <?php echo $inc['other_data_td'];
                    $other_data_td = $other_data_td + $inc['other_data_td']; ?>
                ],
                backgroundColor: ["#AFC8C4", "#B19FF9", "#93A387", "#A9A9A9", "#7982B9", "#57167E", "#9B3192", "#AADEA7", "#E6F69D", "#FF6B45", "#FF2E7E", "#D52DB7", "#6050DC"],
                // hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5"]
            }]
        },
        options: {
            responsive: true,
            // labels: false
        }

    });
</script>

<style>
    
    .etwpsnb {
        color: red;
        padding-top: 20px;
        text-align: center;
        /* font-family: Lucida Grande, Lucida Sans, Arial, sans-serif; */
        font-weight: bold;
    }

    .desctbl {
        padding-left: 20px;
        padding-top: 5px;
    }

    .left-half{
        width: 50%;
        float: left;
        padding-top: 20px;
    }
    .right-half {
        width: 50%;
        float: left;
    }

    #pie {
        padding-top: 10px;
        text-align: center;
        display: none;
    }

    #pie2 {
        padding-top: 10px;
        text-align: center;
        display: none;
    }

    #pie3 {
        padding-top: 10px;
        text-align: center !important;
        /* display: none; */
    }

    .btn-outline-primary {
        color: grey;
        width: 20%;
        border: 1px solid grey;
        font-size: 10px;
    }

    #ETWPS {
        color: black;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        /* font-family: Lucida Grande, Lucida Sans, Arial, sans-serif !important ; */
    }

    #lefttbl {
        font-size: 2opx;
        padding: 5px;
    }

    #lefttbltdh {
        text-align: left !important ;
        font-size: 20px !important;
        padding: 0px !important;
    }

    #lefttbltdh {
        text-align: left !important;
        font-size: 20px !important;
        padding: 0px !important ;
    }

    .NHM_Dashboard td,
    .B12_report_dash td {
        padding: 0px;
    }

    #righttblh {
        text-align: left !important;
        padding: 0px !important;
    }

    #righttbl {
        padding: 0px!important ;
    }
    .btn-outline-primary {
        color: grey;
        width: 20%;
        border: 1px solid grey;
        font-size: 10px;
    }

    #rttblmain {
        padding: 11px !important;
        font-size: 22px !important;
    }
    
    #rttblmain1 {
        padding: 11px !important;
        font-size: 22px !important;
        width: 50% !important;
    }
    #rttblmain2 {
        
        font-size: 22px !important;
        padding: 10px 0px 10px 0px !important;
    }
    #rttblmain3 {
        padding: 11px !important;
        font-size: 22px !important;
        width: 20% !important;
        padding: 10px 30px !important;
    }
    #rttblmain4 {
        padding: 11px !important;
        font-size: 22px !important;
        width: 20% !important;

    }
    #frmbtm {
        color: grey;
        border: 1px solid grey;
    }
    
    .button_print2 {

border: none;
color: white;
padding: 5px 10px 5px 10px;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 15px;
margin: 1px 1px;
cursor: pointer;
background-color: #085B80 !important;

}
</style>

<script>
    function funto() {
        document.getElementById('pie').style.display = 'block';
        document.getElementById('pie2').style.display = 'none';
        document.getElementById('pie3').style.display = 'none';

    }

    function funto2() {
        document.getElementById('pie2').style.display = 'block';
        document.getElementById('pie3').style.display = 'none';
        document.getElementById('pie').style.display = 'none';
    }

    function funto3() {
        document.getElementById('pie3').style.display = 'block';
        document.getElementById('pie2').style.display = 'none';
        document.getElementById('pie').style.display = 'none';
    }
</script>
</div>