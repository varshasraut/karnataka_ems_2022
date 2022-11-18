<?php 
$imgvideo_path = $photo_data[0]->imgvideo_path;
$image = explode(',', $imgvideo_path);
?>
<div class="with100">
<?php
if($image){
foreach($image as $img){
    
     $pic_path = FCPATH . "api/incidentData/" . $img;
    ?>
  <a class="ambulance_photo" target="blank" href="<?php
                                    if (file_exists($pic_path)) {
                                        echo $pic_path1;
                                    } 
                                    ?>" style="background: url('<?php
                                    if (file_exists($pic_path)) {
                                        echo $pic_path1;
                                    } 
                                    ?>') no-repeat left center; background-size: contain; float:left; margin:5px;"  <?php echo $view; ?>></a>
<?php
}
} 
?>
</div>