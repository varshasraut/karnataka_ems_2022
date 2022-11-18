<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Dashboard</title>

    <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/morris.css">
    <link href="<?php echo base_url(); ?>assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/snap.svg-min.js"></script> -->
    <script type="text/javascript">
        var base_url = '{base_url}';
    </script>

    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/js/gijgo.min.js" type="text/javascript"></script>
    <link href="<?php echo base_url(); ?>assets/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url(); ?>assets/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/vendor/wow/animate.css" rel="stylesheet" media="all">
    <!-- <link href="<?php echo base_url(); ?>assets/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all"> -->
    <!-- <link href="<?php echo base_url(); ?>assets/vendor/slick/slick.css" rel="stylesheet" media="all"> -->
    <!-- <link href="<?php echo base_url(); ?>assets/vendor/select2/select2.min.css" rel="stylesheet" media="all"> -->
    <!-- <link href="<?php echo base_url(); ?>assets/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all"> -->


    <!-- Main CSS-->
    <link href="<?php echo base_url(); ?>assets/css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER DESKTOP-->
        <div class="container">
            <div class="row" style="background-color: #085b80;">
                <div class="col-md-1 align-items-left">
                    <a href="#">
                        <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="National Health Mission" />
                    </a>
                </div>
                <div class="col-md-8 align-items-right" style="text-align: center">
                    <label id="headdiv">MP &nbsp;EMERGENCY &nbsp;MEDICAL &nbsp;SERVICES</label>
                </div>
                <div class="col-md-2" style="padding-top:20px">
                    <!-- <h4 style="color: whitesmoke;font-family:serif;">30-06-2021</h4> -->
                    <span style="padding-top:50px;color: #F4F6F7;font-size:15px;" class="clock" id='ct'> </span>
                </div>

                <div class="col-md-1 align-items-right">
                    <a href="#">
                        <img src="<?php echo base_url(); ?>assets/images/Call108.png" alt="Call 108" />
                    </a>
                </div>
            </div>
        </div>

        <!-- END HEADER DESKTOP -->
        <nav class="navbar navbar-expand-md bg-dark navbar-dark justify-content-center">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="nav navbar-nav" id="tabs">
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>Dashboard/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>Dashboard/get_performer/">Performer</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>Dashboard/get_performer_tl/">TL/SM</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>Dashboard/get_performer_bike/">DCO TL/Bike ERO</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>Dashboard/get_performer_pda/">PDA/IT</a></li> -->


                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>Dashboard/all_amb/">Live Ambulance Map</a></li>
                    <!--<li><a class="nav-link" href="<?php echo base_url(); ?>Dashboard/amb_tracking/">Ambulance Tracking</a></li> -->
                    <!--                  <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url(); ?>Dashboard/live_calls/">Live Calls</a></li>
      <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url(); ?>Dashboard/type_of_emergency_served/">Type of Emergency Served</a></li>
                  <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url(); ?>Dashboard/districtwise_emergency_patients_served/">District-Wise Emergency Patients</a></li>-->


                    <!--<li class="nav-item">
      <a class="nav-link" href="<?php echo base_url(); ?>Dashboard/total_distance_travelled_by_ambulance/">Total Distance Travelled</a></li>-->
                    <!--      <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url(); ?>Dashboard/ambulance_reponse_time/">Response Time Report</a></li>
      <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url(); ?>Dashboard/graph/">Graph</a></li> -->

                </ul>
            </div>
        </nav>


    </div>


</body>

<style>
    #headdiv {
        font-family: serif !important;
        padding-top: 10px;
        text-align: center;
        font-size: 25px;
        color: #F4F6F7;
        font-weight: bold;
        padding-left: 200px;
    }

    #tabs {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    #tabs li {
        float: left;
    }
</style>