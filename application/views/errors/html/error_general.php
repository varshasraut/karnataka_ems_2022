<?php defined('BASEPATH') OR exit('No direct script access allowed');
echo "general";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>EMS: Down for maintenance.</title>
<style type="text/css">
::selection {
	background-color: #E13300;
	color: white;
}
::-moz-selection {
background-color: #E13300;
color: white;
}
body {
	background: #99ccff url({base_url}themes/frontend/images/grill_tec.png);
	margin: 40px;
	font: 20px Arial, Helvetica, sans-serif;
	color: #FFFFFF;
}
a {
	color: #FFFFFF;
	background-color: transparent;
	font-weight: bold;
}
h1 {
	background: url({base_url}themes/frontend/images/alert_task_reshedule.png) left center no-repeat;
	display:inline-block;
	width:98%;
	color: #FFFFFF;
	font-size: 20px;
	font-weight: normal;
	margin: 5px;
	padding: 5px 5px 5px 35px;
}
.center {
	position: absolute!important;
	top:0!important;
	bottom: 0!important;
	left: 0!important;
	right: 0!important;
	margin: auto!important;
}
.box {
	-webkit-box-shadow: 0px 0px 20px 10px #0099ff;
	-moz-box-shadow: 0px 0px 20px 10px #0099ff;
	box-shadow: 0px 0px 20px 10px #0099ff;
	-webkit-border-radius:10px;
	-moz-border-radius:10px;
	border-radius:10px;
	border:2px solid #3399cc;
	font-size:16px;
	background-color: #99ccff;
}
p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="center"><div class="center box" style=" width:50%; height:50%">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="border-bottom:1px solid #FFF" align="left">	<h1><?php echo $heading; ?></h1></td>
          </tr>
          <tr>
            <td style="text-align:center" align="center">
		<?php echo $message; ?></td>
          </tr>
        </table>
      </div></td>
  </tr>
</table>
</body>
</html>