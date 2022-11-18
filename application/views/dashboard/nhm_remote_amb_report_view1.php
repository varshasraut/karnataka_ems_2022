<form action="<?php echo base_url(); ?>dashboard/nhm_amb_report_remote_download" method="post" enctype="multipart/form-data" target="form_frame">
<input type="hidden" value="<?php echo $to_date; ?>" name="to_date_download">
<input type="hidden" value="<?php echo $from_date; ?>" name="from_date_download">
<input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
</form>
<table class="list_table_amb"  id="myTable" style="text-align: center;">
                        <thead class="" style="">
                            <tr class="table-active">
                            <th scope="col">Ambulance No2</th>
                            <th scope="col">Base Location</th>
                            <!--<th scope="col">EMT Name</th>
                            <th scope="col">Current Status</th>
                            <th scope="col">EMT Login Time</th>
                            <th scope="col">EMT Logout Time</th>-->
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
        foreach ($amb_data as $amb){ 
          $clg_data_p =  get_emso_name($amb->amb_rto_register_no,'P');
         $clg_data_d =  get_emso_name($amb->amb_rto_register_no,'D');

         if($clg_data_p[0]->status==2){
          $Login_status_p = 'Logout';
         }else if($clg_data_p[0]->status==1){
          $Login_status_p = 'Login';
         }
         if($clg_data_d[0]->status==2){
          $Login_status_d = 'Logout';
         }else if($clg_data_d[0]->status==1){
          $Login_status_d = 'Login';
         }
        if($amb->amb_status == 2 ){ 
         
    ?>
    <tr>         
        <td><?php echo $amb->amb_rto_register_no; ?></td>
        <td><?php echo $amb->baselocation; ?></td>
        <!--<td><?php //echo $clg_data_p[0]->clg_first_name.' '.$clg_data_p[0]->clg_last_name; ?> </td>
        <td><?php// echo $Login_status_p; ?></td>
        <td><?php// echo $clg_data_p[0]->login_time; ?> </td>
        <td><?php// echo $clg_data_p[0]->logout_time; ?> </td>-->
        <td><?php echo $clg_data_d[0]->clg_first_name.' '.$clg_data_d[0]->clg_last_name; ?></td>
        <td><?php echo $Login_status_d; ?></td>
        <td><?php echo $clg_data_d[0]->login_time; ?></td>
        <td><?php echo $clg_data_d[0]->logout_time; ?></td>
    </tr>
    <?php  }else{ ?>
    <tr>         
    <td><?php echo $amb->amb_rto_register_no; ?></td>
        <td><?php echo $amb->baselocation; ?></td>
        <!--<td><?php //echo $clg_data_p[0]->clg_first_name.' '.$clg_data_p[0]->clg_last_name; ?> </td>
        <td><?php //echo $Login_status_p; ?></td>
        <td><?php //echo $clg_data_p[0]->login_time; ?> </td>
        <td><?php //echo $clg_data_p[0]->logout_time; ?> </td>-->
        <td><?php echo $clg_data_d[0]->clg_first_name.' '.$clg_data_d[0]->clg_last_name; ?></td>
        <td><?php echo $Login_status_d; ?></td>
        <td><?php echo $clg_data_d[0]->login_time; ?></td>
        <td><?php echo $clg_data_d[0]->logout_time; ?></td>
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