<table class="table report_table">

    <tr>                              
        <?php foreach ($header as $heading) { ?>
            <th style="line-height: 20px;"><?php echo $heading; ?></th>
            <?php } ?>
    </tr>
    <?php
    $count = 1;
    //var_dump($inc_data);die();
    foreach ($inc_data as $inc) {
        //  $count = 1;
   // var_dump($inc);die();
           if($inc['status']=='1') {
            $amb_status='Active';
           }
           if($inc['status']=='2') {
            $amb_status='In-Active';       
            }
?>

        <tr>         
            <td><?php echo $count; ?></td> 
            <td><?php echo $inc['Ambulance_no']; ?></td>
            <td><?php echo $amb_status; ?></td>
            <td>
                <?php  
                         $thirdparty = '';
            if($inc['third_party'] != ''){
                $thirdparty = get_third_party_name($inc['third_party']);
            }
            echo $thirdparty;
                ?> 
                </td>
             
        </tr>

        <?php
        $count++;
    }
    ?>

</table>