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
</style>
<div class="page-content--bgf7 pb-5" style="min-height:550px;">

  <!-- round cirlcle icons start -->
  <!-- STATISTIC-->
  <div class="container-fluid">
    <section class="statistic statistic2">
      <div class="row text-center">
        <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">
          <!--offset-md-1 col-lg-10 offset-md-1-->
          <h5>B12 Data Report</h5>
          <br>
        </div>
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
                <th style="text-align: center" width="40%" scope="col">Type</th>
                <th style="text-align: center" width="15%" scope="col">Today</th>
                <th style="text-align: center" width="15%" scope="col">This Month</th>
                <th style="text-align: center" width="15%" scope="col">Till Month</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              if (is_array($B12_data)) {
                foreach ($B12_data as $data) { ?>

                    <tr>
                      <td><?php echo $data->SrNo; ?></td>
                      <td><?php echo $data->B12_Type; ?> </td>
                      <td><?php echo $data->today; ?></td>
                      <td><?php echo $data->this_month; ?> </td>
                      <td><?php echo $data->till_date; ?> </td>
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