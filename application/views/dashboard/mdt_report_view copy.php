<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
        <div class="col-md-3">
          <div class="form-group">
            <!-- <input type="text" name="als_p" id="als_p" value="<?php echo $als_p; ?> -->
          
            <!-- <label><?php echo $pl->count;?></label> -->
          
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
        <div class="col-md-3">
          <div class="form-group">
            <label>Amb Type:</label><br>
            <select onchange="showtitle()" name="amb_type" id="amb_type" class="form-group" style="width: 90%;padding: 10px;border-radius: 8px;margin-top:0px;" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7">
              <option value="">All</option>
              <option value="1">JE</option>
              <option value="2">BLS</option>
              <option value="3">ALS</option>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="button_box" style="padding-top:30px;">
            <input type="button" name="submit" value="Submit" class="btn btn-primary submit_btnt Submit">
            <input type="button" name="download" id="download" value="Download" class="btn btn-primary submit_btnt Submit">
          </div>
        </div>
        <!-- <div class="col-md-6" id="print">
       <button class="button_print" onclick="window.print()">Download</button>
       </div> -->
      </div> 
            

      <div id="total_div1">
      
      <div id="total_div">
      <div class="row" id="count_id">
        
      </div>
      <div class="row" id="count1_id">
        
      </div> 
      <div class="row" id="count2_id">
        
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
                <th scope="col"> Remark</th>
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
    count();
    var amb_district = document.getElementById("amb_district").value; 
    // $("#amb_district").val();
    var amb_type = document.getElementById("amb_type").value; 
    // $('#amb_type').val();
    $.post('<?= site_url('dashboard/mdt_dtl') ?>', {
      amb_district,amb_type
    }, function(data) {
      // console.log(data)
    //   if(amb_type == '' && amb_district == ''){
    //   $("#totalAmb").attr("disabled", "disabled");
    //   $("#loginDRIVER").attr("disabled", "disabled");
    //   $("#loginEMSO").attr("disabled", "disabled");
    // }
      if(amb_district == ''){

      }
      var new_var = JSON.parse(data);
      console.log(new_var)
      // alert(data);
      $('.list_table_amb').html("");
      var raw = '<table class="table table-bordered list_table_amb" border="1" id="table1" style="text-align: center;">' +
      '<thead>'+
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
        '<th scope="col" style="display:none;">Remark</th>' +
        '<th scope="col">Total Hours HH:MM</th>' +
        '</tr>' +
        '</thead>'+
        '</table>';
      $('.list_table_amb').html(raw);
      $('#totalAmb').html(new_var.length);
      var j = 1;
      var loginmdt = 0;
      var loginDRIVER = 0;
      var loginEMSO = 0;
      var als_off = 0;
      var als_on = 0;
      var bls_off = 0;
      var bls_on = 0;
      var je_off = 0;
      var je_on = 0;
      var als_p = 0;
      var bls_p = 0;
      var je_p = 0;
      console.log(new_var.length)
      for (var i = 0; i < new_var.length; i++) {
        if(new_var[i].ambt_name == 'ALS' && (new_var[i].amb_status == "7" || new_var[i].amb_status == "11")){
          als_off++;
        }else if(new_var[i].ambt_name == 'ALS' && (new_var[i].amb_status != "7" || new_var[i].amb_status != "11")){
          als_on++;
        }
        if(new_var[i].ambt_name == 'BLS' && (new_var[i].amb_status == "7" || new_var[i].amb_status == "11")){
          bls_off++;
        }
        else if(new_var[i].ambt_name == 'BLS' && (new_var[i].amb_status != "7" || new_var[i].amb_status != "11")){
          bls_on++;
        }
        if(new_var[i].ambt_name == 'JE' && (new_var[i].amb_status == "7" || new_var[i].amb_status == "11")){
          je_off++;
        }
        else if(new_var[i].ambt_name == 'JE' && (new_var[i].amb_status != "7" || new_var[i].amb_status != "11")){
          je_on++;
        }
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
          if (new_var[i].clg_data_d_status == 1 ) {
            loginDRIVER++;
          }
      
        if(Login_status_p == 'Logout'){
          // new_var[i].baselocation = '-';
          // new_var[i].ambt_name = '-';
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
          "<td>" + new_var[i].ambs_name + "</td>" +
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
          "<td>"+
          "<i class='fa fa-comments' style='font-size:30px;cursor: pointer;' Onclick='saveremark(" + new_var[i].amb_id + ")'></i>"+
          "<i class='fa fa-eye' style='font-size:25px;cursor: pointer;color:green;' aria-hidden='true' Onclick='displayremark(" + new_var[i].amb_id + ")'></i>"+
          "</td>" +
          "<th scope='col' style='display:none;'>"+ new_var[i].amb_id +"</th>" +
          "<td>" + new_var[i].clg_data_total_hrs + "</td>" +
          "</tr>";
        $('#list_table_amb tr:last').after(raw);
       
      }
      $('#totalMdt').html(loginmdt);
      $('#loginDRIVER').html(loginDRIVER);
      $('#loginEMSO').html(loginEMSO);
      for (var i = 0; i < new_var.length; i++) {
      var dst_name = new_var[i].dst_name;
      if(amb_type == '' )
      {
      var total_cnt = als_off + als_on + bls_off + bls_on + je_off+ je_on;
      var status = '';
      var amc_count = '';
      amc_count  = '<table class="table" id="table2" border="1">'+
      '<thead>'+
      '<tr style="text-align:center;">'+
            '<th rowspan="2" style="vertical-align: top;">Total Ambulances</th>'+
            '<th colspan="2">ALS</th>'+
            '<th colspan="2">BLS</th>'+
            '<th colspan="2">JE</th>'+
          '</tr>'+
          '<tr style="text-align:center;">'+
            '<td>Off-Road</td>'+
            '<td>On-Road</td>'+
            '<td>Off-Road</td>'+
            '<td>On-Road</td>'+
            '<td>Off-Road</td>'+
            '<td>On-Road</td>'+
          '</tr>'+
          '<tr style="text-align:center;">'+
            '<td>'+ total_cnt +'</td>'+
            '<td>'+ als_off +'</td>'+
            '<td>'+ als_on +'</td>'+
            '<td>'+ bls_off +'</td>'+
            '<td>'+ bls_on +'</th>'+
            '<td>'+ je_off +'</td>'+
            '<td>'+ je_on +'</td>'+
          '</tr>'+
          '</thead>'+
        '</table>';
        $('#count_id').html(amc_count);
        // console.log(amc_count);
      }else{
        $('#count_id').html('');
      }
    }
    });

  });
  function count(){
    var amb_district = document.getElementById("amb_district").value; 
    // $("#amb_district").val();
    var amb_type = document.getElementById("amb_type").value; 
    // $('#amb_type').val();
    // alert(amb_district)
    $.ajax({
        url:"<?= site_url('dashboard/count_of') ?>",
        datatype:'jsonp',
        type:"POST",
        data : {'amb_district':amb_district,'amb_type':amb_type},
        
        success: function(data){
          var obj = JSON.parse(data);
          // console.log(obj)
          var als_p = obj.als_p[0]['count'];
          var als_d = obj.als_d[0]['count'];
          var bls_p = obj.bls_p[0]['count'];
          var bls_d = obj.bls_d[0]['count'];
          var je_d = obj.je_d[0]['count'];
          var off = obj.off[0]['count'];
          var ttl_stf = parseInt(als_p) +  parseInt(als_d) +  parseInt(bls_p) +  parseInt(bls_d) +  parseInt(je_d);
          var count = '';
          count  = '<table class="table" id="table3" border="1">'+
          '<thead>'+
          '<tr style="text-align:center;">'+
            '<th rowspan="2" style="vertical-align: top;">Total Staff</th>'+
            '<th colspan="2">ALS</th>'+
            '<th colspan="2">BLS</th>'+
            '<th colspan="2">JE</th>'+
          '</tr>'+
          '<tr style="text-align:center;">'+
            '<td>EMT</td>'+
            '<td>Pilot</td>'+
            '<td>EMT</td>'+
            '<td>Pilot</td>'+
            '<td>Pilot</td>'+
          '</tr>'+
          '<tr style="text-align:center;">'+
            '<td>'+ ttl_stf +'</td>'+
            '<td>'+ als_p +'</td>'+
            '<td>'+ als_d +'</td>'+
            '<td>'+ bls_p +'</td>'+
            '<td>'+ bls_d +'</td>'+
            '<td>'+ je_d +'</td>'+
          '</tr>'+
          '</thead>'+
          '</table>';
          $('#count1_id').html(count);
          var count1 = '';
          count1  ='<table class="table" border="1">'+
          '<thead>'+
          '<tr style="text-align:center;">'+
              '<th style="width:50%">Total Off-Road</th>'+
              '<td style="width:50%">'+off+'</td>'+
          '</tr>'+
          '</thead>'+
          '</table>';
          
          $('#count2_id').html(count1);
          // $.each(obj, function (index, object) {
          //           $('#list_item').append('<li>' + object['name'] + '</li>');
            // console.log(obj);
            // var als_p = result.als_p;
            // var als_d = result.als_d;
            // alert(als_p)
            // $.each(result.results,function(item){
            //     $('ul').append('<li>' + item + '</li>')
            // })
        }
    })
      }
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
<script type = "text/javascript">  
   $(document).ready(function() {
            // $("#divrow").hide();
            $("#divloginEMSO").hide();
            $("#divloginDRIVER").hide();
            $("#divtotalAmb").hide();
            // alert("Hello, world!");
        });
        function showtitle(){
          var ambtype = $('#amb_type').val();
          if(ambtype != ''){
            $("#divloginEMSO").show();
            $("#divloginDRIVER").show();
            $("#divtotalAmb").show();
            $('#count1_id').hide();
            $('#count2_id').hide();
            $('#count_id').hide();
          }else if(ambtype == ''){
            // $("#divrow").hide();
            $('#count1_id').show();
            $('#count_id').show();
            $('#count2_id').show();
            $("#divloginEMSO").hide();
            $("#divloginDRIVER").hide();
            $("#divtotalAmb").hide();
          }
          
        }
