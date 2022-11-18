<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="utf-8" http-equiv="encoding">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<title>Dashboard</title>

<link rel="stylesheet" href="<?php echo base_url().'assets/css/morris.css'?>">
    <link href="<?php echo base_url(); ?>assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtAZEUryIBFm-pAoQXya4TnjxrwyUIUWI&libraries=places&callback=init_auto_address&country:in"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps-api-v3/api/js/36/12a/common.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps-api-v3/api/js/36/12a/util.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps-api-v3/api/js/36/12a/map.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps-api-v3/api/js/36/12a/marker.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js/ViewportInfoService.GetViewportInfo?1m6&1m2&1d14.218718813664086&2d54.36568958165685&2m2&1d27.1828447908284&2d99.53103169564861&2u7&4sen-US&5e0&6sm%40473000000&7b0&8e0&callback=_xdc_._trw0xd&key=AIzaSyBtAZEUryIBFm-pAoQXya4TnjxrwyUIUWI&token=98268"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps-api-v3/api/js/36/12a/onion.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i7!2i88!3i55!1m4!1m3!1i7!2i89!3i55!1m4!1m3!1i7!2i90!3i55!1m4!1m3!1i7!2i91!3i55!1m4!1m3!1i7!2i92!3i55!1m4!1m3!1i7!2i93!3i55!1m4!1m3!1i7!2i94!3i55!1m4!1m3!1i7!2i88!3i56!1m4!1m3!1i7!2i88!3i57!1m4!1m3!1i7!2i89!3i56!1m4!1m3!1i7!2i89!3i57!1m4!1m3!1i7!2i90!3i56!1m4!1m3!1i7!2i90!3i57!1m4!1m3!1i7!2i91!3i56!1m4!1m3!1i7!2i91!3i57!1m4!1m3!1i7!2i92!3i56!1m4!1m3!1i7!2i92!3i57!1m4!1m3!1i7!2i93!3i56!1m4!1m3!1i7!2i93!3i57!1m4!1m3!1i7!2i94!3i56!1m4!1m3!1i7!2i94!3i57!2m3!1e0!2sm!3i473183392!3m14!2sen-US!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!12m4!1e26!2m2!1sstyles!2zcy50OjMzfHMuZTpsfHAudjpvZmY!4e3!12m1!5b1&callback=_xdc_._jo8kcb&key=AIzaSyBtAZEUryIBFm-pAoQXya4TnjxrwyUIUWI&token=72427"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps-api-v3/api/js/36/12a/controls.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js/AuthenticationService.Authenticate?1shttp%3A%2F%2Fwww.speroems.com%2Fspero_ems_2019%2Famb%2Fall&4sAIzaSyBtAZEUryIBFm-pAoQXya4TnjxrwyUIUWI&callback=_xdc_._e82br2&key=AIzaSyBtAZEUryIBFm-pAoQXya4TnjxrwyUIUWI&token=1053"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js/QuotaService.RecordEvent?1shttp%3A%2F%2Fwww.speroems.com%2Fspero_ems_2019%2Famb%2Fall&3sAIzaSyBtAZEUryIBFm-pAoQXya4TnjxrwyUIUWI&7syiu41v&10e1&callback=_xdc_._6tm7dd&key=AIzaSyBtAZEUryIBFm-pAoQXya4TnjxrwyUIUWI&token=32515"></script>
<script type="text/javascript" > var base_url = '{base_url}'; </script>
<!--<script type="text/javascript" src=""></script>-->
<!--<script type="text/javascript" src=""></script>-->
    <!-- Vendor CSS-->
    <link href="<?php echo base_url(); ?>assets/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">


    <!-- Main CSS-->
    <link href="<?php echo base_url(); ?>assets/css/theme.css" rel="stylesheet" media="all">
</head>
<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER DESKTOP-->
         <header class="header-desktop3 d-none d-lg-block ">
            <div class="section__content section__content--p35 align-items-center">
                <div class="header3-wrap align-items-center">
                    <div class="col-md-4 align-items-center">
                        <div class="header__logo align-items-center">
                             <a href="#">
                                <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="National Health Mission"  />
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 align-items-center">
                        <div class="align-items-center" >
                            <div class="ems-heading">Emergency Medical Services</div>
                        </div>
                    </div>
                    <div class="col-md-5 align-items-center">
                        <div class="align-items-center text-right" >
                            <span class="clock" id='ct' > </span>
                        </div>

                    </div>
                    <!--<div class="col-md-2 align-items-center">
                        <div class="align-items-center" >
                            <img src="<?php echo base_url(); ?>assets/images/bvg_logo.jpg" alt="BVG"  /><a href="<?php echo base_url(); ?>Dashboard/logout"><button class="btn btn-xs btn-default" style="color: white">Logout</button></a>
                        </div>

                    </div>-->
                   
                    </div>
                </div>
            </div>
            
        </header>
         <!-- END HEADER DESKTOP -->
         <nav class="navbar navbar-expand-md bg-dark navbar-dark justify-content-center">
               <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
             <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="http://www.speroems.com/spero_ems_2019/Dashboard" >Home</a></li>
                   <li class="nav-item"><a class="nav-link" href="http://www.speroems.com/spero_ems_2019/amb/all" >Live Ambulance Map</a></li>
                  <li class="nav-item">
      <a class="nav-link" href="#" target="_blank">Dispathces Report</a></li>
                  <li class="nav-item">
      <a class="nav-link" href="#" target="_blank">District-Wise Report</a></li>
                  <li class="nav-item">
      <a class="nav-link" href="#" target="_blank">Type of Emergency</a></li>
                  <li class="nav-item">
      <a class="nav-link" href="#" target="_blank">Live Calls</a></li>
                  <li class="nav-item">
      <a class="nav-link" href="#" target="_blank">Total Distance Travelled</a></li>
                  <li class="nav-item">
      <a class="nav-link" href="http://www.speroems.com/spero_ems_2019/reports/NHM_report" target="_blank">NHM Reports</a></li>
                  <li class="nav-item">
      <a class="nav-link" href="#" target="_blank">EMS Grieviance</a></li>
                </ul>
            </div>
