<?php
if($questions){
foreach ($questions as $key=>$question) {?>
        <div class="width100 questions_row flt_nonmci" id="ques_<?php echo $question->id;?>">
            <div class="width70 float_left"><?php echo $question->questions; ?></div>
            <div class="width_30 float_right">
                <label for="ques_<?php echo $question->id;?>_yes" class="radio_check width2 float_left">
                     <input id="ques_<?php echo $question->id;?>_yes" type="radio" name="obious_death[ques][<?php echo $question->id ?>]" class="radio_check_input" value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                     <span class="radio_check_holder" ></span>Yes
                </label>
                <label for="ques_<?php echo $question->id;?>_no" class="radio_check width2 float_left">
                    <input id="ques_<?php echo $question->id;?>_no" type="radio" name="obious_death[ques][<?php echo $question->id ?>]" class="radio_check_input" value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                    <span class="radio_check_holder" ></span>No
                </label>
            </div>   
        </div>
    <?php }
}