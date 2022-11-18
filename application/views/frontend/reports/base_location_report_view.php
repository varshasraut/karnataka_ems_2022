<style>
    .button_print {

        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        font-size: 17px;
        margin: 1px 1px;
        cursor: pointer;
        background-color: #085B80;
        float: right;

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
        text-align: center !important;
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
</style>
<div class="page-content--bgf7 pb-5" style="min-height:550px;">

    <!-- round cirlcle icons start -->
    <!-- STATISTIC-->
    <div class="container-fluid">
        <section class="statistic statistic2">
            <div class="row text-center">
                <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">
                    <!--offset-md-1 col-lg-10 offset-md-1-->
                    <h3>BASE LOCATION REPORT</h3>
                </div>
            </div>
            <!-- <form action="<?php echo base_url(); ?>reports/base_location_report_download" method="post" enctype="multipart/form-data" target="form_frame"> -->

            <div class="row">
                <!-- <div class="col-md-4">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Ambulance Type :</div>
                    </div>
                    <div class="width100 float_left">
                        <select id="system" name="system" class="" data-errors="{filter_required:'Ambulance Type Should not be Blank'}" TABINDEX="7">
                            <option value="">Ambulance Type</option>
                            <option value="108">108 Ambulance</option>
                            <option value="104">102 Ambulance</option>
                        </select>
                    </div>
                </div> -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="style6 pb-0 mb-0">District :</label><br>
                        <select onchange="" name="amb_district" id="amb_district" class="form-group"  TABINDEX="7">
                            <option value="">All</option>
                            <?php foreach ($dist as $dst) { ?>
                                <option value="<?php echo $dst->dst_code; ?>" <?php if ($dst->dst_code == '518') {
                                                                                    echo "selected";
                                                                                } ?>><?php echo $dst->dst_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                <div class="button_field_row">
                    <div class="button_box" style="padding-top:10px;">
                        <input type="submit" name="submit" value="Submit" id="bse" class="btn btn-primary submit_btnt Submit">
                    </div>
                </div>
                </div>

                <div class="col-md-2" style="padding-top:20px;">
                    <form action="<?php echo base_url(); ?>erc_reports/base_location_report_download" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="" name="getdist" id="getdist">
                        <input type="hidden" value="" name="getsys" id="getsys">
                        <input type="Submit" name="" value="Download" class="" TABINDEX="3" class="">
                    </form>

                </div>
            </div>


    </div>


    <div class="row pb-5">
        <div class="col-md-12" id="list_table_amb">
            <!--offset-md-1 col-lg-10 offset-md-1 mt-4 pt-1-->
            <table class="list_table_amb" id="myTable" style="text-align: center;">
                <thead class="">
                    <tr class="table-active">
                        <th scope="col">Sr.No</th>
                        <th scope="col">Base Location Name</th>
                        <th scope="col">Mobile Number</th>
                        <th scope="col">Working Area</th>
                        <th scope="col">Base Location Type</th>
                        <th scope="col">System Type</th>
                        <th scope="col">GeoFence Area</th>
                        <th scope="col">Base Location Category</th>
                        <th scope="col">Address</th>
                        <th scope="col">State</th>
                        <th scope="col">District</th>
                        <th scope="col">Tehshil</th>
                        <th scope="col">City</th>
                        <th scope="col">Area/Locality</th>
                        <th scope="col">Landmark</th>
                        <th scope="col">Lane/Street</th>
                        <th scope="col">Pin Code</th>
                        <th scope="col">Latitude</th>
                        <th scope="col">Longitude</th>
                        <th scope="col">Contact Person Name</th>
                        <th scope="col">Contact Person Mobile Number</th>
                        <th scope="col">Email ID</th>
                        <th scope="col">DM Name</th>
                        <th scope="col">Added By</th>
                        <th scope="col">Added Date</th>
                    </tr>
                </thead>

                <!-- <tbody>
                           <?php foreach ($basedata as $base) { ?>
                            <tr>
                           <td><?php echo $base->hp_name ?> </td>
                           <td><?php echo $base->hp_mobile ?> </td>
                           <td><?php echo $base->ar_name ?> </td>
                           <td><?php echo $base->full_name ?> </td>
                           <td><?php echo $base->hp_system ?> </td>
                           <td><?php echo $base->geo_fence ?> </td>
                           <td><?php echo $base->hp_register_no ?> </td>
                           <td><?php echo $base->hp_address ?> </td>
                           <td><?php echo $base->st_name ?> </td>
                           <td><?php echo $base->dst_name ?> </td>
                           <td><?php echo $base->thl_name ?> </td>
                           <td><?php echo $base->cty_name ?> </td>
                           <td><?php echo $base->hp_area ?> </td>
                           <td><?php echo $base->hp_lmark ?> </td>
                           <td><?php echo $base->hp_lane_street ?> </td>
                           <td><?php echo $base->hp_pincode ?> </td>
                           <td><?php echo $base->hp_lat ?> </td>
                           <td><?php echo $base->hp_long ?> </td>
                           <td><?php echo $base->hp_contact_person ?> </td>
                           <td><?php echo $base->hp_contact_mobile ?> </td>
                           <td><?php echo $base->hp_email ?> </td>
                           <td><?php echo $base->hp_adm ?> </td>
                           <td><?php echo $base->base_added_by ?> </td>
                           <td><?php echo $base->base_added_date ?> </td>

                           </tr>     
                           <?php } ?>
                        </tbody> -->
            </table>
        </div>
    </div>
</div>
</section>
</div>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
    $('.Submit').on('click', function() {

        var amb_district = $('#amb_district').val();
        var system = $('#system').val();

        $amb_district1 = amb_district;
        $system1 = system;
        $('#getdist').val($amb_district1);
        $('#getsys').val($system1);
        // document.getElementById('getdist').innerHTML = $amb_district1;
        // document.getElementById('getsys').innerHTML = $system1;



        $.post('<?= site_url('erc_reports/base_loc') ?>', {
            amb_district,
            system
        }, function(data) {
            console.log(data);
            var new_var = JSON.parse(data);
            // console.log(new_var);
            $('.list_table_amb').html("");
            var raw = '<table class="table table-bordered list_table_amb" id="myTable" style="text-align: center;">' +
                '<tr class="table-active">' +
                '<th scope="col">Sr.No</th>' +
                '<th scope="col">Base Location Name</th>' +
                '<th scope="col">Mobile Number</th>' +
                '<th scope="col">Working Area</th>' +
                '<th scope="col">Base Location Type</th>' +
                '<th scope="col">System Type</th>' +
                '<th scope="col">Geofence Area</th>' +
                '<th scope="col">Base Location Category</th>' +
                '<th scope="col">Address</th>' +
                '<th scope="col">State</th>' +
                '<th scope="col">District</th>' +
                '<th scope="col">Tehsil</th>' +
                '<th scope="col">City</th>' +
                '<th scope="col">Area/Locality</th>' +
                '<th scope="col">Landmark</th>' +
                '<th scope="col">Lane/Street</th>' +
                '<th scope="col">Pin Code</th>' +
                '<th scope="col">Latitude</th>' +
                '<th scope="col">Longitude</th>' +
                '<th scope="col">Contact Person Name</th>' +
                '<th scope="col">Contact Person Mobile Number</th>' +
                '<th scope="col">Email ID</th>' +
                '<th scope="col">DM Name</th>' +
                '<th scope="col">Added By</th>' +
                '<th scope="col">Added Date</th>' +
                '</tr>' +
                '</table>';
            $('.list_table_amb').html(raw);
            var j = 1;
            for (var i = 0; i < new_var.length; i++) {

                var raw = "<tr>" +
                    "<td>" + j++ + "</td>" +
                    "<td>" + new_var[i].hp_name + "</td>" +
                    "<td>" + new_var[i].hp_mobile + "</td>" +
                    "<td>" + new_var[i].ar_name + "</td>" +
                    "<td>" + new_var[i].full_name + "</td>" +
                    "<td>" + new_var[i].hp_system + "</td>" +
                    "<td>" + new_var[i].geo_fence + "</td>" +
                    "<td>" + new_var[i].hp_register_no + "</td>" +
                    "<td>" + new_var[i].hp_address + "</td>" +
                    "<td>" + new_var[i].st_name + "</td>" +
                    "<td>" + new_var[i].dst_name + "</td>" +
                    "<td>" + new_var[i].thl_name + "</td>" +
                    "<td>" + new_var[i].cty_name + "</td>" +
                    "<td>" + new_var[i].hp_area + "</td>" +
                    "<td>" + new_var[i].hp_lmark + "</td>" +
                    "<td>" + new_var[i].hp_lane_street + "</td>" +
                    "<td>" + new_var[i].hp_pincode + "</td>" +
                    "<td>" + new_var[i].hp_lat + "</td>" +
                    "<td>" + new_var[i].hp_long + "</td>" +
                    "<td>" + new_var[i].hp_contact_person + "</td>" +
                    "<td>" + new_var[i].hp_contact_mobile + "</td>" +
                    "<td>" + new_var[i].hp_email + "</td>" +
                    "<td>" + new_var[i].hp_adm + "</td>" +
                    "<td>" + new_var[i].base_added_by + "</td>" +
                    "<td>" + new_var[i].base_added_date + "</td>" +
                    "</tr>";
                $('#list_table_amb tr:last').after(raw);
            }

        });
    });
</script>