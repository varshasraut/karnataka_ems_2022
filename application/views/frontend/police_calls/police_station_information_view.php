<script>

    // initAutocomplete();

</script>


<div id="dublicate_id"></div>

<?php
//if (@$view_clg == 'view') {
$disable = 'disabled';
//}
?>

<form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form">
    <div class="width100">
        <h2 class="txt_clr2 width1 txt_pro"><?php
            if ($action_type) {
                echo $action_type;
            }
            ?></h2>


        <div class="joining_details_box">

            <div class="single_record float_left width100"> 
                <div class="single_record_back">
                    <div>Police Station Information</div>
                </div>
            </div>
            <div class="field_row width100">
                <div class="width33 float_left">
                    <div class="filed_lable float_left width33 "><label for="station_name">Station Name</div>

                    <div class="filed_input float_left width50">
                        <input  type="text" name="police_station_name" class="" value=" <?= @$police_station[0]->police_station_name ?>"<?php echo $disable; ?>  >


                    </div>
                </div>    
                <!-- <div class="width33 float_left">
                    <div class="filed_lable float_left width33 "><label for="station_name">Contact Person</div>

                    <div class="filed_input float_left width50">
                        <input  type="text" name="police_station_name" class="" value=" <?= @$police_station[0]->police_station_name ?>"<?php echo $disable; ?>  >


                    </div>
                </div>   -->
                <div class="width33 float_left">
                    <div class="field_lable float_left width33 "> <label for="mobile_no">Mobile No</label></div>


                    <div class="filed_input float_left width50">

                        <input  type="text" name="police_station_name" class="float_left width90" value="<?= @$police_station[0]->p_station_mobile_no; ?>"<?php echo $disable; ?>  >
                        <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo @$police_station[0]->p_station_mobile_no; ?>"></a>
                    </div>
                </div>
                <div class="width33 float_left">
                    <div class="field_lable float_left width33 "> <label for="district">Google Address </label></div>
                    <div class="filed_input float_left width50">

                        <?php
                        if (@$police_station[0]->p_google_address) {
                            $fuel_address = @$police_station[0]->p_google_address;
                        }
                        ?>
                        <input  type="text" name="police_station_name" class="" value=" <?= $fuel_address ?>"<?php echo $disable; ?>  >
                    </div>
                </div>  
            </div>
            <div class="width100">

                <div class="width33 float_left">
                    <div class="field_lable float_left width33 "> <label for="mobile_no">Address</label></div>


                    <div class="filed_input float_left width50">

                        <input  type="text" name="police_station_name" class="" value="   <?= @$police_station[0]->p_google_address; ?>"<?php echo $disable; ?>  >

                    </div>
                </div>
<!--                <div class="width33 float_left">
                    <div class="field_lable float_left width33"><label for="tahsil">Tehsil</label></div>
                    <div class="filed_input float_left width50"> <div id="incient_tahsil">
                            <?php
                            if ($police_station[0]->p_tahsil != '' && $police_station[0]->p_tahsil != 0) {

                                $st = array('thl_id' => $police_station[0]->p_tahsil,'dst_code' => $police_station[0]->p_district_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');

                            } else {
                                $st = array('st_code' => '','dst_code' => $police_station[0]->p_district_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                            }
                            echo get_tahshil($st); ?>
                        </div>
                    </div>
                </div>-->
                <div class="width100 float_left">
                    <div class="map_box1">

                        <div id="googleMap1" class="load_googleMap" style="width: 100%; height: 0px; background: #5A8E4A; "></div>



                        <script>
                            var i = 0;
                           // var drag;
                            if (i == 0) {

                                setTimeout(function () {
                                    var map_obj = document.getElementById('googleMap');

            <?php
            if ($police_station[0]->p_lat && $police_station[0]->p_long) {

                $lat = $police_station[0]->p_lat;
                $lng = $police_station[0]->p_long;
            }

            ?>

                                    var ltlng = {lat:<?= $lat ?>, lng:<?= $lng ?>};

                                    initMap(ltlng, map_obj);


                                }, 1000);

                                i++;
                            }
                        </script>



                    </div>
                </div>
  </div>    

 </form>

