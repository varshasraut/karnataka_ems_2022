

<div class="table_wrp">
<table class="style5">
    <tr>
        <th class="width40"> Id</th>
        <th> Title</th>
        <th>Quantity</th>
    </tr>
   
        <?php foreach($cons_data as $cons){ 
           // var_dump($cons);
            ?>
     <tr>
        <td><?php echo $cons['inv_id'];?></td>
        <td><?php echo $cons['inv_title'];?> </td>
        <td><?php echo $cons['inv_qty'];?> </td>
    </tr>
        <?php } ?>

</table>
</div><br>