<?php
if(@$condition=='add'){
$distance_from = array();
if(count($get_distance_form)>0){
    foreach($get_distance_form as $dist_from){ 
        $distance_from[$dist_from->report_id] = $dist_from->medical_store_name;
    }
}

$result_dis_from= array();
$i=0;
if(count($result)>0){
foreach($result as $res){
    
    $result_dis_from[$i] = $res->distance_form;
    $i++;    
}
}


$result=array();

if(count($get_distance_form)>0){
    foreach($get_distance_form as $dist_from){  
        if($dist_from->report_id == $report_id){
            $result[0] = $dist_from;
        }
    }
}


?>

            
            <div class="add_discount_form_content">
           
              
                <div class="left-text discount_text">
                    <div class="labels">
                        <label for="distance">Distance Form</label>
                    </div>
                </div>
                
                <div class="right_text discount_right_text">
                    
                    <?php //if(count(@$get_distance_form)>0){
                    
                                           
                      $selected_distance_from[$result[0]->distance_form] = "selected = selected";
                      
                    
                    ?>
                
                    <select name="distance_form" id="select_box" class="distance_from change-xhttp-request half-text text_input filter_required " data-errors="{filter_required:' Please select discount type'}" tabindex="2">
											
                                                                                
					    <option disabled="" selected="" value=""> Select option </option>
                        
                        <option value="1" <?php echo $selected_distance_from[1];?>>Home</option>     
                        
                            <?php
                            
                            if(count(@$get_distance_form)>0){
                               foreach($get_distance_form as $value){ 
                                 
                               ?>  
                                                             
                            <option value="<?php echo $value->report_id; ?>"<?php echo @$selected_distance_from[$value->report_id]; ?>><?php echo $value->medical_store_name; ?> </option>
                            <?php  }}?>
                                               
											
                    </select>
                </div>
                
            </div> 
            
<?php } ?>

<?php 

$distance_from = array();



if(count($get_data)>0){
    foreach($get_data as $dist_from){ 
        $distance_from[$dist_from->report_id] = $dist_from->medical_store_name;
    }
}

$result_dis_from= array();
$i=0;
if(count($result)>0){
foreach($result as $res){
    
    $result_dis_from[$i] = $res->distance_form;
    $i++;    
}
}


$result=array();

if(count($get_data)>0){
    foreach($get_data as $dist_from){  
        if($dist_from->report_id == $report_id){
            $result[0] = $dist_from;
        }
    }
}


if(@$condition=='edit'){ ?>
    
    
            <div class="add_discount_form_content">
           
              
                <div class="left-text discount_text">
                    <div class="labels">
                        <label for="distance">Distance Form</label>
                    </div>
                </div>
                
                 <div class="right_text discount_right_text">

                        <?php //if(count(@$get_distance_form)>0){


                          $selected_distance_from[$result[0]->distance_form] = "selected = selected";

                        ?>

                        <select name="distance_form" id="select_box" class="distance_from change-xhttp-request half-text text_input filter_required " data-errors="{filter_required:' Please select discount type'}" tabindex="2">


                            <option disabled="" selected="" value=""> Select option </option>

                            <option value="1" <?php echo $selected_distance_from[1];?>>Home</option>     

                                <?php  



                                if(count(@$get_data)>0){
                                   foreach($get_data as $value){
                                       


                                        if(in_array($value->report_id, $result_dis_from) ){ 
                                      

                                   ?>  

                                  <option value="<?php echo $value->report_id; ?>"<?php echo @$selected_distance_from[$value->report_id]; ?>><?php echo $value->medical_store_name; ?> </option>
                                   <?php  }}}?>


                        </select>
                    </div>
            </div>
    
<?php } ?>
    


