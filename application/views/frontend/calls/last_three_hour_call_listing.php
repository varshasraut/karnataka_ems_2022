    <h3 class="txt_clr2 width1">Previous Call Details</h3>
     
        <form method="post" name="inc_list_form" id="inc_list">  
           <div class="width100" id="ero_dash">

         

                  <table class="table report_table">



                       <tr>                                     

                            <th nowrap>Date</th>
                           <th nowrap>Incident ID</th>

                           <th nowrap>Caller Name</th>
                            <th nowrap>District</th>


                           <th nowrap>Caller Mobile No</th>
                           <th nowrap>EMT NAME</th>
                           <th nowrap>EMT Mobile</th>
                           <th>ERO Name</th>
                            <th>Audio File</th>
                           <th nowrap>Ambulance</th>
                           <th nowrap>Call Time</th>
<!--                           <th nowrap>Incident status</th>
                        <th nowrap>Closure Status</th>-->
                          
                       </tr>



                       <?php  if(count(@$inc_info)>0){  



                       $total = 0;
                       foreach($inc_info as $key=>$inc){
                          
                          // var_dump($inc);
                           if($inc['clr_fullname'] != ''){
                               $caller_name = $inc['clr_fullname'];
                           }else{
                               $caller_name = $inc['clr_fname']." ".$inc['clr_mname']." ".$inc['clr_lname'];
                           }
                          
                          ?>

                       <tr>




                            <td ><?php echo date("d-m-Y",strtotime($inc['inc_datetime']));?></td>

                           <td ><?php echo $inc['inc_ref_id'];?></td>

                          <td ><?php echo ucwords($caller_name);?></td>
                           
                          <td ><?php echo $inc['dst_name'];?></td>
<!--                           <td ><?php echo ucwords($patient_name);?></td>-['
<!--                           <td  style="background: #FFD4A2;;"><?php echo $inc['inc_bvg_ref_number'];?></td>-->
                           <td ><?php echo $inc['clr_mobile'];?></td>

<!--                           <td ><?php echo $inc['inc_address'];?></td>-->

                           
                           <td ><?php echo $inc['amb_emt_id'];?><?php //echo ucwords($inc['emt_first_name']." ".$inc['emt_last_name']);?></td>
                           <td  nowrap><?php echo $inc['amb_default_mobile'];?></td>
<!--                            <td ><?php echo $inc['amb_pilot_id'];?><?php //echo ucwords($inc['clg_first_name']." ".$inc['clg_last_name']);?></td>
                        <td ><?php echo $inc['amb_pilot_mobile'];?><?php //echo ucwords($inc['clg_first_name." ".$inc['clg_last_name);?></td>-->

                          
                            <td  nowrap><?php echo ucwords(strtolower($inc['clg_first_name']." ".$inc['clg_last_name'])); ?></td>
                            <td>
                                    <?php  
                                        $inc_datetime = date("Y-m-d", strtotime($inc['inc_datetime']));
                                        $pic_path =  "{base_url}uploads/audio_files/".$inc['inc_audio_file'] ;
                                        $pic_path =   get_inc_recording($inc['inc_avaya_uniqueid'],$inc_datetime);
                                    if($pic_path != ''){
                                        ?>
                                
                                    <audio controls controlsList="nodownload" style="width: 185px;">
                                      <source src="<?php echo $pic_path;?>" type="audio/wav">
                                    Your browser does not support the audio element.
                                    </audio> 
                                
                                <?php  } ?>
                                  
                           </td>
                           <td  nowrap><?php echo $inc['amb_rto_register_no'];?></td>


                           <td ><?php echo date("H:i:m",strtotime($inc['inc_datetime']));?></td>
                       
   <?php 
                                      if($inc['incis_deleted'] == 0){
                                          $disptched = "Dispatched";
                                      }if($inc['incis_deleted'] == 2){
                                          $disptched = "Terminated";
                                      }if($inc['incis_deleted'] == 1){
                                          $disptched = "Deleted";
                                      }
                                      if($inc['inc_pcr_status'] == '0' || $inc['inc_pcr_status'] == 0){
                                          $closer = "Closer Pending";
                                      }else{
                                          $closer = "Closer Done";
                                      }
                                      ?>
<!--                                 <td><?php echo $disptched; ?></td>
                                 <td><?php echo $closer; ?></td>-->

                          </tr>

                        <?php } ?>

                   <?php }else{   ?>

                       <tr><td colspan="13" class="no_record_text">No Record Found</td></tr>

                    <?php } ?>   

                   </table>
              


               
           </div>
        </form>