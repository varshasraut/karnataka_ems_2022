<div class="width100 patient_blk display_inlne_block">
    <div class="single_record_back">                                     
        <h3>Kids Information  </h3>
    </div>
</div>
<div class="row">
<div class=" width_30 float_left">
    <select name="kid[gender]" class="form_input  filter_required"  data-errors="{filter_required:'Please select gender'}" data-base="" tabindex="6">
        <option value="">Gender</option>
        <?php echo get_gen_type($ptn[0]->ptn_gender); ?>
    </select>
</div>

<div class=" width_30 float_left">

<select name="kid[apgar_score]" class="filter_required" data-errors="{filter_required:'Please select score from dropdown'}" tabindex="18">

<option value="">APGAR SCORE</option>

<?php echo get_number($get_pat_mng_data[0]->ap_1min); ?>

</select>

</div>
<div class=" width_30 float_left">
<input name="kid[birth_datetime]" tabindex="1" class="form_input mi_timecalender StartDate filter_required" placeholder="Select kids birth date time" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="from_date">
</div>
</div>

<div class="row">
    <textarea class="width_100" rowspan="5" name='kid[birth_remark]' class="filter_required has_error" data-errors="{filter_required:'Remark should not be blank!'}"></textarea>
</div>
