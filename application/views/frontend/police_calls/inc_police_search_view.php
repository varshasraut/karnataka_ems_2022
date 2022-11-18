
<div class="filed_input width1 float_left">
    <div class="radio_button_div">
        <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  onchange="on_change_incident_search()" type="radio" name="incident" value="incident_search"  class="" data-errors="{}" TABINDEX="14"  <?php echo $view; ?>> Incident Search
    </div>

    <div class="radio_button_div">
        <input data-base="<?= @$current_data[0]->clg_ref_id ?>"   onchange="on_change_manual_call()" type="radio" name="incident" value="manual_call"   class="" TABINDEX="15"  <?php echo $view; ?>> Manual Call 
    </div>

</div>


<script>

    function  on_change_incident_search() {
        xhttprequest($(this), base_url + 'police_calls/police_incident_search', 'f_id=' + '1');
    }

    function  on_change_manual_call() {
        xhttprequest($(this), base_url + 'police_calls/police_manual_call', 'f_id=' + '1');
    }
</script>