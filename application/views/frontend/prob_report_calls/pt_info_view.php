<script>
<?php echo $scrpt; ?>
</script>

<div class="inc_pt_info float_left width100">
    
    <div class="width47 float_left">
        
        <span class="font_weight600">Incident Information</span>
        
        <table class="style3">
            
            <tr>
                <td>Caller Name</td>
                <td><?php echo $pt_info[0]->clr_fname." ".$pt_info[0]->clr_lname;?></td>
            </tr>
            
            <tr>
                <td>Patient Name</td>
                <td><?php echo $pt_info[0]->ptn_fname." ".$pt_info[0]->ptn_lname;?></td>
            </tr>
            
            <tr>
                <td>Incident Address</td>
                <td><?php echo $pt_info[0]->inc_address;?></td>
            </tr>
            
        </table>
        
    </div>
    
    <div class="width47 float_right">
        
        <span class="font_weight600">Patient Information</span>
        
         <table class="style3">
            
            <tr>
                <td>Chief Complaint Name</td>
                <td><?php echo $pt_info[0]->ct_type;?></td>
            </tr>
            
            <tr>
                <td>SHP Name</td>
                 <td><?php echo $pt_info[0]->clg_first_name." ".$pt_info[0]->clg_last_name;?></td>
                
            </tr>
            
            <tr>
                <td>ERO Summary</td>
                <td><?php echo $pt_info[0]->inc_ero_summary;?></td>
            </tr>
            
            <tr>
                <td>Ambulance Base Location</td>
                <td><?php echo $pt_info[0]->hp_name;?></td>
            </tr>
            
        </table>
        
    </div>
    
</div>

<input type="hidden" name="increfid" value="<?php echo $increfid;?>">



            