//         function download_report(separator = ','){
//           var rows = $('.table tr');
//         // Construct csv
//         var csv = [];
//         var lastrow = []; var repeatrowval = [];
//         var tabledata = [];
// // the code is structured only if you can base the col numbers in a spesific row. in my situation it's the last tr in thead.         
// var cols = $('.table > thead > tr:last > th').length; $('.table > thead > tr:last > th').attr('rowSpan','1');
//         for (var i = 0; i < cols; i ++) {repeatrowval.push(1); lastrow.push('none')}
//         for (var i = 0; i < rows.length -1; i++) { //loop every row
//             console.log("row: " + i)
//             var row = []; var col = rows[i].querySelectorAll('td, th');
//             var col_len = 0;
//             for (var j = 0; j < cols; j++) {
//                 var a=0;
//                 console.log(repeatrowval[j]);
//                 if (repeatrowval[j] > 1) {
//                     data = lastrow[j]; repeatrowval[j] = repeatrowval[j] - 1;
//                     console.log("row: " + i + " reapet_col: " + j + " = " + data);
//                     row.push('"' + data + '"');
//                 } else {
//                     if(col[col_len] === undefined) break;
//                     var colspan = col[col_len].colSpan ?? 1 ;
//                     console.log("col: " + j + ", colspan = " + colspan + ", repeatrowval: " + repeatrowval[j])
//                     for (var r = 0; r < colspan; r++) { 
                        
