 <div class="field_row width100">
<!--        <h3>Response Time  Dashboard</h3><br>       -->
                <table class="table table-bordered NHM_Dashboard ">

                    <tr>                
                        <th style="width: 50px;">Incident ID</th>
                        <th style="width: 50px;">District</th>
                        <th style="width: 50px;">Ambulance No</th>
                        <th style="width: 40px;">Incident Date</th>
                        <th style="width: 50px;">Type of Emergency</th>
                        <th style="width: 40px;">Ambulance Assign Time</th>
<!--                        <th>Ambulance Start from Base</th>-->
                        <th style="width: 50px;">Ambulance Reach at Scene</th> 
                        <th style="width: 50px;">Area</th> 
                        <th nowrap>Remarks</th> 
                    </tr>
                    <?php if($rtd_data){
                        foreach($rtd_data as $rtd){ //var_dump($rtd); ?>
                      <tr>
                        <td style="width: 50px;"><?php echo $rtd["inc_ref_id"];?></td>   
                        <td style="width: 50px;"><?php echo $rtd["district"];?></td>
                        <td style="width: 50px;"><?php echo $rtd["ambulance_no"];?></td>
                        <td style="width: 40px;"><?php echo $rtd["res_date"] ;?></td>   
                        <td style="width: 50px;"><?php echo $rtd["type_inc"] ;?></td>    
<!--                        <td>2020-07-30 12:25:09</td> -->
                        <td style="width: 40px;"><?php echo $rtd["assign_time"] ;?></td> 
                        <td style="width: 50px;"><?php echo $rtd["ambulance_reach_at_scane"] ;?></td> 
                        <td style="width: 50px;"><?php echo $rtd["area"];?></td>
                        <td style="text-align: left; padding-left: 5px;"><?php echo $rtd["remark"] ;?></td> 
                    </tr>
                            
                    <?php    }
                    } ?>
                  
                    
                 </table>
<br><br>
            </div>