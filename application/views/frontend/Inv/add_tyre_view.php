<?php
$ftype='';
if($action=='view'){ $ftype='disabled'; }

(empty($item[0]))? $href="add_tyre" : ($href="edit_tyre") && ($data_qr.="tyre_id_new=".$item[0]->tyre_id_new."&amp;action=edit_tyre");
// var_dump($data_qr);
?>


<div class="width1 float_left">
        
    <form action="#" method="post" id="">
        
     <div class="width1 float_left">
          
          <h2 class="txt_clr2 width1 txt_pro hheadbg"> <?php echo ucfirst($action); ?> Tyre Item</h2>
        
            
            
        
                
                <div class="field_row">

                    <div class="field_lable">
                        
                        <label>Tyre Name<span class="md_field">*</span> :</label>
                        
                    </div>
                    
					<div class="filed_input">
                        
					   <input type="text" name="tyre_title" tabindex="1" value='<?php echo stripslashes(trim($item[0]->tyre_title));?>' class="filter_required" data-errors="{filter_required:'Item name should not be blank'}" <?php echo $ftype;?> >
                       
				   </div>

                </div>
                
                <div class="field_row">

                    <div class="field_lable">

                        <label>Set Minimum Quantity<span class="md_field">*</span> :</label>

                    </div>
                    
					<div class="filed_input">
                        
					   <input type="text" name="tyre_base_qty" tabindex="2" value="<?php echo $item[0]->tyre_base_quantity;?>"  class="filter_required filter_no_whitespace filter_number" data-activeerror="" data-errors="{filter_required:'Item minimum should not be blank','filter_number':'Item minimum should be in numbers',filter_no_whitespace:'Item minimum should not be allowed blank space.'}" <?php echo $ftype;?>>
                       
				   </div>

                </div>
                
                
                <!--<div class="field_row">

                    <div class="field_lable">
                        
                         <label>Unit Type<span class="md_field">*</span> : </label>
                         
                    </div>
                    
                    <div class="filed_input"> 
                        
                        <select id="classification" name="inv_unit" tabindex="3" class="filter_required"  data-errors="{filter_required:'Please select item unit'}" <?php echo $ftype;?> >
                            
                                <option value="" selected="" disabled>Type</option>

                                <?php echo get_unit($inv_type,$item[0]->inv_unit); ?>

                        </select>

                    </div>

                </div>-->
                <div class="field_row">
                    
                    <div class="field_lable">
                        <label>Manufacture Name :</label>
                    </div>
                   
                    <div class="filed_input">
                        <?php $type ='2'; ?>
                       <select  name="tyre_manid" tabindex="4" class=""  data-errors="" <?php echo $ftype;?>>

                                        <option value="" selected="" disabled>Manufacture</option>

                                        <?php echo get_man_tyre($type,$item[0]->tyre_manufacture); ?>


                        </select>

                    </div>

                </div>
                <div class="field_row">

                    <div class="field_lable">
                        
                         <label>Manufacture Date <span class="md_field">*</span> : </label>
                         
                    </div>
                    
                    <div class="filed_input"> 
                        <?php
                       
                        if( $item[0]->tyre_manufacturing_date != '' && $item[0]->tyre_manufacturing_date != 0000-00-00 ){ 
                              
                            $manu_date =  date('Y-m-d', strtotime($item[0]->tyre_manufacturing_date));    
                        }
                        ?> 
                        <input id="tyre_manufacturing_date" name="tyre_manufacturing_date" class="form_input mi_calender filter_required" data-errors="{filter_required:'Please select Manufacture date from date format'}" value="<?php echo $manu_date; ?>" class="mi_calender" type="text" tabindex="3" <?php echo $ftype;?>>

                    </div>

                </div>

                <div class="field_row">

                    <div class="field_lable">
                        
                         <label>Expiry Date : </label>
                         
                    </div>
                    
                    <div class="filed_input"> 
                         <?php if( $item[0]->tyre_exp_date != '' && $item[0]->tyre_exp_date != 0000-00-00 ){ 
                            $tyre_exp_date=  date('Y-m-d', strtotime($item[0]->tyre_exp_date));    
                        }
                        ?> 
                        <input id="tyre_exp_date" name="tyre_exp_date" value="<?php echo $tyre_exp_date; ?>" class="form_input mi_calender " data-errors="{filter_required:'Please select Expiry date from date format'}" type="text" tabindex="3" <?php echo $ftype;?>>

                    </div>

                </div>

                    
                <?php if($ftype!='disabled'){ ?>
                    
                <div class="width2 margin_auto">
                      
                    <div class="button_field_row">
                 
                        <div class="button_box">

                            <input type="hidden" name="submit_inv" value="sub_inv">

                            <input type="button" name="submit" id="btnsave" value="Submit" class="btn submit_btnt form-xhttp-request" data-href="{base_url}inv/<?php echo $href;?>" data-qr="<?php echo $data_qr;?>">

                            <input type="reset" name="Reset" value="Reset" class="btn">

                        </div>
                           
                    </div>
                </div>
                    
                <?php } ?>

            
          
        </div>
                
    </form>
    
</div>

<script>;
    jQuery(document).ready(function () {

        var dateFormat = "mm/dd/yy",
                from = jQuery("#tyre_manufacturing_date")
                .datepicker({
                    defaultDate: new Date(),
                    changeMonth: true,
                    changeYear: true,
                    numberOfMonths: 1
                })
                .on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#tyre_exp_date").datepicker({
            defaultDate:  new Date(),
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1
        })
                .on("change", function () {
                    from.datepicker("option", "maxDate", getDate(this));
                });

        function getDate(element) {
            var date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }
            return date;
        }
    });

</script>