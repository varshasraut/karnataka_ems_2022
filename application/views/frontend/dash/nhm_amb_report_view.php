   <script>
        $(".mi_loader").fadeOut("slow");
    </script>
<style>
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

  tbody {
    /* display:block; */
    /* max-height:500px; */
    /* overflow-y:auto; */
  }

  /* thead, tbody tr {
        display:table;
        width:100%;
        table-layout:fixed;
    } */
  /* thead {
        width: calc( 100% - 1em )
    }  */
  #myTable {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  .list_table_amb td,
  .list_table_amb th {
    border: 1px solid #6f6d6d;
    padding: 8px;
  }
  #myTable td,
  #myTable th {
    border: 1px solid #6f6d6d;
    padding: 8px;
  }

  .list_table_amb tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  .list_table_amb tr:hover {
    background-color: #ddd;
  }

  .list_table_amb th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
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
  .hide{
      display: none;
  }
 
</style>
<style>
  /* { 
    box-sizing: border-box;
  }

  #myInput {
    background-image: url('/css/searchicon.png');
    background-position: 10px 10px;
    background-repeat: no-repeat;
    width: 100%;
    font-size: 16px;
    padding: 12px 20px 12px 40px;
    border: 1px solid #ddd;
    margin-bottom: 12px;
  }

  #myTable {
    border-collapse: collapse;
    width: 100%;
    border: 1px solid #ddd;
    font-size: 18px;
  }

  #myTable th,
  #myTable td {
    text-align: left;
    padding: 12px;
  }

  #myTable tr {
    border-bottom: 1px solid #ddd;
  }

  #myTable tr.header,
  #myTable tr:hover {
    background-color: #f1f1f1;
  }
   #district {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #C0C0C0;
    width: 90%;
    margin-bottom: 10px;
} */
</style>
<!-- <div class="page-content--bgf7 pb-5">
    <section class="statistic statistic2">
        <div class="container-fluid">
            <div class="row pb-5">
                <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1 mt-4 pt-1">
                    <select name="system"  class="" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7"  >
                        <option value="">Select System Type</option>
                        <option value="all">All</option>
                        <option value="102"> 102</option>
                        <option value="108"> 108</option>
                    </select>
                    <select name="amb_district"  class="" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7"  >
                            <option value="">Select District</option>
                            <?php foreach ($dist as $dst) { ?>
                               <option value="<?php echo $dst->dst_code; ?>"><?php echo $dst->dst_name; ?></option>
                            <?php } ?>     
                    </select>
                    <input type="button" name="submit" value="Submit" class="btn btn-primary submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>dashboard/show_ambulance_tracking' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' >                     
                </div>
            </div>
        </div>
    </section>
</div> -->
<div class="page-content--bgf7 pb-5" style="min-height:550px;">

  <!-- round cirlcle icons start -->
  <!-- STATISTIC-->
  <div class="container-fluid">
    <section class="statistic statistic2">
      <div class="row text-center">
        <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">
          <!--offset-md-1 col-lg-10 offset-md-1-->
          <h3>MDT TRACKING REPORT</h3>
        </div>
        <div id="print">
   <button class="button_print" onclick="window.print()">Download</button>
   </div>
      </div>
      <div class="row">
        <form enctype="multipart/form-data" action="#" method="post" id="mdt_tracking" class="col-md-12">
            <div class="col-md-3" style="float:left;">
          <div class="form-group">
            <label>District:</label><br>
            <select name="amb_district" id="amb_districtmdt" class="form-group" style="width: 90%;padding: 10px;border-radius: 8px;margin-top:0px;" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7">
              <option value="">All</option>
              <!-- <option value="">All</option> -->
              <?php foreach ($dist as $dst) { ?>
                <!-- <option value="<?php echo $dst->dst_code; ?>"><?php echo $dst->dst_name; ?></option> -->
                  <option value="<?php echo $dst->dst_code; ?>"  <?php if($district_id ==  $dst->dst_code ) { echo "selected"; } ?>><?php echo $dst->dst_name; ?></option>
                <?php } ?>
            </select>
          </div>
        </div>

        <div class="col-md-3" style="float:left;">
          <div class="button_box" style="padding-top:40px;">
               <input type="button" name="submit" value="Submit" class="btn btn-primary submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>dashboard/nhm_amb_report1' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' >     
