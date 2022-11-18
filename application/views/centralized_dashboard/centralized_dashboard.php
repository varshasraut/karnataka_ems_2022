<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Centralized Dashboard</title>
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
</head>
<style>
.img_bg{
    height:auto;
    background: linear-gradient(180deg, #EBE8F6 0%, #BEBFE6 100%);
    position:relative;
    text-align:center;
}
.img_bg p{
    font-family: 'Roboto';
    font-style: normal;
    font-weight: 800;
    font-size: 45px;
    line-height: 70px;
    text-transform: uppercase;
    margin-top:50px;
}
.image{
    /* height:382px; */
    /* margin-top:20px; */
    width:80%;
    /* margin-bottom: 68px;     */
}
.cards a:hover{
    text-decoration:none;
}
/* .cards{
    margin-top:30px;
} */
.card1{
    background: linear-gradient(180deg, #905D99 0%, #720F83 100%);
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.25);
    border-radius: 16px;
    height:150px;
    width:85%;
    margin:10px 0 0 65px;
}
.report_img{
    display:block;
    margin:auto;
    height:85px;
    /* margin-top:20px; */
}

.report_txt{
    font-family: 'Roboto';
    font-style: normal;
    font-weight: 600;
    font-size: 32px;
    margin-top:12px;
    color: #FFFFFF;
}
a .img_hover:hover{
    transition: 1.2s;
    transition-timing-function: linear;
    transform: rotateY(360deg);
}
.card2{
    background: linear-gradient(180deg, #FC7F50 0%, #D75C2E 100%);
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.25);
    border-radius: 16px;
    height:150px;
    width:85%;
    margin:10px 0 0 0px;
}
.card3{
    background: linear-gradient(180deg, #88D67F 0%, #53914C 100%);
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.25);
    border-radius: 16px;
    height:150px;
    width:85%;
    margin:0px 0 0 65px;
}
.card4{
    background: linear-gradient(180deg, #FFCA36 0%, #E1AF24 100%);
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.25);
    border-radius: 16px;
    height:150px;
    width:85%;
}
.card5{
    background: linear-gradient(180deg, #38B8C1 0%, #098F98 100%);
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.25);
    border-radius: 16px;
    height:150px;
    width:85%;
    margin:0 0 0 65px;
}
.card6{
    background: linear-gradient(180deg, #EB87AC 0%, #CA376D 100%);
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.25);
    border-radius: 16px;
    height:150px;
    width:85%;
}
#nhm,#gis,#report{
    cursor: pointer;
}
@media (min-width: 768px) and (max-width: 999.98px){
    .image{
        height:300px;
        margin:80px 0 20px 0;
    }
   
    .card1{
        margin: 10px 0 0 10px;
        width:100%;
    }
    .card2{
        margin: 10px 0 0 -5px;
        width:100%;
    }
    .card3{
        margin: 0 0 0 10px;
        width:100%;
    }
    .card4{
        margin: 0 0 0 -5px;
        width:100%;
    }
    .card5{
        margin: 0 0 0 10px;
        width:100%;
    }
    .card6{
        margin: 0 0 0 -5px;
        width:100%;
    }
    .report_img{
        height:75px;
    }
    .report_txt{
        font-size:20px;
    }
    .dash_img{
        height:100px;
    }
}
@media (min-width: 1024px) and (max-width: 1400px){
    .image{
        margin-top:29px;
        height:300px;
        margin-bottom:80px;
    }
    .card1{
        margin: 10px 0 0 10px;
        width:100%;
    }
    .card2{
        margin: 10px 0 0 -5px;
        width:100%;
    }
    .card3{
        margin: 0 0 0 10px;
        width:100%;
    }
    .card4{
        margin: 0 0 0 -5px;
        width:100%;
    }
    .card5{
        margin: 0 0 0 10px;
        width:100%;
    }
    .card6{
        margin: 0 0 0 -5px;
        width:100%;
    }
    .report_img{
        height:70px;
    }
    .report_txt{
        font-size:25px;
    }
    
}
@media (min-width: 1401px) and (max-width: 2599px){
    .image{
        margin-top:40px;
        height:350px;
        margin-bottom:92px;
    }
    .card1{
        margin: 10px 0 0 10px;
        height:170px;
        width:100%;
    }
    .card2{
        margin: 10px 0 0 -5px;
        height:170px;
        width:100%;
    }
    .card3{
        margin: 0 0 0 10px;
        height:170px;
        width:100%;
    }
    .card4{
        margin: 0 0 0 -5px;
        height:170px;
        width:100%;
    }
    .card5{
        margin: 0 0 0 10px;
        height:170px;
        width:100%;
    }
    .card6{
        margin: 0 0 0 -5px;
        height:170px;
        width:100%;
    }
    .report_img{
        height:70px;
    }
    .report_txt{
        font-size:25px;
    }
}
@media (min-width: 2560px){
    .image{
        height:680px;
        margin-bottom:30px;
        margin-top:100px;
    }
    .img_bg p{
        font-size:80px;
        margin-top:100px;
    }
    .cards{
        margin-top:25px;
    }
    .card1{
        height:275px;
    }
    .card2{
        height:275px;
    }
    .card3{
        height:275px;
    }
    .card4{
        height:275px;
    }
    .card5{
        height:275px;
    }
    .card6{
        height:275px;
    }
    .report_img{
        height:125px;
    }
    .report_txt{
        font-size:50px;
    }
}

