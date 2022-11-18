<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js" type="text/javascript"></script> -->
<div class="row" id="ofhead">
    <div class="col-md-8" id="ofhead1">
        <label id="oflbl">Feedback</label>
    </div>
    <div class="col-md-1">
        <button type="button" id="first"  onClick="reply_click1()" class="btn btn-light btn1">Circle</button>
    </div>
    <div class="col-md-1">
        <button type="button" id="second" onclick="reply_click2()" class="btn btn-light btn2">Zone</button>
    </div>
    <div class="col-md-1">
        <button type="button" id="third" onclick="reply_click3()" class="btn btn-light btn3">ZM</button>
    </div>
    <div class="col-md-1">
        <button type="button" id="fourth"  class="btn btn-light btn4">DM</button>
    </div>
</div>
<div id="lefthalf">
    <div class="row" id="ofcontent">
        <div class="col-md-3" id="box">
            <h3 class="headclr2">2460</h3>
            <label id="rowlbl">Total Manpower</label>
        </div>
        <div class="col-md-2" id="box">
            <h3 class="headclr2">2100</h3>
            <label id="rowlbl">Active</label>
        </div>
        <div class="col-md-2" id="box">
            <h3 class="headclr2">300</h3>
            <label id="rowlbl">Inactive</label>
        </div>
        <div class="col-md-2" id="box">
            <h3 class="headclr2">100</h3>
            <label id="rowlbl">Vacant</label>
        </div>
    </div>
    <div class="row" id="ofcontent">
        <div class="col-md-3" id="box">
            <h3 class="headclr2">2200</h3>
            <label id="rowlbl">Total Manpower</label>
        </div>
        <div class="col-md-2" id="box">
            <h3 class="headclr2">1000</h3>
            <label id="rowlbl">EMT</label>
        </div>
        <div class="col-md-2" id="box">
            <h3 class="headclr2">1000</h3>
            <label id="rowlbl">Pilot</label>
        </div>
        <div class="col-md-2" id="box">
            <h3 class="headclr2">200</h3>
            <label id="rowlbl">Mechanics</label>
        </div>
    </div>
    <div class="row" id="ofcontent">
        <div class="col-md-3" id="box">
            <h3 class="headclr2">60</h3>
            <label id="rowlbl">Supervisor</label>
        </div>
        <div class="col-md-2" id="box">
            <h3 class="headclr2">40</h3>
            <label id="rowlbl">ADM</label>
        </div>
        <div class="col-md-2" id="box">
            <h3 class="headclr2">30</h3>
            <label id="rowlbl">DM</label>
        </div>
        <div class="col-md-2" id="box">
            <h3 class="headclr2">20</h3>
            <label id="rowlbl">Ops.Manager</label>
        </div>
    </div>
    <div class="row" id="ofcontent">
        <div class="col-md-3" id="box">
            <h3 class="headclr2">60</h3>
            <label id="rowlbl">Biomedical Eng.</label>
        </div>
        <div class="col-md-2" id="box">
            <h3 class="headclr2">50</h3>
            <label id="rowlbl">ZC</label>
        </div>
        <div class="col-md-2" id="box">
            <h3 class="headclr2">20</h3>
            <label id="rowlbl">ZM</label>
        </div>
        <div class="col-md-2" id="box">
            <h3 class="headclr2">10</h3>
            <label id="rowlbl">OH</label>
        </div>
    </div>

</div>
<div id="righthalf">
    <div id="ETWPS">
        <label>Manpower</label><br>
        <button type="button" id="frmbtm" onclick="funto()" class="btn-outline-primary">Total Manpower</button>
        <button type="button" id="frmbtm" onclick="funto2()" class="btn-outline-primary">Total Manpower</button>
    </div>
    <div id="pie1">
        <canvas id="pieChart1" style="max-width:300px;display:inline;"></canvas>
    </div>
    <div id="pie2">
        <canvas id="pieChart2" style="max-width:300px;display:inline;"></canvas>
    </div>
</div>
<div id="center">
   <canvas id="canvas" width="600" height="400"></canvas>
</div>

<script>
    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');

    var myChart = new Chart(ctx, {
   type: 'line',
   data: {
      labels: ["2010", "2011", "2012", "2013"],
      datasets: [{
         label: 'Dataset 1',
         data: [150, 200, 250, 150],
         color: "#878BB6",
      }, {
         label: 'Dataset 2',
         data: [250, 100, 150, 10],
         color: "#4ACAB4",
      }]
   }
    });
</script>
<style>
       .btn2{
        display: none;
    }
    .btn3{
        display: none;    
    }
    .btn4{
        display: none;    
    }
    .headclr2{
        background:linear-gradient(to right, rgb(69 212 199), rgb(235 235 235));
        padding: 10px;
        margin: 0px;
        font-weight: bold;
    }
    #ccstatus{
        padding-left: 20px;
        padding-top: 10px;
    }
    #sts{
        color: red;
        font-weight: bold;
    }

    #frmbtm {
        color: grey;
        border: 1px solid grey;
    }

    #ETWPS {
        text-align: center;
        font-size: 20px;
    }

    .btn {
        width: 80%;
    }

    #headlbl {
        text-align: center;
        padding-top: 10px;
        font-size: 20px;
        font-weight: bold;
    }

    .col-md-1 {
        padding: 10px;
    }

    #headlbl2 {
        color: red;
    }

    #rowlbl {
        font-size: 16px;
        padding-top: 10px;
        font-weight: bold;
    }

    #lefthalf {
        width: 60%;
        float: left;
    }

    #righthalf {
        width: 40%;
        float: left;
        padding-right: 12px;

    }

    #ofhead {
        background-color: #085b80;
    }

    #ofhead1 {
        padding: 10px;
    }

    #oflbl {
        color: white;
        font-size: 20px;
        font-weight: bold;
    }

    #box {
        border: 2px solid black;
        margin: 10px;
        text-align: center;
        padding: 0px;
        box-shadow: 5px 5px 5px #888888;
        border-bottom-left-radius: 40px 10px;
    }

    #content .row {
        padding-left: 12px;
        width: 100%;

    }
</style>
<script type="text/javascript">    
    
    function reply_click1() {
        document.getElementById('second').style.display = 'block';
        document.getElementById('third').style.display = 'none';
        document.getElementById('fourth').style.display = 'none';

    }

     function reply_click2() {
        document.getElementById('second').style.display = 'block';
        document.getElementById('third').style.display = 'block';
        document.getElementById('fourth').style.display = 'none';

     }

     function reply_click3() {
        document.getElementById('second').style.display = 'block';
        document.getElementById('third').style.display = 'block';
        document.getElementById('fourth').style.display = 'block';
     }
</script>
