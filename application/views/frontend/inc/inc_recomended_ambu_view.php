<style>
.tbl th, td {
  border: 1px solid black;
  
}
</style>
<div>
<table class="tbl" style="border-bottom:none; width:95%;" >

<?php 

foreach(array_chunk($amb_type_list,4,true) as $amb_type_inner_list){
   ?> <tr> <?php
foreach($amb_type_inner_list as $amb_type){ 
     
if(is_array($ambu_type_data)){ 
     $class = "";
     foreach( $ambu_type_data as $amb_tp){
         if($amb_type->ambt_id == $amb_tp){
            $class = "checked";
         }
        }
}else{ 
    $class = "";
}
    ?>

    <td>
    <label for="amb_type_<?php echo $amb_type->ambt_id; ?>" class="chkbox_check">
   <input type="checkbox" name="amb_type[]" class="check_input amb_type_checkbox" value="<?php echo $amb_type->ambt_id; ?>"  id="amb_type_<?php echo $amb_type->ambt_id; ?>" <?php echo $class;?>  data-base="ques_btn" >
            <span class="chkbox_check_holder"></span><?php echo $amb_type->ambt_name; ?><br>
        </label>
        <?php //echo $amb_type->ambt_name;?>
    </td>
<?php
 $class="" ; }  ?> <?php
}
?>
 <td>
        <label for="amb_status" class="chkbox_check">
                    <input type="checkbox" name="amb_status[]" class="check_input amb_status_checkbox" value="2"  id="amb_status" data-base="ques_btn" >
            <span class="chkbox_check_holder"></span>Busy<br>
        </label>
        
    </td>
    </tr> 
    
</table>
<input type="hidden" value="<?php echo $rec_ambu_type;?>" name="incient[inc_suggested_amb]">
</div>