<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> 
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
            <h3 class="headclr3">937</h3>
            <label id="rowlbl">Total Ambulance</label>
        </div>
        <div class="col-md-3" id="box">
            <h3 class="headclr3">41</h3>
            <label id="rowlbl">Off Road</label>
        </div>
        <div class="col-md-3" id="box">
            <h3 class="headclr3">17 Hours</h3>
            <label id="rowlbl">Total Off Road – Hours</label>
        </div>
    </div>
    <div class="row" id="ofcontent">
        <div class="col-md-3" id="box">
            <h3 class="headclr3">20</h3>
            <label id="rowlbl">ALS</label>
        </div>
        <div class="col-md-3" id="box">
            <h3 class="headclr3">20</h3>
            <label id="rowlbl">Off Road - Maintenance</label>
        </div>
        <div class="col-md-3" id="box">
            <h3 class="headclr3">17 Hours</h3>
            <label id="rowlbl">MT - Off Road – Hours</label>
        </div>
    </div>
    <div class="row" id="ofcontent">
        <div class="col-md-3" id="box">
            <h3 class="headclr3">21</h3>
            <label id="rowlbl">BLS</label>
        </div>
        <div class="col-md-3" id="box">
            <h3 class="headclr3">21</h3>
            <label id="rowlbl">Off Road – Manpower</label>
        </div>
        <div class="col-md-3" id="box">
            <h3 class="headclr3">17 Hours</h3>
            <label id="rowlbl">MP - Off Road – Hours</label>
        </div>
    </div>
    <div class="row" id="ofcontent">
        <div class="col-md-3" id="box">
            <h3 class="headclr3">896</h3>
            <label id="rowlbl">On Road</label>
        </div>
        <div class="col-md-3" id="box">
            <h3 class="headclr3">96%</h3>
            <label id="rowlbl">On Road %</label>
        </div>
        <div class="col-md-3" id="box">
            <h3 class="headclr3">4%</h3>
            <label id="rowlbl">Off Road %</label>
        </div>

    </div>
</div>
<div id="righthalf">
    <div class="row">
        <div class="col-md-12" id="headlbl">
            <label for="" id="headlbl2">Top 10 Off Road Ambulances</label>
        </div>
    </div>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Base Location</th>
                <th scope="col">Vehicle Number</th>
                <th scope="col">Hours</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Aundh hospital pune</td>
                <td>MH 12 DL 9657</td>
                <td>17 Hours</td>
            </tr>
            <tr>
                <td>Aurangabad Civil Hospital</td>
                <td>MH 14 CL 1432</td>
                <td>15 Hours</td>
            </tr>
            <tr>
                <td>Wardha District Hospital</td>
                <td>MH 14 CL 1159</td>
                <td>14 Hours</td>
            </tr>
        </tbody>
    </table>
</div>
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
    .headclr3{
        background: linear-gradient(to right, rgb(105 109 243), rgb(235 235 235));
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
    #pie1 {
        padding-top: 10px;
        text-align: center;
        display: none;
    }

    #pie2 {
        padding-top: 10px;
        text-align: center;
        /* display: none; */
    }
    .table .thead-dark th{
        background-color: #085b80;
        font-size: 15px;
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