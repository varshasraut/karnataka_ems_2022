<?php
 
        $post_data =json_decode(base64_decode(@$user_type_data),true);
        
        $data =json_encode($post_data);
        $data =base64_encode($data);
        

if(@$condition=='edit'){

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



?>
<div class="container clearfix">

        <form name="add_report" action="#" method="post" enctype="multipart/form-data" id="add_report">
            <h1 class="sms_heading">Add Report</h1>
            
            <div class="add_discount_form_content">
           
                <div class="left-text discount_text">
                    <div class="labels">
                        <label for="add_medical_store">Medical Store</label>
                    </div>
                </div>
                
                <div class="right_text discount_right_text">
                    <div class="text_box">
	                	<div class="input">      
                            <?php   //$medi_name = str_replace(array('"'), '',json_decode($result[0]->medical_store_name,JSON_UNESCAPED_SLASHES));?>
                            <input type="text" name="store_name" value="<?php echo $result[0]->medical_store_name;?>" id="store_name" class="filter_required filter_words" data-errors="{filter_required:'Medical store should not be blank.',filter_words:'Store name not allowed number,spaces and special characters.'}" tabindex="1"/>
		                </div>
	                </div>
                </div>
                
                <div class="left-text discount_text">
                    <div class="labels">
                        <label for="time">Time</label>
                    </div>
                </div>
                
                
                <div class="right_text discount_right_text">
                    <div class="text_box">
	                	<div class="input">
                           <?php 
                            if(@$current_time=='true'){ 
                                $current_times = date("h:i A",time());
                            }else{
                                $current_times = $result[0]->report_time;
                                      
                            }?>
                         <input type="text" name="report_time" value="<?php echo $current_times; ?>" id="time" class="filter_required filter_number" data-errors="{filter_required:'Time should not be blank.',filter_number:'Time are allowed number.'}" tabindex="2"/>
		                </div>
	                </div>
                </div>
                
                
                <div class="outer_date">
                    <div class="left-text discount_text">
                      <div class="labels">
                          <label for="date">Date</label>
                      </div>
                    </div>
                
                    <div class="right_text discount_right_text">
                        <div class="text_box">
                            <div class="input">
                                  <?php   $date = date('Y-m-d',strtotime(date('Y-m-d'))); ?>

                              <input type="text" name="date_of_report" value="<?php echo $result[0]->date_of_report;?>" id="date_of_report" data-href="{base_url}ms-admin/clg/get_distance_from" data-qr="output_position=report_distance_from&amp;action=edit" class="change-xhttp-request mi_calender filter_required filter_lessthan[<?=$date?>]"  data-errors="{filter_required:'To Date should not be blank',filter_lessthan:'Date should be less than today'}">
                            </div>
                        </div>
                    </div> 
                </div>
                
                <div id="report_distance_from">
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
                                       //$medi_name = str_replace(array('"'), '',json_decode($value->medical_store_name,JSON_UNESCAPED_SLASHES));


                                   ?>  

                                  <option value="<?php echo $value->report_id; ?>"<?php echo @$selected_distance_from[$value->report_id]; ?>><?php echo $value->medical_store_name; ?> </option>
                                   <?php  }}}?>


                        </select>
                    </div>
                </div>

                <div class="left-text discount_text">
                    <div class="labels">
                        <label for="distance">Distance (KM)</label>
                    </div>
                </div>
                
                
                <div class="right_text discount_right_text">
                    <div class="text_box">
	                    <div class="input">
                              
                           <input type="text" name="distance" value="<?php echo $result[0]->distance;?>" id="distance" class="filter_required filter_number text_input" data-errors="{filter_required:'Distance should not be blank.',filter_number:'Distance only allowed number.'}"tabindex="3"/> 
		                </div>
	                </div>
                </div> 
                   
                            
                
                 <div class="left-text discount_text">
                    <div class="labels">
                        <label for="feedback">Feedback</label>
                    </div>
                </div>
                
                <div class="right_text discount_right_text">
                    <div class="text_box">
	                	<div class="input">
                         
                            <textarea type="text" name="feedback" value="<?php echo $result[0]->report_feedback;?>" id="report_feedback" class="filter_required address_area" data-errors="{filter_required:'Feedback should not be blank.'}" tabindex="5"><?php echo $result[0]->report_feedback;?></textarea>
		                </div>
	                </div>                      
                </div> 
                   
                <div class="add_discounts">

                    <input type="hidden" name="submit_form" value="form">
                    <input class="save_button form-xhttp-request small" id="save_button" data-href="{base_url}ms-admin/clg/report_operation" data-qr="<?php if(@$result[0]){?>action=edit<?php }else{?>action=add<?php }?>&amp;output_position=content&amp;all_data=true&amp;<?php if($result[0]){  ?>report_id[0]=<?php echo base64_encode($result[0]->report_id);?>&amp;report_data=<?php echo $data;?>&amp;page_number=<?php echo @$page_number;?><?php }?>" type="button" name="add_discount" value="Save"/>
                </div>
       
               
            </div> 
            
            <button type="button" id="boxClose" data-href="{base_url}ms-admin/sms/sms_add_view" data-qr="output_position=popup_content&amp;usr_ref_id=<?php echo base64_encode($value->dis_usr_ref_id);?>">close</button>
        </form>

