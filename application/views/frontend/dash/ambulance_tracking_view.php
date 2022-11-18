
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

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
    /* display:block; /
    / max-height:500px; /
    / overflow-y:auto; */
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
</style>

<section class="statistic statistic2">
      <div class="row text-center">
        <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">
          <!--offset-md-1 col-lg-10 offset-md-1-->
          <!-- <h3>AMBULANCE MDT LOGIN REPORT</h3> -->
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label>District:</label><br>
            <select onchange="" name="amb_district" id="amb_district" class="form-group" style="width: 90%;padding: 10px;border-radius: 8px;margin-top:0px;" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7">
              <option value="">All</option>
              <!-- <option value="">All</option> -->
              <?php foreach ($dist as $dst) { ?>
                <option value="<?php echo $dst->dst_code; ?>" 
                <?php if ($dst->dst_code == '518') {
                  echo "selected";
                                                              } ?>><?php echo $dst->dst_name; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-2" style="padding-top:40px;">
          <div class="button_box">
            <input type="button" style="float:right;background-color:#1d3c5d;" name="submit" value="Submit" class="btn btn-primary submit_btnt Submit">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <b>Total Ambulance : </b><label id="totalAmb"></label>
        </div>
        <div class="col-md-3">
          <b>MDT Login : </b><label id="totalMdt"></label>
        </div>
        <div class="col-md-3">
          <b>Total EMT Login : </b><label id="loginEMT"></label>
        </div>
        <div class="col-md-3">
          <b>Total Pilot Login : </b><label id="loginDRIVER"></label>
        </div>
      </div>
      <div class="row pb-5">
        <div class="col-md-12" id="list_table_amb">
          <!--offset-md-1 col-lg-10 offset-md-1 mt-4 pt-1-->
          <table class="list_table_amb" id="myTable" style="text-align: center;">
            <thead class="" style="">
              <tr class="table-active">
                <th scope="col">Sr.No</th>
                <th scope="col">Ambulance No</th>
                <th scope="col">Base Location</th>
                <th scope="col">EMT Name</th>
                <th scope="col">Current Status</th>
                <th scope="col">EMT Login Time</th>
                <th scope="col">EMT Logout Time</th>
                <th scope="col">Pilot Name</th>
                <th scope="col">Current Status</th>
                <th scope="col">Pilot Login Time</th>
                <th scope="col">Pilot Logout Time</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              if (is_array($amb_data)) {
                foreach ($amb_data as $amb) {
                  $clg_data_p =  get_emso_name($amb->amb_rto_register_no, 'P');
                  $clg_data_d =  get_emso_name($amb->amb_rto_register_no, 'D');

                  if ($clg_data_p[0]->status == 2) {
                    $Login_status_p = 'Logout';
                  } else if ($clg_data_p[0]->status == 1) {
                    $Login_status_p = 'Login';
                  }
                  if ($clg_data_d[0]->status == 2) {
                    $Login_status_d = 'Logout';
                  } else if ($clg_data_d[0]->status == 1) {
                    $Login_status_d = 'Login';
                  }
                  if ($amb->amb_status == 2) {

              ?>
                    <tr>
                      <td><?php echo $count; ?></td>
                      <td><?php echo $amb->baselocation; ?></td>
                      <td><?php echo $clg_data_p[0]->clg_first_name . ' ' . $clg_data_p[0]->clg_last_name; ?> </td>
                      <td><?php echo $Login_status_p; ?></td>
                      <td><?php echo $clg_data_p[0]->login_time; ?> </td>
                      <td><?php echo $clg_data_p[0]->logout_time ?> </td>
                      <td><?php echo $clg_data_d[0]->clg_first_name . ' ' . $clg_data_d[0]->clg_last_name; ?></td>
                      <td><?php echo $Login_status_d; ?></td>
                      <td><?php echo $clg_data_d[0]->login_time; ?></td>
                      <td><?php echo $clg_data_d[0]->logout_time ?> </td>
                    </tr>
                  <?php  } else { ?>
                    <tr>
                      <td><?php echo $count; ?></td>
                      <td><?php echo $amb->amb_rto_register_no; ?></td>
                      <td><?php echo $amb->baselocation; ?></td>
                      <td><?php echo $clg_data_p[0]->clg_first_name . ' ' . $clg_data_p[0]->clg_last_name; ?> </td>
                      <td><?php echo $Login_status_p; ?></td>
                      <td><?php echo $clg_data_p[0]->login_time; ?> </td>
                      <td><?php echo $clg_data_p[0]->logout_time ?> </td>
                      <td><?php echo $clg_data_d[0]->clg_first_name . ' ' . $clg_data_d[0]->clg_last_name; ?></td>
                      <td><?php echo $Login_status_d; ?></td>
                      <td><?php echo $clg_data_d[0]->login_time; ?></td>
                      <td><?php echo $clg_data_d[0]->logout_time ?> </td>
                    </tr>
              <?php    }
                  $clg_data_p = '';
                  $clg_data_d = '';
                  $count++;
                  $amb->amb_rto_register_no = '';
                }
              }

              ?>
            </tbody>
          </table>
        </div>
      </div>
</section>

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

    $.post('<?= site_url('dashboard/show_ambulance_tracking_remote') ?>', {
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