</nav>

        <div id="mi_loader" class="mi_loader"></div> 
        <div id="processbar">
          <div id="message" style="display:block;">
            <div id="request" ></div>
            <div id="usrresponse" >{message}</div>
          </div>
        </div>
    <div class="content">
        {content}
    </div>
<footer class="footer-desktop3 d-none d-lg-block">

            <div class="section__content section__content--p35">

                <div class="header3-wrap">

                    <div class="header__logo">

                        <a href="#">

                            <img src="<?php echo base_url(); ?>assets/images/spero_logo.png" alt="Spero Healthcare Innovations"  />

                        </a>

                    </div>

                    <MARQUEE WIDTH=100% HEIGHT=50>

                        <div class="align-items-center" >

                            <div style="color: white;padding-top: 10px;font-family: 'Poppins', sans-serif;font-weight: 500;font-size: 22px;text-transform: uppercase;">Emergency Medical Services</div>

                        </div>

                    </MARQUEE>

                        

                    </div>

                </div>

            </div>

        </footer>

         <!-- END HEADER DESKTOP -->

    





</div>



    <!-- Jquery JS-->

    <!-- <script src="<?php //echo base_url(); ?>assets/vendor/jquery-3.2.1.min.js"></script> -->

    <!--<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="<?php echo base_url().'assets/js/raphael-min.js'?>"></script>

    <script src="<?php echo base_url().'assets/js/morris.min.js'?>"></script>

    <!-- Bootstrap JS-->

    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap-4.1/popper.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap-4.1/bootstrap.min.js"></script>

    <!-- Vendor JS       -->

    <script src="<?php echo base_url(); ?>assets/vendor/slick/slick.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/wow/wow.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/animsition/animsition.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/counter-up/jquery.waypoints.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/counter-up/jquery.counterup.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/circle-progress/circle-progress.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>

    <!-- <script src="<?php //echo base_url(); ?>assets/vendor/chartjs/Chart.bundle.min.js"></script> -->

    <!-- <script src="<?php //echo base_url(); ?>assets/vendor/select2/select2.min.js"></script> -->



    <!-- Main JS-->

    <script src="<?php echo base_url(); ?>assets/js/main.js"></script>

      <script type="text/javascript"> 

      function display_c(){

      var refresh=1000; // Refresh rate in milli seconds

      mytime=setTimeout('display_ct()',refresh)

      }



      function display_ct() {

      var x = new Date()

      var x1=x.toLocaleString();// changing the display to Local time string

      document.getElementById('ct').innerHTML = x1;

      tt=display_c();

       }

      </script>

     <script>

        $(document).ready(function() {

          window.onload=display_ct();

          window.onload=chart_diaplay();
          window.onload=map_diaplay();

          

          window.onload=ajaxcall();

          setInterval("ajaxcall()",20000);

            



        });



        function ajaxcall() { 

         $.ajax({

         type: "GET",

         data: "id=testdata",

         cache: false,

         dataType: 'json',

         url: "<?php echo base_url(); ?>/dashboard/view",

         success: function(result){

            //var count = jquery.ParseJSON(result);

            //alert(result.total_calls);

            $("#total_calls").html(result.total_calls);

            $("#total_calls_handled").html(result.total_calls_handled);

            $("#total_dispatch").html(result.total_dispatch);

            $("#agents_available").html(result.agents_available);

            $("#onRoad_ambulace").html(result.onRoad_ambulace);

            $("#offRoad_ambulace").html(result.offRoad_ambulace);

            $("#avg_resp_tm").html(result.avg_resp_tm);

            $("#total_incoming_call").html(result.total_incoming_call);

            $("#total_active_call").html(result.total_active_call);

            $("#total_closed_call").html(result.total_closed_call);

            $("#queue_call").html(result.queue_call);

            $("#total_dispatch_q").html(result.total_dispatch_q);

            

         }

        // event.preventDefault();

         });

         }



         function chart_diaplay() { 

         $.ajax({

         type: "GET",

         data: "id=testdata",

         cache: false,

         dataType: 'json',

         url: "<?php echo base_url(); ?>/dashboard/chartdata",

         success: function(res){

            alert(res);

            Morris.Bar({

            element: 'graph',

            data: res.chart,

            xkey: 'year',

            ykeys: ['emergency_calls', 'mas_cas_calls', 'medical_advice'],

            labels: ['Emergency Calls', 'Mas Casualty Calls', 'Medical Advice Calls']

            });

            

         }

        // event.preventDefault();

         });

         }
         
         function map_diaplay() { 

         $.ajax({

         type: "GET",

         data: "id=testdata",

         cache: false,

         dataType: 'json',

         url: "<?php echo base_url(); ?>dashboard/all_amb",

         success: function(res){
             //var count = jquery.ParseJSON(res);
            alert(count);
           $('#map11').html(count);

            

         }

        // event.preventDefault();

         });

         }

        //alert(res);

    </script> 


</body>
</html>