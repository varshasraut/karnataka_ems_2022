 <style>
     img {
    vertical-align: middle;
    /* width: 200px; */
}
.btn.btn-primary {
    background-color: #154068;
    border-color: #ffdc96;
}
 </style>
 <script language="javascript">
    setTimeout(function timeru(){$('.alert').fadeOut(1000)}, 3000);
   </script> 
<header class="header" style=" background-color:#ffdc96; repeat-x; background-size: 100% 100%;">
    <a href="#" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        <div class="logo-pms"><img src="<?php echo base_url()?>public/company_logo/logo.png" width="50%" height="45" ></div>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation" style=" background-color: #ffdc96; repeat-x; background-size: 100% 100%;">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="logo2"> 
                <?php echo $companyInfo->company_name?>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
              
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span>
                            
                            <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <?php if($userInfo->picture == ""){?>
                    	<img src="<?php echo base_url()?>public/user_picture/no_avatar.gif" class="img-circle" alt="User Image" />
                    <?php }else{?>
                    	<img src="<?php echo base_url()?>public/user_picture/<?php echo $userInfo->picture;?>" class="img-circle" alt="User Image" />
                    <?php }?>
                            <p>
                                <?php echo $userInfo->firstname." ".$userInfo->lastname;?> <br /> <?php echo $userInfo->designation;?>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo base_url()?>myprofile" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo base_url()?>login/logout" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>





<script type="text/javascript">
function closeAd(id)
{
    $('#' + id).remove();
}
</script>
