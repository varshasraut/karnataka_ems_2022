<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard</title>
    <script language="javascript" type="text/javascript"></script>
    <link href="CM.css" rel="stylesheet">

    <!-- Google Fonts Name :- Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600&family=Montserrat:wght@300;400;500&family=Permanent+Marker&display=swap" rel="stylesheet"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
    <!-- End Google Fonts Name :- Roboto -->

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


    <!-- Pie Chart -->

    <!-- End Pie Chart -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>


    <!-- Google Bar Chart -->


    <!-- End Google Bar Chart -->


    <!-- CSS -->

  <style>
   .bg_shadoBox {
    background: #FFFFFF;
    box-shadow: 0px 5px 15px rgba(137, 137, 137, 0.5);
    border-radius: 10px;
}

.text_center {
    text-align: center;
}

.red {
    background: #2f419b;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.25);
    transform: matrix(1, 0, 0, 1, 0, 0);
    position: absolute;
}

.fount_dash {
    font-family: "Roboto";
    font-style: normal;
    font-weight: 600;
    font-size: 40px;
    line-height: 47px;
    display: flex;
    align-items: flex-end;

    color: #ffffff;

    transform: rotate(-0.22deg);
    padding-left: 50px;
}



.logo_spero {
    width: 60;
    height: 60;
    position: fixed;
    top: 0px;
}

.spase_padding {
    padding-top: 60px;
}

.spase_padding2 {
    padding-top: 15px;
}

