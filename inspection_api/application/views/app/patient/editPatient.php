<!DOCTYPE html>
<html>

<head>

    <head>
        <style>
            span {
                cursor: pointer;
            }

            .minus,
            .plus {
                width: 35px;
                /* height:20px; */
                background: #f2f2f2;
                border-radius: 4px;
                padding: 8px 5px 8px 5px;
                border: 1px solid #ddd;
                display: inline-block;
                vertical-align: middle;
                text-align: center;
            }

            input {
                /* height:34px;
            width: 100px;
            text-align: center; */
                width: 100px;
                padding: 10px;
                font-size: 26px;
                border: 1px solid #ddd;
                border-radius: 4px;
                display: inline-block;
                vertical-align: middle;
            }

            #counter {
                text-align: center;
            }
        </style>
        <meta charset="UTF-8">
        <title>Assisted Living</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">


        <link href="<?php echo base_url() ?>public/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>public/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>public/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>public/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>

<body class="skin-blue">
    <!-- header logo: style can be found in header.less -->
    <?php require_once(APPPATH . 'views/include/header.php'); ?>

    <div class="wrapper row-offcanvas row-offcanvas-left">

        <?php require_once(APPPATH . 'views/include/sidebar.php'); ?>
        <script language="javascript">
            function validate() {
                if (document.getElementById("email").value == "") {
                    alert('You did not enter a valid Email Address');
                    return false;
                } else {
                    if (confirm('Are you sure you want to save?')) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        </script>
        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Add New Trip</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url() ?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="<?php echo base_url() ?>app/patient/addPatient">Book Now</a></li>
                    <li class="active">Add New Trip</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-6">
                        <form role="form" method="post" action="<?php echo base_url() ?>app/patient/addtrip" onSubmit="return validate()">
                            <input type="hidden" name="id" value="<?php //echo $patientInfo->patient_no;
                                                                    ?>">
                            <div class="box">
                                <div class="box-body table-responsive">
                                    <form>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Name:</label>
                                                <input type="text" name="cust_name" class="form-control" id="inputEmail4" placeholder="Name" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Age:</label>
                                                <input type="number" name="age" class="form-control" id="inputEmail4" placeholder="Name" required>
                                            </div>

                                        </div>
                                        <div class="row">

                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4">Contact Number:</label>
                                                <input type="tel" name="cust_num" class="form-control" id="inputPassword4" placeholder="Contact Number" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" maxlength="10">
                                            </div>


                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4">Select Vehicle Category:</label>
                                                <select class="form-control" name="veh_cat" id="inlineFormCustomSelect">
                                                    <option selected></option>
                                                    <option value="1">Category One</option>
                                                    <option value="2">Category Two</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4">Select Vehicle Type:</label>
                                                <select class="form-control" name="veh_type" id="inlineFormCustomSelect">
                                                    <option selected>Choose...</option>
                                                    <option value="1">Four Seater </option>
                                                    <option value="2">Seven Seater</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4">Select Pic Location:</label>
                                                <input type="text" class="form-control" id="inputPassword4" placeholder="Select Pic Location">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4">No. Of Persons:</label></br>
                                                <span class="minus">-</span><input name="noofperson" type="text" id="counter" value="1" /><span class="plus">+</span>
                                            </div>


                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4">Total Kilometers:</label>
                                                <input type="text" class="form-control" id="inputPassword4" placeholder="Total Kilometers">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4">Fare/Price As Per Route</label>
                                                <input type="number" class="form-control" id="inputPassword4" placeholder="Fare/Price As Per Route">
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="form-group col-md-6">

                                                <!-- <a href="<?php echo base_url(); ?>app/patient" class="btn btn-default">Cancel</a> -->
                                                <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit"><i class="fa fa-save"></i> Save</button>
                                            </div>
                                            </div>
                                    </form>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="col-md-6">

                        <input type="hidden" name="id" value="<?php //echo $patientInfo->patient_no;
                                                                ?>">
                        <div class="box">
                            <div class="box-body table-responsive">
                                <form>
                                    <div class="form-row">
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d15137.212148042669!2d73.83014335!3d18.4699278!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1635413671174!5m2!1sen!2sin" width="590" height="490" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->


    <script src="<?php echo base_url(); ?>public/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>public/js/AdminLTE/app.js" type="text/javascript"></script>

    <!-- BDAY -->
    <script src="<?php echo base_url(); ?>public/datepicker/js/jquery-1.9.1.min.js"></script>
    <script src="<?php echo base_url(); ?>public/datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
        // When the document is ready
        $(document).ready(function() {

            $('#birthday').datepicker({
                //format: "dd/mm/yyyy"
                format: "yyyy-mm-dd"
            });

        });
        $(document).ready(function() {
            $('.minus').click(function() {
                var $input = $(this).parent().find('input');
                var count = parseInt($input.val()) - 1;
                count = count < 1 ? 1 : count;
                $input.val(count);
                $input.change();
                return false;
            });
            $('.plus').click(function() {
                var $input = $(this).parent().find('input');
                $input.val(parseInt($input.val()) + 1);
                $input.change();
                return false;
            });
        });
    </script>
    <!-- END BDAY -->

</body>

</html>