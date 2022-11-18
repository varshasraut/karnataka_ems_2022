<?php
    $CI = GB_Controller::get_instance();
    $language = get_language();
?>

 
<div class="permission_list">
    
    <h3 class="txt_clr5">Colleagues Earn Listing</h3>
    <div id="sales_pay_id"></div>
<form method="post" action="#" id="clg_earn_form">

    <div class="row">
        <?=$CI->modules->get_tool_html('MT-CLG-TOTAL-PMNT',$CI->active_module,'form-xhttp-request float_left');?>
        <div id="clg_total_pmnt"></div>   
        <input type="button" class="search_button form-xhttp-request" name="search" style="float:right;" value="Search" data-href="{base_url}gb-admin/colleagues/search_colleague_earn" data-qr="module_name=colleagues&amp;tlcode=MT-CLG-SEARCH_EARN&amp;output_position=search_colleague_earn_table"/>
       
        <?php if($CI->session->userdata('current_user')->clg_group == 'UG-ADMIN'  || $this->session->userdata('current_user')->clg_group == 'UG-ACCOUNT'){ ?>
        
        <input type="text" name="clg_ref_id" value="" placeholder="Colleague Ref. Id" style="width:12%;float:right;padding-left:10px;"/>    
        <?php } ?>
      
        <?php // if($CI->session->userdata('current_user')->clg_group == 'UG-SLS'){ ?>
        
        
               <select id="payment_status" name="payment_status"  data-errors="{filter_required:'Please select payment status'}"  style="width:13%;padding-left:10px;float:right;margin-right:10px;">
                        <option value=""  >Payment Status</option>
                        <option value="1" <?=$status_select['1']?> >Paid</option>
                        <option value="0"  <?=$status_select['0']?> >Unpaid</option>
                </select>
              
               <input type="text"  name="date_to"      placeholder="Date To"  class="mi_calender clg_date_textbox  " style="width:10%;margin:0 10px 0 0 ;" >
                             
                   <input type="text"  name="date_from"      placeholder="Date From"  class="mi_calender clg_date_textbox "  style="width:10%;margin:0 10px 0 0 ;" >             
        <?php // } ?>

    </div>

    <div id="search_colleague_earn_table">    
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
                    <th nowrap> Date</th>
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
                    <td nowrap ><?=$earn->commission_rate?></td>
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
                <tr><td colspan="13" class="text_align_center"> No record found</td></tr> 
              <?php  }
            ?>



            </table> 
        
        
        <div class="pagination">
            <?php  echo $pagination; ?>
        </div>
        
    </div>    
</form>
</div>
