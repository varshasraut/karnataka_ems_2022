<?php
?>
<div class="register_outer_block">

    <div class="box3">

        <form enctype="multipart/form-data" method="post" action="" id="manage_team">
            <h1>Manage Team</h1>

            <input type="hidden" name="rto_no" id="amb_id" value="<?php echo $get_amb_details[0]->amb_rto_register_no; ?>">

            <div class="field_row width100">
                <div class="width2 float_left">
                    <div class="shift width_30 float_left "><label for="sft2">Register Number</label></div>

                    <div class="shift width70 float_left">
                        <input name="amb_rto_register_no" class="filter_required" value="<?php echo $get_amb_details[0]->amb_rto_register_no; ?>" type="text" tabindex="1" placeholder="Register Number" data-errors="{filter_required:'Register Number should not blank'}" disabled="">
                    </div>
                </div>

                <div class="width2 float_left">
                    <div class="shift width20 float_left"><label for="sft2">Import file</label></div>

                    <div class="shift width_78 float_left">
                        <input name="file" class="filter_required" value="" type="file" tabindex="1" placeholder="Import file" data-errors="{filter_required:'Import file should not blank'}">
                    </div>
                </div>

            </div>
            <div class="field_row width100">
                <h3>CSV file format</h3>
                <table class="table report_table">

                    <tr>
                        <th nowrap>Ambulance no</th>
                        <th nowrap>Shift</th>
                        <th nowrap>Date</th>
                        <th>Pilot ref id</th>
                        <th>EMT ref Id</th>
                        <th>Deleted</th>
                        <th>Absent</th>
                    </tr>
                    <tr>
                        <td>MH 14 CL 0767</td>
                        <td>1</td>
                        <td>2019-06-24</td>
                        <td>PILOT-1</td>
                        <td>EMT-1</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>

                </table>
                <span><b>Shift:-
                        Morning=>1, Afternoon=>2, Night=>3, Off=>4</b> </span>
            </div>

            <div class="field_row width100">
                <div class="width40 margin_auto">
                    <div class="button_field_row">
                        <div class="button_box text_center">
                            <input type="hidden" name="submit_amb_team" value="sub_amb_team" />
                            <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>shift_roster/save_imported_excel_team' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content'>
                            <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset">
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>