@media (min-height: 768px){
    .image{
        height:340px;
        /* margin-bottom:30px;
        margin-top:100px; */
    }
    .img_bg p{
        font-size:60px;
        /* margin-top:80px; */
    }
    .cards{
        margin-top:15px;
    }
    .card1{
        height:165px;
    }
    .card2{
        height:165px;
    }
    .card3{
        height:165px;
    }
    .card4{
        height:165px;
    }
    .card5{
        height:165px;
    }
    .card6{
        height:165px;
    }
    .report_img{
        height:75px;
    }
    .report_txt{
        font-size:30px;
    }
}

@media (min-height: 770px){
    .image{
        height:404px;
        /* margin-bottom:30px;
        margin-top:100px; */
    }
    .img_bg p{
        font-size:60px;
        /* margin-top:80px; */
    }
    .cards{
        margin-top:22px;
    }
    .card1{
        height:185px;
    }
    .card2{
        height:185px;
    }
    .card3{
        height:185px;
    }
    .card4{
        height:185px;
    }
    .card5{
        height:185px;
    }
    .card6{
        height:185px;
    }
    .report_img{
        height:75px;
    }
    .report_txt{
        font-size:30px;
    }
}

</style>
<body>
    
        <div class="row">
            <div class="col-lg-6 col-md-6 img_bg">
                <p>Centralized Dashboard</p>
                <img src="..\assets\images\center_dash.png" class="image">
            </div>
            <div class="col-lg-6 col-md-6 mt-4">
                <div  class="row cards">
                    <div class="col-md-6">
                        <a id="report" target="_blank">

                        <!-- <a href="http://reports.jaesmp.com/JAEms/clg/login" target="_blank"> -->
                        <div class="card-body card1">
                            <div class="row">
                                <div class="col-md-12 img_hover">
                                    <img src="..\assets\images\reports.png" class="report_img">
                                </div>
                                <div class="col-md-12 text-center report_txt">
                                    <p>Reports</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <div class="col-md-6">
                    <!-- <a href="http://gis.jaesmp.com/JAemsGis/loginscreen.php" target="_blank">  -->
                    <a id="gis" target="_blank">
                        <div class="card-body card2">
                            <div class="row">
                                <div class="col-md-12 img_hover">
                                    <img src="..\assets\images\gis.png" class="report_img">
                                </div>
                                <div class="col-md-12 text-center report_txt">
                                    <p>GIS Analytics</p>
                                </div>
                            </div>
                        </div></a>
                    </div>
                </div>
                <div  class="row cards">
                    <div class="col-md-6 mt-3">
                    <a href="http://13.235.213.74" target="_blank"> <div class="card-body card3">
                            <div class="row">
                                <div class="col-md-12 img_hover">
                                    <img src="..\assets\images\gps.png" class="report_img">
                                </div>
                                <div class="col-md-12 text-center report_txt">
                                    <p>GPS</p>
                                </div>
                            </div>
                    </div></a>
                    </div>
                    <div class="col-md-6 mt-3">
                     <a id="nhm" target="_blank">
                    <!-- <a href="http://irts.jaesmp.com/JAEms/clg/login" target="_blank"> -->
                        <div class="card-body card4">
                            <div class="row">
                                <div class="col-md-12 img_hover">
                                    <img src="..\assets\images\dashboard.png" class="report_img">
                                </div>
                                <div class="col-md-12 text-center report_txt">
                                    <p>NHM Dashboard</p>
                                </div>
                            </div>
                    </div></a>
                    </div>
                </div>
                <div  class="row cards">
                    <div class="col-md-6 mt-3">
                    <a href="https://thirdwave.in.suremdm.io/console/ConsolePage/Master.html?7.20.14" target="_blank"> <div class="card-body card5">
                            <div class="row">
                                <div class="col-md-12 img_hover">
                                    <img src="..\assets\images\mdt.png" class="report_img">
                                </div>
                                <div class="col-md-12 text-center report_txt">
                                    <p>MDT</p>
                                </div>
                            </div>
                    </div></a>
                    </div>
                    <div class="col-md-6 mt-3">
                    <a href="https://dialer.jaesmp.com:8443/app" target="_blank"> <div class="card-body card6">
                            <div class="row">
                                <div class="col-md-12 img_hover">
                                    <img src="..\assets\images\dialer.png" class="report_img">
                                </div>
                                <div class="col-md-12 text-center report_txt">
                                    <p>Dialer Application</p>
                                </div>
                            </div>
                    </div></a>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $('#report').click(function(){
       
        // $.ajax({
        // // url: "http://localhost/Spero_MPDIAL_108/clg/report_login",
        // // url: "https://test.jaesmp.com/clg/nhm_login",
        // url: "https://reports.jaesmp.com/clg/report_login",
        // type: "post",
        // // data: {password:"111111",ref_id:"CENTERDASH-2"},
        // success: function (data) {
                
        //         <?php
        //             // $this->session->set_userdata('temp_usr', "CENTERDASH-2");
        //             // $this->session->set_userdata('password', "111111");
        //         ?>
                    // window.open("http://localhost/Spero_MPDIAL_108/clg/login", "_blank");
                    window.open("https://reports.jaesmp.com/clg/report_login", "_blank");
                    // window.open("https://test.jaesmp.com/clg/login", "_blank");
                
            // }
        // });
    });

    $('#nhm').click(function(){
       
       $.ajax({
    //    url: "http://localhost/Spero_MPDIAL_108/clg/nhm_login",
        // url: "https://test.jaesmp.com/clg/nhm_login",
        url: "https://irts.jaesmp.com/clg/nhm_login",
       type: "post",
    //    data: {password:"111111",ref_id:"CENTERDASH-2"},
       success: function (data) {
               
               <?php
                   // $this->session->set_userdata('temp_usr', "CENTERDASH-2");
                   // $this->session->set_userdata('password', "111111");
               ?>
                //    window.open("http://localhost/Spero_MPDIAL_108/clg/login", "_blank");
                // window.open("https://test.jaesmp.com/clg/login", "_blank");
                window.open("https://irts.jaesmp.com/clg/login", "_blank");
               
           }
       });
   });

   $('#gis').click(function(){
       
    //    $.ajax({
    // //    url: "http://localhost/IRTS_analytics/loginscreen.php",
    //     url: "https://gis.jaesmp.com/centralize_dash.php",
    //    type: "post",
    //    data: {password:"111111",ref_id:"CENTERDASH-2"},
    //    success: function (data) {
               
               <?php
                   // $this->session->set_userdata('temp_usr', "CENTERDASH-2");
                   // $this->session->set_userdata('password', "111111");
               ?>
                //    window.open("http://localhost/IRTS_analytics/loginscreen.php", "_blank");
                // window.open("https://gis.jaesmp.com/loginscreen.php", "_blank");
                window.open("https://gis.jaesmp.com/centralize_dash.php", "_blank");
               
    //        }
    //    });
   });
   
</script>


</body>
</html>