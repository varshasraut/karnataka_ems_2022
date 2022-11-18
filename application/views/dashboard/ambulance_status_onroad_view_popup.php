<script type="text/javascript" src="{js_path}/jquery-1.12.1.js"></script>
<script type="text/javascript" src="{js_path}/jquery-ui.js"></script>
<script type="text/javascript" src="{js_path}/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="{js_path}/jquery.enhanced.cookie.js" ></script>
<script type="text/javascript" src="{js_path}/comman.js?t=2.4"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<!--<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,400italic,600,700,800' rel='stylesheet' type='text/css'>-->
<link rel="shortcut icon" href="{image_path}/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="{css_path}/jquery-ui-timepicker-addon.css">
<link rel="stylesheet" type="text/css" href="{css_path}/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="{css_path}/jquery-ui.structure.css">
<link rel="stylesheet" type="text/css" href="{css_path}/jquery-ui.theme.css">
<link rel="stylesheet" type="text/css" href="{css_path}/colorbox.css">
<!--<link href="{css_path}/style.css?v=<?php echo time();?>" rel="stylesheet" type="text/css" />
<link href="{css_path}/style_pages.css?v=<?php echo time();?>" rel="stylesheet" type="text/css" />
<link href="{css_path}/style_responsive_common.css?v=<?php echo time();?>" rel="stylesheet" type="text/css" />
<link href="{css_path}/style_responsive.css?v=<?php echo time();?>" rel="stylesheet" type="text/css" />-->
<!--<link href="{css_path}/cms_widget.css" rel="stylesheet" type="text/css" />-->
<link href="{css_path}/style.css?t=1.5" rel="stylesheet" type="text/css" />
<link href="{css_path}/style_pages.css" rel="stylesheet" type="text/css" />
<link href="{css_path}/style_responsive_common.css" rel="stylesheet" type="text/css" />
<link href="{css_path}/style_responsive.css" rel="stylesheet" type="text/css" />
<link href="{css_path}/MonthPicker.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
<style>
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked+.slider {
    background-color: #2196F3;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  tbody {
    /* display:block; */
    /* max-height:500px; */
    /* overflow-y:auto; */
  }

  /* thead, tbody tr {
        display:table;
        width:100%;
        table-layout:fixed;
    } */
  /* thead {
        width: calc( 100% - 1em )
    }  */
  #myTable {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  #myTable td,
  #myTable th {
    border: 1px solid #6f6d6d;
    padding: 8px;
  }

  #myTable tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  #myTable tr:hover {
    background-color: #ddd;
  }

  #myTable th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #2F419B;
    color: white;
  }
  .date {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #C0C0C0;
    width: 90%;
    margin-bottom: 10px;
  }
 
  .button_print {
  
  border: none;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 17px;
  margin: 1px 1px;
  cursor: pointer;
  background-color: #085B80;
  
}
#print{
    text-align:right;
    padding: 2% 10% 1% 0px;
   
}
#onroadhead{
    text-align:center;
    padding: 2% 0% 1% 0px;
    color: #1d3c5d;

}
.mi_calender{
    padding: 10px;
    border-radius: 8px;
    border:1px solid #C0C0C0;
    width:90%;
    margin-bottom: 10px;
}
</style>
<script>
  $(document).ready(function () {
        var today = new Date();
        $('.datepicker').datepicker({
            maxDate: today,
            minDate: new Date(2021, 08 - 1, 01),
        }).on('changeDate', function (ev) {
                $(this).datepicker('hide');
            });


        /*$('.datepicker').keyup(function () {
            if (this.value.match(/[^0-9]/g)) {
                this.value = this.value.replace(/[^0-9^-]/g, '');
            }
        });*/
    });
  </script>

<div class="page-content--bgf7 pb-5" style="min-height:550px;">
<div class="row" >
  <div class="col-md-10" id="onroadhead">
     
  <h5>Total On-Road Ambulances <?php echo date('d', strtotime($current_date));?> <?php echo date('F', strtotime($current_date));?> <?php echo date('Y', strtotime($current_date));?> @ <?php echo $select_time_name;?></h5>
