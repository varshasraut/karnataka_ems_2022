                        <select id="cluster_id" name="clg[cluster_id][]"  class="filter_required" data-errors="{filter_required:'Cluster should not blank'}" TABINDEX="7"  <?php echo $view; ?>  multiple="multiple">

                            <option value="">Select Cluster</option>
                           
                            <?php  echo get_cluster('',$po_id);?>
                        </select>