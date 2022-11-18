<!DOCTYPE html>
<html>
    <head>
<head>

        <meta charset="UTF-8">
        <title>Assisted Living</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
 

        <link href="<?php echo base_url()?>public/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>public/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>public/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>public/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        
           <!----------BOOTSTRAP DATEPICKER----------------------------->
    	<link rel="stylesheet" href="<?php echo base_url();?>public/datepicker/css/datepicker.css">
		<!---------------------------------------------------------->
        
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        
    </head><div style="position:fixed; bottom: 0; right: 0; width: 67%; border: 2px solid #CCC; top:200px; z-index:1001; background-color: #FFF; display:none;" id="ad2">
    <span style="right: 0; position: fixed; cursor: pointer; z-index:1002" onclick="closeAd('ad2')" >CLOSE</span>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Payroll Management System -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3182624105910612"
     data-ad-slot="4635770289"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>


<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Assisted Living -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3182624105910612"
     data-ad-slot="3101991489"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>


<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Grading System -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3182624105910612"
     data-ad-slot="6132191885"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- HMS Website -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3182624105910612"
     data-ad-slot="1562391480"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <?php require_once(APPPATH.'views/include/header.php');?>
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
            
            <?php require_once(APPPATH.'views/include/sidebar.php');?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Billing Details</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Billing</a></li>
                        <li><a href="<?php echo base_url()?>app/billing_history"> Billing History</a></li>
                        <li class="active">Billing Details</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                 
                 
                 <div class="row">
                 	<div class="col-md-12">
                    
                    	<div class="nav-tabs-custom">
                        	<ul class="nav nav-tabs">
                               	<li class="active"><a href="#tab_1" data-toggle="tab"><strong>Billing List</strong></a></li>
                            	<li><a href="#tab_2" data-toggle="tab">Header Details</a></li>
                                <li><a href="#tab_3" data-toggle="tab">Patient Information</a></li>
                            </ul>
                            <div class="tab-content">
                            	<div class="tab-pane active" id="tab_1">
                                	<a class="btn btn-primary" href="<?php echo base_url()?>app/opd/printOR/<?php echo $patientInfo->IO_ID?>/<?php echo $patientInfo->patient_no?>/<?php echo $header->invoice_no?>" target="_blank"><i class="fa fa-print"></i> Print Receipt</a>
                                	<table class="table table-hover">
                                    <thead>
                                    	<tr>
                                        	<th>Particular Name</th>
                                            <th>Qty</th>
                                            <th>Rate</th>
                                            <th>Amount</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php foreach($details as $detailsRow){?>
                                        <tr>
                                        	<td><?php echo $detailsRow->bill_name?></td>
                                            <td><?php echo $detailsRow->qty?></td>
                                            <td><?php echo number_format($detailsRow->rate,2)?></td>
                                            <td><?php echo number_format($detailsRow->amount,2)?></td>
                                            <td><?php echo $detailsRow->note?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                    </table>
                                    <br><br><br><br><br><br><br><br><br><br>
                                </div>
                                <div class="tab-pane" id="tab_2">
                                	<table class="table">
                                    <tbody>
                                    	<tr>
                                        	<td>Invoice No.</td>
                                            <td><?php echo $header->invoice_no?></td>
                                        </tr>
                                        <tr>
                                        	<td>Invoice Date</td>
                                            <td><?php echo $header->dDate?></td>
                                        </tr>
                                        <tr>
                                        	<td>Payment Type</td>
                                            <td><?php echo $header->payment_type?></td>
                                        </tr>
                                        <tr>
                                        	<td>Total Items</td>
                                            <td><?php echo $header->total_purchased?></td>
                                        </tr>
                                        <tr>
                                        	<td>Total Amount</td>
                                            <td><?php echo number_format($header->total_amount,2);?></td>
                                        </tr>
                                        <tr>
                                        	<td>Remarks</td>
                                            <td><?php echo $header->remarks?></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab_3">
                                	<table class="table">
                                    <tbody>
                                    	<tr>
                                        	<td>Patient No.</td>
                                            <td><?php echo $patientInfo->patient_no?></td>
                                        </tr>
                                        <tr>
                                        	<td>Patient IOP No.</td>
                                            <td><?php echo $patientInfo->IO_ID?></td>
                                        </tr>
                                        <tr>
                                        	<td>Patient No.</td>
                                            <td><?php echo $patientInfo->patient?></td>
                                        </tr>
                                        <tr>
                                        	<td>Date Visit</td>
                                            <td><?php echo $patientInfo->date_visit?></td>
                                        </tr>
                                        
                                        <tr>
                                        	<td>Time Visit</td>
                                            <td><?php echo $patientInfo->time_visit?></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                 </div>
                 
                 
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
  
        
         <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
         <script src="<?php echo base_url();?>public/js/bootstrap.min.js" type="text/javascript"></script>     
        <script src="<?php echo base_url();?>public/js/AdminLTE/app.js" type="text/javascript"></script>
        
         <!-- BDAY -->
         <script src="<?php echo base_url();?>public/datepicker/js/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url();?>public/datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#cFrom').datepicker({
                    //format: "dd/mm/yyyy"
					format: "yyyy-mm-dd"
                });  
				
				$('#cTo').datepicker({
                    //format: "dd/mm/yyyy"
					format: "yyyy-mm-dd"
                });  
            
            });
        </script>
        <!-- END BDAY -->
        
        
    </body>
</html>