</div>
  <!-- round cirlcle icons start -->
  <!-- STATISTIC-->


  <div class="col-md-2" id="print">
   <button class="button_print" onclick="window.print()">Download</button>
   </div>
   </div>
   <div class="row">
      <form enctype="multipart/form-data"  id="date_filter" method="post" action="<?php echo base_url(); ?>dashboard/ambulance_onroad_popup_datefilter" style="height: 100px;">   
            <div class="width100" style="display:flex">
            
                <div class="width_30 " style="margin-left:50px;">
                
                  <input type="text" id="select_date" name="select_date" class="filter_required mi_calender datepicker"  value="<?php echo $current_date;?>" type="text" tabindex="1" placeholder="Select Date" data-errors="{filter_required:'Register Number should not blank'}">
                </div>&nbsp;&nbsp;&nbsp;
                <div class="width_30 float_left">
                              

                    <div class="shift width100 float_left">
                        <select name="select_time" class="filter_required" data-errors="{filter_required:'Select Time should not blank'}">
                      <option value="">Select Time</option>
                       <option value="1" <?php if($report_args['select_time'] == '1'){ echo "selected"; }?> > 9 AM</option>
                       <option value="2" <?php if($report_args['select_time'] == '2'){ echo "selected"; }?>> 12 PM</option>
                       <option value="3" <?php if($report_args['select_time'] == '3'){ echo "selected"; }?>> 3 PM</option>
                       <option value="4" <?php if($report_args['select_time'] == '4'){ echo "selected"; }?>> 6 PM</option>
                  </select>
                    </div>
                </div>
                <div class="width20 "> 
                <input type="submit" name="submit" value="Submit" >     
                </div>
            </div>
        </form>
</div>
  <div class="container-fluid">
    <section class="statistic statistic2">
      <div class="row text-center">
        <!-- <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">
          offset-md-1 col-lg-10 offset-md-1
          <h5>District Wise Off Road Report <?php echo date('d');?> <?php echo date('F');?> <?php echo date('Y');?> @ 8:30 AM</h5>
          <br>
        </div> -->
      </div>



      <div class="row pb-5">
      <div class="col-md-1">
    </div>
        <div class="col-md-10" id="list_table_amb">
          <!--offset-md-1 col-lg-10 offset-md-1 mt-4 pt-1-->
          <table class="list_table_amb" id="myTable" style="text-align: center;">
            <thead class="" style="">
              <tr class="table-active" >
                <th style="text-align: center" width="15%" scope="col">Sr.No</th>
                <th style="text-align: center" width="15%" scope="col">District</th>
                <th style="text-align: center" width="40%" scope="col">Base Location</th>
                <th style="text-align: center" width="20%" scope="col">Vehicle No</th>
                <th style="text-align: center" width="10%" scope="col">Vehicle Type</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              if (is_array($amb_data)) {
                foreach ($amb_data as $amb) { ?>

                    <tr>
                      <td ><?php echo $count; ?></td>
                      <td><?php echo $amb->district_name; ?></td>
                      <td><?php echo $amb->base_location; ?></td>
                      <td><?php echo $amb->amb_number; ?></td>
                      <td><?php echo $amb->veh_type; ?> </td>
                     
                    </tr>
     <?php $count++;

                }
              }
              

              ?>
                    
            </tbody>
          </table>
        </div>
        <div class="col-md-1">
    </div>
      </div>
    </section>
  </div>
