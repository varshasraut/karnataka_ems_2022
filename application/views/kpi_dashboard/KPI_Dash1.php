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
    }

    .footer {
        background: #2F419B;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.25);
        transform: matrix(1, 0, 0, 1, 0, 0);
    } */

    .img_crd {
        height: 100%;
        width: 100%;
    }

    .mp1 {
        background: linear-gradient(90deg, #9071F2 0%, #3084C0 100%);
        box-shadow: 0px 10px 50px rgba(236, 236, 237, 0.5);
        border-radius: 20px;
    }

    .mp2 {
        background: linear-gradient(270deg, #3DD2BF 0%, #1198D2 100%);
        box-shadow: 0px 10px 50px rgba(236, 236, 237, 0.5);
        border-radius: 20px;
    }

    .mp3 {
        background: linear-gradient(90deg, #FF8763 0%, #FF63AB 100%);
        box-shadow: 0px 10px 50px rgba(236, 236, 237, 0.5);
        border-radius: 20px;
    }

    .mp4 {
        background: linear-gradient(90deg, #EC68F4 0%, #8762FD 100%);
        box-shadow: 0px 10px 50px rgba(236, 236, 237, 0.5);
        border-radius: 20px;
    }

    .img_white {
        background-color: #FFF;
        margin: 2px 0 0 0;
    }

    .boxx1 {
        width: 600vh;
        right: 10px;
        top: 30px;
    }

    .boxx1_color {
        background: linear-gradient(90deg, #9071F2 0%, #3084C0 100%);
        box-shadow: 0px 10px 50px rgba(236, 236, 237, 0.5);
        border-radius: 20px;
    }

    .boxx2_color {
        background: linear-gradient(270deg, #3DD2BF 0%, #1198D2 100%);
        box-shadow: 0px 10px 50px rgba(236, 236, 237, 0.5);
        border-radius: 20px;
    }

    .boxx3_color {
        background: linear-gradient(90deg, #FF8763 0%, #FF63AB 100%);
        box-shadow: 0px 10px 50px rgba(236, 236, 237, 0.5);
        border-radius: 20px;
    }

    .boxx4_color {
        background: linear-gradient(90deg, #EC68F4 0%, #8762FD 100%);
        box-shadow: 0px 10px 50px rgba(236, 236, 237, 0.5);
        border-radius: 20px;
    }

    .founta {
        font-family: 'Roboto';
        font-style: normal;
        font-weight: 700;
        font-size: 30px;
        display: flex;
        align-items: flex-end;
        text-align: center;
        color: #FFFFFF;
        transform: rotate(-0.22deg);
    }

    .name_Padding_left1 {
        padding-left: 175px;
    }

    .name_Padding_left2 {
        padding-left: 35px;
    }

    /*  */

    svg {
        display: inline-block;
        position: absolute;
        top: -204px;
        left: -15px;
        width: 365px;
        z-index: -1;
        transform: rotate(-90deg);
        opacity: 0.2;
    }

    .container {
        display: inline-block;
        position: absolute;
        width: 100%;
        padding-bottom: 100%;
        vertical-align: middle;
        overflow: hidden;
        top: 0;
        left: 0;
    }


    @media (min-width: 320px) and (max-width: 349.98px) {
        .margin {
            margin-top: 30px;
        }

        .founta {
            font-size: 17px;
        }

        .img_size {
            height: 130px;
        }

        svg {
            display: inline-block;
            position: absolute;
            top: -100px;
            left: -15px;
            width: 300px;
            z-index: -1;
            transform: rotate(-90deg);
            opacity: 0.2;
        }

        .container {
            display: inline-block;
            position: absolute;
            width: 100%;
            padding-bottom: 100%;
            vertical-align: middle;
            overflow: hidden;
            top: 0;
            left: 0;
        }

        /* .header_fount {
            line-height: 45px;
        } */
    }

    @media (min-width: 350px) and (max-width: 369.98px) {
        .margin {
            margin-top: 30px;
        }

        .founta {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-size: 16px;
            display: flex;
            align-items: flex-end;
            text-align: center;
            color: #FFFFFF;
            transform: rotate(-0.22deg);
        }

        .img_size {
            height: 150px;
        }

        svg {
            display: inline-block;
            position: absolute;
            top: -150px;
            left: -15px;
            width: 300px;
            z-index: -1;
            transform: rotate(-90deg);
            opacity: 0.2;
        }

        .container {
            display: inline-block;
            position: absolute;
            width: 100%;
            padding-bottom: 100%;
            vertical-align: middle;
            overflow: hidden;
            top: 0;
            left: 0;
        }
    }

    @media (min-width: 370px) and (max-width: 399.98px) {
        .margin {
            margin-top: 30px;
        }

        .founta {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-size: 16px;
            display: flex;
            align-items: flex-end;
            text-align: center;
            color: #FFFFFF;
            transform: rotate(-0.22deg);
        }

        .img_size {
            height: 170px;
        }

        svg {
            display: inline-block;
            position: absolute;
            top: -170px;
            left: -15px;
            width: 300px;
            z-index: -1;
            transform: rotate(-90deg);
            opacity: 0.2;
        }

        .container {
            display: inline-block;
            position: absolute;
            width: 100%;
            padding-bottom: 100%;
            vertical-align: middle;
            overflow: hidden;
            top: 0;
            left: 0;
        }

        .img_resp {
            display: block;
            margin: auto;
        }

        .img_resp1 {
            float: right;
        }

        /* .header_fount {
            line-height: 45px;
        } */
    }

    @media (min-width: 400px) and (max-width: 449.98px) {
        .margin {
            margin-top: 30px;
        }

        /* .header_fount {
            line-height: 45px;
        } */

        .founta {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-size: 20px;
            display: flex;
            align-items: flex-end;
            text-align: center;
            color: #FFFFFF;
            transform: rotate(-0.22deg);
        }

        .img_size {
            height: 190px;
        }

        svg {
            display: inline-block;
            position: absolute;
            top: -204px;
            left: -15px;
            width: 315px;
            z-index: -1;
            transform: rotate(-90deg);
            opacity: 0.2;
        }

        .container {
            display: inline-block;
            position: absolute;
            width: 100%;
            padding-bottom: 100%;
            vertical-align: middle;
            overflow: hidden;
            top: 0;
            left: 0;
        }

        .img_resp {
            display: block;
            margin: auto;
        }

        .img_resp1 {
            float: right;
        }
    }

    /* // Extra small devices (portrait phones, less than 576px) */
    @media (min-width: 450px) and (max-width: 499.98px) {
        .margin {
            margin-top: 30px;
        }

        .founta {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-size: 20px;
            display: flex;
            align-items: flex-end;
            text-align: center;
            color: #FFFFFF;
            transform: rotate(-0.22deg);
        }
    }

    @media (min-width: 500px) and (max-width: 539.98px) {
        .margin {
            margin-top: 30px;
        }

        .founta {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-size: 22px;
            display: flex;
            align-items: flex-end;
            text-align: center;
            color: #FFFFFF;
            transform: rotate(-0.22deg);
        }
    }

    @media (min-width: 540px) and (max-width: 574.98px) {
        .margin {
            margin-top: 30px;
        }

        .founta {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-size: 24px;
            display: flex;
            align-items: flex-end;
            text-align: center;
            color: #FFFFFF;
            transform: rotate(-0.22deg);
        }
    }

    @media (min-width: 575px) and (max-width: 599.98px) {
        .margin {
            margin-top: 30px;
        }

        .founta {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-size: 26px;
            display: flex;
            align-items: flex-end;
            text-align: center;
            color: #FFFFFF;
            transform: rotate(-0.22deg);
        }
    }

    @media (min-width: 600px) and (max-width: 644.98px) {
        .margin {
            margin-top: 30px;
        }

        .founta {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-size: 26px;
            display: flex;
            align-items: flex-end;
            text-align: center;
            color: #FFFFFF;
            transform: rotate(-0.22deg);
        }
    }

    @media (min-width: 645px) and (max-width: 699.98px) {
        .margin {
            margin-top: 30px;
        }
    }

    @media (min-width: 700px) and (max-width: 749.98px) {
        .margin {
            margin-top: 30px;
        }

        /* .header_fount {
            line-height: 45px;
            margin-top: -8px;
        } */
    }

    @media (min-width: 750px) and (max-width: 768.98px) {
        .margin {
            margin-top: 30px;
        }

        /* .header_fount {
            line-height: 45px;
            margin-top: -8px;
        } */
    }

    @media (min-width: 768px) and (max-width: 799.98px) {
        .margin {
            margin-top: 30px;
        }

        /* .header_fount {
            line-height: 45px;
            margin-top: -8px;
        } */
    }

    @media (min-width: 800px) and (max-width: 849.98px) {
        .margin {
            margin-top: 30px;
        }
    }

    @media (min-width: 850px) and (max-width: 899.98px) {
        .margin {
            margin-top: 30px;
        }
    }

    @media (min-width: 900px) and (max-width: 949.98px) {
        .margin {
            margin-top: 30px;
        }

        /* .header_fount {
            font-size: 26px;
        } */
    }

    @media (min-width: 950px) and (max-width: 991.98px) {
        .margin {
            margin-top: 30px;
        }

        /* .header_fount {
            font-size: 26px;
        } */
    }

    @media (min-width: 992px) and (max-width: 999.98px) {
        .founta {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-size: 22px;
            display: flex;
            align-items: flex-end;
            text-align: center;
            color: #FFFFFF;
            transform: rotate(-0.22deg);
        }

        /* .header_fount {
            font-size: 26px;
        } */
    }

    @media (min-width: 1000px) and (max-width: 1049.98px) {
        .founta {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-size: 22px;
            display: flex;
            align-items: flex-end;
            text-align: center;
            color: #FFFFFF;
            transform: rotate(-0.22deg);
        }

        /* .header_fount {
            font-size: 26px;
        } */
    }

    @media (min-width: 1050px) and (max-width: 1057.98px) {
        .founta {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-size: 22px;
            display: flex;
            align-items: flex-end;
            text-align: center;
            color: #FFFFFF;
            transform: rotate(-0.22deg);
        }

        /* .header_fount {
            font-size: 26px;
        } */
    }

    @media (min-width: 1058px) and (max-width: 1099.98px) {
        .founta {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-size: 22px;
            display: flex;
            align-items: flex-end;
            text-align: center;
            color: #FFFFFF;
            transform: rotate(-0.22deg);
        }

        /* .header_fount {
            font-size: 26px;
        } */
    }

    @media (min-width: 1100px) and (max-width: 1149.98px) {
        .founta {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-size: 25px;
            display: flex;
            align-items: flex-end;
            text-align: center;
            color: #FFFFFF;
            transform: rotate(-0.22deg);
        }

        /* .header_fount {
            font-size: 26px;
        } */
    }

    @media (min-width: 1150px) and (max-width: 1199.98px) {
        .founta {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-size: 25px;
            display: flex;
            align-items: flex-end;
            text-align: center;
            color: #FFFFFF;
            transform: rotate(-0.22deg);
        }

        /* .header_fount {
            font-size: 26px;
        } */
    }

    @media (min-width: 1200px) and (max-width: 1249.98px) {
        .founta {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-size: 25px;
            display: flex;
            align-items: flex-end;
            text-align: center;
            color: #FFFFFF;
            transform: rotate(-0.22deg);
        }
    }

    @media (min-width: 1250px) and (max-width: 1259.98px) {
        .founta {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 700;
            font-size: 25px;
            display: flex;
            align-items: flex-end;
            text-align: center;
            color: #FFFFFF;
            transform: rotate(-0.22deg);
        }
    }

    a:hover {
        text-decoration: none;
    }

    /*  */
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
                                <img src="MP_Img\108.png" alt="108 Logo" height="76" class="img_resp">
                            </div>
                            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-8 col-sm-8 col-12 ">
                                <div class="" style="padding-top: 10px;">
                                    <lable class="header_fount">Integrated Referral Transport System [ IRTS ] 108
                                    </lable>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-2 col-sm-2 col-6">
                                <img src="MP_Img\RED.png" alt="RED" height="72" class="img_white">
                            </div>
                            <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-2 col-sm-2 col-6 mx-auto">
                                <img src="MP_Img\Char.png" alt="Image" height="76" class="img_resp1">
                            </div>
                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12 mx-auto">
                                <img src="MP_Img\PM.png" alt="Image" height="76" class="img_resp">
                            </div>

                        </div>
                    </div> -->

                    <!-- Enter Main Content -->

                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-5" style="padding-top: 20px;">
                        <div class="">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">

                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12  ">
                                        <a href="{base_url}erc_dashboards/integrated_call_center">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 boxx1_color"
                                                style="height: 300px;">
                                                <div class="row">
                                                    <div
                                                        class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_center">
                                                        <img src="..\assets\images\Tech_call.png" alt="Technical Call"
                                                            height="220">
                                                    </div>
                                                    <div
                                                        class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">

                                                        <div class=" founta">
                                                            <svg viewBox="0 0 500 500"
                                                                preserveAspectRatio="xMinYMin meet">
                                                                <path
                                                                    d="M0, 350 C350, 800 350,50 500, 3 L500, 00 L00, 0 Z"
                                                                    style="stroke:none; fill:#ffffff;">
                                                                </path>
                                                            </svg>
                                                            <div
                                                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <lable class="">108 Integrated Call Center </lable>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>


                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 margin">
                                        <a href="{base_url}erc_dashboards/sanjeevani_service">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 boxx2_color"
                                                style="height: 300px;">
                                                <div class="row">
                                                    <div
                                                        class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_center mt-4">
                                                        <img class="img_size" src="..\assets\images\ambu.png"
                                                            alt="Ambulance" height="180">
                                                    </div>

                                                    <div
                                                        class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">

                                                        <div class="founta founta1">
                                                            <svg viewBox="0 0 500 500"
                                                                preserveAspectRatio="xMinYMin meet">
                                                                <path
                                                                    d="M0, 350 C350, 800 350,50 500, 3 L500, 00 L00, 0 Z"
                                                                    style="stroke:none; fill:#ffffff;">
                                                                </path>
                                                            </svg>
                                                            <div
                                                                class=" col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                                <lable class="">
                                                                    <lable class="">Sanjeevani -108 </lable><br>
                                                                    <lable class="">Emergency Medical Ambulance Service
                                                                    </lable>
                                                                </lable>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 "
                                        style="padding-top: 30px;">
                                        <a href="{base_url}erc_dashboards/janani_express_service">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 boxx3_color"
                                                style="height: 300px;">
                                                <div class="row">
                                                    <div
                                                        class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_center mt-2">
                                                        <img src="..\assets\images\ambufront.png" alt="Ambulance"
                                                            height="210">
                                                    </div>

                                                    <div
                                                        class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                        <div class="founta ">
                                                            <svg viewBox="0 0 500 500"
                                                                preserveAspectRatio="xMinYMin meet">
                                                                <path
                                                                    d="M0, 350 C350, 800 350,50 500, 3 L500, 00 L00, 0 Z"
                                                                    style="stroke:none; fill:#ffffff;">
                                                                </path>
                                                            </svg>
                                                            <div
                                                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="margin-top:-10px;">
                                                                <lable class="">
                                                                    <lable class="">Janani Express</lable> <br>
                                                                    <lable class="">Referral Transport Service Under
                                                                        JSSK</lable>
                                                                </lable>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-3"
                                        style="padding-top: 30px;">
                                        <a href="{base_url}erc_dashboards/helpline_service">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 boxx4_color"
                                                style="height: 300px;">
                                                <div class="row">
                                                    <div
                                                        class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_center">
                                                        <img src="..\assets\images\Sick_1.png" alt="Helpline"
                                                            height="220">
                                                    </div>

                                                    <div
                                                        class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                        <div class="founta">
                                                            <svg viewBox="0 0 500 500"
                                                                preserveAspectRatio="xMinYMin meet">
                                                                <path
                                                                    d="M0, 350 C350, 800 350,50 500, 3 L500, 00 L00, 0 Z"
                                                                    style="stroke:none; fill:#ffffff;">
                                                                </path>
                                                            </svg>
                                                            <div
                                                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <lable class=" ">104 Health Helpline</lable>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- End Enter Main Content -->
                </div>
            </div>



            <!-- Footer -->
            <!-- <footer class="page-footer font-small blue footer mt-4">

              
                <div class="container-fluid text-md-left">

                  
                    <div class="row">
                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3">
                            <div class="">
                                <img src="MP_Img\JAES.png" alt="JAES Logo" height="40">
                            </div>
                        </div>
                        <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-8 col-sm-6 col-6">

                        </div>
                        <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-2 col-sm-3 col-3 ">
                            <div class="">
                                <img src="MP_Img\spero.png" alt="Spero Logo" height="40">
                            </div>
                        </div>
                    </div> -->



            </footer>
            <!-- Footer -->

        </div>
    </div>

</body>

<script>

</script>



</html>