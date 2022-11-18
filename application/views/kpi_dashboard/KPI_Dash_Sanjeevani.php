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
    }

    .footer {
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
        margin-left: 5px;
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
        background: linear-gradient(90deg, #08A5B3 0%, #1BE0C2 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .color_bg2 {
        background: linear-gradient(90deg, #FF968E 0%, #FFBC79 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .color_bg3 {
        background: linear-gradient(90deg, #75DCCD 0%, #9CD07D 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .color_bg4 {
        background: linear-gradient(90deg, #FF978E 0%, #AC93CC 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .color_bg5 {
        background: linear-gradient(90deg, #6DCFF6 0%, #785FAE 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .color_bg6 {
        background: linear-gradient(90deg, #A4DC90 0%, #EBAF14 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .color_bg7 {
        background: linear-gradient(90deg, #FFC56D 0%, #29D5D5 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .color_bg8 {
        background: linear-gradient(90deg, #B9CF2F 0%, #EC8D8D 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .color_bg9 {
        background: linear-gradient(90deg, #9B90DC 0%, #D53EC5 100%);
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

    .text_large {
        margin-top: 0 !important;
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
        height: 280px !important;
    }

    .table th {
        padding: 0.20rem;
        vertical-align: top;
        border-top: 0px solid #dee2e6;
    }

    .table td {
        padding: 0.20rem;
        vertical-align: top;
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

        .txt_resp {
            margin-top: 0px !important;
        }

        .txt-resp2 {
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

        .txt_resp {
            margin-top: 0px !important;
        }

        .txt_resp1 {
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

        .txt_resp {
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

        .txt_resp {
            margin-top: 0px !important;
        }

        .table th {
            width: 70%;
        }

        .table_height {
            height: 300px !important;
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
                                        <a href="{base_url}erc_dashboards/integrated_call_center">
                                            <div class="icon icon-shape bg-gradient-coll">
                                                <i class="fa-solid fa-arrow-left p-3 fa-2x"></i>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12 ">
                                        <div class="text-center">
                                            <label class="fount_item"> Sanjeevani -108: Emergency Medical Ambulance
                                                Service </label>
                                        </div>
                                    </div>

                                    <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 icon_resp">
                                        <a href="{base_url}erc_dashboards/janani_express_service">
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
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                <div class="">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg1">
                                        <div class="text_fount text_large">
                                            <label>KPI - I Operationalization of ALS and BLS Ambulance</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <div class="">
                                                <table class="table border rounded-corners table_height">
                                                    <tr>
                                                        <th scope="" class="align-middle" colspan="">Compliance
                                                            Benchmark</th>
                                                        <td scope=""><?php echo $data['sj_kpi1_cb'].'%'?>  </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="" class="text_fount2 align-middle" colspan="">Date
                                                        </th>
                                                        <td scope=""><?php echo $data['sj_kpi1_date']?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="" class="text_fount2 align-middle" colspan="">Month
                                                        </th>
                                                        <td scope=""><?php echo $data['sj_kpi1_month']?></td>
                                                    </tr>
                                                    <tbody>
                                                        <tr>
                                                            <th
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                ALS Deployment As per RFP</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi1_als_deploy_rfp']?></td>
                                                        </tr>

                                                        <tr>
                                                            <th
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                BLS Deployment As per RFP</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi1_bls_deploy_rfp']?></td>
                                                        </tr>

                                                        <tr>
                                                            <th
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                ALS Deployed</th>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi1_als_deployed']?></td>
                                                        </tr>

                                                        <tr>
                                                            <th
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                BLS Deployed</th>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi1_bls_deployed']?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                <div class="">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg2">
                                        <div class="text_fount txt-resp2">
                                            <label>KPI - II Ambulance Response Time</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                        <div class="">
                                            <table class="table border rounded-corners table_height">
                                                <thead>
                                                    <tr>

                                                        <td scope="col" class="pl-3 text_fount2" colspan="3">Compliance
                                                            Benchmark&nbsp; &nbsp; &nbsp; &nbsp; <label><?php echo $data['sj_kpi2_cb'].'%'?></label></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td
                                                            class="pl-3 text_fount2 align-middle border-top border-right">
                                                            Name</td>
                                                        <td
                                                            class="text_fount2 text-center align-middle border-top border-right">
                                                            Urban</td>
                                                        <td class="text_fount2 align-middle text-center border-top">
                                                            Rural</td>
                                                    </tr>

                                                    <tr>
                                                        <td
                                                            class="pl-3 text_fount2 align-middle border-top border-right">
                                                            Total Served Cases</td>
                                                        <td class="text-center align-middle border-top border-right">
                                                        <?php echo $data['sj_kpi2_tcs_urban']?></td>
                                                        <td class="text-center align-middle border-top"><?php echo $data['sj_kpi2_tcs_rural']?></td>
                                                    </tr>

                                                    <tr>
                                                        <td
                                                            class="pl-3 text_fount2 align-middle border-top border-right">
                                                            Response Time</td>
                                                        <td class="text-center align-middle border-top border-right">
                                                        <?php echo $data['sj_kpi2_res_time_urban']?></td>
                                                        <td class="text-center align-middle border-top"><?php echo $data['sj_kpi2_res_time_rural']?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                <div class="">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg3">
                                        <div class="text_fount">
                                            <label>KPI - III Ambulance Off Road</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                        <div class="">
                                            <table class="table border rounded-corners table_height">
                                                <thead>
                                                    <tr>

                                                        <td class="pl-3 text_fount2" scope="col" colspan="3">Compliance
                                                            Benchmark&nbsp; &nbsp; &nbsp; &nbsp; <label><?php echo $data['sj_kpi3_cb'].'%'?></label></td>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td
                                                            class="pl-3 text_fount2 align-middle border-top border-right">
                                                            Total Ambulance (A)</td>
                                                        <td class="text-center align-middle border-top border-right"><?php echo $data['sj_kpi3_ta_A']?>
                                                        </td>
                                                        <td class="text-center align-middle border-top"><?php echo $data['sj_kpi3_ta_A_perc'].'%'?></td>
                                                    </tr>

                                                    <tr>
                                                        <td
                                                            class="pl-3 text_fount2 align-middle border-top border-right">
                                                            Total Ambulance On Road (B)</td>
                                                        <td class="text-center align-middle border-top border-right"><?php echo $data['sj_kpi3_ta_onroad_B']?>
                                                        </td>
                                                        <td class="text-center align-middle border-top"><?php echo $data['sj_kpi3_ta_onroad_B_perc'].'%'?></td>
                                                    </tr>

                                                    <tr>
                                                        <td
                                                            class="pl-3 text_fount2 align-middle border-top   border-right">
                                                            Total Ambulance Off Road <br>for More than 24 Hrs (C)</td>
                                                        <td class="text-center align-middle border-top border-right">
                                                        <?php echo $data['sj_kpi3_ta_offroad_more_24hrs_C']?></td>
                                                        <td class="text-center align-middle border-top"><?php echo $data['sj_kpi3_ta_offroad_more_24hrs_C_perc'].'%'?></td>
                                                    </tr>

                                                    <tr>
                                                        <td
                                                            class="pl-3 text_fount2 align-middle border-top border-right">
                                                            Total Ambulance Off Road </th>
                                                        <td class="text-center align-middle border-top border-right"><?php echo $data['sj_kpi3_ta_offroad']?>
                                                        </td>
                                                        <td class="text-center align-middle border-top"><?php echo $data['sj_kpi3_ta_offroad_perc'].'%'?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                <div class="">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg4">
                                        <div class="text_fount text_large">
                                            <label>KPI - IV Ambulance Off Road for Preventive and Breakdown
                                                Maintenance</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <div class="">
                                                <table class="table border rounded-corners table_height">
                                                    <tr>
                                                        <td class="pl-3 text_fount2 align-middle" scope="" colspan="">Compliance Benchmark</td>
                                                        <td scope="" class="align-middle" colspan="2"><?php echo $data['sj_kpi4_cb']?>
                                                        </td>
                                                    </tr>

                                                    <tbody>
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance (A)</td>
                                                            <td class="text-center align-middle border-top border-right"><?php echo $data['sj_kpi4_ta_A']?></td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi4_ta_A_perc'].'%'?></td>
                                                        </tr>

                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance On Road (B)</td>
                                                            <td class="text-center align-middle border-top border-right"><?php echo $data['sj_kpi4_ta_onroad_B']?></td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi4_ta_onroad_B_perc'].'%'?></td>
                                                        </tr>

                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance Off Road for More than 60 Hours (C)</td>
                                                            <td class="text-center align-middle border-top border-right"><?php echo $data['sj_kpi4_ta_offroad_more_60hrs_C']?></td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi4_ta_offroad_more_60hrs_C_perc'].'%'?></td>
                                                        </tr>

                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance (D)</td>
                                                            <td class="text-center align-middle border-top border-right"><?php echo $data['sj_kpi4_ta_D']?></td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi4_ta_D_perc'].'%'?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                <div class="">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg5">
                                        <div class="text_fount txt_resp txt_resp1">
                                            <label>KPI - V Ambulance GPS Device Uptime</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <div class="">
                                                <table class="table border rounded-corners table_height">
                                                    <thead>
                                                        <tr>

                                                            <td class="pl-3 text_fount2" scope="col" colspan="3">
                                                                Compliance Benchmark&nbsp; &nbsp; &nbsp; &nbsp;
                                                                <label><?php echo $data['sj_kpi5_cb'].'%'?></label>
                                                            </td>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right w-75">
                                                                Total Ambulance GPS Devices (A)</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi5_ta_gps_device_A']?></td>

                                                        </tr>

                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance GPS Functioning (B)</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi5_ta_gps_functn_B']?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance GPS Device Non <br>Functioning (C)</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi5_ta_gps_device_non_functn_C']?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                <div class="">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg6">
                                        <div class="text_fount txt_resp">
                                            <label>KPI - V.1 Ambulance MDT Device Uptime</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <div class="">
                                                <table class="table border rounded-corners table_height">
                                                    <thead>
                                                        <tr>

                                                            <td class="pl-3 text_fount2 align-middle" scope="col"
                                                                colspan="3">Compliance Benchmark&nbsp; &nbsp; &nbsp;
                                                                &nbsp; <label><?php echo $data['sj_kpi5_1_cb'].'%'?></label></td>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right w-75">
                                                                Total Ambulance MDT Devices (A)</td>
                                                            <td class="text-center align-middle w-25 border-top"><?php echo $data['sj_kpi5_1_ta_mdt_device_A']?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance MDT Functioning (B)</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi5_1_ta_mdt_functn_B']?></td>
                                                        </tr>

                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance MDT Device <br>Non Functioning (C)</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi5_1_ta_mdt_device_non_functn_C']?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                <div class="">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg7">
                                        <div class="text_fount text_large">
                                            <label>KPI - VI Ambulance Inspection Deficiency/ Shortfalls</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <div class="">                                                
                                                <table class="table border rounded-corners table_height">

                                                    <tr>
                                                        <td class="pl-3 text_fount2 align-middle" scope="col"
                                                            colspan="3">Compliance Benchmark&nbsp; &nbsp; &nbsp; &nbsp;
                                                            <label><?php echo $data['sj_kpi6_cb'].'%'?></label>
                                                        </td>
                                                    </tr>

                                                    <tbody>
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance Inspected (A)</td>
                                                            <td class="text-center align-middle w-25 border-top "><?php echo $data['sj_kpi6_ta_inspect_A']?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance Audit non <br>Compliance (B)</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi6_ta_audit_B']?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                <div class="">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg8">
                                        <div class="text_fount text_large">
                                            <label>KPI - VII Ambulance Not Availed Cases (Base to Scene Time)</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <div class="">
                                                <table class="table border rounded-corners table_height">
                                                    <tr>
                                                        <td class="pl-3 text_fount2 align-middle" scope="" colspan="">
                                                            Compliance Benchmark&nbsp; &nbsp; &nbsp; &nbsp;
                                                            <label><?php echo $data['sj_kpi7_cb'].'%'?></label>
                                                        </td>
                                                        <td class="text-center text_fount2 align-bottom ">Rural</th>
                                                        <td class="text-center text_fount2 align-bottom ">Urban</td>
                                                    </tr>
                                                    <tbody>
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Not Availed Cases (A)</td>
                                                            <td scope="col"
                                                                class="text-center align-middle border-top border-right">
                                                                <?php echo $data['sj_kpi7_tnac_A_rural']?></td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi7_tnac_A_urban']?></td>

                                                        </tr>
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Not Availed Cases with in <br>
                                                                <= Response Time (B)</td>
                                                            <td
                                                                class="text-center align-middle border-top border-right">
                                                                <?php echo $data['sj_kpi7_tnac_less_res_time_B_rural']?></td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi7_tnac_less_res_time_B_urban']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Not Availed Cases with in <br>> Response Time (C)</td>
                                                            <td
                                                                class="text-center align-middle border-top border-right">
                                                                <?php echo $data['sj_kpi7_tnac_more_res_time_C_rural']?></td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi7_tnac_more_res_time_C_urban']?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                <div class="">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg9">
                                        <div class="text_fount text_large">
                                            <label>KPI - VIII Ambulance Medical and Non Medical Equipment
                                                Availability</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <div class="">
                                                <table class="table border rounded-corners table_height">
                                                    <thead>
                                                        <tr>

                                                            <td class="pl-3 text_fount2 align-middle" scope="col"
                                                                colspan="3">Compliance Benchmark&nbsp; &nbsp; &nbsp;
                                                                &nbsp; <label><?php echo $data['sj_kpi8_cb'].'%'?></label></td>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Count of Ambulances Equipment’s  (A)</td>
                                                            <td class="text-center align-middle w-25 border-top"><?php echo $data['sj_kpi8_tc_amb_equip_A']?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Count of Ambulances Equipment’s Available (B)</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi8_tc_amb_equip_avail_B']?></td>
                                                        </tr>

                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Count of Ambulances Equipment’s Not Available (C)</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi8_tc_amb_equip_not_avail_C']?></td>
                                                        </tr>

                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Sum of Total Number of Days Ambulance Equipment Not Available in Days (D)</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['sj_kpi8_tn_days_amb_equip_not_avail_D']?></td>
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
    </div>
    <!-- End Enter Main Content -->

    <!-- Footer -->
    <!-- <footer class="page-footer font-small blue footer">

      
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
        </div>
    </footer> -->

    </div>

    </div>

</body>

<script>

</script>



</html>