<?php //var_dump($info); 
$hos_id = $hos_details[0]->hp_id; ?>
<input type="hidden" name="incient[hos_id]" value="<?php echo $hos_details[0]->hp_id; ?>"></input><br>  
<input type="hidden" name="incient[hos_name]" value="<?php echo $hos_details[0]->hp_name; ?>"></input><br>
<label id="hlbl"><span style="font-weight:bold;">Hospital Type : </span><?php echo get_hosp_type_by_id_full_name($hos_details[0]->hp_type); ?></label><br>
<!--<label id="lbl"><span style="font-weight:bold">Contact Person : </span><?php echo ''; ?></label>
<label id="lbl"><span style="font-weight:bold">Mobile No1 : </span><?php echo $hos_details[0]->hp_mobile; ?> </label>
<label id="lbl"><span style="font-weight:bold">Mobile No2 : </span><?php ''; ?> </label>-->
<!-- <table class="table report_table">

        <tr>
    <th>Name [ Type ] </th>
    <th>Total Beds</th>
    <th>Occupied</th>
    <th>Vacant</th>
    <th>Soft book</th>
    <th>Remarks</th>
    <th>Bed Booking</th>
        </tr>
        <tr>
                        <td>ICU beds without ventilator</td>                            
                        <td> <?php if ($info[0]->ICUWoVenti_Total_Beds != '0' && $info[0]->ICUWoVenti_Total_Beds != 'null' && $info[0]->ICUWoVenti_Total_Beds != '') {
                                    echo $info[0]->ICUWoVenti_Total_Beds;
                                } else {
                                    if ($info[0]->ICUWoVenti_Total_Beds != '0' && $info[0]->ICUWoVenti_Total_Beds != 'null' && $info[0]->ICUWoVenti_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td> 
                        <td> <?php if ($info[0]->ICUWoVenti_Occupied != '0' && $info[0]->ICUWoVenti_Occupied != 'null' && $info[0]->ICUWoVenti_Occupied != '') {
                                    echo $info[0]->ICUWoVenti_Occupied;
                                } else {
                                    if ($info[0]->ICUWoVenti_Total_Beds != '0' && $info[0]->ICUWoVenti_Total_Beds != 'null' && $info[0]->ICUWoVenti_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td> 
                        <td> <?php if ($info[0]->ICUWoVenti_Vacant != '0' && $info[0]->ICUWoVenti_Vacant != 'null' && $info[0]->ICUWoVenti_Vacant != '') {
                                    echo $info[0]->ICUWoVenti_Vacant;
                                } else {
                                    if ($info[0]->ICUWoVenti_Total_Beds != '0' && $info[0]->ICUWoVenti_Total_Beds != 'null' && $info[0]->ICUWoVenti_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td> 
                        <td> <?php echo get_bed_count_details('1'); ?> </td> 
                        <td> <?php if ($info[0]->ICUWoVenti_Remarks != '0' && $info[0]->ICUWoVenti_Remarks != 'null' && $info[0]->ICUWoVenti_Remarks != '') {
                                    echo $info[0]->ICUWoVenti_Remarks;
                                } else {
                                    echo 'NA';
                                } ?> </td> 
                        <td>
                        <?php if ($info[0]->ICUWoVenti_Vacant != '0' && $info[0]->ICUWoVenti_Vacant != 'null' && $info[0]->ICUWoVenti_Vacant != '') {
                        ?>
                            <input type="radio" name="incient[bed_type]" value="1" class="bed_book_chkbox float_left"  id="bed_type" style="margin-top:7px;"><label>Book</label>
                            <?php
                        }
                            ?>
                        </td>
                        
                     </tr>
                    
                    <tr>
                        <td>ICU beds with ventilator</td>  
                        <td> <?php if ($info[0]->ICUwithVenti_Total_Beds != '0' && $info[0]->ICUwithVenti_Total_Beds != 'null' && $info[0]->ICUwithVenti_Total_Beds != '') {
                                    echo $info[0]->ICUwithVenti_Total_Beds;
                                } else {
                                    if ($info[0]->ICUwithVenti_Total_Beds != '0' && $info[0]->ICUwithVenti_Total_Beds != 'null' && $info[0]->ICUwithVenti_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td> 
                        <td> <?php if ($info[0]->ICUwithVenti_Occupied != '0' && $info[0]->ICUwithVenti_Occupied != 'null' && $info[0]->ICUwithVenti_Occupied != '') {
                                    echo $info[0]->ICUwithVenti_Occupied;
                                } else {
                                    if ($info[0]->ICUwithVenti_Total_Beds != '0' && $info[0]->ICUwithVenti_Total_Beds != 'null' && $info[0]->ICUwithVenti_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td> 
                        <td> <?php if ($info[0]->ICUwithVenti_Vacant != '0' && $info[0]->ICUwithVenti_Vacant != 'null' && $info[0]->ICUwithVenti_Vacant != '') {
                                    echo $info[0]->ICUwithVenti_Vacant;
                                } else {
                                    if ($info[0]->ICUwithVenti_Total_Beds != '0' && $info[0]->ICUwithVenti_Total_Beds != 'null' && $info[0]->ICUwithVenti_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td> 
                        <td> <?php echo get_bed_count_details('2'); ?> </td>
                        <td> <?php if ($info[0]->ICUwithVenti_Remarks != '0' && $info[0]->ICUwithVenti_Remarks != 'null' && $info[0]->ICUwithVenti_Remarks != '') {
                                    echo $info[0]->ICUwithVenti_Remarks;
                                } else {
                                    echo 'NA';
                                } ?> </td> 
                        <td>
                        <?php if ($info[0]->ICUwithVenti_Vacant != '0' && $info[0]->ICUwithVenti_Vacant != 'null' && $info[0]->ICUwithVenti_Vacant != '') {
                        ?>
                        <input type="radio" name="incient[bed_type]" value="2" class="bed_book_chkbox float_left"  id="bed_type" style="margin-top:7px;"><label>Book</label>
                        <?php } ?>
                        </td>
                     </tr>
                    <tr>
                        <td>Dialysis beds</td>                            
                        <td> <?php if ($info[0]->ICUwithdialysisBed_Total_Beds != '0' && $info[0]->ICUwithdialysisBed_Total_Beds != 'null' && $info[0]->ICUwithdialysisBed_Total_Beds != '') {
                                    echo $info[0]->ICUwithdialysisBed_Total_Beds;
                                } else {
                                    if ($info[0]->ICUwithdialysisBed_Total_Beds != '0' && $info[0]->ICUwithdialysisBed_Total_Beds != 'null' && $info[0]->ICUwithdialysisBed_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td> 
                        <td> <?php if ($info[0]->ICUwithdialysisBed_Occupied != '0' && $info[0]->ICUwithdialysisBed_Occupied != 'null' && $info[0]->ICUwithdialysisBed_Occupied != '') {
                                    echo $info[0]->ICUwithdialysisBed_Occupied;
                                } else {
                                    if ($info[0]->ICUwithdialysisBed_Total_Beds != '0' && $info[0]->ICUwithdialysisBed_Total_Beds != 'null' && $info[0]->ICUwithdialysisBed_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td> 
                        <td> <?php if ($info[0]->ICUwithdialysisBed_Vacant != '0' && $info[0]->ICUwithdialysisBed_Vacant != 'null' && $info[0]->ICUwithdialysisBed_Vacant != '') {
                                    echo $info[0]->ICUwithdialysisBed_Vacant;
                                } else {
                                    if ($info[0]->ICUwithdialysisBed_Total_Beds != '0' && $info[0]->ICUwithdialysisBed_Total_Beds != 'null' && $info[0]->ICUwithdialysisBed_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td> 
                        <td> <?php echo get_bed_count_details('3'); ?> </td>
                        <td> <?php if ($info[0]->ICUwithdialysisBed_Remarks != '0' && $info[0]->ICUwithdialysisBed_Remarks != 'null' && $info[0]->ICUwithdialysisBed_Remarks != '') {
                                    echo $info[0]->ICUwithdialysisBed_Remarks;
                                } else {
                                    echo 'NA';
                                } ?> </td> 
                        <td>
                        <?php if ($info[0]->ICUwithdialysisBed_Vacant != '0' && $info[0]->ICUwithdialysisBed_Vacant != 'null' && $info[0]->ICUwithdialysisBed_Vacant != '') {
                        ?>
                        <input type="radio" name="incient[bed_type]" value="3" class="bed_book_chkbox float_left"  id="bed_type" style="margin-top:7px;"><label>Book</label>
                        <?php } ?> </td>
                     </tr>
                                                
                     <tr>
                        <td>Ward</td>    
                        <td> <?php //if($info[0]->C19Ward_Total_Beds !='0' && $info[0]->C19Ward_Total_Beds != 'null' && $info[0]->C19Ward_Total_Beds != ''){ echo $info[0]->C19Ward_Total_Beds; }else{ if($info[0]->C19Ward_Total_Beds !='0' && $info[0]->C19Ward_Total_Beds != 'null' && $info[0]->C19Ward_Total_Beds != ''){ echo '0'; }else{ echo 'DNA'; } } 
                                ?> </td>  
                        <td> <?php //if($info[0]->C19Ward_Occupied !='0' && $info[0]->C19Ward_Occupied != 'null' && $info[0]->C19Ward_Occupied != ''){ echo $info[0]->C19Ward_Occupied; }else{ if($info[0]->C19Ward_Total_Beds !='0' && $info[0]->C19Ward_Total_Beds != 'null' && $info[0]->C19Ward_Total_Beds != ''){ echo '0'; }else{ echo 'DNA'; } } 
                                ?> </td> 
                        <td> <?php //if($info[0]->C19Ward_Vacant !='0' && $info[0]->C19Ward_Vacant != 'null' && $info[0]->C19Ward_Vacant != ''){ echo $info[0]->C19Ward_Vacant; }else{ if($info[0]->C19Ward_Total_Beds !='0' && $info[0]->C19Ward_Total_Beds != 'null' && $info[0]->C19Ward_Total_Beds != ''){ echo '0'; }else{ echo 'DNA'; } } 
                                ?> </td> 
                        <td> <?php //if($info[0]->C19Ward_Remarks !='0' && $info[0]->C19Ward_Remarks != 'null' && $info[0]->C19Ward_Remarks != ''){ echo $info[0]->C19Ward_Remarks; }else{ echo 'NA'; } 
                                ?> </td> 
                    </tr>
                    <tr>
                        <td>Isolation beds-COVID19 positive </td>  
                        <td> <?php if ($info[0]->C19Positive_Total_Beds != '0' && $info[0]->C19Positive_Total_Beds != 'null' && $info[0]->C19Positive_Total_Beds != '') {
                                    echo $info[0]->C19Positive_Total_Beds;
                                } else {
                                    if ($info[0]->C19Positive_Total_Beds != '0' && $info[0]->C19Positive_Total_Beds != 'null' && $info[0]->C19Positive_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td>  
                        <td> <?php if ($info[0]->C19Positive_Occupied != '0' && $info[0]->C19Positive_Occupied != 'null' && $info[0]->C19Positive_Occupied != '') {
                                    echo $info[0]->C19Positive_Occupied;
                                } else {
                                    if ($info[0]->C19Positive_Total_Beds != '0' && $info[0]->C19Positive_Total_Beds != 'null' && $info[0]->C19Positive_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td> 
                        <td> <?php if ($info[0]->C19Positive_Vacant != '0' && $info[0]->C19Positive_Vacant != 'null' && $info[0]->C19Positive_Vacant != '') {
                                    echo $info[0]->C19Positive_Vacant;
                                } else {
                                    if ($info[0]->C19Positive_Total_Beds != '0' && $info[0]->C19Positive_Total_Beds != 'null' && $info[0]->C19Positive_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td>  
                        <td> <?php echo get_bed_count_details('4'); ?> </td>
                        <td> <?php if ($info[0]->C19Positive_Remarks != '0' && $info[0]->C19Positive_Remarks != 'null' && $info[0]->C19Positive_Remarks != '') {
                                    echo $info[0]->C19Positive_Remarks;
                                } else {
                                    echo 'NA';
                                } ?> </td> 
                        <td>
                        <?php if ($info[0]->C19Positive_Vacant != '0' && $info[0]->C19Positive_Vacant != 'null' && $info[0]->C19Positive_Vacant != '') {
                        ?>
                        <input type="radio" name="incient[bed_type]" value="4" class="bed_book_chkbox float_left"  id="bed_type" style="margin-top:7px;"><label>Book</label>
                        <?php } ?></td>
                     </tr>
                     <tr>
                        <td>Isolation beds-Central Oxygen</td>   
                        <td> <?php if ($info[0]->central_oxygen_Total_Beds != '0' && $info[0]->central_oxygen_Total_Beds != 'null' && $info[0]->central_oxygen_Total_Beds != '') {
                                    echo $info[0]->central_oxygen_Total_Beds;
                                } else {
                                    if ($info[0]->central_oxygen_Total_Beds != '0' && $info[0]->central_oxygen_Total_Beds != 'null' && $info[0]->central_oxygen_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td> 
                        <td> <?php if ($info[0]->central_oxygen_Occupied != '0' && $info[0]->central_oxygen_Occupied != 'null' && $info[0]->central_oxygen_Occupied != '') {
                                    echo $info[0]->central_oxygen_Occupied;
                                } else {
                                    if ($info[0]->central_oxygen_Total_Beds != '0' && $info[0]->central_oxygen_Total_Beds != 'null' && $info[0]->central_oxygen_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td>  
                        <td> <?php if ($info[0]->central_oxygen_Vacant != '0' && $info[0]->central_oxygen_Vacant != 'null' && $info[0]->central_oxygen_Vacant != '') {
                                    echo $info[0]->central_oxygen_Vacant;
                                } else {
                                    if ($info[0]->central_oxygen_Total_Beds != '0' && $info[0]->central_oxygen_Total_Beds != 'null' && $info[0]->central_oxygen_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td> 
                        <td> <?php echo get_bed_count_details('5'); ?> </td>
                        <td> <?php if ($info[0]->central_oxygen_Remarks != '0' && $info[0]->central_oxygen_Remarks != 'null' && $info[0]->central_oxygen_Remarks != '') {
                                    echo $screning['central_oxygen_Remarks'];
                                } else {
                                    echo 'NA';
                                } ?> </td> 
                        <td>
                        <?php if ($info[0]->central_oxygen_Vacant != '0' && $info[0]->central_oxygen_Vacant != 'null' && $info[0]->central_oxygen_Vacant != '') {
                        ?>
                        <input type="radio" name="incient[bed_type]" value="5" value="" class="bed_book_chkbox float_left"  id="bed_type" style="margin-top:7px;"><label>Book</label>
                        <?php } ?></td> 
                     </tr>
                    <tr>
                        <td>Quarantine Ward-Suspected COVID</td>                            
                        <td> <?php if ($info[0]->SspectC19_Total_Beds != '0' && $info[0]->SspectC19_Total_Beds != 'null' && $info[0]->SspectC19_Total_Beds != '') {
                                    echo $info[0]->SspectC19_Total_Beds;
                                } else {
                                    if ($info[0]->SspectC19_Total_Beds != '0' && $info[0]->SspectC19_Total_Beds != 'null' && $info[0]->SspectC19_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td>  
                        <td> <?php if ($info[0]->SspectC19_Occupied != '0' &&  $info[0]->SspectC19_Occupied != 'null' && $info[0]->SspectC19_Occupied != '') {
                                    echo $info[0]->SspectC19_Occupied;
                                } else {
                                    if ($info[0]->SspectC19_Total_Beds != '0' && $info[0]->SspectC19_Total_Beds != 'null' && $info[0]->SspectC19_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td> 
                        <td> <?php if ($info[0]->SspectC19_Vacant != '0' && $info[0]->SspectC19_Vacant != 'null' && $info[0]->SspectC19_Vacant != '') {
                                    echo $info[0]->SspectC19_Vacant;
                                } else {
                                    if ($info[0]->SspectC19_Total_Beds != '0' && $info[0]->SspectC19_Total_Beds != 'null' && $info[0]->SspectC19_Total_Beds != '') {
                                        echo '0';
                                    } else {
                                        echo 'DNA';
                                    }
                                } ?> </td>  
                        <td> <?php echo get_bed_count_details('6'); ?> </td>
                        <td> <?php if ($info[0]->SspectC19_Remarks != '0' && $info[0]->SspectC19_Remarks != 'null' && $info[0]->SspectC19_Remarks != '') {
                                    $info[0]->SspectC19_Remarks;
                                } else {
                                    echo 'NA';
                                } ?> </td> 
                        <td>
                        <?php if ($info[0]->SspectC19_Vacant != '0' && $info[0]->SspectC19_Vacant != 'null' && $info[0]->SspectC19_Vacant != '') {
                        ?>
                        <input type="radio" name="incient[bed_type]" value="6" class="bed_book_chkbox float_left"  id="bed_type" style="margin-top:7px;"><label>Book</label>
                        <?php } ?></td>

                    </tr>

                      
                        

</table> -->
<div class="float_right ">
    <a data-href='{base_url}hp/ero_hospital_details_view' id="hptlbtn" class="btn click-xhttp-request" data-qr='hp_id=<?php echo $hos_id; ?>&amp;output_position=content' TABINDEX="27">View Hospital Details</a>
</div>
<style>
    #lbl{
        width: 30%;
        margin: 0px;
        display: inline-block;
    }
    #hlbl{
        display: inline-block;
    }
    #hptlbtn{
        font-size: 12px;
    }
</style>