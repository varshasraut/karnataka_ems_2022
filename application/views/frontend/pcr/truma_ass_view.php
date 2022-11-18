<script>cur_pcr_step(5);</script>

<div class="panel-body" style="" id="disable_div_truma_assessment">
        <div class="head_outer">
            <h2>TRAUMA Assessment </h2>
    </div>
        <form method="post" name="" id="truma_info">
    <div class="width100" id="Front_detail_block">
        <div class="width30 float_left">
            <label class="label" >Select Front:</label>
            <div class="col-sm-2">
               
                <select name="front" class="form-control" data-base="front_injury" id="front_id" tabindex="1" onchange="load_front_injury(this);">
                        <option value="" >Please Front</option>  

                        <?php echo get_front('1');?>
                </select>
            </div>
        </div>
            <?php if($front_injury_info){ $hide_class="show"; }else{ $hide_class="hide"; } ?>
        <div class="width100 float_left <?php echo $hide_class;?>" id="Front_detail">
                <div class="width40 float_left">
                    <div class="table-responsive table_wrp">
                        <table class="style5">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Select Injury</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="front_injury_name">Face</td>
                                    <td>
                                        <select id="Injury" tabindex="2" name="injury" class="width_full" data-base="front_injury" data-errors="{filter_required:'Front Injury should not be blank'}" <?php echo $view; ?> style="margin-top: 10px;">
                                        <option value="" >Please select Injury</option>  
                                        
                                        <?php echo get_injury(@$inc_details[0]->inc_district_id);?>


                                    </select>
                                    </td>
                                    <td align="center">
                                                
        <input name="front_injury" value="Select" class="btn base-xhttp-request float_left green_btn" data-href="{base_url}pcr/selecte_front_injury" data-qr="output_position=selected_front_detail" type="button">


                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="width50 float_right" style="margibn-left:10%" id="selected_front_detail">
                <?php if($front_injury_info){ ?>
                <div class="table_wrp">
                    <table class="style5">
                        <tr>
                            <th> Name</th>	
                            <th>Injury Name</th>	
                            <th> Action</th>	
                        </tr>
                         <?php foreach($front_injury_info as $injury){ ?>
                        <tr>
                            <td><?=@$injury['front_name'];?></td>	
                            <td><?=@$injury['inj_name'];?></td>	
                            <td>


<!--                         <input type="hidden" value="<?=@$injury['rand_id'];?>" data-base="remove_back_injury_<?=@$injury['rand_id'];?>" name="back_injury_row_id">
                          <input name="remove_back_injury_<?=@$injury['rand_id'];?>" value="Remove" class="btn base-xhttp-request red_btn" data-href="{base_url}pcr/remove_back_injury" data-qr="output_position=selected_back_detail" type="button">-->
 <input type="hidden" value="<?=@$injury['rand_id'];?>" data-base="remove_front_injury_<?=@$injury['rand_id'];?>" name="injury_row_id">
         <input name="remove_front_injury_<?=@$injury['rand_id'];?>" value="Remove" class="btn base-xhttp-request red_btn" data-href="{base_url}pcr/remove_front_injury" data-qr="output_position=selected_front_detail" type="button">

                            </td>  
                        </tr>
                    <?php }?>
                    </table>
                </div>
                <?php } ?>
            
                </div>
        </div>
    </div>
    <div class="width100 head_outer"><br></div>
     
    <div class="width100" id="back_detail_block">
        <div class="width30 table_wrp float_left">
            <label class="label">Select Back:</label>
            <div class="col-sm-2">
                <select name="back" class="form-control" data-base="back_injury" id="back_id" onchange="load_back_injury(this);">
                        <option value="" >Please Select Back</option>  

                        <?php echo get_back('1');?>
                </select>
            </div>
        </div>
           <?php if($back_injury_info){ $hide_class="show"; }else{ $hide_class="hide"; } ?>
        <div class="width100 float_right <?php echo $hide_class;?>" id="back_detail">
                <div class="width40 table_wrp float_left">
                      <div class="table-responsive">
                        <table class="style5">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Select Injury</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="back_injury_name">Head</td>
                                    <td>
                                        <select id="Injury" tabindex="15" name="back_injury" class="width_full" data-base="back_injury" data-errors="{filter_required:'Back Injury should not be blank'}" <?php echo $view; ?> style="margin-top: 10px;">
                                        <option value="" >Please select Injury</option>  
                                        
                                        <?php echo get_injury(@$inc_details[0]->inc_district_id);?>


                                    </select>
                                    </td>
                                    <td align="center">
                                                
        <input name="back_injury" value="Select" class="btn base-xhttp-request float_left green_btn" data-href="{base_url}pcr/selecte_back_injury" data-qr="output_position=selected_back_detail" type="button">


                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="width50 float_right" style="margibn-left:10%" id="selected_back_detail">
                <?php if($back_injury_info){ ?>
                <div class="table_wrp">
                    <table class="style5">
                        <tr>
                            <th> Name</th>	
                            <th>Injury Name</th>	
                            <th> Action</th>	
                        </tr>
                         <?php foreach($back_injury_info as $injury){ ?>
                        <tr>
                            <td><?=@$injury['back_name'];?></td>	
                            <td><?=@$injury['inj_name'];?></td>	
                            <td>


<!--                         <input type="hidden" value="<?=@$injury['rand_id'];?>" data-base="remove_back_injury_<?=@$injury['rand_id'];?>" name="back_injury_row_id">
                          <input name="remove_back_injury_<?=@$injury['rand_id'];?>" value="Remove" class="btn base-xhttp-request red_btn" data-href="{base_url}pcr/remove_back_injury" data-qr="output_position=selected_back_detail" type="button">-->
                                         <input type="hidden" value="<?=@$injury['rand_id'];?>" data-base="remove_back_injury_<?=@$injury['rand_id'];?>" name="back_injury_row_id">
          <input name="remove_back_injury_<?=@$injury['rand_id'];?>" value="Remove" class="btn base-xhttp-request red_btn" data-href="{base_url}pcr/remove_back_injury" data-qr="output_position=selected_back_detail" type="button">


                            </td>  
                        </tr>
                    <?php }?>
                    </table>
                </div>
                <?php } ?>
                </div>
        </div>
    </div>
    
    <div class="width100 head_outer"><br></div>
    
    <div class="width100" id="side_detail_block">
        <div class="width30 table_wrp float_left">
            <label class="label" >Select Side:</label>
            <div class="col-sm-2">
                <select name="side" class="form-control input-sm"  data-base="side_injury" id="side_id" onchange="load_side_injury(this);">
                        <option value="" >Please Select Side</option>  

                        <?php echo get_side('1');?>
                </select>
            </div>
        </div>
        <?php if($side_injury_info){ $hide_class="show"; }else{ $hide_class="hide"; } ?>
        <div class="width100 float_right <?php echo $hide_class;?>" id="side_detail">
                <div class="width40 table_wrp float_left">
                    <div class="table-responsive">
                        <table class="style5">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Select Injury</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="side_injury_name">Lt arm</td>
                                    <td>
                                    <select id="Injury" tabindex="15" name="side_injury" class="width_full" data-base="side_injury" data-errors="{filter_required:'Side Injury should not be blank'}" <?php echo $view; ?> style="margin-top: 10px;" >
                                        <option value="" >Please select Injury</option>  
                                        
                                        <?php echo get_injury(@$inc_details[0]->inc_district_id);?>


                                    </select>
                                    </td>
                                    <td align="center">
                                                
        <input name="side_injury" value="Select" class="btn base-xhttp-request float_left green_btn" data-href="{base_url}pcr/selecte_side_injury" data-qr="output_position=selected_side_detail" type="button">


                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="width50 float_right" style="margibn-left:10%" id="selected_side_detail">
                            <?php if($side_injury_info){ ?>
                <div class="table_wrp">
                    <table class="style5">
                        <tr>
                            <th> Name</th>	
                            <th>Injury Name</th>	
                            <th> Action</th>	
                        </tr>
                         <?php foreach($side_injury_info as $injury){ ?>
                        <tr>
                            <td><?=@$injury['side_name'];?></td>	
                            <td><?=@$injury['inj_name'];?></td>	
                            <td>


<!--                         <input type="hidden" value="<?=@$injury['rand_id'];?>" data-base="remove_back_injury_<?=@$injury['rand_id'];?>" name="back_injury_row_id">
                          <input name="remove_back_injury_<?=@$injury['rand_id'];?>" value="Remove" class="btn base-xhttp-request red_btn" data-href="{base_url}pcr/remove_back_injury" data-qr="output_position=selected_back_detail" type="button">-->
                                           <input type="hidden" value="<?=@$injury['rand_id'];?>" data-base="remove_side_injury_<?=@$injury['rand_id'];?>" name="side_injury_row_id">
          <input name="remove_side_injury_<?=@$injury['rand_id'];?>" value="Remove" class="btn base-xhttp-request red_btn" data-href="{base_url}pcr/remove_side_injury" data-qr="output_position=selected_side_detail" type="button">


                            </td>  
                        </tr>
                    <?php }?>
                    </table>
                </div>
                <?php } ?>
                </div>
        </div>
    </div>
    <div class="width100 head_outer"><br></div>
    
    <div class="width100">
        <div style="margibn-left:10%" id="selected_side_detail"></div>
    </div>
    <div class="width100" style="margin-bottom:2%" align="center"><br>
        <input type="button" class="btn-default form-xhttp-request" data-href="{base_url}pcr/save_trauma_assessment" data-qr="output_position=content" value="Accept">
    </div>
</form>
</div>
        <div class="next_pre_outer">
           <?php  $step = $this->session->userdata('pcr_details'); 
           if(!empty($step)){
           ?>
             <a href="#" class="prev_btn btn float_left" onclick="load_next_prev_step(4)"> < Prev </a>
            <a href="#" class="next_btn btn float_right" onclick="load_next_prev_step(6)"> Next > </a>
           <?php } ?>
        </div>