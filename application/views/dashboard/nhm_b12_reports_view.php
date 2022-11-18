<style>
    .report_table{
       
        font-size: 10px;
        background-color: #db9b66;
        overflow: hidden;
    }
    .report_table tr {
        line-height: 6px; 
        height: 6px;
        color: white;
       
    }
    .report_table td {
        line-height: 2px; 
        height: 2px;
        color: #0d0f11;
       
    }
    .table_overrode_margin{
        margin:0px;
    }
    .report_table th{
        background-color: #4a5661;
        border: 1px solid black;
  border-collapse: collapse;
    }
    .table-wrap {
    height: 80px;
    overflow-y: auto;
  }

    </style>
<table class="table report_table table_overrode_margin table-wrap table-bordered" >
<tr > <th style="text-align:center;font-size: 10px;" colspan="3" scope="col">108 Emergency Type Wise Patient Served</th>
</tr>
<tr>   <?php 
        foreach ($header as $heading) 
        { 
        ?>
         
        <th style="text-align:center;font-size: 10px;"><?php echo $heading; ?></th>
        <?php 
        }
        ?>
    </tr>
    
    <?php 
    $medical = 0;
    $other = 0;
    $assault = 0;
    $poision = 0;
    $light = 0;
    $trauma = 0;
    $traumanon = 0;
    $attack = 0;
    $suicide = 0;
    $burn = 0;
    $mass = 0;
    $labour =0;
    if(is_array($inc_data)){
        foreach ($inc_data as $inc) {
            //var_dump($inc['medical']); ?>
        <tr>  
            <td><b><?php echo 'Medical' ?></b></td>
            <td style="text-align:center;"><?php echo $inc['medical']; $medical = $medical + $inc['medical']; ?></td>
            <td  style="text-align:center;"><?php echo $inc['medical_till']; $medical_till = $medical_till + $inc['medical_till']; ?></td>
            
        </tr>
        <tr>    
            <td><b><?php echo 'Other' ?></b></td>
            <td  style="text-align:center;"><?php echo $inc['other']; $other = $other + $inc['other']; ?></td>
            <td  style="text-align:center;"><?php echo $inc['other_till']; $other_till = $other_till + $inc['other_till']; ?></td>
        </tr>
        <tr>    
            <td><b><?php echo 'Assault' ?></b></td>
            <td  style="text-align:center;"><?php echo $inc['assault']; $assault = $assault + $inc['assault']; ?></td>
            <td  style="text-align:center;"><?php echo $inc['assault_till']; $assault_till = $assault_till + $inc['assault_till']; ?></td>
        </tr>
        <tr>   
            <td><b><?php echo 'Labour/ Pregnancy' ?></b></td>
            <td  style="text-align:center;"><?php echo $inc['labour']; $labour = $labour + $inc['labour']; ?></td>
            <td  style="text-align:center;"><?php echo $inc['labour_till']; $labour_till = $labour_till + $inc['labour_till']; ?></td>
        </tr>
        <tr>   
            <td><b><?php echo 'Intoxication/Poisoning' ?></b></td>
            <td  style="text-align:center;"><?php echo $inc['poision']; $poision = $poision + $inc['poision']; ?></td>
            <td  style="text-align:center;"><?php echo $inc['poision_till']; $poision_till = $poision_till + $inc['poision_till']; ?></td>
        </tr>
        <tr>   
            <td><b><?php echo 'Lighting/Electrocution' ?></b></td>
            <td  style="text-align:center;"><?php echo $inc['light']; $light = $light + $inc['light']; ?></td>
            <td  style="text-align:center;"><?php echo $inc['light_till']; $light_till = $light_till + $inc['light_till']; ?></td>
        </tr>
        <tr >   
            <td><b><?php echo 'Trauma (Vehicle)' ?></b></td>
            <td  style="text-align:center;"><?php echo $inc['trauma']; $trauma = $trauma + $inc['trauma']; ?></td>
            <td  style="text-align:center;"><?php echo $inc['trauma_till']; $trauma_till = $trauma_till + $inc['trauma_till']; ?></td>
        </tr>
        <tr>    
            <td><b><?php echo 'Trauma (Non-Vehicle)' ?></b></td>
            <td  style="text-align:center;"><?php echo $inc['traumanon']; $traumanon = $traumanon + $inc['traumanon']; ?></td>
            <td  style="text-align:center;"><?php echo $inc['traumanon_till']; $traumanon_till = $traumanon_till + $inc['traumanon_till']; ?></td>
        </tr>
        <tr>    
            <td><b><?php echo 'Animal Attack' ?></b></td>
            <td  style="text-align:center;"><?php echo $inc['attack']; $attack = $attack + $inc['attack']; ?></td>
            <td  style="text-align:center;"><?php echo $inc['attack_till']; $attack_till = $attack_till + $inc['attack_till']; ?></td>
        </tr>
        <tr>  
            <td><b><?php echo 'Suicide/Self Inflicted Injury' ?></b></td>
            <td  style="text-align:center;"><?php echo $inc['suicide']; $suicide = $suicide + $inc['suicide']; ?></td>
            <td  style="text-align:center;"><?php echo $inc['suicide_till']; $suicide_till = $suicide_till + $inc['suicide_till']; ?></td>
        </tr>
        <tr>   
            <td><b><?php echo 'Burn' ?><b></td>
            <td  style="text-align:center;"><?php echo $inc['burn']; $burn = $burn + $inc['burn']; ?></td>
            <td  style="text-align:center;"><?php echo $inc['burn_till']; $burn_till = $burn_till + $inc['burn_till']; ?></td>
        </tr>
        <tr>   
            <td><b><?php echo 'Mass casualty' ?></b></td>
            <td  style="text-align:center;"><?php echo $inc['mass']; $mass = $mass + $inc['mass']; ?></td>
            <td  style="text-align:center;"><?php echo $inc['mass_till']; $mass_till = $mass_till + $inc['mass_till']; ?></td>
        </tr>
        <?php }}?>
        <tr>           
            <td><b>Total</b></td> 
            <td  style="text-align:center;"><b><?php echo $medical + $other + $assault + $labour + $poision + $light + $trauma + $traumanon + $attack + $suicide + $burn + $mass; ?></b></td>
            <td  style="text-align:center;"><b><?php echo $medical_till + $other_till + $assault_till + $labour_till + $poision_till + $light_till + $trauma_till + $traumanon_till + $attack_till + $suicide_till + $burn_till + $mass_till ; ?></b></td>
        </tr>
</table>