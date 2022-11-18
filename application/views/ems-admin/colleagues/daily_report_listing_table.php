
<?php $CI = MS_Controller::get_instance(); 

$arr=array(
            'page_no'=>@$page_number,
            'records_per_page'=>count(@$dist_data),                     
            'select_users'=>@$select_users,
            'page_limit'=>@$page_limit,   
                    
          );

if(isset($post_data['filter']) && $post_data['filter']!=''){ 
  $arr[$post_data['filter']] = @$post_data[$post_data['filter']];  
  $arr['filter'] = $post_data['filter'];
  
}

$data =base64_encode(json_encode($arr));
$count_record = count(@$dist_data);



if(count(@$date)>0){
    foreach($date as $key=>$value){  
       $arr[$key] = $value;
    }
}

if(@$post_data['month']!=''){
    $dmy = @$post_data['month'];
}else if(@$post_data['year']!=''){
    $dmy = @$post_data['year'];
}else if(@$post_data['day']!=''){
    $dmy = date("j\<\s\u\p\>S\<\/\s\u\p\> M Y", strtotime(@$post_data['day']));
}else if(@$post_data['day']!=''){
    $dmy = @$post_data['day'];
}else if(@$post_data['week']!=''){
    $dmy = date("j\<\s\u\p\>S\<\/\s\u\p\> M Y", strtotime(unserialize(base64_decode(@$post_data['week']))['start']))."  to  ".date("j\<\s\u\p\>S\<\/\s\u\p\> M Y", strtotime(unserialize(base64_decode(@$post_data['week']))['end']));
}
 
    
if(!@$date){
   $dmy = date("j\<\s\u\p\>S\<\/\s\u\p\> M Y", strtotime(date("Y-m-d")));  
}


?> 
 <div id="daily_list_table">
            
        <table class="table report_table">

            <tr>
                <th><input type="checkbox" title="Select All Users" name="selectall" class="base-select daily_ch" data-type="default"></th>
                <th nowrap>Sales Person</th>
                <th>Medical Store</th>
                <th nowrap>Distance (KM)</th>
                <th nowrap>Date</th>
            </tr>

                <?php 
                if(count(@$dist_data)>0){
                        
                $total = 0;
                foreach($dist_data as $value){ ?>
                      
                    <tr>
                        <td nowrap><input type="checkbox" data-base="selectall" class="base-select" name="report_id[<?= $value->report_id; ?>]" value="<?=base64_encode($value->report_id);?>" title="Select All Discount"/></td>
                                <?php $sales_person_name = $value->clg_first_name . " ".$value->clg_last_name;?>
                        <td><?php echo $sales_person_name;?></td>
                        <td>
                            <a href="<?php echo base_url();?>ms-admin/clg/daily_report_action_view" data-qr="output_position=popup&amp;page_number=<?php echo @$page_number;?><?php if(!@$date_of_report){ ?>&amp;report_date_filter=true<?php }?>&amp;filter_data= <?php echo $data; ?>&amp;clg_ref_id=<?php echo base64_encode($value->clg_ref_id)?>&amp;daily_report=true&amp;records_per_page=<?php echo @$report_load_count;?>" class="view_link onpage_popup view_cpn_code" data-popupwidth="900" data-popupheight="700">View</a>

                        </td>

                        <td>
                            <?php foreach(@$sum_of_distance as $dist){ 

                                 if($dist->clg_ref_id == $value->clg_ref_id){
                                    echo $dist->distance; ?>&nbsp;KM

                                   <?php  }
                                }
                                ?>  
                        </td>

                            <?php  $date = $value->date_of_report;?>

                        <td><?php   if(count(@$dist_data)>0){

                                        foreach($dist_data as $rp_date){

                                            if($rp_date->clg_ref_id == $value->clg_ref_id){ 

                                                $date = $rp_date->date_of_report;         

                                                echo $dmy;
                                            }
                                       }
                                    }?>

                        </td>

                    </tr>
                <?php } ?>
                    
                <?php }else{  ?>


                    <tr><td colspan="9" class="no_record_text">No history Found</td></tr>


                 <?php } ?>   


                </table>
            
                <div class="pagination"> <?php echo $pagination; ?></div>
                 
                <div class="float_right">
                      <span> Total Daily Report: <?php if(@$total_count){ echo @$total_count; }else{ echo"0";}?> </span>
               </div>
      
</div>
