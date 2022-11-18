<?php
$view = ($action == 'view') ? 'disabled' : '';

if ($action == 'edit') {
    $edit = 'disabled';
}

$CI = EMS_Controller::get_instance();

$title = ($action == 'edit') ? " Edit Ambulance Details " : (($action == 'view') ? "View CQ Details" : "Add CQ Details");
?>
<script src="<?php echo base_url(); ?>assets/js/jquery.multi-select.js"></script> 
<style>
.multi-select-container {
    display: inline-block;
    position: relative;
}

.multi-select-menu {
    position: absolute;
    left: 0;
    top: 0.8em;
    z-index: 1;
    float: left;
    min-width: 100%;
    background: #fff;
    margin: 1em 0;
    border: 1px solid #aaa;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    display: none;
}

.multi-select-menuitem {
    display: block;
    font-size: 0.875em;
    padding: 0.6em 1em 0.6em 30px;
    white-space: nowrap;
}

.multi-select-menuitem--titled:before {
    display: block;
    font-weight: bold;
    content: attr(data-group-title);
    margin: 0 0 0.25em -20px;
}

.multi-select-menuitem--titledsr:before {
    display: block;
    font-weight: bold;
    content: attr(data-group-title);
    border: 0;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
}

.multi-select-menuitem + .multi-select-menuitem {
    padding-top: 0;
}

.multi-select-presets {
    border-bottom: 1px solid #ddd;
}

.multi-select-menuitem input {
    position: absolute;
    margin-top: 0.25em;
    margin-left: -20px;
}

.multi-select-button {
    display: inline-block;
    font-size: 0.875em;
    padding: 0.2em 0.6em;
    max-width: 16em;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    vertical-align: -0.5em;
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 4px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    cursor: default;
}

.multi-select-button:after {
    content: "";
    display: inline-block;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0.4em 0.4em 0 0.4em;
    border-color: #999 transparent transparent transparent;
    margin-left: 0.4em;
    vertical-align: 0.1em;
}

.multi-select-container--open .multi-select-menu {
    display: block;
}

.multi-select-container--open .multi-select-button:after {
    border-width: 0 0.4em 0.4em 0.4em;
    border-color: transparent transparent #999 transparent;
}

.multi-select-container--positioned .multi-select-menu {
    /* Avoid border/padding on menu messing with JavaScript width calculation */
    box-sizing: border-box;
}

.multi-select-container--positioned .multi-select-menu label {
    /* Allow labels to line wrap when menu is artificially narrowed */
    white-space: normal;
}
.disabled_div{
    pointer-events: none;
    opacity: 0.4;
}
.warn{
    border:2px solid red;
    border-radius:5px;
}
</style>


<form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form" style="position:relative; top:0px; bottom:0px;">
<h2 class="txt_clr2 width1 txt_pro"><?php echo $title; ?></h2>
    <div class="joining_details_box">
        <div class="field_row width100" >
            <div class="width2 float_left">
                <div class="field_lable float_left width33"><label for="district">Ambulance Number<span class="md_field">*</span></label></div>
                <div class="filed_input float_left width50">
                <?php if(!$update){ ?>  
                    <select id="cq_ambulance1" name="cq_ambulance1" multiple>
                        <!-- <option value="alice">Alice</option>
                        <option value="bob">Bob</option>
                        <option value="carol">Carol</option> -->
                    </select>
                    <input type="checkbox" id="vehicle1" name="vehicle1">Select All
                    <input type="hidden" id="cq_ambulance" name="cq_ambulance"  value="<?php echo $update[0]->cq_vehicle; ?>" tabindex="1" autocomplete="off">
                    <!-- <div id="cq_ambulance"> -->
                    <?php   
                    
                        // if($update[0]->cq_vehicle == ' ' || $update[0]->cq_vehicle == NULL ){
                        //     $dt = array('st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'cq', 'disabled' => '','amb_ref_no'=>$cq_ambulance);
                        //     echo get_ambulance_cq($dt);
                        }
                        else{
                            ?>
                            <input type="text"   value="<?php echo $update[0]->cq_vehicle; ?>" tabindex="1" autocomplete="off" <?php echo $view; ?>>
                            <?php
                        }
                        
                    ?>

                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div> 
    <div class="field_row width100" >
            <div class="width2 float_left">
                <div class="field_lable float_left width33"><label for="Note">Note<span class="md_field">*</span></label></div>
                <div class="filed_input float_left width60">
                    <textarea name="cq_note" id="cq_note" placeholder="Note" cols="30" rows="5" <?php echo $view; ?> ><?php echo $update[0]->cq_msg; ?></textarea>
                </div>
            </div>
        </div>
