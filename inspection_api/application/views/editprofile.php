<!DOCTYPE html>
<html>

<head>

    <head>

        <meta charset="UTF-8">
        <title>Assisted Living</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">


        <link href="<?php echo base_url() ?>public/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>public/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>public/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>public/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!----------BOOTSTRAP DATEPICKER----------------------------->
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/datepicker/css/datepicker.css">
        <!---------------------------------------------------------->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <div style="position:fixed; bottom: 0; right: 0; width: 67%; border: 2px solid #CCC; top:200px; z-index:1001; background-color: #FFF; display:none;" id="ad2">
        <span style="right: 0; position: fixed; cursor: pointer; z-index:1002" onclick="closeAd('ad2')">CLOSE</span>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Payroll Management System -->
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3182624105910612" data-ad-slot="4635770289" data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>


        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Assisted Living -->
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3182624105910612" data-ad-slot="3101991489" data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>


        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Grading System -->
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3182624105910612" data-ad-slot="6132191885" data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>

        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- HMS Website -->
        <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3182624105910612" data-ad-slot="1562391480" data-ad-format="auto"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>

<body class="skin-blue">
    <!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH . 'views/include/header.php'); ?>

    <div class="wrapper row-offcanvas row-offcanvas-left">

        <?php require_once(APPPATH . 'views/include/sidebar.php'); ?>

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Add User</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url() ?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Add User</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">


                <div class="row">
                    <div class="col-md-12">
                        <form role="form" method="post" action="<?php echo base_url() ?>myprofile/editprofile" onSubmit="return confirm('Are you sure you want to save?');">
                            <input class="form-control input-sm" name="userid" id="userid" type="hidden" style="width: 100px;" required readonly value="">
                            <div class="box">

                                

                                <div class="box-body table-responsive">


                                    <div class="nav-tabs-custom">
                                        <!-- <ul class="nav nav-tabs">
                                            <li class="active"><a href="#tab_1" data-toggle="tab">User Information</a></li> -->
                                            <!-- <li><a href="#tab_2" data-toggle="tab">Contact Information</a></li>
                                            <li><a href="#tab_3" data-toggle="tab">Profile Picture</a></li> -->
                                        <!-- </ul> -->
                                        <div class="tab-content">
                                        <a href="<?php echo base_url();?>app/dashboard" class="btn btn-primary">Back</a>
                                            <div class="tab-pane active" id="tab_1">
                                                <!-- <table cellpadding="3" cellspacing="3" width="100%">
                                                    <tr>
                                                    	<td colspan="2">Required fields = <font color="#FF0000">*</font></td>
                                                    </tr>
                                                    <tR>
                                                    	<td colspan="2">
                                                        <?php echo validation_errors(); ?>    
                                                        <?php echo $message; ?>    
                                                        </td>
                                                    </tR>
                                                    <tr>
                                                    	<td width="12%">Last Name <font color="#FF0000">*</font></td>
                                                        <td width="88%">
                                                        <?php echo form_input('lastname', set_value('lastname', $user->lastname), 'id="lastname" class="form-control input-sm" placeholder="Last Name" style="width: 250px;" required'); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>First Name <font color="#FF0000">*</font></td>
                                                        <td>
                                                        <?php echo form_input('firstname', set_value('firstname', $user->firstname), 'id="firstname" class="form-control input-sm" placeholder="First Name" style="width: 250px;" required'); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>Middle Name <font color="#FF0000">*</font></td>
                                                        <td>
                                                        <?php echo form_input('middlename', set_value('middlename', $user->middlename), 'id="middlename" class="form-control input-sm" placeholder="Middle Name" style="width: 250px;" required'); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>Birthday <font color="#FF0000">*</font></td>
                                                        <td>
                                                        <?php echo form_input('birthday', set_value('birthday', $user->birthday), 'id="birthday" class="form-control input-sm" placeholder="Birthday" style="width: 150px;" required'); ?> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>Birth Place</td>
                                                        <td>
                                                        <?php echo form_input('birthplace', set_value('birthplace', $user->birthplace), 'id="birthplace" class="form-control input-sm" placeholder="Birth Place" style="width: 380px;"'); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="12%">Gender</td>
                                                        <td width="88%">
                                                        	<select name="gender" id="gender" class="form-control input-sm" style="width: 100px;">
                                                            	<option value="">- Gender -</option>
                                                                <?php
                                                                foreach ($gender as $gender) {
                                                                    if ($_POST['gender'] == $gender->param_id || $user->gender == $gender->param_id) {
                                                                        $selected = "selected='selected'";
                                                                    } else {
                                                                        $selected = "";
                                                                    }
                                                                ?>
                                                            	<option value="<?php echo $gender->param_id; ?>" <?php echo $selected; ?>><?php echo $gender->cValue; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td width="12%">Civil Status</td>
                                                        <td width="88%">
                                                        	<select name="civil_status" id="civil_status" class="form-control input-sm" style="width: 140px;">
                                                            	<option value="">- Civil Status -</option>
                                                                <?php
                                                                foreach ($civilStatus as $civilStatus) {
                                                                    if ($_POST['civil_status'] == $civilStatus->param_id || $user->civil_status == $civilStatus->param_id) {
                                                                        $selected = "selected='selected'";
                                                                    } else {
                                                                        $selected = "";
                                                                    }
                                                                ?>
                                                            	<option value="<?php echo $civilStatus->param_id; ?>" <?php echo $selected; ?>><?php echo $civilStatus->cValue; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                        </table> -->
                                                <div class="row user-row">
                                                    <div class="col-md-12">
                                                        <?php echo validation_errors(); ?>
                                                        <?php $message ?>
                                                    </div>
                                                </div>


                                                <div class="row user-row">
                                                    <div class="col-md-2">

                                                        <label for="fullname">Name <font color="#FF0000">*</font></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="fullname" id="fullname" class="form-control input-sm" placeholder="Name" style="width: 250px;" required>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="gender">Gender <font color="#FF0000">*</font></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="gender" id="gender" class="form-control input-sm" style="width: 250px;" required>
                                                            <option value="">Select Gender</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>

                                                        </select>
                                                    </div>



                                                </div>

                                                <div class="row user-row">

                                                    <div class="col-md-2">
                                                        <label for="mobile">Mobile No <font color="#FF0000">*</font></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="tel" name="mobile" id="mobile" class="form-control input-sm" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" maxlength="10" class="form-control mobile" placeholder="Mobile Number" style="width: 250px;" required>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="email">Email</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="email" name="email" id="email" class="form-control input-sm" placeholder="Enter Email" style="width: 250px;">
                                                    </div>


                                                </div>

                                                <div class="row user-row">

                                                    <div class="col-md-2">
                                                        <label for="mobile">Date Of Birth<font color="#FF0000">*</font></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="date" id="birthday" class="form-control input-sm" name="birthday" style="width: 250px;" required>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="email">Joining Date<font color="#FF0000">*</font></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="date" name="joindate" id="joindate" class="form-control input-sm" style="width: 250px;" required>
                                                    </div>


                                                </div>
                                                <div class="row user-row">


                                                    <div class="col-md-2">
                                                        <label for="state">State <font color="#FF0000">*</font></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="state" id="state" class="form-control input-sm" style="width: 250px;" required>
                                                            <option value="">Select State</option>
                                                            <?php foreach ($state as $st) { ?>
                                                                <option value="<?php echo $st['st_id']; ?>"><?php echo $st['st_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="dist">District <font color="#FF0000">*</font></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="dist" id="dist" class="form-control input-sm" style="width: 250px;" required>
                                                            <option value="">Select District</option>
                                                            <?php foreach ($dist as $dst) { ?>
                                                                <option value="<?php echo $dst['dst_id']; ?>"><?php echo $dst['dst_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>


                                                </div>

                                                <div class="row user-row">

                                                    <div class="col-md-2">
                                                        <label for="city">City <font color="#FF0000">*</font></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="city" id="city" class="form-control input-sm" placeholder="City" style="width: 250px;" required>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="address">Address</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="address" id="address" class="form-control input-sm" placeholder="Address" style="width: 250px;">
                                                    </div>

                                                </div>


                                                <div class="row user-row">
                                                    <div class="col-md-2">
                                                        <label for="group">Group <font color="#FF0000">*</font></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="group" id="group" class="form-control input-sm" style="width: 250px;">
                                                            <option value="">Select Group</option>
                                                            <?php foreach ($group as $grp) { ?>
                                                                <option value="<?php echo $grp['gcode']; ?>"><?php echo $grp['gpname']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="ref_id">User Id <font color="#FF0000">*</font></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="ref_id" id="ref_id" class="form-control input-sm" placeholder="Enter User Id" style="width: 250px;" required>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit"><i class="fa fa-save"></i> Save</button>
                                            </div>
                                            <!-- <div class="tab-pane" id="tab_2">
                                                <table cellpadding="3" cellspacing="3" width="100%">
                                                    <tr>
                                                        <td colspan="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="14%">No. of House</td>
                                                        <td width="86%">
                                                            <?php echo form_input('noofhouse', set_value('noofhouse', $user->street), 'id="noofhouse" class="form-control input-sm" placeholder="No. of House" style="width: 250px;"'); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="14%">Brgy./Subd.</td>
                                                        <td width="86%">
                                                            <?php echo form_input('brgy', set_value('brgy', $user->subd_brgy), 'id="brgy" class="form-control input-sm" placeholder="Brgy./Subd." style="width: 250px;"'); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="14%">City/Province</td>
                                                        <td width="86%">
                                                            <?php echo form_input('province', set_value('province', $user->province), 'id="province" class="form-control input-sm" placeholder="City/Province" style="width: 250px;"'); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="14%">Mobile No.</td>
                                                        <td width="86%">
                                                            <?php echo form_input('mobile', set_value('mobile', $user->mobile_no), 'id="mobile" class="form-control input-sm" placeholder="Mobile No" style="width: 250px;"'); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="14%">Phone No.</td>
                                                        <td width="86%">
                                                            <?php echo form_input('phone', set_value('phone', $user->phone_no), 'id="phone" class="form-control input-sm" placeholder="Phone No." style="width: 250px;"'); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="14%">Email Address <font color="#FF0000">*</font>
                                                        </td>
                                                        <td width="86%">
                                                            <?php echo form_input('email', set_value('email', $user->email_address), 'id="email" class="form-control input-sm" placeholder="Email Address" style="width: 250px;" required'); ?>
                                                        </td>
                                                    </tr>
                                                    <input type="hidden" name="username" id="username" value="<?php echo $user->username; ?>">
                                                </table>
                                            </div> -->
                                            <!-- <div class="tab-pane" id="tab_3">
                                                <iframe width="100%" frameborder="0" height="400" src="<?php echo base_url() ?>app/user/upload_picture/<?php echo $user->user_id ?>"></iframe>
                                            </div> -->

                                        </div>

                                
                                    </div>





                                </div>

                            </div>
                    </div>
                    </form>
                </div>


            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->


    <script src="<?php echo base_url(); ?>public/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>public/js/AdminLTE/app.js" type="text/javascript"></script>

    <!-- BDAY -->
    <!-- <script src="<?php echo base_url(); ?>public/datepicker/js/jquery-1.9.1.min.js"></script> -->
    <!-- <script src="<?php echo base_url(); ?>public/datepicker/js/bootstrap-datepicker.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">


    <script type="text/javascript">
        $('.mobile').keypress(function(e) {
            var arr = [];
            var kk = e.which;

            for (i = 48; i < 58; i++)
                arr.push(i);

            if (!(arr.indexOf(kk) >= 0))
                e.preventDefault();
        });
    </script>
    <!-- END BDAY -->

</body>
<style>
    .user-row {
        margin-top: 10px;
    }
</style>

</html>