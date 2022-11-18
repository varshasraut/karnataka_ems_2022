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
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>

    <!-- Main CSS-->
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />


    <link href="<?php echo base_url(); ?>assets/css/theme.css" rel="stylesheet" media="all">
    <style>
        .header_image {
            height: 57px;
            width: 50px;
            margin-top: -12px;
            
        }
    </style>
</head>

<body class="animsition" style="overflow-x:hidden;">
    <div class="page-wrapper">
        <!-- HEADER DESKTOP-->
        <header style="background-color: #2F419B !important;">
            <div class="row">
                <div class="col-md-3 align-items-center">
                    <div class="ml-2 header__logo align-items-center">
                        <div class="ems-heading-hosp text-center">
                            <span><?php echo $hosp[0]->hp_name; ?></span>
                        </div>
                        <!-- <a href="#">

                            <img src="<?php echo base_url(); ?>assets/images/bvg_logo.png" alt="BVG" style="height:50px;width:65px;margin-top:2px;" />

                            </a> -->
                    </div>
                </div>
                <div class="col-md-5 align-items-center">
                    <div class="align-items-center mt-2">

                        <div class="ems-heading1 text-center">
                            <span style="margin:auto 15px;">Hospital Intimation Terminal</span>
                        </div>

                    </div>
                </div>
                <div class="col-md-2 align-items-right">
                    <div class="align-items-right text-right mt-3">
                        <span class="clock" id='ct'> </span>
                    </div>

                </div>
                <div class="col-md-1 pr-0">

                    <div class="float_right">
                        <!-- <a id="open_74181851" alt="Logout" class="logout_open click-xhttp-request" data-href="{base_url}Clg/logout" data-popup-ordinal="0" data-qr="output_position=content"><i class="fa fa-sign-out pt-2" alt="Logout" style="font-size:35px;color:white;padding-top:5px;" data-toggle="tooltip" data-placement="top" title="Logout"></i></a> -->
                        <a class="logout_open head_logout_lnk" href="{base_url}Clg/logout" data-popup-ordinal="0"><i class="fa fa-sign-out pt-2" alt="Logout" style="font-size:35px;color:white;padding-top:5px;" data-toggle="tooltip" data-placement="top" title="Logout"></i></a>

                    </div>
                </div>
                <div class="col-md-1">
                    <div class="float_right mt-2">
                        <span style="float: left;" class="mr-1"><img class="header_image" src="<?php echo base_url(); ?>assets/images/108_logo.png"></span>
                    </div>

                </div>

            </div>
        </header>
    </div>


    <!-- END HEADER DESKTOP -->
    <nav class="navbar navbar-expand-md  navbar-dark justify-content-center" style="background-color: #cccccc;height:100%;">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-center" id="collapsibleNavbar">
            <ul class="nav navbar-nav ">
                <li class="btn btn-danger" style="background-color:#E41B17;height:30%;"><a class="nav-link" style="color: white;" href="<?php echo base_url(); ?>hospital_terminal/">Patients Arriving</a></li>&nbsp;
                <li class="btn btn-success" style="background-color:#347C17;height:30%;"><a class="nav-link" style="color: white;" href="<?php echo base_url(); ?>hospital_terminal/patients_arrived/">Patients Arrived</a></li>
            </ul>
        </div>
    </nav>