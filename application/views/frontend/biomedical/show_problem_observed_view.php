<div class="table_wrp">
<table class="style5">
    <tr>
        <th class="width40"> Id</th>
        <th>Problem observed</th>
    </tr>
   
        <?php foreach($cons_data as $cons){?>
     <tr>
        <td><?php echo $cons['inv_id'];?></td>
        <td><?php echo $cons['inv_title'];?> </td>
    </tr>
        <?php } ?>

</table>
</div><br>