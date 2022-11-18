
<!--PAGE CONTENT-->
<?php //foreach ($data['district_names'] as $result):
//108
// $tempsub= districtwise_emergency_patients($result->dst_code, 'tillDate', '108');

// $temp_td_1 = $temp_td_1+$tempsub;


// $tempsub= districtwise_emergency_patients($result->dst_code, 'thismonth', '108');

// $temp_tm_1 = $temp_tm_1+$tempsub;


// $tempsub= districtwise_dispatches($result->dst_code, 'today', '108');

// $temp_to_1 = $temp_to_1+$tempsub;
//102

// $cntsub= districtwise_dispatches($result->dst_code, 'tillDate', '102');

// $cnt_td_1 = $cnt_td_1+$cntsub;


// $cntsub= districtwise_dispatches($result->dst_code, 'thismonth', '102');

// $cnt_tm_1 = $cnt_tm_1+$cntsub;


// $cntsub= districtwise_dispatches($result->dst_code, 'today', '102');

// $cnt_to_1 = $cnt_to_1+$cntsub;

// $srno++; endforeach; ?>
<div class="page-content--bgf7" >
    <div class="container-fluid" style="margin-bottom:4.5%;">
        <div class="row text-center">
            <div class="col-md-6">

                <div class="col-md-12 my-1 ">

                    <table class="table table-sm table-dark table-bordered nhm_table cus">

                        <thead class="thead-dark" >
                        <tr>

                        <th colspan="4">MHEms 108 Seva</th>

                        </tr>

                        <tr>

                            <th style="width: 21%" scope="col">Districts</th>

                            <th style="width: 19%" scope="col">Dispatch Today</th>

                            <th style="width: 19%" scope="col">Patients Served This Month</th>

                            <th style="width: 19%" scope="col">Patients Served Till date</th>


                        </tr>
                            <?php foreach ($data['district_names'] as $result): ?>

                            <tr>

                            <td style="width:21%"><?php echo $result->dst_name ?></td>

                            <td id="<?php echo trim($result->dst_name) ?>"><?php //echo districtwise_dispatches($result->dst_code, 'today', '108') ?></td>

                            <td id= "<?php echo 'distmpt'. trim($result->dst_name) ?>"><?php //echo districtwise_emergency_patients($result->dst_code, 'thismonth', '108') ?></td>

                            <td id= "<?php echo 'distdpt'. trim($result->dst_name) ?>"><?php //echo districtwise_emergency_patients($result->dst_code, 'tillDate', '108') ?></td>

                            </tr>

                            <?php endforeach; ?>
                        <tr>
                        <td style="width:21%">Total</td>

                        <td id="to108"><?php //echo $temp_to_1 ?></td>

                        <td id="tm108"><?php //echo $temp_tm_1 ?></td>

                        <td id="td108"><?php //echo $temp_td_1 ?></td>
                        </tr>
                        </thead>

                    </table>

                </div>

            </div>
            <div class="col-md-6">        
            <div class="col-md-12 my-1 ">

                <table class="table table-sm table-dark table-bordered nhm_table cus">

                    <thead class="thead-dark" >
                    <tr>

                    <th colspan="4">MHEms 102 Janani Shishu Seva</th>

                    </tr>

                    <tr>

                        <th style="width: 21%" scope="col">Districts</th>

                        <th style="width: 19%" scope="col">Dispatch Today</th>

                        <th style="width: 19%" scope="col">Dispatch This Month</th>

                        <th style="width: 19%" scope="col">Dispatch Till date</th>

                    </tr>
                        <?php foreach ($data['district_names'] as $result): ?>

                        <tr>

                        <td style="width:21%"><?php echo trim($result->dst_name) ?></td>

                        <td id= "<?php echo '102'. trim($result->dst_name) ?>"><?php //echo districtwise_dispatches($result->dst_code, 'today', '102') ?></td>

                        <td id= "<?php echo 'distm'. trim($result->dst_name) ?>"><?php //echo districtwise_dispatches($result->dst_code, 'thismonth', '102') ?></td>

                        <td id= "<?php echo 'distd'. trim($result->dst_name) ?>"><?php //echo districtwise_dispatches($result->dst_code, 'tillDate', '102') ?></td>

                        </tr>

                        <?php endforeach; ?>
                        <tr>
                       
                        <td style="width:21%">Total</td>

                        <td id="to102"><?php //echo $temp_to_1 ?></td>

                        <td id="tm102"><?php //echo $temp_tm_1 ?></td>

                        <td id="td102"><?php //echo $temp_td_1 ?></td>
                        </tr>
                    </thead>

                </table>

                </div>
            </div>          
        </div>             
    </div>              
</div> 
                        </div></div></div>

<!-- round circle icons end -->
<script type="text/javascript">
$(document).ready(function() {
window.onload=ajaxcall_nhm();
setInterval("ajaxcall_nhm()",1800000);
});
</script>
