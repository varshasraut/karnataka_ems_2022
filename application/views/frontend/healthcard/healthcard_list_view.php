<?php $CI = EMS_Controller::get_instance();?>
  
<div class="breadcrumb float_left">
    <ul>
        <li>
            <h2>Healthcard Listing</h2>
        </li>
   </ul>
</div>

<br><br>
<div class="width2 float_right ">

   
    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}healthcard/healthcard_list" data-qr="output_position=content&amp;filters=reset" type="button">
   
</div>
<div class="box3">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="amb_form" id="student_list">  
            
             <div id="healthcard_filters"></div>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                    <tr>                                       
                        <th nowrap>Sr No</th>
                        <th nowrap>Registration No</th>
                        <th nowrap>Student Name</th>
                        <th nowrap>School Name</th>
                        <th>Action</th> 
                        
                    </tr>

                    <?php  if(count($student_data)>0){  

                    $total = $inc_offset;
                   // $inc_offset = $inc_offset
                    foreach($student_data as $key=>$value){  
                       ?>
                            <tr>
                        
                        <td><?php echo $total+$key+1;?></td>
                     
                        <td><?php echo $value->stud_reg_no;?></td>
                        
                        <td><?php echo $value->stud_first_name;?> <?php echo $value->stud_last_name;?></td>
                        <td><?php echo $value->school_name;?></td>
                             
                        <td> 
 <a class="click-xhttp-request action_button btn" data-href="{base_url}healthcard/view_health_card" data-qr="output_position=content&amp;stud_id=<?php echo base64_encode($value->stud_id);?>" data-popupwidth="1000" data-popupheight="800">View</a>
                        </td>
                        
                    </tr>

                    <?php } }else{   ?>
                              
                    <tr><td colspan="9" class="no_record_text">No Student Found</td></tr>
                    
                 <?php } ?>   

                </table>
                
                <div class="bottom_outer">
            
                    <div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php if(@$data){ echo $data; }?>">
 
                    <div class="width38 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}healthcard/healthcard_list" data-qr="output_position=content&amp;flt=true">

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