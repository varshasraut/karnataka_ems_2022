    <script>
        $(".mi_loader").fadeOut("slow");
    </script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<div id="report_data_view_details">


<div class="row">
    <div class="col-md-12" id="head">
        <label for=""> Dashboard Data Report Datewise</label><br>
            <label for=""><?php echo $current_date?> <?php echo $time ?></label>
    </div>
</div>
<div class="row">
    <div class="col-md-10">
        <form enctype="multipart/form-data" id="date_filter" method="post" action="" style="height: 100px;">
            <div class="width100" style="display:flex">

                <div class="width30" style="margin-left:50px;margin-top:8px">
                    <input name="select_date" class="filter_required mi_calender datepicker" value="" type="text" tabindex="1" placeholder="Select Date" data-errors="{filter_required:'Date should not blank'}">
                </div>&nbsp;&nbsp;&nbsp;
                <div class="width20 ">
                    <input type="button" name="submit" value="Submit" class="form-xhttp-request button_print2" data-href='<?php echo base_url(); ?>dashboard/dashboard_data_datewise_view' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content'>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-2">
        <div id="print">
            <button class="button_print" onclick="window.print()">Download</button>
        </div>
    </div>
</div>




<div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-10">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th id="eroperh">IRTS 108</th>
                    <th id="eroperh">Till Date</th>
                    <th id="eroperh">This Month</th>
                    <th id="eroperh">Today</th>
                </tr>
            </thead>

            <tbody>
                <?php

                if ($dash_data) {
                    foreach ($dash_data as $dash) { ?>
                        <tr>
                            <td id="eroper2">Total Call</td>
                            <td id="eroper3"><?php echo $dash->count_till_date+22241019; ?></td>
                            <td id="eroper3"><?php echo $dash->count_till_month; ?></td>
                            <td id="eroper3"><?php echo $dash->total_calls_today; ?></td>
                        </tr>
                        <tr>
                            <td id="eroper2">Emergency Call</td>
                            <td id="eroper3"><?php echo $dash->eme_count_till_date+3602556; ?></td>
                            <td id="eroper3"><?php echo $dash->eme_count_till_month; ?></td>
                            <td id="eroper3"><?php echo $dash->today_eme; ?></td>

                        </tr>
                        <tr>
                            <td id="eroper2">Non Emergency Call </td>
                            <td id="eroper3"><?php echo $dash->noneme_count_till_date+18638463; ?></td>
                            <td id="eroper3"><?php echo $dash->noneme_count_till_month; ?></td>
                            <td id="eroper3"><?php echo $dash->today_non_eme; ?></td>
                        </tr>
                        <tr>
                            <td id="eroper2">Ambulance Dispatch</td>
                            <td id="eroper3"><?php echo $dash->dispatch_till_date+3602556; ?></td>
                            <td id="eroper3"><?php echo $dash->eme_count_till_month; ?></td>
                            <td id="eroper3"><?php echo $dash->today_eme; ?></td>
                        </tr>
                        <tr>
                            <td id="eroper2">Emergency Patient Served</td>
                            <td id="eroper3"><?php echo $dash->closure_till_date+6176511; ?></td>
                            <td id="eroper3"><?php echo $dash->closure_till_month; ?></td>
                            <td id="eroper3"><?php echo $dash->closure_today; ?></td>
                        </tr>
                <?php }
                } ?>



            </tbody>

        </table>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th id="eroperh">Total Ambulance</th>
                    <th id="eroperh">Ambulance On Road</th>
                    <th id="eroperh">In Maintenance</th>
                    <th id="eroperh">EMT Present</th>
                    <th id="eroperh">Pilot Present</th>
                </tr>
            </thead>

            <tbody>
                <tr> 
            
                            <td id="eroper3"><?php echo $total; ?></td>
                            <td id="eroper3"><?php echo $on_data[0]->count; ?></td>
              
                            <td id="eroper3"><?php echo $off_data[0]->count; ?></td>
                
                            <td id="eroper3"><?php echo $on_data[0]->count; ?></td>
                            <td id="eroper3"><?php echo $on_data[0]->count;?></td>
                   
                </tr>
            </tbody>

        </table>
    </div>
    <div class="col-md-1">
    </div>
</div>
</div>
<style>
    #head{
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        color: black;
    }
    .button_print {

        border: none;
        color: white;
        padding: 10px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 15px;
        margin: 1px 1px;
        cursor: pointer;
        background-color: #085B80 !important;

    }

    .button_print2 {

        border: none;
        color: white;
        padding: 5px 10px 5px 10px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 15px;
        margin: 1px 1px;
        cursor: pointer;
        background-color: #085B80 !important;

    }

    #print {
        text-align: right;
        padding-right: 10px;

    }

    table th {
        background: #2F419B;
        color: #ffffff;
        text-align: left;
        font-size: 14px;
        height: 22px;
        line-height: 22px;
        font-family: 'Open Sans';
        padding-left: 10px;
    }

    #eroper {
        font-weight: bold !important;
        text-align: left !important;
    }

    #eroperh {
        text-align: center !important;
        font-size: 17px !important;
    }

    .table-bordered td {
        text-align: center !important;
        padding: 8px !important;
    }

    #eroper2 {
        font-weight: bold !important;
        text-align: left !important;
        padding: 14px !important;
    }

    #eroper3 {
        padding: 16px !important;
        font-size: 20px !important;
        
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
            minDate: new Date(2021, 10 - 1, 01)
        }).on('changeDate', function(ev) {
            $(this).datepicker('hide');
        });
    });
</script>