<?php $CI = EMS_Controller::get_instance();?>
  
<div class="breadcrumb float_left">
    <ul>
        <li>
            <h2>Screening Dashbord</h2>
        </li>
   </ul>
</div>

<br><br>

<div class="box3">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="amb_form" id="amb_list">  
            
        <div id="amb_filters"></div>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                    <tr>                                  
                        <th nowrap>Sr No</th>
                        <th nowrap>Date</th>
                        <th nowrap>Time</th>
                        <th nowrap>School Name</th>
                        <th>Action</th> 
                        
                    </tr>

                    <?php  if(count($result)>0){  

                    $total = 0;
                    foreach($result as $key=> $value){  
                       ?>
                            <tr>
                        
                        <td><?php echo $key+1;?></td>
                     
                        <td><?php echo date("d-M-Y",strtotime($value->schedule_date));?></td>
                        <td><?php echo date("g:s A",strtotime($value->schedule_time));?></td>
                        
                        <td><?php echo $value->school_name;?></td>
                             
                        <td> 
                            <a href="{base_url}emt/student_search?schedule_id=<?php echo base64_encode( $value->schedule_id);?>" class="btn click-xhttp-request" data-qr="output_position=content" >Start</a>
                        </td>
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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}school/school_listing" data-qr="output_position=content&amp;flt=true">

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