
<div class="filed_input width100 float_left padding_btm_10">
    <div class="radio_button_div">
        <input id="mySelect"  onchange="on_change_incident_search();" type="radio" name="incident" value="1"  > Incident Search
    </div>

    <div class="radio_button_div">
        <input   id="manual_calls"     onchange="on_change_manual_call()" type="radio" name="incident" value="<?php echo $comp_type ?>"> Manual Call 
    </div>

</div>

<script>

    function  on_change_incident_search() {
        var $val = document.getElementById("mySelect").value;
        if ($val = 1) {

            xhttprequest($(this), base_url + 'grievance/show_manual_inc_search', 'f_id=' + '1');
            $('#grivience_info').html('');
        }
    }

    function  on_change_manual_call() {
        var $val = document.getElementById("manual_calls").value;

        if ($val) {
            console.log($val);
            xhttprequest($(this), base_url + 'grievance/grievance_call', 'f_val=' + $val);
            $('#grivance_inc_filter').html('');
            $('#inc_details').html('');
        }
    }
</script>