</div>
<input type="hidden" id="mdt_veh">
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
<link href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
  $('.Submit').on('click', function() {
    var amb_district = $('#amb_district').val();

    $.post('<?= site_url('dashboard/mdt_dtl') ?>', {
      amb_district
    }, function(data) {
      var new_var = JSON.parse(data);
      // alert(data);
      $('.list_table_amb').html("");
      var raw = '<table class="table table-bordered list_table_amb" id="myTable" style="text-align: center;">' +
        '<tr class="table-active">' +
        '<th scope="col">Sr.No</th>' +
        '<th scope="col">Ambulance No</th>' +
        '<th scope="col">Base Location</th>' +
        '<th scope="col">EMT Name</th>' +
        '<th scope="col">Current Status</th>' +
        '<th scope="col">EMT Login Time</th>' +
        '<th scope="col">EMT Logout Time</th>' +
        '<th scope="col">Pilot Name</th>' +
        '<th scope="col">Current Status</th>' +
        '<th scope="col">Pilot Login Time</th>' +
        '<th scope="col">Pilot Logout Time</th>' +
        '</tr>' +
        '</table>';
      $('.list_table_amb').html(raw);
      $('#totalAmb').html(new_var.length);
      var j = 1;
      var loginmdt = 0;
      var loginDRIVER = 0;
      var loginEMSO = 0;

      for (var i = 0; i < new_var.length; i++) {
        var app_status = new_var[i].app_status;
        var parameter_count = new_var[i].parameter_count;
        var login_type = new_var[i].login_type;
        if (app_status == '1') {
          loginmdt++;
          var app_status1 = '<i class="fa fa-mobile-phone" style="font-size:30px;color:green"></i>';
          if (parameter_count == 1) {
            //$time = $inc->start_from_base_loc;
            var status = 'Call Assigned';
          } else if (parameter_count == 2) {
            //$time = $inc->start_from_base_loc;
            var status = 'Start From Base';
          } else if (parameter_count == 3) {
            //$time = $inc->at_scene;
            var status = 'At Scene';
          } else if (parameter_count == 4) {
            //$time = $inc->from_scene;
            var status = 'From Scene';
          } else if (parameter_count == 5) {
            //$time = $inc->at_hospital;
            var status = 'At Hospital';
          } else if (parameter_count == 6) {
            //$time = $inc->patient_handover;
            var status = 'Patient Handover';
          } else if (parameter_count == 7) {
            //$time = $inc->back_to_base_loc;
            var status = 'Available';
          } else {
            //$time = $inc->assigned_time;
            var status = 'Login';
          }
        }
        if (new_var[i].clg_data_p_status == 2) {
          var Login_status_p = 'Logout';
        } else if (new_var[i].clg_data_p_status == 1) {
          var Login_status_p = 'Login';
        }
        if (new_var[i].clg_data_d_status == 2) {
          var Login_status_d = 'Logout';
        } else if (new_var[i].clg_data_d_status == 1) {
          var Login_status_d = 'Login';
        }
        if (new_var[i].clg_data_p_status == 1) {
          loginEMSO++;
        }
        if (new_var[i].clg_data_d_status == 1) {
          loginDRIVER++;
        }
        var raw = "<tr>" +
          "<td>" + j++ + "</td>" +
          "<td>" + new_var[i].amb_rto_register_no + "</td>" +
          "<td>" + new_var[i].baselocation + "</td>" +
          "<td>" + new_var[i].clg_data_p + "</td>" +
          "<td>" + Login_status_p + "</td>" +
          "<td>" + new_var[i].clg_data_p_login_time + "</td>" +
          "<td>" + new_var[i].clg_data_p_logout_time + "</td>" +
          "<td>" + new_var[i].clg_data_d + "</td>" +
          "<td>" + Login_status_d + "</td>" +
          "<td>" + new_var[i].clg_data_d_login_time + "</td>" +
          "<td>" + new_var[i].clg_data_d_logout_time + "</td>" +
          "</tr>";
        $('#list_table_amb tr:last').after(raw);
      }
      $('#totalMdt').html(loginmdt);
      $('#loginDRIVER').html(loginDRIVER);
      $('#loginEMSO').html(loginEMSO);

      var status = '';
    });
  });

  function track(amb_id) {
    var space = 0;
    $.post('<?= site_url('dashboard/get_amb_no') ?>', {
      amb_id,
      space
    }, function(data) {
      var strLink = 'https://www.nuevastech.com/API/API_LiveTrackVehicle.aspx?track=S&username=JKERC&accesskey=5682C1ED819E8B48FC3E&vehiclename=' + data + '&tracktype=LT';
      document.getElementById("mapId").setAttribute("href", strLink);
      var strLink1 = "https://www.nuevastech.com/API/API_LiveTrackVehicle.aspx?track=S&username=JKERC&accesskey=5682C1ED819E8B48FC3E&vehiclename=" + data + "&tracktype=LT";
      document.getElementById("mapId1").setAttribute("src", strLink1);
      // alert(data)
    });
    // alert(id);
    $('#MyModal').modal('show');
  }
  var veh;

  function mdt(amb_id) {
    var space = 1;
    $.post('<?= site_url('dashboard/get_amb_no') ?>', {
      amb_id,
      space
    }, function(data) {
      $('#mdt_veh').val(data);
      veh += data;
      $('#map3').html('')
      $('#MDTModal').modal('show');
      mdtloadmap();
    });
  }
  // $('#amb').on('click',function(){
  //     alert('id')
  // });
  function amb(amb_id) {
    var system = $('#system').val();
    // alert(system);
    if (system == '108') {
      $.post('<?= site_url('dashboard/get_app_login_user') ?>', {
        amb_id
      }, function(data) {
        var new_var = JSON.parse(data);
        $('#emso_name').html('');
        $('#emso_mob').html('');
        $('#driver_name1').html('');
        $('#driver_mob1').html('');

        for (var i = 0; i < new_var.length; i++) {
          if (new_var[i].login_type == "D") {
            var driverName = new_var[i].clg_first_name + new_var[i].clg_mid_name + new_var[i].clg_last_name;
            $('#driver_name1').html(driverName);
            $('#driver_mob1').html(new_var[i].clg_mobile_no);
          }

          if (new_var[i].login_type == "P") {
            var emsoName = new_var[i].clg_first_name + new_var[i].clg_mid_name + new_var[i].clg_last_name;
            $('#emso_name').html(emsoName);
            $('#emso_mob').html(new_var[i].clg_mobile_no);
          }

          $('#logindetails').modal('show');
        }

      });
    } else {
      $.post('<?= site_url('dashboard/get_app_login_user') ?>', {
        amb_id
      }, function(data) {
        var new_var = JSON.parse(data);
        // console.log(new_var);
        for (var i = 0; i < new_var.length; i++) {

          if (new_var[i].login_type == "P") {
            var emsoName = new_var[i].clg_first_name + new_var[i].clg_mid_name + new_var[i].clg_last_name;
            $('#emso_name1').html(emsoName);
            $('#emso_mob1').html(new_var[i].clg_mobile_no);
          }
          $('#logindetails_bike').modal('show');
        }

      });
    }
  }
</script>
<script>
  function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
</script>