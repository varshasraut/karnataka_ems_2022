<!--PAGE CONTENT-->

<div class="page-content--bgf7 pb-5">

     <!-- round cirlcle icons start -->

     <!-- STATISTIC-->

    <div class="container-fluid">

        <section class="statistic statistic2">

            <div class="row text-center">

              <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">  

                <h3>DISTRICTWISE EMERGENCY PATIENTS SERVED</h3>

              </div>

            </div>

            

            <div class="row pb-5" >

                <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1 mt-4 pt-1">

                    <table class="table table-sm table-dark table-bordered">

                        <thead class="thead-dark">

                          <tr>

                            <th style="width: 50%" scope="col">Districts</th>

                            <th style="width: 16.7%" scope="col">Till date</th>

                            <th style="width: 16.7%" scope="col">This Month</th>

                            <th style="width: 19%" scope="col">Today</th>

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

                                        <td style="width:48%"><?php echo $result->dst_name ?></td>

                                        <td><?php echo districtwise_emergency_patients($result->dst_code, 'tillDate', "both") ?></td>

                                        <td><?php echo districtwise_emergency_patients($result->dst_code, 'thismonth', "both") ?></td>

                                        <td><?php echo districtwise_emergency_patients($result->dst_code, 'today', "both") ?></td>

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