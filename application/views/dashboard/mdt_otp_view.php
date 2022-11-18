
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
  #myTable {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  #myTable td,
  #myTable th {
    border: 1px solid #6f6d6d;
    padding: 8px;
    /* width: 25%; */
  }

  #myTable tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  #myTable tr:hover {
    background-color: #ddd;
  }

  #list_table_amb {
    width: 100%;
  }

  #myTable th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center !important;
    background-color: #2F419B;
    color: white;
  }
</style>
<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label>Mobile No:</label><br>
      <div class="search-container">
   
      <input type="text" name="clg_mobile_no" id="clg_mobile_no"  placeholder="Search.." style="height: 50px;">
      <!-- <button type="submit"><i class="fa fa-search"></i></button> -->
  </div>
      <!-- <select onchange="" name="clg_mobile_no" id="clg_mobile_no" class="form-group" style="width: 90%;padding: 10px;border-radius: 8px;margin-top:0px;" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7">
         <option value="">Enter Number</option>
        <?php foreach ($mob_no as $mob) { ?>
          <option value="<?php echo $mob->clg_mobile_no; ?>"><?php echo $mob->clg_mobile_no; ?></option>
        <?php } ?>
      </select> -->
    </div>
  </div>

  <div class="col-md-2">
    <div class="button_box" style="padding-top:30px;">
      <input type="button" name="submit" value="Submit" class="btn btn-primary submit_btnt Submit">
    </div>
  </div>
</div>
<div class="row">
        <div id="list_table_amb" style="width: 100%;">
          <table class="list_table_amb" id="myTable" style="text-align: center;">
            <thead class="" style="">
              <tr class="table-active">
                <th scope="col" style="width: 10%;">Sr.No</th>
                <th scope="col" style="width: 10%;">ID</th>
                <th scope="col" style="width: 20%;">Name</th>
                <th scope="col" style="width: 20%;">Mobile No</th>
                <th scope="col" style="width: 20%;">Designation</th>
                <th scope="col" style="width: 20%;">Current OTP</th>
                <!-- <th scope="col">OTP Time</th> -->
              </tr>
            </thead>
            <tbody>
                    <tr>
                      <td><?php echo $count; ?></td>
                      <td><?php echo $amb->clg_name; ?></td>
                      <td><?php echo $amb->clg_mob_no; ?></td>
                      <td><?php echo $clg_otp ?> </td>
                      <!-- <td><?php echo $clg_otp_time; ?></td> -->
                    </tr>
            </tbody>
          </table>
        </div>
      </div>

<script>
  $('.Submit').on('click', function() {
    var clg_mobile_no = $('#clg_mobile_no').val();
    $.post('<?= site_url('dashboard/show_otp_user') ?>', {
        clg_mobile_no
      },
      function(data) {
        var new_var = JSON.parse(data);
        // alert(new_var);
        $('.list_table_amb').html("");
        var raw = '<table class="table table-bordered list_table_amb" id="myTable" style="text-align: center;">' +
          '<tr class="table-active">' +
          '<th scope="col">Sr.No</th>' +
          '<th scope="col">ID</th>' +
          '<th scope="col">Name</th>' +
          '<th scope="col">Mobile No</th>' +
          '<th scope="col">Designation</th>' +
          '<th scope="col">Current OTP</th>' +
        //   '<th scope="col">OTP Time</th>' +
          '</tr>' +
          '</table>';
        $('.list_table_amb').html(raw);
        var j = 1;
        for (var i = 0; i < new_var.length; i++) {
        //    alert (new_var[i].clg_group);
          if (new_var[i].clg_group == 'UG-PILOT') {
            var user_type = 'Pilot';
          } else if (new_var[i].clg_group == 'UG-EMT') {
             var user_type = 'EMT';
           }
        //    alert (new_var[i].clg_group);
          var clg_name = new_var[i].clg_first_name + " " + new_var[i].clg_mid_name + " " + new_var[i].clg_last_name;
          // alert(new_var[i].clg_group);
          var raw = "<tr>" +
            "<td>" + j++ + "</td>" +
            "<td>" + new_var[i].clg_ref_id + "</td>" +
            "<td>" + clg_name + "</td>" +
            "<td>" + new_var[i].clg_mobile_no + "</td>" +
            "<td>" + user_type + "</td>" +
            "<td>" + new_var[i].otp + "</td>" +
            
            // "<td>" + new_var[i].clg_otp_time + "</td>" +
            "</tr>";
          $('#list_table_amb tr:last').after(raw);
        }

      });
  });
</script>