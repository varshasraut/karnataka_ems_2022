<?php

foreach($media as $med){
$name = $med['media_name'];
$img_id = $med['img_id'];
                   $pic_path = FCPATH . "uploads/ambulance/" . $name;

                                                    if (file_exists($pic_path)) {
                                                        $pic_path1 = base_url() . "uploads/ambulance/" . $name;
                                                    }
                                                    $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
            ?><div class="images_block" id="image_<?php echo $img_id;?>">
                <input type="hidden" name="upload_images[]" value="<?php echo $img_id;?>">
                                    <a class="remove_images click-xhttp-request" style="color:#000;" data-href="<?php echo base_url();?>ambulance_maintaince/remove_images" data-qr="id=<?php echo $img->id; ?>&output_position=image_<?php echo $img_id;?>"></a>
                                    <a class="ambulance_photo" target="blank" href="<?php
                                    if (file_exists($pic_path)) {
                                        echo $pic_path1;
                                    } else {
                                        echo $blank_pic_path;
                                    }
                                    ?>" style="background: url('<?php
                                    if (file_exists($pic_path)) {
                                        echo $pic_path1;
                                    } else {
                                        echo $blank_pic_path;
                                    }
                                    ?>') no-repeat left center; background-size: cover; height: 100px; width:150px; float:left;"  <?php echo $view; ?>></a>
                                    
                                    <?php } ?>