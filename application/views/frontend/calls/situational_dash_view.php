<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<?php
//if($_SERVER['HTTP_HOST'] != 'www.mhems.in'){
?>
<script>
    start_incoming_call_event();
</script>
<?php  //} 
?>

<?php $CI = EMS_Controller::get_instance();

$quality_marks = array();
$quality_marks['quality_score'] = 0;
$quality_marks['fetal_indicator'] = 0;
$quality_count = 0;

//if($_SERVER['remote_addr']=='43.224.172.126'){
//    var_dump($audit_details);
//}

if (!empty($audit_details)) {
    $quality_count = count($audit_details);


    foreach ($audit_details as $quality) {

        $quality_marks['quality_score'] = (int)$quality->quality_score + (int)$quality_marks['quality_score'];

        $fetal_indicator = json_decode($quality->fetal_indicator);
        if ($quality->quality_score == '0' || $quality->quality_score == 0) {
            $quality_marks['fetal_indicator'] =  $quality_marks['fetal_indicator']  + 1;
        }

        //$quality_marks['fetal_indicator'] = $quality->quality_score + $quality_marks['quality_score'];
    }
}

?>
<div id="calls_inc_list">

    <form method="post" name="inc_list_form" id="inc_list">
  

        <div id="list_table">

            <table class="table report_table">
                <tr>

                    <th>Date & Time</th>
                    <th>Previous Incident ID</th>
                    <th>Incident ID</th>
                    <th>Summary </th>
                </tr>
                <?php
                if ($inc_info) {



                    $total = 0;

                    foreach ($inc_info as $key => $inc) {

                ?>

                        <tr>
                            <td><?php echo date("d-m-Y H:i:s", strtotime($inc->added_date)); ?></td>
                            <td><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->pre_inc_ref_id; ?>" style="color:#000;" data-popupwidth="1900" data-popupheight="1700"><?php echo $inc->pre_inc_ref_id; ?></a></td>
                            <td><?php echo $inc->inc_ref_id; ?></td>
                            <td><?php echo $inc->summary
; ?></td>
                        </tr>

                    <?php } ?>

                <?php }

                //  } 
                else { ?>


                    <?php if ($clg_senior) { ?>
                        <tr>
                            <td colspan="16" class="no_record_text">No Record Found</td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td colspan="16" class="no_record_text">No Record Found</td>
                        </tr>
                    <?php } ?>



                <?php } ?>





            </table>



            <div class="bottom_outer">

                <div class="pagination"><?php echo $pagination; ?></div>

                <input type="hidden" name="submit_data" value="<?php
                                                                if (@$data) {
                                                                    echo $data;
                                                                }
                                                                ?>">

                <div class="width33 float_right">

                    <div class="record_per_pg">

                        <div class="per_page_box_wrapper">

                            <span class="dropdown_pg_txt float_left"> Records per page : </span>

                            <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}calls/ero_dash" data-qr="output_position=content&amp;flt=true&amp;type=inc">

                                <?php echo rec_perpg($pg_rec); ?>

                            </select>

                        </div>

                        <div class="float_right">
                            <span> Total records: <?php
                                                    if (@$inc_total_count) {
                                                        echo $inc_total_count;
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?> </span>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </form>
</div>
<div class="hide">
    <?php echo $clg_senior; ?>
</div>
<?php if ($clg_senior) { ?>
    <script>
        jQuery(document).ready(function() {

            var dateFormat = "mm/dd/yy",
                from = jQuery("#from_date")
                .datepicker({
                    defaultDate: -1,
                    changeMonth: true,
                    numberOfMonths: 1,
                    maxDate: new Date()
                })
                .on("change", function() {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
                    defaultDate: new Date(),
                    changeMonth: true,
                    numberOfMonths: 1,
                    maxDate: new Date()
                })
                .on("change", function() {
                    from.datepicker("option", "maxDate", getDate(this));
                });

            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }
                return date;
            }
        });
    </script>
<?php } else { ?>

    <script>
        jQuery(document).ready(function() {

            var dateFormat = "mm/dd/yy",
                from = jQuery("#from_date")
                .datepicker({
                    defaultDate: -1,
                    changeMonth: true,
                    numberOfMonths: 1,
                    maxDate: new Date(),
                    minDate: '-1d',
                })
                .on("change", function() {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
                    defaultDate: new Date(),
                    changeMonth: true,
                    numberOfMonths: 1,
                    maxDate: new Date(),
                    minDate: '-1d',
                })
                .on("change", function() {
                    from.datepicker("option", "maxDate", getDate(this));
                });

            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }
                return date;
            }
        });
    </script>
<?php } ?>


<style>
    #eroper {
        font-weight: bold !important;
        text-align: left !important;
    }
    #eroperh{
        text-align: center !important;
        font-size: 17px !important;
    }
    .table-bordered td{
        text-align: center !important;
        padding:8px !important;
    }
    #eroper2{
        font-weight: bold !important;
        text-align: left !important;
        padding:14px !important;
    }
    #eroper3{
        padding:16px !important;
    }

</style>