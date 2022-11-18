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
    .button_print {
  
      border: none;
      color: white;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 17px;
      margin: 1px 1px;
      cursor: pointer;
      background-color: #085B80;
      
    }
    #print{
        text-align:right;
        padding: 0% 10% 1% 0px;
       
    }
    #onroadhead{
    text-align:center;
    padding: 2% 0% 1% 0px;
    color: #1d3c5d;
    font-size: 25px;

}
.mi_calender{
    padding: 10px;
    border-radius: 8px;
    border:1px solid #C0C0C0;
    width:90%;
    margin-bottom: 10px;
}  
#list_table_amb{
    text-align: center;
    padding-left: 30%;

} 
    </style>
<div class="page-content--bgf7 pb-5" style="min-height:550px;">
<div class="row" >
  <div class="col-md-10" id="onroadhead">
  <h5 style="font-weight: bold;">Base Location With Network Challenges</h5>
</div>
  <div class="col-md-2" id="print">
   <button class="button_print" onclick="window.print()">Download</button>
   </div>
   </div>

  <div class="container-fluid">
    <section class="statistic statistic2">




      <div class="row pb-5">
      <div class="col-md-1">
    </div>
        <div class="col-md-10" id="list_table_amb">
          <!--offset-md-1 col-lg-10 offset-md-1 mt-4 pt-1-->
          <table class="list_table_amb" style="width:60%;" id="myTable" style="text-align: center;">
            <thead class="" style="">
              <tr class="table-active" >
                <th style="text-align: center" width="10%" scope="col">Sr.No</th>
                <th style="text-align: center" width="10%" scope="col">District</th>
                <th style="text-align: center" width="30%" scope="col">Base Location</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              if (is_array($amb_data)) {
                foreach ($amb_data as $amb) { ?>
                    <tr>
                      <td style="text-align: center;"><?php echo $count; ?></td>
                      <td style="text-align: center;"><?php echo $amb->district_name; ?></td>
                      <td style="text-align: center;"><?php echo $amb->base_location; ?></td>                    
                    </tr>
     <?php $count++;

                }
              }
              

              ?>
                    
            </tbody>
          </table>
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
