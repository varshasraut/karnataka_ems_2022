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
<div class="row">
  <div id="list_table_amb">
    <table class="list_table_amb" id="myTable" style="text-align: center;">
      <thead>
        <tr class="table-active">
          <th scope="col">Sr.No</th>
          <th scope="col">User Type</th>
          <th scope="col">User ID</th>
          <th scope="col">Mobile No </th>
          <th scope="col">Name</th>
          <th scope="col">Added By</th>
          <th scope="col">Add User Type</th>
          <th scope="col">Added On</th>
          <th scope="col">Registration Status</th>
          <th scope="col">Approved By</th>
          <th scope="col">Approved On</th>
          <th scope="col">Action</th>
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
              <td style="text-align: center;"><?php echo $amb->clg_data_logout_time; ?></td>
              <td style="text-align: center;"><?php echo $amb->clg_data_logout_time; ?></td>
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

<script>
  $('.Submit').on('click', function() {
    var clg_district_id = $('#clg_district_id').val();
    $.post('<?= site_url('inc/show_validate_user') ?>', {
        clg_district_id
      },
      function(data) {
        var new_var = JSON.parse(data);
        // alert(new_var);
        $('.list_table_amb').html("");
        var raw = '<table class="table table-bordered list_table_amb" id="myTable" style="text-align: center;">' +
          '<tr class="table-active">' +
          '<th scope="col">Sr.No</th>' +
          '<th scope="col">User Type</th>' +
          '<th scope="col">User ID</th>' +
          '<th scope="col">Mobile No</th>' +
          '<th scope="col">Name</th>' +
          '<th scope="col">Added By</th>' +
          '<th scope="col">Add User Type</th>' +
          '<th scope="col">Added On</th>' +
          '<th scope="col">Registration Status</th>' +
          '<th scope="col">Approved By</th>' +
          '<th scope="col">Approved On</th>' +
          '<th scope="col">Action</th>' +
          '</tr>' +
          '</table>';
        $('.list_table_amb').html(raw);
        var j = 1;
        for (var i = 0; i < new_var.length; i++) {

          // if (new_var[i].clg_group == 'UG-Pilot') {
          //   var user_type = 'Pilot';
          // } else if (new_var[i].status == 'UG-EMT') {
          //   var user_type = 'EMSO';
          // }
          var clg_name = new_var[i].clg_first_name + " " + new_var[i].clg_mid_name + " " + new_var[i].clg_last_name;
          // alert(new_var[i].clg_group);
          var raw = "<tr>" +
            "<td>" + j++ + "</td>" +
            "<td>" + new_var[i].clg_group + "</td>" +
            "<td>" + new_var[i].clg_ref_id + "</td>" +
            "<td>" + new_var[i].clg_mobile_no + "</td>" +
            "<td>" + clg_name + "</td>" +
            "<td>" + + "</td>" +
            "<td>" + + "</td>" +
            "<td>" + + "</td>" +
            "<td>" + + "</td>" +
            "<td>" + + "</td>" +
            "<td>" + + "</td>" +
            "<td><i class='fas fa-pen-square' style='font-size:30px;cursor: pointer;'></i><br><i class='fa fa-eye' style='font-size:25px;cursor: pointer;color:green;' aria-hidden='true'></i></td>" +
            "</tr>";
          $('#list_table_amb tr:last').after(raw);
        }

      });
  });
</script>