

<!--PAGE CONTENT-->

        <div class="page-content--bgf7">

             <!-- round cirlcle icons start -->

             <!-- STATISTIC-->

             <div class="container-fluid">

                <section class="statistic statistic2 mb-5">

                    <div class="row text-center">

                      <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">  

                            <h3>TYPES OF EMERGENCY PATIENTS SERVED</h3>

                      </div>

                    </div>

                    <!-- <div class="container"> -->

                        <div class="row mb-5 pb-5" >

                            

                          <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1 mt-4 pt-1">

                            <table class="table table-sm table-dark table-bordered">

                                <thead class="thead-dark">

                                  <tr>

                                    <th style="width: 50%" scope="col">Types of Emergency</th>

                                    <th style="width: 16.5%" scope="col">Till date</th>

                                    <th style="width: 16.2%" scope="col">This Month</th>

                                    <th style="width: 19%" scope="col">Today</th>

                                  </tr>

                                </thead>

                            </table>

                                <div id="accordion">

                                    <div class="card">

                                    <a class="card-link" data-toggle="collapse" href="#collapseOne">

                                      <div class="card-header">

                                        <table class="table table-sm table-dark table-bordered cus">

                                                                  <thead class="thead-dark" >

                                                                    <?php foreach ($data['accident_names'] as $result):

                                                                    $cntsub= accident_motorcycle($result->ct_id, 'tillDate');

                                                                    $cnt_td_1 = $cnt_td_1+$cntsub;

                                                                    //echo $cnt_td_1;

                                                                    $cntsub= accident_motorcycle($result->ct_id, 'thismonth');

                                                                    $cnt_tm_1 = $cnt_tm_1+$cntsub;

                                                                    //echo $cnt_tm_1;

                                                                    $cntsub= accident_motorcycle($result->ct_id, 'today');

                                                                    $cnt_to_1 = $cnt_to_1+$cntsub;

                                                                    //echo $cnt_to_1;

                                                                    $srno++; endforeach; ?>

                                                                    <tr>

                                                                      <td style="width: 50%;" scope="col">Accident</td>

                                                                      <td scope="col" style="width: 18%;"><?php echo $cnt_td_1;?></td>

                                                                      <td scope="col" style="width: 18%;"><?php echo $cnt_tm_1;?></td>

                                                                      <td scope="col" style="width: 18%;"><?php echo $cnt_to_1;?></td>

                                                                      </tr>

                                                                  </thead>

                                                                  </table>

                                      </div>

                                        </a>

                                      <div id="collapseOne" class="collapse" data-parent="#accordion">

                                        <div class="card-body">

                                         <table class="table table-sm table-hover table-bordered">

                                                                  

                                                                  <tbody>

                                                                   <?php $srno = 1;  ?>

                                                                  <?php foreach ($data['accident_names'] as $result): ?>

                                                                        <tr>

                                                                            <td style="width: 3%"><?php echo $srno ?></td>

                                                                      <td  style="width: 47%"><?php echo $result->ct_type ?></td>

                                                                      <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'tillDate'); ?></td>

                                                                      <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'thismonth'); ?></td>

                                                                      <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'today'); ?></td>

                                                                    </tr>

                                                                    <?php $srno++;  endforeach; ?>

                                                                    

                                                                  </tbody>

                                          </table>

                                        </div>

                                      </div>

                                    </div>

    

                <div class="card">

                    <a class="card-link" data-toggle="collapse" href="#collapseTwo">

                      <div class="card-header">

                        <table class="table table-sm table-dark table-bordered cus">

                          <thead class="thead-dark">

                            <?php foreach ($data['attack'] as $result):

                            $cntsub= accident_motorcycle($result->ct_id, 'tillDate');

                            $cnt_td_2 = $cnt_td_2+$cntsub;

                            $cntsub= accident_motorcycle($result->ct_id, 'thismonth');

                            $cnt_tm_2 = $cnt_tm_2+$cntsub;

                            $cntsub= accident_motorcycle($result->ct_id, 'today');

                            $cnt_to_2 = $cnt_to_2+$cntsub;

                             endforeach; ?>

                            <tr>

                              <td style="width: 50%;" scope="col">Attack/Assault</td>

                              <td scope="col" style="width: 18%;"><?php echo $cnt_td_2;?></td>

                              <td scope="col" style="width: 18%;"><?php echo $cnt_tm_2;?></td>

                              <td scope="col" style="width: 18%;"><?php echo $cnt_to_2;?></td>

                              </tr>

                            

                          </thead>

                        </table>

                      </div>

                    </a>

                    <div id="collapseTwo" class="collapse" data-parent="#accordion">

                      <div class="card-body">

                       <table class="table table-sm table-hover table-bordered">

                                                                  

                        <tbody>

                        <?php $srno = 1; ?>

                        <?php foreach ($data['attack'] as $result): ?>

                              <tr>

                                  <td style="width: 3%"><?php echo $srno ?></td>

                            <td  style="width: 47%"><?php echo $result->ct_type; ?></td>

                            <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'tillDate');  ?></td>

                            <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'thismonth'); ?></td>

                            <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'today'); ?></td>

                          </tr>

                          <?php $srno++; endforeach; ?>

                        </tbody>

                      </table>

                    </div>

                  </div>

              </div>

    

          <div class="card">

            <a class="card-link" data-toggle="collapse" href="#collapseThree">

              <div class="card-header">

                <table class="table table-sm table-dark table-bordered cus">

                    <thead class="thead-dark">

                       <?php foreach ($data['burn'] as $result):

                      $cntsub= accident_motorcycle($result->ct_id, 'tillDate');

                      $cnt_td_3 = $cnt_td_3+$cntsub;                   

                      $cntsub= accident_motorcycle($result->ct_id, 'thismonth');

                      $cnt_tm_3 = $cnt_tm_3+$cntsub;

                      $cntsub= accident_motorcycle($result->ct_id, 'today');

                      $cnt_to_3 = $cnt_to_3+$cntsub;

                       endforeach; ?>

                      <tr>

                        <td style="width: 50%;" scope="col">Burns</td>

                        <td scope="col" style="width: 18%;"><?php echo $cnt_td_3;?></td>

                        <td scope="col" style="width: 18%;"><?php echo $cnt_tm_3;?></td>

                        <td scope="col" style="width: 18%;"><?php echo $cnt_to_3;?></td>

                        </tr>

                    </thead>

                </table>

              </div>

            </a>

          <div id="collapseThree" class="collapse" data-parent="#accordion">

            <div class="card-body">

             <table class="table table-sm table-hover table-bordered">

                                                                  

                <tbody>

               <?php $srno = 1; ?>

                <?php foreach ($data['burn'] as $result): ?>

                      <tr>

                          <td style="width: 3%"><?php echo $srno ?></td>

                    <td  style="width: 47%"><?php echo $result->ct_type ?></td>

                    <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'tillDate'); ?></td>

                    <td id="" style="width: 18%;"><?php  echo accident_motorcycle($result->ct_id, 'thismonth'); ?></td>

                    <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'today'); ?></td>

                  </tr>

                  <?php $srno++; endforeach; ?>

                </tbody>

            </table>

          </div>

        </div>

      </div>

    

      <div class="card">

          <a class="card-link" data-toggle="collapse" href="#collapseFour">

            <div class="card-header">

              <table class="table table-sm table-dark table-bordered cus">

                <thead class="thead-dark">

                  <?php foreach ($data['cardiac'] as $result):

                  $cntsub= accident_motorcycle($result->ct_id, 'tillDate');

                  $cnt_td_4 = $cnt_td_4+$cntsub;                   

                  $cntsub= accident_motorcycle($result->ct_id, 'thismonth');

                  $cnt_tm_4 = $cnt_tm_4+$cntsub;

                  $cntsub= accident_motorcycle($result->ct_id, 'today');

                  $cnt_to_4 = $cnt_to_4+$cntsub;

                 endforeach; ?>

                  <tr>

                    <td style="width: 50%;" scope="col">Cardiac</td>

                    <td scope="col" style="width: 18%;"><?php echo $cnt_td_4;?></td>

                    <td scope="col" style="width: 18%;"><?php echo $cnt_tm_4;?></td>

                    <td scope="col" style="width: 18%;"><?php echo $cnt_to_4;?></td>

                    </tr>

                </thead>

              </table>

            </div>

          </a>

    <div id="collapseFour" class="collapse" data-parent="#accordion">

      <div class="card-body">

       <table class="table table-sm table-hover table-bordered">

                                                                  

          <tbody>

          <?php $srno = 1; ?>

          <?php foreach ($data['cardiac'] as $result): ?>

                <tr>

                    <td style="width: 3%"><?php echo $srno ?></td>

              <td  style="width: 47%"><?php echo $result->ct_type ?></td>

              <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'tillDate'); ?></td>

              <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'thismonth'); ?></td>

              <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'today'); ?></td>

            </tr>

            <?php $srno++; endforeach; ?>

          </tbody>

      </table>

    </div>

  </div>

