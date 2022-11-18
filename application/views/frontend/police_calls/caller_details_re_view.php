                        <select id="caller_relation" name="caller[cl_relation]" class="" <?php echo $view; ?> TABINDEX="2" data-qr="output_position=inc_details&amp;module_name=calls&amp;showprocess=no"  data-href="{base_url}calls/save_call_details" onchange="submit_caller_form()">
                            <option value="">Select Relation</option>   
                            <?php echo get_relation($form_data['cl_relation']);?>
                        </select>