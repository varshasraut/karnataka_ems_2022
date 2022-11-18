
   <script>
        $(".mi_loader").fadeOut("slow");
    </script>
<div id="print">
    <button class="button_print" onclick="window.print()">Download</button>
</div>
<div id="headdata">
    <h5 id="biodata">Biomedical Equipment Data</h5>
</div>
<table class="table">
    <thead>
        <tr class="table-warning">
            <th scope="col" style="width: 20%;">Total Equipment</th>
            <th scope="col">ALS</th>
            <th scope="col">ALS %</th>
            <th scope="col">BLS</th>
            <th scope="col">BLS %</th>
            <th scope="col">Total</th>
            <th scope="col">Total %</th>
        </tr>
    </thead>
    <tbody>
        <tr class="table-primary">
            <th scope="row">Critical</th>
            <td>1384</td>
            <td>99.00%</td>
            <td>2106</td>
            <td>99.72%</td>
            <td>3490</td>
            <td>99.43%</td>
        </tr>
        <tr class="table-secondary">
            <th scope="row">Major</th>
            <td>2321</td>
            <td>99.61%</td>
            <td>7003</td>
            <td>99.47%</td>
            <td>9324</td>
            <td>99.51%</td>
        </tr>
        <tr class="table-danger">
            <th scope="row">Minor</th>
            <td>5579</td>
            <td>99.77%</td>
            <td>16862</td>
            <td>99.80%</td>
            <td>22441</td>
            <td>99.79%</td>
        </tr>
        <tr class="table-success">
            <th scope="row">Total</th>
            <td>9284</td>
            <td>99.61%</td>
            <td>25971</td>
            <td>99.70%</td>
            <td>35255</td>
            <td>99.68%</td>
        </tr>
    </tbody>
</table>
<div style="width: 100%;">
    <div id="parameters">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Parameter</th>
                    <th scope="col">Critical(3510)</th>
                    <th scope="col">Major(9370)</th>
                    <th scope="col">Minor(22488)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">Available</th>
                    <td>100%</td>
                    <td>100%</td>
                    <td>100%</td>
                </tr>
                <tr>
                    <th scope="row">Functional</th>
                    <td>99.43%</td>
                    <td>99.64%</td>
                    <td>99.96%</td>
                </tr>
                <tr>
                    <th scope="row">In Repair</th>
                    <td>0.57%</td>
                    <td>0.36%</td>
                    <td>0.15%</td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td><a id="viewdata" href="<?php echo base_url();?>dashboard/biomedical_popup" target="_blank">View Critical</a></td>
                    <td><a id="viewdata" href="<?php echo base_url();?>dashboard/biomedical_major_popup" target="_blank">View Major</a></td>
                    <td><a id="viewdata" href="<?php echo base_url();?>dashboard/biomedical_minor_popup" target="_blank">View Minor</a></td>
                </tr>
            </tbody>
        </table>
        <!-- <div id="formbox" style="text-align: center;">
          <a id="viewdata" href="<?php echo base_url();?>dashboard/biomedical_popup" target="_blank">View Critical</a>
          <a id="viewdata" href="<?php echo base_url();?>dashboard/biomedical_major_popup" target="_blank">View Major</a>
          <a id="viewdata" href="<?php echo base_url();?>dashboard/biomedical_minor_popup" target="_blank">View Minor</a>
          </div> -->
    </div>
    <div style="width: 50%;float:left;">
        <canvas id="bar-chart-grouped" class="barchart"></canvas>


    </div>
</div>

<style>
    th,
    td {
        text-align: center !important;
        font-size: 20px !important;
    }

    #biodata {
        font-size: 25px;
    }
    #viewdata{
        color: green;
        font-size: 25px;
        font-weight: bold;
    }
    #headdata {
        text-align: center;
        padding-bottom: 20px;
    }

    #paratable {
        width: 80%;
    }

    .barchart {
        display: block;
        height: 410px !important;
        width: 900px !important;
        padding-left: 50px;
    }

    #parameters {
        width: 50%;
        float: left;
        padding-top: 6%;
    }
</style>
<script>
    new Chart(document.getElementById("bar-chart-grouped"), {
        type: 'bar',
        data: {
            labels: ["Critical", "Major", "Minor"],
            datasets: [{
                label: "ALS",
                backgroundColor: "#3e95cd",
                data: [1384, 2321, 5579]
            }, {
                label: "BLS",
                backgroundColor: "#8e5ea2",
                data: [2106, 7003, 16862]
            }]
        },
        options: {
            title: {
                display: true,
                fontSize: 18,
                text: 'Total Equipment'

            },
            scales: {
                xAxes: [{
                    ticks: {
                        autoSkip: false,
                        fontSize: 18,
                        fontStyle: "bold",
                        precision: 2,
                        suggestedMin: 0
                    }
                }],
                yAxes: [{
                    ticks: {
                        fontSize: 18,
                        fontStyle: "bold",
                        precision: 2,
                        suggestedMin: 0
                    }
                }]
            }
        }
    });
</script>