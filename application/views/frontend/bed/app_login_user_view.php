        <h5 class="modal-title">Login User</h5>
    
      <div class="width100" style="margin: 17px;">
        <div class="row">
            <h4>Pilot</h4><br/>
        </div>
        <div class="row">
            <b class="col-4">Name : </b> <label class="col-8" id="driver_name"><?php echo $usr_login_data[0]->clg_first_name;?> <?php echo $usr_login_data[0]->clg_mid_name;?> <?php echo $usr_login_data[0]->clg_last_name;?></label><br/>
        </div>
        <div class="row">
            <b class="col-4">Contact No : </b><label class="col-8" id="driver_mob"><?php echo $usr_login_data[0]->clg_mobile_no;?></label>
        </div>
      </div>