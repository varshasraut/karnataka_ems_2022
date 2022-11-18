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
<!-- <meta http-equiv="refresh" content="60">-->

<title>Emergency Medical Services</title>

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,400italic,600,700,800' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" href="{base_url}themes/backend/images/favicon.ico" type="image/x-icon" />
<link href="{base_url}themes/backend/css/style.css" rel="stylesheet" type="text/css" />
<link href="{base_url}themes/backend/css/style_pages.css" rel="stylesheet" type="text/css" />
<link href="{base_url}themes/backend/css/style_responsive_common.css" rel="stylesheet" type="text/css" />
<link href="{base_url}themes/backend/css/style_responsive.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
  setInterval("my_function();",120000); 
 
    function my_function(){
        window.location = location.href;
    }
</script>
</head>

<body id="container" class="" data-ng-controller="NotificationCenter">
 <div id="popupconitainer" style="width:0px; height:0px; overflow:hidden;" ></div>   
 <div class="header" style="position: relative;">
  <div id="header_main" class="brg_clr6">

<div class="header_wrapper content_pan width100 float_left common_header">

    <div class="head float_left width100" style="background:#fff; height: auto;">

        <div class="content_wrapper margin_auto">

            <div class="outer_spero">
                <div class="header_left_block" style="width: 200px;">

                    <div class="logo_content  float_left" style="width: 200px;">

                        <div class="head_logo_img_wrapper width50 float_left" style="width: 200px;">

                            <a href="{base_url}"><div class="head_logo" style="height: 150px;"></div></a>

                        </div>

                    </div>

                </div>
            

                <div id="section_title" class="logo_label float_left" style="font-size:25px;  width: 70%; text-align: center;">

                <span class="text-centre" style="font-size:65px; width: 100%; border-left: 0px;">

                    
                        Atal Arogya Vahini Dashboard

                </span>

            </div>
 <!--<div class="float_right">
     <img src="{base_url}themes/backend/images/bvg_logo.png" id="imLogo" name="imLogo" alt="BVG" border="0" height="120">
                            </div>-->
           </div>


            
        </div>
        

    </div>

</div>

</div>
</div>

    <div class="hide_button show_button"></div>
        <div id="">
          <div class="content" align="left" >
              <div id="filter_data">  </div>
            <div class="content_pan" style="vertical-align: top">
                <div id="content">
                
        <div id="container">
            <div class="dashboard_heading"></div>

            <div class="dashboard_chart_container">
               
                <div class="box3">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="amb_form" id="amb_list">  
            
        <div id="dash_filters"></div>
            
            <div id="list_table" >
            
            
                <table class="table" style="font-size:70px; font-weight: bold; text-align: center; line-height: 70px;">

                    <tr style="height: 100px;">                                      
                        <th nowrap style="font-size:70px; line-height: 85px;">Calls/<br>Closers</th>
                         <th nowrap style="font-size:70px; line-height: 85px; text-align: center;">Emergency <br>Calls</th>
                        <th nowrap style="font-size:70px; line-height: 85px; text-align: center;">Calls  <br>Closers</th>
                    </tr>
                  
                    <tr style="height: 100px;">
                        
                        
                        <td style="font-size:70px; text-align: left;">2018-Till Date Calls</td>                            
                         <td style="font-size:70px"><?php echo $total_inc?$total_inc:'0';?></td>  
                        <td style="font-size:70px"><?php echo $total_screening;?></td> 
                    </tr>
                    <tr style="height: 100px;">
                        
                      
                        <td style="font-size:70px; text-align: left;"><?php echo date('F');?>- Till Date Calls</td>                             
                        <td style="font-size:70px"><?php echo $nov_today_inc?$nov_today_inc:'0'?></td>  
                        <td style="font-size:70px"><?php echo $nov_screening; ?></td>
                    </tr>
                    <tr style="height: 100px;">
                        
                        
                        <td style="font-size:70px; text-align: left;"><?php echo date('d-m-Y');?> Calls</td>
                        <td style="font-size:70px; text-align: center;"><?php echo $today_inc?$today_inc:'0';; ?></td>  
                        <td style="font-size:70px; text-align: center;"><?php echo $today_screening; ?></td>     
                       
                    </tr>
                   
                </table>

            </div>
        </form>
    </div>
</div>
</div>
            
            
       
            
        </div>
                </div>
            </div>
          </div>
        </div>
</div>
    
                    <div class="footer width100">
                
                                <span class="text_pan"> </span>
                
                
            </div>
</body>
</html>