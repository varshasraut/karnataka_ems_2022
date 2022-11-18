<!--<div class="box3">    
    
    <div class="emt_landing_page">
      
        <div class="inspection_dash_buttons">
                <a class="action_button click-xhttp-request" data-href="{base_url}inv/invlist_amb" data-qr="output_position=content&amp;filters=no&amp;inv_type=CA&amp;inv_amb=<?php echo $inv_amb;?>">TOTAL INSPECTION<br><?php echo $total_count_ins;?> </a>
                
        </div>
        <div class="inspection_dash_blck_buttons">
   <a class="action_button click-xhttp-request" data-href="{base_url}inv/invlist_amb" data-qr="output_position=content&amp;filters=no&amp;inv_type=NCA&amp;inv_amb=<?php echo $inv_amb;?>">TOTAL GRIEVANCE<br><?php echo $total_count_gri; ?> </a>
            
        </div>
        <div class="inspection_dash_green_buttons">
  <a class="action_button click-xhttp-request" data-href="{base_url}med/medlist_amb" data-qr="output_position=content&amp;filters=no&amp;inv_type=MED&amp;med_amb=<?php echo $inv_amb;?>">TOTAL COMPLETED<br><?php echo $total_count_ins;?> </a>
            
        </div>
        <div class="inspection_dash_green_buttons">
           <a class="action_button click-xhttp-request" data-href="{base_url}eqp/eqplist_amb" data-qr="output_position=content&amp;filters=no&amp;inv_type=EQP&amp;eqp_amb=<?php echo $inv_amb;?>">TOTAL RESOLVED <br><?php echo $total_count_comp_gri; ?></a>
            
        </div>
        <div class="inspection_dash_orng_buttons">
  <a class="action_button click-xhttp-request" data-href="{base_url}med/medlist_amb" data-qr="output_position=content&amp;filters=no&amp;inv_type=MED&amp;med_amb=<?php echo $inv_amb;?>">TOTAL IN-PROGRESS <br><?php echo '0';?></a>
            
        </div>
        <div class="inspection_dash_orng_buttons">
           <a class="action_button click-xhttp-request" data-href="{base_url}eqp/eqplist_amb" data-qr="output_position=content&amp;filters=no&amp;inv_type=EQP&amp;eqp_amb=<?php echo $inv_amb;?>">TOTAL IN-PROGRESS <br><?php echo $total_count_gri - $total_count_comp_gri; ?></a>
            
        </div>
      
    </div>
    
</div>-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<style>
.table td {
    text-align: center;
}
</style>

<div class="row">
    <div class="col-md-5 cardrow">
        <div class="row displaycart">
            <div class="col-md-12 countval">
                INSPECTION
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 head-cardrow">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <!-- <td>Till Date</td>
                            <td>This Month</td> -->
                            <td>Total Inspection</td>
                            <td>Total Completed</td>
                            <td>Total In-Progress</td>
                        </tr>
                        <tr>
                            <td><?php echo $total_count_ins; ?></td>
                            <!-- <td><?php echo $total_count_ins_month; ?></td> -->
                            <td><?php echo $total_count_ins_month; ?></td>
                            <td><?php echo $total_count_ins_progress; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-5 cardrow">
        <div class="row displaycart">
            <div class="col-md-12 countval">
                GRIEVANCE
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 head-cardrow">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <!-- <td>Till Date</td> -->
                            <!-- <td>This Month</td> -->
                            <td>Total Grievance</td>
                            <td>Total Completed</td>
                            <td>Total In-Progress</td>
                        </tr>
                        <tr>
                            <td><?php echo $total_count_gri; ?></td>
                            <!-- <td><?php echo $total_count_gri_month; ?></td> -->
                            <td><?php echo $total_count_gri_month; ?></td>
                            <td><?php echo $total_count_gri_progress; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 connectedSortable">
        <canvas id="myChart1" style="width:650px;height:400px"></canvas>
    </div>

    <div class="col-md-6 connectedSortable">
        <canvas id="myChart2" style="width:650px;height:400px"></canvas>
    </div>
</div>


<script>
var xValues = ["Completed", "In-Progress"];
var yValues = [<?php echo $total_count_ins_month; ?>, <?php echo $total_count_ins_progress; ?>];
var barColors = [
    "#76D7C4",
    "#F5B041"
];

new Chart("myChart1", {
    type: "pie",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        title: {
            display: true,
            text: "Inspection Dashboard",
            fontSize: 30
        }
    }
});

</script>

<script>
var xValues = ["Completed", "In-Progress"];
var yValues = [<?php echo $total_count_gri_month; ?>, <?php echo $total_count_gri_progress; ?>];
var barColors = [
    "#76D7C4",
    "#F5B041"
];
new Chart("myChart2", {
    type: "pie",
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        title: {
            display: true,
            text: "Grievance Dashboard",
            fontSize: 30
        }
    }
});
</script>

<style>
.icon1 {
    font-size: 60px;
    color: #C48A69;
    margin: 10px;
}

.icon2 {
    font-size: 60px;
    color: #6C244C;
    margin: 10px;
}

.cardrow {
    border: 2px solid grey;
    margin: 40px;
    border-radius: 10px;
    box-shadow: 7px 10px #cac9c95c;
    padding: 0px !important;
}

.countval {
    font-size: 30px;
    font-weight: bold;
    text-align: center;
    padding: 20px;
}

.head-cardrow {
    text-align: center;
    font-size: 15px;
    font-weight: bold;
    border-top: 2px solid grey;
    padding: 5px 10px 5px 10px;
}

.row {
    margin: 0px !important;
}

.displaycart {
    display: flex;
    align-content: space-between;
}
</style>