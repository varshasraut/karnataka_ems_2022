 <div class="width1 float_left ">
                <h2 class="txt_clr2 width1 txt_pro">Add Remark</h2>
                <table>
                    <tr>
                        <th>Ambulance</th>
                        <th>Remark</th>
                        <th>Remark Added By</th>
                        <th>Remark Date</th>
                    </tr>
                    <?php if($remark_data){
                        foreach($remark_data as $remark){?>
                            <tr>
                                <td><?php echo $remark->amb_id; ?></td>
                                <td><?php echo $remark->remark; ?></td>
                                <td><?php echo $remark->clg_first_name.' '.$remark->clg_mid_name.' '.$remark->clg_last_name; ?></td>
                                <td><?php echo $remark->added_date; ?></td>
                            </tr>
                       <?php }   
                    } else{?>
                    <tr><td colspan="4">No record</td></tr>
                    <?php }?>
                </table>