//                         var rowspan = col[col_len].rowSpan ?? 1 ;
//                         console.log('rowspan: ' +rowspan)
//                         if (rowspan == 1) {
//                             // Clean innertext to remove multiple spaces and jumpline (break csv)
//                             var data = col[col_len].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
//                             // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
//                             data = data.replace(/"/g, '""');
//                             repeatrowval[j] = 1;
//                             lastrow[j] = data
//                             //}
//                         } else {
//                             // Clean innertext to remove multiple spaces and jumpline (break csv)
//                             var data = col[col_len].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
//                             // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
//                             data = data.replace(/"/g, '""');
//                             lastrow[j] = data; repeatrowval[j] = rowspan;
//                         }
//                         // Push escaped string
//                         console.log("row: " + i + " col: " + j + " = " + data);
//                         row.push('"' + data + '"');
//                         if(colspan > 1) {a++};
//                     }
//                     col_len++
//                 }
//                 if(a>0){j=+a};
//             }
//             csv.push(row.join(separator));
//             tabledata.push(row);
//         }
//         var csv_string = csv.join('\n');
//         // Download it
//         var filename = 'export_Report_' + new Date().toLocaleDateString() + '.csv';
//         var link = document.createElement('a');
//         link.style.display = 'none';
//         link.setAttribute('target', '_blank');
//         link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
//         link.setAttribute('download', filename);
//         document.body.appendChild(link);
//         link.click();
//         document.body.removeChild(link);
//         }
        
