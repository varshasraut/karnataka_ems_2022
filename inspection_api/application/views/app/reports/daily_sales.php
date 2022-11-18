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
        
    </head>
    <body class="skin-blue" onLoad="getPatientList('a')">
        <!-- header logo: style can be found in header.less -->
        <?php require_once(APPPATH.'views/include/header.php');?>
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
            
            <?php require_once(APPPATH.'views/include/sidebar.php');?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                     <h1>Daily Sales Reports</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>app/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Reports</a></li>
                        <li class="active">Daily Sales Reports</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                 
                 	
                 
                 <div class="row">
                 	<div class="col-md-3"></div>
                 	<div class="col-md-6">
                    
                    	 <div class="box">
                         		
                         		<div class="box-body table-responsive">
                                    <h4 class="box-title"></h4>
                                    
                                    <div class="box-body">
                                            <form method="post" action="<?php echo base_url()?>app/reports/daily_sales" onSubmit="return validate();" target="_blank">
                                            <table class="table table-hover" width="100%">
                                            <tr>
                                            	<td><strong>From Date</strong></td>
                                                <td><input class="form-control input-sm" name="cFrom" id="cFrom" type="text" value="<?php echo date("Y-m-d");?>" placeholder="From Date" style="width:100%;" required></td>
                                            </tr><tr>
                                            	<td><strong>To Date</strong></td>
                                                <td><input class="form-control input-sm" name="cTo" id="cTo" type="text" value="<?php echo date("Y-m-d");?>" placeholder="to Date" required></td>
                                            </tr>
                                            <tr>
                                            	<td><strong>Reports Type</strong></td>
                                            	<td>
                                                <select name="cType" id="cType" class="form-control">
                                            		<option value="browser">Browser</option>
                                                	<option value="pdf">PDF</option>
                                            	</select>
                                                </td>
                                             </tr>
                                            <tr>
                                            	<tD></tD>
                                            	<td>
                                                <input type="submit" value="View Report" class="btn btn-primary" style="width: 100%;" name="btnView">
                                                </td>
                                            </tr>
                                            </table>
                                          </form>
                                    </div>
                                    
                                </div>
                        </div>
                        
                        
                        
                    </div>
                    <div class="col-md-3"></div>
                 </div>
                 
                 
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
  
  
  
  
  
  		<!-- / patientListModal modal -->   
        					<div class="modal fade" id="patientListModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Search Patient</h4>
                                        </div>
                                        <div class="modal-body">
                                        			
                                                    
<script language="javascript">
function addPatient(iop_no,patient_no,patient){

document.getElementById("patient_name").value = patient;
document.getElementById("iop_no").value = iop_no;
document.getElementById("patient_no").value = patient_no;

$('#patientListModal').modal('hide');
						return true;	
}

function getPatientList(val)
{
	var cType;
	cType = "OPD";
	
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	
    document.getElementById("showPatients").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","<?php echo base_url();?>general/ipdLists/"+val,true);
xmlhttp.send();

}
</script>   
                                                    <input onKeyUp="getPatientList(this.value)" class="form-control input-sm" name="cSearch" id="cSearch" type="text" placeholder="Search here">
                                        		<span id="showPatients">
                                                
                                                </span>
                                                
                                               
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                           <!-- <button type="button" class="btn btn-primary" onClick="return addPatient()">Proceed</button>-->
                                        </div>
                                       
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
  
  
  
  
        
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