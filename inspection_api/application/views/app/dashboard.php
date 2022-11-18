<!DOCTYPE html>
<html>

<head>

    <head>

        <meta charset="UTF-8">
        <title>Statue Of Unity</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">


        <!-- <meta content="Live Demo Assisted Living,HMS is designed for medical practitioners and health-related institutions to assistant them in storing and keeping track of all correlated information such as patient medical records, admission/discharge reports, pharmaceutical management, billing and report generation and more. " name="description">
 <meta content="free live demo hms,free live demo Assisted Living,live demo,demo,live,Assisted Living live demo,Assisted Living free source codes,source codes,php,mysql,codeigniter,mvc,php frameworks,Assisted Living,hospital,management,system,solution,online demo,demo Assisted Living,live demo,demo trial,trial,hospital solution,clinic management system,clinic solution,management system,system,online management system" name="keywords">
  <meta content="Jayson Sarino" name="author">

  <meta property="og:site_name" content="Assisted Living Free Trial Demo">
  <meta property="og:title" content="Assisted Living">
  <meta property="og:description" content="Live Demo Assisted Living,HMS is designed for medical practitioners and health-related institutions to assistant them in storing and keeping track of all correlated information such as patient medical records, admission/discharge reports, pharmaceutical management, billing and report generation and more.">
  <meta property="og:type" content="website">
  <meta property="og:image" content="http://hms-demo.jaysonsarino.com/public/img/new/hms_logo.png"><!-- link to image for socio -->
        <!--<meta property="og:url" content="http://hms-demo.jaysonsarino.com/"> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
        <link href="<?php echo base_url() ?>public/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>public/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>public/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>public/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo base_url(); ?>public/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <div style="position:fixed; bottom: 0; right: 0; width: 67%; border: 2px solid #CCC; top:200px; z-index:1001; background-color: #FFF; display:none;" id="ad2">
        <span style="right: 0; position: fixed; cursor: pointer; z-index:1002" onclick="closeAd('ad2')">CLOSE</span>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Payroll Management System -->
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3182624105910612" data-ad-slot="4635770289" data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>


        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Assisted Living -->
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3182624105910612" data-ad-slot="3101991489" data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>


        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Grading System -->
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3182624105910612" data-ad-slot="6132191885" data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>

        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- HMS Website -->
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3182624105910612" data-ad-slot="1562391480" data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>

<body class="skin-blue">
    <!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH . 'views/include/header.php'); ?>

    <div class="wrapper row-offcanvas row-offcanvas-left">

        <?php require_once(APPPATH . 'views/include/sidebar.php'); ?>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Dashboard</h1>
                <!--<ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Examples</a></li>
                        <li class="active">Blank page</li>
                    </ol>-->
            </section>
            <div class="row">
                <div class="card"></div>
            </div>

            <div class="row">
                <section class="col-lg-12">
                    <div class="col-md-3 cardrow">
                        <div class="row displaycart">
                            <div class="col-md-4">
                                <i class="fa fa-plus-square icon1" aria-hidden="true"></i>
                            </div>
                            <div class="col-md-8 countval">
                                <label for="" id="value">49</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 head-cardrow">
                                Total Bookings Today

                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 cardrow">
                        <div class="row displaycart">
                            <div class="col-md-4">
                                <i class="fa fa-plus-square icon2" aria-hidden="true"></i>
                            </div>
                            <div class="col-md-8 countval">
                                <label for="" id="value">205</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 head-cardrow">
                                Total Bookings Till Month

                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 cardrow">
                        <div class="row displaycart">
                            <div class="col-md-4">
                                <i class="fa fa-money icon3" aria-hidden="true"></i>

                            </div>
                            <div class="col-md-8 countval">
                                <label for="" id="value">205</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 head-cardrow">
                                Total Collection

                            </div>
                        </div>
                    </div>

                </section>
            </div>

            <div class="row">
                <section class="col-lg-6 connectedSortable">
                    <canvas id="myChart" style="width:650px;height:400px"></canvas>

                </section>
                <section class="col-lg-6 connectedSortable">
                    <canvas id="myChart2" style="width:100%;max-width:600px;margin-top:50px;"></canvas>

                </section>
            </div>

        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->


    <script src="<?php echo base_url(); ?>public/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>public/js/AdminLTE/app.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            doctorOUTF();
            doctorINF();

        });

        function doctorOUTF() {
            $.ajax({
                url: "<?php echo base_url() ?>general/getDoctorOUT",
                type: "POST",
                success: function(result) {
                    $('#doctorOUT').html(result);
                },
                beforeSend: function() {
                    $('#doctorOUT').html("<center><img src='../public/img/ajax-loader.gif'></center>");
                }
            });
        }

        function doctorINF() {
            $.ajax({
                url: "<?php echo base_url() ?>general/getDoctorIN",
                type: "POST",
                success: function(result) {
                    $('#doctorIN').html(result);
                },
                beforeSend: function() {
                    $('#doctorIN').html("<center><img src='../public/img/ajax-loader.gif'></center>");
                }
            });
        }

        function doctorProcess(id, status) {
            if (confirm('Are you sure you want the doctor ' + status + '?')) {
                $.ajax({
                    url: "<?php echo base_url() ?>general/procDocAvail/" + id + "/" + status,
                    type: "POST",
                    success: function() {
                        alert('Doctor is ' + status);
                        doctorINF()
                        doctorOUTF()
                    },
                    beforeSend: function() {
                        $('#doctor' + status).html("<center><img src='../public/img/ajax-loader.gif'></center>");
                    }
                });
                return true;
            } else {
                return false;
            }

        }
    </script>

</body>
<style>
    .icon1 {
        font-size: 60px;
        color: #87aaebdb;
        margin: 10px;
    }
    .icon2 {
        font-size: 60px;
        color:#eb8787db;
        margin: 10px;
    }

    .icon3 {
        font-size: 60px;
        color: #78fc9a;
        margin: 10px;
    }

    .cardrow {
        border: 2px solid grey;
        margin: 50px;
        border-radius: 10px;
        box-shadow: 7px 10px #cac9c95c;
        padding: 0px !important;
    }

    .countval {
        font-size: 50px;
    }

    .head-cardrow {
        text-align: center;
        font-size: 15px;
        font-weight: bold;
        border-top: 2px solid grey;
        padding: 5px 10px 5px 10px;
    }

    .row {
        margin: 0px !important;
    }

    .displaycart {
        display: flex;
        align-content: space-between;
    }
</style>

<script>
    var xValues = ["Today", "Til Month"];
    var yValues = [49, 250];
    var barColors = [

        "#2b5797",
        "#e8c3b9"

    ];

    new Chart("myChart", {
        type: "pie",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            title: {
                display: true,
                text: "Total Cab Dispatched",
                fontSize: 20
            }
        }
    });
</script>


<script>
var xValues = ["Today", "Till Mont"];
var yValues = [55, 65];

new Chart("myChart2", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
        backgroundColor: [
            "#2b5797",
            "#e8c3b9"
    
    ],
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Total Collection",
      fontSize: 20
    },
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
  }
});
</script>


</html>