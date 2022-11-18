
<div class="filed_input width100 float_left padding_btm_10">
    <div class="radio_button_div">
        <input  id="inc_srh"   onchange="on_change_incident_search();" type="radio" name="incident" value="1"  > Incident Search
    </div>

    <div class="radio_button_div">
        <input  id="man_srh"  onchange="on_change_manual_call();" type="radio" name="incident" value="<?php echo $comp_type; ?>"  > Manual Call 
    </div>

</div>

<script>

    function  on_change_incident_search() {
      
//        xhttprequest($(this), base_url + 'grievance/show_inc_search', 'f_id=' + '1');
        
         var $val = document.getElementById("inc_srh").value;
        if ($val = 1) {

            xhttprequest($(this), base_url + 'grievance/show_inc_search', 'f_id=' + '1');
            $('#grivience_info').html('');
        }
    }

    function  on_change_manual_call() {
    
//        xhttprequest($(this), base_url + 'grievance/grievance_auto_manual_call', 'f_id=' + '1');
        
         var $val = document.getElementById("man_srh").value;
        if ($val ) {
            xhttprequest($(this), base_url + 'grievance/grievance_auto_manual_call', 'f_val=' + $val);
            $('#grivance_inc_filter').html('');
            $('#inc_details').html('');
        }
    }
</script>