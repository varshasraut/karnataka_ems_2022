<style>
  .button_print {

    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    font-size: 17px;
    margin: 1px 1px;
    cursor: pointer;
    background-color: #085B80;
    float: right;

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

  #myTable {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
    height:500px;
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
    text-align: center !important;
    background-color: #2F419B;
    color: white; 
    position:sticky;
    top:0px;
  }

  .date {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #C0C0C0;
    width: 90%;
    margin-bottom: 10px;
  }
</style>

<!-- <?php echo $this->clg->clg_group ?> -->
<div class="page-content--bgf7 pb-5" style="min-height:550px;">

  <!-- round cirlcle icons start -->
  <!-- STATISTIC-->
  <div class="container-fluid">
    <section class="statistic statistic2">
      <div class="row text-center">
        <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">
          <!--offset-md-1 col-lg-10 offset-md-1-->
          <h3>AMBULANCE MDT LOGIN REPORT</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>District:</label><br>
            <select onchange="" name="amb_district" id="amb_district" class="form-group" style="width: 90%;padding: 10px;border-radius: 8px;margin-top:0px;" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7">
           <?php if($this->clg->clg_group !=  'UG-DM' && $this->clg->clg_group !=  'UG-ZM' && $this->clg->clg_group != 'UG-DIS-FILD-MANAGER'){ ?>
 
            <option value="">All</option>

            <?php }?>
              <?php foreach ($dist as $dst) { ?>
                <option value="<?php echo $dst->dst_code; ?>" <?php if ($dst->dst_code == '518') {
                                                                echo "selected";
                                                              } ?>><?php echo $dst->dst_name; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Amb Type:</label><br>
            <select onchange="" name="amb_type" id="amb_type" class="form-group" style="width: 90%;padding: 10px;border-radius: 8px;margin-top:0px;" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7">
              <option value="">All</option>
              <option value="1">JE</option>
              <option value="2">BLS</option>
              <option value="3">ALS</option>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="button_box" style="padding-top:30px;">
            <input type="button" name="submit" value="Submit" class="btn btn-primary submit_btnt Submit">
          </div>
        </div>
        <!-- <div class="col-md-6" id="print">
       <button class="button_print" onclick="window.print()">Download</button>
       </div> -->
      </div>

      <div class="row">
        <div class="col-md-3">
          <b>Total Ambulance : </b><label id="totalAmb">0</label>
        </div>
        <!-- <div class="col-md-3">
          <b>MDT Login : </b><label id="totalMdt"></label>
        </div> -->
        <div class="col-md-3">
          <b>Total EMT Login : </b><label id="loginEMSO">0</label>
        </div>
        <div class="col-md-3">
          <b>Total Pilot Login : </b><label id="loginDRIVER">0</label>
        </div>
      </div>
      <div class="row pb-5">
        <div class="col-md-12" id="list_table_amb">
          <!--offset-md-1 col-lg-10 offset-md-1 mt-4 pt-1-->
          <table class="list_table_amb table-responsive" id="myTable" style="text-align: center;">
            <thead class="" style="">
              <tr class="table-active">
                <th scope="col">Sr.No</th>
                <th scope="col">Ambulance No</th>
                <th scope="col">Base Location</th>
                <th scope="col">Default Mobile Number</th>
                <th scope="col">District Name </th>
                <th scope="col">EMT Name</th>
                <th scope="col">EMT Mob No</th>
                <th scope="col">Current Status</th>
                <th scope="col">EMT Login Time</th>
                <th scope="col">EMT Logout Time</th>
                <th scope="col">Pilot Name</th>
                <th scope="col">Pilot Mob No</th>
                <th scope="col">Current Status</th>
                <th scope="col">Pilot Login Time</th>
                <th scope="col">Pilot Logout Time</th>
                <th scope="col"> &nbsp;&nbsp;&nbsp;&nbsp;Remark&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th scope="col">Total Hours HH:MM</th>
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
                      <td><?php echo $amb->amb_default_mobile; ?></td>
                      <td><?php echo $amb->dst_name; ?></td>
                      <td><?php echo $clg_data_p[0]->clg_first_name . ' ' . $clg_data_p[0]->clg_last_name; ?> </td>
                      <td><?php echo $clg_pilot[0]->clg_mobile_no; ?></td>
                      <td><?php echo $Login_status_p; ?></td>
                      <td><?php echo $clg_data_p[0]->login_time; ?> </td>
                      <td><?php echo $clg_data_p[0]->logout_time ?> </td>
                      <td><?php echo $clg_data_d[0]->clg_first_name . ' ' . $clg_data_d[0]->clg_last_name; ?></td>
                      <td><?php echo $clg_driver[0]->clg_mobile_no; ?></td>
                      <td><?php echo $Login_status_d; ?></td>
                      <td><?php echo $clg_data_d[0]->login_time; ?></td>
                      <td><?php echo $clg_data_d[0]->logout_time ?> </td>
                      <td style="display: flex;"><?php ?> </td>
                    </tr>
                  <?php  } else { ?>
                    <tr>
                      <td><?php echo $count; ?></td>
                      <td><?php echo $amb->amb_rto_register_no; ?></td>
                      <td><?php echo $amb->baselocation; ?></td>
                      <td><?php echo $amb->amb_default_mobile; ?></td>
                      <td><?php echo $clg_data_p[0]->clg_first_name . ' ' . $clg_data_p[0]->clg_last_name; ?> </td>
                      <td><?php echo $clg_pilot[0]->clg_mobile_no; ?></td>
                      <td><?php echo $Login_status_p; ?></td>
                      <td><?php echo $clg_data_p[0]->login_time; ?> </td>
                      <td><?php echo $clg_data_p[0]->logout_time ?> </td>
                      <td><?php echo $clg_data_d[0]->clg_first_name . ' ' . $clg_data_d[0]->clg_last_name; ?></td>
                      <td><?php echo $clg_driver[0]->clg_mobile_no; ?></td>
                      <td><?php echo $Login_status_d; ?></td>
                      <td><?php echo $clg_data_d[0]->login_time; ?></td>
                      <td><?php echo $clg_data_d[0]->logout_time ?> </td>
                      <td style="display: flex;"><?php ?> </td>
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
      <div class="modal loginmodal" tabindex="-1" role="dialog" id="logindetails">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" style="font-weight: bold;">Remark</h5>

              <button type="button" class="close" onclick="hidepopup()" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body" style="margin: 17px;">
              <!-- <form method="post"> -->
              <div>
                <textarea name="remark" placeholder="Remark ..." id="remark" style="font-family:sans-serif;font-size:1.2em;"></textarea>
              </div>
              <input type="hidden" id="amb_id" name="amb_id">
              <input type="submit" name="save" value="Submit" onclick="submit_remark();">
              <!-- </form> -->
            </div>
          </div>
        </div>

      </div>
      <div class="modal loginmodal" tabindex="-1" role="dialog" id="remarkdetails">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" style="font-weight: bold;">Remark Details</h5>

              <button type="button" class="close" onclick="hidepopup()" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body" style="margin: 17px;">
              <div class="row">
                <b class="col-2" style="padding: 0;">Remark : </b>
                <div class="col-10" id="user_remark"></div><br />
              </div>
              <div class="row">
                <b class="col-4" style="padding: 0;">Remark Given By : </b>
                <div class="col-6" id="added_by"></div>
              </div>
              <div class="row">
                <b class="col-4" style="padding: 0;">Added Time : </b>
                <div class="col-8" id="added_date"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

  </div>
  </section>
</div>
<input type="hidden" id="mdt_veh">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
  $('.Submit').on('click', function() {
    var amb_district = $('#amb_district').val();
   var amb_type = $('#amb_type').val();
    $.post('<?= site_url('dashboard/mdt_dtl') ?>', {
      amb_district,amb_type
    }, function(data) {
      // console.log(data)
      var new_var = JSON.parse(data);
      // alert(data);
      $('.list_table_amb').html("");
      var raw = '<table class="table table-bordered list_table_amb" id="myTable" style="text-align: center;">' +
        '<tr class="table-active">' +
        '<th scope="col">Sr.No</th>' +
        '<th scope="col">Ambulance No</th>' +
        '<th scope="col">Base Location</th>' +
        '<th scope="col">Ambulance Type</th>' +
        '<th scope="col">Ambulance Status</th>' +
         '<th scope="col">Default Mobile Number</th>' +
        '<th scope="col">District Name</th>' +
        '<th scope="col">EMT Name</th>' +
        '<th scope="col">EMT Mob No</th>' +
        '<th scope="col">Current Status</th>' +
        '<th scope="col">EMT Login Time</th>' +
        '<th scope="col">EMT Logout Time</th>' +
        '<th scope="col">Pilot Name</th>' +
        '<th scope="col">Pilot Mob No</th>' +
        '<th scope="col">Current Status</th>' +
        '<th scope="col">Pilot Login Time</th>' +
        '<th scope="col">Pilot Logout Time</th>' +
        '<th scope="col">Remark</th>' +
        '<th scope="col">Total Hours HH:MM</th>' +
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
        if(Login_status_p == 'Logout'){
          new_var[i].baselocation = '-';
          new_var[i].ambt_name = '-';
          new_var[i].amb_default_mobile = '-';
          new_var[i].dst_name = '-';
          new_var[i].clg_data_p = '-';
          new_var[i].clg_datamobno_p = '-';
          new_var[i].clg_data_p_login_time = '-';
          new_var[i].clg_data_p_logout_time = '-';
        }
        if(Login_status_d == 'Logout'){
          new_var[i].clg_data_d = '-';
          new_var[i].clg_datamobno_d = '-';
          new_var[i].amb_default_mobile = '-';
          new_var[i].clg_data_d_login_time = '-';
          new_var[i].clg_data_d_logout_time = '-';
          new_var[i].clg_data_total_hrs = '-';
        }
        // var today = new Date();
        // var current_time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        // var actual_time = new_var[i].clg_p_login_time;
        // let valuestart = moment.duration(current_time);
        // let valuestop = moment.duration(actual_time);
        // let difference = valuestop.subtract(valuestart);

        // console.log(difference.hours() + ":" + difference.minutes() +":"+ difference.seconds())
        // var difference = current_time.getTime() - actual_time.getTime();
        //  var seconds = (current_time - actual_time);
        // alert(seconds);       
        var raw = "<tr>" +
          "<td>" + j++ + "</td>" +
          "<td>" + new_var[i].amb_rto_register_no + "</td>" +
          "<td>" + new_var[i].baselocation + "</td>" +
          "<td>" + new_var[i].ambt_name + "</td>" +
          "<td>" + new_var[i].amb_default_mobile + "</td>" +
          "<td>" + new_var[i].dst_name + "</td>" +
          "<td>" + new_var[i].clg_data_p + "</td>" +
          "<td>" + new_var[i].clg_datamobno_p + "</td>" +
          "<td>" + Login_status_p + "</td>" +
          "<td>" + new_var[i].clg_data_p_login_time + "</td>" +
          "<td>" + new_var[i].clg_data_p_logout_time + "</td>" +
          "<td>" + new_var[i].clg_data_d + "</td>" +
          "<td>" + new_var[i].clg_datamobno_d + "</td>" +
          "<td>" + Login_status_d + "</td>" +
          "<td>" + new_var[i].clg_data_d_login_time + "</td>" +
          "<td>" + new_var[i].clg_data_d_logout_time + "</td>" +
          "<td><i class='fa fa-comments' style='font-size:30px;cursor: pointer;' Onclick='saveremark(" + new_var[i].amb_id + ")'></i><i class='fa fa-eye' style='font-size:25px;cursor: pointer;color:green;' aria-hidden='true' Onclick='displayremark(" + new_var[i].amb_id + ")'></i></td>" +
          "<td>" + new_var[i].clg_data_total_hrs + "</td>" +
          "</tr>";
        $('#list_table_amb tr:last').after(raw);
      }
      $('#totalMdt').html(loginmdt);
      $('#loginDRIVER').html(loginDRIVER);
      $('#loginEMSO').html(loginEMSO);

      var status = '';
    });
  });

  function saveremark(amb_id) {
    $('#amb_id').val(amb_id);
    $('#logindetails').show();
    $("input[type=text], textarea").val("");

  }

  function displayremark(amb_id) {
    // alert(amb_id)
    // $('#remarkdetails').show();

    $.post('<?= site_url('dashboard/show_remark_data') ?>', {
      amb_id
    }, function(data) {

      var new_var = JSON.parse(data);
      //alert(new_var.clg_last_name);
      // var remark = data['remark'];
      // console.log(new_var);  
      console.log(data);
      var added_by = new_var.clg_first_name + " " + new_var.clg_mid_name + " " + new_var.clg_last_name;
      var not_added_by = new_var.clg_first_name + new_var.clg_mid_name + new_var.clg_last_name;
      var added_date = new_var.added_date;
      var remark = new_var.remark + "<br>" + "<br>";
      var remarkgiven = new_var.remark;

      var nullremark = 'Remark Not Given Yet..!';
      //  alert(added_by);
      if (remarkgiven == " " || remarkgiven == null) {
        var remarknew = nullremark;
      } else {

        var remarknew = remark;
      }

      var nulladdedby = '';
      if (not_added_by == " " || not_added_by == null) {
        var addedbynew = nulladdedby;
      } else {
        var addedbynew = added_by;
      }

      $('#added_by').html(addedbynew);
      $('#added_date').html(added_date);
      $('#user_remark').html(remarknew);

      $('#remarkdetails').show();
    });
  }

  function hidepopup() {
    $("#logindetails").hide();
    $("#remarkdetails").hide();
  }

  function submit_remark() {
    // alert('ff');
    var amb_id = $('#amb_id').val();
    var remark = $('#remark').val();
    if (remark == "") {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Please Enter Remark!',
      })
    } else {
      $.post('<?= site_url('dashboard/save_remark_data') ?>', {
        amb_id,
        remark
      }, function(data) {
        //  alert(data);
        $('#logindetails').hide();
        // Swal.fire('Remark Save Successfully..!!');

        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Remark Saved Successfully..!!',
          showConfirmButton: false,
          timer: 2000
        });

      });
      document.getElementsByClassName("fa fa-eye")[0].style.color = "red";
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