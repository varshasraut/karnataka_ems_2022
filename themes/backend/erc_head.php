<?php
$CI = EMS_Controller::get_instance();

//$CI = get_instance(); 

$user_info = $CI->session->userdata('current_user');

$current_user = $CI->session->userdata('current_user');


?>

<div class="container-fluid container p-0" style="max-width: 100%;">
    <div class="row" id="headermain" style="background-color:#2F419B !important;">
        <div class="col-md-1 pl-0">
            <span style="float: left;"><img class="header_image" src="<?php echo base_url(); ?>assets/images/108_logo.png"></span>

        </div>
        <div class="col-md-8 align-items-right" style="text-align: center">
            <label style="padding-top:10px;text-align:center;font-size:25px;font-weight:bold;color:#F4F6F7;">MADHYA PRADESH INTEGRATED REFERRAL TRANSPORT SYSTEM</label>
        </div>
        <div class="col-md-2 pl-0 pr-0" style="padding-top:13px">

            <span style="color: #F4F6F7;font-size:19px;font-weight:bold;" class="clock" id='ct5'> </span>
        </div>
        <div class="col-md-1 pr-0">
            <!-- <a id="open_74181851" alt="Logout" class="logout_open click-xhttp-request" data-href="{base_url}Clg/logout" data-popup-ordinal="0" data-qr="output_position=content"><i class="fa fa-sign-out pt-2" alt="Logout" style="font-size:35px;color:white;padding-top:5px;" data-toggle="tooltip" data-placement="top" title="Logout"></i></a> -->
            <a class="logout_open head_logout_lnk" href="{base_url}Clg/logout"><i class="fa fa-sign-out pt-2" alt="Logout" style="font-size:35px;color:white;padding-top:5px;" data-toggle="tooltip" data-placement="top" title="Logout"></i></a>

            <img class="header_image1" src="<?php echo base_url(); ?>assets/images/NHM.png">

        </div>
    </div>

    <div class="row pl-0 pr-0" id="headermb" style="background-color:#2F419B;">
        <div class="col-md-12 pl-0 pr-0" id="headermb2">
            <div class="align-items-left">
                <a href="#">
                    <span style="float: left;"><img class="header_image" src="<?php echo base_url(); ?>assets/images/108_logo.png"></span>
                </a>
            </div>

            <div>
                <a class="logout_open head_logout_lnk" href="{base_url}Clg/logout"><i class="fa fa-sign-out pt-2" alt="Logout" style="font-size:35px;color:white;padding-top:5px;" data-toggle="tooltip" data-placement="top" title="Logout"></i></a>

                <img class="header_image1" src="<?php echo base_url(); ?>assets/images/NHM.png">
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-8 align-items-right" style="text-align: center">
                <label style="padding-top:10px;text-align:center;font-size:20px;font-weight:bold;color:#F4F6F7;">MADHYA PRADESH EMERGENCY INTEGRATED REFERRAL TRANSPORT SYSTEM</label>
            </div>
        </div>

    </div>
</div>

<!--<script src="<?php echo base_url(); ?>assets/js/functions.js"></script>-->

<style>
    .header_image {
        height: 55px;
        width: 52px;

    }

    .header_image1 {
        height: 55px;
        width: 52px;
        float: right;
    }

    #headermb2 {
        display: flex;
        align-content: stretch;
        justify-content: space-between;
    }

    @media screen and (max-width: 500px) {
        #headermain {

            display: none !important;

        }
    }

    @media screen and (min-width: 500px) {
        #headermb {

            display: none !important;

        }
    }
</style>
<script>
    $('#container').on('click', '.click-xhttp-request', function() {


        if ($(this).data('confirm') == 'yes') {

            if (window.confirm($(this).data('confirmmessage'))) {

            } else {

                return false;

            }

        }

        var qr = $(this).data('qr');

        if (qr != "") {

            $.each(qr.split('&'), function(c, q) {

                var i = q.split('=');

                //queries[i[0].toString()] = i[1].toString();
                var str = i[1].toString();
                str = str.replace(/(<([^>]+)>)/ig, '');

                //request_setting[i[0].toString()] = i[1].toString();
                request_setting[i[0].toString()] = str;

            });

        }

        /// $('#'+queries.module_name+'_position').attr('class',queries.tool_code);	 

        $('#content').attr('class', request_setting.tool_code);

        $('#leftsidebar').attr('class', request_setting.tool_code);

        if (request_setting.showprocess != "no") {

            $('#container').attr('class', request_setting.module_name);

            if (active_nav) {

                active_nav.closest("li[class^='module']").removeClass('active_nav');

                active_nav.removeClass('active_nav');

            }

            active_nav = $(this);

            $("li[class^='module']").removeClass('active_nav');

            $(this).closest("li[class^='module']").addClass('active_nav');

            $(this).addClass('active_nav');

        }

        xhttprequest($(this), '', '');

        return false;

    });
</script>
<script>
    function join(t, a, s) {
        function format(m) {
            let f = new Intl.DateTimeFormat('en', m);
            return f.format(t);
        }
        return a.map(format).join(s);
    }

    let a = [{
        day: '2-digit'
    }, {
        month: 'short'
    }, {
        year: 'numeric'
    }];
    let x = join(new Date, a, '-');
    console.log(x);

    function display_ct5() {
        var current = new Date();
        var y = current.toLocaleTimeString('en-GB');

        document.getElementById('ct5').innerHTML = x + ' ' + y;
        display_c5();
    }

    function display_c5() {
        var refresh = 1000; // Refresh rate in milli seconds
        mytime = setTimeout('display_ct5()', refresh)
    }
    display_c5()
</script>