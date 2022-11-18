<div class="page-content--bgf7 pb-5">
     <!-- round cirlcle icons start -->
     <!-- STATISTIC-->
    <div class="container-fluid">
        <section class="statistic statistic2">
            <div class="row text-center">
              <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">  
                <h3>RESPONSE TIME OF AMBULANCE</h3>
              </div>
            </div>
            
            <div class="row pb-5" >
                <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1 mt-4 pt-1">
                	<table class="table table-sm table-bordered">
                        <thead class="text-center">
                          
                          <tr><th style="background: lightblue;" colspan="5">Basic Life Support (BLS)</th></tr>
                          <tr>
                            <th class="dif" scope="col">MEMS</th>
                            <td scope="col"><?php echo date('Y').'-'.date('y', strtotime('+1 year')); ?></td>
                          </tr>
                          <tr>
                            <th class="dif" scope="col">No. of Ambulances Operational under dial 108</th>
                            <td scope="col"><?php echo amb_resp_time_onroad('3')  ?></td>
                          </tr>
                          <tr>
                            <th scope="col">Average Response Time - Urban</th>
                            <td></td>
                          </tr>
                          <tr>
                            <th class="dif" scope="col">Call To Scene Time(Min.Sec)</th>
                            <td scope="col"><?php echo call_to_scene_time(3,2) ?></td>
                          </tr>
                          <tr>
                            <th class="dif" scope="col">Call To Hospital Time(Min.Sec)</th>
                            <td scope="col"><?php echo call_to_hosp_time(3,2) ?></td>
                          </tr>
                          <tr>
                            <th scope="col">Average Response Time - Rural</th>
                            <td></td>
                          </tr>
                          <tr>
                            <th class="dif" scope="col">Call To Scene Time(Min.Sec)</th>
                            <td scope="col"><?php echo call_to_scene_time(3,1) ?></td>
                          </tr>
                          <tr>
                            <th class="dif" scope="col">Call To Hospital Time(Min.Sec)</th>
                            <td scope="col"><?php echo call_to_hosp_time(3,1) ?></td>
                          </tr>
                          <tr><th class="dif" scope="col">Percentage of calls denied due to shortage/unavaibility of Ambulances</th>
                          	<td scope="col"><?php echo amb_unavailability_percentage(3). ' %' ?></td></tr>
                          
                          <tr><th style="background: lightblue;" colspan="5">Advanced Life Support (ALS)</th></tr>
                          <tr>
                            <th class="dif" scope="col">MEMS</th>
                            <td scope="col"><?php echo date('Y').'-'.date('y', strtotime('+1 year')); ?></td>
                          </tr>
                          <tr>
                            <th class="dif" scope="col">No. of Ambulances Operational under dial 108</th>
                            <td scope="col"><?php echo amb_resp_time_onroad('4') ?></td>
                          </tr>
                          <tr>
                            <th scope="col">Average Response Time - Urban</th>
                            <td></td>
                          </tr>
                          <tr>
                            <th class="dif" scope="col">Call To Scene Time(Min.Sec)</th>
                            <td scope="col"><?php echo call_to_scene_time(4,2) ?></td>
                          </tr>
                          <tr>
                            <th class="dif" scope="col">Call To Hospital Time(Min.Sec)</th>
                            <td scope="col"><?php echo call_to_hosp_time(4,2) ?></td>
                          </tr>
                          <tr>
                            <th scope="col">Average Response Time - Rural</th>
                            <td></td>
                          </tr>
                          <tr>
                            <th class="dif" scope="col">Call To Scene Time(Min.Sec)</th>
                            <td scope="col"><?php echo call_to_scene_time(4,1) ?></td>
                          </tr>
                          <tr>
                            <th class="dif" scope="col">Call To Hospital Time(Min.Sec)</th>
                            <td scope="col"><?php echo call_to_hosp_time(4,1) ?></td>
                          </tr>
                          <tr><th class="dif" scope="col">Percentage of calls denied due to shortage/unavaibility of Ambulances</th>
                          	<td scope="col"><?php echo amb_unavailability_percentage(4). ' %' ?></td></tr>
                        </thead>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>