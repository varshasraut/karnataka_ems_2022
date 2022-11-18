<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>KPI Dashboard</title>
    <script language="javascript" type="text/javascript"></script>



    <!-- Google Fonts Name :- Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
    <!-- End Google Fonts Name :- Roboto -->

    <!-- Google Fonts Name :- Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <!-- End Google Fonts Name :- Poppins -->

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <!-- End Bootstrap -->


    <!-- Font Awesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- End Font Awesome  -->  
    <!-- CSS -->

    <style>
    .text_center {
        text-align: center;
    }

    /* .header_bg {
        background: linear-gradient(270deg, #2F419B 0.01%, #1299D2 100.02%);
        box-shadow: 0px 3px 40px rgba(0, 0, 0, 0.25);
        transform: matrix(1, 0, 0, 1, 0, 0);
    }

    .header_fount {
        font-family: 'Roboto';
        font-style: normal;
        font-weight: 800;
        font-size: 30px;
        line-height: 60px;
        display: flex;
        align-items: flex-end;
        text-align: center;
        text-transform: capitalize;
        color: #FFFFFF;
        transform: rotate(-0.22deg);
    } */

    /* .footer {
        background: #2F419B;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.25);
        transform: matrix(1, 0, 0, 1, 0, 0);
    } */

    .img_white {
        background-color: #FFF;
        margin: 2px 0 0 0;
    }

    .icon-shape {
        width: 60px;
        height: 60px;
        color: #FFFF;
        background-position: center;
        border-radius: 0.75rem;
    }

    .bg-gradient-coll {
        background: linear-gradient(180deg, #1299D2 0%, #2F419B 100%);
        box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 50px;
        margin-left: 8px;
    }

    .rounded-circle,
    .avatar.rounded-circle img {
        border-radius: 50% !important;
    }

    .fount_item {
        font-family: 'Roboto';
        font-style: normal;
        font-weight: 700;
        font-size: 40px;
        line-height: 56px;
        align-items: flex-end;
        text-align: center;
        color: #000000;
    }

    /* CSS For */

    .color_bg1 {
        background: linear-gradient(90deg, #D1B7FB 0%, #24AD9B 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .color_bg2 {
        background: linear-gradient(90deg, #AA90F9 0%, #F1DB8F 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .color_bg3 {
        background: linear-gradient(90deg, #67D9BA 0%, #E37DC2 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .color_bg4 {
        background: linear-gradient(90deg, #FFD494 0%, #E37D7D 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .text_fount {
        font-family: 'Roboto';
        font-style: normal;
        font-weight: 800;
        font-size: 18px;
        line-height: 22px;
        text-align: center;
        color: #FFFFFF;
        transform: matrix(1, 0, 0.01, 1, 0, 0);
        margin-top: 11px;
    }

    .text_fount2 {
        font-family: 'Roboto';
        font-style: normal;
        font-weight: 800;
        font-size: 15px;
        line-height: 26px;
        align-items: flex-end;
        transform: matrix(1, 0, 0.01, 1, 0, 0);
    }

    .table_align_center {
        vertical-align: center;
    }

    .table_height {
        height: 272px !important;
    }

    .table th {
        padding: 0.20rem;
        border-top: 0px solid #dee2e6;
    }

    .table td {
        padding: 0.20rem;
        border-top: 0px solid #dee2e6;
    }

    .table1 {
        table-layout: fixed;
        width: 100%;
    }

    .table1 td {
        border-top: 0px solid #dee2e6;
    }

    .border {
        border: 1px solid #000 !important;
        border-top: none !important;
    }

    .rounded-corners {
        border-collapse: separate;
        border-radius: 0 0 10px 10px;
        border-spacing: 0;
    }

    .border-top {
        border-top: 1px solid #8C8C8C !important;
    }

    .border-right {
        border-right: 1px solid #8C8C8C !important;
    }

    @media (min-width: 320px) and (max-width: 374.98px) {
        /* .header_fount {
            line-height: 45px;
        } */

        .fount_item {
            font-size: 30px;
            line-height: 45px;
            margin-top: 5px;
        }

        .img_resp {
            display: block;
            margin: auto;
        }

        .img_resp1 {
            float: right;
        }

        .bg-gradient-coll {
            display: block;
            margin: auto;
        }

        .table1 {
            table-layout: auto;
        }

        .text_large {
            margin-top: 0px !important;
        }
    }

    @media (min-width: 375px) and (max-width: 425.98px) {
        /* .header_fount {
            line-height: 45px;
        } */

        .fount_item {
            font-size: 30px;
            line-height: 45px;
            margin-top: 5px;
        }

        .img_resp {
            display: block;
            margin: auto;
        }

        .img_resp1 {
            float: right;
        }

        .bg-gradient-coll {
            display: block;
            margin: auto;
        }

        .text_large {
            margin-top: 10px !important;
        }
    }

    @media (min-width: 400px) and (max-width: 499.98px) {
        .img_resp {
            display: block;
            margin: auto;
        }

        .img_resp1 {
            float: right;
        }

        .bg-gradient-coll {
            display: block;
            margin: auto;
        }

        .text_large {
            margin-top: 0px !important;
        }

        .text_large {
            margin-top: 10px !important;
        }
    }

    @media (min-width: 700px) and (max-width: 799.98px) {
        .icon {
            margin-top: 15px;
        }

        .bg-gradient-coll {
            margin-left: -14px;
        }

        /* .header_fount {
            line-height: 45px;
            margin-top: -8px;
        } */

        .fount_item {
            font-size: 38px;
            line-height: 50px;
        }

        .text_large {
            margin-top: 10px !important;
        }
    }


    @media (min-width: 900px) and (max-width: 1300px) {
        /* .header_fount {
            font-size: 26px;
        } */

        .fount_item {
            font-size: 31px;
        }

        .icon {
            margin-left: -4px;
        }

        .text_large {
            margin-top: 0px !important;
        }

        .table th {
            width: 70%;
        }

        .table_height {
            height: 300px !important;
        }

        .table1 {
            table-layout: auto;
        }
    }

    @media (min-width: 2560px) {
        .icon_resp {
            padding-left: 115px !important;
        }

        .text_large {
            margin-top: 10px !important;
        }
    }
    </style>


    <!-- End CSS -->
</head>

<body>
    <div>
        <div>
            <div class="container-fluid">
                <div class="row">
                    <!-- <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 header_bg">
                        <div class="row">

                            <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-2 col-sm-2 col-12 ">
                                <img src="MP_Img\108.png" alt="Image" height="76" class="img_resp">
                            </div>
                            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-8 col-sm-8 col-12 ">
                                <div class="" style="padding-top: 10px;">
                                    <lable class="header_fount">Integrated Referral Transport System [ IRTS ] 108
                                    </lable>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-2 col-sm-2 col-6 ">
                                <img src="MP_Img\RED.png" alt="Image" height="72" class="img_white">
                            </div>
                            <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-2 col-sm-2 col-6 mx-auto">
                                <img src="MP_Img\Char.png" alt="Image" height="76" class="img_resp1">
                            </div>
                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12 mx-auto">
                                <img src="MP_Img\PM.png" alt="Image" height="76" class="img_resp">
                            </div>

                        </div>
                    </div> -->
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 " style="padding-top: 20px;">
                        <div class="">
                            <!-- Enter Main Content -->

                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <div class="row">
                                    <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                                        <a href="{base_url}erc_dashboards/janani_express_service">
                                            <div class="icon icon-shape bg-gradient-coll">
                                                <i class="fa-solid fa-arrow-left p-3 fa-2x"></i>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12 ">
                                        <div class="text-center">
                                            <label class="fount_item"> 104 Health Helpline </label>
                                        </div>
                                    </div>

                                    <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 icon_resp">
                                        <a href="{base_url}erc_dashboards/kpi_dash">
                                            <div class="icon icon-shape bg-gradient-coll">
                                                <i class="fa-solid fa-arrow-right p-3 fa-2x"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="padding-top: 20px;">
                        <div class="row">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">
                                <div class="">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg1">
                                        <div class="text_fount text_large">
                                            <label>KPI - I Average Speed to Answer (ASA)</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <div class="">
                                                <table class="table border rounded-corners table_height table1">
                                                    <thead>
                                                        <tr>

                                                            <td scope="col" class="pl-3 text_fount2" colspan="3">
                                                                Compliance Benchmark&nbsp; &nbsp; &nbsp; &nbsp;
                                                                <label><?php echo $data['hh_104_kpi1_cb'].'%'?></label></td>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance (A)</td>
                                                            <td
                                                                class="text-center align-middle border-top border-right">
                                                                <?php echo $data['hh_104_kpi1_ta_A']?></td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['hh_104_kpi1_ta_A_perc'].'%'?></td>
                                                        </tr>

                                                        <tr>
                                                            <th
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Calls Answered by Agent (<=12 Seconds)</td>
                                                            <td
                                                                class="text-center align-middle border-top border-right">
                                                                <?php echo $data['hh_104_kpi1_caa_less_12_sec']?></td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['hh_104_kpi1_caa_less_12_sec_perc'].'%'?></td>
                                                        </tr>

                                                        <tr>
                                                            <th
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Calls Answered by Agent (> 12 Seconds)</th>
                                                            <td
                                                                class="text-center align-middle border-top border-right">
                                                                <?php echo $data['hh_104_kpi1_caa_more_12_sec']?></td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['hh_104_kpi1_caa_more_12_sec_perc'].'%'?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">
                                <div class="">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg2">
                                        <div class="text_fount">
                                            <label>KPI - II Call Abandoned Rate</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                        <div class="">
                                            <table class="table border rounded-corners table_height table1">
                                                <thead>
                                                    <tr>
                                                        <td scope="col" class="pl-3 text_fount2" colspan="3">Compliance
                                                            Benchmark&nbsp; &nbsp; &nbsp; &nbsp; <label><?php echo $data['hh_104_kpi2_cb'].'%'?></label></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th
                                                            class="pl-3 text_fount2 align-middle border-top border-right">
                                                            Total Calls Offered</td>
                                                        <td class="text-center align-middle border-top border-right">
                                                        <?php echo $data['hh_104_kpi2_tco']?></td>
                                                        <td class="text-center align-middle border-top"><?php echo $data['hh_104_kpi2_tco_perc'].'%'?></td>
                                                    </tr>
                                                    <tr>
                                                        <th
                                                            class="pl-3 text_fount2 align-middle border-top border-right">
                                                            Total Calls of Abandoned</td>
                                                        <td class="text-center align-middle border-top border-right"><?php echo $data['hh_104_kpi2_tca']?>
                                                        </td>
                                                        <td class="text-center align-middle border-top"><?php echo $data['hh_104_kpi2_tca_perc'].'%'?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="row">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">
                        <div class="">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg3">
                                <div class="text_fount">
                                    <label>KPI - III 108-ERC Downtime</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <div class="">
                                        <table class="table border rounded-corners table_height">
                                            <thead>
                                                <tr>
                                                    <td scope="col" class="pl-3 text_fount2" colspan="3">Compliance
                                                        Benchmark&nbsp; &nbsp; &nbsp; &nbsp; <label><?php echo $data['hh_104_kpi3_cb'].'%'?></label></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th class="pl-3 text_fount2 align-middle border-top border-right w-50">
                                                        Total hours</th>
                                                    <th class="text-center align-middle border-top"><?php echo $data['hh_104_kpi3_total_hrs']?></th>
                                                </tr>

                                                <tr>
                                                    <th class="pl-3 text_fount2 align-middle border-top border-right">
                                                        ERC Uptime Hours</td>
                                                    <td class="text-center align-middle border-top"><?php echo $data['hh_104_kpi3_erc_uptime']?></td>
                                                </tr>
                                                <tr>
                                                    <th class="pl-3 text_fount2 align-middle border-top border-right">
                                                        ERC Downtime Hours</td>
                                                    <td class="text-center align-middle border-top"><?php echo $data['hh_104_kpi3_erc_downtime']?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">
                        <div class="">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg4">
                                <div class="text_fount">
                                    <label>KPI - IV 104 ERC Staffing</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <div class="">
                                    <table class="table border rounded-corners table_height table1 
                                                            table-responsive-md">
                                        <thead>
                                            <tr>
                                                <td scope="col" class="pl-3 text_fount2" colspan="6">Compliance
                                                    Benchmark&nbsp; &nbsp; &nbsp; &nbsp; <label><?php echo $data['hh_104_kpi4_cb'].'%'?></label></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text_fount2 align-middle border-top border-right text-center">Designation
                                                </td>
                                                <td
                                                    class=" text_fount2 align-middle border-top border-right text-center">
                                                    Team Lead</td>
                                                <td
                                                    class="text_fount2 align-middle border-top border-right text-center">
                                                    Doctors</td>
                                                <td
                                                    class="text_fount2 align-middle border-top border-right text-center">
                                                    Clinical Psychologists (CP)</td>
                                                <td
                                                    class="text_fount2 align-middle border-top border-right text-center">
                                                    Paramedic</td>
                                                <td class="text_fount2 align-middle border-top text-center">Total</td>
                                            </tr>

                                            <tr>
                                                <td class="pl-3 text_fount2 align-middle border-top border-right">NHM
                                                    Manpower Target</td>
                                                <td class="text-center align-middle border-top border-right"><?php echo $data['hh_104_kpi4_nhm_tl']?></td>
                                                <td class="text-center align-middle border-top border-right"><?php echo $data['hh_104_kpi4_nhm_doc']?></td>
                                                <td class="text-center align-middle border-top border-right"><?php echo $data['hh_104_kpi4_nhm_cp']?></td>
                                                <td class="text-center align-middle border-top border-right"><?php echo $data['hh_104_kpi4_nhm_paramedic']?></td>
                                                <td class="text-center align-middle border-top"><?php echo $data['hh_104_kpi4_nhm_total']?></td>
                                            </tr>
                                            <tr>
                                                <td class="pl-3 text_fount2 align-middle border-top border-right">JAES
                                                    Manpower</td>
                                                <td class="text-center align-middle border-top border-right"><?php echo $data['hh_104_kpi4_jaes_tl']?></td>
                                                <td class="text-center align-middle border-top border-right"><?php echo $data['hh_104_kpi4_jaes_doc']?></td>
                                                <td class="text-center align-middle border-top border-right"><?php echo $data['hh_104_kpi4_jaes_cp']?></td>
                                                <td class="text-center align-middle border-top border-right"><?php echo $data['hh_104_kpi4_jaes_cp']?></td>
                                                <td class="text-center align-middle border-top"><?php echo $data['hh_104_kpi4_jaes_total']?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    <!-- End Enter Main Content -->

    <!-- Footer 
    <footer class="page-footer font-small blue footer">

       
        <div class="container-fluid text-md-left">

            
            <div class="row">
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3">
                    <div class="">
                        <img src="MP_Img\JAES.png" alt="Image" height="40">
                    </div>
                </div>
                <div class="col-xxl-9 col-xl-9 col-lg-8 col-md-8 col-sm-6 col-6">

                </div>
                <div class="col-xxl-1 col-xl-1 col-lg-2 col-md-2 col-sm-3 col-3 ">
                    <div style="float:right;">
                        <img src="MP_Img\spero.png" alt="Image" height="40">
                    </div>
                </div>
            </div>
        </div>-->
    </footer>

    </div>

    </div>

</body>

<script>

</script>



</html>