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
    <!-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600&family=Montserrat:wght@300;400;500&family=Permanent+Marker&display=swap" rel="stylesheet"> -->
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

    .img_white {
        background-color: #FFF;
        margin: 2px 0 0 0;
    }

    /* .footer {
        background: #2F419B;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.25);
        transform: matrix(1, 0, 0, 1, 0, 0);
    } */



    .icon-shape {
        width: 60px;
        height: 60px;
        color: #FFFF;
        background-position: center;
        border-radius: 0.75rem;
        margin-left: 12px;
    }

    .bg-gradient-coll {
        background: linear-gradient(180deg, #1299D2 0%, #2F419B 100%);
        box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 50px;
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
        /* display: flex; */
        text-align: center;
        color: #000000;
    }

    /* CSS For */

    .color_bg1 {
        background: linear-gradient(90deg, #1FF7FF 0%, #7377BA 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .color_bg2 {
        background: linear-gradient(90deg, #E51F7A 0%, #862989 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;

    }

    .color_bg3 {
        background: linear-gradient(90deg, #FE8F93 0%, #CB87B5 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;

    }

    .color_bg4 {
        background: linear-gradient(90deg, #FBA43E 0%, #E24751 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .color_bg5 {
        background: linear-gradient(90deg, #AA90FB 0%, #D18EB6 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .color_bg6 {
        background: linear-gradient(90deg, #7B9CDF 0%, #4FAC99 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .color_bg7 {
        background: linear-gradient(90deg, #C1DA28 0%, #58B23A 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 45px;
    }

    .color_bg8 {
        background: linear-gradient(90deg, #159F8E 0%, #2ACF83 100%);
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
        /* display: flex; */
        text-align: center;
        color: #FFFFFF;
        transform: matrix(1, 0, 0.01, 1, 0, 0);
        margin-top: 11px;
    }

    .text_fount2 {
        font-family: 'Roboto';
        font-style: normal;
        font-weight: 600;
        font-size: 15px;
        /*line-height: 25px;*/
        /* display: flex; */
        align-items: flex-end;
        /* text-align: center; */
        transform: matrix(1, 0, 0.01, 1, 0, 0);
    }

    .text_large {
        margin-top: 0 !important;
    }

    .table_height {
        height: 220px !important;
    }

    .table_align_center {
        vertical-align: center;
    }

    .table th {
        padding: 0.20rem;
        vertical-align: top;
        border-top: none;
    }

    .table td {
        padding: 0.20rem;
        vertical-align: top;
        border-top: none;
    }

    .text_label {
        font-weight: normal !important;
        font-size: 14px;
    }

    .border-top {
        border-top: 1px solid #8C8C8C !important;
    }

    .border-right {
        border-right: 1px solid #8C8C8C !important;
    }

    .border_black {
        border-right: 1px solid #000;
        border-left: 1px solid #000;
        border-bottom: 1px solid #000 !important;
    }

    .rounded-corners {
        border-collapse: separate;
        border-radius: 0 0 10px 10px;
    }

    @media (min-width: 320px) and (max-width: 374.98px) {
        .text_fount {
            font-size: 14px;
            line-height: 18px;
            margin-top: 6px;
        }

        .text_large {
            margin-top: 4px !important;
            font-size: 14px !important;
        }

        .icon-shape {
            display: block;
            margin: auto;
        }

        .img_108 {
            display: block;
            margin: auto;
        }

        .img_char {
            float: right;
        }
    }

    @media (min-width: 375px) and (max-width: 425.98px) {
        /* .header_fount {
            line-height: 45px;
        } */

        .text_fount {
            font-weight: 600;
            font-size: 16px;
            line-height: 18px;
            margin-top: 8px;
        }

        .text_large {
            margin-top: 5px !important;
            font-size: 14px !important;
        }

        .icon-shape {
            display: block;
            margin: auto;
        }

        .img_108 {
            display: block;
            margin: auto;
        }

        .img_char {
            float: right;
        }
    }

    /* // Extra small devices (portrait phones, less than 576px) */
    @media (min-width: 426px) and (max-width: 575.98px) {}

    /* // Small devices (landscape phones, 576px and up) */
    @media (min-width: 576px) and (max-width: 767.98px) {}

    /* // Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) and (max-width: 991.98px) {
        .icon-shape {
            margin-left: 0;
        }

        .text_fount {
            font-weight: 600;
            font-size: 18px;
            line-height: 18px;
            margin-top: 13px;
        }

        .text_large {
            margin-top: 13px !important;
        }

        .icon_resp {
            padding: 0 !important;
        }
    }

    @media (min-width: 768px) and (max-width: 991.98px) {}

    @media (min-width: 400px) and (max-width: 499.98px) {
        .text_mob {
            margin-top: 2px !important;
        }
    }

    @media (min-width: 500px) and (max-width: 599.98px) {
        .icon-shape {
            display: block;
            margin: auto;
        }

        .img_108 {
            display: block;
            margin: auto;
        }

        .img_char {
            float: right;
        }
    }

    @media (min-width: 600px) and (max-width: 699.98px) {}

    @media (min-width: 700px) and (max-width: 799.98px) {}

    /* // Large devices (desktops, 992px and up) */
    @media (min-width: 800px) and (max-width: 998.98px) {}

    @media (min-width: 900px) and (max-width: 1099.98px) {
        .fount_item {
            font-size: 33px;
        }

        /* .header_fount {
            font-size: 26px;
        } */

        .color_bg1 {
            height: 60px;
        }

        .color_bg2 {
            height: 60px;
        }

        .color_bg3 {
            height: 60px;
        }

        .color_bg4 {
            height: 60px;
        }

        .color_bg5 {
            height: 60px;
        }

        .color_bg6 {
            height: 60px;
        }

        .color_bg7 {
            height: 60px;
        }

        .color_bg8 {
            height: 60px;
        }

        .text_fount {
            font-size: 18px;
            line-height: 18px;
            margin-top: 10px;
        }

        .table_height {
            height: 285px !important;
        }

        .text_large {
            margin-top: 5px !important;
        }

        .icon-shape {
            margin-left: -2px;
        }
    }

    @media (min-width: 1100px) and (max-width: 1199.98px) {}

    /* // Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) and (max-width: 1299.98px) {}

    @media (min-width: 1300px) and (max-width: 1439.98px) {}

    @media (min-width: 1440px) and (max-width: 2559.98px) {
        .border_black {
            border-bottom: 2px solid #000 !important;
        }
    }

    @media (min-width: 2000px) and (max-width: 2499.98px) {}

    @media (min-width: 2500px) and (max-width: 2559.98px) {}

    @media (min-width: 2560px) {
        .icon_resp {
            padding-left: 130px;
             !important
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
                                <img src="MP_Img\108.png" alt="Logo 108" height="76" class="img_108">
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
                                <img src="MP_Img\Char.png" alt="Image" height="76" class="img_char">
                            </div>
                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12 mx-auto">
                                <img src="MP_Img\PM.png" alt="Image" height="76" class="img_108">
                            </div>

                        </div>
                    </div> -->
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 " style="padding-top: 20px;">
                        <!-- <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12  " style="padding-bottom: 20px;"> -->
                        <div class="row">

                            <!-- Enter Main Content -->


                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <div class="row">
                                    <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                                        <a href="{base_url}erc_dashboards/sanjeevani_service">
                                            <div
                                                class="icon icon-shape bg-gradient-coll shadow-danger text-center rounded-circle">
                                                <i class="fa-solid fa-arrow-left p-3 fa-2x"></i>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12 ">
                                        <div class="text-center">
                                            <label class="fount_item">Janani Express: Referral Transport Service Under
                                                JSSK </label>
                                        </div>
                                    </div>

                                    <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 icon_resp">
                                        <a href="{base_url}erc_dashboards/helpline_service">
                                            <div
                                                class="icon icon-shape bg-gradient-coll shadow-danger text-center rounded-circle">
                                                <i class="fa-solid fa-arrow-right p-3 fa-2x"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="padding-top: 20px;">
            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                    <div class="row">
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                            <div class="color_bg1">
                                <div class="text_fount text_mob">
                                    <label>KPI - I Operationalization Of JSSK Ambulances</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <div class="">
                                        <div class="row">
                                        </div>
                                        <table class="table border_black table_height rounded-corners table-borderless">
                                            <tbody>
                                                <tr>
                                                    <th scope="" class="align-middle" colspan="">Compliance Benchmark
                                                    </th>
                                                    <td scope="" class="align-middle"><?php echo $data['je_kpi1_cb'].'%'?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="" class="text_fount2 align-middle" colspan="">Month</th>
                                                    <td scope="" class="align-middle"><?php echo $data['je_kpi1_month']?></td>
                                                </tr>
                                                <tr>
                                                    <th class="pl-3 text_fount2 align-middle border-top border-right"
                                                        width="55%">JSSK Deployed As Per PRF</th>
                                                    <td class="text-center align-middle border-top"><?php echo $data['je_kpi1_jssk_deployed_prf']?></td>
                                                </tr>
                                                <tr>
                                                    <th class="pl-3 text_fount2 align-middle border-top border-right">
                                                        JSSK Deployed</td>
                                                    <td class="text-center align-middle border-top"><?php echo $data['je_kpi1_jssk_deployed']?></td>
                                                </tr>
                                                <tr>
                                                    <th class="pl-3 text_fount2 align-middle border-top border-right">
                                                        Remark</th>
                                                    <td class="text-center align-middle border-top"><?php echo $data['je_kpi1_remark']?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                            <div class="">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg2">
                                    <div class="text_fount">
                                        <label>KPI - II Ambulance Response Time</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                        <div class="">
                                            <table
                                                class="table border_black table_height rounded-corners table-borderless">
                                                <thead class="border-bottom-0">
                                                    <tr>
                                                        <th scope="col" class="pl-3 text_fount2" colspan="3">Compliance
                                                            Benchmark&nbsp; &nbsp; &nbsp; &nbsp; <label><?php echo $data['je_kpi2_cb'].'%'?></label>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="border_black">
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
                                                        <?php echo $data['je_kpi2_tcs_urban']?></td>
                                                        <td class="text-center align-middle border-top"><?php echo $data['je_kpi2_tcs_rural']?></td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="pl-3 text_fount2 align-middle border-top border-right">
                                                            Response Time</td>
                                                        <td class="text-center align-middle border-top border-right">
                                                        <?php echo $data['je_kpi2_res_time_urban']?></td>
                                                        <td class="text-center align-middle border-top"><?php echo $data['je_kpi2_res_time_rural']?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                            <div>
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg3">
                                    <div class="text_fount">
                                        <label>KPI - III Ambulance Off Road</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                        <div class="">
                                            <table
                                                class="table border_black table_height rounded-corners table-borderless">
                                                <thead class="border-bottom-0">
                                                    <tr>

                                                        <td scope="col" class="pl-3 text_fount2" colspan="3">Compliance
                                                            Benchmark&nbsp; &nbsp; &nbsp; &nbsp; <label><?php echo $data['je_kpi3_cb'].'%'?></label></th>

                                                    </tr>
                                                </thead>
                                                <tbody class="border_black">
                                                    <tr>
                                                        <td class="pl-3 text_fount2 align-middle border-top border-right"
                                                            width="68%">Total Ambulance (A)</td>
                                                        <td class="text-center align-middle border-top border-right"><?php echo $data['je_kpi3_ta_A']?>
                                                        </td>
                                                        <td class="text-center align-middle text-center border-top"><?php echo $data['je_kpi3_ta_A_perc'].'%'?>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td
                                                            class="pl-3 text_fount2 align-middle border-top border-right">
                                                            Total Ambulance On Road (B)</td>
                                                        <td class="text-center align-middle border-top border-right"><?php echo $data['je_kpi3_ta_onroad_B']?>
                                                        </td>
                                                        <td class="text-center align-middle border-top"><?php echo $data['je_kpi3_ta_onroad_B_perc'].'%'?></td>
                                                    </tr>

                                                    <tr>
                                                        <td
                                                            class="pl-3 text_fount2 align-middle border-top border-right">
                                                            Total Ambulance Off Road for More Than 24 Hrs (C)</td>
                                                        <td class="text-center align-middle border-top border-right"><?php echo $data['je_kpi3_ta_offroad_more_24hrs_C']?>
                                                        </td>
                                                        <td class="text-center align-middle border-top"><?php echo $data['je_kpi3_ta_offroad_more_24hrs_C_perc'].'%'?></td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="pl-3 text_fount2 align-middle border-top border-right">
                                                            Total Ambulance Off Road</td>
                                                        <td class="text-center align-middle border-top border-right"><?php echo $data['je_kpi3_ta_offroad']?>
                                                        </td>
                                                        <td class="text-center align-middle border-top"><?php echo $data['je_kpi3_ta_offroad_perc'].'%'?></td>
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
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                    <div class="">
                                        <div
                                            class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg4">
                                            <div class="text_fount text_large">
                                                <label>KPI - IV Ambulance Off Road for Preventive and Breakdown
                                                    Maintenance</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <div class="">
                                                <table
                                                    class="table table_height rounded-corners border_black table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th scope="" class="pl-3 text_fount2 align-top border-0">
                                                                Compliance Benchmark</th>
                                                            <th colspan="2" class="border-0 text_label"><label><?php echo $data['je_kpi4_cb']?></label></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="border_black">
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance (A)</td>
                                                            <td
                                                                class="text-center align-middle border-top border-right">
                                                                <?php echo $data['je_kpi4_ta_A']?></td>
                                                            <td class="text-center align-middle text-center border-top">
                                                            <?php echo $data['je_kpi4_ta_A_perc'].'%'?></td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance On Road (B)</td>
                                                            <td
                                                                class="text-center align-middle border-top border-right">
                                                                <?php echo $data['je_kpi4_ta_onroad_B']?></td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['je_kpi4_ta_onroad_B_perc'].'%'?></td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance Off Road for More Than 60 Hrs (C)</td>
                                                            <td
                                                                class="text-center align-middle border-top border-right">
                                                                <?php echo $data['je_kpi4_ta_offroad_more_60hrs_C']?></td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['je_kpi4_ta_offroad_more_60hrs_C_perc'].'%'?></td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance (D)</td>
                                                            <td
                                                                class="text-center align-middle border-top border-right">
                                                                <?php echo $data['je_kpi4_ta_D']?></td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['je_kpi4_ta_D_perc'].'%'?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                    <div class="">
                                        <div
                                            class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg5">
                                            <div class="text_fount">
                                                <label>KPI - V Ambulance GPS Device Uptime</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <div class="">
                                                <table
                                                    class="table table_height rounded-corners border_black table-borderless">
                                                    <thead class="border-bottom-0">
                                                        <tr>
                                                            <th scope="col" class="pl-3 pt-2 text_fount2" colspan="3">
                                                                Compliance Benchmark&nbsp; &nbsp; &nbsp; &nbsp;
                                                                <label><?php echo $data['je_kpi5_cb'].'%'?></label></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="border_black">
                                                        <tr>
                                                            <td class="pl-3 text_fount2 align-middle border-top border-right"
                                                                width="75%">Total Ambulance GPS Devices (A)</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['je_kpi5_ta_gps_device_A']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance GPS Functioning (B)</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['je_kpi5_ta_gps_functn_B']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance GPS Device Non Functioning (C)</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['je_kpi5_ta_gps_device_non_functn_C']?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                    <div class="">
                                        <div
                                            class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg6">
                                            <div class="text_fount text_mob">
                                                <label>KPI - V.1 Ambulance MDT Device Uptime</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <div class="">
                                                <table
                                                    class="table table_height rounded-corners border_black table-borderless">
                                                    <thead class="border-bottom-0">
                                                        <tr>
                                                            <th scope="col" class="pl-3 pt-2 text_fount2" colspan="3">
                                                                Compliance Benchmark&nbsp; &nbsp; &nbsp; &nbsp;
                                                                <label><?php echo $data['je_kpi5_1_cb'].'%'?></label></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="border_black">
                                                        <tr>
                                                            <td class="pl-3 text_fount2 align-middle border-top border-right"
                                                                width="75%">Total Ambulance MDT Devices (A)</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['je_kpi5_1_ta_mdt_device_A']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance MDT Functioning (B)</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['je_kpi5_1_ta_mdt_functn_B']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                class="pl-3 text_fount2 align-middle border-top border-right">
                                                                Total Ambulance MDT Device Non Functioning (C)</td>
                                                            <td class="text-center align-middle border-top"><?php echo $data['je_kpi5_1_ta_mdt_device_non_functn_C']?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                            <div class="">
                                                <div
                                                    class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg7">
                                                    <div class="text_fount text_large">
                                                        <label>KPI - VI Ambulance inspection Deficiency /
                                                            Shortfalls</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                    <div class="">
                                                        <table class="table table_height rounded-corners border_black
                                                                    table-borderless">
                                                            <thead class="border-bottom-0">
                                                                <tr>

                                                                    <th scope="col" class="pl-3 pt-2 text_fount2"
                                                                        colspan="3">Compliance Benchmark&nbsp; &nbsp;
                                                                        &nbsp; &nbsp; <label><?php echo $data['je_kpi6_cb'].'%'?></label></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="border_black">
                                                                <tr>
                                                                    <td class="pl-3 text_fount2 align-middle border-top border-right"
                                                                        width="75%">Total Ambulance Inspected (A)</td>
                                                                    <td class="text-center align-middle border-top"><?php echo $data['je_kpi6_ta_inspect_A']?>
                                                                    </td>
                                                                <tr>
                                                                    <td
                                                                        class="pl-3 text_fount2 align-middle border-top border-right">
                                                                        Total Ambulance Audit non Compliance (B)</td>
                                                                    <td class="text-center align-middle border-top"><?php echo $data['je_kpi6_ta_audit_B']?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                            <div class="">
                                                <div
                                                    class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 color_bg8">
                                                    <div class="text_fount text_large">
                                                        <label>KPI - VII Ambulance Not Availed Cases (Base to Scene
                                                            Time)</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                    <div class="">
                                                        <table
                                                            class="table table_height rounded-corners border_black table-borderless">
                                                            <thead class="border-bottom-0">
                                                                <tr>
                                                                    <td scope="col" class="pl-3 pt-1 pb-3 text_fount2">
                                                                        Compliance Benchmark&nbsp; &nbsp; &nbsp;
                                                                        <label><?php echo $data['je_kpi7_cb'].'%'?></label></td>
                                                                    <td class="align-bottom text-center"><b>Rural</b>
                                                                    </td>
                                                                    <td class="align-bottom text-center"><b>Urban</b>
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="border_black">
                                                                <tr>
                                                                    <td class="pl-3 text_fount2 align-middle border-top border-right"
                                                                        width="60%">Total Not Availed Cases (A)</td>
                                                                    <td
                                                                        class="text-center align-middle border-top border-right">
                                                                        <?php echo $data['je_kpi7_tnac_A_rural']?></td>
                                                                    <td class="text-center align-middle border-top"><?php echo $data['je_kpi7_tnac_A_urban']?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        class="pl-3 text_fount2 align-middle border-top border-right">
                                                                        Total Not Availed Cases <br>with in <= Response
                                                                            Time (B)</td>
                                                                    <td
                                                                        class="text-center align-middle border-top border-right">
                                                                        <?php echo $data['je_kpi7_tnac_less_res_time_B_rural']?></td>
                                                                    <td class="text-center align-middle border-top"><?php echo $data['je_kpi7_tnac_less_res_time_B_urban']?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        class="pl-3 text_fount2 align-middle border-top border-right">
                                                                        Total Not Availed Cases with in<br> > Response
                                                                        Time (C)</td>
                                                                    <td
                                                                        class="text-center align-middle border-top border-right">
                                                                        <?php echo $data['je_kpi7_tnac_more_res_time_C_rural']?></td>
                                                                    <td class="text-center align-middle border-top"><?php echo $data['je_kpi7_tnac_more_res_time_C_urban']?>
                                                                    </td>
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
    </div>




    <!-- Footer -->
    <footer class="page-footer font-small blue footer">

        <!-- Footer Links 
        <div class="container-fluid text-md-left">

            <div class="row">
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3">
                    <div class="">
                        <img src="MP_Img\JAES.png" alt="Image" height="40">
                    </div>
                </div>
                <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-8 col-sm-6 col-6">

                </div>
                <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-2 col-sm-3 col-3 ">
                    <div class="">
                        <img src="MP_Img\spero.png" alt="Image" height="40">
                    </div>
                </div>
            </div>
        </div>-->
    </footer>
</body>

<script>

</script>



</html>