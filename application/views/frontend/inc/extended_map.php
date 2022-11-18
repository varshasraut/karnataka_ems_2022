<style>
    #EXTENDED_INCIDENT_MAP{
        position:fixed !important; top:0; bottom:0; right:0; left:0; width:100%; height:100%;
    }
</style>
                 <input id="inc_ext_map_address" placeholder="Enter your address"  type="text" class="width_100 incient" style="border-radius:0px !important; width:50% !important; border:7px solid #4688f1; position: absolute; z-index: 10;" name="incient[place]" TABINDEX="11" data-ignore="ignore" data-state="yes" data-dist="yes" data-rel="incient" data-auto="inc_auto_addr"></input>
 <div class="width_15 float_right min_distance_block">
        <select name="inc_min_distance" id="inc_min_distance" onchange="get_amb_by_distance();">
            <option>Default distance</option>
            <option value="1">1 KM</option>
            <option value="2">2 KM</option>
            <option value="5">5 KM</option>
            <option value="10">10 KM</option>
            <option value="15">15 KM</option>
            <option value="20"> 20 KM</option>
        </select>
</div>
<div id="EXTENDED_INCIDENT_MAP"></div>
<script>
    function get_amb_by_distance(){
        
    var p_lat =  window.opener.$('#add_inc_details #lat').val();
    var p_lng =  window.opener.$('#add_inc_details #lng').val();

    var min_distance = $('#inc_min_distance').val();
    
    var $amb_type = '';
    if( window.opener.$('#inc_ambu_type_details').length >= 1 ){
        $amb_type =  window.opener.$('#amb_type').val();
    }
    var $inc_type =  window.opener.$('#inc_type').val();
     
      window.opener.$('#get_ambu_details').attr('href',base_url+'inc/get_inc_ambu?inc_type='+$inc_type+'&amb_tp='+$amb_type+'&lat='+p_lat+'&lng='+p_lng+'&min_distance='+min_distance);
    
     window.opener.$("#get_ambu_details").click();
}
//update_ambulance_inc_ext_map();
</script>