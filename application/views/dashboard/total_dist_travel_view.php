<!--PAGE CONTENT-->

<div class="page-content--bgf7 pb-5">

     <!-- round cirlcle icons start -->

     <!-- STATISTIC-->

    <div class="container-fluid">

        <section class="">

            <div class="row text-center">

              <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">  

                <h3>TOTAL DISTANCE TRAVELLED BY AMBULANCE</h3>

              </div>

            </div>

            

            <div class="row " >

                <div class="col-md-6  col-lg-6  mt-4 pt-1">

                    <table class="table table-sm  table-dark table-bordered">

                        <thead class="">

                          <tr style="background-color:#1ABC9C">
                          <th style="width: 16%;text-align:center" colspan="5" >MHEMS 108 Seva</th>
                          </tr>
                          <tr style="background-color:#1ABC9C">

                            <th style="width: 16%" rowspan="2" scope="col">Districts</th>

                            <th style="width: 20%;text-align: center;" colspan="2" scope="col">No of Ambulances Deployed</th>

                            <!-- <th style="width: 10%" rowspan="2" scope="col">No of Ambulance<br>On-Road</th>

                            <th style="width: 10%" rowspan="2" scope="col">No of Ambulance<br>Off-Road(Last 24 Hrs)</th> -->

                            <th style="width: 25%;text-align: center;" colspan="3" scope="col">No of Km</th>

                          </tr>

                          <tr style="background-color:#1ABC9C">

                

                            <th style="width: 8%" scope="col">ALS</th>

                            <th style="width: 8%" scope="col">BLS</th>

                            <!-- <th style="width: 10%" scope="col">PTA</th> -->

                            <!-- <th style="width: 10%" scope="col">15 Days</th> -->

                            <th style="width: 9%" scope="col">This Month</th> 

                            <th style="width: 12%" scope="col">Till Date</th>

                          </tr>

                        </thead>

                    </table>

                    <div id="accordion">

                        <div class="card">

                            <!-- <a class="card-link" data-toggle="collapse" href="#collapseOne"> -->

                                <div class="card-header">

                                    <table class="table table-sm table-dark table-bordered cus1">

                                      <thead class="thead-dark" >

                                        <?php foreach ($data['district_names'] as $result): ?>

                                        <tr style="color: #212529">

                                        <td  style="width: 20%"><?php echo $result->dst_name ?></td>

                                        <td style="width: 10%"><?php echo districtwise_ambulance_count($result->dst_code, 'ALS') ?></td>

                                        <td style="width: 10%"><?php echo districtwise_ambulance_count($result->dst_code, 'BLS') ?></td>

                                        <!-- <td style="width: 10%"><?php //echo districtwise_ambulance_count($result->dst_code, 'PTA') ?></td> -->

                                        <!-- <td style="width: 10%"><?php// echo districtwise_ambulance_onoff_road($result->dst_code, 'onroad') ?></td> -->

                                        <!-- <td style="width: 10%"><?php //echo districtwise_ambulance_onoff_road($result->dst_code, 'offroad') ?></td> -->

                                        <!-- <td style="width: 10%"><?php //echo districtwise_ambulance_km($result->dst_code, '15days') ?></td> -->

                                        <td style="width: 10%"><?php  echo districtwise_ambulance_108_km($result->dst_code, 'thismonth') ?></td>

                                        <td style="width: 9%"><?php echo districtwise_ambulance_108_km($result->dst_code, 'tillDate') ?></td>

                                        </tr>

                                        <?php endforeach; ?>

                                      </thead>

                                    </table>

                                </div>

                            <!-- </a> -->

                        </div>

                    </div><!--Accordian End div -->

                </div><!--Col md-10 End div -->

            

                <div class="col-md-6  col-lg-6  mt-4 pt-1">

                    <table class="table table-sm  table-dark table-bordered ">

                        <thead class="">
                        <tr style="background-color:#1ABC9C">
                          <th style="width: 16%;text-align:center" colspan="5" >MHEMS 102 Janani Shishu Seva</th>
                          </tr>
                          <tr style="background-color:#1ABC9C">

                            <th style="width: 14%" rowspan="2" scope="col">Districts</th>

                            <th style="width: 15%;text-align: center;" colspan="1" scope="col">No of Ambulances Deployed</th>

                            <!-- <th style="width: 10%" rowspan="2" scope="col">No of Ambulance<br>On-Road</th> -->

                            <!-- <th style="width: 10%" rowspan="2" scope="col">No of Ambulance<br>Off-Road(Last 24 Hrs)</th> -->

                            <th style="width: 30%;text-align: center;" colspan="2" scope="col">No of Km</th>

                          </tr>

                          <tr style="background-color:#1ABC9C">

                

                            <!-- <th style="width: 10%" scope="col">ALS</th> -->

                            <!-- <th style="width: 10%" scope="col">BLS</th> -->

                            <th style="width: 5%" scope="col">PTA</th>

                            <!-- <th style="width: 10%" scope="col">15 Days</th> -->

                            <th style="width: 10%" scope="col">This Month</th> 

                            <th style="width: 12%" scope="col">Till Date</th>

                          </tr>

                        </thead>

                    </table>

                    <div id="accordion">

                        <div class="card">

                            <!-- <a class="card-link" data-toggle="collapse" href="#collapseOne"> -->

                                <div class="card-header">

                                    <table class="table table-sm table-dark table-bordered cus1 ">

                                      <thead class="thead-dark" >

                                        <?php foreach ($data['district_names'] as $result): ?>

                                        <tr style="color: #212529">

                                        <td  style="width: 16%"><?php echo $result->dst_name ?></td>

                                        <!-- <td style="width: 10%"><?php echo districtwise_ambulance_count($result->dst_code, 'ALS') ?></td> -->

                                        <!-- <td style="width: 10%"><?php echo districtwise_ambulance_count($result->dst_code, 'BLS') ?></td> -->

                                        <td style="width: 18%"><?php echo districtwise_ambulance_count($result->dst_code, 'PTA') ?></td>

                                        <!-- <td style="width: 10%"><?php echo districtwise_ambulance_onoff_road($result->dst_code, 'onroad') ?></td> -->

                                        <!-- <td style="width: 10%"><?php echo districtwise_ambulance_onoff_road($result->dst_code, 'offroad') ?></td> -->

                                        <!-- <td style="width: 10%"><?php echo districtwise_ambulance_km($result->dst_code, '15days') ?></td> -->

                                        <td style="width: 12%"><?php  echo districtwise_ambulance_102_km($result->dst_code, 'thismonth') ?></td>

                                        <td style="width: 14%"><?php echo districtwise_ambulance_102_km($result->dst_code, 'tillDate') ?></td>

                                        </tr>

                                        <?php endforeach; ?>

                                      </thead>

                                    </table>

                                </div>

                            <!-- </a> -->

                        

                    </div><!--Accordian End div -->

                </div>
</div>
            <!--Row End div -->
           
        </section>

    </div>

</div>