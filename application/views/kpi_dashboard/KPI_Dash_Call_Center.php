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

    .margin_Leftadded {
        margin-left: 70px;
    }

    .Table1 {
        background: linear-gradient(90deg, #E1C7F4 0%, #AC93CC 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 70px;
    }

    .Table2 {
        background: linear-gradient(90deg, #7AE2BF 0%, #D7F090 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 70px;
    }

    .Table3 {
        background: linear-gradient(90deg, #FFE794 0%, #E37DC2 100%);
        border: 1px solid #000000;
        border-radius: 10px 10px 0px 0px;
        height: 70px;
    }

    .table1_fount {
        font-family: 'Roboto';
        font-style: normal;
        font-weight: 700;
        font-size: 21px;
        align-items: flex-end;
        color: #FFFFFF;
        margin-top: 10px;
    }

    .table2_fount2 {
        font-family: 'Roboto';
        font-style: normal;
        font-weight: 600;
        font-size: 18px;
        line-height: 28px;
        align-items: flex-end;
        color: #000000;
    }

    .table_height {
        height: 320px !important;
    }

    .table th {
        border-top: none;
        width: 60%;
    }

    .head_txt {
        margin: 10px 0 10px 0;
        padding-left: 5px;
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

        .text_large {
            margin-top: -5px !important;
        }

        .text_large1 {
            margin-top: -5px !important;
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
            margin-top: -5px !important;
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
            margin-top: -5px !important;
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

    }



    @media (min-width: 900px) and (max-width: 1300px) {
        /* .header_fount {
            font-size: 26px;
        } */

        .fount_item {
            font-size: 35px;
        }

        .text_large {
            margin-top: -5px !important;
        }

        .table th {
            width: 70%;
        }

        .table_height {
            height: 365px !important;
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
                            <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-2 col-sm-2 col-6">
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
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                        <div class="row">
                                            <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                                                <a href="{base_url}erc_dashboards/kpi_dash">
                                                    <div class="icon icon-shape bg-gradient-coll">
                                                        <i class="fa-solid fa-arrow-left p-3 fa-2x"></i>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12 ">
                                                <div class="text-center">
                                                    <label class="fount_item"> Centralized Call Center : 108 Integrated
                                                        Call Center </label>
                                                </div>
                                            </div>

                                            <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12">
                                                <a href="{base_url}erc_dashboards/sanjeevani_service">
                                                    <div class="icon icon-shape bg-gradient-coll">
                                                        <i class="fa-solid fa-arrow-right p-3 fa-2x"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 "
                                    style="padding-top: 20px;">
                                    <div class="row">
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">

                                            <div class=" ">
                                                <div
                                                    class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 Table1">
                                                    <div class="text-center">
                                                        <label class="table1_fount p-2 text_large">KPI - I Average Speed
                                                            to Answer (ASA)</label>
                                                    </div>
                                                </div>
                                                <table class="table border rounded-corners table_height">
                                                    <thead>
                                                        <!-- <tr>

                                                            <th scope="col" colspan="3" class="border-0 text-center">
                                                                Compliance Benchmark&nbsp; &nbsp; <label>85%</label>
                                                            </th>

                                                        </tr> -->
                                                    </thead>
                                                    <tbody>
                                                        <tr>

                                                            <td class="border-right align-middle w-50">
                                                                <h6 class="head_txt">Total Calls Answered by Agent</h6>
                                                            </td>
                                                            <td
                                                                class=" text-center align-middle">
                                                                <?php echo $data['cc_kpi1_tcaa']?></td>
                                                            <!-- <td class="border-top text-center align-middle">@100%</td> -->
                                                        </tr>
                                                        <tr>

                                                            <td class="border-top border-right align-middle">
                                                                <h6 class="head_txt">Calls Answered by Agent <br>(<=12
                                                                        Seconds)</h6>
                                                            </td>
                                                            <td
                                                                class="border-top text-center align-middle">
                                                                <?php echo $data['cc_kpi1_caa_less_12_sec']?></td>
                                                            <!-- <td class="border-top text-center align-middle">@84%</td> -->
                                                        </tr>
                                                        <tr>

                                                            <td class="border-top border-right align-middle">
                                                                <h6 class="head_txt">Calls Answered by Agent <br>(> 12
                                                                    Seconds)</h6>
                                                            </td>
                                                            <td
                                                                class="border-top text-center align-middle">
                                                                <?php echo $data['cc_kpi1_caa_more_12_sec']?></td>
                                                            <!-- <td class="border-top text-center align-middle">16%</td> -->
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                            <div class="">
                                                <div
                                                    class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 Table2 ">
                                                    <div class="text-center">
                                                        <label class="table1_fount p-2 text_large1">KPI - II Call
                                                            Abandoned Rate</label>
                                                    </div>
                                                </div>
                                                <!--<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                    <label class="table2_fount2">Compliance Benchmark  &nbsp; &nbsp;<label>73%</label></label>
                                                </div>
                                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                    <div class="row">
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="text-center">
                                                                <label class="table2_fount2 p-2">Total Calls Offered</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 border_ubhe">
                                                            <div class="text-center">
                                                                <label class="table2_fount2 p-2">736733</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 border_ubhe">
                                                            <div class="text-center">
                                                                <label class="table2_fount2 p-2">100</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <table class="table  border rounded-corners table_height ">
                                                    <!-- <thead>
                                                        <tr>
                                                            <th colspan="3" class="text-center border-0">Compliance
                                                                Benchmark &nbsp; &nbsp; <label>100%</label></th>
                                                        </tr>
                                                    </thead> -->
                                                    <tbody>
                                                        <tr>

                                                            <td class=" border-right align-middle w-50">
                                                                <h6>Total Calls Offered</h6>
                                                            </td>
                                                            <td
                                                                class="align-middle text-center">
                                                                <?php echo $data['cc_kpi2_tco']?></td>
                                                            <!-- <td class="border-top align-middle text-center">100</td> -->
                                                        </tr>
                                                        <tr>

                                                            <td class="border-top border-right align-middle">
                                                                <h6>Total Calls of Abandoned</h6>
                                                            </td>
                                                            <td
                                                                class="border-top align-middle text-center">
                                                                <?php echo $data['cc_kpi2_tca']?></td>
                                                            <!-- <td class="border-top align-middle text-center">86</td> -->
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                            <div class="">
                                                <div
                                                    class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 Table3    ">
                                                    <div class="text-center">
                                                        <label class="table1_fount p-2 text_large1">KPI - III 108-ERC
                                                            Downtime</label>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                    <label class="table2_fount2">Compliance Benchmark   &nbsp; &nbsp;<label>73% </label></label>
                                                </div>
                                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                    <div class="row">
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="text-center">
                                                                <label class="table2_fount2 p-2">Total Hours</label>
                                                            </div>
                                                        </div>                                                            
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 border_ubhe">
                                                            <div class="text-center">
                                                                <label class="table2_fount2 p-2">-</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <table class="table border rounded-corners table_height ">
                                                    <!-- <thead>
                                                        <tr>


                                                            <th scope="col" colspan="3" class="text-center border-0">
                                                                Compliance Benchmark &nbsp; &nbsp; <label>99.9%</label>
                                                            </th>
                                                            <th scope="col">Handle</th>
                                                        </tr>
                                                    </thead> -->
                                                    <tbody>
                                                        <tr>


                                                            <td class="border-right align-middle w-50">
                                                                <h6>Total Hours</h6>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <h6><?php echo $data['cc_kpi3_total_hrs']?></h6>
                                                            </td>
                                                        </tr>
                                                        <tr>


                                                            <td class="border-top border-right align-middle">
                                                                <h6>ERC Uptime Hours</h6>
                                                            </td>
                                                            <td class="border-top align-middle text-center"><?php echo $data['cc_kpi3_erc_up']?></td>
                                                        </tr>
                                                        <tr>

                                                            <td class="border-top border-right align-middle">
                                                                <h6>ERC Downtime Hours</h6>
                                                            </td>
                                                            <td class="border-top align-middle text-center"><?php echo $data['cc_kpi3_erc_down']?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- End Enter Main Content -->
                    </div>
                </div>
            </div>





            <!-- Footer -->
            <!-- <footer class="page-footer font-small blue footer mt-2">

                
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