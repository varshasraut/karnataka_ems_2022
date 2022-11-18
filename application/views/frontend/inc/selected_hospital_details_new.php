<?php //var_dump($info); 
$hos_id = $hos_details[0]->hp_id; ?>
<input type="hidden" name="incient[hos_id]" value="<?php echo $hos_details[0]->hp_id; ?>"></input><br>  
<input type="hidden" name="incient[hos_name]" value="<?php echo $hos_details[0]->hp_name; ?>"></input><br>
<label id="hlbl"><span style="font-weight:bold;">Hospital Type : </span><?php echo get_hosp_type_by_id_full_name($hos_details[0]->hp_type); ?></label><br>

<style>
    #lbl{
        width: 30%;
        margin: 0px;
        display: inline-block;
    }
    #hlbl{
        display: inline-block;
    }
    #hptlbtn{
        font-size: 12px;
    }
</style>