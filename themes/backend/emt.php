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
{styles}

{javascripts}
</head>

<body id="container" class="{activemenu}" data-ng-controller="NotificationCenter">
 <div id="popupconitainer" style="width:0px; height:0px; overflow:hidden;" ></div>   
<div id="mi_loader" class="mi_loader"></div> 
<div id="processbar">
  <div id="message" style="display:block;">
    <div id="request" ></div>
    <div id="usrresponse" >{message}</div>
  </div>
</div>
<div class="header">
  <div id="header_main" class="brg_clr6">{header}</div>
</div>
<div class="contentpan">
        <div class="leftsidebar collapse">
          <div id="profile" class="brg_clr5"> {profile} </div>
          <div id="" class="brg_clr5 left_side_menu_scroll"> {leftsidebar} </div>
          
        </div>

    <div class="hide_button show_button" style="left: 53px;"></div>
        <div id="rightsidecontent" style="margin-left: 50px;">
          <div class="content" align="left" >
              <div id="filter_data"> {filter_data} </div>
            <div class="content_pan" style="vertical-align: top">
                <div id="content_main">
                       <div id="schedule_student_top"></div>
                       <div id="pcr_top_steps">{pcr_top_steps}</div>
                       <div id="content"> {content}</div>
               
                </div>
            </div>
            <div id="profiler" style="vertical-align: top; width:1100px;">{profiler}</div>
          </div>
        </div>
</div>
    
    <div id="lockscreen"> {user_screen_lock_view} </div>
        {footer}
    <div id="dialerscreen"> {user_dialer_view} </div>
</body>
</html>


