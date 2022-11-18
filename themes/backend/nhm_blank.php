<!DOCTYPE HTML>

<html>
    <head>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta content="utf-8" http-equiv="encoding">
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{title}</title>
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!--<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/morris.css"> -->
    <link href="<?php echo base_url(); ?>assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <script type="text/javascript" > var base_url = '{base_url}'; </script>
    <script type="text/javascript" > var base_url = '{base_url}'; </script>
    <script src="<?php echo base_url(); ?>assets/js/gijgo.min.js" type="text/javascript"></script>
    <link href="<?php echo base_url(); ?>assets/css/gijgo.min.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="{css_path}/jquery-ui.css">
    
    <link href="<?php echo base_url(); ?>assets/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">     <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <!--<link href="<?php echo base_url(); ?>assets/vendor/wow/animate.css" rel="stylesheet" media="all">-->
    <link href="<?php echo base_url(); ?>assets/css/theme.css" rel="stylesheet" media="all">
<!--<link rel="stylesheet" type="text/css" href="{css_path}/colorbox.css">-->

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="http://www.instinctcoder.com/wp-content/uploads/2014/02/tabnavi.js"></script>
<link href="http://js.api.here.com/v3/3.1/mapsjs-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
<script type="text/javascript" src="{js_path}/comman.js?t=2.4"></script>
    {javascripts}
 
    </head>
    <script>
  $(function () {
    $( "#tabs" ).tabs();
 
  });
 </script>
   <!-- <script>
    window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
    </script>-->
<style>

.paddindOverRide{
    padding: 0px 1px;
   
}   
.footer {
    position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
 
   color: white;
   text-align: center;
} 
    .NHM_Dashboard {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  
}

.NHM_Dashboard td, #NHM_Dashboard th {
  border: 1px solid black;
  text-align: center;
  width: 15%;
  padding: 0px;
}


.NHM_Dashboard tr:nth-child(even){background-color: #f2f2f2;}
.NHM_Dashboard tr:nth-child(odd){background-color: #f2f2f2;}

.NHM_Dashboard tr:hover {background-color: #ddd;}

.NHM_Dashboard th {
  
  text-align: center;
  background-color: #085B80;
  color: white;
  font-weight:normal;
  font-size:17px;
  border: 1px solid black;
  
}
.NHM_Dashboard td {
  
  text-align: center;
  
   font-weight:normal;
  font-size:14px;
  border: 1px solid black;
  
}

#popup_div .txt_clr2 {
    margin-top:0px !important;
}
#popup_div table > tbody > tr > td {
   min-height: 30px;
}
#popup_div table > tbody > tr:nth-child(2n) > td {
    background-color: #F3F3F3;
}
#content .field_row .filed_input, #popup_div .field_row .filed_input {
    position: relative;
}
#content .field_row .filed_input input[type="file"], #popup_div .field_row .filed_input input[type="file"], #catalog_file {
    height: 33px;
    margin-top: 10px;
}
a.lnk_icon_btns {
    border: 1px solid #ffffff;
    padding: 5px 7px 5px 7px;
    border-radius: 50px;
    font-size: 14px;
    background: #ffffff!important;
    color: #085b80;
}
.head .profile_content .profile_box .head_links a.break_lnk{
    background: url('../images/break.png') no-repeat 10px 5px;
}

.mi_autocomplete {
    background: rgb(255,255,255) url('../images/drop_down_arrow.png') right center no-repeat !important;
    background-position: 97% !important;
    padding-right: 27px !important;
}
.mi_loader {
    border: 6px solid #00FFFF;
    border-top: 6px solid #085b80;
    border-bottom: 6px solid #085b80;
    background-color: #FFFFFF;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    text-align: center;
    animation: spiner 2s linear infinite;
    -webkit-box-shadow: 0px 0px 10px 1px rgba(64,64,64,1);
    -moz-box-shadow: 0px 0px 10px 1px rgba(64,64,64,1);
    box-shadow: 0px 0px 10px 1px rgba(64,64,64,1);
    position: fixed;
    left: calc(-50vw - 45px);
    right: calc(-50vw - 45px);
    top: calc(-50vh - 40px);
    bottom: calc(-50vh - 40px);
    margin: auto;
    z-index: 99999;
}
</style>
    <body  class="container-fluid" id="container">
        <!-- <div id="popupconitainer" style="width:0px; height:0px; overflow:hidden;" ></div>   -->
<div id="mi_loader" class="mi_loader"></div> 
       
        <div id="content" >
             {content}
        </div>
         
      
    </body>
    
</html>