</div>

<?php }else if($condition=='add'){
    
$distance_from = array();

if(count($get_distance_form)>0){
    foreach($get_distance_form as $dist_from){ 
        $distance_from[$dist_from->report_id] =  $dist_from->medical_store_name;
    }
}
$result=array();
if(count($get_distance_form)>0){
    foreach($get_distance_form as $dist_from){ 
        if($dist_from->report_id== $report_id){
            $result[0] = $dist_from;
        }
    }
}



?>
<div class="container clearfix">

        <form name="add_report" action="#" method="post" enctype="multipart/form-data" id="add_report">
            <h1 class="sms_heading">Add Report</h1>
            
            <div class="add_discount_form_content">
           
                <div class="left-text discount_text">
                    <div class="labels">
                        <label for="add_medical_store">Medical Store</label>
                    </div>
                </div>
                
                <div class="right_text discount_right_text">
                    <div class="text_box">
	                	<div class="input">      
                          
                            <input type="text" name="store_name" value="<?php echo $result[0]->medical_store_name;?>" id="store_name" class="filter_required filter_words" data-errors="{filter_required:'Medical store should not be blank.',filter_words:'Store name not allowed number,spaces and special characters.'}" tabindex="1"/>
		                </div>
	                </div>
                </div>
                
                <div class="left-text discount_text">
                    <div class="labels">
                        <label for="time">Time</label>
                    </div>
                </div>
                
                
                <div class="right_text discount_right_text">
                    <div class="text_box">
	                	<div class="input">
                           <?php 
                            if(@$current_time=='true'){ 
                                $current_times = date("h:i A",time());
                            }else{
                                $current_times = $result[0]->report_time;
                                      
                            }?>
                         <input type="text" name="report_time" value="<?php echo $current_times; ?>" id="time" class="filter_required filter_number" data-errors="{filter_required:'Time should not be blank.',filter_number:'Time are allowed number.'}" tabindex="2"/>
		                </div>
	                </div>
                </div>
                
                
                
                
                
                    <div class="left-text discount_text">
                        <div class="labels">
                            <label for="date">Date</label>
                        </div>
                    </div>

                    <div class="right_text discount_right_text">
                        <div class="text_box">
                            <div class="input">

                               <?php   $date = date('Y-m-d',strtotime(date('Y-m-d'))); ?>

                              <input type="text" name="date_of_report" value="<?php echo $result[0]->date_of_report;?>" id="date_of_report" data-href="{base_url}ms-admin/clg/get_distance_from" class="change-xhttp-request mi_calender filter_required filter_lessthan[<?=$date?>]" data-qr="output_position=report_distance_from&amp;action=add" data-errors="{filter_required:'To Date should not be blank',filter_lessthan:'Date should be less than today'}"tabindex="2" >
                            </div>
                        </div>
                    </div> 
                       
                
            
                 
                <div id="report_distance_from">
                
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
                
                <div class="left-text discount_text">
                    <div class="labels">
                        <label for="distance">Distance (KM)</label>
                    </div>
                </div>
                
                
                <div class="right_text discount_right_text">
                    <div class="text_box">
	                    <div class="input">
                              
                           <input type="text" name="distance" value="<?php echo $result[0]->distance;?>" id="distance" class="filter_required filter_number text_input" data-errors="{filter_required:'Distance should not be blank.',filter_number:'Distance only allowed number.'}"tabindex="3"/> 
		                </div>
	                </div>
                </div> 
                   
                
                 <div class="left-text discount_text">
                    <div class="labels">
                        <label for="feedback">Feedback</label>
                    </div>
                </div>
                
                <div class="right_text discount_right_text">
                    <div class="text_box">
	                	<div class="input">
                         
                            <textarea type="text" name="feedback" value="<?php echo $result[0]->report_feedback;?>" id="report_feedback" class="filter_required address_area" data-errors="{filter_required:'Feedback should not be blank.'}" tabindex="5"><?php echo $result[0]->report_feedback;?></textarea>
		                </div>
	                </div>                      
                </div> 
                   
                <div class="add_discounts">

                    <input type="hidden" name="submit_form" value="form">
                    <input class="save_button form-xhttp-request small" id="save_button" data-href="{base_url}ms-admin/clg/report_operation" data-qr="<?php if(@$result[0]){?>action=edit<?php }else{?>action=add<?php }?>&amp;output_position=content&amp;all_data=true&amp;<?php if($result[0]){  ?>report_id[0]=<?php echo base64_encode($result[0]->report_id);?>&amp;report_data=<?php echo $data;?>&amp;page_number=<?php echo @$page_number;?><?php }?>" type="button" name="add_discount" value="Save"/>
                </div>
       
               
            </div> 
            
            <button type="button" id="boxClose" data-href="{base_url}ms-admin/sms/sms_add_view" data-qr="output_position=popup_content&amp;usr_ref_id=<?php echo base64_encode($value->dis_usr_ref_id);?>">close</button>
          
        </form>
   

   </div>

         

    
<?php }else 