</div>

    

 <div class="card">

    <a class="card-link" data-toggle="collapse" href="#collapseFive">

      <div class="card-header">

        <table class="table table-sm table-dark table-bordered cus">

            <thead class="thead-dark">

              <?php foreach ($data['child_birth'] as $result):

              $cntsub= accident_motorcycle($result->ct_id, 'tillDate');

              $cnt_td_5 = $cnt_td_5+$cntsub;                   

              $cntsub= accident_motorcycle($result->ct_id, 'thismonth');

              $cnt_tm_5 = $cnt_tm_5+$cntsub;

              $cntsub= accident_motorcycle($result->ct_id, 'today');

              $cnt_to_5 = $cnt_to_5+$cntsub;

              endforeach; ?>

              <tr>

                <td style="width: 50%;" scope="col">Child Birth</td>

                <td scope="col" style="width: 18%;"><?php echo $cnt_td_5;?></td>

                <td scope="col" style="width: 18%;"><?php echo $cnt_tm_5;?></td>

                <td scope="col" style="width: 18%;"><?php echo $cnt_to_5;?></td>

                </tr>

            </thead>

        </table>

      </div>

    </a>

  <div id="collapseFive" class="collapse" data-parent="#accordion">

    <div class="card-body">

      <table class="table table-sm table-hover table-bordered">

                                                                  

        <tbody>

        <?php $srno = 1; ?>

        <?php foreach ($data['child_birth'] as $result): ?>

              <tr>

                  <td style="width: 3%"><?php echo $srno ?></td>

            <td  style="width: 47%"><?php echo $result->ct_type ?></td>

            <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'tillDate'); ?></td>

            <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'thismonth'); ?></td>

            <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'today'); ?></td>

          </tr>

          <?php $srno++; endforeach; ?>

        </tbody>

      </table>

    </div>

  </div>

