  <select name="amb_type" class="" data-errors="{filter_required:'Ambulance type should not be blank'}" <?php echo $view; ?> TABINDEX="5" readonly="readonly" >

                                    <option value="" >Select Type</option>
                                    <?php echo get_amb_type($ambt_name); ?>
                            </select>