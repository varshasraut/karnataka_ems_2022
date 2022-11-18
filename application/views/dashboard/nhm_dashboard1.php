
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
<div class="container-fluid" style="margin-bottom:2.0%;">
    <div class="row text-center">
    <div class="col-md-6 remove_padding_md6">
     
        
        <table class="table table-sm table-dark table-bordered nhm_table cus " >
            
                <thead class="" >
                <tr>                    <th colspan="4">MHEMS 108 Seva</th>
                </tr>
                        
                <tr id="108">
                            
                            <th style="width: 20%" scope="col">Districts</th>
                            
                        <th style="width: 22%" scope="col">Dispatch Today</th>
                            
                            <th style="width: 20%" scope="col">Patients Served This Month</th>
                            
                            <th style="width: 21%" scope="col">Patients Served Till date</th>
                            
                            
                        </tr>
                    </thead>
                </table>
                <table class="table table-sm table-dark table-bordered nhm_table cus " id="nhm108">
                    <thead>
                        <tr></tr>
                        <?php //foreach ($data['nhm'] as $result): ?>
                            
                            <!-- <tr>
                                
                                <td style="width:21%"><?php //echo $result->dst_code ?></td>
                                
                                <td id=""><?php //echo ($result->dispatch_today_108) ?></td>
                                
                                <td id= ""><?php //echo ($result->patient_served_tm) ?></td>
                                
                                <td id= ""><?php //echo ($result->patient_served_td) ?></td>
                                
                            </tr> -->
                            
                            <?php //endforeach; ?>
                            <!-- <tr>
                                <td style="width:21%">Total</td>
                                
                                <td id="to108"><?php //echo $temp_to_1 ?></td>
                                
                                <td id="tm108"><?php //echo $temp_tm_1 ?></td>
                                
                                <td id="td108"><?php //echo $temp_td_1 ?></td>
                            </tr> -->
                        </thead>
                        
                    </table>
                    
                    
                    
                </div>
                <div class="col-md-6 remove_padding_md6 ">        
                    
                    
                    <table class="table table-sm table-dark table-bordered nhm_table cus " id="">
                        
                        <thead class="" >
                            <tr>
                                
                                <th colspan="4">MHEMS 102 Janani Shishu Seva</th>
                                    
                                </tr>
                                
                                <tr id="102">
                                        
                            <th style="width: 20%" scope="col">Districts</th>
                            
                            <th style="width: 19%" scope="col">Dispatch Today</th>
                            
                            <th style="width: 19%" scope="col">Dispatch This Month</th>
                            
                            
                            <th style="width: 19%" scope="col">Dispatch Till date</th>
                            
                        </tr>
                    </thead>
                </table>
                <table class="table table-sm table-dark table-bordered nhm_table cus1 " id="nhm102">
                    <thead>
                        <tr></tr>
                        <?php// foreach ($data['nhm'] as $result): ?>
                            
                            <!-- <tr>
                                
                                <td style="width:21%"><?php //echo trim($result->dst_code) ?></td>
                                
                                <td id= ""><?php //echo ($result->dispatch_today_102) ?></td>
                                
                                <td id= ""><?php //echo ($result->dispatch_tm) ?></td>
                                
                                <td id= ""><?php //echo ($result->dispatch_td) ?></td>
                                
                            </tr> -->
                            
                            <?php// endforeach; ?>
                            <!-- <tr>
                                
                                <td style="width:21%">Total</td>
                                
                                <td id="to102"><?php //echo $temp_to_1 ?></td>
                                
                                <td id="tm102"><?php //echo $temp_tm_1 ?></td>
                                
                                <td id="td102"><?php //echo $temp_td_1 ?></td>
                    </tr> -->
                </thead>
                
            </table>
            
            
        </div>  
        <div class="col-md-6 remove_padding_md6">        
            
            <iframe id="map" src="<?php echo base_url();?>amb/nhm_all" style="width:100%; height: 220px; border-style: solid;">
            </iframe>      
            
        </div>
        <div class="col-md-6 remove_padding_md6" >        
            
            
            <iframe id="B12data" src="<?php echo base_url();?>amb/B12_data" style="width:100%; height: 120%; border:0px;">
            </iframe>  
            
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
     //setInterval("ajaxcall_nhm()",1808);
    });
</script>

