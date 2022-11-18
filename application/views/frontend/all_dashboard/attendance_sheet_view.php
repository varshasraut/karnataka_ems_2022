<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<div class="row">
    <div class="col-md-2" style="margin-top: 32px;">
        <input name="from_date" tabindex="1" class="form_input" placeholder="From Date" type="text" value="" readonly="readonly" id="from_date">
    </div>
    <div class="col-md-2" style="margin-top: 32px;">
        <input name="to_date" tabindex="2" class="form_input" placeholder="To Date" type="text"  value="" readonly="readonly" id="to_date">
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>District :</label><br>
            <select name="amb_district" id="amb_districtmdt" class="form-group" style="border-radius: 8px;margin-top:0px;" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7">
                <option value="">All</option>
                <?php foreach ($dist as $dst) { ?>
                    <option value="<?php echo $dst->dst_code; ?>" <?php if ($district_id ==  $dst->dst_code) {echo "selected";
                     } ?>>
                     <?php echo $dst->dst_name; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Select User :</label><br>
            <select name="" aria-placeholder="Select User" id="viewSelector" class="form-group" style="border-radius: 8px;margin-top:0px;" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7">
                <option value="">Select User</option>
                <option value="1">EMT</option>
                <option value="2">Pilot</option>
            </select>
        </div>
    </div>
    <div class="col-md-2" id="1">
        <div class="form-group" style="margin-top: 32px;">
            <select name="" aria-placeholder="Select User" id="" class="form-group" style="border-radius: 8px;margin-top:0px;" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7">
                <option value="">Select EMT</option>
            </select>
        </div>
    </div>
    <div class="col-md-2" id="2">
        <div class="form-group" style="margin-top: 32px;">
            <select name="" aria-placeholder="Select User" id="" class="form-group" style="border-radius: 8px;margin-top:0px;" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7">
                <option value="">Select Pilot</option>
            </select>
        </div>
    </div> 
    <div class="col-md-1" style="margin-top: 25px;">
        <input type="button" name="search_btn" value="Search" class="btn clg_search form-xhttp-request float_left" data-href="" data-qr="">
    </div>        
</div>


<div class="row pb-4">
    <div class="col-md-12" id="list_table_amb_div">
        <table class="list_table_amb" id="myTable" style="text-align: center;">
            <thead class="" style="text-align: center;">
                <tr class="table-active">
                    <th id="centerth1" scope="col">Sr.No</th>
                    <th id="centerth1" scope="col">Date</th>
                    <th id="centerth1" scope="col">Ambulance No</th>
                    <th id="centerth1" scope="col">District</th>
                    <th id="centerth1" scope="col">Name</th>
                    <th id="centerth1" scope="col">Login Time</th>
                    <th id="centerth1" scope="col">Logout Time</th>
                    <th id="centerth1" scope="col">Hours</th>

                </tr>
            </thead>
        </table>
    </div>
</div>

<style>
    .form_input{
        padding-top: 20px;
    }
    #centerth1 {
        text-align: center;
        border: 2px solid white;
        padding: 10px;
    }

    #centerth {
        text-align: center;
        border: 2px solid white;
    }

    col {
        text-align: center;
    }

    table {
        border-collapse: revert;
        border-bottom: none;

    }

    table th {
        font-size: 17px;
    }

    .table-active,
    .table-active>td,
    .table-active>th {
        background: #085b80 !important;
    }
</style>
<script>
 $("#1").hide();
    $("#2").hide();
        $(document).ready(function() { 
         $.viewMap = {
    '0' : $([]),
    '1' : $('#1'),
    '2' : $('#2'),
  };
  $('#viewSelector').change(function() {
    // hide all
    $.each($.viewMap, function() { this.hide(); });
    // show current
    $.viewMap[$(this).val()].show();
     });
    });
</script>