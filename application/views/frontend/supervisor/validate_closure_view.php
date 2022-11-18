<div id="report_data_view_details">
  <div class="container">
    <form enctype="multipart/form-data" method="post" action="">
      <div class="width100 float_left">
        <div class="width20 float_left">
          <label>District:</label>
          <select name="amb_district" id="amb_district" class="form-group" TABINDEX="7">
            <option value="">All</option>
            <?php foreach ($dist as $dst) { ?>
              <option value="<?php echo $dst->dst_code; ?>"><?php echo $dst->dst_name; ?></option>
            <?php } ?>
          </select>

        </div>
        <!-- <div class="width20 float_left">
          <label>From Date<span class="md_field">*</span>:</label>
          <input name="from_date" tabindex="1" class="mi_timecalender_sch filter_required" placeholder="From Date" type="text" data-errors="{filter_required:'From Date should not be blank!'}" value="" id="from_date">
        </div> -->
        <!-- <div class="width30 float_left">
      <label>Amb Type:</label>
      <select name="amb_type" id="amb_type" class="form-group" style="width: 90%;padding: 10px;border-radius: 8px;margin-top:0px;" TABINDEX="7" required>
        <option value="">All</option>
        <option value="1">JE</option>
        <option value="2">BLS</option>
        <option value="3">ALS</option>
      </select>

    </div> -->
        <div class="width20 float_left">
          <div class="button_box" style="padding-top:10px;">
            <input type="button" name="submit" value="Submit" class="form-xhttp-request button_print2" data-href='<?php echo base_url(); ?>supervisor/get_validate_count' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content'>

            <!-- <input type="submit" name="submit" value="Submit" class="btn btn-primary submit_btnt Submit"> -->
          </div>
        </div>
      </div>
      <div class="container">

    </form>


    <div class="width100 float_left">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Total Dispatch</th>
            <th>Total Closure</th>
            <th>MDT Closure</th>
            <th>DCO Closure</th>
            <th>Total Validate</th>
          </tr>
        </thead>
        <tbody>
          <tr class="text_center">
            <td><b><?php echo $dis_data ?></b> </td>
            <td><b><?php echo $clo_data ?></b> </td>
            <td><b><?php echo $mdt_data ?></b> </td>
            <td><b><?php echo $dco_data ?></b> </td>
            <td><b><?php echo $val_data ?></b> </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

