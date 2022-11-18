

<div class="inc_pt_info float_left width100">
    
    
    <?php if(!empty($pt_info[0])){ ?>
    
    <div class="width47 float_left">
        
        <span class="font_weight600">Incident Information</span>
        
        <table class="style3">
            
            <tr>
                <td>No Of Patients</td>
                <td><?php echo $pt_info[0]->inc_patient_cnt;?></td>
            </tr>
            
            <tr>
                <td>Chief Complaint Name</td>
                <td><?php echo $pt_info[0]->ct_type;?></td>
            </tr>
            
            <tr>
                <td>Incident Address</td>
                <td><?php echo $pt_info[0]->inc_address;?></td>
            </tr>
            
            <?php if(@$resource=='true'){ ?>
            
                <tr>
                    <td>Current Ambulance</td>
                    <td><?php ?></td>
                </tr>
            <?php } ?>
            
        </table>
        
    </div>
    
    <div class="width47 float_right">
        
        <span class="font_weight600">Patient Information</span>
        
         <table class="style3">
            
            <tr>
                <td>patient Name</td>
                <td><?php echo $pt_info[0]->ptn_fname." ".$pt_info[0]->ptn_lname;?></td>
            </tr>
            
            <tr>
                <td>Age</td>
                <td><?php echo $pt_info[0]->ptn_age;?></td>
            </tr>
            
            <tr>
                <td>Gender</td>
                <td><?php echo get_gen($pt_info[0]->ptn_gender);?></td>
            </tr>
            
            <tr>
                <td>ERO Summary</td>
                <td><?php echo $pt_info[0]->inc_ero_summary;?></td>
            </tr>
            
        </table>
        
    </div>
    

    <?php }else{ ?>

            <div class="width100 text_align_center"><span> No records found. </span></div>
    

    <?php } ?>
    
</div>

<div id="amb_map_view">

</div>
<input type="hidden" name="incaddress" id="IncAddress" value="<?php echo $pt_info[0]->inc_address;?>">

<?php 

if(!empty($pt_info[0]) && !(@$resource)){ ?>

<input name="search_btn" value="FORWARD TO ERCP" class="style4 form-xhttp-request" data-href="{base_url}medadv/save" data-qr="" type="button" >

<input type="hidden" name="increfid" value="<?php echo $increfid;?>">


<?php } 

if(@$resource=='true'){ ?>


    <div class="button_field_row text_align_center">
        
        <div class="button_box">
                        
            <input type="hidden" name="submit" value="sub_test"/>
                         
            <input type="button" name="submit" value="Save" class="style5 form-xhttp-request" data-href='{base_url}resource/save' data-qr="output_position=content">
                        
            <input type="reset" name="reset" id="reset" value="Reset" class="btn test_rst_btn register_view_reset">
        </div>
        
    </div>
    
<?php } ?>




            