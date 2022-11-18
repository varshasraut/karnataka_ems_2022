<!DOCTYPE HTML>

<html>
    <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

    <body id="container" style="background:#F3F1F1 !important" class="{activemenu}" data-ng-controller="NotificationCenter" >
        <div id="popupconitainer" style="width:0px; height:0px; overflow:hidden;" ></div>   
       
        <div id="mi_loader" class="mi_loader"></div> 
        <div class="calls_main">
            <div id="processbar">
                <div id="message" style="display:block;">
                    <div id="request" ></div>
                    <div id="usrresponse" >{message}</div>
                </div>
            </div>
            <div class="header">
                <div id="header_main" class="brg_clr6">{mp_header}</div>
            </div>
            <div class="pcr_contentpan mt_atnd_calls">
                <div id="procesing_custom_script">
                </div>
                <div id="procesing_hide_custom_script">
                </div>
               
                <div id="filter_data"> {filter_data} </div>
                <div id="call_detail"></div>
                <div id="content">
                    {content}
                </div>
            </div>
            <!--    <div class="next_pre_outer">
                        <a href="#" class="next_btn btn float_left"> < Prev </a>
                        <a href="#" class="next_btn btn float_right"> Next > </a>
                    </div>-->
            <div id="lockscreen"> {user_screen_lock_view} </div>
            {mp_footer}
               <div id="dialerscreen"> {user_dialer_view} </div>
        </div>
        <div id="profiler" style="vertical-align: top; width:1100px;">{profiler}</div>
    </body>
</html>


<style>
    #content{
        min-height: 100vh !important;
        font-size: 14px !important;
    }
    #header_main{
        height: 57px !important;
    }
</style>

