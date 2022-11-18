  

        <form method="post" name="amb_form" >  
           <div id="amb_dash">
               <div id="amb_filters">
                  <div class="width2 float_left">                   

                       <div class="search">

                           <div class="row">

                               <div class="width100 float_left">
                                   
                                     <div class="width_25 float_left">
                                    <h3 class="txt_clr2">Ambulance Details</h3>
                                </div>

                                   <div class="width4 float_left">
                                       <input type="text"  class="controls amb_search" id="mob_no" name="amb_search" value="<?php echo @$rg_no; ?>" placeholder="Search"/>
                                   </div>

                                   <div class="width_14 float_left">

                                       <input type="button" class="search_button float_right form-xhttp-request" name="" value="Search" data-href="{base_url}calls/ero_dash" data-qr="output_position=content&amp;flt=true&amp;type=amb" />
                                   </div>

                               </div>
                           </div>
                       </div>

                   </div>
               </div>
            <div id="list_table">
                <table class="table report_table">



                    <tr>                

<!--                   <th><input type="checkbox" title="Select All Users" name="selectall" class="base-select" data-type="default"></th>                        -->

                        <th nowrap>Sr No</th>

                        <th nowrap>Ambulance Number</th>

<!--                    <th nowrap>Mobile Number</th>-->

                        <th nowrap>Last Assign Time</th> 
                        
                        <th nowrap>Base Location</th>     
                        <th nowrap>District</th>  

                        <th>Type</th>

                        <th>Status</th> 

<!--                    <th>Action</th> -->

                        

                    </tr>



                    <?php 
                   
                    if(count($result)>0){  



                    $total = 0;

                    foreach($result as $key=>$value){ 
                       
                       if($page_no>1){
                         $key += 20*($page_no-1);
                       }
                      
                       ?>

                    <tr>
<!--
                        <td><input type="checkbox" data-base="selectall" class="base-select" name="amb_id[<?= $value->amb_id; ?>]" value="<?=base64_encode($value->amb_id);?>" title="Select All Ambulance"/></td>-->

                        

                        <td><?php echo ($key+1);?></td>

                        <td><?php echo $value->amb_rto_register_no;?></td>                     

<!--                        <td><a class="click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0<?php echo $value->amb_default_mobile;?>"><?php echo $value->amb_default_mobile;?></a></td>-->
                        <td><?php if($value->timestamp){ echo date("d-m-Y h:m:i",strtotime($value->timestamp));}else{echo "-";}?></td>
                        <td><?php echo ucwords($value->hp_name);?></td>                        



                       <?php $ar_name = $cty_name = $ambt_name = $ambs_name ='';

                            if(count($get_data) > 0){                        

                                foreach($get_data as $type){ 

                                    if($value->amb_id == $type->amb_id ){

                                        $ar_name = $type->ar_name;

                                        $cty_name =  $type->cty_name;

                                        $ambt_name = $type->ambt_name;

                                        $ambs_name = $type->ambs_name;

                                    }

                                }

                            }    

                        ?>   

                        

                        <td><?php echo $value->dst_name;?> </td> 

                        <td><?php echo $ambt_name;?></td> 

                        <td><?php echo $ambs_name;?> </td>       

<!--                        <td> 

                                  <li><a href="{base_url}amb/change_status" class="btn click-xhttp-request" data-qr="output_position=popup_div&amb_id=<?php echo $inc->inc_ref_id;?>">Change</a> </li>

                                    <a class="action_button onpage_popup btn" data-href="{base_url}calls/change_status" data-qr="amb_id=<?php echo base64_encode($value->amb_id);?>&amp;status=<?php echo $ambs_name;?>&amp;output_position=popup_div" data-popupwidth="600" data-popupheight="600">Change status</a>
                            <a class="action_button btn" data-href="{base_url}calls/change_status" data-qr="amb_id=<?php echo base64_encode($value->amb_id);?>&amp;status=<?php echo $ambs_name;?>" data-popupwidth="600" data-popupheight="600">Change status</a>
                             <input type="button" name="submit" value="Change status" class="btn submit_btnt form-xhttp-request" data-href='{base_url}calls/change_status' data-qr="amb_id=<?php echo base64_encode($value->amb_id);?>&amp;status=<?php echo $ambs_name;?>" TABINDEX="<?php echo $key+1;?>">

                        </td>-->

                    </tr>

                     <?php } }else{   ?>



                    <tr><td colspan="10" class="no_record_text">No history Found</td></tr>

                    

                 <?php } ?>   



                </table>
                <div class="bottom_outer">
            
                    <div class="pagination"><?php echo $amb_pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php if(@$data){ echo $data; }?>">
 
                    <div class="width33 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec_amb" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}calls/ero_dash" data-qr="output_position=content&amp;flt=true&amp;type=amb">

                                    <?php echo rec_perpg($pg_rec); ?>

                                </select>

                            </div>

                                <div class="float_right">
                                    <span> Total records: <?php if(@$total_count){ echo $total_count; }else{ echo"0";}?> </span>
                                </div>
                        </div>

                    </div>
                    
                </div>
                </div>
               
             </div>

        </form>
