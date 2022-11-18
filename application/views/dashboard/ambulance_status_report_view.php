

   <script>
        $(".mi_loader").fadeOut("slow");
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<style>
  #formbox{

    text-align: right;
  }
 #onroad{
padding-right: 6%;
color: green;
text-decoration: none;

 }
 #offroad{
  padding-right: 4%;
  padding-left: 5%;
  color: red;
  text-decoration: none;
 }
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
  #clkd{
    text-align: right;
    padding-right: 14%;
    color: red;
  }
  #cboxOverlay{
    visibility: visible;
  }
  .time_drop{
    border:0px !important;
    background:white !important;
    padding:5px !important;
  }
</style>
<script>
  $(document).ready(function () {
        var today = new Date();
        $('.datepicker').datepicker({
            format: 'mm-dd-yyyy',
            autoclose:true,
            endDate: "today",
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
<div class="page-content--bgf7 pb-5" style="min-height:550px;" id="filter_date_view">

  <!-- round cirlcle icons start -->
  <!-- STATISTIC-->
  <div class="container-fluid">
    <section class="statistic statistic2">
      <div class="row text-center">
        <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">
          <!--offset-md-1 col-lg-10 offset-md-1-->
          
          <h5>District Wise OnRoad/OffRoad Report <?php echo date('d', strtotime($current_date));?> <?php echo date('F', strtotime($current_date));?> <?php echo date('Y', strtotime($current_date));?> @ <?php echo $select_time_name;?></h5>
          <br>
        </div>
        
       
      </div>
     
    <div class="field10">
      <form enctype="multipart/form-data"  id="date_filter" method="post" action="" style="height: 100px;">   
            <div class="row">
            
            <div class="col-md-1" style="margin-top:10px !important;">
            <label for="">&nbsp;</label>
                </div>
                <div class="col-md-2" style="margin-top:10px !important;">
                  <input name="select_date" class="filter_required mi_calender datepicker"  value="<?php echo $report_args['select_date'];?>" type="text" tabindex="1" placeholder="Select Date" data-errors="{filter_required:'Register Number should not blank'}">
                </div>
                  <div class="col-md-1" style="margin-top:10px !important;">
                  <select name="select_time" class="filter_required time_drop" data-errors="{filter_required:'Select Time should not blank'}" >
                      <option value="">Select Time</option>
                       <option value="1" <?php if($report_args['select_time'] == '1'){ echo "selected"; }?> >9 AM</option>
                       <option value="2" <?php if($report_args['select_time'] == '2'){ echo "selected"; }?>>12 PM</option>
                       <option value="3" <?php if($report_args['select_time'] == '3'){ echo "selected"; }?>>3 PM</option>
                       <option value="4" <?php if($report_args['select_time'] == '4'){ echo "selected"; }?>>6 PM</option>
                  </select>
                </div>
                <div class="col-md-2"> 
                  <input type="button" name="submit" value="Submit" class="form-xhttp-request button_print" data-href='<?php echo base_url();?>dashboard/ambulance_status_date' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' style="padding:7px 12px 7px 12px !important">
                </div>
                <div class="col-md-1" style="margin-top:10px !important;">
            <label for="">&nbsp;</label>
                </div>
                <div class="col-md-4" id="print">
                 <button class="button_print" onclick="window.print()">Download</button>
                 </div>
                 
            </div>
        </form>
</div>


      <div class="row pb-5" >
      <div class="col-md-1">
    </div>
        <div class="col-md-10" id="list_table_amb">
          <!--offset-md-1 col-lg-10 offset-md-1 mt-4 pt-1-->
          <table class="list_table_amb" id="myTable" style="text-align: center;">
            <thead class="" style="">
              <tr class="table-active" >
                <th style="text-align: center" width="15%" scope="col">Sr.No</th>
                <th style="text-align: center" width="15%" scope="col">District</th>
                <th style="text-align: center" width="20%" scope="col">Count of Ambulance</th>
                <th style="text-align: center" width="30%" scope="col">On-Road Ambulances with Doctor and Driver Available</th>
                <th style="text-align: center" width="20%" scope="col">Total-Off Road</th>
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
                      <td><?php echo $amb->amb_count; ?> </td>
                      <td><?php echo $amb->off_road_doctor; ?></td>
                      <td><?php echo $amb->total_offroad; ?></td>
                      <!-- <td><?php echo $amb->total_offroad; ?> </td> -->
                    </tr>
     <?php $count++;

                }
              }
              

              ?>
                    
            </tbody>
          </table>
          <div id="formbox">
          <a id="onroad" href="<?php echo base_url();?>dashboard/ambulance_onroad_popup" target="_blank">View List Of Onroad </a>
          <a id="offroad" href="<?php echo base_url();?>dashboard/ambulance_status_popup" target="_blank">View List Of Offroad </a>
          </div>
        </div>
        <div class="col-md-1">
    </div>
      </div>
      <!-- <div class="row">
        <div class="col-md-2">
        <form id="clkd" class="single onpage_popup"  data-href="{base_url}dashboard/ambulance_status_popup" style="cursor: pointer;" data-qr="output_position=content&amp;" data-popupwidth="1500" data-popupheight="900">
         <button>Visit Website</button>
          </form>
        </div>
      </div> -->
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