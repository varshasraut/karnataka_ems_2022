
<div class="width100">
<form enctype="multipart/form-data" method="post" id="reports_type">

        <div class="field_row">

            <div class="filed_select">
                <div class="width30 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select District: </div>
                    </div>
                    <div class="width100 float_left">
<!--                        <div id="incient_dist">
                            <?php
                           // $dt = array('dst_code' => '', 'st_code' => 'MP', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                             //echo get_district($dt);
                            ?>
                        </div>-->
                        <!-- <select name="incient_district" class="filter_required" data-errors="{filter_required:'District should not be blank!'}">
                            <option value="">Select District</option>
                            <option value="30">Mumbai</option>
                            <option value="35">Palghar</option>
                            <option value="10">Gadchiroli</option>
                            <option value="28">Solapur</option>
                            <option value="3">Amravati</option>
                            <option value="other">Other</option>
                         </select> -->
                         <select name="incient_district" class="filter_required" data-errors="{filter_required:'District should not be blank!'}">
                       <option value="">Select District</option>
                        <?php foreach ($district_data as $key) { ?>
                            <option value="<?php echo $key->dst_code ?>"><?php echo $key->dst_name ?></option>
                        <?php  }
                        ?>

                    </select>
                    </div>
                </div>
                
            </div>
            <div class="field_row float_left width30">

            <div class="filed_select">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Month: </div>
                    </div>
                    <div class="width100 float_left" >
                        
                        <select name="from_date" class="filter_required" data-errors="{filter_required:'Month should not be blank!'}">
                            <option value="">Select Month</option>
                            <?php for($i=0;$i<=20;$i++){
                                $current_date = time();
                                $month = date('M Y',strtotime('-'.$i.' Months',$current_date)); 
                                $month_value = date('Y-m-01',strtotime('-'.$i.' Months',$current_date)); 
                                
                                echo '<option value="'.$month_value.'">'.$month.'</option>';
                            }?>
                           
                        </select>
                    </div>
                </div>
            </div>

        </div>

        </div>
       <div class="width_25 float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box">

<!--                    <input type="submit" name="submit" value="Submit" TABINDEX="3">  -->
                    <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>reports/<?php echo $submit_function;?>" class="form-xhttp-request btn clg_search" >
                </div>
            </div>
        </div>
</div>
<div class="box3">    

    <div class="permission_list group_list">

        <div id="list_table" >


        </div>
    </div>
</div>