<div class="width100 dls">
    <strong>Hospital name</strong> : <?php echo $hospital[0]->hp_name;?><br>
    <strong>Mobile No</strong> : <?php echo $hospital[0]->hp_mobile;?><br>
    <strong>Address</strong> : <?php echo $hospital[0]->hp_address;?>, <?php echo $hospital[0]->cty_name;?>, <?php echo $hospital[0]->thl_name?>, <?php echo $hospital[0]->dst_name?>
    <input type="hidden" value="<?php echo $hospital[0]->hp_address;?>" class="new_hos_address" name="new_hos_address">
    <input type="hidden" value="<?php echo $hospital[0]->hp_lat;?>" class="new_hos_lat" name="new_hos_lat">
    <input type="hidden" value="<?php echo $hospital[0]->hp_long;?>" class="new_hos_lng" name="new_hos_lng">
    
    
    <!--<script>get_new_hospital_ambulance();</script>-->
</div>