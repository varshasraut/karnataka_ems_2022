<div class="table_wrp">
    <table class="style5">
        <tr>
            <th> Name</th>	
            <th>Injury Name</th>	
            <th> Action</th>	
        </tr>
        <?php foreach($injury_info as $injury){ ?>
        <tr>
            <td><?=@$injury['side_name'];?></td>	
            <td><?=@$injury['inj_name'];?></td>	
            <td><input type="hidden" value="<?=@$injury['rand_id'];?>" data-base="remove_side_injury_<?=@$injury['rand_id'];?>" name="side_injury_row_id">
          <input name="remove_side_injury_<?=@$injury['rand_id'];?>" value="Remove" class="btn base-xhttp-request red_btn" data-href="{base_url}pcr/remove_side_injury" data-qr="output_position=selected_side_detail" type="button">
            </td>  
        </tr>
        <?php }?>
    </table>
 </div>