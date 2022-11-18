
                         <select id="caller_relation" name="caller[cl_relation]" class="filter_required has_error" data-errors="{filter_required:'Caller relation should not be blank'}" <?php echo $view; ?> TABINDEX="1.3" data-qr="output_position=inc_details&amp;module_name=calls&amp;showprocess=no" data-href="{base_url}calls/save_call_details" onchange="submit_caller_form()">
                                <option value="">Select Relation</option>
                                <?php echo get_relation(); ?>
                            </select>