</div>



    <div class="card">

      <a class="card-link" data-toggle="collapse" href="#collapseSix">

        <div class="card-header">

          <table class="table table-sm table-dark table-bordered cus">

            <thead class="thead-dark">

             <?php foreach ($data['fall'] as $result):

              $cntsub= accident_motorcycle($result->ct_id, 'tillDate');

              $cnt_td_6 = $cnt_td_6+$cntsub;                   

              $cntsub= accident_motorcycle($result->ct_id, 'thismonth');

              $cnt_tm_6 = $cnt_tm_6+$cntsub;

              $cntsub= accident_motorcycle($result->ct_id, 'today');

              $cnt_to_6 = $cnt_to_6+$cntsub;

              endforeach; ?>

              <tr>

                <td style="width: 50%;" scope="col">Fall</td>

                <td scope="col" style="width: 18%;"><?php echo $cnt_td_6;?></td>

                <td scope="col" style="width: 18%;"><?php echo $cnt_tm_6;?></td>

                <td scope="col" style="width: 18%;"><?php echo $cnt_to_6;?></td>

                </tr>

            </thead>

          </table>

        </div>

      </a>

      <div id="collapseSix" class="collapse" data-parent="#accordion">

        <div class="card-body">

         <table class="table table-sm table-hover table-bordered">

                                  

            <tbody>

            <?php $srno = 1; ?>

            <?php foreach ($data['fall'] as $result): ?>

                  <tr>

                      <td style="width: 3%"><?php echo $srno ?></td>

                <td  style="width: 47%"><?php echo $result->ct_type ?></td>

                <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'tillDate'); ?></td>

                <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'thismonth'); ?></td>

                <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'today'); ?></td>

              </tr>

              <?php $srno++; endforeach; ?>

            </tbody>

          </table>

        </div>

      </div>

    </div>



    

    <div class="card">

      <a class="card-link" data-toggle="collapse" href="#collapseSeven">

        <div class="card-header">

          <table class="table table-sm table-dark table-bordered cus">

            <thead class="thead-dark">

                <?php foreach ($data['poisoning'] as $result):

              $cntsub= accident_motorcycle($result->ct_id, 'tillDate');

              $cnt_td_7 = $cnt_td_7+$cntsub;                   

              $cntsub= accident_motorcycle($result->ct_id, 'thismonth');

              $cnt_tm_7 = $cnt_tm_7+$cntsub;

              $cntsub= accident_motorcycle($result->ct_id, 'today');

              $cnt_to_7 = $cnt_to_7+$cntsub;

               endforeach; ?>

              <tr>

                <td style="width: 50%;" scope="col">Intoxication/Poisoning</td>

                <td scope="col" style="width: 18%;"><?php echo $cnt_td_7;?></td>

                <td scope="col" style="width: 18%;"><?php echo $cnt_tm_7;?></td>

                <td scope="col" style="width: 18%;"><?php echo $cnt_to_7;?></td>

                </tr>

            </thead>

          </table>

        </div>

      </a>

      <div id="collapseSeven" class="collapse" data-parent="#accordion">

        <div class="card-body">

         <table class="table table-sm table-hover table-bordered">

                                  

            <tbody>

            <?php $srno = 1; ?>

            <?php foreach ($data['poisoning'] as $result): ?>

                  <tr>

                      <td style="width: 3%"><?php echo $srno ?></td>

                <td  style="width: 47%"><?php echo $result->ct_type ?></td>

                <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'tillDate'); ?></td>

                <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'thismonth'); ?></td>

                <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'today'); ?></td>

              </tr>

              <?php $srno++; endforeach; ?>

            </tbody>

          </table>

        </div>

      </div>

    </div>

    

     <div class="card">

        <a class="card-link" data-toggle="collapse" href="#collapseEight">

          <div class="card-header">

            <table class="table table-sm table-dark table-bordered cus">

              <thead class="thead-dark">

                <?php foreach ($data['pregnancy'] as $result):

                $cntsub= accident_motorcycle($result->ct_id, 'tillDate');

                $cnt_td_8 = $cnt_td_8+$cntsub;                   

                $cntsub= accident_motorcycle($result->ct_id, 'thismonth');

                $cnt_tm_8 = $cnt_tm_8+$cntsub;

                $cntsub= accident_motorcycle($result->ct_id, 'today');

                $cnt_to_8 = $cnt_to_8+$cntsub;

                endforeach; ?>

                <tr>

                  <td style="width: 50%;" scope="col">Labour/ Pregnancy</td>

                  <td scope="col" style="width: 18%;"><?php echo $cnt_td_8;?></td>

                  <td scope="col" style="width: 18%;"><?php echo $cnt_tm_8;?></td>

                  <td scope="col" style="width: 18%;"><?php echo $cnt_to_8;?></td>

                </tr>

                

              </thead>

            </table>

          </div>

        </a>

        <div id="collapseEight" class="collapse" data-parent="#accordion">

          <div class="card-body">

           <table class="table table-sm table-hover table-bordered">

                                    

              <tbody>

              <?php $srno = 1; ?>

              <?php foreach ($data['pregnancy'] as $result): ?>

                    <tr>

                        <td style="width: 3%"><?php echo $srno ?></td>

                  <td  style="width: 47%"><?php echo $result->ct_type ?></td>

                  <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'tillDate'); ?></td>

                  <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'thismonth'); ?></td>

                  <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'today'); ?></td>

                </tr>

                <?php $srno++; endforeach; ?>

              </tbody>

            </table>

          </div>

        </div>

      </div>

    

    <div class="card">

      <a class="card-link" data-toggle="collapse" href="#collapseNine">

        <div class="card-header">

          <table class="table table-sm table-dark table-bordered cus">

            <thead class="thead-dark">

              <?php foreach ($data['mass_casualty'] as $result):

              $cntsub= mci_incidence($result->ntr_id, 'tillDate');

              $cnt_td_9 = $cnt_td_9+$cntsub;                   

              $cntsub= mci_incidence($result->ntr_id, 'thismonth');

              $cnt_tm_9 = $cnt_tm_9+$cntsub;

              $cntsub= mci_incidence($result->ntr_id, 'today');

              $cnt_to_9 = $cnt_to_9+$cntsub;

               endforeach; ?>

              <tr>

                <td style="width: 50%;" scope="col">Mass casualty</td>

                <td scope="col" style="width: 18%;"><?php echo $cnt_td_9;?></td>

                <td scope="col" style="width: 18%;"><?php echo $cnt_tm_9;?></td>

                <td scope="col" style="width: 18%;"><?php echo $cnt_to_9;?></td>

              </tr>

            </thead>

          </table>

        </div>

      </a>

      <div id="collapseNine" class="collapse" data-parent="#accordion">

        <div class="card-body">

         <table class="table table-sm table-hover table-bordered">

                                                                  

            <tbody>

            <?php $srno = 1; ?>

            <?php foreach ($data['mass_casualty'] as $result): ?>

                  <tr>

                      <td style="width: 3%"><?php echo $srno ?></td>

                <td  style="width: 47%"><?php echo $result->ntr_nature ?></td>

                <td id="" style="width: 18%;"><?php echo mci_incidence($result->ntr_id, 'tillDate'); ?></td>

                <td id="" style="width: 18%;"><?php echo mci_incidence($result->ntr_id, 'thismonth'); ?></td>

                <td id="" style="width: 18%;"><?php echo mci_incidence($result->ntr_id, 'today'); ?></td>

              </tr>

              <?php $srno++; endforeach; ?>

            </tbody>

        </table>

      </div>

    </div>

    </div>

    

    <div class="card">

      <a class="card-link" data-toggle="collapse" href="#collapseTen">

        <div class="card-header">

          <table class="table table-sm table-dark table-bordered cus">

            <thead class="thead-dark">

              <?php foreach ($data['medical'] as $result):

              $cntsub= accident_motorcycle($result->ct_id, 'tillDate');

              $cnt_td_10 = $cnt_td_10+$cntsub;                   

              $cntsub= accident_motorcycle($result->ct_id, 'thismonth');

              $cnt_tm_10 = $cnt_tm_10+$cntsub;

              $cntsub= accident_motorcycle($result->ct_id, 'today');

              $cnt_to_10 = $cnt_to_10+$cntsub;

               endforeach; ?>

              <tr>

                <td style="width: 50%;" scope="col">Medical</td>

                <td scope="col" style="width: 18%;"><?php echo $cnt_td_10;?></td>

                <td scope="col" style="width: 18%;"><?php echo $cnt_tm_10;?></td>

                <td scope="col" style="width: 18%;"><?php echo $cnt_to_10;?></td>

                </tr>

            </thead>

          </table>

        </div>

      </a>

    <div id="collapseTen" class="collapse" data-parent="#accordion">

      <div class="card-body">

       <table class="table table-sm table-hover table-bordered">

                                                                  

          <tbody>

          <?php $srno = 1; ?>

          <?php foreach ($data['medical'] as $result): ?>

                <tr>

                    <td style="width: 3%"><?php echo $srno ?></td>

              <td  style="width: 47%"><?php echo $result->ct_type ?></td>

              <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'tillDate'); ?></td>

              <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'thismonth'); ?></td>

              <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'today'); ?></td>

            </tr>

            <?php $srno++; endforeach; ?>

          </tbody>

        </table>

      </div>

    </div>

  </div>



  <div class="card">

    <a class="card-link" data-toggle="collapse" href="#collapseEleven">

      <div class="card-header">

        <table class="table table-sm table-dark table-bordered cus">

          <thead class="thead-dark">

            <?php foreach ($data['trauma'] as $result):

            $cntsub= accident_motorcycle($result->ct_id, 'tillDate');

            $cnt_td_11 = $cnt_td_11+$cntsub;                   

            $cntsub= accident_motorcycle($result->ct_id, 'thismonth');

            $cnt_tm_11 = $cnt_tm_11+$cntsub;

            $cntsub= accident_motorcycle($result->ct_id, 'today');

            $cnt_to_11 = $cnt_to_11+$cntsub;

             endforeach; ?>

            <tr>

              <td style="width: 50%;" scope="col">Trauma</td>

              <td scope="col" style="width: 18%;"><?php echo $cnt_td_11;?></td>

              <td scope="col" style="width: 18%;"><?php echo $cnt_tm_11;?></td>

              <td scope="col" style="width: 18%;"><?php echo $cnt_to_11;?></td>

              </tr>

            

          </thead>

        </table>

      </div>

    </a>

    <div id="collapseEleven" class="collapse" data-parent="#accordion">

      <div class="card-body">

       <table class="table table-sm table-hover table-bordered">

                                                                  

        <tbody>

        <?php $srno = 1; ?>

        <?php foreach ($data['trauma'] as $result): ?>

              <tr>

                  <td style="width: 3%"><?php echo $srno ?></td>

            <td  style="width: 47%"><?php echo $result->ct_type ?></td>

            <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'tillDate'); ?></td>

            <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'thismonth'); ?></td>

            <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'today'); ?></td>

          </tr>

          <?php $srno++; endforeach; ?>

        </tbody>

      </table>

    </div>

  </div>