if(@$condition=='view'){

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



?>
<div class="container clearfix">

        <form name="add_report" action="#" method="post" enctype="multipart/form-data" id="add_report">
            <h1 class="sms_heading">Add Report</h1>
            
            <div class="add_discount_form_content">
           
                <div class="left-text discount_text">
                    <div class="labels">
                        <label for="add_medical_store">Medical Store</label>
                    </div>
                </div>
                
                <div class="right_text discount_right_text">
                    <div class="text_box">
	                	<div class="input">      
                          
                            <input type="text" name="store_name" value="<?php echo $result[0]->medical_store_name;?>" id="store_name" class="filter_required filter_words" data-errors="{filter_required:'Medical store should not be blank.',filter_words:'Store name not allowed number,spaces and special characters.'}" <?php if(@$result[0]!=''){?> disabled<?php }?> tabindex="1"/>
		                </div>
	                </div>
                </div>
                
                <div class="left-text discount_text">
                    <div class="labels">
                        <label for="time">Time</label>
                    </div>
                </div>
                
                
                <div class="right_text discount_right_text">
                    <div class="text_box">
	                	<div class="input">
                           <?php 
                            if(@$current_time=='true'){ 
                                $current_times = date("h:i A",time());
                            }else{
                                $current_times = $result[0]->report_time;
                                      
                            }?>
                         <input type="text" name="report_time" value="<?php echo $current_times; ?>" id="time" class="filter_required filter_number" data-errors="{filter_required:'Time should not be blank.',filter_number:'Time are allowed number.'}" <?php if(@$result[0]!=''){?> disabled<?php }?> tabindex="2"/>
		                </div>
	                </div>
                </div>
                
                
                <div class="outer_date">
                    <div class="left-text discount_text">
                      <div class="labels">
                          <label for="date">Date</label>
                      </div>
                    </div>
                
                    <div class="right_text discount_right_text">
                        <div class="text_box">
                            <div class="input">
                                  <?php   $date = date('Y-m-d',strtotime(date('Y-m-d'))); ?>

                              <input type="text" name="date_of_report" value="<?php echo $result[0]->date_of_report;?>" id="date_of_report" data-href="{base_url}ms-admin/clg/get_distance_from" data-qr="output_position=report_distance_from&amp;action=edit" class="change-xhttp-request mi_calender filter_required filter_lessthan[<?=$date?>]"  data-errors="{filter_required:'To Date should not be blank',filter_lessthan:'Date should be less than today'}" <?php if(@$result[0]!=''){?> disabled<?php }?>>
                            </div>
                        </div>
                    </div> 
                </div>
                
                <div id="report_distance_from">
                    <div class="left-text discount_text">
                        <div class="labels">
                            <label for="distance">Distance Form</label>
                        </div>
                    </div>
                
                
                
                    <div class="right_text discount_right_text">

                        <?php $selected_distance_from[$result[0]->distance_form] = "selected = selected";

                        ?>

                        <select name="distance_form" id="select_box" class="distance_from change-xhttp-request half-text text_input filter_required " data-errors="{filter_required:' Please select discount type'}" <?php if(@$result[0]!=''){?> disabled<?php }?> tabindex="2">


                            <option disabled="" selected="" value=""> Select option </option>

                            <option value="1" <?php echo $selected_distance_from[1];?>>Home</option>     

                                <?php  



                                if(count(@$get_data)>0){
                                   foreach($get_data as $value){ 

                                        if(in_array($value->report_id, $result_dis_from) ){ ?>
                                                                        

                                  <option value="<?php echo $value->report_id; ?>"<?php echo @$selected_distance_from[$value->report_id]; ?>><?php echo $value->medical_store_name; ?> </option>
                                   <?php  }}}?>


                        </select>
                    </div>
                </div>

                <div class="left-text discount_text">
                    <div class="labels">
                        <label for="distance">Distance (KM)</label>
                    </div>
                </div>
                
                
                <div class="right_text discount_right_text">
                    <div class="text_box">
	                    <div class="input">
                              
                           <input type="text" name="distance" value="<?php echo $result[0]->distance;?>" id="distance" class="filter_required filter_number text_input" data-errors="{filter_required:'Distance should not be blank.',filter_number:'Distance only allowed number.'}" <?php if(@$result[0]!=''){?> disabled<?php }?> tabindex="3"/> 
		                </div>
	                </div>
                </div> 
                   
                            
                
                 <div class="left-text discount_text">
                    <div class="labels">
                        <label for="feedback">Feedback</label>
                    </div>
                </div>
                
                <div class="right_text discount_right_text">
                    <div class="text_box">
	                	<div class="input">
                         
                            <textarea type="text" name="feedback" value="<?php echo $result[0]->report_feedback;?>" id="report_feedback" class="filter_required address_area" data-errors="{filter_required:'Feedback should not be blank.'}" <?php if(@$result[0]!=''){?> disabled<?php }?> tabindex="5"><?php echo $result[0]->report_feedback;?></textarea>
		                </div>
	                </div>                      
                </div> 
                   
                <?php if(!@$result[0]){?> 
                <div class="add_discounts">
       
                    <input type="hidden" name="submit_form" value="form">
                    <input class="save_button form-xhttp-request small" id="save_button" data-href="{base_url}ms-admin/clg/report_operation" data-qr="<?php if(@$result[0]){?>action=edit<?php }else{?>action=add<?php }?>&amp;output_position=content&amp;all_data=true&amp;<?php if($result[0]){  ?>report_id[0]=<?php echo base64_encode($result[0]->report_id);?>&amp;page_number=<?php echo @$page_number;?><?php }?>" type="button" name="add_discount" value="Save"/>
                </div>
                <?php  }?>
       
               
            </div> 
            
            <button type="button" id="boxClose" data-href="{base_url}ms-admin/sms/sms_add_view" data-qr="output_position=popup_content&amp;usr_ref_id=<?php echo base64_encode($value->dis_usr_ref_id);?>">close</button>
        </form>

</div>

<?php }?>

