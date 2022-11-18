<div class="page-content--bgf7 pb-5" style="min-height:550px;">


  <div class="container-fluid">
    <section class="statistic statistic2">
      <div class="row text-center">
        <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">
          <!--offset-md-1 col-lg-10 offset-md-1-->
          <div class="breadcrumb float_left">
            <ul>
                <li>
                    <span>AMBULANCE MDT FORCEFULLY LOGOUT</span>
                </li>

            </ul>
        </div>
          <!-- <h3>AMBULANCE MDT FORCEFULLY LOGOUT</h3> -->
        </div>
      </div>
           <form enctype="multipart/form-data"  action="" method="post">
      <div class="width100 float_left">
        <div class="width30 drg float_left">
          <div class="form-group">
            <label>District:</label><br>
            <select name="amb_district" id="amb_district" class="form-group" style="width: 90%;padding: 10px;border-radius: 8px;margin-top:0px;" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7">
              <option value="">All</option>
              <!-- <option value="">All</option> -->
              <?php foreach ($dist as $dst) { ?>
                <option value="<?php echo $dst->dst_code; ?>" ><?php echo $dst->dst_name; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="width30 drg float_left">
          <div class="button_box" style="padding-top:40px;">
            <input type="button" name="submit" value="Submit" class="btn btn-primary submit_btnt form-xhttp-request" data-href="<?php echo base_url(); ?>dashboard/mdt_logout">
          </div>
        </div>

      </div>
           </form>


      <div class="row pb-5">
        <div class="col-md-12" id="list_table_amb">
          <table class="table report_table"  style="text-align: center;">
            <thead class="" style="">
              <tr class="table-active">
                <th scope="col">Sr.No</th>
                <th scope="col">Ambulance No</th>
                <th scope="col">District Name </th>
                <th scope="col">User Type</th>
                <th scope="col">Name</th>
                <th scope="col">Mob No</th>
                <th scope="col">Current Status</th>
                <th scope="col">Login Time</th>
                <th scope="col">Logout Time</th>
                <th scope="col">Total Hours</th>
                <th scope="col"> Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                        
     
              $count = 1;
              if (is_array($amb_data)) {
                foreach ($amb_data as $amb) {
                  if ($amb->status == 2) {
                    $Login_status_p = 'Logout';
                  } else if ($amb->status == 1) {
                    $Login_status_p = 'Login';
                  }
                  if ($amb->login_type == 'P') {
                    $login_type = 'EMT';
                  } else  {
                    $login_type = 'Pilot';
                  }
          
              ?>
                   
                   <?php $current_time = date('Y-m-d H:i:s');
                    $datetime1 = new DateTime($amb->login_time);
                    $datetime2 = new DateTime($current_time);
                    $interval = $datetime2->diff($datetime1);
                    $total_hours = ($interval->format("%a")* 24) + $interval->format("%h"). " hours". $interval->format(" %i minutes ");  ?>
                    <tr>
                      <td><?php echo $count; ?></td>
                      <td><?php echo $amb->amb_rto_register_no; ?></td>
                      <td><?php echo $amb->dst_name; ?></td>       
                      <td><?php echo $login_type; ?></td>       
                      <td><?php echo $amb->clg_first_name . ' ' . $amb->clg_last_name; ?> </td>
                      <td><?php echo $amb->clg_mobile_no; ?></td>
                      <td><?php echo $Login_status_p; ?></td>
                      <td><?php echo $amb->login_time; ?> </td>
                      <td><?php echo $amb->logout_time; ?> </td>
                      <td><?php echo $total_hours; ?></td>
                      <td style="width=30% !important;"> <a class="click-xhttp-request btn" data-href="{base_url}dashboard/force_logout" data-qr="output_position=popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-VIEW&amp;id=<?php echo base64_encode($amb->login_id); ?>&amp;ref_id=<?php echo $amb->clg_ref_id; ?>">Forcefully Logout</a>
                      </td>
                    </tr>
              <?php    
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