<script>
    
      init_autocomplete();

</script>
<div id="remote_vehical_status">
<form method="post" name="amb_form" id="amb_list">  
    <div class="row">
        <div class="col-md-1">Ambulance : </div>
        <div class="col-md-2">
            
            <select name="amb_reg" class="" data-errors="{filter_required:'Ambulance type should not be blank'}" <?php echo $view; ?> TABINDEX="5">
                <?php 
                if($amb_rto_register!='')
                { ?>
                    <option value="<?php echo $amb_rto_register; ?>"><?php echo $amb_rto_register; ?></option>
                <?php }else{
                    ?>
                    <option value="">Select Type</option>
                    <?php
                }
                ?>
                
                <?php if($amb_list){
                    foreach($amb_list as $amb){ ?>
                <option value="<?php echo $amb->amb_rto_register_no; ?>"><?php echo $amb->amb_rto_register_no; ?></option>
                <?php } } ?>
               
            </select>
        </div>

        <div class="col-md-1">Type</div>   

        <div class="col-md-2">
            <select name="amb_type" class="" data-errors="{filter_required:'Ambulance type should not be blank'}" <?php echo $view; ?> TABINDEX="5">

            <?php 
                if($amb_type != '')
                { ?>
                    <option value=<?php echo $amb_type ; ?> ><?php echo get_amb_type_by_id($amb_type) ; ?> </option>
                    <?php echo get_amb_type($update_data[0]->amb_type); ?>
               <?php }else{
                    ?>
                    <option value="">Select Type</option>
                    <?php echo get_amb_type($update_data[0]->ambt_name); ?>
                    <?php
                }
                ?>
                
            </select>
        </div>
        <div class="col-md-1">Status</div>   

        <div class="col-md-2">
            <select name="amb_status" class="" data-errors="{filter_required:'Ambulance Status should not be blank'}" <?php echo $view; ?> TABINDEX="5">
            <?php 
                if($amb_status!='')
                { 
                    if($amb_status=='1'){
                        ?>
                        <option value="1">Login</option>
                        <?php
                    }elseif($amb_status=='2'){
                        ?>
                         <option value="2">Logout</option>
                        <?php
                    }
                 }else{
                    ?>
                    <option value="">Select Status</option>
                    <?php
                }
                ?>
                <option value="1">Login</option>
                <option value="2">Logout</option>
        </select>
        </div>
        <div class="col-md-3" style="padding: 0px;"> <input type="button" class="search_button float_right form-xhttp-request" name="" value="Search" data-href="{base_url}bed/vehical_tracking_search" data-qr="output_position=content&amp;flt=true" />
             <input type="button" class="search_button float_right click-xhttp-request" name="" value="Reset" data-href="{base_url}bed/vehical_tracking_search" data-qr="output_position=content&amp;flt=true" /></div>   
    </div>
    <div class="row">
        <div class="col-md-2"><strong>Login:</strong> </div>
        <div class="col-md-1">
            <?php echo $login_count; ?>

        </div>
        <div class="col-md-2"><strong>Logout:</strong> </div>
        <div class="col-md-1">
            <?php echo $logout_count; ?>

        </div>
        <div class="col-md-2"><strong>Total:</strong> </div>
        <div class="col-md-1">
            <?php echo $logout_count+$login_count; ?>

        </div>
    </div>

   
</form>
<table class="table table-bordered NHM_Dashboard_report"  >

    <tr>                              
        <?php foreach ($header as $heading) { ?>
            <th style="line-height: 20px;"><?php echo $heading; ?></th>
            <?php } ?>
    </tr>
    <?php
    $count = 1;
    if (is_array($amb_data)) {
     
        foreach ($amb_data as $amb){ 
            if($amb->amb_status == 2 ){ 
            ?>
            
            <tr>         
            
            <td><?php echo $amb->amb_rto_register_no; ?></td>
            <td><?php echo $amb->ambt_name; ?></td>
            <td><?php 
            
            if($amb->parameter_count == '2'){
                $time = $amb->start_from_base_loc;
                echo 'Start From Base';
            }elseif($amb->parameter_count == '3'){
                $time = $amb->at_scene;
                echo 'At Scene';
            }elseif($amb->parameter_count == '4'){
                $time = $amb->from_scene;
                echo 'From Scene';
            }elseif($amb->parameter_count == '5'){
                $time = $amb->at_hospital;
                echo 'At Hospital';
            }elseif($amb->parameter_count == '6'){
                $time = $amb->patient_handover;
                echo 'Patient Handover';
            }elseif($amb->parameter_count == '7'){
                $time = $amb->back_to_base_loc;
                echo 'Back To Base';
            }else{
                $time = $amb->assigned_time;
                echo 'Call Assigned';
            }
        
        ?></td>
             <td><a data-href="{base_url}bed/amb_user_view" class="onpage_popup" data-qr="output_position=popup_div&AMP;amb_rto_register_no=<?php echo $amb->amb_rto_register_no; ?>" data-popupwidth="500" data-popupheight="500"  style="color:#000;">Check user</a></td>
           <td><a data-href="{base_url}bed/record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $amb->inc_ref_id; ?>" data-popupwidth="1300" data-popupheight="200"  style="color:#000;"> <?php echo $amb->inc_ref_id; ?></a></td>
          <!-- <td><?php //echo show_vehical_Login_details($amb->amb_rto_register_no); ?></td>-->
           <td nowrap><?php echo $time; ?></td>
            
            
             
        </tr>
            

            <?php  }else{ ?>
            <tr>         
                <td><?php echo $amb->amb_rto_register_no; ?></td>
                <td><?php echo $amb->ambt_name; ?></td>
                <td><?php echo show_vehical_Login_details($amb->amb_rto_register_no); ?></td>
                <td><a data-href="{base_url}bed/amb_user_view" class="onpage_popup" data-qr="output_position=popup_div&AMP;amb_rto_register_no=<?php echo $amb->amb_rto_register_no; ?>" data-popupwidth="500" data-popupheight="500"  style="color:#000;">Check user</a></td>
               
                <td><?php echo ''; ?></td>
                <td nowrap><?php echo ''; ?></td>
            </tr>
        <?php    }
     $count++; 
    
    
    }
    }

    ?>

</table>
</div>