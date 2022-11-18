<?php
    $CI = GB_Controller::get_instance();
    $language = get_language();
?>

<table class="table report_table">
        <tr>
            <th><input type="checkbox" title="Select All Colleagues" name="selectall" class="base-select" data-type="default"></th>
            <th nowrap>Clg. Ref. Id</th>
            <th nowrap>Clg. Name</th>
            <th nowrap>Commission For</th>
            <th nowrap>Source Id</th>
            <th nowrap>Rate Type</th>
            <th nowrap>Rate</th>
            <th nowrap>Price</th>
            <th nowrap>Date</th>
            <th nowrap>Is Paid</th>
            <th nowrap>Paid Date</th>
             <th nowrap>Payment By</th>
                    <th nowrap>Bank & Account</th>
        </tr>


        <?php if(@$earn_list){

                foreach($earn_list as $earn){
                   ?>
        <tr>
             <td><input type="checkbox" data-base="selectall" class="base-select" name="id[<?= $earn->commission_source_id; ?>]" value="<?= base64_encode($earn->commission_source_id); ?>" title="Select Colleague"/></td>

            <td nowrap><?=$earn->clg_ref_id?></td>
            <td nowrap><?php echo ucwords($earn->clg_first_name)." ".ucwords($earn->clg_last_name) ;?></td>
            <td nowrap  class="text_align_center"><?=$earn->commission_from?></td>
            <td nowrap><?php echo $earn->commission_source_id;
                            if(get_data($earn->usr_first_name,$language) !=""){
                                echo "</br>(".ucwords(get_data($earn->usr_first_name,$language))." ".ucwords(get_data($earn->usr_last_name,$language)).")";
                            }
                            ?>
            </td>
            <td nowrap><?=$earn->commission_rate_type?></td>
            <td nowrap><?=$earn->commission_rate?></td>
            <td nowrap><?=$earn->commission_prize?></td>
            <td nowrap><?=$earn->commission_date?></td>
            <td nowrap><?php if($earn->is_paid == 0){echo "Unpaid";}else{echo "Paid";} ?></td>
            <td nowrap><?=$earn->paid_date?></td>
             <td nowrap><?php if($earn->payment_by){ echo $earn->payment_by;}else{echo "NA";}?></td>
                   
                <?php if($earn->payment_account !=""){
                              $res_acc=  explode(":",$earn->payment_account );
                     }?>
                     
            <td nowrap><?php if($earn->payment_account !=""){echo @$res_acc[0]."</br>".$res_acc[1];}else{echo "NA";}?></td>
        </tr>
        <?php
                }
        }else{ ?>
        <tr>
            <td colspan="13"  class="text_align_center">There is no record available for your search !!!</td>
        </tr> 
      <?php  }
    ?>



    </table> 


<div class="pagination">
    <?php  echo $pagination; ?>
</div>
