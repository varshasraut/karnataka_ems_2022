

<!--PAGE CONTENT-->

        <div class="page-content--bgf7">

             <!-- round cirlcle icons start -->

             <!-- STATISTIC-->

             <div class="container-fluid">

                <section class="statistic statistic2 py-1">

                    

                    <div class="row py-4 text-center">

                      <div class="col-md-12 col-lg-12">  

                            <h3>LIVE CALLS</h3>

                      </div>

                    </div>

                    <!-- <div class="row ">

                      <div class="col-md-6 col-lg-6"> 

                      <form class="form-inline" id="formdtw" method="post" action="">

                        <label><strong>Between Dates</strong>&nbsp;</label>

                             <input class="d-inline" placeholder="From Date" id="datepickerf" name="from" width="150" />&nbsp;

                             <input class="d-inline" placeholder="To Date" id="datepickert" name="to" width="150" />&nbsp;

                            <input type="submit" name="Submit" class="btn btn-primary btn-xs d-inline" value="Submit">

                              <script>

        $('#datepickerf').datepicker({

            uiLibrary: 'bootstrap4',

            format: 'yyyy/mm/dd'

        });

        $('#datepickert').datepicker({

            uiLibrary: 'bootstrap4',

            format: 'yyyy/mm/dd'

        });



    </script>

                        </form> 

                    </div>

                        <div class="col-md-6 col-lg-6"> 

                        <form method="post" action="<?php echo base_url()?>Dashboard/createxls">

                            <input type="submit" name="export" class="pull-right btn btn-primary btn-xs" value="Export Data">

                        </form>

                      </div>

                    </div> -->

                    <!-- <div class="container"> -->

                        <div class="row pb-5 pt-2" >

                            

                            <div class="col-md-10 offset-md-1 col-lg-10 offset-lg-1 mt-4 pt-4">

                                <div class="row text-center">

                                    <div class="col-md-12">

                                    <h3 class="text-center pb-2">EMERGENCY CALLS <span id="ec"></span></h3>

                                </div>

                                </div>

                                <div class="row">

                                <div class="col-md-3 offset-md-1 col-lg-3 inline-dispatch">

                                    <div class="statistic__item_dispatch statistic__item--orange">

                                        <div class="black-head-dispatch"><span class="desc-dispatch">Till-Date</span></div>

                                        <h2 class="number" id="eme_calls_td"></h2>

                                        

                                    </div>

                                </div>

                                <div class="col-md-3 col-lg-3 inline-dispatch">

                                    <div class="statistic__item_dispatch statistic__item--redd">

                                        <div class="black-head-dispatch"><span class="desc-dispatch">This Month</span></div>

                                        <h2 class="number" id="eme_calls_tm"><?php echo live_calls('thismonth') ?></h2>

                                    </div>

                                </div>

                                <div class="col-md-3 col-lg-3 inline-dispatch">

                                    <div class="statistic__item_dispatch statistic__item--yellow">

                                        <div class="black-head-dispatch"><span class="desc-dispatch">Today</span></div>

                                        <h2 class="number" id="eme_calls_to"><?php echo live_calls('today') ?></h2>

                                    </div>

                                </div>

                                <!-- <div class="col-md-4 offset-md-4 col-lg-4 offset-lg-4 inline-dispatch show">

                                    <div class="statistic__item_dispatch statistic__item--yellow">

                                        <div class="black-head-dispatch"><span class="desc-dispatch">Custom Range</span></div>

                                        <h2 class="number" id="custom_eme_calls"></h2>

                                    </div>

                                </div> -->

                            </div>

                      

                            <div class="row text-center">

                                <div class="col-md-12">

                                    <h3 class="pb-2 text-center">EMERGENCY PATIENTS SERVED <span id="eps"></span></h3>

                                </div>

                                </div>

                                <div class="row">

                                <div class="col-md-3 offset-md-1 col-lg-3  inline-dispatch">

                                    <div class="statistic__item_dispatch statistic__item--orange1">

                                        <div class="black-head-dispatch"><span class="desc-dispatch">Till-Date</span></div>

                                        <h2 class="number" id="total_calls_emps_td"><?php echo $emps_td; ?></h2>

                                    </div>

                                </div>

                                <div class="col-md-3 col-lg-3 inline-dispatch">

                                    <div class="statistic__item_dispatch statistic__item--green">

                                        <div class="black-head-dispatch"><span class="desc-dispatch">This Month</span></div>

                                        <h2 class="number" id="total_calls_emps_tm"><?php echo $emps_tm; ?></h2>

                                    </div>

                                </div>

                                <div class="col-md-3 col-lg-3  inline-dispatch">

                                    <div class="statistic__item_dispatch statistic__item--blue">

                                        <div class="black-head-dispatch"><span class="desc-dispatch">Today</span></div>

                                        <h2 class="number" id="total_calls_emps_to"><?php echo $emps_to; ?></h2>

                                    </div>

                                </div>

                                <!-- <div class="col-md-4 offset-md-4 col-lg-4 offset-lg-4 inline-dispatch show">

                                    <div class="statistic__item_dispatch statistic__item--blue">

                                        <div class="black-head-dispatch"><span class="desc-dispatch">Custom Range</span></div>

                                        <h2 class="number" id="custom_pati_served"></h2>

                                    </div>

                                </div> -->

                            </div>   

                            </div>



                        

                        </div>

                </section>

            <!-- END STATISTIC-->

            </div>



</div>

<script type="text/javascript">
$(document).ready(function() {
 window.onload=ajaxcall();
 setInterval("ajaxcall()",20000); 
});
</script>
