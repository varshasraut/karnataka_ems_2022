<?php $CI = EMS_Controller::get_instance();?>
  
<div class="breadcrumb float_left">
        <ul>
            <li class="sms">
                <a class="click-xhttp-request" data-href="{base_url}schedule/schedule_listing">Schedule</a>
            </li>
            <li>
                Screening Schedule Listing
            </li>

        </ul>
</div>
<br><br>

<div class="box3">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="amb_form" id="amb_list">  
            
        <div id="schedule_filters"></div>
            
            <div id="list_table">
            
            
                <table class="table report_table">
                    <tr>                
                        <th nowrap>Sr No</th>
                        <th nowrap>Date</th>
                        <th nowrap>Time</th>
                        <th nowrap>Student name</th>
                        <th nowrap>Std</th>
                        <th nowrap>Sex</th>
                        <th nowrap>Age</th>
                        <th nowrap>Doctor name</th>
                        <th nowrap>Doctor Id</th>
                    </tr>

                    <?php  if(count($result)>0){  

                    $total = 0;
                    foreach($result as $value){  
						$asScheduleDatetime = explode(' ',$value->schedule_date);
						$asDate = explode('-',$asScheduleDatetime[0]);
                       ?>
                    <tr>
                        <td><?php echo $value->schedule_id;?></td>
                        <td><?php echo date('d-M-Y',mktime(0,0,0,$asDate[1],$asDate[2],$asDate[0]));?></td>
                        <td><?php echo $asScheduleDatetime[1];?></td>
                        <td><?php echo $value->stud_first_name.' '.$value->stud_middle_name.' '.$value->stud_last_name;?></td>
                        <td><?php echo $value->student_std;?></td>
                        <td><?php echo $value->stud_gender;?></td>
                        <td><?php echo $value->stud_age;?></td>
                        <td></td>
                        <td></td>
                    </tr>
                     <?php } }else{   ?>

                    <tr><td colspan="9" class="no_record_text">No history Found</td></tr>
                    
                 <?php } ?>   

                </table>
                
                <div class="bottom_outer">
            
                    <div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php if(@$data){ echo $data; }?>">
 
                    <div class="width38 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}schedule/schedule_listing" data-qr="output_position=content&amp;flt=true">

                                    <?php echo rec_perpg($pg_rec); ?>

                                </select>

                            </div>

                                <div class="float_right">
                                    <span> Total records: <?php echo (@$total_count) ?  $total_count : "0";?> </span>
                                </div>
                        </div>

                    </div>
                    
                </div>
      
            </div>
        </form>
    </div>
</div>