</div>



<div class="card">

    <a class="card-link" data-toggle="collapse" href="#collapseTwelve">

      <div class="card-header">

        <table class="table table-sm table-dark table-bordered cus">

          <thead class="thead-dark">

            <?php foreach ($data['other'] as $result):

            $cntsub= accident_motorcycle($result->ct_id, 'tillDate');

            $cnt_td_12 = $cnt_td_12+$cntsub;                   

            $cntsub= accident_motorcycle($result->ct_id, 'thismonth');

            $cnt_tm_12 = $cnt_tm_12+$cntsub;

            $cntsub= accident_motorcycle($result->ct_id, 'today');

            $cnt_to_12 = $cnt_to_12+$cntsub;

             endforeach; ?>

            <tr>

              <td style="width: 50%;" scope="col">Other</td>

              <td scope="col" style="width: 18%;"><?php echo $cnt_td_12;?></td>

              <td scope="col" style="width: 18%;"><?php echo $cnt_tm_12;?></td>

              <td scope="col" style="width: 18%;"><?php echo $cnt_to_12;?></td>

              </tr>

          

          </thead>

        </table>

      </div>

    </a>

<div id="collapseTwelve" class="collapse" data-parent="#accordion">

  <div class="card-body">

   <table class="table table-sm table-hover table-bordered">

                                                                  

    <tbody>

    <?php $srno = 1; ?>

    <?php foreach ($data['other'] as $result): ?>

          <tr>

              <td style="width: 3%"><?php echo $srno ?></td>

        <td  style="width: 47%"><?php echo $result->ct_type ?></td>

        <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'tillDate'); ?></td>

        <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'thismonth'); ?></td>

        <td id="" style="width: 18%;"><?php echo accident_motorcycle($result->ct_id, 'today'); ?></td>

      </tr>

      <?php $srno++; endforeach; ?>

    </tbody>

  </table>

</div>

                                      </div>

                                    </div> 

                                </div>  

                             

                            </div>

                 

                        </div>

                </section>

            <!-- END STATISTIC-->

            </div>



</div>

<script type="text/javascript">

            $(document).ready(function() {



          //window.onload=chart_diaplay();

         

        });



        

</script>

            

