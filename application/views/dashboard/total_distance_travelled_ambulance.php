<!--PAGE CONTENT-->
<div class="page-content--bgf7 pb-5">
     <!-- round cirlcle icons start -->
     <!-- STATISTIC-->
    <div class="container-fluid">
        <section class="statistic statistic2">
            <div class="row text-center">
              <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">  
                <h3>TOTAL DISTANCE TRAVELLED BY AMBULANCE</h3>
              </div>
            </div>
            
            <div class="row pb-5" >
                <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1 mt-4 pt-1">
                    <table class="table table-sm table-dark table-bordered">
                        <thead class="thead-dark">
                          <tr>
                            <th style="width: 20%" rowspan="2" scope="col">Districts</th>
                            <th style="width: 30%;text-align: center;" colspan="3" scope="col">No of Ambulances Deployed</th>
                            <th style="width: 10%" rowspan="2" scope="col">No of Ambulance<br>On-Road</th>
                            <th style="width: 10%" rowspan="2" scope="col">No of Ambulance<br>Off-Road(Last 24 Hrs)</th>
                            <th style="width: 30%;text-align: center;" colspan="3" scope="col">No of Km</th>
                          </tr>
                          <tr>
                
                            <th style="width: 10%" scope="col">ALS</th>
                            <th style="width: 10%" scope="col">BLS</th>
                            <th style="width: 10%" scope="col">PTA</th>
                            <th style="width: 10%" scope="col">15 Days</th>
                            <th style="width: 10%" scope="col">This Month</th> 
                            <th style="width: 10%" scope="col">Till Date</th>
                          </tr>
                        </thead>
                    </table>
                    <div id="accordion">
                        <div class="card">
                            <!-- <a class="card-link" data-toggle="collapse" href="#collapseOne"> -->
                                <div class="card-header">
                                    <table class="table table-sm table-dark table-bordered cus">
                                      <thead class="thead-dark" >
                                        <?php foreach ($data['district_names'] as $result): ?>
                                        <tr>
                                        <td  style="width: 20%"><?php echo $result->dst_name ?></td>
                                        <td style="width: 10%"><?php echo districtwise_ambulance_count($result->dst_code, 'ALS') ?></td>
                                        <td style="width: 10%"><?php echo districtwise_ambulance_count($result->dst_code, 'BLS') ?></td>
                                        <td style="width: 10%"><?php echo districtwise_ambulance_count($result->dst_code, 'PTA') ?></td>
                                        <td style="width: 10%"><?php echo districtwise_ambulance_onoff_road($result->dst_code, 'onroad') ?></td>
                                        <td style="width: 10%"><?php echo districtwise_ambulance_onoff_road($result->dst_code, 'offroad') ?></td>
                                        <td style="width: 10%"><?php echo districtwise_ambulance_km($result->dst_code, '15days') ?></td>
                                        <td style="width: 10%"><?php echo districtwise_ambulance_km($result->dst_code, 'thismonth') ?></td>
                                        <td style="width: 10%"><?php echo districtwise_ambulance_km($result->dst_code, 'tillDate') ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                      </thead>
                                    </table>
                                </div>
                            <!-- </a> -->
                        </div>
                    </div><!--Accordian End div -->
                </div><!--Col md-10 End div -->
            </div><!--Row End div -->
        </section>
    </div>
</div>