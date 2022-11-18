

<div class="inc_pt_info float_left width100">
    
    
    <?php if(!empty($pt_info[0])){ ?>
    
    <div class="width100 float_left">
        
        <span class="font_weight600">Incident Information</span>
        
        <table class="style3">
            
            <tr>
                <td class="width35">No Of Patients</td>
                <td><?php echo ($pt_info[0]->inc_patient_cnt) ? $pt_info[0]->inc_patient_cnt : "-";?></td>
            </tr>
            
            <tr>
                
                 <?php  if($pt_info[0]->inc_type=='mci'){
                            $label ="MCI Nature";
                            $value = ($pt_info[0]->ntr_nature) ? $pt_info[0]->ntr_nature : "-";
                        }else{
                             $label ="Chief Complaint Name";
                             $value= ($pt_info[0]->ct_type) ? $pt_info[0]->ct_type : "-"; 
                        }
                
                 ?>
                      <?php
                    //var_dump($pt_info);
                    
                    if (trim($pt_info[0]->ntr_nature) != '') {
                        $label = "MCI Nature";
                        $value = ($pt_info[0]->ntr_nature) ? $pt_info[0]->ntr_nature : "-";
                    } else if(trim($pt_info[0]->ptn_condition) != ''){
                        $label = "Patient Condition";
                        $value = ($pt_info[0]->ptn_condition) ? $pt_info[0]->ptn_condition : "-";
                    }else {
                        $label = "Chief Complaint Name";
                        $value = ($pt_info[0]->ct_type) ? $pt_info[0]->ct_type : "-";
                    }
                    ?>
                <td><?php echo $label; ?></td>
                <td><?php echo $value; ?></td>
            </tr>
            
            <tr>
                <td>Incident Address</td>
                 <td><?php echo ($pt_info[0]->inc_address) ? $pt_info[0]->inc_address : "-";?></td>
            </tr>
            
         
            
                <tr>
                    <td>Ambulance</td>
                    <td><?php echo ($pt_info[0]->amb_rto_register_no) ? $pt_info[0]->amb_rto_register_no : "-";?></td>
                </tr>
                
                <tr>
                    <td>Ambulance Name</td>
                    <td><?php echo ($pt_info[0]->hp_name) ? $pt_info[0]->hp_name : "-";?></td>
                </tr>
        
            
        </table>
        
    </div>
    <?php if($current_amb){ ?>
    <div class="width100 float_right">
        
        <span class="font_weight600">New Ambulance</span>
        
         <table class="style3">
            <?php foreach($current_amb as $amb){              ?>
            <tr>
                <td class="width35">Ambulance Name</td>
                <td><?php echo $amb->hp_name; ?></td>
            </tr>
            
            <tr>
                <td>Ambulance Registration No</td>
                <td><?php echo $amb->amb_rto_register_no; ?></td>
            </tr>
               <tr>
                <td>Ambulance Mobile</td>
                <td><?php echo $amb->amb_default_mobile; ?><a class="click-xhttp-request soft_dial_mobile" data-href="<?php echo base_url();?>avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0<?php echo $amb->amb_default_mobile; ?>"></a></td>
            </tr>
            <?php } ?>
        </table>
        
    </div>
    <?php }?>
    
    <div class="width100 float_right">
        
        <span class="font_weight600">Old Patient Information</span>
        
         <table class="style3">
            
            <tr>
                <td class="width35">patient Name</td>
                <td><?php echo ($pt_info[0]->ptn_fname) ? $pt_info[0]->ptn_fname . " " . $pt_info[0]->ptn_lname : "-"; ?></td>
            </tr>
            
            <tr>
                <td>Age</td>
                <td><?php echo ($pt_info[0]->ptn_age) ? $pt_info[0]->ptn_age : "-"; ?></td>
            </tr>
            
            <tr>
                <td>Gender</td>
                <td><?php echo ($pt_info[0]->ptn_gender) ? get_gen($pt_info[0]->ptn_gender) : "-"; ?></td>
            </tr>
            
            <tr>
                <td>ERO Summary</td>
                <td><?php echo ($pt_info[0]->inc_ero_summary) ? $pt_info[0]->inc_ero_summary : "-"; ?></td>
            </tr>
            
        </table>
        
    </div>
    
    <div class="width100 float_right">

            <span class="font_weight600">New Patient Information </span>

             <table class="style3"  style="margin-bottom: 10px;">

                <tr>
                    <td style="width: 40%;">Patient Name</td>
                    <td><?php echo $patient["first_name"]; ?> <?php echo $patient["middle_name"]; ?> <?php echo $patient["last_name"]; ?></td>
                </tr>

                <tr>
                    <td>Patient Age</td>
                     <td><?php echo $patient["age"];?></td>

                </tr>

                <tr>
                    <td>Gender</td>
                    <td><?php echo get_gen($patient["gender"]);?></td>
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

if(@$resource=='true'){ 
    
    ?>


    <div class="button_field_row text_align_center">
        
        <div class="button_box">
                        
            <input type="hidden" name="submit" value="sub_test"/>
 
            <input type="button" name="submit" value="Save" class="btn submit_btnt form-xhttp-request" data-href='{base_url}resource/save' data-qr='output_position=content' TABINDEX="5">
            
            <input type="reset" name="reset" id="reset" value="Reset" class="btn test_rst_btn register_view_reset">
            
            
            
        </div>
        
    </div>
    
<?php } ?>




            