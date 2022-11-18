<?php
$CI = EMS_Controller::get_instance();
?>
<div class="breadcrumb">
  <ul>
    <li class="backup"><a href="{base_url}/database/backup">Database</a></li>
    <li><span>Backup</span></li>
  </ul>
</div>
<br/>
<div class="box3">
  <div class="permission_list group_list">
    <h3 class="txt_clr5"> Database Listing</h3>
   
     <div id="add_group">
     
     </div>

   <form method="post" action="#" class="">
       <div class="row">
       <?php if(@$last_download_details){ ?>
           <h3 class="txt_clr5"> Date and Time : <span style="font-weight:normal;"> <?php  echo $CI->time_date(strtotime($last_download_details['time']),TRUE,TRUE);?> </span></h3>
           <h3 class="txt_clr5"> File Name :<span style="font-weight:normal;"> <?php echo $last_download_details['filename'];?></span></h3>
                <h3 class="txt_clr5"> Download By : <span style="font-weight:normal;"><?php echo $last_download_details['download_by'];?></span></h3>
       <?php }
       ?>
       </div>
      <div class="row">
      <?php //$CI->modules->get_tool_html('MT-BKUP-DELETE',$CI->active_module,'form-xhttp-request delete_button');?>
      <?php //$CI->modules->get_tool_html('MT-BKUP-GENERATE',$CI->active_module,'form-xhttp-request top_ancher');?>
    </div>
    <table class="table report_table">
       
        <tr>
            <th><input type="checkbox" title="Select All groups" name="selectall" class="base-select" data-type='default' /></th>
            <th>Files Name</th>
            <th>Creation Time</th>
            <th>Size</th>
            <th>Actions</th>
        
        </tr>
       
     <?php
     if(!empty($files_list)){
     foreach ($files_list as $key=>$filename):
	
	 ?>
      <tr>
            <td><input type="checkbox"  title="Select All Id" data-base="selectall"  value="<?php echo base64_encode($filename);?>" name="filename[<?php echo $key?>]"  class="base-select" ></td>
            <td><?php if (file_exists($filename)) { echo $filename;}?></td>
            <td><?php if (file_exists($filename)) { echo date ("jS M Y H:i:s.", filemtime($filename)); }?></td>
            <td><?php if (file_exists($filename)) {echo $CI->format_byte(filesize($filename));}?></td> 
           <td><?=$CI->modules->get_tool_html('MT-BKUP-DELETE',$CI->active_module,'click-xhttp-request delete_img',"?filename=".base64_encode($filename), "data-confirm='yes' data-confirmmessage='Are you sure to delete ?'");?>
           
               
            <?php if($CI->modules->get_tool_html('MT-BKUP-DOWNLOAD',$CI->active_module,true)!='')
                {
            ?>
            
           <a  class="mt_pcmt_rsm_download" href="{base_url}ms-admin/database/download/<?php echo urlencode(base64_encode($filename));?>"></a>
           
           <?php } ?>
          
           
           
            </td>
      </tr>
      
    <?php endforeach;
     }
    ?>
    </table>
       
       <div class="float_right">
            Total downloads : <?php if(@$total_downloads){  echo $total_downloads; }else{ echo"0";}?>
       </div>
   
    </form>
  </div>
</div>