.coll_block {
    background: linear-gradient(90deg, #F7757D 0%, #FC3A97 100%);
    border-radius: 10px 10px 0px 0px;
}

.bg_ {
    background: linear-gradient(90deg, #ff896e 0%, #ff6879 100%);
    border-radius: 10px 10px 0px 0px;
}

.bg_LiveAmbulanceStatus {
    background: linear-gradient(90.01deg, #FC5339 0.01%, #DF2773 99.5%);
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 10px 10px 0px 0px;
}

.Ambulance_Dispatch_block {
    background: linear-gradient(90.01deg, #c52bb8 0.01%, #7579fd 99.5%);
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 10px 10px 0px 0px;
}

.Emergency_Patient_Served_block {
    background: linear-gradient(90.01deg, #F28C73 0.01%, #AD5A8A 99.5%);
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 10px 10px 0px 0px;
}

.bg_Ambulance {
    background: linear-gradient(170.01deg, #12CFB3 0.01%, #03AEBE 99.5%);
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 10px 10px 0px 0px;
}

.bg_Agent_List {
    background: linear-gradient(90.01deg, #3F7CFE 0.01%, #43E5D0 99.5%);
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 10px 10px 0px 0px;
}

.Dispatch_Status_block {
    background: linear-gradient(90deg, #43cfce 0%, #5ca2de 100%);
    border-radius: 10px 10px 0px 0px;
}

.collpadding {
    padding: 0px 0px 0px 14px;
}

.iconcirclepading {
    padding: 10px;
}

.icon-shape {
    width: 48px;
    height: 48px;
    color: #fff;
    background-position: center;
    border-radius: 0.75rem;
}

.bg-gradient-dangerPhysiotherapy1 {
    background: #5b93ff;
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 50px;
}

.bg-gradient-coll {
    background: linear-gradient(180deg, #F7757D 0%, #FC3B97 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 50px;
}

.bg_LiveAmbulanceStatuslo {
    background: linear-gradient(180deg, #FC5339 0%, #E1357C 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 50px;
}

.bg_Utilization_Per_DayPer {
    background: linear-gradient(180deg, #FF6879 0%, #FF896E 100%);
    box-shadow: 0px 10px 60px rgba(236, 236, 237, 0.5);
    border-radius: 10px;
}

.bg_Average_Rural_Response_Time {
    background: linear-gradient(180deg, #CC81DF 0%, #9867A9 100%);
    box-shadow: 0px 10px 60px rgba(236, 236, 237, 0.5);
    border-radius: 10px;
}

.bg_Average_Urban_Response_Time {
    background: linear-gradient(180deg, #57BED1 0%, #5D9FDF 100%, #1B73A1 100%);
    box-shadow: 0px 10px 60px rgba(236, 236, 237, 0.5);
    border-radius: 10px;
}

.bg-gradient-Ambulance_Dispatch {
    background: linear-gradient(180deg, #dc52cf 0%, #7279fd 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 50px;
}

.bg-Emergency_Patient_Served {
    background: linear-gradient(180deg, #F28C73 0%, #AD5A8A 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 50px;
}

.bg-gradient-Dispatch_Status {
    background: linear-gradient(180deg, #43eeac 0%, #09afe9 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 50px;
}

.bg-gradient_Ambulance {
    background: linear-gradient(360deg, #03AFBE -1.22%, #12CFB3 101.22%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 50px;
}

.bg-gradient_Login_Agent {
    background: linear-gradient(180deg, #45E5D0 0%, #3F7CFE 100%);
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 10px 10px 0px 0px;
}

.text-center {
    text-align: center !important;
}

.rounded-circle,
.avatar.rounded-circle img {
    border-radius: 50% !important;
}



.white {
    color: #ffffff;
}

.whiteText {
    font-family: 'Roboto';
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    color: #FFFFFF;
}

.coll_title_lable {
    font-family: "Roboto";
    font-style: normal;
    font-weight: 600;
    font-size: 15px;
    line-height: 18px;
    color: #444343;
}

.coll_num_lable {
    font-family: "Inter";
    font-style: normal;
    font-weight: 600;
    font-size: 19px;
    line-height: 27px;
    color: #444343;
}

.coll_num_lable_large {
    font-family: "Inter";
    font-style: normal;
    font-weight: 600;
    font-size: 30px;
    line-height: 35px;

    color: #fff;
}

.bg_colo {
    background: #f5f5f5;
}

.bg_box {
    background: #ffffff;
    box-shadow: 0px 10px 50px rgba(236, 236, 237, 0.5);
    border-radius: 10px 10px 10px 10px;
}

.lable_Dispatch_Status {
    font-family: "Roboto";
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 15px;
    padding-left: 18px;
    padding-top: 10px;
    color: #444343;
}

.bg_color_Dispatch {
    background: linear-gradient(90deg, #27d9e4 0%, #5d9fdf 100%);
    box-shadow: 0px 10px 60px rgba(236, 236, 237, 0.5);
    border-radius: 4px;
}

.bg_color_StartFromBase {
    background: linear-gradient(90deg, #cf6cef 0%, #7f62ed 100%);
    box-shadow: 0px 11px 60px rgba(236, 236, 237, 0.5);
    border-radius: 4px;
}

.bg_color_AtScene {
    background: linear-gradient(90deg, #3fd696 0%, #38aeaf 100%);
    box-shadow: 0px 10px 60px rgba(236, 236, 237, 0.5);
    border-radius: 4px;
}

.bg_color_AtDestination {
    background: linear-gradient(90deg, #2dc2da 0%, #2e83c2 100%);
    box-shadow: 0px 10px 60px rgba(236, 236, 237, 0.5);
    border-radius: 4px;
}

.bg_color_BackToBase {
    background: linear-gradient(90deg, #f66099 0%, #c749a5 100%);
    border-radius: 4px;
}

.text_align_right {
    text-align: right;
    color: #fff;
    font-family: "Roboto";
    font-weight: 600;
    font-size: 16px;
}

.bordar_search {
    border-radius: 13px;
}

.iconambulance {
    /* position: absolute; */
    width: 45px;
    height: 45px;
}

.lable_col {
    font-family: "Roboto";
    font-style: normal;
    font-weight: 600;
    font-size: 22px;
    line-height: 33px;
    padding-top: 18px;

    color: #ffffff;
}

/* chart  */
.canvas-con {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 365px;
    position: relative;
}

p {
    position: relative;
    left: 194px;
    margin-top: 64px;
}

.canvas-con-inner {
    height: 100%;
}

.canvas-con-inner,
.legend-con {
    display: inline-block;
}

.legend-con {
    font-family: Roboto;
    display: inline-block;
}

ul {
    list-style: none;
}

li {
    display: flex;
    align-items: center;
    margin-bottom: 4px;
}

span {
    display: inline-block;
}

span.chart-legend {
    width: 25px;
    height: 25px;
    margin-right: 10px;
}



/* End Chart */
.bg_button_export {
    background: linear-gradient(180deg, #31d9bd 0%, #04c7a6 100%);
    border-radius: 10px;
    transform: rotate(0deg);
    font-family: "Roboto";
    font-style: normal;
    font-weight: 700;
    font-size: 20px;
    /* line-height: 24px; */
    /* or 120% */

    color: #ffffff;
}



.map_size {
    width: 610px;
    height: 420px;
}

.text_center1 {
    text-align: center;
}

.box {
    position: absolute;
    width: 34.42px;
    height: 34.42px;
    left: 0px;
    top: 5px;
    background: linear-gradient(180deg, #43eeac 1.32%, #1ec6d3 100%);
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 6px;
}

@media (min-width: 320px) and (max-width: 374.98px) {}

@media (min-width: 375px) and (max-width: 425.98px) {}

@media (min-width: 300px) and (max-width: 349.98px) {
    .pie_align {
        margin-left: 30px;
    }

    .pie2_align {
        margin-left: 30px;
    }

    .coll_Padding {
        padding-top: 22px;
    }

    .coll_Padding1 {
        padding-top: 15px;
    }

    .box {
        position: absolute;
        width: 34.42px;
        height: 34.42px;
        left: 40px;
        top: 30px;
        background: linear-gradient(180deg, #43eeac 1.32%, #1ec6d3 100%);
        box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
    }
}

@media (min-width: 320px) and (max-width: 399.98px) {
    .pie_align {
        margin-left: 0px;
    }

    .pie2_align {
        margin-left: 0px;
    }

    .coll_Padding {
        padding-top: 22px;
    }

    .coll_Padding1 {
        padding-top: 15px;
    }

    .box {
        position: absolute;
        width: 34.42px;
        height: 34.42px;
        left: 40px;
        top: 30px;
        background: linear-gradient(180deg, #43eeac 1.32%, #1ec6d3 100%);
        box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
    }
    
    .mar2{
        margin-top: 50px;
    }
}

@media (min-width: 400px) and (max-width: 449.98px) {
    .pie_align {
        margin-left: 35px;
    }

    .pie2_align {
        margin-left: 35px;
    }

    .coll_Padding {
        padding-top: 22px;
    }

    .coll_Padding1 {
        padding-top: 15px;
    }

    .box {
        position: absolute;
        width: 34.42px;
        height: 34.42px;
        left: 50px;
        top: 30px;
        background: linear-gradient(180deg, #43eeac 1.32%, #1ec6d3 100%);
        box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
    }
    .mar{
        margin-left: 0px;
    }
    .mar2{
        margin-top: 50px;
    }
}

/* // Extra small devices (portrait phones, less than 576px) */
@media (min-width: 450px) and (max-width: 499.98px) {
    .pie_align {
        margin-left: 40px;
    }

    .pie2_align {
        margin-left: 40px;
    }

    .coll_Padding {
        padding-top: 22px;
    }

    .coll_Padding1 {
        padding-top: 15px;
    }

    .box {
        position: absolute;
        width: 34.42px;
        height: 34.42px;
        left: 90px;
        top: 30px;
        background: linear-gradient(180deg, #43eeac 1.32%, #1ec6d3 100%);
        box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
    }
    .mar{
        margin-left: 10px;
    }
    .mar2{
        margin-top: 50px;
    }
}

@media (min-width: 500px) and (max-width: 549.98px) {
    .pie_align {
        margin-left: 100px;
    }

    .pie2_align {
        margin-left: 120px;
    }

    .coll_Padding {
        padding-top: 22px;
    }

    .coll_Padding1 {
        padding-top: 15px;
    }

    .box {
        position: absolute;
        width: 34.42px;
        height: 34.42px;
        left: 110px;
        top: 30px;
        background: linear-gradient(180deg, #43eeac 1.32%, #1ec6d3 100%);
        box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
    }
    .mar{
        margin-left: 40px;
    }
    .mar2{
        margin-top: 50px;
    }
}

@media (min-width: 550px) and (max-width: 599.98px) {
    .pie_align {
        margin-left: 110px;
    }

    .pie2_align {
        margin-left: 140px;
    }

    .coll_Padding {
        padding-top: 22px;
    }

    .coll_Padding1 {
        padding-top: 15px;
    }

    .box {
        position: absolute;
        width: 34.42px;
        height: 34.42px;
        left: 140px;
        top: 30px;
        background: linear-gradient(180deg, #43eeac 1.32%, #1ec6d3 100%);
        box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
    }
    .mar{
        margin-left: 40px;
    }
    .mar2{
        margin-top: 50px;
    }
}

@media (min-width: 600px) and (max-width: 649.98px) {
    .pie_align {
        margin-left: 120px;
    }

    .pie2_align {
        margin-left: 140px;
    }

    .coll_Padding {
        padding-top: 22px;
    }

    .coll_Padding1 {
        padding-top: 15px;
    }

    .box {
        position: absolute;
        width: 34.42px;
        height: 34.42px;
        left: 140px;
        top: 30px;
        background: linear-gradient(180deg, #43eeac 1.32%, #1ec6d3 100%);
        box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
    }
    .mar{
        margin-left: 40px;
    }
    .mar2{
        margin-top: 50px;
    }
}

@media (min-width: 650px) and (max-width: 699.98px) {
    .pie_align {
        margin-left: 150px;
    }

    .pie2_align {
        margin-left: 180px;
    }

    .coll_Padding {
        padding-top: 22px;
    }

    .coll_Padding1 {
        padding-top: 15px;
    }

    .box {
        position: absolute;
        width: 34.42px;
        height: 34.42px;
        left: 180px;
        top: 30px;
        background: linear-gradient(180deg, #43eeac 1.32%, #1ec6d3 100%);
        box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
    }
    .mar{
        margin-left: 40px;
    }
    .mar2{
        margin-top: 50px;
    }
}

@media (min-width: 700px) and (max-width: 749.98px) {
    .pie_align {
        margin-left: 190px;
    }

    .pie2_align {
        margin-left: 210px;
    }

    .coll_Padding {
        padding-top: 22px;
    }

    .coll_Padding1 {
        padding-top: 15px;
    }

    .box {
        position: absolute;
        width: 34.42px;
        height: 34.42px;
        left: 180px;
        top: 30px;
        background: linear-gradient(180deg, #43eeac 1.32%, #1ec6d3 100%);
        box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
    }
    .mar{
        margin-left: 40px;
    }
    .mar2{
        margin-top: 50px;
    }
}

@media (min-width: 750px) and (max-width: 768.98px) {
    .coll_Padding {
        padding-top: 22px;
    }

    .coll_Padding1 {
        padding-top: 15px;
    }

    .box {
        position: absolute;
        width: 34.42px;
        height: 34.42px;
        left: 180px;
        top: 30px;
        background: linear-gradient(180deg, #43eeac 1.32%, #1ec6d3 100%);
        box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
    }

    .pie_align {
        margin-left: 190px;
    }

    .pie2_align {
        margin-left: 210px;
    }
    .mar{
        margin-left: 40px;
    }
    .mar2{
        margin-top: 50px;
    }
}

@media (min-width: 768px) and (max-width: 799.98px) {
    .coll_Padding {
        padding-top: 22px;
    }

    .coll_Padding1 {
        padding-top: 15px;
    }

    .box {
        position: absolute;
        width: 34.42px;
        height: 34.42px;
        left: 60px;
        top: 30px;
        background: linear-gradient(180deg, #43eeac 1.32%, #1ec6d3 100%);
        box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
    }

    .pie_align {
        margin-left: 30px;
    }

    .pie2_align {
        margin-left: 30px;
    }
    .mar{
        margin-left: 40px;
    }
    .mar2{
        margin-top: 50px;
    }
}

@media (min-width: 800px) and (max-width: 849.98px) {
    .coll_Padding {
        padding-top: 22px;
    }

    .coll_Padding1 {
        padding-top: 15px;
    }

    .box {
        position: absolute;
        width: 34.42px;
        height: 34.42px;
        left: 75px;
        top: 30px;
        background: linear-gradient(180deg, #43eeac 1.32%, #1ec6d3 100%);
        box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
    }

    .pie_align {
        margin-left: 40px;
    }

    .pie2_align {
        margin-left: 40px;
    }
    .mar{
        margin-left: 40px;
    }
    .mar2{
        margin-top: 50px;
    }
}

@media (min-width: 850px) and (max-width: 899.98px) {
    .coll_Padding {
        padding-top: 22px;
    }

    .coll_Padding1 {
        padding-top: 15px;
    }

    .box {
        position: absolute;
        width: 34.42px;
        height: 34.42px;
        left: 75px;
        top: 30px;
        background: linear-gradient(180deg, #43eeac 1.32%, #1ec6d3 100%);
        box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
    }

    .pie_align {
        margin-left: 45px;
    }

    .pie2_align {
        margin-left: 40px;
    }
    .mar{
        margin-left: 40px;
    }
    .mar2{
        margin-top: 50px;
    }
}

@media (min-width: 900px) and (max-width: 949.98px) {
    .box {
        position: absolute;
        width: 34.42px;
        height: 34.42px;
        left: 75px;
        top: 30px;
        background: linear-gradient(180deg, #43eeac 1.32%, #1ec6d3 100%);
        box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
    }

    .coll_Padding {
        padding-top: 22px;
    }

    .coll_Padding1 {
        padding-top: 15px;
    }

    .pie_align {
        margin-left: 70px;
    }

    .pie2_align {
        margin-left: 85px;
    }
    .mar{
        margin-left: 40px;
    }
    .mar2{
        margin-top: 50px;
    }
}

@media (min-width: 950px) and (max-width: 991.98px) {
    .box {
        position: absolute;
        width: 34.42px;
        height: 34.42px;
        left: 75px;
        top: 30px;
        background: linear-gradient(180deg, #43eeac 1.32%, #1ec6d3 100%);
        box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
        border-radius: 6px;
    }

    .coll_Padding {
        padding-top: 22px;
    }

    .coll_Padding1 {
        padding-top: 15px;
    }

    .pie_align {
        margin-left: 70px;
    }

    .pie2_align {
        margin-left: 85px;
    }
    .mar{
        margin-left: 40px;
    }
    .mar2{
        margin-top: 50px;
    }
}

@media (min-width: 992px) and (max-width: 999.98px) {
    .pading_top1 {
        padding-top: 13px;
    }
    .mar{
        margin-left: 40px;
    }
    .mar1{
        margin-top: 50px;
    }
}

@media (min-width: 1000px) and (max-width: 1049.98px) {
    .pading_top1 {
        padding-top: 13px;
    }
    .mar{
        margin-left: 40px;
    }
    .mar1{
        margin-top: 50px;
    }
}

@media (min-width: 1050px) and (max-width: 1057.98px) {
    .pading_top1 {
        padding-top: 13px;
    }
    .mar{
        margin-left: 65px;
    }
    .mar1{
        margin-top: 50px;
    }
}

@media (min-width: 1058px) and (max-width: 1099.98px) {
    .mar{
        margin-left: 65px;
    }
    .mar1{
        margin-top: 50px;
    }
}

@media (min-width: 1100px) and (max-width: 1149.98px) {
    .mar{
        margin-left: 65px;
    }
    .mar1{
        margin-top: 50px;
    }
}

@media (min-width: 1150px) and (max-width: 1199.98px) {
    .mar{
        margin-left: 65px;
    }
    .mar1{
        margin-top: 50px;
    }
}

@media (min-width: 1200px) and (max-width: 1249.98px) {
    .pading_Live_ambu {
        padding-left: 20px;
    }

    .pading_top1 {
        padding-top: 13px;
    }
    .mar{
        margin-left: 10px;
    }
}

@media (min-width: 1250px) and (max-width: 1262.98px) {
    .pading_top1 {
        padding-top: 13px;
    }

    .pading_botom1 {
        padding-bottom: 15px;
    }
    .mar{
        margin-left: 15px;
    }
}

@media (min-width: 1263px) and (max-width: 1299.98px) {
    .pading_Live_ambu {
        padding-left: 20px;
    }
    .mar{
        margin-left: 25px;
    }
}

@media (min-width: 1300px) and (max-width: 1349.98px) {
    .pading_Live_ambu {
        padding-left: 20px;
    }
    .mar{
        margin-left: 25px;
    }
}

@media (min-width: 1350px) and (max-width: 1399.98px) {
    .pading_Live_ambu {
        padding-left: 20px;
    }
    .mar{
        margin-left: 40px;
    }
}

@media (min-width: 1400px) and (max-width: 1449.98px) {
    .pading_Live_ambu {
        padding-left: 20px;
    }
    .mar{
        margin-left: 40px;
    }
}

@media (min-width: 1450px) and (max-width: 1499.98px) {
    .pading_Live_ambu {
        padding-left: 20px;
    }
    .mar{
        margin-left: 50px;
    }
}

@media (min-width: 1500px) and (max-width: 1649.98px) {
    .pading_Live_ambu {
        padding-left: 20px;
    }
    .mar{
        margin-left: 55px;
    }
}

@media (min-width: 1650px) and (max-width: 1699.98px) {
    .pading_Live_ambu {
        padding-left: 20px;
    }
    .mar{
        margin-left: 78px;
    }
}



@media (min-width: 1700px) and (max-width: 1749.98px) {
    .pading_Live_ambu {
        padding-left: 20px;
    }
    .mar{
        margin-left: 85px;
    }
}

@media (min-width: 1750px) and (max-width: 1799.98px) {
    .pading_Live_ambu {
        padding-left: 20px;
    }
    .mar{
        margin-left: 85px;
    }
}

@media (min-width: 1800px) and (max-width: 1949.98px) {
    .mar{
        margin-left: 85px;
    }
}

@media (min-width: 1950px) and (max-width: 1999.98px) {
    .mar{
        margin-left: 100px;
    }
}



@media (min-width: 2000px) and (max-width: 2049.98px) {
    .mar{
        margin-left: 100px;
    }
}

@media (min-width: 2050px) and (max-width: 2099.98px) {
    .mar{
        margin-left: 100px;
    }
}

@media (min-width: 2100px) and (max-width: 2149.98px) {
    .mar{
        margin-left: 100px;
    }
}

@media (min-width: 2150px) and (max-width: 2199.98px) {
    .mar{
        margin-left: 100px;
    }
}

@media (min-width: 2200px) and (max-width: 2249.98px) {
    .mar{
        margin-left: 100px;
    }
}

@media (min-width: 2250px) and (max-width: 2299.98px) {
    .mar{
        margin-left: 100px;
    }
}   

@media (min-width: 2300px) and (max-width: 2349.98px) {
    .mar{
        margin-left: 100px;
    }
}

@media (min-width: 2350px) and (max-width: 2399.98px) {
    .mar{
        margin-left: 100px;
    }
}

@media (min-width: 2400px) and (max-width: 2449.98px) {
    .mar{
        margin-left: 100px;
    }
}

@media (min-width: 2450px) and (max-width: 2509.98px) {
    .mar{
        margin-left: 100px;
    }
}

@media (min-width: 2510px) and (max-width: 2559.98px) {
    .mar{
        margin-left: 100px;
    }
}
/* .hide{
    display:none;
} */
/* Export Button */
a:hover {
    text-decoration: none !important;
}

.dedcription-btn {
    width: 100%;
    position: relative;
    display: inline-block;
    border-radius: 30px;
    background-color: #fcfcfc;
    /* color: #ffa000; */
    color: #31d9bd;
    text-align: center;
    font-size: 18px;
    padding: 9px 0;
    transition: all 0.3s;
    padding-right: 40px;
    margin: 20px 5px;
    box-shadow: 0 3px 20px 0 rgba(0, 0, 0, 0.06);
}

.dedcription-btn .btn-icon {
    /* background-color: #ffa000; */
    background: linear-gradient(180deg, #31d9bd 0%, #04c7a6 100%);
    width: 92px;
    height: 45px;
    float: right;
    position: absolute;
    border-radius: 30px 30px 30px 0;
    right: 0px;
    top: 0px;
    transition: all 0.3s;
}

.name-descripeion {
    position: relative;
    z-index: 9999;
    font-family: "Roboto";
    font-style: normal;
    font-weight: 700;
    font-size: 20px;
    line-height: 24px;
}

.btn-icon::after {
    content: "";
    width: 0;
    height: 0;
    border-top: 45px solid #fcfcfc;
    border-right: 40px solid transparent;
    position: absolute;
    top: 0px;
    left: 0px;
}

.dedcription-btn:hover .btn-icon {
    width: 100%;
    border-radius: 30px;
}

.dedcription-btn:hover .btn-icon::after {
    display: none;
    opacity: 0.1;
}

.btn-icon i {
    position: absolute;
    right: 25px;
    top: 15px;
    color: #fff;
}

.dedcription-btn:hover {
    color: #fff !important;
}

.hover-box {
    display: flex;
    width: 100%;
    height: 100vh;
    justify-content: center;
    align-items: center;
}

.exportt {
    font-family: "Roboto";
    font-style: normal;
    font-weight: 700;
    font-size: 20px;
    line-height: 24px;
}

/* Export Button */

#pie-chart {
    height: 250px !important;
    width: 265px !important;
}

#myChart {
    height: 250px !important;
    width: 250px !important;
}

.map {
    height: 560px !important;
    width: 250px !important;
}


.circle_dot {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    /* the magic */
}

.circle_color1 {
    background: linear-gradient(180deg, #5DE7BB 0%, #2A9291 100%);
    border-radius: 100px;
}

.circle_color2 {
    background: linear-gradient(180deg, #4C87FC 0%, #29C5D6 100%);
    border-radius: 100px;
}

.circle_color3 {
    background: linear-gradient(180deg, #F583EE 0%, #7181FE 100%);
    border-radius: 100px;
}

.circle_color4 {
    background: linear-gradient(180deg, #3BE6B3 0%, #09AFE9 100%);
    border-radius: 100px;
}

.circle_color5 {
    background: linear-gradient(180deg, #FBB52E 0%, #F78554 100%);
    border-radius: 100px;
}

.circle_color6 {
    background: linear-gradient(180deg, #F66FBC 0%, #FC968F 100%);
    border-radius: 100px;
}


.agent_circle_bg1{
    background: linear-gradient(180deg, #CA5454 0%, #FB7474 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);      
}
.agent_circle_bg2{
    background: linear-gradient(180deg, #37B0AF 0%, #2EE1A8 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);     
}
.agent_circle_bg3{
    background: linear-gradient(180deg, #8462ED 0%, #C96BEF 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
}
.agent_circle_bg4{
    background: linear-gradient(180deg, #F38981 0%, #ECB166 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
}
.agent_circle_bg5{
    background: linear-gradient(180deg, #52479E 0%, #B89DE1 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
}
.agent_circle_bg6{
    background: linear-gradient(180deg, #5AA2DF 0%, #29D6E4 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
}
.agent_circle_bg7{
    background: linear-gradient(180deg, #8A08A5 0%, #DC427E 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
}
.agent_circle_bg8{
    background: linear-gradient(180deg, #00CEF7 0%, #1CD79D 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
}
.agent_circle_bg9{
    background: linear-gradient(180deg, #C737B0 0%, #EE8A74 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
}
.agent_circle_bg10{
    background: linear-gradient(180deg, #9A67F8 0%, #E7A2F4 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);

}
.circle_dot1 {
    /* width: 48px;
    height: 48px; */
    border-radius: 50%;
    margin-left: auto;
    margin-right: auto;
    left: 0;
    right: 0;
    text-align: center;
    box-sizing: border-box;
    position: absolute;
    width: 45px;
    height: 45px;
    top: -30px;

}

.Agent_fount1{
    font-family: 'Roboto';
    font-style: normal;
    font-weight: 500;
    font-size: 18px;
    line-height: 21px;
    /* identical to box height */
    color: #000000;
}
.Agent_fount2{
    font-family: 'Roboto';
    font-style: normal;
    font-weight: 700;
    font-size: 30px;
    line-height: 35px;

    color: #000000;
}
#pie-chart-this-month {
            height: 250px !important;
            width: 265px !important;
        }

        #pie-chart-today {
            height: 250px !important;
            width: 265px !important;
        }


.box2_bg {
    background: #FFFFFF;
    box-shadow: 4px 4px 10px 7px rgba(135, 135, 135, 0.05);
    border-radius: 10px;
} 
#pie_chart_this_month,#pie_chart_this_month_count,#pie_chart_today,#pie_chart_today_count{
    display: none;
}
  </style>


    <!-- End CSS -->
</head>

<body>
    <div>
        <div>
            <div class="container-fluid ">
                <!-- <div class="row">
                    <div class="col-lg-12 red">
                        <div class="row">
                            <div class="col-lg-10 ">
                                <div class="fount_dash">
                                    <lable>Dashboard</lable>  
                                </div> 
                            </div>                             
                            <div class="col-lg-2 ">
                                <div class="fount_dash">
                                    <i class="fa-solid fa-right-from-bracket"></i>  
                                </div> 
                            </div> 
                        </div>
                    </div>
                </div>  -->
                <!-- <div class="row">
                    <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-9 col-sm-6 col-6 ">
                       
                    </div>
                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-3 col-sm-6 col-6 ">
                          
                            <a class="dedcription-btn" href="#">
                                <span class="name-descripeion">Export</span>
                                <div class="btn-icon">
                                    <lable class="exportt"></lable>
                                    <i class="fa-solid fa-download"></i>              
                                </div>
                            </a>
                    </div>
                </div>    -->

                <div class="row p-3">
                    <div class="col-lg-6 col-sm-12 col-12 col-md-6 col-xl-5 col-xxl-5 p-2">
                        <div class="col-lg-12 col-sm-12 col-12 col-md-12 col-sm-12 col-12 col-xl-12 col-xxl-12 ">

                            <div class="row coll_block">
                                <div class="col-lg-2 col-sm-2 col-3 col-md-3 col-xl-2 col-xxl-2 ">
                                    <div class="iconcirclepading">
                                        <div
                                            class="icon icon-shape bg-gradient-coll shadow-danger text-center rounded-circle">
                                            <i class="fas fa-phone-volume p-3"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-9 col-sm-10 col-9 col-xl-10 col-xxl-10 lable_col">
                                    <div class=""style="margin-left: -10px;">
                                        <lable>Calls</lable>
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12  p-2 bg_box">
                                    <div class="row">
                                        <div class="col-lg-7 col-sm-12 col-md-12 col-12 col-xl-7 col-xxl-7">
                                            <div class="row">

                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12">
                                                    <div class="form-check pie_chart_radio">
                                                        <div class="row ">
                                                            <div class="col-lg-4 col-sm-4 col-md-4 col-4 col-xl-4 col-xxl-4">
                                                                <input class="form-check-input " type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="till_date" checked>
                                                                <label class="form-check-label" for="flexRadioDefault1">
                                                                    <b>Till Date</b>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-5 col-sm-4 col-md-4 col-4 col-xl-5 col-xxl-5 ">
                                                                <input class="form-check-input " value="this_month" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                                                <label class="form-check-label" for="flexRadioDefault2">
                                                                    <b>This Month</b>
                                                                </label>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-4 col-md-4 col-4 col-xl-3 col-xxl-3">
                                                                <input value="today" class="form-check-input " type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                                                <label class="form-check-label" for="flexRadioDefault2">
                                                                    <b>Today</b>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 col-xxl-12 mx-auto" id="pie_chart_till_date">

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 col-xxl-12 mx-auto">
                                                        <div class="  pie_align  ">
                                                            <canvas id="pie-chart"><?php echo $data['count_till_date']; ?></canvas>
                                                        </div>
                                                    </div>

                                                </div>
                                                
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 col-xxl-12 mx-auto hide" id="pie_chart_this_month">

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 col-xxl-12 mx-auto">
                                                        <div class="  pie_align  ">
                                                            <canvas id="pie-chart-this-month"><?php echo $data['count_till_date']; ?></canvas>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 col-xxl-12 mx-auto hide" id="pie_chart_today">

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 col-xxl-12 mx-auto">
                                                        <div class="  pie_align  ">
                                                            <canvas id="pie-chart-today"><?php echo $data['count_till_date']; ?></canvas>
                                                        </div>
                                                    </div>

                                                </div>    
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-xl-5 col-xxl-5 col-md-12 col-sm-12 col-12">

                                            <!-- pie_chart_till_date & count -->
                                            <div class="row pt-5" id="pie_chart_till_date_count">
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding">
                                                    <div class="box  "><i class="fas fa-phone-volume white p-2"></i></div>
                                                    <lable class="p-4 coll_title_lable ">Total Calls</lable>
                                                </div>
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding1">
                                                    <lable class="p-4 coll_num_lable"><span id="pei_chart_total_till_date"><?php echo $data['pei_chart_total_till_date']; ?></span></lable>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding">
                                                    <div class="box boxx_sigft"><i
                                                            class="fas fa-phone-volume white p-2"></i></div>
                                                    <lable class="p-4 coll_title_lable">Emergency Calls</lable>
                                                </div>
                                                
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding1">
                                                    <lable class="p-4 coll_num_lable"><span id="pei_chart_eme_till_date"><?php echo $data['pei_chart_eme_till_date']; ?></span></lable>
                                                </div>
                                                <br>
                                                <br>
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding">
                                                    <div class="box boxx_sigft"><i class="fas fa-phone-volume white p-2"></i></div>
                                                    <lable class="p-4 coll_title_lable">Non Emergency Calls</lable>
                                                </div>
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding1">
                                                    <lable class="p-4 coll_num_lable"><span id="pei_chart_non_eme_till_date"><?php echo $data['pei_chart_non_eme_till_date']; ?></span></lable>
                                                </div>
                                                <br>
                                                <br>
                                            </div>
                                            <!-- pie_chart_till_date & count -->

                                            <!-- pie_chart_this_month & count -->
                                            <div class="row pt-5 hide" id="pie_chart_this_month_count">
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding">
                                                    <div class="box  "><i class="fas fa-phone-volume white p-2"></i></div>
                                                    <lable class="p-4 coll_title_lable ">Total Calls</lable>
                                                </div>
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding1">
                                                    <lable class="p-4 coll_num_lable"><span id="pei_chart_total_today_till_month"><?php echo $data['pei_chart_total_today_till_month']; ?></lable>
                                                </div>
                                                <br>
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding">
                                                    <div class="box boxx_sigft"><i
                                                            class="fas fa-phone-volume white p-2"></i></div>
                                                    <lable class="p-4 coll_title_lable">Emergency Calls</lable>
                                                </div>
                                                
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding1">
                                                    <lable class="p-4 coll_num_lable"><span id="pei_chart_eme_today_till_month"><?php echo $data['pei_chart_eme_today_till_month']; ?></span></lable>
                                                </div>
                                                <br>
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding">
                                                    <div class="box boxx_sigft"><i class="fas fa-phone-volume white p-2"></i></div>
                                                    <lable class="p-4 coll_title_lable">Non Emergency Calls</lable>
                                                </div>
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding1">
                                                    <lable class="p-4 coll_num_lable"><span id="pei_chart_non_eme_till_month"><?php echo $data['pei_chart_non_eme_till_month']; ?></span></lable>
                                                </div>
                                                <br>
                                            </div>
                                            <!-- <div class="row pt-5 hide" id="pie_chart_this_month_count">
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding">
                                                    <div class="box  "><i class="fas fa-phone-volume white p-2"></i></div>
                                                    <lable class="p-4 coll_title_lable ">Total Calls</lable>
                                                </div>
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding1">
                                                    <lable class="p-4 coll_num_lable"><span id="pei_chart_total_today_till_month"><?php echo $data['pei_chart_total_today_till_month']; ?></span></lable>
                                                </div> 
                                                <br>
                                                <br>
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding">
                                                    <div class="box boxx_sigft"><i class="fas fa-phone-volume white p-2"></i></div>
                                                    <lable class="p-4 coll_title_lable">Emergency Calls</lable>
                                                </div>
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding1">
                                                    <lable class="p-4 coll_num_lable"><span id="pei_chart_eme_today_till_month"><?php echo $data['pei_chart_eme_today_till_month']; ?></span></lable>
                                                </div> 
                                                <br>    
                                                <br>
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding">
                                                    <div class="box boxx_sigft"><i class="fas fa-phone-volume white p-2"></i></div>
                                                    <lable class="p-4 coll_title_lable">Non Emergency Calls</lable>
                                                </div>
                                                
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding1">
                                                    <lable class="p-4 coll_num_lable"><span id="pei_chart_non_eme_till_month"><?php echo $data['pei_chart_non_eme_till_month']; ?></span></lable>
                                                </div> 
                                                <br>
                                            </div> -->
                                            <!-- pie_chart_this_month & count -->

                                            <!-- pie_chart_today & count -->
                                            <div class="row pt-5 hide" id="pie_chart_today_count">
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding">
                                                    <div class="box  "><i class="fas fa-phone-volume white p-2"></i></div>
                                                    <lable class="p-4 coll_title_lable ">Total Calls</lable>
                                                </div>
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding1">
                                                    <lable class="p-4 coll_num_lable"><span id="pei_chart_total_today"><?php echo $data['pei_chart_total_today']; ?></span></lable>
                                                </div> 
                                                <br>
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding">
                                                    <div class="box boxx_sigft"><i class="fas fa-phone-volume white p-2"></i></div>
                                                    <lable class="p-4 coll_title_lable">Emergency Calls</lable>
                                                </div>

                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding1">
                                                    <lable class="p-4 coll_num_lable"><span id="pei_chart_eme_today"><?php echo $data['pei_chart_eme_today']; ?></span></lable>
                                                </div>
                                                <br>
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding">
                                                    <div class="box boxx_sigft"><i class="fas fa-phone-volume white p-2"></i></div>
                                                    <lable class="p-4 coll_title_lable">Non Emergency Calls</lable>
                                                </div>
                                                <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 text-center coll_Padding1">
                                                    <lable class="p-4 coll_num_lable"><span id="pei_chart_non_eme_today"><?php echo $data['pei_chart_non_eme_today']; ?></span></lable>
                                                </div> 
                                                <br>
                                            </div>
                                            <!-- pie_chart_today & count -->
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 col-12 col-xl-4 col-xxl-4 p-2">
                        <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 Ambulance_Dispatch_block">
                            <div class="row ">
                                <div class="col-lg-2 col-sm-2 col-md-2 col-3 col-xl-2 col-xxl-2">

                                    <div class="iconcirclepading">
                                        <div class="icon icon-shape bg-gradient-Ambulance_Dispatch shadow-danger text-center rounded-circle">
                                            <i class="fa-solid fa-truck-medical p-3"></i>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-10 col-sm-10 col-md-10 col-9 col-xl-10 col-xxl-10 lable_col">
                                    <lable>Ambulance Dispatch</lable>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 p-2  bg_box ">

                                <div class="row padding_map3  pading_top1  ">
                                    <div class="col-lg-4 col-sm-12 col-md-12 col-12 col-xl-4 col-xxl-4">
                                        <div class="row " style="padding-top: 15px;">
                                            <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12" style="padding-bottom: 20px;">
                                                <div class="text_center coll_title_lable">
                                                    <lable>Till Date</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12" style="padding-bottom: 2px;">
                                                <div class="text_center coll_num_lable">
                                                    <lable><span id="dispatch_till_date"><?php echo $data['dispatch_till_date']; ?></span></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-md-12 col-12 col-xl-4 col-xxl-4">
                                        <div class="row" style="padding-top: 15px;">
                                            <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12" style="padding-bottom: 20px;">
                                                <div class="text_center coll_title_lable">
                                                    <lable>This Month</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12"
                                                style="padding-bottom: 2px;">
                                                <div class="text_center coll_num_lable">
                                                    <lable><span id="eme_count_till_month"><?php echo $data['eme_count_till_month']; ?></span></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12 col-md-12 col-12 col-xl-4 col-xxl-4">
                                        <div class="row" style="padding-top: 15px;">
                                            <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12" style="padding-bottom: 20px;">
                                                <div class="text_center coll_title_lable">
                                                    <lable>Today</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12" style="padding-bottom: 2px;">
                                                <div class="text_center coll_num_lable">
                                                    <lable><span id="eme_count_today_date"><?php echo $data['eme_count_today_date']; ?></span></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                        

                        <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12 Emergency_Patient_Served_block">
                            <div class="row ">
                                <div class="col-lg-2 col-xl-2 col-sm-2 col-md-2 col-2 col-xxl-2">

                                    <div class="iconcirclepading">
                                        <div
                                            class="icon icon-shape bg-Emergency_Patient_Served shadow-danger text-center rounded-circle">
                                            <i class="fa-solid fa-truck-medical p-3"></i>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-10 col-xl-10 col-sm-10 col-md-10 col-10 col-xxl-10 lable_col">
                                    <lable>Emergency Patient Served</lable>
                                </div>
                            </div>
                        </div>


                        <div class=" ">
                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 p-2  bg_box">
                                <div class="row padding_map3 pading_top1">
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-12 col-sm-12 col-12 ">
                                        <div class="row" style="padding-top: 15px;">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12"
                                                style="padding-bottom: 20px;">
                                                <div class="text_center coll_title_lable">
                                                    <lable>Till Date</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12"
                                                style="padding-bottom: 2px;">
                                                <div class="text_center coll_num_lable">
                                                    <lable><span id="closure_till_date"><?php echo $data['closure_till_date']; ?></span></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-12 col-sm-12 col-12 ">
                                        <div class="row" style="padding-top: 15px;">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12"
                                                style="padding-bottom: 20px;">
                                                <div class="text_center coll_title_lable">
                                                    <lable>This Month</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12"
                                                style="padding-bottom: 2px;">
                                                <div class="text_center coll_num_lable">
                                                    <lable><span id="closure_till_month"><?php echo $data['closure_till_month']; ?></span></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-12 col-sm-12 col-12">
                                        <div class="row" style="padding-top: 15px;">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12"
                                                style="padding-bottom: 20px;">
                                                <div class="text_center coll_title_lable">
                                                    <lable>Today</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12"
                                                style="padding-bottom: 2px;">
                                                <div class="text_center coll_num_lable">
                                                    <lable><span id="closure_today"><?php echo $data['closure_today']; ?></span></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6 col-xl-3 col-xxl-3 col-md-12 col-sm-12 col-12 p-2 mx-auto">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 col-xxl-12 Dispatch_Status_block">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-3 col-md-3 col-xl-3 col-xxl-3">

                                    <div class="iconcirclepading">
                                        <div
                                            class="icon icon-shape bg-gradient-Dispatch_Status shadow-danger text-center rounded-circle">
                                            <i class="fa-solid fa-truck-medical p-3"></i>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-9 col-xl-9 col-xxl-9 lable_col">
                                    <lable>Dispatch Status</lable>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-xl-12 col-md-12 col-xxl-12 col-sm-12 col-12 p-3 bg_box pt-4">
                            <div class="row padding_map2 pading_botom1 pt-2">
                                <div class="col-lg-6 col-xl-6 col-xxl-6 col-md-6 col-sm-6 col-6 p-2">
                                    <div class="lable_Dispatch_Status">
                                        <lable>Dispatch </lable>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-6 col-xxl-6 col-md-6 col-sm-6 col-6 p-2">
                                    <div class="bg_color_Dispatch text_align_right p-1">
                                        <lable><span id="count_today_dispatch"><?php echo $data['count_today_dispatch']; ?></span></lable>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-xl-6 col-xxl-6 col-md-6 col-sm-6 col-6 p-2">
                                    <div class="lable_Dispatch_Status">
                                        <lable>Start From Base</lable>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-6 col-xxl-6 col-md-6 col-sm-6 col-6 p-2">
                                    <div class="bg_color_StartFromBase text_align_right p-1">
                                        <lable><span id="start_frm_base"><?php echo $data['start_frm_base']; ?></span></lable>
                                    </div>
                                </div>


                                <div class="col-lg-6 col-xl-6 col-xxl-6 col-md-6 col-sm-6 col-6 p-2">
                                    <div class="lable_Dispatch_Status">
                                        <lable>At Scene</lable>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-6 col-xxl-6 col-md-6 col-sm-6 col-6 p-2">
                                    <div class="bg_color_AtScene text_align_right p-1">
                                        <lable><span id="at_scene"><?php echo $data['at_scene']; ?></lable>
                                    </div>
                                </div>


                                <div class="col-lg-6 col-xl-6 col-xxl-6 col-md-6 col-sm-6 col-6 p-2">
                                    <div class="lable_Dispatch_Status ">
                                        <lable>At Destination</lable>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-6 col-xxl-6 col-md-6 col-sm-6 col-6 p-2">
                                    <div class="bg_color_AtDestination  text_align_right p-1">
                                        <lable><span id="at_destination"><?php echo $data['at_destination']; ?></lable>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-xl-6 col-xxl-6 col-md-6 col-sm-6 col-6 p-2">
                                    <div class="lable_Dispatch_Status">
                                        <lable>Back To Base</lable>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-6 col-xxl-6 col-md-6 col-sm-6 col-6 p-2">
                                    <div class="bg_color_BackToBase text_align_right p-1">
                                        <lable><span id="back_to_base"><?php echo $data['back_to_base']; ?></span></lable>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-lg-12 col-xl-12 col-xxl-12 bg_box">                            
                        </div> -->
                    </div>


                </div>
                <div class="">
                    <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                        <div class="row">
                            <!-- <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-12 col-sm-12 col-12 p-2"> -->
                            <div class="col-lg-5 col-xl-5 col-xxl-5 col-md-12 col-sm-12 col-12 p-2">
                                <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 bg_box pb-3">
                                    <div class="row bg_Ambulance">
                                        <div class="col-lg-3 col-sm-3 col-3 col-md-3 col-xl-3 col-xxl-3 ">
                                            <div class="iconcirclepading">
                                                <div
                                                    class="icon icon-shape bg-gradient_Ambulance shadow-danger text-center rounded-circle">
                                                    <i class="fas fa-phone-volume p-3"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-9 col-xl-9 col-xxl-9 lable_col">
                                            <div style="margin-left: -50px;">
                                                <lable>Ambulance</lable>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-xl-8 col-xxl-8 col-md-6 col-sm-12 col-12 pt-3 mx-auto">                                       
                                        <div class=" pie2_align ml-5">
                                            <canvas id="myChart"></canvas>
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-6 col-sm-12 col-12 pt-2 mx-auto">                                      
                                        <div class=" pie2_align ">
                                            <canvas id="myChart"></canvas>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12  ">
                                    <div class="row pt-2 pb-3">

                                        <div
                                            class="col-lg-12 col-xl-12 col-xxl-12 col-md-9  col-sm-12 col-12 mx-auto bg_shadoBox mt-2">
                                            <a href="#">
                                                <div class="row">
                                                    <div class="col-lg-1 col-xl-1 col-xxl-1 col-md-1 col-sm-1 col-1 text-center coll_num_lable p-1">
                                                        <div class="circle_dot circle_color1 m-1"></div>
                                                    </div>
                                                    <div class="col-lg-8 col-xl-8 col-xxl-8 col-md-8 col-sm-8 col-8 lable_Dispatch_Status ">
                                                        <lable>Ambulance On Road</lable>
                                                    </div>
                                                    <div class="col-lg-3 col-xl-3 col-xxl-3 col-md-3 col-sm-3 col-3 text-center coll_num_lable p-1">
                                                        <lable><span id=""><?php echo $data['amb_available'] + $data['amb_busy']; ?></span></lable>
                                                    </div>
                                                </div>
                                            </a>

                                            <a href="#">
                                                <div class="row">
                                                    <div class="col-lg-1 col-xl-1 col-xxl-1 col-md-1 col-sm-1 col-1 text-center coll_num_lable p-1">
                                                        <div class="circle_dot circle_color2 m-1"></div>
                                                    </div>
                                                    <div class="col-lg-8 col-xl-8 col-xxl-8 col-md-8 col-sm-8 col-8 lable_Dispatch_Status ">
                                                        <lable>Ambulance Off Road</lable>
                                                    </div>
                                                    <div class="col-lg-3 col-xl-3 col-xxl-3 col-md-3 col-sm-3 col-3 text-center coll_num_lable p-1 text_center1">
                                                        <lable><span id="amb_maintainance"><?php echo $data['amb_maintainance']; ?></span></lable>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div
                                            class="col-lg-12 col-xl-12 col-xxl-12 col-md-9 col-sm-12 col-12 mx-auto bg_shadoBox mt-2">
                                            <a href="#">
                                                <div class="row">
                                                    <div class="col-lg-1 col-xl-1 col-xxl-1 col-md-1 col-sm-1 col-1 text-center coll_num_lable p-1">
                                                        <div class="circle_dot circle_color3 m-1"></div>
                                                    </div>
                                                    <div class="col-lg-8 col-xl-8 col-xxl-8 col-md-8 col-sm-8 col-8  lable_Dispatch_Status ">
                                                        <div >
                                                            <lable>Available Ambulance</lable>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-xl-3 col-xxl-3 col-md-3 col-sm-3 col-3 text-center coll_num_lable p-1">
                                                        <lable><span id="amb_available"><?php echo $data['amb_available']; ?></span></lable>
                                                    </div>
                                                </div>
                                            </a>

                                            <a href="#">
                                                <div class="row">
                                                    <div
                                                        class="col-lg-1 col-xl-1 col-xxl-1 col-md-1 col-sm-1 col-1 text-center coll_num_lable p-1">
                                                        <div class="circle_dot circle_color4 m-1"></div>
                                                    </div>
                                                    <div
                                                        class="col-lg-8 col-xl-8 col-xxl-8 col-md-8 col-sm-8 col-8  lable_Dispatch_Status ">
                                                        <lable>Busy Ambulance</lable>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 col-xl-3 col-xxl-3 col-md-3 col-sm-3 col-3 text-center coll_num_lable p-1">
                                                        <lable><span id="amb_busy"><?php echo $data['amb_busy']; ?></span></lable>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div
                                            class="col-lg-12 col-xl-12 col-xxl-12 col-md-9 col-sm-12 col-12 mx-auto bg_shadoBox mt-2">
                                            <a href="#">
                                                <div class="row">
                                                    <div
                                                        class="col-lg-1 col-xl-1 col-xxl-1 col-md-1 col-sm-1 col-1 text-center coll_num_lable p-1">
                                                        <div class="circle_dot circle_color5 m-1"></div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-4 col-sm-4 col-4  lable_Dispatch_Status ">
                                                        <lable>Sanjivani</lable>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-4 col-sm-4 col-4  lable_Dispatch_Status ">
                                                        <lable>ALS</lable>
                                                    </div>
                                                    <div class="col-lg-3 col-xl-3 col-xxl-3 col-md-3 col-sm-3 col-3 text-center coll_num_lable p-1">
                                                        <lable><span id="amb_als"><?php echo $data['amb_als']; ?></span></lable>
                                                    </div>
                                                </div>
                                            </a>

                                            <a href="#">
                                                <div class="row">
                                                    <div class="col-lg-5 col-xl-5 col-xxl-5 col-md-5 col-sm-5 col-5 text-center coll_num_lable p-1">
                                                        <!-- <div class="circle_dot circle_color6 m-1"></div> -->
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-4 col-sm-4 col-4  lable_Dispatch_Status ">
                                                        <lable>BLS </lable>
                                                    </div>
                                                    <div class="col-lg-3 col-xl-3 col-xxl-3 col-md-3 col-sm-3 col-3  text-center coll_num_lable p-1">
                                                        <lable><span id="amb_bls"><?php echo $data['amb_bls']; ?></span></lable>
                                                    </div>
                                                </div>
                                            </a>

                                            <a href="#">
                                                <div class="row">
                                                    <div
                                                        class="col-lg-1 col-xl-1 col-xxl-1 col-md-1 col-sm-1 col-1 text-center coll_num_lable p-1">
                                                        <div class="circle_dot circle_color6 m-1"></div>
                                                    </div>
                                                    <div
                                                        class="col-lg-8 col-xl-8 col-xxl-8 col-md-8 col-sm-8 col-8  lable_Dispatch_Status ">
                                                        <lable>Janani</lable>
                                                    </div>
                                                    <div
                                                        class="col-lg-3 col-xl-3 col-xxl-3 col-md-3 col-sm-3 col-3  text-center coll_num_lable p-1">
                                                        <lable><span id="amb_je"><?php echo $data['amb_je']; ?></span></lable>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>                                        
                                    </div>

                                </div>
                            </div>
                            <!-- <div class="col-lg-8 col-xl-6 col-xxl-6 col-md-12 col-sm-12 col-12 p-2"> -->
                            <div class="col-lg-7 col-xl-7 col-xxl-7 col-md-12 col-sm-12 col-12 p-2">
                                <div class="col-lg-12 col-xl-12 col-xxl-12 bg_box ">
                                    <div class="row bg_LiveAmbulanceStatus">
                                        <div class="col-lg-2 col-sm-12 col-md-3 col-12 col-xl-1 col-xxl-2 ">
                                            <div class="iconcirclepading">
                                                <div
                                                    class="icon icon-shape bg_LiveAmbulanceStatuslo shadow-danger text-center rounded-circle">
                                                    <i class="fa-solid fa-location-crosshairs p-3"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-sm-12 col-md-9 col-12 col-xl-6 col-xxl-5 lable_col ">
                                            <div class="pading_Live_ambu">
                                                <lable>Live Ambulance Status</lable>
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-4 col-sm-10 col-md-10 col-10 col-xl-4 col-xxl-4 lable_col"> -->
                                        <div class="col-lg-5 col-sm-11 col-md-11 col-11 col-xl-5 col-xxl-5 lable_col">
                                            <div class="">
                                                <!-- <input type="text" class="form-control bordar_search" placeholder="Search Ambulance" aria-label="Server"> -->
                                                <div class="">
                                                    <!--                                                <input type="text" class="form-control bordar_search" placeholder="Search Ambulance" aria-label="Server">-->
                                                    <select class="form-control bordar_search amb_type_dropdown" name="show_map">
                                                    <option value="ALL">ALL</option>
                                                        <option value="JE">JE</option>
                                                        <option value="ALS">ALS</option>
                                                        <option value="BLS">BLS</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- <div class="col-lg-1 col-sm-2 col-md-2 col-2 col-xl-1 col-xxl-1">
                                            <a href="#" class="white">
                                                <i class="fa fa-maximize " style="font-size: 25px; padding-top: 20px;"></i>
                                            </a>
                                        </div> -->
                                    </div>

                                    <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12  ">
                                        <!-- <div class="col-lg-12 col-sm-12 col-md-12 col-12 col-xl-12 col-xxl-12  padding_map"> -->
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 col-xxl-12 map">
                                                <div class="  "id="JE_map">
                                                    <iframe src="<?php echo base_url(); ?>erc_dashboards/map_amb_all" style="width:100%; height: 550px!important; border:0px;"scrolling="no"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <!-- <div class=""></div> -->
                            <!-- <div class="col-lg-12 col-xl-3 col-xxl-3 col-md-6 col-sm-12 col-12 p-2 mx-auto">

                                <div class="">

                                    <div class="col-lg-6 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mx-auto">
                                        <div class="row bg_Utilization_Per_DayPer padding_map4 ">
                                            <div
                                                class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 text-center ">
                                                <i class="fa fa-truck-medical white"
                                                    style="font-size: 45px; padding-top: 20px;"></i>
                                            </div>
                                            <div
                                                class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 text-center mt-4 whiteText">
                                                <lable>Utilization Per Day/Per Ambulance</lable><br>
                                                <lable>(May 2022)</lable>
                                            </div>
                                            <div
                                                class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 text-center mt-3 mb-3 coll_num_lable_large white">
                                                <lable>4.5</lable><br>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mx-auto"
                                        style="padding-top: 10px;">
                                        <div class="row bg_Average_Rural_Response_Time padding_map4 ">
                                            <div
                                                class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 text-center ">
                                                <i class="fa fa-truck-medical white"
                                                    style="font-size: 39px; padding-top: 20px;"></i>
                                            </div>
                                            <div
                                                class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 text-center mt-4 whiteText">
                                                <lable>Utilization Per Day/Per Ambulance</lable><br>
                                                <lable>(May 2022)</lable>
                                            </div>
                                            <div
                                                class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12  text-center mt-3 mb-3 coll_num_lable_large white">
                                                <lable>00:22:29</lable><br>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mx-auto"
                                        style="padding-top: 10px;">
                                        <div class="row bg_Average_Urban_Response_Time padding_map4 ">
                                            <div
                                                class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 text-center ">
                                                <i class="fa fa-truck-medical white"
                                                    style="font-size: 45px; padding-top: 20px;"></i>
                                            </div>
                                            <div
                                                class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 text-center mt-4 whiteText">
                                                <lable>Utilization Per Day/Per Ambulance</lable><br>
                                                <lable>(May 2022)</lable>
                                            </div>
                                            <div
                                                class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 text-center mt-3 mb-3 coll_num_lable_large white">
                                                <lable>00:22:29</lable><br>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div> -->
                        </div>
                    </div>
                </div>



                <!-- <div class="">
                    <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                        <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 p-2">
                            <div class="row">
                                <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12  pb-3">
                                    <div class="row bg_Agent_List">
                                        <div class="col-lg-1 col-sm-3 col-3 col-md-2 col-xl-1 col-xxl-1 ">
                                            <div class="iconcirclepading">
                                                <div
                                                    class="icon icon-shape bg-gradient_Login_Agent shadow-danger text-center rounded-circle">
                                                    <i class="fa-solid fa-user-group p-3"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-11 col-md-10 col-sm-9 col-9 col-xl-11 col-xxl-11 lable_col">
                                            <div style="margin-left: -25px;">
                                                <lable>Login Agent List</lable>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            

                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-5">
                                <div class="row mar">
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-3 text-center">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 ">
                                                <div class="circle_dot1 agent_circle_bg1 p-2">
                                                    <i class="fa-solid fa-user white fa-lg "></i>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>ERO</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-2">
                                                <div class="Agent_fount2">
                                                    <lable>32</lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-3 text-center">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg2 white p-2">
                                                    <i class="fa-solid fa-user-doctor fa-lg"></i>
                                                </div>
                                                <br>
                                            </div> 
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>DCO</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-2">
                                                <div class="Agent_fount2">
                                                    <lable>32</lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-3 mar2 text-center">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg3 white p-2">
                                                    <i class="fa-solid fa-user fa-lg "></i>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>PDA</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-2">
                                                <div class="Agent_fount2">
                                                    <lable>32</lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-3 mar2 text-center">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg4 white p-2">
                                                    <i class="fa-solid fa-user fa-lg "></i>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>FDA</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-2">
                                                <div class="Agent_fount2">
                                                    <lable>32</lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-3 mar2 text-center">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg5 white p-2">
                                                    <i class="fa-solid fa-user fa-lg "></i>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>ERCP</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-2">
                                                <div class="Agent_fount2">
                                                    <lable>32</lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-3 mar2 text-center mar1">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg6 white p-2">
                                                    <i class="fa-solid fa-rectangle-xmark fa-lg"></i>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>Grievance</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-2">
                                                <div class="Agent_fount2">
                                                    <lable>32</lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-3 mar2 text-center mar1">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg7 white p-2">
                                                    <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>Feedback</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-2">
                                                <div class="Agent_fount2">
                                                    <lable>32</lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5  col-md-5 col-xl-1 col-xxl-1 box2_bg ml-3 mar2 text-center mar1">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg8 white p-2">
                                                     <i class="fa-solid fa-circle-check fa-lg"></i>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>Quality</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-2">
                                                <div class="Agent_fount2">
                                                    <lable>32</lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-3 mar2 text-center mar1">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg9 white p-2">
                                                    <i class="fa-solid fa-users fa-lg"></i>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>TL</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-1">
                                                <div class="Agent_fount2">
                                                    <lable>32</lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-3 mar2 text-center mar1">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg10 white p-2">
                                                    <i class="fa-solid fa-user-tie fa-lg"></i>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>Managers</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-2">
                                                <div class="Agent_fount2">
                                                    <lable>32</lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div> -->




            </div>






        </div>
    </div>

</body>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>
    new Chart(document.getElementById("pie-chart"), {
        type: 'pie',
        data: {
            labels: ["Emergency Calls", "Non Emergency Calls"],
            datasets: [{
                label: "Population (millions)",
                backgroundColor: ["#3FDBEA", "#FFAB62"],
                data: [<?php echo $data['pei_chart_eme_till_date']; ?>, <?php echo $data['pei_chart_non_eme_till_date']; ?>]
            }]
        },
        options: {
            legend: {
                position: 'bottom',

            },
            title: {
                display: true,
                text: ''
            }
        }
    });

    new Chart(document.getElementById("pie-chart-this-month"), {
        type: 'pie',
        data: {
            labels: ["Emergency Calls", "Non Emergency Calls"],
            datasets: [{
                label: "Population (millions)",
                backgroundColor: ["#3FDBEA", "#FFAB62"],
                data: [<?php echo $data['pei_chart_eme_today_till_month']; ?>, <?php echo $data['pei_chart_non_eme_till_month']; ?>]
            }]
        },
        options: {
            legend: {
                position: 'bottom',

            },
            title: {
                display: true,
                text: ''
            }
        }
    });

    new Chart(document.getElementById("pie-chart-today"), {
        type: 'pie',
        data: {
            labels: ["Emergency Calls", "Non Emergency Calls"],
            datasets: [{
                label: "Population (millions)",
                backgroundColor: ["#3FDBEA", "#FFAB62"],
                data: [<?php echo $data['pei_chart_eme_today']; ?>, <?php echo $data['pei_chart_non_eme_today']; ?>]
            }]
        },
        options: {
            legend: {
                position: 'bottom',

            },
            title: {
                display: true,
                text: ''
            }
        }
    });
    Chart.pluginService.register({
        beforeDraw: function(chart) {
            if (chart.config.options.elements.center) {
                // Get ctx from string
                var ctx = chart.chart.ctx;

                // Get options from the center object in options
                var centerConfig = chart.config.options.elements.center;
                var fontStyle = centerConfig.fontStyle || 'Arial';
                var txt = centerConfig.text;
                var color = centerConfig.color || '#000';
                var maxFontSize = centerConfig.maxFontSize || 75;
                var sidePadding = centerConfig.sidePadding || 20;
                var sidePaddingCalculated = (sidePadding / 100) * (chart.innerRadius * 2)
                // Start with a base font of 30px
                ctx.font = "30px " + fontStyle;

                // Get the width of the string and also the width of the element minus 10 to give it 5px side padding
                var stringWidth = ctx.measureText(txt).width;
                var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

                // Find out how much the font can grow in width.
                var widthRatio = elementWidth / stringWidth;
                var newFontSize = Math.floor(30 * widthRatio);
                var elementHeight = (chart.innerRadius * 2);

                // Pick a new font size so it will not be larger than the height of label.
                var fontSizeToUse = Math.min(newFontSize, elementHeight, maxFontSize);
                var minFontSize = centerConfig.minFontSize;
                var lineHeight = centerConfig.lineHeight || 25;
                var wrapText = false;

                if (minFontSize === undefined) {
                    minFontSize = 20;
                }

                if (minFontSize && fontSizeToUse < minFontSize) {
                    fontSizeToUse = minFontSize;
                    wrapText = true;
                }

                // Set font settings to draw it correctly.
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
                var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
                ctx.font = fontSizeToUse + "px " + fontStyle;
                ctx.fillStyle = color;

                if (!wrapText) {
                    ctx.fillText(txt, centerX, centerY);
                    return;
                }

                var words = txt.split(' ');
                var line = '';
                var lines = [];

                // Break words up into multiple lines if necessary
                for (var n = 0; n < words.length; n++) {
                    var testLine = line + words[n] + ' ';
                    var metrics = ctx.measureText(testLine);
                    var testWidth = metrics.width;
                    if (testWidth > elementWidth && n > 0) {
                        lines.push(line);
                        line = words[n] + ' ';
                    } else {
                        line = testLine;
                    }
                }

                // Move the center up depending on line height and number of lines
                centerY -= (lines.length / 2) * lineHeight;

                for (var n = 0; n < lines.length; n++) {
                    ctx.fillText(lines[n], centerX, centerY);
                    centerY += lineHeight;
                }
                //Draw text in center
                ctx.fillText(line, centerX, centerY);
            }
        }
    });


    var config = {
        type: 'doughnut',
        data: {
            labels: ["JE Ambulance", "ALS Ambulance","BLS Ambulance"],
            datasets: [{
                data: [<?php echo $data['amb_je'] ?>, <?php echo $data['amb_als'] ?>, <?php echo $data['amb_bls'] ?>],
                backgroundColor: [
                    "#FF6384",
                    "#36A2EB",
                    "#FFCE56"
                ],
                hoverBackgroundColor: [
                    "#FF6384",
                    "#36A2EB",
                    "#FFCE56"
                ]
            }]
        },
        options: { legend: {
            display: false
         },
            elements: {
                center: {
                    text: 'Total Ambulance <?php echo $data['amb_total'] ?>',
                    color: '#000000',
                    fontStyle: 'Inter',

                }
            }
        }
    };

    var ctx = document.getElementById("myChart").getContext("2d");
    var myChart = new Chart(ctx, config);
</script>
<script type="text/javascript">
    $(document).ready(function() {

        // window.onload = erc_live_calls_dash_view();
        var refreshIntervalId = setInterval("cm_live_calls_dash_view()", 30000);
    });

    function cm_live_calls_dash_view() {
        //alert(base_url);
        $.ajax({

            type: 'POST',

            data: 'id=ss',

            cache: false,

            dataType: 'json',

            url: base_url + 'erc_dashboards/cm_live_calls_dash_view',

            success: function(result) {

                $("#amb_je").text(result.amb_je);
                $("#amb_als").text(result.amb_als);
                $("#amb_bls").text(result.amb_bls);

                $("#count_today").text(result.count_today);
                $("#closure_today").text(result.closure_today);
                $("#today_cases_closed").text(result.today_cases_closed);

                $("#eme_count_today_date").text(result.eme_count_today_date);
                $("#noneme_count_today_date").text(result.noneme_count_today_date);
                $("#amb_total").text(result.amb_total);
                $("#amb_available").text(result.amb_available);
                $("#amb_busy").text(result.amb_busy);
                $("#amb_on_road").text(result.amb_on_road);
                $("#amb_maintainance").text(result.amb_maintainance);

                $("#eme_count_till_month").text(result.eme_count_till_month);
                $("#dispatch_till_date").text(result.dispatch_till_date);
                $("#count_till_date").text(result.count_till_date);
                $("#count_till_month").text(result.count_till_month);
                $("#eme_count_till_date").text(result.eme_count_till_date);

                $("#noneme_count_till_date").text(result.noneme_count_till_date);
                $("#noneme_count_till_month").text(result.noneme_count_till_month);

                $("#count_today_dispatch").text(result.count_today_dispatch);
                $("#start_frm_base").text(result.start_frm_base);
                $("#at_scene").text(result.at_scene);
                $("#at_destination").text(result.at_destination);
                $("#back_to_base").text(result.back_to_base);
                $("#emt_present").text(result.emt_present);
                $("#pilot_present").text(result.pilot_present);

                $("#pei_chart_non_eme_today").text(result.noneme_count_today_date);
                $("#pei_chart_eme_today").text(result.eme_count_today_date);
                $("#pei_chart_total_today").text(result.count_today);

                $("#pei_chart_non_eme_till_date").text(result.noneme_count_till_date);
                $("#pei_chart_eme_till_date").text(result.eme_count_till_date);
                $("#pei_chart_total_till_date").text(result.count_till_date);

                $("#pei_chart_non_eme_till_month").text(result.noneme_count_till_month);
                $("#pei_chart_eme_today_till_month").text(result.eme_count_till_month);
                $("#pei_chart_total_today_till_month").text(result.count_till_month);
                


            }


        });

    }
    $('body').on("change", ".pie_chart_radio input[type='radio']", function() {
        $pie_chart_radio = $(".pie_chart_radio input[type='radio']:checked").val();

        if ($pie_chart_radio == 'this_month') {
            $("#pie_chart_this_month").show();
            $("#pie_chart_this_month_count").show();

            $("#pie_chart_till_date").hide();
            $("#pie_chart_till_date_count").hide();
            $("#pie_chart_today").hide();
            $("#pie_chart_today_count").hide();
        } else if ($pie_chart_radio == 'today') {
            $("#pie_chart_today").show();
            $("#pie_chart_today_count").show();

            $("#pie_chart_this_month").hide();
            $("#pie_chart_this_month_count").hide();
            $("#pie_chart_till_date").hide();
            $("#pie_chart_till_date_count").hide();

        } else if ($pie_chart_radio == 'till_date') {

            $("#pie_chart_till_date").show();
            $("#pie_chart_till_date_count").show();

            $("#pie_chart_this_month").hide();
            $("#pie_chart_this_month_count").hide();
            $("#pie_chart_today").hide();
            $("#pie_chart_today_count").hide();
        }

    });
    $('body').on("change", ".amb_type_dropdown", function() {
        $amb_type = $(this).val();
        if ($amb_type == 'ALL') {
            $("#JE_map").html('<iframe src="' + base_url + 'erc_dashboards/map_amb_all" style="width:100%; height: 550px!important; border:0px;"></iframe>');

        }
        else if ($amb_type == 'ALS') {
            $("#JE_map").html('<iframe src="' + base_url + 'erc_dashboards/map_amb_als" style="width:100%; height: 550px!important; border:0px;"></iframe>');

        } else if ($amb_type == 'BLS') {
            $("#JE_map").html('<iframe src="' + base_url + 'erc_dashboards/map_amb_bls" style="width:100%; height: 550px!important; border:0px;"></iframe>');
        } else if ($amb_type == 'JE') {
            $("#JE_map").html('<iframe src="' + base_url + 'erc_dashboards/map_amb_je" style="width:100%; height: 550px!important; border:0px;"></iframe>');
        }
    });
   
</script>

</html>