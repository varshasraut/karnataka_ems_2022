<?php $CI = EMS_Controller::get_instance();?>
  
<div class="breadcrumb float_left">
        <ul>
            <li class="sms">
                <a class="click-xhttp-request" data-href="{base_url}medication/medication_list">Medication</a>
            </li>
            <li>
                <span>Medication Listing</span>
            </li>

        </ul>
</div>

<div class="width2 float_right ">

   
    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}medication/medication_list" data-qr="output_position=content&amp;filters=reset" type="button">
   
</div>

<br>

<div class="box3">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="prescription_form" id="prescription_list">  
            
        <div id="prescription_filters"></div>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                    <tr>                
                                
                        <th nowrap>Sr No</th>
                        <th nowrap>Student Name</th>
                        <th nowrap>School Name</th>      
                        <th>Medication Status</th> 
                        <th>Action</th> 
                        
                    </tr>

                    <?php  if(count($result)>0){  

                    $total = 0;
                    foreach($result as $key=>$value){  
                        $key = $key+1;
                       ?>
                    <tr>
                      
                        
                        <td><?php echo $key+$offset;?></td>
                     
                        <td><?php echo $value->stud_first_name;?> <?php echo $value->stud_middle_name;?> <?php echo $value->stud_last_name;?></td>
                        
                        <td><?php echo $value->school_name;?></td>
                                             
                        <td><?php if($value->is_approve == '1'){ echo "Approved";}else{ echo "Not Approve"; }?></td>    
                        <td> 
                           <a class="click-xhttp-request action_button btn" data-href="{base_url}medication/view_prescription" data-qr="output_position=popup_div&amp;pre_id=<?php echo base64_encode($value->id);?>&amp;amb_action=view" data-popupwidth="1000" data-popupheight="800">View</a>
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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}medication/medication_list" data-qr="output_position=content&amp;flt=true">

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