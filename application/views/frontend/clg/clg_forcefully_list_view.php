<?php
$CI = EMS_Controller::get_instance();

$clg_status = array('0' => 'Inactive', '1' => 'Active', '2' => 'Deleted');
$sts = array('0' => 'Active', '1' => 'Inactive');
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>
        <li class="colleague"><a href="#">Employee</a></li>
        <li><span>Login Employee List</span></li>
    </ul>
</div>



<br>

<div class="box3">    

    <div class="permission_list group_list">

        <form method="post" action="#" name="colleagues_list_form" class="colleagues_list_form">  

            <div id="clg_filters"> </div>

            <div id="list_table">


                <table class="table report_table">

                    <tr>                
                                             
                        <th nowrap>User Id</th>
                        <th nowrap>Name</th>
<!--                        <th nowrap>SAP ID</th>-->
                        <th nowrap>Mobile Number</th>
                          <th nowrap>Email Id</th>
<!--                        <th nowrap>Avaya Id</th>-->
                        <th>Group</th>
                        <th>Status</th> 
                        <th>Action</th> 

                    </tr>

                    <?php
                    if (count($colleagues) > 0) {

                        foreach ($colleagues as $colleague) {
                            ?>
                            <tr>
                              

                                <td><?php echo strtoupper($colleague->clg_ref_id); ?></td>
                                <td><?php echo ucwords($colleague->clg_first_name . " " . $colleague->clg_last_name); ?></td>
<!--                                <td><?php echo $colleague->clg_jaesemp_id; ?></td>        -->
                                <td><?php echo $colleague->clg_mobile_no; ?></td>        
                                  <td><?php echo $colleague->clg_email; ?> </td>     
<!--                                <td><?php echo $colleague->clg_avaya_id; ?> </td>     -->
                                <td><?php echo $colleague->clg_group; ?> </td>      
                                <td><?php echo $clg_status[$colleague->clg_is_active]; ?>


                                </td>       

                                <td> 

                            

                                     

                                        <a class="click-xhttp-request btn" data-href="{base_url}clg/force_logout" data-qr="output_position=popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-VIEW&amp;ref_id=<?php echo base64_encode($colleague->clg_ref_id); ?>&amp;action=edit_data&amp;clg_view=view&amp;clg_group=<?php echo $colleague->clg_group; ?>&amp;clg_senior=<?php echo $colleague->clg_senior; ?>&amp;action_type=View">Forcefully Logout</a>
                                  
                                </td>
                            </tr>
    <?php }
} else { ?>

                        <tr><td colspan="9" class="no_record_text">No history Found</td></tr>

<?php } ?>   

                </table>

                <div class="bottom_outer">

                    <div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php if (@$data) {
    echo $data;
} ?>">

                    <div class="width38 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}clg/forcefully_logout" data-qr="output_position=content&amp;flt=true">

<?php echo rec_perpg($pg_rec); ?>

                                </select>

                            </div>

                            <div class="float_right">
                                <span> Total records: <?php if (@$total_count) {
    echo $total_count;
} else {
    echo"0";
} ?> </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </form>
    </div>
</div>