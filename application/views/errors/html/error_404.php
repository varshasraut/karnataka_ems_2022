<?php

defined('BASEPATH') OR exit('No direct script access allowed');


?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="utf-8">

<title>404 Page Not Found</title>

<style type="text/css">



::selection { background-color: #E13300; color: white; }

::-moz-selection { background-color: #E13300; color: white; }



body {

	background: #db5d5d url("{base_url}themes/frontend/images/grill_tec.png");

	margin: 40px;

	font: 20px  Arial, Helvetica, sans-serif;

	color: #FFFFFF;

}



a {

	color: #FFFFFF;

	background-color: transparent;

	font-weight: bold;



}



h1 {

	background: url("{base_url}themes/frontend/images/alert_task_error.png") left center no-repeat;

	

	display:inline-block;

	width:98%;	

	color: #FFFFFF;

	font-size: 20px;

	font-weight: normal;

	margin: 5px;

	padding: 5px 5px 5px 35px;

}







.center{

    position: absolute!important;

    top:0!important;

    bottom: 0!important;

    left: 0!important;

    right: 0!important;

    margin: auto!important;

}

.box{-webkit-box-shadow: 0px 0px 20px 10px #cc0000;-moz-box-shadow: 0px 0px 20px 10px #cc0000;box-shadow: 0px 0px 20px 10px #cc0000;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;border:2px solid #ff0000; font-size:16px;background-color: #db5d5d;}



p {

	margin: 12px 15px 12px 15px;

}

</style>

</head>

<body>

	<table width="100%" border="0" cellspacing="0" cellpadding="5">

  <tr>

    <td align="center"><div class="center box" style=" width:50%; height:50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td style="border-bottom:1px solid #FFF"><h1>Error 404- Page Not Found</h1></td>

  </tr>

  <tr>

    <td style="text-align:center" align="center"><br><br>

    Sorry, but we couldn't find the page or file you want to open.<br><br>

    This page or file may have been moved or renamed.<br><br>

    Please visit our <a href="{base_url}">Homepage</a>.

</td>

  </tr>

</table>

 </div></td>

  </tr>

</table>



</body>

</html>