// function download_report(){
 
//               // Variable to store the final csv data
//               var csv_data = [];

//               // Get each row data
//               // if(document.getElementsByTagName('th') != "remark"){
//               var rows = document.getElementsByTagName('tr');
//               var val = document.getElementsByTagName('th');
//               var td = document.getElementsByTagName('td');
//               console.log(val)
//               // }
           
//               for (var i = 0; i < rows.length; i++) {

//                   // Get each column data
                  
//                   var cols = rows[i].querySelectorAll('td,th');
                 
//                   // Stores each csv row data
//                   var csvrow = [];
//                   for (var j = 0; j < cols.length; j++) {

//                       // Get the text data of each cell
//                       // of a row and push it to csvrow
//                       csvrow.push(cols[j].innerHTML);
//                   }
               
//                   // Combine each column value with comma
//                   csv_data.push(csvrow.join(","));
//                 }
//               // Combine each row data with new line character
//               csv_data = csv_data.join('\n');

//               // Call this function to download csv file 
//               downloadCSVFile(csv_data);

//             }
//               function downloadCSVFile(csv_data) {

//               // Create CSV file object and feed
//               // our csv_data into it
//               CSVFile = new Blob([csv_data], {
//                   type: "text/csv"
//               });

//               // Create to temporary link to initiate
//               // download process
//               var temp_link = document.createElement('a');

//               // Download csv file
//               temp_link.download = "GfG.csv";
//               var url = window.URL.createObjectURL(CSVFile);
//               temp_link.href = url;

//               // This link should not be displayed
//               temp_link.style.display = "none";
//               document.body.appendChild(temp_link);

//               // Automatically click the link to
//               // trigger download
//               temp_link.click();
//               document.body.removeChild(temp_link);
//          }
        function generateExcel(el) {
        var clon = el.clone();
        var html = clon.wrap('<div>').parent().html();
          
        //add more symbols if needed...
        while (html.indexOf('á') != -1) html = html.replace(/á/g, '&aacute;');
        while (html.indexOf('é') != -1) html = html.replace(/é/g, '&eacute;');
        while (html.indexOf('í') != -1) html = html.replace(/í/g, '&iacute;');
        while (html.indexOf('ó') != -1) html = html.replace(/ó/g, '&oacute;');
        while (html.indexOf('ú') != -1) html = html.replace(/ú/g, '&uacute;');
        while (html.indexOf('º') != -1) html = html.replace(/º/g, '&ordm;');
        html = html.replace(/<td>/g, "<td>&nbsp;");
        var result = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
        var link = document.createElement("a");
        document.body.appendChild(link);
        link.download = "Mdt_Login_Report.xls"; //You need to change file_name here.
        link.href = result;
        link.click();
        // html.setAttribute('mdt_report', fileName);   
        // window.open("data:,Hello%2C%20World!", "helloWorld.xls")
        // window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html)).attr("download", "file-.xls");
    
}
$("#download").click(function (event) {
  // var table1 = $("#count_id");
  // var table2 = $("#count1_id");
  // var table3 = $("#myTable");
  // var a = document.write(table1 + table2);total_div
  // generateExcel(a);
  var amb_district = document.getElementById("amb_district").value; 
  var amb_type = document.getElementById("amb_type").value; 
  if((amb_district == '') || (amb_district == 'All')  && (amb_type == '')||(amb_type == 'All')){
    generateExcel($("#total_div"));
  }else if((amb_district != '') || (amb_district != 'All')  && (amb_type == '')||(amb_type == 'All')){
    generateExcel($("#total_div"));
  }else if((amb_district != '') || (amb_district != 'All')  && (amb_type != '')||(amb_type != 'All')){
     generateExcel($("#total_div"));
  }
  // generateExcel($("#myTable"));
  // var data = table.buttons.exportData();
 	// generateExcel(table1,table2,table3);
});

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


