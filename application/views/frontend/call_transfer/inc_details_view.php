 

<table class="style2 float_left">
                
        <tr>
            <th>Sr.No</th>
            <th>Incident Id</th>
            <th>ERO Notes</th>
            <th>Incident Location</th>
            <th>Patient Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Action</th>
        </tr>
        
            
            <?php 
            
            
            if(is_array($pt_details)){
                
                $srno=1;
                foreach($pt_details as $pet){
                
            ?>
            <tr>
            <td><?php echo $srno; ?></td>
            <td><?php echo $pet->inc_ref_id; ?></td>
            <td><?php echo $pet->inc_ero_summary; ?></td>
            <td><?php echo $pet->inc_address; ?></td>
            <td><?php echo $pet->ptn_fname." ".$pet->ptn_lname; ?></td>
            
            <?php $dtm=explode(" ",$pet->inc_datetime); ?>
            
            <td><?php echo $dtm[0]; ?></td>
            <td><?php echo date("g:i A",strtotime($dtm[1])); ?></td>
            <td id="incact">
    
                <input name="select" class="click-xhttp-request inc_act<?php echo $pet->inc_ref_id; ?> incact" data-href="{base_url}patients/pt_inc_info" data-qr="inc_ref_id=<?php echo $pet->inc_ref_id;?>&amp;tah_id=<?php echo $tahshil;?>&amp;freq=true" value="SELECT" type="button">

            </td>
            </tr>
            
            <?php 
            
                $srno++;
            
                }
                
            
            }else{ ?>
            
            <tr><td colspan="8" class="text_align_center">No records found.</td></tr>
            
            <?php } ?>
        </tr>
                
                
</table>

<div id="inc_pt_info">
    
</div>


<div id="inc_fwd_note" class="tabl_btm_note width100 float_left">
    
    <span class="float_right">Please select at least one incidence forward to supervisor.</span>
    
</div>