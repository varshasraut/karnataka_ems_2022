
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<?php
$CI = EMS_Controller::get_instance();
?>
<style>
  #formbox {

    text-align: right;
  }

  #onroad {
    padding-right: 6%;
    color: green;
    text-decoration: none;

  }

  #offroad {
    padding-right: 4%;
    padding-left: 5%;
    color: red;
    text-decoration: none;
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

  #clkd {
    text-align: right;
    padding-right: 14%;
    color: red;
  }

  #cboxOverlay {
    visibility: visible;
  }
</style>
<script>
  $(document).ready(function() {
    var today = new Date();
    $('.datepicker').datepicker({
      format: 'mm-dd-yyyy',
      autoclose: true,
      endDate: "today",
      maxDate: today,
      minDate: new Date(2021, 08 - 1, 01),
    }).on('changeDate', function(ev) {
      $(this).datepicker('hide');
    });


    /*$('.datepicker').keyup(function () {
        if (this.value.match(/[^0-9]/g)) {
            this.value = this.value.replace(/[^0-9^-]/g, '');
        }
    });*/
  });
</script>
<div class="page-content--bgf7 pb-5" style="min-height:550px;" id="filter_date_view">


  <div class="container-fluid">
    <section class="statistic statistic2">
      <div class="row text-center">
        <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">
          <!--offset-md-1 col-lg-10 offset-md-1-->

          <h5>District Wise OnRoad/OffRoad Report Realtime <?php echo date("d/m/Y")?></h5>
          <br>
        </div>

        <div id="print">
          <button class="button_print" onclick="window.print()">Download</button>
        </div>
      </div>

      <div class="row pb-5">
        <div class="col-md-1">
        </div>
        <div class="col-md-10" id="list_table_amb">
          <table class="list_table_amb" id="myTable" style="text-align: center;">
            <thead class="" style="">
              <tr class="table-active">
                <th style="text-align: center" width="15%" scope="col">Sr.No</th>
                <th style="text-align: center" width="15%" scope="col">District</th>
                <th style="text-align: center" width="20%" scope="col">Count of Ambulance</th>
                <th style="text-align: center" width="30%" scope="col">On-Road Ambulances with Doctor and Driver Available</th>
                <th style="text-align: center" width="20%" scope="col">Total-Off Road</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              if (is_array($amb_data)) {
                foreach ($amb_data as $amb) { ?>

                  <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $amb->district_name; ?></td>
                    <td><?php echo $amb->amb_count; ?> </td>
                    <td><?php echo $amb->off_road_doctor; ?></td>

                    <td><a href="<?php echo base_url(); ?>dashboard/realtime_offroad_status" target="_blank"><?php echo $amb->total_offroad; ?></a></td>


                    <!-- <td><?php echo $amb->total_offroad; ?> </td> -->
                  </tr>
              <?php $count++;
                }
              }


              ?>

            </tbody>
          </table>
          <div id="formbox">
            <a id="onroad" href="<?php echo base_url(); ?>dashboard/ambulance_onroad_popup" target="_blank">View List Of Onroad </a>
            <a id="offroad" href="<?php echo base_url(); ?>dashboard/ambulance_status_popup" target="_blank">View List Of Offroad </a>
          </div>
        </div>
        <div class="col-md-1">
        </div>
      </div>
    
    </section>
  </div>
</div>
<input type="hidden" id="mdt_veh">
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
<link href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
