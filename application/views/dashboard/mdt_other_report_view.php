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

  <div class="container-fluid">
    <section class="statistic statistic2">
      <div class="row text-center">
        <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">
          <!--offset-md-1 col-lg-10 offset-md-1-->
          <h3>IRTS Managerial MDT Status Report</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>District:</label><br>
            <select onchange="" name="clg_district_id" id="clg_district_id" class="form-group" style="width: 90%;padding: 10px;border-radius: 8px;margin-top:0px;" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7">
              <option value="">All</option>
              <!-- <option value="">All</option> -->
              <?php foreach ($dist as $dst) { ?>
                <option value="<?php echo $dst->dst_code; ?>" <?php if ($dst->dst_code == '518') {
                                                                echo "selected";
                                                              } ?>><?php echo $dst->dst_name; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="button_box" style="padding-top:30px;">
            <input type="button" name="submit" value="Submit" class="btn btn-primary submit_btnt Submit">
          </div>
        </div>

      </div>

      <div id="live_tracking_view">
        <div id="list_table_amb">
          <table class="list_table_amb" id="myTable" style="text-align: center;">
            <thead>
              <tr class="table-active">
                <th scope="col">Sr.No</th>
                <th scope="col">District</th>
                <th scope="col">Name</th>
                <th scope="col">Designation </th>
                <th scope="col">Official Email ID </th>
                <th scope="col">Mobile No</th>
                <th scope="col">Current Status</th>
                <th scope="col">Login Time</th>
                <th scope="col">Logout Time</th>
                <th scope="col"> &nbsp;&nbsp;&nbsp;&nbsp;Remark&nbsp;&nbsp;&nbsp;&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              if (is_array($amb_data)) {
                foreach ($amb_data as $amb) { ?>
                  <tr>
                    <td style="text-align: center;"><?php echo $count; ?></td>
                    <td style="text-align: center;"><?php echo $amb->dst_name; ?></td>
                    <td style="text-align: center;"><?php echo $amb->clg_data_name; ?></td>
                    <td style="text-align: center;"><?php echo $amb->clg_data_des; ?></td>
                    <td style="text-align: center;"><?php echo $amb->clg_data_mail; ?></td>
                    <td style="text-align: center;"><?php echo $amb->clg_data_mobno; ?></td>
                    <td style="text-align: center;"><?php echo $amb->status; ?></td>
                    <td style="text-align: center;"><?php echo $amb->clg_data_login_time; ?></td>
                    <td style="text-align: center;"><?php echo $amb->clg_data_logout_time; ?></td>
                  </tr>
              <?php $count++;
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
              <input type="hidden" id="clg_id" name="clg_id">
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
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
  $('.Submit').on('click', function() {
    var clg_district_id = $('#clg_district_id').val();
    // alert(clg_district_id);

    $.post('<?= site_url('dashboard/mdt_other_dtl') ?>', {
      clg_district_id
    }, function(data) {
      // console.log(data)
      var new_var = JSON.parse(data);
    // alert(data);
      $('.list_table_amb').html("");
      var raw = '<table class="table table-bordered list_table_amb" id="myTable" style="text-align: center;">' +
        '<tr class="table-active">' +
        '<th scope="col">Sr.No</th>' +
        '<th scope="col">District</th>' +
        '<th scope="col">Name</th>' +
        '<th scope="col">Designation</th>' +
        '<th scope="col">Official Email ID</th>' +
        '<th scope="col">Mobile No</th>' +
        '<th scope="col">Current Status</th>' +
        '<th scope="col">Login Time</th>' +
        '<th scope="col">Logout Time</th>' +
        '<th scope="col">Remark</th>' +
        '</tr>' +
        '</table>';
      $('.list_table_amb').html(raw);
      var j = 1;

    for (var i = 0; i < new_var.length; i++) {

        if (new_var[i].status == 2) {
          var Login_status = 'Logout';
        } else if (new_var[i].status == 1) {
          var Login_status = 'Login';
        }
           var clg_name = new_var[i].clg_first_name + " " + new_var[i].clg_mid_name + " " + new_var[i].clg_last_name;

        var raw = "<tr>" +
          "<td>" + j++ + "</td>" +
          "<td>" + new_var[i].dst_name+ "</td>" +
          "<td>" + clg_name + "</td>" +
          "<td>" + new_var[i].ugname + "</td>" +
          "<td>" + new_var[i].clg_email + "</td>" +
          "<td>" + new_var[i].clg_mobile_no + "</td>" +
          "<td>" + Login_status + "</td>" +
          "<td>" + new_var[i].login_time + "</td>" +
          "<td>" + new_var[i].logout_time + "</td>" +
          "<td><i class='fa fa-comments' style='font-size:30px;cursor: pointer;' Onclick='saveremark(" + new_var[i].clg_id + ")'></i><i class='fa fa-eye' style='font-size:25px;cursor: pointer;color:green;' aria-hidden='true' Onclick='displayremark(" + new_var[i].clg_id + ")'></i></td>" +
          "</tr>";
        $('#list_table_amb tr:last').after(raw);
      }

      var status = '';
    });
  });

  function saveremark(clg_id) {
    $('#clg_id').val(clg_id);
    $('#logindetails').show();
    $("input[type=text], textarea").val("");

  }

  function displayremark(clg_id) {
    // alert(clg_id)
    // $('#remarkdetails').show();

    $.post('<?= site_url('dashboard/show_other_remark_data') ?>', {
      clg_id
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
    var clg_id = $('#clg_id').val();
    // alert(clg_id);
    var remark = $('#remark').val();
    // alert(remark);
    if (remark == "") {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Please Enter Remark!',
      })
    } else {
      $.post('<?= site_url('dashboard/save_other_remark_data') ?>', {
        clg_id,
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