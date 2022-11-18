<table class="table report_table">

    <tr>                              
        <?php foreach ($header as $heading) { ?>
            <th style="line-height: 20px;"><?php echo $heading; ?></th>
            <?php } ?>
    </tr>
    <?php
    $count = 1;
    if($inc_data){
    foreach ($inc_data as $inc) {
        //  $count = 1;
    //var_dump($inc);die();
           
?>

        <tr>         
            <td><?php echo $count; ?></td> 
            <td><?php echo $inc['ambt_name']; ?></td>
            <td><?php echo $inc['amb_count']; ?></td>
            <td><?php echo $inc['dispatch_count']; ?> </td>
            <td><?php echo $inc['patient_count']; ?> </td>
            <td><?php echo $inc['amb_count_active']; ?> </td>
     
            
             
        </tr>

        <?php
        $count++;
    } }
    ?>

</table>