<!--            <input type="button" name="submit" value="Submit" class="btn btn-primary submit_btnt Submit">-->
          </div>
        </div>
      </form>
      </div>
      <div id="live_tracking_view">
      <div class="row" style="padding-top: 10px;">
        <div class="col-md-3">
          <b>Total Ambulance : </b><label id="totalAmb"></label>
        </div>
        <div class="col-md-3">
          <b>Total MDT Login : </b><label id="total_mdt"></label>
        </div>
        <div class="col-md-3">
          <b>OnRoad Ambulance : </b><label id="total_onroad_new"></label>
        </div>
        <div class="col-md-3">
          <b>OffRoad Ambulance : </b><label id="total_offroad_new"></label>
        </div>
        <div class="col-md-3">
          <b>Base Location With Network Challenges : </b><label id="totalNonNetworkAmb"></label>
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
                <th scope="col"  style="background-color: #483D8B">EMT Mob No</th>
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
             
            </tbody>
          </table>
          </div>
          <div class="col-md-12" id="list_table_ambsinglelogin">
              <table id="list_table_ambsinglelogin" class="list_table_amb list_table_amb_single" style="text-align: center;">
                  <tr class="hide" style="display:none;" >
                <th scope="col">Sr.No</th>
                <th scope="col">Ambulance No</th>
                <th scope="col">Base Location</th>
                <th scope="col">EMT Name</th>
                <th scope="col">EMT Mob No</th>
                <th scope="col">Current Status</th>
                <th scope="col">EMT Login Time</th>
                <th scope="col">Total Hours HH:MM</th>
                <!-- <th scope="col">EMT Logout Time</th> -->
                <th scope="col">Pilot Name</th>
                <th scope="col">Pilot Mob No</th>
                <th scope="col">Current Status</th>
                <th scope="col">Pilot Login Time</th>
                <th scope="col">Total Hours HH:MM</th>
                <!-- <th scope="col">Pilot Logout Time</th> -->
              </tr>
            
            
          </table>
          </div>
          <div class="col-md-12" id="list_table_ambnonlogin">
              <table id="list_table_ambnonlogin" class="list_table_amb list_table_amb_no" style="text-align: center;">
                <tr class="hide" style="display:none;" >
                <th scope="col">Sr.No</th>
                <th scope="col">Ambulance No</th>
                <th scope="col">Base Location</th>
                <th scope="col">EMT Name</th>
                <th scope="col">EMT Mob No</th>
                <th scope="col">Current Status</th>
                <th scope="col">EMT Login Time</th>
                <th scope="col">Total Hours HH:MM</th>
                <!-- <th scope="col">EMT Logout Time</th> -->
                <th scope="col">Pilot Name</th>
                <th scope="col">Pilot Mob No</th>
                <th scope="col">Current Status</th>
                <th scope="col">Pilot Login Time</th>
                <th scope="col">Total Hours HH:MM</th>
                <!-- <th scope="col">Pilot Logout Time</th> -->
              </tr>
            
            
          </table>
          </div>
        
      </div>
      </div>
    </section>
  </div>
