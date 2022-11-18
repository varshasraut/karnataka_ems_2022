 
<?php
$fwd_note = array(
    'COMP_CALL' => ' forward to supervisor',
    'FEED_CALL' => ' to submit feedback',
    'FOLL_CALL' => ' to save'
);
?>

<table class="style2 float_left">

    <tr>
        <th>Sr.No</th>
        <th>Incident Id</th>
        <th>Incident Location</th>
        <th>Patient Name</th>
        <th>Date</th>
        <th>Time</th>
        <th>Action</th>
    </tr>


    <?php
    if (!empty($pt_details)) {

        $srno = 1;

        foreach ($pt_details as $pet) {
            ?>
            <tr>
                <td><?php echo $srno; ?></td>
                <td><?php echo $pet->inc_ref_id; ?></td>
                <td><?php echo $pet->inc_address; ?></td>
                <td><?php echo ($pet->ptn_fname)?$pet->ptn_fname . " " . $pet->ptn_lname:"-"; ?></td>

                <?php $dtm = explode(" ", $pet->inc_datetime); ?>

                <td><?php echo date('d-m-Y',strtotime($dtm[0])); ?></td>
                <td><?php echo date("g:i A", strtotime($dtm[1])); ?></td>
                <td id="incact">

                    <input name="select" class="click-xhttp-request inc_act<?php echo $pet->inc_ref_id; ?> incact" data-href="{base_url}grievance/gr_inc_info" data-qr="inc_ref_id=<?php echo $pet->inc_ref_id; ?>&amp;cl_purpose=<?php echo $cl_purpose; ?>&amp;freq=true" value="SELECT" type="button">

                </td>
            </tr>

            <?php
            $srno++;
        }
    } else {
        ?>

        <tr><td colspan="7" class="text_align_center">No records found.</td></tr>

    <?php } ?>
</tr>


</table>

<div id="inc_pt_info">
</div>


<div id="inc_fwd_note" class="tabl_btm_note width100 float_left">

    <span class="float_right">
        <?php if ($pt_details) { ?> 
        
            ( Note: Please select at least one incidence <?php echo $fwd_note[$cl_purpose]; ?>. ) 
            
        <?php } ?>
    </span>

</div>