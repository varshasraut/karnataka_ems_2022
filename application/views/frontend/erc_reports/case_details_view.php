
<body>
<table class="table report_table">
        <tr>
            <?php foreach ($header as $heading) { ?>
            <th><?php echo $heading; ?></th>
            <?php } ?>

        </tr>
        <?php foreach ($inc_data as $inc) {
       
       ?>
       <tr>  
            <td></td>
           <td><?php echo $inc['dist_name']; ?></td>
           <td></td>
           <td><?php echo $inc['get_cl_count']; ?></td>
        </tr>
        <?php } ?>
</table>        
</body>