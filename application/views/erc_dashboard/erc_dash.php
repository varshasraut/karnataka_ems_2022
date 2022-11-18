<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    

    <!-- <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet"> -->
    <!-- Font Awesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- End Font Awesome  -->
    <!-- CSS -->

    <style>
        .box_color_Total_Calls {
            background: linear-gradient(90deg, #27D9E4 0%, #5D9FDF 100%);
            border-radius: 10px 10px 0px 0px;
        }

        .box_color_Emergency_Calls {
            background: linear-gradient(90deg, #FD7676 0%, #C74949 100%);
            border-radius: 10px 10px 0px 0px;
        }

        .box_color_Non_Emergency_Calls {
            background: linear-gradient(90deg, #2EE3A8 0%, #37AEAF 100%);
            border-radius: 10px 10px 0px 0px;
        }

        .box_color_Dispatches {
            background: linear-gradient(90deg, #2DC0D9 0%, #1F75B3 100%);
            border-radius: 10px 10px 0px 0px;
        }

        .box_color_Agents_Available {
            background: linear-gradient(90deg, #CE6CEF 0%, #8062ED 100%);
            border-radius: 10px 10px 0px 0px;
        }

        .box_color_Agents_Status {
            background: linear-gradient(90deg, #DE447D 0%, #8605A7 100%);
            border-radius: 10px 10px 0px 0px;
        }

        .box_color_Ambulance {
            background: linear-gradient(90deg, #ECB265 0%, #F38882 100%);
            border-radius: 10px 10px 0px 0px;
        }

        .box_color_Patient_Served {
            background: linear-gradient(90deg, #986BD8 0%, #50459D 100%);
            border-radius: 10px 10px 0px 0px;
        }



        .crical {
            margin-left: auto;
            margin-right: auto;
            left: 0;
            right: 0;
            text-align: center;
            box-sizing: border-box;
            position: absolute;
            width: 50px;
            height: 50px;
            top: -30px;

        }



        .bg_crical1_Total_Calls {
            background: linear-gradient(360deg, #27D9E4 -1.22%, #5D9FDF 101.22%);
            box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 50px;
        }

        .bg_crical2_Emergency_Calls {
            background: linear-gradient(360deg, #FD7676 -1.22%, #C74949 101.22%);
            box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 50px;
        }

        .bg_crical3_Non_Emergency_Calls {
            background: linear-gradient(360deg, #2EE3A8 -1.22%, #37AFAF 101.22%);
            box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 50px;
        }

        .bg_crical4_Dispatches {
            background: linear-gradient(360deg, #2DC0D9 -1.22%, #1F76B3 101.22%);
            box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 50px;
        }

        .bg_crical5_Agents_Available {
            background: linear-gradient(360deg, #CE6CEF -1.22%, #8062ED 101.22%);
            box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 50px;
        }

        .bg_crical6_Agents_Status {
            background: linear-gradient(0deg, #DF447D -1.45%, #8605A7 103.14%);
            box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 50px;
        }

        .bg_crical3_Ambulance {
            background: linear-gradient(360deg, #ECB265 2.73%, #F38882 102.09%);
            box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 50px;
        }

        .bg_crical8_Patient_Served {
            background: linear-gradient(0deg, #BCA0E3 -0.41%, #50459D 100%);
            box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 50px;
        }


        .crical2 {
            box-sizing: border-box;
            position: absolute;
            width: 50px;
            height: 50px;
            left: 13px;
            top: 11px;

        }

        .crical2_color1 {
            background: linear-gradient(98.15deg, #E4D245 3.17%, #FE7381 100%);
            box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 50px;
            /* opacity: 0.50;         */
        }

        .crical2_color2 {
            background: linear-gradient(97.31deg, #F2ABF3 0.69%, #8E5EF9 99.22%);
            box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 50px;
            /* opacity: 0.50;         */
        }

        .crical2_color3 {
            background: linear-gradient(97.73deg, #18E193 0.94%, #3891E3 100%);
            box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 50px;
            /* opacity: 0.50;         */
        }

        .crical2_color4 {
            background: linear-gradient(97.73deg, #FE956F 0.94%, #7A369B 100%);
            box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 50px;
            /* opacity: 0.50;         */
        }

        .crical2_color5 {
            background: linear-gradient(97.73deg, #ABD03F 0.94%, #18C284 100%);
            box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 50px;
            /* opacity: 0.50;         */
        }


        .icon_size {
            font-size: 20px;
        }

        .text_and_color_white {
            color: white;
        }

        .padding_top1 {
            padding-top: 20px;
        }

        .text_alineCenter {
            text-align: center;
        }

        .padding_topT {
            padding-top: 15px;
        }

        .font_Poppins {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 500;
            font-size: 25px;
            line-height: 0px;
            color: #FFFFFF;
        }

        .font_Poppins_t1 {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 500;
            font-size: 20px;
            line-height: 0px;
            color: #FFFFFF;
        }

        .font_Poppins_t2 {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 600;
            font-size: 25px;
            line-height: 0px;
            color: #FFFFFF;
        }

       
        .block1_Left {
            background: linear-gradient(179.17deg, #27D9E4 0.72%, #5CA1DF 99.29%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 0px 16px;
        }

        .bolck1_right {
            background: linear-gradient(179.17deg, #27D9E4 0.72%, #5CA1DF 99.29%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 16px 0px;
            transform: matrix(1, 0, 0, 1, 0, 0);
        }

        .block2_Left {
            background: linear-gradient(179.17deg, #FD7676 0.72%, #C74949 99.29%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 0px 16px;
        }

        .bolck2_right {
            background: linear-gradient(179.17deg, #FD7676 0.72%, #C74949 99.29%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 16px 0px;
            transform: matrix(1, 0, 0, 1, 0, 0);
        }

        .block3_Left {
            background: linear-gradient(179.17deg, #2EE3A8 0.72%, #37AEAF 99.29%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 0px 16px;
        }

        .bolck3_right {
            background: linear-gradient(179.17deg, #2EE3A8 0.72%, #37AEAF 99.29%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 16px 0px;
            transform: matrix(1, 0, 0, 1, 0, 0);
        }

        .block4_Left {
            background: linear-gradient(179.17deg, #2DC0D9 0.72%, #1F75B3 99.29%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 0px 16px;
        }

        .bolck4_right {
            background: linear-gradient(179.17deg, #2DC0D9 0.72%, #1F75B3 99.29%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 16px 0px;
            transform: matrix(1, 0, 0, 1, 0, 0);
        }

        .block5_Left {
            background: linear-gradient(179.17deg, #CF6CEF 0.72%, #8062ED 99.29%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 10px 10px;
        }
        .bolck5_center{
            background: linear-gradient(179.17deg, #CF6CEF 0.72%, #8062ED 99.29%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 10px 10px;

        }

        .bolck5_right {
            background: linear-gradient(179.17deg, #CF6CEF 0.72%, #8062ED 99.29%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 10px 10px;
            transform: matrix(1, 0, 0, 1, 0, 0);
        }

        .block6_Left {
            background: linear-gradient(179.17deg, #DE447D 0.91%, #8000AA 99.48%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 10px 10px;
        }

        .bolck6_right {
            background: linear-gradient(179.17deg, #DE447D 0.91%, #8000AA 99.48%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 10px 10px;
            transform: matrix(1, 0, 0, 1, 0, 0);
        }

        .bolck6_center {
            background: linear-gradient(179.17deg, #DE447D 0.91%, #8000AA 99.48%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 10px 10px;
            /* transform: matrix(1, 0, 0, 1, 0, 0); */
        }

        .block7_Left {
            background: linear-gradient(179.17deg, #ECB265 0.72%, #F38882 99.29%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 10px 10px;
        }

        .bolck7_right {
            background: linear-gradient(179.17deg, #ECB265 0.72%, #F38882 99.29%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 10px 10px;
            transform: matrix(1, 0, 0, 1, 0, 0);
        }

        .bolck7_center {
            background: linear-gradient(179.17deg, #ECB265 0.72%, #F38882 99.29%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 10px 10px;
            /* transform: matrix(1, 0, 0, 1, 0, 0); */
        }

        .block8_Left {
            background: linear-gradient(179.17deg, #986BD7 0.72%, #50459D 99.28%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 0px 16px;
        }

        .bolck8_right {
            background: linear-gradient(179.17deg, #986BD7 0.72%, #50459D 99.28%);
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
            border-radius: 0px 0px 16px 0px;
            transform: matrix(1, 0, 0, 1, 0, 0);
        }

        .bolck9 {
            background: linear-gradient(98.15deg, #E4D245 3.17%, #FE7381 100%);
            border-radius: 16px;
        }

        .bolck10 {
            background: linear-gradient(97.31deg, #F2ABF3 0.69%, #8E5EF9 99.22%);
            border-radius: 16px;
        }

        .bolck11 {
            background: linear-gradient(97.73deg, #18E193 0.94%, #3891E3 100%);
            border-radius: 16px;
        }

        .bolck12 {
            background: linear-gradient(97.73deg, #FE956F 0.94%, #7A369B 100%);
            border-radius: 16px;
        }

        .bolck13 {
            background: linear-gradient(97.73deg, #ABD03F 0.94%, #18C284 100%);
            border-radius: 16px;
        }


        
.bg_Agent_List {
    background: linear-gradient(90.01deg, #3F7CFE 0.01%, #43E5D0 99.5%);
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 10px 10px 0px 0px;
}
.iconcirclepading {
    padding: 5px;
}



.icon-shape {
    width: 48px;
    height: 48px;
    color: #fff;
    background-position: center;
    border-radius: 0.75rem;
}
.bg-gradient_Login_Agent {
    background: linear-gradient(180deg, #45E5D0 0%, #3F7CFE 100%);
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 10px 10px 0px 0px;
}

.rounded-circle,
.avatar.rounded-circle img {
    border-radius: 50% !important;
}
.box2_bg {
    background: #FFFFFF;
    box-shadow: 4px 4px 10px 7px rgba(135, 135, 135, 0.05);
    border-radius: 10px;
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
    background: linear-gradient(180deg, #f700ef  0%, #0da5d3  100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 50px;
}
.agent_circle_bg11  {
    background: linear-gradient(180deg, #00CEF7 0%, #1CD40D 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);
    border-radius: 50px;
}
.agent_circle_bg10{
    background: linear-gradient(180deg, #9A67F8 0%, #E7A2F4 100%);
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.14), 0px 1px 10px rgba(0, 0, 0, 0.12);

}
.agent_circle_bg12{
    background: linear-gradient(180deg, #00ffdc  0%, #E7A2F4  100%);
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
.lable_col {
    font-family: "Roboto";
    font-style: normal;
    font-weight: 600;
    font-size: 22px;
    line-height: 33px;
    padding-top: 12px;

    color: #ffffff;
}

.white {
    color: #ffffff;
}




/* Button  */
*{
	margin: 0;
	padding: 0;
	list-style: none;
	font-family: 'Montserrat', sans-serif;
	-webkit-box-sizing: border-box;
	        box-sizing: border-box;
}

/* body{
	background: #7fc469;
	color: #565e6b;
} */

.wrapper{
	/* width: 500px; */
	height: 100%;
	background: #fff;
	margin: 15px auto 0;
}

.wrapper .title{
	padding: 30px 20px;
	text-align: center;
	font-size: 24px;
	font-weight: 700;
	border-bottom: 1px solid #ebedec;
}

.wrapper .tabs_wrap{
	padding: 20px;
	border-bottom: 1px solid #ebedec;
}

.wrapper .tabs_wrap ul{
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-pack: center;
	    -ms-flex-pack: center;
	        justify-content: center;
}

.wrapper .tabs_wrap ul li{
	width: 135px;
    text-align: center;
    background: #e9ecf1;
    border-right: 1px solid #c1c4c9;
    padding: 13px 15px;
	cursor: pointer;
	-webkit-transition: all 0.2s ease;
	-o-transition: all 0.2s ease;
	transition: all 0.2s ease;
}

.wrapper .tabs_wrap ul li:first-child{
	border-top-left-radius: 25px;
	border-bottom-left-radius: 25px;
}

.wrapper .tabs_wrap ul li:last-child{
	border-right: 0px;
	border-top-right-radius: 25px;
	border-bottom-right-radius: 25px;
}

.wrapper .tabs_wrap ul li:hover,
.wrapper .tabs_wrap ul li.active{
	background: #7fc469;
	color: #fff;
}

.wrapper .container .item_wrap{

	cursor: pointer;
}

.wrapper .container .item_wrap:hover{
	background: #e9ecf1;
}

.wrapper .container .item{
	position: relative;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-align: center;
	    -ms-flex-align: center;
	        align-items: center;
	-webkit-box-pack: justify;
	    -ms-flex-pack: justify;
	        justify-content: space-between;
}

.item_wrap .item .item_left{
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-align: center;
	    -ms-flex-align: center;
	        align-items: center;
}

.item_wrap .item_left img{
	width: 70px;
	height: 70px;
	display: block;
}

.item_wrap .item_left .data{
	margin-left: 20px;
}

.item_wrap .item_left .data .name{
	font-weight: 600;
}

.item_wrap .item_left .data .distance{
	color: #7f8b9b;
	font-size: 14px;
	margin-top: 3px;
}

.item_wrap .item_right .status{
	position: relative;
	color: #77818d;
}

.item_wrap .item_right .status:before{
	content: "";
	position: absolute;
	top: 5px;
    left: -12px;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: #b3bbc8;
}

.item_wrap.offline .item_right .status{
	color: #b3bbc8;	
}

.item_wrap.online .item_right .status:before{
	background: #7fc469;
}
/* Button */

    </style>
    <!-- End CSS -->
    
</head>

<body>
    <div >
        <div>
            <div class="container-fluid" id="ercDash">
                <div class="row">
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="row">
                            <!-- <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding_top1">
                                <div class="row">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        
                                    
                                    <div class="wrapper">
                                        <div class="tabs_wrap">
                                            <ul>
                                            <li data-tabs="male">Male</li>
                                            <li data-tabs="female">Female</li>
                              
                                            </ul>
                                        </div>
                                        <div class="container">
                                            <ul>
                                            <li class="item_wrap male online">
                                              <a href="erc_dash.php"></a> 
                                            </li>                                            
                                         
                                            <li class="item_wrap female offline">
                                                <a href="EMS.php"></a>
                                            </li>
                                    </div>
                                 
                                </div>
                            </div> -->
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding_top1">
                                <div class="row">
                                    <div class=" col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 p-3">
                                        <div class="row">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-2">
                                                <div class="">
                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 box_color_Total_Calls text_alineCenter p-2">

                                                        <div class="crical bg_crical1_Total_Calls">
                                                            <i class="fas fa-phone-volume icon_size text_and_color_white p-3"></i>
                                                        </div>
                                                        <div class="padding_topT">
                                                            <lable class="text_and_color_white font_Poppins">Total Calls</lable>
                                                        </div>

                                                    </div>


                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_alineCenter">
                                                        <div class="row ">
                                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_alineCenter">
                                                                <div class="row pt-1">
                                                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 p-0 ">

                                                                        <div class="padding_topT mr-0 pt-4 pb-4 text_alineCenter block1_Left"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">Till Date</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2"><span id="count_till_date"><?php echo $data['count_till_date']; ?></span></lable>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 p-0">

                                                                        <div class="padding_topT ml-1 pt-4 pb-4  text_alineCenter bolck1_right"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">This Month</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2"><span  id="count_till_month"><?php echo $data['count_till_month']; ?></span></lable>
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
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 p-3">
                                        <div class="row">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-2">
                                                <div class="">
                                                    <div class=" col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 box_color_Emergency_Calls text_alineCenter p-2">
                                                        <div class="crical bg_crical2_Emergency_Calls">
                                                            <i class="fas fa-phone-volume icon_size text_and_color_white p-3"></i>
                                                        </div>
                                                        <div class="padding_topT">
                                                            <lable class="text_and_color_white font_Poppins">Emergency Calls</lable>
                                                        </div>
                                                    </div>

                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_alineCenter">
                                                        <div class="row ">
                                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_alineCenter">
                                                                <div class="row pt-1">
                                                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 p-0 ">

                                                                        <div class="padding_topT mr-0 pt-4 pb-4 text_alineCenter block2_Left"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">Till Date</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2" id="eme_count_till_date"><?php echo $data['eme_count_till_date']; ?> </lable>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 p-0">

                                                                        <div class="padding_topT ml-1 pt-4 pb-4  text_alineCenter bolck2_right"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">This Month</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2" id="eme_count_till_month"><?php echo $data['eme_count_till_month']; ?></lable>
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
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 p-3">
                                        <div class="row">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-2">
                                                <div class="">
                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 box_color_Non_Emergency_Calls text_alineCenter p-2">
                                                        <div class="crical bg_crical3_Non_Emergency_Calls">
                                                            <i class="fas fa-phone-volume icon_size text_and_color_white p-3"></i>
                                                        </div>
                                                        <div class="padding_topT">
                                                            <lable class="text_and_color_white font_Poppins">Non Emergency Calls</lable>
                                                        </div>
                                                    </div>


                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_alineCenter">
                                                        <div class="row ">

                                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_alineCenter">
                                                                <div class="row pt-1">
                                                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 p-0 ">
                                                                        <div class="padding_topT mr-0 pt-4 pb-4 text_alineCenter block3_Left"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">Till Date</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2" id="noneme_count_till_date"><?php echo $data['noneme_count_till_date']; ?></lable>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 p-0">
                                                                        <div class="padding_topT ml-1 pt-4 pb-4  text_alineCenter bolck3_right"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">This Month</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2" id="noneme_count_till_month"><?php echo $data['noneme_count_till_month']; ?></lable>
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
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 p-3">
                                        <div class="row">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-2">
                                                <div class="">
                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 box_color_Dispatches text_alineCenter p-2">
                                                        <div class="crical bg_crical4_Dispatches">
                                                            <i class="fas fa-phone-volume icon_size text_and_color_white p-3"></i>
                                                        </div>
                                                        <div class="padding_topT">
                                                            <lable class="text_and_color_white font_Poppins">Dispatches</lable>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_alineCenter">
                                                        <div class="row ">

                                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_alineCenter">
                                                                <div class="row pt-1">
                                                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 p-0 ">
                                                                        <div class="padding_topT mr-0 pt-4 pb-4 text_alineCenter block4_Left"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">Till Date</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2" id="dispatch_till_date"><?php echo $data['dispatch_till_date']; ?></lable>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 p-0">
                                                                        <div class="padding_topT ml-1 pt-4 pb-4  text_alineCenter bolck4_right"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">This Month</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2" id="dispatch_till_month"><?php echo $data['dispatch_till_month']; ?></lable>
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


                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <div class="row">
                                    
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 p-3">
                                        <div class="row">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-2">
                                                <div class="">
                                                    <div class=" col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 box_color_Agents_Status text_alineCenter p-2">
                                                        <div class="crical bg_crical6_Agents_Status">
                                                            <i class="fas fa-phone-volume icon_size text_and_color_white p-3"></i>
                                                        </div>
                                                        <div class="padding_topT">
                                                            <lable class="text_and_color_white font_Poppins">ERO Status</lable>
                                                        </div>
                                                    </div>

                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12  text_alineCenter">
                                                        <div class="row ">
                                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12  text_alineCenter">
                                                                <div class="row pt-1">
                                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 p-0 ">

                                                                        <div class="padding_topT mr-0 pt-4 pb-4 text_alineCenter block6_Left"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">Available</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2"><span id="ero_free"><?php echo $data['ero_free']; ?></span></lable>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 p-0 ">

                                                                        <div class="padding_topT mr-0 ml-1 pt-4 pb-4 text_alineCenter bolck6_center"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">On Call</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2"><span id="ero_atend"><?php echo $data['ero_atend']; ?></span></lable>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 p-0">

                                                                        <div class="padding_topT ml-1 pt-4 pb-4  text_alineCenter bolck6_right"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">Break</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2"><span id="ero_break"><?php echo $data['ero_break']; ?></span></lable>
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
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 p-3">
                                        <div class="row">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-2">
                                                <div class="">
                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 box_color_Ambulance text_alineCenter p-2">
                                                        <div class="crical bg_crical3_Ambulance ">
                                                            <i class="fas fa-phone-volume icon_size text_and_color_white p-3"></i>
                                                        </div>
                                                        <div class="padding_topT">
                                                            <lable class="text_and_color_white font_Poppins">Ambulance</lable>
                                                        </div>
                                                    </div>


                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_alineCenter">
                                                        <div class="row ">

                                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_alineCenter">
                                                                <div class="row pt-1">
                                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 p-0 ">
                                                                        <div class="padding_topT mr-0 pt-4 pb-4 text_alineCenter block7_Left"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">All</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2"><span id="amb_total"><?php echo $data['amb_total']?></span></lable>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 p-0 ">
                                                                        <div class="padding_topT mr-0 ml-1 pt-4 pb-4 text_alineCenter bolck7_center"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">Available</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2"><span id="amb_available"><?php echo $data['amb_available']?></span></lable>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 p-0">
                                                                        <div class="padding_topT ml-1 pt-4 pb-4  text_alineCenter bolck7_right"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">On Case</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2"><span id="amb_busy"><?php echo $data['amb_busy']?></span></lable>
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
                                    <div class=" col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 p-3">
                                        <div class="row">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-2">
                                                <div class="">
                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 box_color_Agents_Available text_alineCenter p-2">

                                                        <div class="crical bg_crical5_Agents_Available">
                                                            <i class="fas fa-phone-volume icon_size text_and_color_white p-3"></i>
                                                        </div>
                                                        <div class="padding_topT">
                                                            <lable class="text_and_color_white font_Poppins">Ambulance Type</lable>
                                                        </div>

                                                    </div>


                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_alineCenter">
                                                        <div class="row ">
                                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_alineCenter">
                                                                <div class="row pt-1">
                                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 p-0 ">

                                                                        <div class="padding_topT mr-0 pt-4 pb-4 text_alineCenter block5_Left"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">JE</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2"><span id="amb_je"><?php echo $data['amb_je']; ?></span></lable>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 p-0">

                                                                        <div class="padding_topT ml-1 pt-4 pb-4  text_alineCenter bolck5_center"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">ALS</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2"><span id="amb_als"><?php echo $data['amb_als']; ?></span></lable>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 p-0">

                                                                        <div class="padding_topT ml-1 pt-4 pb-4  text_alineCenter bolck5_right"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">BLS</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2"><span id="amb_bls"><?php echo $data['amb_bls']; ?></span></lable>
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
                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 p-3">
                                        <div class="row">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-2">
                                                <div class="">
                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 box_color_Patient_Served text_alineCenter p-2">
                                                        <div class="crical bg_crical8_Patient_Served">
                                                            <i class="fas fa-phone-volume icon_size text_and_color_white p-3"></i>
                                                        </div>
                                                        <div class="padding_topT">
                                                            <lable class="text_and_color_white font_Poppins">Patient Served</lable>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_alineCenter">
                                                        <div class="row ">

                                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text_alineCenter">
                                                                <div class="row pt-1">
                                                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 p-0 ">
                                                                        <div class="padding_topT mr-0 pt-4 pb-4 text_alineCenter block8_Left"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">Till Date</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2"><span id="closure_till_date"><?php echo $data['closure_till_date']; ?></span></lable>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 p-0">
                                                                        <div class="padding_topT ml-1 pt-4 pb-4  text_alineCenter bolck8_right"><br>
                                                                            <lable class="text_and_color_white font_Poppins_t1">This Month</lable> <br>
                                                                            <br>
                                                                            <lable class="text_and_color_white font_Poppins_t2"><span id="closure_till_month"><?php echo $data['closure_till_month']; ?></span></lable>
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


                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mx-auto ">
                                <div class="row" style="padding-bottom: 10px;">
                                    <div class=" col-xxl-2 col-xl-2 col-lg-2 col-md-5 col-sm-12 col-12 m-2 mx-auto bolck9  p-3">
                                        <div class="crical2 crical2_color1">
                                            <i class="fas fa-phone-volume icon_size text_and_color_white p-3"></i>
                                        </div>
                                        <div class="">
                                            <div class="padding_topT ml-1 pt-4 pb-4  text_alineCenter "><br>
                                                <lable class="text_and_color_white font_Poppins_t2"><span id="count_today"><?php echo $data['count_today']; ?></span></lable><br>
                                                <br>
                                                <lable class="text_and_color_white font_Poppins_t1">Total Calls Today</lable>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-5 col-sm-12 m-2 col-12 mx-auto bolck10 p-3">
                                        <div class="crical2 crical2_color2">
                                            <i class="fas fa-phone-volume icon_size text_and_color_white p-3"></i>
                                        </div>
                                        <div class="padding_topT ml-1 pt-4 pb-4  text_alineCenter "><br>
                                            <lable class="text_and_color_white font_Poppins_t2"><span id="eme_count_today_date"><?php echo $data['eme_count_today_date']; ?></span></lable><br>
                                            <br>
                                            <lable class="text_and_color_white font_Poppins_t1">Today's Dispatch</lable>
                                        </div>

                                    </div>

                                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-5 col-sm-12 col-12 m-2 mx-auto bolck11 p-3">
                                        <div class="crical2 crical2_color3">
                                            <i class="fas fa-phone-volume icon_size text_and_color_white p-3"></i>
                                        </div>
                                        <div class="padding_topT ml-1 pt-4 pb-4  text_alineCenter "><br>
                                            <lable class="text_and_color_white font_Poppins_t2"><span id="noneme_count_today_date"><?php echo $data['noneme_count_today_date']; ?></span></lable><br>
                                            <br>
                                            <lable class="text_and_color_white font_Poppins_t1">Total Non Emergency Calls Today</lable>
                                        </div>

                                    </div>

                                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-5 col-sm-12 col-12 m-2 bolck12 mx-auto p-3">
                                        <div class="crical2 crical2_color4">
                                            <i class="fas fa-phone-volume icon_size text_and_color_white  p-3"></i>
                                        </div>
                                        <div class="padding_topT ml-1 pt-4 pb-4  text_alineCenter "><br>
                                            <lable class="text_and_color_white font_Poppins_t2"><span id="closure_till_month_dup"><?php echo $data['closure_till_month']; ?></span></lable><br>
                                            <br>
                                            <lable class="text_and_color_white font_Poppins_t1">Total Closure This Month</lable>

                                        </div>

                                    </div>

                                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-5 col-sm-12 col-12 m-2 bolck13 mx-auto p-3 ">
                                        <div class="crical2 crical2_color5">
                                            <i class="fas fa-phone-volume icon_size text_and_color_white p-3"></i>
                                        </div>
                                        <div class="padding_topT ml-1 pt-4 pb-4  text_alineCenter "><br>
                                            <lable class="text_and_color_white font_Poppins_t2"><span id="closure_today"><?php echo $data['closure_today']; ?></span></lable><br>
                                            <br>
                                            <lable class="text_and_color_white font_Poppins_t1">Total Closure Today</lable>

                                        </div>

                                    </div>

                                </div>
                            </div>



                             <div class="">
                    <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mb-5">
                        <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 p-2">
                            <div class="row">
                                <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12  pb-0">
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
                                    <!--<div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1   text-center">
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
                                    </div>-->
                                    <!-- <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-2 text-center">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg2 white p-2">
                                                    <i class="fa-solid fa-user fa-lg "></i>
                                                </div>
                                                <br>
                                            </div> 
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>ERO 108</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-2">
                                                <div class="Agent_fount2">
                                                    <lable><span id="ero_count"><?php echo $data['ero_count']; ?></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-2 mar2 text-center">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg3 white p-2">
                                                    <!-- <i class="fa-solid fa-user-doctor fa-lg"></i> -->
                                                    <i class="fa-solid fa-user fa-lg "></i>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>ERO 104</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-2">
                                                <div class="Agent_fount2">
                                                    <lable><span id="ero104_count"><?php echo $data['ero104_count']; ?></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-2 mar2 text-center">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg4 white p-2">
                                                <i class="fa-solid fa-users fa-lg"></i>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>ERO TL</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-2">
                                                <div class="Agent_fount2">
                                                    <lable><span id="ero_Tl_count"><?php echo $data['ero_Tl_count']; ?></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-2 mar2 text-center">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg5 white p-2">
                                                    <!-- <i class="fa-solid fa-user fa-lg "></i> -->
                                                    <!-- <i class="fa-solid fa-user-doctor fa-lg"></i> -->
                                                    <i class="fa-solid fa-user fa-lg "></i>
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
                                                    <lable><span id="dco_count"><?php echo $data['dco_count']; ?></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-2 mar2 text-center mar1">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg6 white p-2">
                                                    <!-- <i class="fa-solid fa-rectangle-xmark fa-lg"></i> -->
                                                    <i class="fa-solid fa-users fa-lg"></i>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>DCO TL</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-2">
                                                <div class="Agent_fount2">
                                                    <lable><lable><span id="dco_Tl_count"><?php echo $data['dco_Tl_count']; ?></lable></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-2 mar2 text-center mar1">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg7 white p-2">
                                                    <!-- <i class="fa-solid fa-pen-to-square fa-lg"></i> -->
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
                                                    <lable><lable><span id="pda_count"><?php echo $data['pda_count']; ?></lable></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5  col-md-5 col-xl-1 col-xxl-1 box2_bg ml-2 mar2 text-center mar1">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg8 white p-2">
                                                     <!-- <i class="fa-solid fa-circle-check fa-lg"></i> -->
                                                     <!-- <i class="fa-solid fa-rectangle-xmark fa-lg"></i> -->
                                                     <i class="fa-solid fa-user fa-lg "></i>
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
                                                    <lable><lable><span id="grievance_count"><?php echo $data['grievance_count']; ?></lable></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-2 mar2 text-center mar1">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg9 white p-2">
                                                    <!-- <i class="fa-solid fa-users fa-lg"></i> -->
                                                    <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>Feedback</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-1">
                                                <div class="Agent_fount2">
                                                    <lable><lable><span id="feedback_count"><?php echo $data['feedback_count']; ?></lable></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-2 mar2 text-center mar1">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg11 white p-2">
                                                    <!-- <i class="fa-solid fa-users fa-lg"></i> -->
                                                    <i class="fa-solid fa-circle-check fa-lg"></i>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>Quality</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-1">
                                                <div class="Agent_fount2">
                                                    <lable><lable><span id="quality_count"><?php echo $data['quality_count']; ?></lable></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-2 mar2 text-center mar1">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg10 white p-2">
                                                    <!-- <i class="fa-solid fa-user-tie fa-lg"></i> -->
                                                    <!-- <i class="fa-solid fa-user fa-lg "></i> -->
                                                    <i class="fa-solid fa-user-doctor fa-lg"></i>
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
                                                    <lable><lable><span id="ercp_count"><?php echo $data['ercp_count']; ?></lable></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-2 mar2 text-center mar1">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg10 white p-2">
                                                    <!-- <i class="fa-solid fa-user-tie fa-lg"></i> -->
                                                    <!-- <i class="fa-solid fa-user fa-lg "></i> -->
                                                    <i class="fa-solid fa-user-doctor fa-lg"></i>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>ERCP 104</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-2">
                                                <div class="Agent_fount2">
                                                    <lable><lable><span id="ercp_104_count"><?php echo $data['ercp_104_count']; ?></lable></lable>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-5 col-5 col-md-5 col-xl-1 col-xxl-1 box2_bg ml-2 mar2 text-center mar1">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12">
                                                <div class="circle_dot1 agent_circle_bg12 white p-2">
                                                    <i class="fa-solid fa-user-tie fa-lg"></i>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2">
                                                <div class="Agent_fount1">
                                                    <lable>SM</lable>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-xl-12 col-xxl-12 col-md-12 col-sm-12 col-12 mt-2 mb-2">
                                                <div class="Agent_fount2">
                                                    <lable><lable><span id="SM_count"><?php echo $data['SM_count']; ?></lable></lable>
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


        </div>
    </div>
    <div id="emsDash">

    </div>

</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!--<script type="text/javascript">
    $(document).ready(function() {
       
       // window.onload = erc_live_calls_dash_view();
        var refreshIntervalId = setInterval("erc_live_calls_dash_view()", 3000);
    });
    function erc_live_calls_dash_view() {
       // alert(base_url);
        $.ajax({

            type: 'POST',

            data: 'id=ss',

            cache: false,

            dataType: 'json',

            url: base_url + 'erc_dashboards/erc_live_calls_dash_view',

            success: function(result) {
                console.log(result.resourse_available);
                //var count = $.ParseJSON(result);
                //alert(result);
                //$("#resourse_available").text(result.resourse_available);
               // $("#resourse_count").text(result.resourse_count);
                $("#ero_free").text(result.ero_free);
                $("#ero_atend").text(result.ero_atend);
                $("#ero_break").text(result.ero_break);
                $("#count_today").text(result.count_today);
                $("#closure_today").text(result.closure_today);

                $("#eme_count_today_date").text(result.eme_count_today_date);
                $("#noneme_count_today_date").text(result.noneme_count_today_date);
                $("#amb_total").text(result.amb_total);
                $("#amb_available").text(result.amb_available);
                $("#amb_busy").text(result.amb_busy);
                $("#amb_je").text(result.amb_je);
                $("#amb_als").text(result.amb_als);
                $("#amb_bls").text(result.amb_bls);

                $("#eme_count_till_month").text(result.eme_count_till_month);
                $("#dispatch_till_date").text(result.dispatch_till_date);
                $("#count_till_date").text(result.count_till_date);
                $("#count_till_month").text(result.count_till_month);
                $("#eme_count_till_date").text(result.eme_count_till_date);
                $("#dispatch_till_month").text(result.dispatch_till_month);
                $("#noneme_count_till_date").text(result.noneme_count_till_date);
                $("#noneme_count_till_month").text(result.noneme_count_till_month);
                $("#closure_till_date").text(result.closure_till_date);
                $("#closure_till_month").text(result.closure_till_month);
                $("#closure_till_month_dup").text(result.closure_till_month);

                $("#dco_count").text(result.dco_count);
                $("#pda_count").text(result.pda_count);
                $("#fda_count").text(result.fda_count);
                $("#ercp_count").text(result.ercp_count);
                $("#grievance_count").text(result.grievance_count);
                $("#feedback_count").text(result.feedback_count);
                $("#quality_count").text(result.quality_count);
                $("#dco_Tl_count").text(result.dco_Tl_count);
                $("#ero_Tl_count").text(result.ero_Tl_count);
                $("#SM_count").text(result.SM_count);
                $("#ero_count").text(result.ero_count);
                $("#ero104_count").text(result.ero104_count);
                $("#ercp_104_count").text(result.ercp_104_count);
                
                



                $("#ero_free").text(result.ero_free);
                $("#ero_atend").text(result.ero_atend);
                $("#ero_break").text(result.ero_break);
                $("#count_today").text(result.count_today);
                $("#closure_today").text(result.closure_today);

                $("#eme_count_today_date").text(result.eme_count_today_date);
                $("#noneme_count_today_date").text(result.noneme_count_today_date);
                $("#amb_total").text(result.amb_total);
                $("#amb_available").text(result.amb_available);
                $("#amb_busy").text(result.amb_busy);
                $("#amb_je").text(result.amb_je);
                $("#amb_als").text(result.amb_als);
                $("#amb_bls").text(result.amb_bls);

                $("#eme_count_till_month").text(result.eme_count_till_month);
                $("#dispatch_till_date").text(result.dispatch_till_date);
                $("#count_till_date").text(result.count_till_date);
                $("#count_till_month").text(result.count_till_month);
                $("#eme_count_till_date").text(result.eme_count_till_date);
                $("#dispatch_till_month").text(result.dispatch_till_month);
                $("#noneme_count_till_date").text(result.noneme_count_till_date);
                $("#noneme_count_till_month").text(result.noneme_count_till_month);
                $("#closure_till_date").text(result.closure_till_date);
                $("#closure_till_month").text(result.closure_till_month);
                $("#closure_till_month_dup").text(result.closure_till_month);


                $("#closed_mdt_count_lm").text(result.closed_mdt_count_lm);
                $("#closed_mdt_count_tm").text(result.closed_mdt_count_tm);
                $("#closed_mdt_count_td").text(result.closed_mdt_count_td);

                $("#closed_dco_count_tm").text(result.closed_dco_count_tm);
                $("#closed_dco_count_lm").text(result.closed_dco_count_lm);
                $("#closed_dco_count_td").text(result.closed_dco_count_td);

                $("#ercp_advice_taken_tm").text(result.ercp_advice_taken_tm);
                $("#ercp_advice_taken_lm").text(result.ercp_advice_taken_lm);
                $("#ercp_advice_taken_td").text(result.ercp_advice_taken_td);

                $("#ercp_feedback_lm").text(result.ercp_feedback_lm);
                $("#ercp_feedback_tm").text(result.ercp_feedback_tm);
                $("#ercp_feedback_td").text(result.ercp_feedback_td);

                $("#ercp_grievance_lm").text(result.ercp_grievance_lm);
                $("#ercp_grievance_tm").text(result.ercp_grievance_tm);
                $("#ercp_grievance_td").text(result.ercp_grievance_td);
                $("#ercp_grievance_to").text(result.ercp_grievance_to);

                $("#closed_validated_count_td").text(result.closed_validated_count_td);
                $("#closed_validated_count_lm").text(result.closed_validated_count_tlm);
                $("#closed_validated_count_tm").text(result.closed_validated_count_tm);
                
                $("#eme_count_lm").text(result.eme_count_lm);
                

                $("#104_comp_lm").text(result.104_comp_lm);
                $("#104_comp_tm").text(result.104_comp_tm);
                $("#104_comp_td").text(result.104_comp_td);

                $("#104All_count_lm").text(result.104All_count_lm);
                $("#104All_count_tm").text(result.104All_count_tm);
                $("#104All_count_td").text(result.104All_count_td);
                
                $("#ercp_advice_taken_to").text(result.ercp_advice_taken_to);
                $("#ercp_feedback_to").text(result.ercp_feedback_to);

                
                
                
                $("#dco_count").text(result.dco_count);
                $("#pda_count").text(result.pda_count);
                $("#fda_count").text(result.fda_count);
                $("#ercp_count").text(result.ercp_count);
                $("#grievance_count").text(result.grievance_count);
                $("#feedback_count").text(result.feedback_count);
                $("#quality_count").text(result.quality_count);
                $("#dco_Tl_count").text(result.dco_Tl_count);
                $("#ero_Tl_count").text(result.ero_Tl_count);
                $("#SM_count").text(result.SM_count);
                $("#ero_count").text(result.ero_count);
                $("#ero104_count").text(result.ero104_count);
                $("#ercp_104_count").text(result.ercp_104_count);
                
                
                // $("#").text(result.closed_mdt_count_lm);
                
             }


        });
                
    }



</script>-->

<script>
var tabs = document.querySelectorAll(".tabs_wrap ul li");
var males = document.querySelectorAll(".male");
var females = document.querySelectorAll(".female");
var all = document.querySelectorAll(".item_wrap");

tabs.forEach((tab)=>{
	tab.addEventListener("click", ()=>{
        var tabval = tab.getAttribute("data-tabs");
        // alert('kkkk')
        $.post('<?=base_url('erc_dashboards/EMS_dash')?>',{'tabval': tabval},function(data){
            $('#emsDash').append(data);
            $('#ercDash').hide();
            alert(data)
        });
		tabs.forEach((tab)=>{
			tab.classList.remove("active");
		})
		tab.classList.add("active");
		var tabval = tab.getAttribute("data-tabs");

		all.forEach((item)=>{
			item.style.display = "none";
		})

		if(tabval == "male"){
			males.forEach((male)=>{
				male.style.display = "block";
			})
		}
		else if(tabval == "female"){
			females.forEach((female)=>{
				female.style.display = "block";
			})
		}
		else{
			all.forEach((item)=>{
				item.style.display = "block";
			})
		}

	})
})
</script>
</html>