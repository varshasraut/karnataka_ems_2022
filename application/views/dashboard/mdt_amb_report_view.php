      <?php //var_dump($total_record); 
      ?>
      <div id="live_tracking_view">
        <div class="row" style="padding-top: 10px;">
          <div class="col-md-3">
            <b>Total Ambulance : </b><label id="totalAmb"><?php echo $total_record['total_amb']; ?></label>
          </div>
          <div class="col-md-3">
            <b>Total MDT Login : </b><label id="total_mdt"><?php echo $total_record['total_mdt']; ?></label>
          </div>
          <div class="col-md-3">
            <b>OnRoad Ambulance : </b><label id="total_onroad_new"><?php echo $total_record['total_onroad_new']; ?></label>
          </div>
          <div class="col-md-3">
            <b>OffRoad Ambulance : </b><label id="total_offroad_new"><?php echo $total_record['total_offroad_new']; ?></label>
          </div>
        </div>
        <div class="row" style="padding-top: 10px;">
          <div class="col-md-6">
            <b>Base Location With Network Challenges : </b><label style="padding-right: 10px;">123</label><a id="nonnetwork" href="<?php echo base_url(); ?>dashboard/ambulance_nonnetwork_popup" target="_blank">(View List)</a>
          </div>
        </div>
        <div class="row pb-5">
          <div class="col-md-12" id="list_table_amb">
            <!--offset-md-1 col-lg-10 offset-md-1 mt-4 pt-1-->
            <table class="list_table_amb list_table_amb_login" id="myTable" style="text-align: center;">
              <thead class="" style="">
                <tr class="table-active">
                  <th scope="col" style="background-color: #808080">Sr.No</th>
                  <th scope="col" style="background-color: #808080">Ambulance No</th>
                  <th scope="col" style="background-color: #808080">Base Location</th>
                  <th scope="col" style="background-color: #483D8B">EMT Name</th>
                  <th scope="col" style="background-color: #483D8B">EMT Mob No</th>
                  <th scope="col" style="background-color: #483D8B"> Current Status</th>
                  <th scope="col" style="background-color: #483D8B">EMT Login Time</th>
                  <th scope="col" style="background-color: #483D8B">Total Hours HH:MM</th>
                  <!-- <th scope="col">EMT Logout Time</th> -->
                  <th scope="col" style="background-color: #008B8B">Pilot Name</th>
                  <th scope="col" style="background-color: #008B8B">Pilot Mob No</th>
                  <th scope="col" style="background-color: #008B8B">Current Status</th>
                  <th scope="col" style="background-color: #008B8B">Pilot Login Time</th>
                  <th scope="col" style="background-color: #008B8B">Total Hours HH:MM</th>
                  <!-- <th scope="col">Pilot Logout Time</th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 1;
                if ($both_login_amb) {
                  foreach ($both_login_amb as $both_login) {
                    if ($both_login->clg_data_p_status == 2) {
                      $Login_status_p = '-';
                      $EMSOname = '-';
                      $EMSOmo = '-';
                      $p_login_time = '-';
                    } else if ($both_login->clg_data_p_status == 1) {
                      $Login_status_p = 'Login';
                      $EMSOname = $both_login->clg_data_p;
                      $EMSOmo = $both_login->clg_datamobno_p;
                      $p_login_time = $both_login->clg_data_p_login_time;
                    } else {
                      $Login_status_p = '-';
                      $EMSOname = '-';
                      $EMSOmo = '-';
                      $p_login_time = '-';
                    }
                    if ($both_login->clg_data_d_status == 2) {
                      $Login_status_d = '-';
                      $Pilotname = '-';
                      $Pilotmo = '-';
                      $d_login_time = '-';
                    } else if ($both_login->clg_data_d_status == 1) {
                      $Login_status_d = 'Login';
                      $Pilotname = $both_login->clg_data_d;
                      $Pilotmo = $both_login->clg_datamobno_d;
                      $d_login_time = $both_login->clg_data_d_login_time;
                      // loginmdt++;
                    } else {
                      $Login_status_d = '-';
                      $Pilotname = '-';
                      $Pilotmo = '-';
                      $d_login_time = '-';
                    }
                ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $both_login->amb_rto_register_no; ?></td>
                      <td><?php echo $both_login->baselocation; ?></td>
                      <td><?php echo $EMSOname; ?></td>
                      <td><?php echo $EMSOmo; ?></td>
                      <td><?php echo $Login_status_p; ?></td>
                      <td><?php echo $p_login_time; ?></td>
                      <td><?php
                          if ($p_login_time == '-') {
                            echo "-";
                          } else {
                            $p_login_time = date('Y-m-d H:i:s', strtotime($p_login_time));
                            $current_time = date('Y-m-d H:i:s');
                            // $difference = ($current_time - $p_login_time);
                            $datetime1 = new DateTime($p_login_time);
                            $datetime2 = new DateTime($current_time);
                            $interval = $datetime1->diff($datetime2);
                            echo $interval->format('%h') . ":" . $interval->format('%I') . " Hours";
                          } ?></td>
                      <td><?php echo $Pilotname; ?></td>
                      <td><?php echo $Pilotmo; ?></td>
                      <td><?php echo $Login_status_d; ?></td>
                      <td><?php echo $d_login_time; ?></td>
                      <td><?php
                          if ($d_login_time == '-') {
                            echo "-";
                          } else {
                            $d_login_time = date('Y-m-d H:i:s', strtotime($d_login_time));
                            $current_time = date('Y-m-d H:i:s');
                            // $difference = ($current_time - $p_login_time);
                            $datetime1 = new DateTime($d_login_time);
                            $datetime2 = new DateTime($current_time);
                            $interval = $datetime1->diff($datetime2);
                            echo $interval->format('%h') . ":" . $interval->format('%I') . " Hours";
                          } ?></td>
                    </tr>
                <?php

                    $i++;
                  }
                } ?>

                <?php

                if ($single_login_amb) {
                  foreach ($single_login_amb as $single_login) {

                    if ($single_login->clg_data_p_status == 2) {
                      $Login_status_p = '-';
                      $EMSOname = '-';
                      $EMSOmo = '-';
                      $p_login_time = '-';
                    } else if ($single_login_amb->clg_data_p_status == 1) {
                      $Login_status_p = 'Login';
                      $EMSOname = $single_login->clg_data_p;
                      $EMSOmo = $single_login->clg_datamobno_p;
                      $p_login_time = $single_login->clg_data_p_login_time;
                    } else {
                      $Login_status_p = '-';
                      $EMSOname = '-';
                      $EMSOmo = '-';
                      $p_login_time = '-';
                    }
                    if ($single_login->clg_data_d_status == 2) {
                      $Login_status_d = '-';
                      $Pilotname = '-';
                      $Pilotmo = '-';
                      $d_login_time = '-';
                    } else if ($single_login->clg_data_d_status == 1) {
                      $Login_status_d = 'Login';
                      $Pilotname = $single_login->clg_data_d;
                      $Pilotmo = $single_login->clg_datamobno_d;
                      $d_login_time = $single_login->clg_data_d_login_time;
                      // loginmdt++;
                    } else {
                      $Login_status_d = '-';
                      $Pilotname = '-';
                      $Pilotmo = '-';
                      $d_login_time = '-';
                    }
                ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $single_login->amb_rto_register_no; ?></td>
                      <td><?php echo $single_login->baselocation; ?></td>
                      <td><?php echo $EMSOname; ?></td>
                      <td><?php echo $EMSOmo; ?></td>
                      <td><?php echo $Login_status_p; ?></td>
                      <td><?php echo $p_login_time; ?></td>
                      <td><?php
                          if ($p_login_time == '-') {
                            echo "-";
                          } else {
                            $p_login_time = date('Y-m-d H:i:s', strtotime($p_login_time));
                            $current_time = date('Y-m-d H:i:s');
                            // $difference = ($current_time - $p_login_time);
                            $datetime1 = new DateTime($p_login_time);
                            $datetime2 = new DateTime($current_time);
                            $interval = $datetime1->diff($datetime2);
                            echo $interval->format('%h') . ":" . $interval->format('%I') . " Hours";
                          } ?></td>
                      <td><?php echo $Pilotname; ?></td>
                      <td><?php echo $Pilotmo; ?></td>
                      <td><?php echo $Login_status_d; ?></td>
                      <td><?php echo $d_login_time; ?></td>
                      <td><?php
                          if ($d_login_time == '-') {
                            echo "-";
                          } else {
                            $d_login_time = date('Y-m-d H:i:s', strtotime($d_login_time));
                            $current_time = date('Y-m-d H:i:s');
                            // $difference = ($current_time - $p_login_time);
                            $datetime1 = new DateTime($d_login_time);
                            $datetime2 = new DateTime($current_time);
                            $interval = $datetime1->diff($datetime2);
                            echo $interval->format('%h') . ":" . $interval->format('%I') . " Hours";
                          } ?></td>
                    </tr>
                  <?php
                    $i++;
                  }
                }
                if ($no_login_amb) {
                  foreach ($no_login_amb as $single_login) {

                    if ($single_login->clg_data_p_status == 2) {
                      $Login_status_p = '-';
                      $EMSOname = '-';
                      $EMSOmo = '-';
                      $p_login_time = '-';
                    } else if ($single_login_amb->clg_data_p_status == 1) {
                      $Login_status_p = 'Login';
                      $EMSOname = $single_login->clg_data_p;
                      $EMSOmo = $single_login->clg_datamobno_p;
                      $p_login_time = $single_login->clg_data_p_login_time;
                    } else {
                      $Login_status_p = '-';
                      $EMSOname = '-';
                      $EMSOmo = '-';
                      $p_login_time = '-';
                    }
                    if ($single_login->clg_data_d_status == 2) {
                      $Login_status_d = '-';
                      $Pilotname = '-';
                      $Pilotmo = '-';
                      $d_login_time = '-';
                    } else if ($single_login->clg_data_d_status == 1) {
                      $Login_status_d = 'Login';
                      $Pilotname = $single_login->clg_data_d;
                      $Pilotmo = $single_login->clg_datamobno_d;
                      $d_login_time = $single_login->clg_data_d_login_time;
                      // loginmdt++;
                    } else {
                      $Login_status_d = '-';
                      $Pilotname = '-';
                      $Pilotmo = '-';
                      $d_login_time = '-';
                    }
                  ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $single_login->amb_rto_register_no; ?></td>
                      <td><?php echo $single_login->baselocation; ?></td>
                      <td><?php echo $EMSOname; ?></td>
                      <td><?php echo $EMSOmo; ?></td>
                      <td><?php echo $Login_status_p; ?></td>
                      <td><?php echo $p_login_time; ?></td>
                      <td><?php
                          if ($p_login_time == '-') {
                            echo "-";
                          } else {
                            $p_login_time = date('Y-m-d H:i:s', strtotime($p_login_time));
                            $current_time = date('Y-m-d H:i:s');
                            // $difference = ($current_time - $p_login_time);
                            $datetime1 = new DateTime($p_login_time);
                            $datetime2 = new DateTime($current_time);
                            $interval = $datetime1->diff($datetime2);
                            echo $interval->format('%h') . ":" . $interval->format('%I') . " Hours";
                          } ?></td>
                      <td><?php echo $Pilotname; ?></td>
                      <td><?php echo $Pilotmo; ?></td>
                      <td><?php echo $Login_status_d; ?></td>
                      <td><?php echo $d_login_time; ?></td>
                      <td><?php
                          if ($d_login_time == '-') {
                            echo "-";
                          } else {
                            $d_login_time = date('Y-m-d H:i:s', strtotime($d_login_time));
                            $current_time = date('Y-m-d H:i:s');
                            // $difference = ($current_time - $p_login_time);
                            $datetime1 = new DateTime($d_login_time);
                            $datetime2 = new DateTime($current_time);
                            $interval = $datetime1->diff($datetime2);
                            echo $interval->format('%h') . ":" . $interval->format('%I') . " Hours";
                          } ?></td>
                    </tr>
                <?php
                    $i++;
                  }
                }
                ?>

              </tbody>
            </table>
          </div>

        </div>
      </div>

      <style>
        #formbox {
          text-align: right;
        }

        #nonnetwork {
          color: green;
          text-decoration: none;
        }

        .list_table_amb_login {
          overflow: auto;
          height: 100px;
        }

        .list_table_amb_login thead th {
          position: sticky;
          top: 0;
          z-index: 1;
        }

        /* Just common table stuff. Really. */
        table {
          border-collapse: collapse;
          width: 100%;
        }

        th,
        td {
          padding: 8px 16px;
        }
      </style>