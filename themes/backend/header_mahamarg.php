<?php
$CI = EMS_Controller::get_instance();

//$CI = get_instance(); 

$user_info = $CI->session->userdata('current_user');

$current_user = $CI->session->userdata('current_user');


?>

<div class="container" style="max-width: 100%;">
    <div class="row" id="headermain" style="background-color:#f7f7f7;">
        <div class="col-md-2 align-items-left">
            <a href="#">
                <img class="mahaimg" src="<?php echo base_url(); ?>assets/images/mahamarg.png" alt="National Health Mission" />
            </a>
        </div>
        <div class="col-md-7 align-items-right" style="text-align: center">
            <label class="mahalbl">MP SAMRUDDHI MAHAMARG</label>
        </div>
        <div class="col-md-1 pad_0 text_right">
            <img class="mahaimg2" src="<?php echo base_url(); ?>assets/images/BVG_logo_big.png" alt="National Health Mission" />
        </div>
        <div class="col-md-1 pad_0 text_left">
            <img class="mahaimg4" src="<?php echo base_url(); ?>assets/images/Bvg_spero.png" alt="National Health Mission" />
        </div>

        <div class="col-md-1 text_right" >
        <a class="logout_open head_logout_lnk click-xhttp-request" style="cursor: pointer;" data-href="{base_url}Clg/logout" data-qr="output_position=content"><img class="mahaimg3" title="Logout"  src="<?php echo base_url(); ?>assets/images/mahalog.png" alt="Logout" /></a> 

    </div>
    </div>

    <div class="row" id="headermb" style="background-color:#085B80;">
        <div class="col-md-12" id="headermb2">
            <div class="align-items-left">
                <a href="#">
                    <img style="padding:5px;" src="<?php echo base_url(); ?>assets/images/logo.png" alt="National Health Mission" />
                </a>
            </div>

            <div class="" style="padding-top:15px">
                <span style="padding-top:50px;color: #F4F6F7;font-size:15px;" class="" id=''><?php echo date("d-m-Y h:i:s A"); ?> </span>
            </div>

            <!--<div class="" style="text-align: right;">
                <a href="#">
                    <img src="<?php echo base_url(); ?>assets/images/bvg_logo.png" alt="National Health Mission" />
                </a>
            </div>-->
        </div>
        <div class="col-md-12">
            <div class="col-md-8 align-items-right" style="text-align: center">
                <label style="padding-top:10px;text-align:center;font-size:20px;font-weight:bold;color:#F4F6F7;">MP EMERGENCY MEDICAL SERVICES</label>
            </div>
        </div>

    </div>
</div>


<script src="<?php echo base_url(); ?>assets/js/functions.js"></script>

<style>
    .text_left{
        text-align: left !important;
    }
    .text_center{
        text-align: center !important;
    }
    .text_right{
        text-align: right !important;
    }
    .pad_0 {
        padding: 0px !important;
    }

    .mahaimg2 {
        margin: 5px;
        height: 7vh;
    }
    .mahaimg4 {
        margin-top: 10px;
        margin-left: 10px;

        height: 5vh;
    }
    .mahaimg3 {
        margin-top: 10px;
        padding: 5px !important;
        height: 5vh !important;
    }
    .mahalbl {
        /* padding-top: 5px; */
        text-align: center;
        font-size: 30px;
        font-weight: 500;
        color: #000080;
    }

    .mahaimg {
        padding: 5px !important;
        height: 9vh !important;
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