</div>
<!-- Modal -->
<div class="modal fade modalid" id="MyModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:1000px;height:800px;right: 278px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ambulance live Tracking</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <a id="mapId" class="lnk_icon_btns btn float_right" target="_blank" style="background: #085b80 !important;">Extend Map</a>
        <iframe id="mapId1" style="width:100%; height: 600px; border:0px;">
        </iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade modalid" id="MDTModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:1000px;height:800px;right: 278px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">MDT live Tracking</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <a id="mapId" class="lnk_icon_btns btn float_right" target="_blank" style="background: #085b80 !important;">Extend Map</a> -->
        <div id="map3" style="width: 900px; height: 600px; border:0px;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal loginmodal" tabindex="-1" role="dialog" id="logindetails">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="margin: 17px;">
        <div class="row">
          <h4>EMT</h4><br />
        </div>
        <div class="row">
          <b class="col-4">Name : </b><label class="col-8" id="emso_name"></label><br />
        </div>
        <div class="row">
          <b class="col-4">Contact No : </b><label class="col-8" id="emso_mob"></label>
        </div>
        <div class="row">
          <h4>Pilot</h4><br />
        </div>
        <div class="row">
          <b class="col-4">Name : </b> <label class="col-8" id="driver_name"></label><br />
        </div>
        <div class="row">
          <b class="col-4">Contact No : </b><label class="col-8" id="driver_mob"></label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="mdt_veh">
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
<link href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
  $('.Submit').on('click', function() {
    var amb_report_from_date = $('#from_date').val();
    var amb_report_to_date = $('#to_date').val();
    var amb_district = $('#amb_districtmdt').val();
    //alert(amb_district);
    $.post('<?= site_url('dashboard/nhm_amb_report1') ?>', {
      amb_report_from_date,
      amb_report_to_date,
      amb_district
    }, function(data) {
      var new_var_data = JSON.parse(data);
      var new_var = new_var_data;
      var single_var = new_var_data.single_login_amb;
      var no_var= new_var_data.one_login_amb;
     
      $('.list_table_amb_login').html("");
      $('.list_table_amb_no').html("");
      $('.list_table_ambsinglelogin').html("");
      
      var raw = '<table class="table table-bordered list_table_amb list_table_amb_login" id="myTable" style="text-align: center;">' +
        '<tr class="table-active">' +
        '<th scope="col">Sr.No</th>' +
        '<th scope="col">Ambulance No</th>' +
        '<th scope="col">Base Location</th>' +
        '<th scope="col">EMT Name</th>' +
        '<th scope="col">EMT Mob No</th>' +
        '<th scope="col">Current Status</th>' +
        '<th scope="col">EMT Login Time</th>' +
        '<th scope="col">Total Hours</th>' +
        // '<th scope="col">EMT Logout Time</th>' +
        '<th scope="col">Pilot Name</th>' +
        '<th scope="col">Pilot Mob No</th>' +
        '<th scope="col">Current Status</th>' +
        '<th scope="col">Pilot Login Time</th>' +
        '<th scope="col">Total Hours</th>' +
        // '<th scope="col">Pilot Logout Time</th>' +
        '</tr>' +
        '</table>';

      $('.list_table_amb_login').html(raw);
             
        if(new_var.length > 0 && single_var.length > 0){
           var no_data_table = '<tr class="table-active">';
        }else{
           var no_data_table = '<tr class="table-active">';
           $('.list_table_amb_login').html("");
        }
             
        var raw = '<table class="table table-bordered list_table_amb list_table_amb_no" id="myTable" style="text-align: center;">' +
         no_data_table+
        '<th scope="col">Sr.No</th>' +
        '<th scope="col">Ambulance No</th>' +
        '<th scope="col">Base Location</th>' +
        '<th scope="col">EMT Name</th>' +
        '<th scope="col">EMT Mob No</th>' +
        '<th scope="col">Current Status</th>' +
        '<th scope="col">EMT Login Time</th>' +
        '<th scope="col">Total Hours</th>' +
        // '<th scope="col">EMT Logout Time</th>' +
        '<th scope="col">Pilot Name</th>' +
        '<th scope="col">Pilot Mob No</th>' +
        '<th scope="col">Current Status</th>' +
        '<th scope="col">Pilot Login Time</th>' +
        '<th scope="col">Total Hours</th>' +
        // '<th scope="col">Pilot Logout Time</th>' +
        '</tr>' +
        '</table>';
      $('.list_table_amb_no').html(raw);
      
         var raw = '<table class="table table-bordered list_table_amb list_table_amb_single" id="myTable" style="text-align: center;">' +
        '<tr class="table-active">' +
        '<th scope="col">Sr.No</th>' +
        '<th scope="col">Ambulance No</th>' +
        '<th scope="col">Base Location</th>' +
        '<th scope="col">EMT Name</th>' +
        '<th scope="col">EMT Mob No</th>' +
        '<th scope="col">Current Status</th>' +
        '<th scope="col">EMT Login Time</th>' +
        '<th scope="col">Total Hours</th>' +
        // '<th scope="col">EMT Logout Time</th>' +
        '<th scope="col">Pilot Name</th>' +
        '<th scope="col">Pilot Mob No</th>' +
        '<th scope="col">Current Status</th>' +
        '<th scope="col">Pilot Login Time</th>' +
        '<th scope="col">Total Hours</th>' +
        // '<th scope="col">Pilot Logout Time</th>' +
        '</tr>' +
        '</table>';

      $('.list_table_amb_single').html(raw);
      
      
      $('#totalAmb').html(new_var.length+no_var.length+single_var.length);
      
      var j = 1;
      var loginmdt = 0;
      var loginDRIVER = 0;
      var loginEMSO = 0;

      for (var i = 0; i < new_var.length; i++) {
        var mdt = new_var[i].total_mdt;
        var offroad = new_var[i].total_offroad_new;
        var onroad = new_var[i].total_onroad_new;
        
      // alert(offroad);
        if (new_var[i].status == 1) {
          loginmdt++;
          //console.log(loginmdt);
        }
        if (new_var[i].clg_data_p_status == 2) {
          var Login_status_p = '-';
          var EMSOname = '-';
          var EMSOmo = '-';
          var p_login_time = '-';
        } else if (new_var[i].clg_data_p_status == 1) {
          var Login_status_p = 'Login';
          var EMSOname = new_var[i].clg_data_p;
          var EMSOmo = new_var[i].clg_datamobno_p;
          var p_login_time = new_var[i].clg_data_p_login_time
          //loginmdt++;
        } else {
          var Login_status_p = '-';
          var EMSOname = '-';
          var EMSOmo = '-';
          var p_login_time = '-';
        }
        if (new_var[i].clg_data_d_status == 2) {
          var Login_status_d = '-';
          var Pilotname = '-';
          var Pilotmo = '-';
          var d_login_time = '-';
        } else if (new_var[i].clg_data_d_status == 1) {
          var Login_status_d = 'Login';
          var Pilotname = new_var[i].clg_data_d;
          var Pilotmo = new_var[i].clg_datamobno_d;
          var d_login_time = new_var[i].clg_data_d_login_time;
          // loginmdt++;
        } else {
          var Login_status_d = '-';
          var Pilotname = '-';
          var Pilotmo = '-';
          var d_login_time = '-';
        }
        if (new_var[i].clg_data_p_status == 1) {
          loginEMSO++;
        }
        if (new_var[i].clg_data_d_status == 1) {
          loginDRIVER++;
        }
        if (new_var[i].clg_data_p_logout_time == '0000-00-00 00:00:00') {
          var logout_time_p = 'Currently Login';
        } else {
          logout_time_p = new_var[i].clg_data_p_logout_time;
        }
        if (new_var[i].clg_data_d_logout_time = '0000-00-00 00:00:00') {
          var logout_time_d = 'Currently Login';
        } else {
          var logout_time_d = new_var[i].clg_data_p_logout_time;
        }
       
        var raw = "<tr>" +
          "<td>" + j++ + "</td>" +
          "<td>" + new_var[i].amb_rto_register_no + "</td>" +
          "<td>" + new_var[i].baselocation + "</td>" +
          "<td>" + EMSOname + "</td>" +
          "<td>" + EMSOmo + "</td>" +
          "<td>" + Login_status_p + "</td>" +
          "<td>" + p_login_time + "</td>" +
          //  "<td>" + logout_time_p + "</td>" +
          "<td>" + Pilotname + "</td>" +
          "<td>" + Pilotmo + "</td>" +
          "<td>" + Login_status_d + "</td>" +
          "<td>" + d_login_time + "</td>" +
          // "<td>" + logout_time_d + "</td>" +
          "</tr>";
           
        $('#list_table_amb tr:last').after(raw);
        
      }
      
      for (var i = 0; i < single_var.length; i++) {
        var mdt = single_var[i].total_mdt;
        var offroad = single_var[i].total_offroad_new;
        var onroad = single_var[i].total_onroad_new;
        
      // alert(offroad);
        if (single_var[i].status == 1) {
          loginmdt++;
          //console.log(loginmdt);
        }
        if (single_var[i].clg_data_p_status == 2) {
          var Login_status_p = '-';
          var EMSOname = '-';
          var EMSOmo = '-';
          var p_login_time = '-';
        } else if (single_var[i].clg_data_p_status == 1) {
          var Login_status_p = 'Login';
          var EMSOname = single_var[i].clg_data_p;
          var EMSOmo = single_var[i].clg_datamobno_p;
          var p_login_time = single_var[i].clg_data_p_login_time
          //loginmdt++;
        } else {
          var Login_status_p = '-';
          var EMSOname = '-';
          var EMSOmo = '-';
          var p_login_time = '-';
        }
        if (single_var[i].clg_data_d_status == 2) {
          var Login_status_d = '-';
          var Pilotname = '-';
          var Pilotmo = '-';
          var d_login_time = '-';
        } else if (single_var[i].clg_data_d_status == 1) {
          var Login_status_d = 'Login';
          var Pilotname = single_var[i].clg_data_d;
          var Pilotmo = single_var[i].clg_datamobno_d;
          var d_login_time = single_var[i].clg_data_d_login_time;
          // loginmdt++;
        } else {
          var Login_status_d = '-';
          var Pilotname = '-';
          var Pilotmo = '-';
          var d_login_time = '-';
        }
        if (single_var[i].clg_data_p_status == 1) {
          loginEMSO++;
        }
        if (single_var[i].clg_data_d_status == 1) {
          loginDRIVER++;
        }
        if (single_var[i].clg_data_p_logout_time == '0000-00-00 00:00:00') {
          var logout_time_p = 'Currently Login';
        } else {
          logout_time_p = single_var[i].clg_data_p_logout_time;
        }
        if (single_var[i].clg_data_d_logout_time = '0000-00-00 00:00:00') {
          var logout_time_d = 'Currently Login';
        } else {
          var logout_time_d = single_var[i].clg_data_p_logout_time;
        }
        
          var single_raw = "<tr>" +
          "<td>" + j++ + "</td>" +
          "<td>" + single_var[i].amb_rto_register_no + "</td>" +
          "<td>" + single_var[i].baselocation + "</td>" +
          "<td>" + EMSOname + "</td>" +
          "<td>" + EMSOmo + "</td>" +
          "<td>" + Login_status_p + "</td>" +
          "<td>" + p_login_time + "</td>" +
          //  "<td>" + logout_time_p + "</td>" +
          "<td>" + Pilotname + "</td>" +
          "<td>" + Pilotmo + "</td>" +
          "<td>" + Login_status_d + "</td>" +
          "<td>" + d_login_time + "</td>" +
          // "<td>" + logout_time_d + "</td>" +
          "</tr>";
        $('#list_table_ambsinglelogin tr:last').after(single_raw);
        
      }
      
      for (var i = 0; i < no_var.length; i++) {
        var mdt = no_var[i].total_mdt;
        var offroad = no_var[i].total_offroad_new;
        var onroad = no_var[i].total_onroad_new;
        
      // alert(offroad);
        if (no_var[i].status == 1) {
          loginmdt++;
          //console.log(loginmdt);
        }
        if (no_var[i].clg_data_p_status == 2) {
          var Login_status_p = '-';
          var EMSOname = '-';
          var EMSOmo = '-';
          var p_login_time = '-';
        } else if (no_var[i].clg_data_p_status == 1) {
          var Login_status_p = 'Login';
          var EMSOname = no_var[i].clg_data_p;
          var EMSOmo = no_var[i].clg_datamobno_p;
          var p_login_time = no_var[i].clg_data_p_login_time
          //loginmdt++;
        } else {
          var Login_status_p = '-';
          var EMSOname = '-';
          var EMSOmo = '-';
          var p_login_time = '-';
        }
        if (no_var[i].clg_data_d_status == 2) {
          var Login_status_d = '-';
          var Pilotname = '-';
          var Pilotmo = '-';
          var d_login_time = '-';
        } else if (no_var[i].clg_data_d_status == 1) {
          var Login_status_d = 'Login';
          var Pilotname = no_var[i].clg_data_d;
          var Pilotmo = no_var[i].clg_datamobno_d;
          var d_login_time = no_var[i].clg_data_d_login_time;
          // loginmdt++;
        } else {
          var Login_status_d = '-';
          var Pilotname = '-';
          var Pilotmo = '-';
          var d_login_time = '-';
        }
        if (no_var[i].clg_data_p_status == 1) {
          loginEMSO++;
        }
        if (no_var[i].clg_data_d_status == 1) {
          loginDRIVER++;
        }
        if (no_var[i].clg_data_p_logout_time == '0000-00-00 00:00:00') {
          var logout_time_p = 'Currently Login';
        } else {
          logout_time_p = no_var[i].clg_data_p_logout_time;
        }
        if (no_var[i].clg_data_d_logout_time = '0000-00-00 00:00:00') {
          var logout_time_d = 'Currently Login';
        } else {
          var logout_time_d = no_var[i].clg_data_p_logout_time;
        }
        
          var no_raw = "<tr>" +
          "<td>" + j++ + "</td>" +
          "<td>" + no_var[i].amb_rto_register_no + "</td>" +
          "<td>" + no_var[i].baselocation + "</td>" +
          "<td>" + EMSOname + "</td>" +
          "<td>" + EMSOmo + "</td>" +
          "<td>" + Login_status_p + "</td>" +
          "<td>" + p_login_time + "</td>" +
          //  "<td>" + logout_time_p + "</td>" +
          "<td>" + Pilotname + "</td>" +
          "<td>" + Pilotmo + "</td>" +
          "<td>" + Login_status_d + "</td>" +
          "<td>" + d_login_time + "</td>" +
          // "<td>" + logout_time_d + "</td>" +
          "</tr>";
        $('#list_table_ambnonlogin tr:last').after(no_raw);
        
      }
      // alert(loginDRIVER);
      //alert(loginEMSO);
      // $('#loginDRIVER').html(loginDRIVER);

      //$('#totalAvls').html(loginavls);
      $('#total_mdt').html(mdt);
      $('#total_onroad_new').html(onroad);
      $('#total_offroad_new').html(offroad);
      $('#totalNonNetworkAmb').html('123');
      $('#loginDRIVER').html(loginDRIVER);
      $('#loginEMSO').html(loginEMSO);
      // $('#loginEMSO').html(loginEMSO);



    });
    $(".mi_loader").show();
    setTimeout(function() {
      $(".mi_loader").fadeOut("slow");
    }, 6000);

  });

  function track(amb_id) {
    var space = 0;
    $.post('<?= site_url('dashboard/get_amb_no') ?>', {
      amb_id,
      space
    }, function(data) {
      var strLink = 'https://www.nuevastech.com/API/API_LiveTrackVehicle.aspx?track=S&username=JKERC&accesskey=5682C1ED819E8B48FC3E&vehiclename=' + data + '&tracktype=LT';
      document.getElementById("mapId").setAttribute("href", strLink);
      var strLink1 = "https://www.nuevastech.com/API/API_LiveTrackVehicle.aspx?track=S&username=JKERC&accesskey=5682C1ED819E8B48FC3E&vehiclename=" + data + "&tracktype=LT";
      document.getElementById("mapId1").setAttribute("src", strLink1);
      // alert(data)
    });
    // alert(id);
    $('#MyModal').modal('show');
  }
  var veh;

  function mdt(amb_id) {
    var space = 1;
    $.post('<?= site_url('dashboard/get_amb_no') ?>', {
      amb_id,
      space
    }, function(data) {
      $('#mdt_veh').val(data);
      veh += data;
      $('#map3').html('')
      $('#MDTModal').modal('show');
      mdtloadmap();
    });
  }
  // $('#amb').on('click',function(){
  //     alert('id')
  // });
  function amb(amb_id) {
    $.post('<?= site_url('dashboard/get_app_login_user') ?>', {
      amb_id
    }, function(data) {
      var new_var = JSON.parse(data);
      for (var i = 0; i < new_var.length; i++) {
        if (new_var[i].login_type == "P") {
          var emsoName = new_var[i].clg_first_name + new_var[i].clg_mid_name + new_var[i].clg_last_name;
          $('#emso_name').html(emsoName);
          $('#emso_mob').html(new_var[i].clg_mobile_no);
        } else {
          var driverName = new_var[i].clg_first_name + new_var[i].clg_mid_name + new_var[i].clg_last_name;
          $('#driver_name').html(driverName);
          $('#driver_mob').html(new_var[i].clg_mobile_no);
        }
      }
      $('#logindetails').modal('show');
    });
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

<script>
  // loadmap();
  // $( document ).ready(function(){
  //   loadmap();
  // });
  var $MdtMarkerGroup = null,
    $MdtMarker = null;
  var map_obj, $google_map_obj;

  var $directionsAmb;
  var $directionsDisplayAmb;
  var $MdtMapUI, $MdtMap;
  var markerins = new Array();
  var amblatlong = new Array();
  // var $Allgroup =null;
  function addMarkersToMap(lat, log) {

    if ($MdtMarker != null) {
      // $MdtMap.removeObject($MdtMarker);
      $MdtMap.removeObjects($MdtMap.getObjects());
      $MdtMarker = null;
    }

    $MdtMarker = new H.map.Marker({
      lat: parseFloat(lat),
      lng: parseFloat(log)
    });
    $MdtMap.addObject($MdtMarker);
    //  sleep(5000);
    $MdtMap.getViewPort().resize();
    setTimeout(function() {
      $MdtMap.getViewPort().resize();
    }, 3000);
  }

  function mdtloadmap() {
    /*var myLatLng = {
      lat: 19.0760,
      lng: 72.8777
    };*/
    var myLatLng = {lat: 23.23979546250735, lng: 77.39215854006432};
    $Mdt_Platform = new H.service.Platform({
      apikey: 'yrjPrIYd0xU9KJpe1xlaR1_K1wFrwc9U-_-99n040JQ',
    });
    var defaultLayers = $Mdt_Platform.createDefaultLayers();

    $MdtMap = new H.Map(document.getElementById('map3'),
      defaultLayers.vector.normal.map, {
        center: myLatLng,
        zoom: 8,
        //pixelRatio: window.devicePixelRatio || 1
      });

    $allmapbehavior = new H.mapevents.Behavior(new H.mapevents.MapEvents($MdtMap));

    $MdtMap.tagId = 'map3';

    window.addEventListener('resize', () => $MdtMap.getViewPort().resize());
    $MdtMapUI = H.ui.UI.createDefault($MdtMap, defaultLayers);

    var lat = 19.0760;
    var log = 72.8777;

    addMarkersToMap(lat, log);
  }
</script>
<script>
  //loadmap();
  if (typeof H != 'undefined') {

    var amb_timer = setInterval(function() {
      // if(map_obj){ 
      // console.log(map_obj);
      var veh = $('#mdt_veh').val();
      $.post('<?= base_url('avls/get_live_data') ?>', {
        veh: veh
      }, function(result) {
        var gpsdata = JSON.parse(result);
        //alert(result);
        if (gpsdata != '') {
          $.each(gpsdata, function(index, ambdata) {

            addMarkersToMap(ambdata.amb_lat, ambdata.amb_log);
            try {
              //resetmarker($google_map_obj,ambdata.amb_rto_register_no,ambdata.amb_lat,ambdata.amb_log); 
            } catch (e) {}
          });
        } else {
          $('#data_not_found').html('No Data Found');
          return false;
        }
      });
      // }
    }, 10000);
  }

  function resetmarker($google_map_obj, ambregno, lat, log) {
    if (ambregno != "") {
      if (markerins[ambregno] != null) {} else {
        return true;
      }
      var markerLatLng = {
        lat: parseFloat(lat),
        lng: parseFloat(log)
      };
      markerins[ambregno].setPosition(markerLatLng);
    }
  }

  //         window.onload = function () {
  //             //addMarkersToMap($google_map_obj,ambregno,lat,log);
  //                   mdtloadmap();
  //         }
  //         mdtloadmap();
  //        
</script>
<style>
  #myTable th{
    text-align: center !important;
  }
  /* #EMSOname{
    text-align: center;
  } */
  /* #baselocation{
    text-align: center;
  } */

</style>