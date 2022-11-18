    <select id="audit_date" name="audit_date" class="filter_required" data-errors="{filter_required:'Audit Date should not blank'}" TABINDEX="7" data-href="{base_url}erc_reports/load_amb_audit_date" data-qr="output_position=content&amp;module_name=reports" >

                            <option value="">Select Date</option>
                            <?php if($ambulance){
                               foreach($ambulance as $amb_date){
                                   ?>
                            <option value="<?php echo $amb_date->current_audit_date;?>"><?php echo $amb_date->current_audit_date;?></option>
                            <?php
                               } 
                            }?>
                        </select>