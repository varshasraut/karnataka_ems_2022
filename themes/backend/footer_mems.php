<?php
$CI = EMS_Controller::get_instance();

//$CI = get_instance(); 

$user_info = $CI->session->userdata('current_user');

$current_user = $CI->session->userdata('current_user');

?>
<footer class="footer">

    <div class="container" style="max-width: 100%;">
    <div class="row" style="background-color: #2F419B;">
        <div class="col-md-1 p-0 m-0">
            <span style="float: left;"><img class="footer_image" src="<?php echo base_url(); ?>assets/images/jaes_logo.png"></span>

        </div>
        <div class="col-md-10 align-items-right" style="text-align: center">
            <MARQUEE WIDTH=100% HEIGHT=50>

                <div class="align-items-center">

                    <div style="color: white;padding-top: 10px;font-family: 'Poppins', sans-serif;font-weight: 500;font-size: 22px;text-transform: uppercase;">MADHYA PRADESH INTEGRATED REFERRAL TRANSPORT SYSTEM</div>

                </div>

            </MARQUEE>
        </div>

        <div class="col-md-1 pr-0" >
            <span class="float_right"><img class="footer_image1" src="<?php echo base_url(); ?>assets/images/Spero_logo1.png"></span>

        </div>
    </div>


        <div class="row" id="mbfooter" style="background-color: #085B80;">
            <div class="col-md-12" id="mbfooter3" style="text-align: left;">
                <!--<a href="#">
                    <img style="padding-top:7px;height:55px;width:70px;" src="<?php echo base_url(); ?>assets/images/mahalogo.jpg" alt="BVG" />

                </a>-->
                <!-- <div class="" id="mainvstr">
            <?php if($current_user->clg_group == 'UG-EMSCOORDINATOR' ){ ?>
                <div id="ftrvstr">
                </div>
            <?php } else {?>
            <div id="ftrvstr">
                    <label for="">Total Visitors :</label>
                    <label class="" id=""><?php echo $visitors_count_mb?></label>
                </div>
             <?php  }?>
            
            </div> -->
            <div class="justify-content-center text-right">

                <a style="padding:15px;padding-top:15px;color: white;" class="logout_open head_logout_lnk" href="{base_url}Clg/logout" data-popup-ordinal="0"><img title="Logout" src="<?php echo base_url(); ?>assets/images/logout.png" alt="Logout"></a>
            </div>
            </div>
            <div class="col-md-12 align-items-right" style="text-align: center">
                <MARQUEE WIDTH=100% HEIGHT=50>

                    <div class="align-items-center">

                        <div style="color: white;padding-top: 10px;font-family: 'Poppins', sans-serif;font-weight: bold;font-size: 22px;text-transform: uppercase;">Madhya Pradesh Emergency Medical Services</div>

                    </div>

                </MARQUEE>
            </div>

           
        </div>
    </div>
</footer>


<!-- END HEADER DESKTOP -->







<!-- Jquery JS-->

<!-- <script src="<?php //echo base_url(); 
                    ?>assets/vendor/jquery-3.2.1.min.js"></script> -->

<!-- <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>  -->
<script src="<?php echo base_url(); ?>assets/js/functions.js"></script>

<script src="<?php echo base_url(); ?>assets/js/raphael-min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/morris.min.js"></script>

<!-- Bootstrap JS-->

<script src="<?php echo base_url(); ?>assets/vendor/bootstrap-4.1/popper.min.js"></script>



<!-- Vendor JS       -->

<script src="<?php echo base_url(); ?>assets/vendor/slick/slick.min.js"></script>

<script src="<?php echo base_url(); ?>assets/vendor/wow/wow.min.js"></script>

<script src="<?php echo base_url(); ?>assets/vendor/animsition/animsition.min.js"></script>

<script src="<?php echo base_url(); ?>assets/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>

<!-- <script src="<?php echo base_url(); ?>assets/vendor/counter-up/jquery.waypoints.min.js"></script>

<script src="<?php echo base_url(); ?>assets/vendor/counter-up/jquery.counterup.min.js"></script>

<script src="<?php echo base_url(); ?>assets/vendor/circle-progress/circle-progress.min.js"></script>

<script src="<?php echo base_url(); ?>assets/vendor/perfect-scrollbar/perfect-scrollbar.js"></script> -->

<!-- Main JS-->

<script src="<?php echo base_url(); ?>assets/js/main.js"></script>



</body>
<style>
    /* .container-fluid{
        padding: 0px !important;
    } */
    #ftrvstr {
        width: 100%;
        font-size: 17px;
        font-weight: bold;
        padding: 15px 0px 15px 0px;
        font-family: Lucida Grande, Lucida Sans, Arial, sans-serif;
    }
    #mainvstr{
    text-align: right;
    display: flex;
    }
#mbfooter3{
    display: flex;
    align-content: stretch;
    justify-content: space-between;
   
}
    @media screen and (max-width: 500px) {
  #mainfooter {
 
    display: none !important;

  }
  #mainvstr{
    text-align: center;
    }
}
@media screen and (min-width: 500px) {
  #mbfooter {
 
    display: none !important;

  }
}
.footer{
    z-index: 11;
}
</style>
</html>

<!-- end document-->