<?php
if(!$update){ 
?>
<div class="field_row width100">
        <div class="field_row width100 float_left">
            <div class="field_row width100 float_left">
                <div class="field_lable float_left width33">
                    <label for="photo">Photo</label>
                </div>
                <div class="filed_input outer_clg_photo width100">
                    <div class="images_main_block width1" id="images_main_block">
                        <div class="upload_images_block">
                            <div class="images_upload_block">
                                <input multiple="multiple" type="file" name="amb_photo[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"  <?php echo $view; if($type == 'Rerequest' && $clg_group == 'UG-FLEETDESK'){ echo $mo_rerequest; }else{ echo $rerequest; } ?>  class="files_amb_photo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}else{ ?>
   <div class="filed_input outer_clg_photo width100">
                    <div class="images_main_block width1" id="images_main_block">
                        <div class="upload_images_block">
                            <div class="images_upload_block">
    <?php                                                 
        $name1 = $update[0]->cq_images;
        $name1 = (explode(",",$name1));
       //var_dump($name1);
        foreach($name1 as $img) {
            //var_dump($img);
            $name = $img;
        $pic_path = FCPATH . "api/cq_images_video/" . $name;
        if (file_exists($pic_path)) {
            $pic_path1 = base_url() . "api/cq_images_video/" . $name;
           
        }else{
            $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
        }
        ?>
         <div class="images_block vid_img" id="image_<?php echo $img;?>">
               <a class="ambulance_photo float_left" target="blank" href="<?php
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
            ?>') no-repeat left center; background-size: cover; min-height: 75px;" <?php echo $view; ?>></a>
        <?php } ?>
        </div>
    </div>
    </div>
    </div>
    </div>
    <?php
}
if(!$update){ ?>
 
    <div class="field_row width100">
        <div class="field_row width100 float_left">
            <div class="field_row width100 float_left">
                <div class="field_lable float_left width33">
                    <label for="photo">Video</label>
                </div>
                <div class="images_main_block width1" id="images_main_block">
                    <div class="upload_images_block">
                        <div class="images_upload_block">
                            <input  type="file" name="amb_video[]" accept="image/jpg,image/jpeg,image/png,video/mp4,video/mp3" TABINDEX="18"  <?php echo $view; echo $rerequest; ?> <?php echo $update; ?>  class="amb_files_amb_photo" multiple="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <?php }else{ ?>
   <div class="filed_input outer_clg_photo width100">
                    <div class="images_main_block width1" id="images_main_block">
                        <div class="upload_images_block">
                            <div class="images_upload_block">
    <?php                                                 
        $name1 = $update[0]->cq_video;
        $name1 = (explode(",",$name1));
       //var_dump($name1);
        foreach($name1 as $img) {
            //var_dump($img);
            $name = $img;
        $pic_path = FCPATH . "api/cq_images_video/" . $name;
        if (file_exists($pic_path)) {
            $pic_path1 = base_url() . "api/cq_images_video/" . $name;
           
        }else{
            $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
        }
        ?>
         <div class="images_block vid_img" id="image_<?php echo $img;?>">
               <a class="ambulance_photo float_left" target="blank" href="<?php
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
            ?>') no-repeat left center; background-size: cover; min-height: 75px;" <?php echo $view; ?>></a>
        <?php } ?>
        </div>
    </div>
    </div>
    </div>
    </div>
    <?php
} ?> 
<?php if(!$update){ ?>  
<div class="field_row width100 " style="padding:10px 0" >
    <input type="button" name="submit" value="Submit" onclick="savedata();" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url();?>cq/save_cq' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' >
</div>
<?php } ?>


</form>

<script>
    function savedata(){
        var amb =$('#cq_ambulance1').val();
        if(amb==''||amb==null){
            $('.multi-select-container').addClass('warn');
            false;
        }
        else{
            $('.multi-select-container').removeClass('warn');
        }
        $('#cq_ambulance').val(amb);
        
    }
    $('#cq_ambulance1').blur(function(){
        $('.multi-select-container').removeClass('warn');
    });
    var row;
    $.ajax({
                    url: "<?php echo base_url();?>Cq/view_amb", // link of your "whatever" php
                    type: "POST",
                    async: true,
                    cache: false,
                    data: { },  // all data will be passed here
                    success: function(data){ 
                     
                      var val = JSON.parse(data);
                      var t = val['amb'].length;// The data that is echoed from the ajax.php
                    //   console.log(val);
                    //   console.log(t);
                      for(var i = 0; i < t; i++){
                    //     var d = val[i].length;
                    //       for(var j = 0; j < d ; j++){
                    //             console.log(val[i]);
                                row += "<option value='"+ val['amb'][i].amb_rto_register_no +"'>" + val['amb'][i].amb_rto_register_no +"</option>";
                                 
                                // console.log(row);
                    //       }
                      }
                      
                    },
                });
                $('#cq_ambulance1').append(row);
                // $('#cq_ambulance').append('<option value="1">1</option><option value="2">2</option>');
     $(function(){
        
        $('#cq_ambulance1').multiSelect({
            columns: 1,
            selectAll: true
        });
    });
    $('#cq_note').change(function(){
        // alert($('#cq_ambulance1').val());
        $('.multi-select-container').removeClass('warn');
        var amb =$('#cq_ambulance1').val();
        $('#cq_ambulance').val(amb);
        // alert($('#cq_ambulance').val());
    });

    $('#vehicle1').change(function(){
        if ($('#vehicle1').attr('checked')) {
            $('#vehicle1').attr('checked',false);
            $('input[type=checkbox]').attr('checked',false);
        $('#cq_ambulance1 option').attr('selected', false);
        $('.multi-select-container').removeClass('disabled_div');
        $('.multi-select-button').html('--Select--');
        // alert();
    }else{ $('#vehicle1').attr('checked',true);
        $('#cq_ambulance1 option').attr('selected', false);
        $('#cq_ambulance1 option').prop('selected', true);
        $('.multi-select-container').addClass('disabled_div');
        $('.multi-select-button').html('All Selected');
    }
});



    
</script>

