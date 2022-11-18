<h2>Annexure B-II A Call Details Emergency</h2>								

<form action="<?php echo base_url(); ?>file_nhm/<?php echo $submit_function;?>" method="post" enctype="multipart/form-data" target="form_frame">
    <input type="hidden" name="from_date" value="<?php echo $from_date;?>">
    <input type="hidden" name="to_date" value="<?php echo $to_date;?>">
    <input type="hidden" name="report_type" value="<?php echo $report_type;?>">
     <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
</form>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
<table class="table report_table" style="border-collapse: collapse;"> 
    <tr>
    <th>Sr.NO</th>
    <th>Incident Id</th>
    <th>Caller No</th>
    <th>Call picked within 5 Rings</th>
    <th>Call Picked After 5 Rings</td>
    <th>Unanswered Call(Call was not picked at all)</th>
    <th>Whether any Ambulance was Assigned</th>
    <th>Whether any Patient was Attended</th>
    <th>Whether the call was about medico Legal Case</th>
    <th>Whether the call was about Fire Incident</th>
    </tr>
<?php 

if($report_info){
      $cur_page_sr = ($page_no - 1) * 5000;
   foreach($report_info as $key=>$info){
    
       ?>
       <tr>
            <td><?php echo $cur_page_sr + $key + 1; ?></td>
            <td><?php echo $info['inc_id']; ?> </td>
            <td><?php echo $info['Caller_no']; ?> </td>
            <td><?php echo $info['within_five_rings']; ?> </td>
            <td><?php echo $info['After_five_rings']; ?> </td>
            <td><?php echo $info['unanswered_call']; ?> </td>
            <td><?php echo $info['amb_dispatched']; ?> </td>
            <td><?php echo $info['patient_attended']; ?> </td>
            <td><?php echo $info['medico_legal']; ?> </td>
            <td><?php echo $info['fire_inc']; ?> </td>
       </tr>
       
<?php
   }
    
}
?>
</table>
<div class="bottom_outer">

                    <div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php
                    if (@$data) {
                        echo $data;
                    }
                    ?>">

                    <div class="width38 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}file_nhm/result_load_file_report_form" data-qr="output_position=content&amp;flt=true&amp;report_type=<?php echo $report_type;?>&from_date=<?php echo $from_date;?>&to_date=<?php echo $to_date;?>">

                                    <?php echo rec_perpg($pg_rec); ?>

                                </select>

                            </div>

                            <div class="float_right">
                                <span> Total records: <?php
                                    if (@$total_count) {
                                        echo $total_count;
                                    } else {
                                        echo"0";
                                    }
                                    ?> </span>
                            </div>

                        </div>

                    </div>

                </div>
<script>
    
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>