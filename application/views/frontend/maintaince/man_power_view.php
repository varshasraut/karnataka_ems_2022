<div id="dublicate_id"></div>

<?php
if ($type == 'Update') {
    $update = 'disabled';
}
?>

<form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form">
    <div class="width1">
        <h2 class="txt_clr2 width1 txt_pro"><?php
            if ($action_type) {
                echo $action_type;
            }
            ?></h2>


        <div class="joining_details_box">

            <div class="width100">

                <div class="field_row width100">
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33 strong "><label for="district">District<span class="md_field">*</span></label></div>   
                        <div class="filed_input float_left width50">
                            <div id="maintaince_dist">
                               <?php
                                echo $preventive[0]->dst_name;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="district">Ambulance Number<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <div id="maintaince_ambulance">

                                <?php echo $preventive[0]->mt_amb_no;?>

                            </div>

                        </div>

                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="district">Base Location<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_base_location">
                           <?= @$preventive[0]->mt_base_loc; ?>

                        </div>
                    </div>
                    
                     <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="district">Ambulance Make<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="ambulance_state">



                                <?php
                                echo $preventive[0]->mt_make;
                                 
                                ?>

                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33 strong "><label for="district">Ambulance Model<span class="md_field">*</span></label></div>   
                        <div class="filed_input float_left width50">
                            <div id="maintaince_dist">
                               <?php
                                echo $preventive[0]->mt_module;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

     
                    
                  

                </div>

                <div class="field_row width100" id="maintance_previous_odometer">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="previous_odometer">Last Updated Odometer<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                           <?=@$preventive[0]->mt_previos_odometer;?>

                        </div>
                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="in_odometer">Current Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                             <?=@$preventive[0]->mt_in_odometer;?>


                        </div>
                    </div>
                </div>
                <div class="field_row width100" >

                <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="previous_odometer">Expected Onroad Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                           <?=@$preventive[0]->mt_ontime_onroad_date;?>

                        </div>
                    </div>
                <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="in_odometer">Off-Road Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                             <?=@$preventive[0]->mt_offroad_date;?>


                        </div>
                    </div>
                </div>

                <div class="field_row width100">

                 

                

                   
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mt_remark">Remark<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50">
                           <?= @$preventive[0]->mt_remark; ?>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"><label for="mt_estimatecost">Added By<span class="md_field"></span></label></div>
                       

                        <div class="filed_input float_left width50" >
                            <?php if(empty($preventive)){
                                $clg_ref_id = $clg_ref_id ;
                            }else{
                                 $clg_ref_id = $preventive[0]->added_by ;
                            }?>
                           <?=@$clg_ref_id;?>
                        </div>
                    </div>

                </div>
            </div>
        </div>



                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="end_odometer">End Odometer<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                <?=@$preventive[0]->mt_end_odometer;?>


                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33 strong"><label for="end_odometer">Manpower issue for<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                <?=@$preventive[0]->mt_manpower_issue_for;?>


                            </div>
                        </div>
                    </div>
                    <div class="field_row width100">
                      
                        <div class="width2 float_left">
                        <div class="field_lable float_left width33 strong"> <label for="mt_on_remark">Remark<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50">
                            <?= @$preventive[0]->mt_on_remark; ?>
                        </div>
                        </div>
                    </div>
        
    
        
       

                    
    </div>  


 
 
<div class="field_row width100" style="background: #cdcdbe;text-align: center;font-weight: bold;">
    <?php echo "Accidental Maintenance Approval Information"; ?>
</div>

<div class="field_row width100">
    <div class="filed_input float_left width2"> 
        <div class="field_lable float_left width33 strong"> 
            <label for="mt_stnd_remark">Approval<span class="md_field">*</span></label>
        </div>
        <div class="filed_input float_left width50">
            <?php if (@$preventive[0]->mt_approval == '1') {
                        echo "Approved";
                    }else{
                        echo "Approval Pending";
                    }
            ?>
                            
        </div>
    </div>

</div>


<div class="field_row width100">
    <div class="width2 float_left">
        <div class="field_lable float_left width33 strong"> 
            <label for="mt_on_remark">Approved By<span class="md_field">*</span></label>
        </div>
        <div class="filed_input float_left width50">
        <?php if($preventive[0]->approved_by != ''){ 
            
            echo "(".get_clg_name_by_ref_id($preventive[0]->approved_by).") ". $preventive[0]->approved_by;
            
        }else{"-";}?>
        </div>
    </div>

    <div class="filed_input float_left width100"> 
    <div class="field_lable float_left width17 strong"> 
            <label for="mt_on_remark">Approve Remark<span class="md_field">*</span></label>
        </div>
        <div class="filed_input float_left width80">
        <?php if($preventive[0]->mt_app_remark != ''){echo $preventive[0]->mt_app_remark;}else{"-";}?>
        </div>
        
    </div>
</div>

     
</form>

