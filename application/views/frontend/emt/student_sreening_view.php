<script>
if(typeof H != 'undefined'){
    init_auto_address();
}
</script>

<?php
$CI = EMS_Controller::get_instance();

$bgtype[$ptn[0]->ptn_bgroup_type] = "selected='selected'";

$rtncrd[$ptn[0]->ptn_ration_card] = "checked=''";
?>
<div class="head_outer" style="clear: both;">
    <h2 class="txt_clr2 width1">Student Screening    
        <div class="form_field width25 float_right">
                        <div class="input">

                            <select name="hair" class="filter_required"  data-errors="{filter_required:'Please select hair color'}" data-base="" tabindex="6">
                                <option value="">Previous visit</option>
                                <option value="25_agu">25 Aug 2018</option>
                                <option value="25_agu">20 Aug 2018</option>
                                <option value="25_agu">15 Aug 2018</option>
                            </select>

                        </div>
        </div>
    </h2>
</div>

<form method="post" name="" id="screening_info">


    <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>">

    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">



    <div class="half_div_left">

        <div class="row display_inlne_block">
<!--            <div class="width100 display_inlne_block">
                <div class="pat_width float_left" data-activeerror="">
                    <input name="date" value="<?php if($screening[0]->screening_date){ echo $screening[0]->screening_date; }else {echo date('Y-m-d'); }?>" class="filter_required" tabindex="1" data-base="" type="text" placeholder="Date"  data-errors="{filter_required:'Date should not blank'}">
                </div>
                <div class="pat_width float_left" data-activeerror="">
                    <input name="doctore_id" value="<?php if($screening[0]->doctore_id){ echo $screening[0]->doctore_id; }else{ echo $user_ref_id; }?>" class="filter_required" tabindex="1" data-base="" type="text" placeholder="Doctor Id"  data-errors="{filter_required:'Mother name should not blank'}">
                </div>
            </div>-->

            <div class="width100 display_inlne_block">
                <h3>Vital</h3><hr>

                    <div class="form_field width25 select float_left">

                        <div class="label">Pulse- beats/min</div>

                        <div class="input top_left">

                            <input name="pulse_radial" value="<?=@$screening[0]->pulse; ?>"  class="form_input  filter_required" placeholder="Pulse beats/min" data-href="{base_url}auto/get_pa_opt" data-errors="{filter_required:'Please select pulse from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->asst_pulse_radial; ?>" tabindex="6">

                        </div>

                    </div>
                <div class="width75 float_left">
                    <div class="form_field width50 float_left">

                        <div class="label">BP-mm Hg<span class="md_field">*</span></div>

                        <div class="input width100 float_left">

                            <input name="sys_mm" value="<?=@$screening[0]->sys_mm; ?>" class="form_input filter_required " placeholder="Syt" data-errors="{filter_required:'BP should not be blank!'}" type="text" tabindex="16">
<!--                            <input name="sys_hg" value="<?=@$screening[0]->sys_hg; ?>" class="form_input filter_required width40 float_left" placeholder="Syt" data-errors="{filter_required:'BP should not be blank!'}" type="text" tabindex="16"  style="margin-left: 10px;">-->

                        </div>

                    </div>
                    <div class="form_field width50 float_left">

                        <div class="label">&nbsp;<span class="md_field"></span></div>

                        <div class="input width100 float_left">

                            <input name="dys_mm" value="<?=@$screening[0]->dys_mm; ?>" class="form_input filter_required" placeholder="Dys" data-errors="{filter_required:'Dys should not be blank!'}" type="text" tabindex="16">
<!--                             <input name="dys_hg" value="<?=@$screening[0]->dys_hg; ?>" class="form_input filter_required width40 float_left" placeholder="Dys" data-errors="{filter_required:'Dys should not be blank!'}" type="text" tabindex="16"  style="margin-left: 10px;">-->

                        </div>

                    </div>
            </div>
                    <div class="form_field width25 float_left">

                         <div class="label">RR- per min<span class="md_field">*</span></div>

                         <div class="input">

                             <input name="asst_rr" value="<?=@$screening[0]->rr; ?>" class="form_input filter_required" placeholder="RR" data-errors="{filter_required:'RR should not be blank!'}" type="text"  tabindex="15">

                         </div>

                    </div>
                                
                    <div class="form_field width25 float_left">

                        <div class="label">O2 Sats- %<span class="md_field">*</span></div>

                        <div class="input">

                            <input name="oxygen_saturation" value="<?=@$screening[0]->oxygen_saturation; ?>" class="form_input filter_required" placeholder="Oxygen saturation" data-errors="{filter_required:'Oxygen saturation should not be blank!'}" type="text" tabindex="16">

                        </div>
                    </div>
                  
                <div class="form_field width25 float_left">

                        <div class="label">HB<span class="md_field">*</span></div>

                        <div class="input">

                            <input name="hb" value="<?=@$screening[0]->hb; ?>" class="form_input filter_required filter_rangelength[1-20]" placeholder="1-20" data-errors="{filter_required:'HB should not be blank!',filter_rangelength:'Should be 1-20'}" type="text" tabindex="16">

                        </div>

                    </div>
                    <div class="form_field width25 float_left">

                       <div class="label">Temperature- &deg;F </div>

                       <div class="input">

                           <input name="temp" value="<?=@$screening[0]->temp; ?>"  class="form_input filter_if_not_blank filter_number filter_rangelength[82-100]" placeholder="82 to 110" data-errors="{filter_required:'Temp should not be blank',filter_rangelength:'Temp range should be 82 to 100'}" type="text" tabindex="19">

                       </div>
                    </div>
            </div>
            <div class="width100 display_inlne_block">
                                    <div class="form_field width33 float_left">

                                    <div class="label">Height- cm<span class="md_field">*</span></div>

                                    <div class="input">

                                        <input name="height" value="<?=@$screening[0]->height; ?>" class="form_input filter_required filter_number" placeholder="Height in cm" data-errors="{filter_required:'Height should not be blank!',filter_number:'Height should be in number'}" type="text"  tabindex="15" id="stud_scr_height">

                                    </div>
                                </div>
                                <div class="form_field width33 float_left">

                                    <div class="label">Weight- Kg<span class="md_field">*</span></div>

                                    <div class="input">

                                        <input name="weight" value="<?=@$screening[0]->weight; ?>" class="form_input filter_required" placeholder="Weight in kg" data-errors="{filter_required:'Weight should not be blank!'}" type="text"  tabindex="15" id="stud_scr_weight">

                                    </div>
                                </div>
                                <div class="form_field width33 float_left">

                                   <div class="label">BMI</div>

                                   <div class="input">

                                       <input name="bmi" value="<?=@$screening[0]->bmi; ?>"  class="form_input " placeholder="BMI" data-errors="{filter_required:'BMI should not be blank'}" type="text" tabindex="19" id="stud_scr_bmi" readonly="readonly">

                                   </div>
                                </div>
            </div>
            <div class="width100 display_inlne_block">
                <h3>General Examination </h3><hr>

                <div class="form_field width_33 float_left">
                    <div class="label">Head</div>

                    <div class="input">

                        <select name="head" class="filter_required"  data-errors="{filter_required:'Please select gender'}" data-base="" tabindex="6">
                            <!--                            <option value="">Select</option>-->
                            <option value="NAD" <?php
                            if ($screening[0]->head == 'NAD') {
                                echo "selected";
                            } else if (empty($screening[0])) {
                                echo "selected";
                            }
                            ?>>NAD</option>
                            <option value="obivous_deformity"  <?php
                            if ($screening[0]->head == 'obivous_deformity') {
                                echo "selected";
                            }
                            ?>>Obvious deformity</option>

                        </select>

                    </div>
                </div>
                <div class="form_field width_33 float_left">
                    <div class="label">Eye</div>

                    <div class="input">

                        <select name="eye" class="filter_required"  data-errors="{filter_required:'Please select Eye'}" data-base="" tabindex="6">
                            <!--                            <option value="">Select</option>-->
                            <option value="NAD" <?php
                            if ($screening[0]->eye == 'NAD') {
                                echo "selected";
                            } else if (empty($screening[0])) {
                                echo "selected";
                            }
                            ?>>NAD</option>
                            <option value="squint_nys" <?php
                            if ($screening[0]->eye == 'squint') {
                                echo "selected";
                            }
                            ?>>Squint</option>
                            <option value="tagmus" <?php
                                    if ($screening[0]->eye == 'nystagmus') {
                                        echo "selected";
                                    }
                                    ?>> Nystagmus</option>
                            <option value="exophthalmos" <?php
                                    if ($screening[0]->eye == 'exophthalmos') {
                                        echo "selected";
                                    }
                                    ?>>Exophthalmos</option>

                        </select>

                    </div>
                </div>
                <div class="form_field width_33 float_left">
                    <div class="label">Nose</div>

                    <div class="input">

                        <select name="nose" class="filter_required"  data-errors="{filter_required:'Please select Nose'}" data-base="" tabindex="6">
                            <!--                            <option value="">Select</option>-->
                            <option value="NAD" <?php
                            if ($screening[0]->nose == 'NAD') {
                                echo "selected";
                            } else if (empty($screening[0])) {
                                echo "selected";
                            }
                            ?>>NAD</option>
                            <option value="deviated_septum" <?php
                            if ($screening[0]->nose == 'deviated_septum') {
                                echo "selected";
                            }
                            ?>>Deviated Septum</option>
                            <option value="nasal_polyps" <?php
                                    if ($screening[0]->nose == 'nasal_polyps') {
                                        echo "selected";
                                    }
                            ?>>Nasal Polyps </option>

                        </select>

                    </div>
                </div>
                <div class="width100 display_inlne_block">
            <!--                <div class="style6">Hair <span class="md_field">*</span></div>-->
                    <div class="form_field width25 float_left">
                        <div class="label">Hair Color</div>

                        <div class="input">

                            <select name="hair" class="filter_required"  data-errors="{filter_required:'Please select hair color'}" data-base="" tabindex="6">
                                <!--                            <option value="">Select</option>-->
                                <option value="black" <?php
                                if ($screening[0]->hair_color == 'black') {
                                    echo "selected";
                                } else if (empty($screening[0])) {
                                    echo "selected";
                                }
                                ?>>Black</option>
                                <option value="dull_brown" <?php
                                if ($screening[0]->hair_color == 'dull_brown') {
                                    echo "selected";
                                }
                                ?>>Dull Brown</option>
                                <option value="discoloration" <?php
                            if ($screening[0]->hair_color == 'discoloration') {
                                echo "selected";
                            }
                            ?>>Discoloration</option>
                            </select>

                        </div>
                    </div>
                    <div class="form_field width25 float_left">
                        <div class="label">Hair Density</div>

                        <div class="input">

                            <select name="hair_density" class="filter_required"  data-errors="{filter_required:'Please select Hair Density'}" data-base="" tabindex="6">
                                <!--                            <option value="">Select</option>-->
                                <option value="thick" <?php
                                if ($screening[0]->hair_density == 'thick') {
                                    echo "selected";
                                } else if (empty($screening[0])) {
                                    echo "selected";
                                }
                                ?>>Thick</option>
                                <option value="thin" <?php
                                if ($screening[0]->hair_density == 'thin') {
                                    echo "selected";
                                }
                                ?>>Thin</option>
                                <option value="parse" <?php
                            if ($screening[0]->hair_density == 'parse') {
                                echo "selected";
                            }
                            ?>>Parse</option>
                            </select>

                        </div>
                    </div>
                    <div class="form_field width25 float_left">
                        <div class="label">Hair Texture</div>

                        <div class="input">
                            <select name="hair_texture" class="filter_required"  data-errors="{filter_required:'Please select Hair Texture'}" data-base="" tabindex="6">
                                <!--                            <option value="">Select</option>-->
                                <option value="healthy" <?php if ($screening[0]->hair_texture == 'healthy') {
                echo "selected";
            } else if (empty($screening[0])) {
                echo "selected";
            } ?>>healthy</option>
                                <option value="rough" <?php if ($screening[0]->hair_texture == 'rough') {
                echo "selected";
            } ?>>rough</option>
                                <option value="brittle" <?php if ($screening[0]->hair_texture == 'brittle') {
                echo "selected";
            } ?>>brittle </option>
                            </select>

                        </div>
                    </div>
                    <div class="form_field width25 float_left">
                        <div class="label">Alopecia </div>

                        <div class="input">
                            <select name="alopecia" class="filter_required"  data-errors="{filter_required:'Please select Hair Alopecia'}" data-base="" tabindex="6">
                                <!--                            <option value="">Select</option>-->
                                <option value="present" <?php if ($screening[0]->alopecia == 'present') {
                echo "selected";
            } ?>>Present</option>
                                <option value="absent" <?php if ($screening[0]->alopecia == 'absent') {
                echo "selected";
            } else if (empty($screening[0])) {
                echo "selected";
            } ?> >Absent</option>
                            </select>

                        </div>
                    </div>

                </div>

                <div class="width100 display_inlne_block">
            <!--                <div class="style6">Skin <span class="md_field">*</span></div>-->
                    <div class="form_field width_33 float_left">
                        <div class="label">Skin Colour</div>

                        <div class="input">
                            <select name="skin_color" class="filter_required"  data-errors="{filter_required:'Please select Skin Colour'}" data-base="" tabindex="6">
                                <!--                            <option value="">Select</option>-->
                                <option value="Normal" <?php if ($screening[0]->skin_color == 'Normal') {
                echo "selected";
            } else if (empty($screening[0])) {
                echo "selected";
            } ?>>Normal</option>
                                <option value="vitiligo" <?php if ($screening[0]->skin_color == 'vitiligo') {
                echo "selected";
            } ?>>Vitiligo</option>
                                <option value="hyperpigmentation" <?php if ($screening[0]->skin_color == 'hyperpigmentation') {
                echo "selected";
            } ?>>Hyperpigmentation</option>
                                <option value="cyanosis" <?php if ($screening[0]->skin_color == 'cyanosis') {
                echo "selected";
            } ?>>Cyanosis</option>
                                <option value="jaundiced" <?php if ($screening[0]->skin_color == 'jaundiced') {
                echo "selected";
            } ?>>Jaundiced</option>
                            </select>
                        </div>
                    </div>
                    <div class="form_field width_33 float_left">
                        <div class="label">Skin Texture</div>

                        <div class="input">
                            <select name="skin_texture" class="filter_required"  data-errors="{filter_required:'Please select Skin Texture'}" data-base="" tabindex="6">
                                <!--                            <option value="">Select</option>-->
                                <option value="normal" <?php if ($screening[0]->skin_texture == 'normal') {
                echo "selected";
            } else if (empty($screening[0])) {
                echo "selected";
            } ?>>normal</option>
                                <option value="dry" <?php if ($screening[0]->skin_texture == 'dry') {
                echo "selected";
            } ?>>dry</option>
                                <option value="rough" <?php if ($screening[0]->skin_texture == 'rough') {
                echo "selected";
            } ?>>rough </option>
                            </select>

                        </div>
                    </div>
                    <div class="form_field width_33 float_left">
                        <div class="label">Skin Lesions</div>

                        <div class="input">

                            <select name="skin_lesions" class="filter_required"  data-errors="{filter_required:'Please select Skin Lesions'}" data-base="" tabindex="6">
                                <!--                            <option value="">Select</option>-->
                                <option value="NAD" <?php if ($screening[0]->skin_lesions == 'NAD') {
                echo "selected";
            } else if (empty($screening[0])) {
                echo "selected";
            } ?>>eczematous</option>
                                <option value="eczematous" <?php if ($screening[0]->skin_lesions == 'eczematous') {
                echo "selected";
            } ?>>eczematous</option>
                                <option value="ulcers" <?php if ($screening[0]->skin_lesions == 'ulcers') {
                echo "selected";
            } ?>>ulcers</option>
                                <option value="tumors_nodes" <?php if ($screening[0]->skin_lesions == 'tumors_nodes') {
                echo "selected";
            } ?>>tumors/nodes</option>
                                <option value="skin_eruptions" <?php if ($screening[0]->skin_lesions == 'skin_eruptions') {
                echo "selected";
            } ?>>skin eruptions</option>
                            </select>

                        </div>
                    </div>
                </div>

                <div class="width100 display_inlne_block">
            <!--                <div class="style6">Mouth <span class="md_field">*</span></div>-->
                    <div class="form_field width33 float_left">
                        <div class="label">Mouth Lips</div>
                        <div class="input">
                            <select name="lips" class="filter_required"  data-errors="{filter_required:'Please select Lips'}" data-base="" tabindex="6">
                                <!--                            <option value="">Select</option>-->
                                <option value="NAD" <?php if ($screening[0]->lips == 'NAD') {
                echo "selected";
            } else if (empty($screening[0])) {
                echo "selected";
            } ?>>NAD</option>
                                <option value="Cracks" <?php if ($screening[0]->lips == 'Cracks') {
                echo "selected";
            } ?>>Cracks</option>
                                <option value="Fissures" <?php if ($screening[0]->lips == 'Fissures') {
                echo "selected";
            } ?>>Fissures</option>
                                <option value="Discoloration" <?php if ($screening[0]->lips == 'Discoloration') {
                echo "selected";
            } ?>>Discoloration</option>
                                <option value="Ulcers_sores" <?php if ($screening[0]->lips == 'Ulcers_sores') {
                echo "selected";
            } ?>>Ulcers or sores </option>
                            </select>
                        </div>
                    </div>
                    <div class="form_field width33 float_left">
                        <div class="label">Mouth Gums</div>
                        <div class="input">
                            <select name="gums" class="filter_required"  data-errors="{filter_required:'Please select Gums'}" data-base="" tabindex="6">
                                <!--                            <option value="">Select</option>-->
                                <option value="Healthy" <?php if ($screening[0]->gums == 'Healthy') {
                echo "selected";
            } else if (empty($screening[0])) {
                echo "selected";
            } ?>>Healthy</option>
                                <option value="stained_tooth" <?php if ($screening[0]->gums == 'stained_tooth') {
                echo "selected";
            } ?>>Stained tooth</option>
                                <option value="bleeding" <?php if ($screening[0]->gums == 'bleeding') {
                echo "selected";
            } ?>>Bleeding </option>
                                <option value="inflamed" <?php if ($screening[0]->gums == 'inflamed') {
                echo "selected";
            } ?>>Inflamed </option>
                                <option value="halitosis" <?php if ($screening[0]->gums == 'halitosis') {
                echo "selected";
            } ?>>Halitosis </option>
                            </select>

                        </div>
                    </div>
                    <div class="form_field width33 float_left">
                        <div class="label">Mouth Dentition</div>

                        <div class="input">

                            <select name="dention" class="filter_required"  data-errors="{filter_required:'Please select Dention'}" data-base="" tabindex="6">
                                <!--                            <option value="">Select</option>-->
                                <option value="NAD"  <?php if ($screening[0]->dention == 'NAD') {
                echo "selected";
            } else if (empty($screening[0])) {
                echo "selected";
            } ?>>NAD</option>
                                <option value="loose_tooth"  <?php if ($screening[0]->dention == 'loose_tooth') {
                echo "selected";
            } ?>>Loose tooth</option>
                                <option value="tooth_decay"  <?php if ($screening[0]->dention == 'tooth_decay') {
                echo "selected";
            } ?>>Tooth Decay</option>
                            </select>

                        </div>
                    </div>
                    <div class="form_field width33 float_left">
                        <div class="label">Mouth Oral Mucosa</div>

                        <div class="input">

                            <select name="oral_mucosa" class="filter_required"  data-errors="{filter_required:'Please select Oral Mucosa'}" data-base="" tabindex="6">
                                <!--                            <option value="">Select</option>-->
                                <option value="healthy_pink" <?php if ($screening[0]->oral_mucosa == 'healthy_pink') {
                echo "selected";
            } else if (empty($screening[0])) {
                echo "selected";
            } ?>>Healthy pink</option>
                                <option value="ulcers_sore" <?php if ($screening[0]->oral_mucosa == 'ulcers_sore') {
                echo "selected";
            } ?>>Ulcers or sore</option>
                                <option value="white_patches" <?php if ($screening[0]->oral_mucosa == 'white_patches') {
                echo "selected";
            } ?>>White patches</option>
                            </select>

                        </div>
                    </div>
                    <div class="form_field width33 float_left">
                        <div class="label">Mouth Tongue</div>

                        <div class="input">

                            <select name="tongue" class="filter_required"  data-errors="{filter_required:'Please select Tongue'}" data-base="" tabindex="6">
                                <!--                            <option value="">Select</option>-->
                                <option value="color_red" <?php if ($screening[0]->tongue == 'color_red') {
                echo "selected";
            } ?>>Colour -red</option>
                                <option value="color_discoloured" <?php if ($screening[0]->tongue == 'color_discoloured') {
                echo "selected";
            } ?>>colour - discoloured</option>
                                <option value="moist_pink" <?php if ($screening[0]->tongue == 'moist_pink') {
                echo "selected";
            } else if (empty($screening[0])) {
                echo "selected";
            } ?>>moist and pink</option>
                                <option value="dry_cracked" <?php if ($screening[0]->tongue == 'dry_cracked') {
                echo "selected";
            } ?>>dry and cracked</option>
                            </select>

                        </div>
                    </div>
                    <!--                <div class="form_field width25 float_left">
                                        <div class="label">Throat</div>

                                        <div class="input">

                                            <select name="throat" class="filter_required"  data-errors="{filter_required:'Please select Throat'}" data-base="" tabindex="6">
                                                <option value="">Select</option>
                                                <option value="eczematous" <?php if ($screening[0]->throat == 'eczematous') {
                echo "selected";
            } ?>>eczematous</option>
                                                <option value="ulcers" <?php if ($screening[0]->throat == 'ulcers') {
                echo "selected";
            } ?>>ulcers</option>
                                                <option value="tumors_nodes" <?php if ($screening[0]->throat == 'tumors_nodes') {
                echo "selected";
            } ?>>tumors/nodes</option>
                                                <option value="skin_eruptions" <?php if ($screening[0]->throat == 'skin_eruptions') {
                echo "selected";
            } ?>>skin eruptions</option>
                                            </select>

                                        </div>
                                    </div>-->
                </div>
                <div class="width100 display_inlne_block">
                    <div class="form_field width25 float_left">
                        <div class="style6">Neck</div>
                        <div  class="input" data-activeerror="">
                            <select name="neck" class="filter_required"  data-errors="{filter_required:'Please select Neck'}" data-base="" tabindex="6">
                                <!--                            <option value="">Select</option>-->
                                <option value="NAD" <?php if ($screening[0]->neck == 'NAD') {
                echo "selected";
            } else if (empty($screening[0])) {
                echo "selected";
            } ?>>NAD</option>
                                <option value="evidence_goitre" <?php if ($screening[0]->neck == 'evidence_goitre') {
                echo "selected";
            } ?>>Evidence of goitre</option>
                                <option value="lymphadenopathy" <?php if ($screening[0]->neck == 'lymphadenopathy') {
                echo "selected";
            } ?>>Lymphadenopathy</option>
                            </select>
                        </div>
                    </div>
                    <div class="form_field width25 float_left">
                        <div class="style6">Chest</div>

                        <div class="width100 float_left">
                            <div class="input">
                                <select name="chest" class="filter_required"  data-errors="{filter_required:'Please select Chest'}" data-base="" tabindex="6">
                                    <!--                            <option value="">Select</option>-->
                                    <option value="NAD" <?php if ($screening[0]->chest == 'NAD') {
                echo "selected";
            } else if (empty($screening[0])) {
                echo "selected";
            } ?>>NAD</option>
                                    <option value="asymmetry_chest_wall"  <?php if ($screening[0]->chest == 'asymmetry_chest_wall') {
                echo "selected";
            } ?>>Asymmetry of chest wall</option>
                                    <option value="breast_development"  <?php if ($screening[0]->chest == 'breast_development') {
                echo "selected";
            } ?>>Breast development</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form_field width25 float_left">
                        <div class="style6">Abdomen</div>
                        <div class="width100 float_left">
                            <div  class="input">
                                <select name="abdomen" class="filter_required"  data-errors="{filter_required:'Please select Abdomen'}" data-base="" tabindex="6">
                                    <!--                            <option value="">Select</option>-->
                                    <option value="NAD" <?php if ($screening[0]->abdomen == 'NAD') {
                echo "selected";
            } else if (empty($screening[0])) {
                echo "selected";
            } ?>>NAD</option>
                                    <option value="distension" <?php if ($screening[0]->abdomen == 'distension') {
                echo "selected";
            } ?>>Distension</option>
                                    <option value="discoloration" <?php if ($screening[0]->abdomen == 'discoloration') {
                echo "selected";
            } ?>>Discoloration</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form_field width25 float_left">
                        <div class="style6">Extremity</div>

                        <div class="width100 float_left">

                            <div  class="input">
                                <select name="extremity" class="filter_required"  data-errors="{filter_required:'Please select Abdomen'}" data-base="" tabindex="6">
                                    <!--                            <option value="">Select</option>-->
                                    <option value="feet_NAD" <?php if ($screening[0]->extremity == 'feet_NAD') {
                echo "selected";
            } else if (empty($screening[0])) {
                echo "selected";
            } ?>>Feet NAD</option>
                                    <option value="muscle_wasting" <?php if ($screening[0]->extremity == 'muscle_wasting') {
                echo "selected";
            } ?>>Muscle wasting</option>
                                    <option value="bone_abnormality" <?php if ($screening[0]->extremity == 'bone_abnormality') {
                echo "selected";
            } ?>>Bone abnormality</option>
                                    <option value="genu_vaglum" <?php if ($screening[0]->extremity == 'genu_vaglum') {
                echo "selected";
            } ?>>Genu vaglum</option>
                                    <option value="genu_varum" <?php if ($screening[0]->extremity == 'genu_varum') {
                echo "selected";
            } ?>>Genu varum</option>
                                </select>

                            </div>

                        </div>
                    </div>
                </div>

            </div>

            

        </div>


        <div class="width100 display_inlne_block">
<!--            <div class="style6">Resp S <span class="md_field">*</span></div>-->
              <h3>Systemic Exam</h3><hr>
            <div class="width50 float_left display_inlne_block">

                <div class="style6">RS Right</div>

                <div  class="input">
                    <select name="resp_right" class="filter_required"  data-errors="{filter_required:'Please select Resp Right'}" data-base="" tabindex="6">
                        <option value="">Select</option>
                        <option value="NAD" <?php if($screening[0]->resp_right == 'NAD'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>NAD</option>
                        <option value="sputum_plus" <?php if($screening[0]->resp_right == 'sputum_plus'){ echo "selected"; } ?>>Sputum +</option>
                        <option value="crackels_plus" <?php if($screening[0]->resp_right == 'crackels_plus'){ echo "selected"; } ?>>crackels +</option>
                        <option value="conducted_sounds" <?php if($screening[0]->resp_right == 'conducted_sounds'){ echo "selected"; } ?>>Conducted sounds</option>
                        <option value="other" <?php if($screening[0]->resp_right == 'other'){ echo "selected"; } ?>>other</option>
                    </select>
                </div>

            </div>
            

            <div class="width50 ">
                <div class="style6">RS Left</div>
                <div  class="input">
                   <select name="resp_left" class="filter_required"  data-errors="{filter_required:'Please select Resp Left'}" data-base="" tabindex="6">
                        <option value="">Select</option>
                        <option value="NAD" <?php if($screening[0]->resp_left == 'NAD'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>NAD</option>
                        <option value="sputum_plus" <?php if($screening[0]->resp_left == 'sputum_plus'){ echo "selected"; } ?>>Sputum +</option>
                        <option value="crackels_plus" <?php if($screening[0]->resp_left == 'crackels_plus'){ echo "selected"; } ?>>crackels +</option>
                        <option value="conducted_sounds" <?php if($screening[0]->resp_left == 'conducted_sounds'){ echo "selected"; } ?>>Conducted sounds</option>
                        <option value="other" <?php if($screening[0]->resp_left == 'other'){ echo "selected"; } ?>>other</option>
                    </select>
                </div>

            </div>

        </div>
        <div class="width100 display_inlne_block">
               <div class="form_field width25 select float_left">
                    <div class="label">CVS</div>
                    <div class="input top_left">
                        <select name="cvs" class="filter_required"  data-errors="{filter_required:'Please select CVS'}" data-base="" tabindex="6">
<!--                            <option value="">Select</option>-->
                            <option value="NAD" <?php if($screening[0]->cvs == 'NAD'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>NAD</option>
                            <option value="murmer_systolic" <?php if($screening[0]->cvs == 'murmer_systolic'){ echo "selected"; } ?>>Murmer - systolic</option>
                            <option value="murmer_diastolic" <?php if($screening[0]->cvs == 'murmer_diastolic'){ echo "selected"; } ?>>Murmers - diastolic</option>
                            <option value="pericardial_rub" <?php if($screening[0]->cvs == 'pericardial_rub'){ echo "selected"; } ?>>Pericardial Rub</option>
                            <option value="other" <?php if($screening[0]->cvs == 'other'){ echo "selected"; } ?>>Other</option>
                        </select>
                    </div>
            </div>
        

              
            <div class="form_field width25 select float_left">
                    <div class="label">Varicose veins</div>
                    <div class="input top_left">
                        <select name="varicose_veins" class="filter_required"  data-errors="{filter_required:'Please select Varicose veins'}" data-base="" tabindex="6">
<!--                            <option value="">Select</option>-->
                            <option value="NAD" <?php if($screening[0]->varicose_veins == 'NAD'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; }  ?>>NAD</option>
                            <option value="right_leg" <?php if($screening[0]->varicose_veins == 'right_leg'){ echo "selected"; } ?>>Right leg</option>
                            <option value="left_leg" <?php if($screening[0]->varicose_veins == 'left_leg'){ echo "selected"; } ?>>Left leg </option>    
                        </select>
                    </div>
            </div>
            <?php 
            
            if($student_data[0]->stud_gender == 'F'){?>
            <div class="form_field width50 select float_left on_click_show_input">
                    <div class="label">LMP</div>
                    <div class="input top_left width50 float_left">
<!--                         <input name="reproductive" value="<?=$screening[0]->reproductive;?>" class="filter_required mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'Reproductive should not blank'}">-->
                        <select name="reproductive" class="filter_required"  data-errors="{filter_required:'Please select Reproductive'}" data-base="" tabindex="6" id="reproductive_value">
                            <option value="">Select</option>
                            <option value="not_yet_started" <?php if($screening[0]->reproductive == 'not_yet_started'){ echo "selected"; } ?>>Not yet started</option>
                            <option value="calender" <?php if($screening[0]->reproductive == 'calender'){ echo "selected"; } ?>>Calender</option>
                        </select>
                    </div>
                     <div class="input width50 float_left top_left hidden_input hide">

                        <input name="reproductive_date" value="<?php echo $medical_data[0]->reproductive_date; ?>"  class="form_input mi_calender" placeholder="Date" d data-errors="{filter_required:'Please select pulse from dropdown list'}" type="text" tabindex="6">

                    </div>
            </div>
            <?php } ?>
        </div>
        <div class="width100 display_inlne_block">
         
            <div class="form_field width25 select float_left">
                    <div class="label">CNS</div>
                    <div class="input top_left">
                        <select name="cns" class="filter_required"  data-errors="{filter_required:'Please select CNS'}" data-base="" tabindex="6">
<!--                            <option value="">Select</option>-->
                            <option value="NAD" <?php if($screening[0]->cns == 'NAD'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>NAD</option>
                            <option value="hemiparesis_right" <?php if($screening[0]->cns == 'hemiparesis_right'){ echo "selected"; } ?>>Hemiparesis - Right side</option>
                            <option value="hemiparesis_left" <?php if($screening[0]->cns == 'hemiparesis_left'){ echo "selected"; } ?>>Hemiparesis - left side</option>
                            <option value="paraperesis" <?php if($screening[0]->cns == 'paraperesis'){ echo "selected"; } ?>>Paraperesis</option>
                            <option value="quadriparesis" <?php if($screening[0]->cns == 'quadriparesis'){ echo "selected"; } ?>>Quadriparesis</option>
                            <option value="facial_palsy" <?php if($screening[0]->cns == 'facial_palsy'){ echo "selected"; } ?>>Facial palsy</option>
                        </select>
                    </div>
            </div>
            
           <div class="form_field width25 float_left">
                <div class="style6">Reflexes</div>

                <div class="width100 float_left">

                    <div  class="input">
                        <select name="reflexes" class=""  data-errors="{filter_required:'Please select Abdomen'}" data-base="" tabindex="6">
<!--                            <option value="">Select</option>-->
                            <option value="plus" <?php if($screening[0]->reflexes == 'plus'){ echo "selected"; } ?>>+</option>
                            <option value="2plus" <?php if($screening[0]->reflexes == '2plus'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>++</option>
                            <option value="3plus" <?php if($screening[0]->reflexes == '3plus'){ echo "selected"; } ?>>+++</option>
                            <option value="4plus" <?php if($screening[0]->reflexes == '4plus'){ echo "selected"; } ?>>++++</option>
                            <option value="absent" <?php if($screening[0]->reflexes == 'absent'){ echo "selected"; } ?>>Absent</option>
                        </select>

                    </div>
                </div>
            </div>
            <div class="form_field width25 select float_left">
                    <div class="label">Romberg's</div>
                    <div class="input top_left">
                        <select name="rombergs" class=""  data-errors="{filter_required:'Please select Romberg'}" data-base="" tabindex="6">
                        
                            <option value="positive" <?php if($screening[0]->rombergs == 'positive'){ echo "selected"; } ?>>+ ve</option>
                            <option value="negative" <?php if($screening[0]->rombergs == 'negative'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>- ve</option>
                           
                        </select>
                    </div>
            </div>
            <div class="form_field width25 select float_left">
                    <div class="label">Pupils</div>
                    <div class="input top_left">
                        <select name="pupils" class="filter_required"  data-errors="{filter_required:'Please select Pupils'}" data-base="" tabindex="6">
<!--                            <option value="">Select</option>-->
                            <option value="BERL" <?php if($screening[0]->pupils == 'BERL'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>BERL</option>
                            <option value="unequal" <?php if($screening[0]->pupils == 'unequal'){ echo "selected"; } ?>>unequal</option>
                            <option value="bilatral_dialated" <?php if($screening[0]->pupils == 'bilatral_dialated'){ echo "selected"; } ?>>bilatral dialated</option>
                            <option value="bilateral_constricted" <?php if($screening[0]->pupils == 'bilateral_constricted'){ echo "selected"; } ?>>bilateral constricted</option>
                        </select>
                    </div>
            </div>

        </div>
        <div class="width100 display_inlne_block">

            <div class="form_field width25 select float_left">
                    <div class="label">P/A</div>
                    <div class="input top_left">
                        <select name="p_a" class="filter_required"  data-errors="{filter_required:'Please select P/A'}" data-base="" tabindex="6">
<!--                            <option value="">Select</option>-->
                                <option value="NAD" <?php if($screening[0]->p_a == 'NAD'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>NAD</option>
                                <option value="hepatomegaly" <?php if($screening[0]->p_a == 'hepatomegaly'){ echo "selected"; } ?>>Hepatomegaly</option>
                                <option value="spleenomegaly" <?php if($screening[0]->p_a == 'spleenomegaly'){ echo "selected"; } ?>>spleenomegaly</option>
                                <option value="hepatospleenomegaly" <?php if($screening[0]->p_a == 'hepatospleenomegaly'){ echo "selected"; } ?>>hepatospleenomegaly</option>
                                <option value="others" <?php if($screening[0]->p_a == 'others'){ echo "selected"; } ?>>others</option>
                        </select>
                    </div>
            </div>
          
            <div class="form_field width25 select float_left">
                    <div class="label">tenderness</div>
                    <div class="input top_left">
                        <select name="tenderness" class="filter_required"  data-errors="{filter_required:'Please select Tenderness'}" >
                                <option value="absent" <?php if($screening[0]->tenderness == 'positive'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; }  ?>>Absent</option>
                                <option value="epigastric" <?php if($screening[0]->tenderness == 'positive'){ echo "selected"; } ?>>Epigastric</option>
                                <option value="hypogastric" <?php if($screening[0]->tenderness == 'positive'){ echo "selected"; } ?>>Hypogastric</option>
                                <option value="umbilical" <?php if($screening[0]->tenderness == 'positive'){ echo "selected"; } ?>>Umbilical</option>
                                <option value="rt_iliac" <?php if($screening[0]->tenderness == 'positive'){ echo "selected"; } ?>>Rt iliac</option>
                                <option value="lt_iliac" <?php if($screening[0]->tenderness == 'positive'){ echo "selected"; } ?>>Lt iliac</option>
                                <option value="rt_lumbar" <?php if($screening[0]->tenderness == 'positive'){ echo "selected"; } ?>>Rt lumbar</option>
                                <option value="lt_lumbar" <?php if($screening[0]->tenderness == 'positive'){ echo "selected"; } ?>>LT lumbar</option>
                         </select>
                    </div>
            </div>
            <div class="form_field width25 select float_left">
                    <div class="label">Ascitis</div>
                    <div class="input top_left">
                        <select name="ascitis" class="filter_required"  data-errors="{filter_required:'Please select Romberg'}" data-base="" tabindex="6">
                           
                            <option value="present" <?php if($screening[0]->ascitis == 'present'){ echo "selected"; } ?>>Present</option>
                            <option value="absent" <?php if($screening[0]->ascitis == 'absent'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>Absent</option>
                           
                        </select>
                    </div>
            </div>
            <div class="form_field width25 select float_left">
                    <div class="label">Guarding</div>
                    <div class="input top_left">
                        <select name="guarding" class="filter_required"  data-errors="{filter_required:'Please select Guarding'}" data-base="" tabindex="6">
<!--                            <option value="">Select</option>-->
                            <option value="present" <?php if($screening[0]->guarding == 'present'){ echo "selected"; } ?>>Present</option>
                            <option value="absent" <?php if($screening[0]->guarding == 'absent'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>Absent</option>
                           
                        </select>
                    </div>
            </div>
            
        </div>
        <div class="width100 display_inlne_block">

            <div class="form_field width25 select float_left">
                    <div class="label">Joints</div>
                    <div class="input top_left">
                        <select name="joints" class="filter_required"  data-errors="{filter_required:'Please select Joints'}" data-base="" tabindex="6">
<!--                            <option value="">Select</option>-->
                            <option value="swollen" <?php if($screening[0]->joints == 'swollen'){ echo "selected"; } ?>>swollen</option>
                            <option value="NAD" <?php if($screening[0]->joints == 'normal'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; }?>>NAD</option>
                        </select>
                    </div>
            </div>
            
            <div class="form_field width25 select float_left">
                    <div class="label">Swollen joints</div>
                    <div class="input top_left">
                        <select name="swollen_joint" class="filter_required"  data-errors="{filter_required:'Please select No of swollen joints'}" data-base="" tabindex="6">
                            <option value="NAD" <?php if($screening[0]->No_swollen_joints == 'NAD'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; }  ?>>NAD</option>
                            <option value="great_5" <?php if($screening[0]->No_swollen_joints == 'great_5'){ echo "selected"; } ?>>>5</option>
                            <option value="10" <?php if($screening[0]->No_swollen_joints == '10'){ echo "selected"; } ?>>>10</option>
                            <option value="5_less" <?php if($screening[0]->No_swollen_joints == '5_less'){ echo "selected"; } ?>><5</option>                         
                        </select>
                    </div>
            </div>
             <div class="form_field width25 select float_left">
                    <div class="label">Spine/posture </div>
                    <div class="input top_left">
                        <select name="spine_posture" class="filter_required"  data-errors="{filter_required:'Please select No of swollen joints'}" data-base="" tabindex="6">
                            <option value="NAD" <?php if($screening[0]->spine_posture == 'NAD'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; }  ?>> NAD</option>
                            <option value="spinal_abnormality_mild" <?php if($screening[0]->spine_posture == 'spinal_abnormality_mild'){ echo "selected"; } ?>>Spinal Abnormality Mild</option>
                             <option value="spinal_abnormility_severe" <?php if($screening[0]->spine_posture == 'spinal_abnormility_severe'){ echo "selected"; } ?>> Spinal Abnormility Severe</option> 
                             <option value="spinal_abnormality_moderate" <?php if($screening[0]->spine_posture == 'spinal_abnormality_moderate'){ echo "selected"; } ?>> Spinal Abnormality moderate </option>
                           
                        </select>
                    </div>
            </div>
          
            
        </div>

    </div>


    <div class="half_div_right">


        <div class="display_inlne_block width100">
              <div class="width100 display_inlne_block">
            <h3> Dental Screening  </h3><hr>
                <div class="form_field width25 select float_left">
                    <div class="label">Oral hygiene</div>
                    <div class="input top_left">
                        <select name="oral_hygiene" class="filter_required"  data-errors="{filter_required:'Please select Oral hygiene'}" data-base="" tabindex="6">
                             <option value="NAD" <?php if($screening[0]->oral_hygiene == 'NAD'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>NAD</option>
                            <option value="good" <?php if($screening[0]->oral_hygiene == 'good'){ echo "selected"; } ?>>good</option>
                            <option value="fair" <?php if($screening[0]->oral_hygiene == 'fair'){ echo "selected"; } ?>>fair</option>
                            <option value="poor" <?php if($screening[0]->oral_hygiene == 'poor'){ echo "selected"; } ?>>poor</option>
                           
                        </select>
                    </div>
                </div>
                <div class="form_field width25 select float_left">
                    <div class="label">Carious Tooth </div>
                    <div class="input top_left">
                        <select name="carious_tooth" class="filter_required"  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                          
                            <option value="Y" <?php if($screening[0]->carious_tooth == 'Y'){ echo "selected"; } ?>>Yes</option>
                            <option value="N" <?php if($screening[0]->carious_tooth == 'N'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; }  ?>>No</option>
                           
                        </select>
                    </div>
                </div>
            <div class="form_field width25 select float_left">
                    <div class="label">Fluorosis</div>
                    <div class="input top_left">
                        <select name="fluorosis" class="filter_required"  data-errors="{filter_required:'Please select Reproductive'}" data-base="" tabindex="6">
                           
                           <option value="Y" <?php if($screening[0]->fluorosis == 'yes'){ echo "selected"; } ?>>Yes</option>
                            <option value="N" <?php if($screening[0]->fluorosis == 'no'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; }  ?>>No</option>
                           
                        </select>
                    </div>
                </div>
            <div class="form_field width25 select float_left">
                    <div class="label">Orthodontic Treatment</div>
                    <div class="input top_left">
                        <select name="orthodontic_treatment" class="filter_required"  data-errors="{filter_required:'Please select Reproductive'}" data-base="" tabindex="6">
                           
                            <option value="Y" <?php if($screening[0]->orthodontic_treatment == 'yes'){ echo "selected"; } ?>>Yes</option>
                            <option value="N" <?php if($screening[0]->orthodontic_treatment == 'no'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; }  ?>>No</option>    
                        </select>
                    </div>
            </div>
            <div class="form_field width25 select float_left">
                    <div class="label">extraction</div>
                    <div class="input top_left">
                        <select name="extraction" class="filter_required"  data-errors="{filter_required:'Please select Extraction'}" data-base="" tabindex="6">
                       
                            <option value="Y" <?php if($screening[0]->extraction == 'Y'){ echo "selected"; } ?>>Required</option>
                            <option value="N" <?php if($screening[0]->extraction == 'N'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; }  ?>>Not required</option>
                           
                        </select>
                    </div>
            </div>
            <div class="form_field width75 select float_left">
                    <div class="label">Comment</div>
                    <div class="input top_left">
                        <input name="dental_comment" value="<?=@$screening[0]->dental_comment;?>" class="width100" tabindex="51" data-base="" data-errors="{filter_minlength:'Comment should be at least 12 digit long'}" autocomplete="off" type="text">
                    </div>
            </div>
            <div class="width100 display_inlne_block">
                <div class="display-inline-block width100">
                    <div class="style6">Reffered to specialist</div>

                    <div class="width100 float_left on_click_show_input">
                        <label for="reffered_specialist_yes" class="radio_check width_30 float_left">
                             <input id="reffered_specialist_yes" type="radio" name="reffered_specialist" class="radio_check_input" value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>" <?php if($screening[0]->reffered_specialist == 'Y'){ echo "selected"; } ?>>
                             <span class="radio_check_holder" ></span>yes
                        </label>
                        <label for="reffered_specialist_no" class="radio_check width_30 float_left">
                            <input id="reffered_specialist_no" type="radio" name="reffered_specialist" class="radio_check_input" value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>" <?php if($screening[0]->reffered_specialist == 'N'){ echo "selected"; } ?>>
                            <span class="radio_check_holder" ></span>No
                        </label>
                        <div class="hidden_input hide width50 float_left">
                            <input type="text" name="reffered_specialist_text" class="width100" value="" placeholder="Reffered to specialist" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key;?>">  
                        </div>
                    </div>  

                </div>

            </div> 
        </div>
        <div class="width100 display_inlne_block row">
                    <h3>Auditary Screening</h3><hr>
               <div class="form_field width50 select float_left">
                    <div class="label">Left</div>
                    <div class="input top_left">
                        <select name="auditary_screening_left" class="filter_required"  data-errors="{filter_required:'Please select left Auditary Screening'}" data-base="" tabindex="6">
                            <option value="">Select</option>
                            <option value="pass" <?php if($screening[0]->auditary_screening_left == 'pass'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>Pass</option>
                            <option value="fail" <?php if($screening[0]->auditary_screening_left == 'fail'){ echo "selected"; } ?>>Fail</option>
                           
                        </select>
                    </div>
                </div>
               <div class="form_field width50 select float_left">
                    <div class="label">Right</div>
                    <div class="input top_left">
                        <select name="auditary_screening_right" class="filter_required"  data-errors="{filter_required:'Please select Right Auditary Screening'}" data-base="" tabindex="6">
                            <option value="">Select</option>
                            <option value="pass" <?php if($screening[0]->auditary_screening_right == 'pass'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>Pass</option>
                            <option value="fail" <?php if($screening[0]->auditary_screening_right == 'fail'){ echo "selected"; } ?>>Fail</option>
                           
                        </select>
                    </div>
                </div>
         </div>
             <div class="width100 display_inlne_block">
                        <h3>Vision Screening</h3><hr>
<!--            <div class="style6">Vision Screening <span class="md_field">*</span></div>-->

                <div class="width100 display_inlne_block">
             
               <div class="form_field width50 select float_left">
                     <div class="style6">Color blindness <span class="md_field">*</span></div>
                    <div class="input top_left">
                        <select name="color_blindness" class="filter_required"  data-errors="{filter_required:'Please select Left'}" data-base="" tabindex="6">
                            <option value="">Select</option>
                            <option value="yes" <?php if($screening[0]->color_blindness_left == 'yes'){ echo "selected"; } ?>>Yes</option>
                            <option value="no" <?php if($screening[0]->color_blindness_left == 'no'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>No</option>    
                        </select>

                    </div>
                </div>
<!--                <div class="form_field width50 select float_left">
                    <div class="label">Right</div>
                    <div class="input top_left">
                        <select name="color_blindness_right" class="filter_required"  data-errors="{filter_required:'Please select Right'}" data-base="" tabindex="6">
                            <option value="">Select</option>
                            <option value="yes" <?php if($screening[0]->color_blindness_right == 'yes'){ echo "selected"; } ?>>Yes</option>
                            <option value="no" <?php if($screening[0]->color_blindness_right == 'no'){ echo "selected"; } ?>>No</option>    
                        </select>

                    </div>
                </div>-->
  <div class="form_field width50 select float_left">
                        <div class="label">Vision screening</div>
                        <div class="input top_left">
                            <select name="vision_screening" class="filter_required"  data-errors="{filter_required:'Please select Vision screening'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="NAD" <?php if($screening[0]->vision_screening == 'NAD'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; }  ?>>NAD</option>
                                <option value="hypermetropia" <?php if($screening[0]->vision_screening == 'hypermetropia'){ echo "selected"; } ?>>hypermetropia</option>
                                 <option value="myopia" <?php if($screening[0]->vision_screening == 'myopia'){ echo "selected"; } ?>>myopia</option>
                            </select>
                        </div>
                </div>
               </div>
              
               <div class="form_field width100 select float_left">
                    <div class="label">Vision Screening Comment</div>
                    <div class="input top_left">
                      <input name="vision_screening_comment" value="<?=@$screening[0]->vision_screening_comment;?>"  class="form_input width97" placeholder="Comment" data-errors="{filter_required:'Comment should not be blank',filter_number:'Comment should be in numbers'}" type="text" tabindex="18">

                    </div>
                </div>
               <div class="width100 display_inlne_block">
                <div class="display-inline-block width100">
                     <div class="style6">Reffered to specialist</div>

               <div class="width100 float_left on_click_show_input">
                    <label for="vision_reffered_specialist_yes" class="radio_check width_30 float_left">
                         <input id="vision_reffered_specialist_yes" type="radio" name="vision_reffered_specialist" class="radio_check_input" value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>" <?php if($screening[0]->vision_reffered_specialist == 'Y'){ echo "selected"; } ?>>
                         <span class="radio_check_holder" ></span>yes
                    </label>
                    <label for="vision_reffered_specialist_no" class="radio_check width_30 float_left">
                        <input id="vision_reffered_specialist_no" type="radio" name="vision_reffered_specialist" class="radio_check_input" value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>" <?php if($screening[0]->vision_reffered_specialist == 'N'){ echo "selected"; } ?>>
                        <span class="radio_check_holder" ></span>No
                    </label>
                    <div class="hidden_input hide width50 float_left">
                            <input type="text" name="vision_reffered_specialist_text" class="width100" value="" placeholder="Reffered to specialist" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key;?>">  
                    </div>
                </div>  

                 </div>

            </div> 

        </div>
            <div class="width100 display_inlne_block">
            <br>
             <h3>Disability screening </h3><hr>
<!--            <div class="style6">Disability screening <span class="md_field">*</span></div>-->
            <div class="form_field width33 select float_left">
                    <div class="label">Language Delay</div>
                    <div class="input top_left">
                        <select name="disability_language_delay" class=""  data-errors="{filter_required:'Please select Language Delay'}" data-base="" tabindex="6">
                            
                            <option value="NAD" <?php if($screening[0]->language_delay == 'NAD'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; }  ?>>NAD</option>
                            <option value="misarticulation" <?php if($screening[0]->language_delay == 'misarticulation'){ echo "selected"; } ?>>misarticulation</option>
                            <option value="delayed_speech" <?php if($screening[0]->language_delay == 'delayed_speech'){ echo "selected"; } ?>>delayed speech</option>
                            <option value="stammering" <?php if($screening[0]->language_delay == 'stammering'){ echo "selected"; } ?>>stammering</option>
                            <option value="tongue_tie" <?php if($screening[0]->language_delay == 'tongue_tie'){ echo "selected"; } ?>>tongue tie</option>
                        </select>

                    </div>
            </div>
            <div class="form_field width33 select float_left">
                    <div class="label">Behavioural Disorder</div>
                    <div class="input top_left">
                        <select name="behavioural_disorder" class="filter_required"  data-errors="{filter_required:'Please select Behavioural Disorder'}" data-base="" tabindex="6">
                            <option value="">Select</option>
                            <option value="yes" <?php if($screening[0]->behavioural_disorder == 'yes'){ echo "selected"; } ?>>Yes</option>
                            <option value="no" <?php if($screening[0]->behavioural_disorder == 'no'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>No</option>    
                        </select>

                    </div>
            </div>
             <div class="form_field width33 select float_left">
                        <div class="label">Speech Screening </div>
                        <div class="input top_left">
                            <select name="speech_screening" class="filter_required"  data-errors="{filter_required:'Please select Speech screening'}" data-base="" tabindex="6">
                               
                                <option value="NAD" <?php if($screening[0]->vision_screening == 'NAD'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>NAD</option>
                                <option value="stammering" <?php if($screening[0]->vision_screening == 'stammering'){ echo "selected"; } ?>>stammering</option>
                                <option value="voice_abnormal" <?php if($screening[0]->vision_screening == 'voice_abnormal'){ echo "selected"; } ?>>voice abnormal</option>
                                <option value="fluency_abnormal" <?php if($screening[0]->vision_screening == 'fluency_abnormal'){ echo "selected"; } ?>>fluency abnormal</option>
                            </select>
                        </div>
                </div>
             <div class="form_field width100 select float_left">
                    <div class="label">Comment</div>
                    <div class="input top_left">
                        <input name="disability_comment" value="<?=@$screening[0]->disability_comment;?>" class="width97" tabindex="51" data-base="" data-errors="{filter_required:'Comment should not be at least 12 digit long'}" autocomplete="off" type="text">
                    </div>
            </div>
             <div class="width100 display_inlne_block" style="margin-bottom:20px;">
                <div class="display-inline-block width100">
                     <div class="style6">Reffered to specialist</div>

               <div class="width100 float_left on_click_show_input">
                    <label for="disability_reffered_specialist_yes" class="radio_check width_30 float_left">
                         <input id="disability_reffered_specialist_yes" type="radio" name="disability_reffered_specialist" class="radio_check_input" value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>"  <?php if($screening[0]->disability_reffered_specialist == 'Y'){ echo "selected"; } ?>>
                         <span class="radio_check_holder" ></span>yes
                    </label>
                    <label for="disability_reffered_specialist_no" class="radio_check width_30 float_left">
                        <input id="disability_reffered_specialist_no" type="radio" name="disability_reffered_specialist" class="radio_check_input " value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>"  <?php if($screening[0]->disability_reffered_specialist == 'N'){ echo "selected"; } ?>>
                        <span class="radio_check_holder" ></span>No
                    </label>
                    <div class="hidden_input hide width50 float_left">
                            <input type="text" name="vision_reffered_specialist_text" class="width100" value="" placeholder="Reffered to specialist" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key;?>">  
                    </div>
                 
                </div>     

                 </div>

            </div> 

            
       
        </div>
           
<hr><br>
            <div class="width50 float_left">

                <div class="style6"><strong>Birth Defects</strong></div>

<div class="checkbox_input"></div>

                    <div class="hide_screening_checkbox checkbox_div">
                <?php
                $asst_dig = json_decode($screening[0]->birth_deffects);
                $tab = 34;

                if (!empty($birth_effects)) {

                    foreach ($birth_effects as $dig) {
                        $id = $dig->id;

                        $oth_opt = array('Others - specify' => 'birth_eff_other');

                        if (!empty($asst_dig)) {
                                
                            if (in_array($dig->id, $asst_dig)) {
                            

                                $checked[$id] = "checked";

                                $oth_dig = ($dig->birth_effects_title == 'Others - specify') ? 'yes' : '';
                            }
                        }

                        $dig_ids[] = "birth_eff_" . $dig->id;
                        ob_start();
                        ?>

                        <div class="display-inline-block width100">

                            <label for="birth_eff_<?php echo $dig->id; ?>" class="chkbox_check">

                                <input name="birth_eff_[]" class="check_input <?php echo $oth_opt[$dig->birth_effects_title]; ?>" value="<?php echo $dig->id; ?>" data-errors="{filter_either_or:'should not be blank!'}" id="birth_eff_<?php echo $dig->id; ?>" type="checkbox" <?php echo $checked[$id]; ?> tabindex="<?php echo $tab++; ?>"><span class="chkbox_check_holder"></span><?php echo $dig->birth_effects_title; ?>


                            </label>

                        </div>

                        <?php
                        $dig_opt[] = ob_get_contents();

                        ob_get_clean();
                    }
                }


                $html = join("", $dig_opt);

                echo $html = str_replace("(*:ids:*)", join(",", $dig_ids), $html);
                ?>
            </div>
            </div>
            <div class="width50 float_left">

                <div class="style6"><strong>Childhood disease</strong></div>
                <div class="checkbox_input"></div>

                    <div class="hide_screening_checkbox checkbox_div">

                <?php
                $tab = 34;
                $checked_disease = json_decode($screening[0]->childhood_disease);
                if (!empty($childhood_disease)) {

                    foreach ($childhood_disease as $dig) {
                        $diseas_id =  $dig->id;

                        $oth_opt = array('Others - specify' => 'child_dis_other');

                          if (!empty($checked_disease)) {
                                
                            if (in_array($dig->id, $checked_disease)) {

                                $checked[$diseas_id] = "checked";

                                $oth_dig = ($dig->birth_effects_title == 'Others - specify') ? 'yes' : '';
                            }
                        }


                        $child_dis_ids[] = "child_dis_" . $dig->id;
                        ob_start();
                        ?>

                        <div class="display-inline-block width100">
                            <label for="child_dis_<?php echo $dig->id; ?>" class="chkbox_check">

                                <input name="child_dis_[]" class="check_input <?php echo $oth_opt[$dig->childhood_disease_title]; ?>" value="<?php echo $dig->id; ?>" data-errors="{filter_either_or:'should not be blank!'}" id="child_dis_<?php echo $dig->id; ?>" type="checkbox" <?php echo $checked[$diseas_id]; ?> tabindex="<?php echo $tab++; ?>"><span class="chkbox_check_holder"></span><?php echo $dig->childhood_disease_title; ?>


                            </label>

                        </div>

                        <?php
                        $child_dis[] = ob_get_contents();

                        ob_get_clean();
                    }
                }


                $htmt_disease = join("", $child_dis);

                echo $htmt_disease = str_replace("(*:ids:*)", join(",", $child_dis_ids), $htmt_disease);
                ?>
            </div>

            </div>
        <div class="display_inlne_block width100">

            <div class="width50 float_left">

                <div class="style6"><strong>Deficiencies</strong></div>
                <div class="checkbox_input"></div>

                    <div class="hide_screening_checkbox checkbox_div">

                <?php
                $tab = 34;
                $checked_deficienciese = json_decode($screening[0]->childhood_disease);

                if (!empty($deficienciese)) {

                    foreach ($deficienciese as $dig) {
                        $deficienciese_id =  $dig->id;        

                        $oth_opt = array('Others - specify' => 'def_other');

                        if (!empty($checked_deficienciese)) {
                                
                            if (in_array($dig->id, $checked_deficienciese)) {

                                $checked[$deficienciese_id] = "checked";

                                $oth_dig = ($dig->birth_effects_title == 'Others - specify') ? 'yes' : '';
                            }
                        }


                        $def_ids[] = "def_" . $dig->id;
                        ob_start();
                        ?>

                        <div class="display-inline-block width100">

                            <label for="def_<?php echo $dig->id; ?>" class="chkbox_check">

                                <input name="def_[]" class="check_input  <?php echo $oth_opt[$dig->deficiencies_title]; ?>" value="<?php echo $dig->id; ?>" data-errors="{filter_either_or:'should not be blank!'}" id="def_<?php echo $dig->id; ?>" type="checkbox" <?php echo $checked[$deficienciese_id]; ?> tabindex="<?php echo $tab++; ?>"><span class="chkbox_check_holder"></span><?php echo $dig->deficiencies_title; ?>


                            </label>

                        </div>

                        <?php
                        $dif_opt[] = ob_get_contents();

                        ob_get_clean();
                    }
                }


                $def_html = join("", $dif_opt);

                echo $html = str_replace("(*:ids:*)", join(",", $def_ids), $def_html);
                ?>
            </div>

            </div>
            <div class="width50 float_left">

                <div class="style6"><strong>Skin condition</strong></div>

                <div class="checkbox_input"></div>

                    <div class="hide_screening_checkbox checkbox_div">

                <?php
                $tab = 34;
                $checked_skin_condition = json_decode($screening[0]->skin_condition);

                if (!empty($skin_condition)) {

                    foreach ($skin_condition as $dig) {
                        $condition_id =  $dig->id;

                        $oth_opt = array('Others - specify' => 'def_other');

                        if (!empty($checked_skin_condition)) {
                                
                            if (in_array($dig->id, $checked_skin_condition)) {

                                $checked[$condition_id] = "checked";

                                $oth_dig = ($dig->birth_effects_title == 'Others - specify') ? 'yes' : '';
                            }
                        }


                        $skin_ids[] = "skin_" . $dig->id;
                        ob_start();
                        ?>

                        <div class="display-inline-block width100">

                            <label for="skin_<?php echo $dig->id; ?>" class="chkbox_check">

                                <input name="skin_[]" class="check_input <?php echo $oth_opt[$dig->skin_condition_title]; ?>" value="<?php echo $dig->id; ?>" data-errors="{filter_either_or:'should not be blank!'}" id="skin_<?php echo $dig->id; ?>" type="checkbox" <?php echo $checked[$condition_id]; ?> tabindex="<?php echo $tab++; ?>"><span class="chkbox_check_holder"></span><?php echo $dig->skin_condition_title; ?>


                            </label>

                        </div>

                        <?php
                        $skin_opt[] = ob_get_contents();

                        ob_get_clean();
                    }
                }


                $skin_html = join("", $skin_opt);

                echo $html = str_replace("(*:ids:*)", join(",", $skin_ids), $skin_html);
                ?>
            </div>
            </div>

        </div>
        <div class="display_inlne_block width100">

            <div class="width50 float_left">

<!--                <div class="width100">
                 <div class="style6"><strong>Orthopedics</strong></div>
                    <div class="checkbox_input"></div>

                    <div class="hide_screening_checkbox checkbox_div">

                <?php
                $tab = 34;
                $checked_orthopedics = json_decode($screening[0]->orthopedics);

                if (!empty($orthopedics)) {

                    foreach ($orthopedics as $dig) {
                        
                    $orthopedics_id =  $dig->id;

                        $oth_opt = array('Others - specify' => 'def_other');

                        if (!empty($checked_orthopedics)) {
                                
                            if (isset($checked_orthopedics->$orthopedics_id)) {

                                $checked[$orthopedics_id] = "checked";

                                $oth_dig = ($dig->birth_effects_title == 'Others - specify') ? 'yes' : '';
                            }
                        }


                        $ortho_ids[] = "ortho_" . $dig->id;
                        ob_start();
                        ?>

                        <div class="display-inline-block width100">

                            <label for="ortho_<?php echo $dig->id; ?>" class="chkbox_check">

                                <input name="ortho_[<?php echo $dig->id; ?>]" class="check_input filter_either_or[(*:ids:*)] <?php echo $oth_opt[$dig->orthopedics_title]; ?>" value="<?php echo $dig->id; ?>" data-errors="{filter_either_or:'should not be blank!'}" id="ortho_<?php echo $dig->id; ?>" type="checkbox" <?php echo $checked[$orthopedics_id]; ?> tabindex="<?php echo $tab++; ?>"><span class="chkbox_check_holder"></span><?php echo $dig->orthopedics_title; ?>


                            </label>

                        </div>

                        <?php
                        $ortho_opt[] = ob_get_contents();

                        ob_get_clean();
                    }
                }


                $ortho_html = join("", $ortho_opt);

                echo $html = str_replace("(*:ids:*)", join(",", $ortho_ids), $ortho_html);
                ?>
                </div>
            </div>-->
                <div class="width100">
                    <div class="style6"><strong>Check box if normal</strong></div>
                    <div class="checkbox_input"></div>

                    <div class="hide_screening_checkbox checkbox_div">

                        <?php
                        $tab = 34;
                        $checked_normal = json_decode($screening[0]->checkbox_if_normal);
                        if (!empty($normal_checkbox)) {

                            foreach ($normal_checkbox as $dig) {
                                
                                $normal_id =  $dig->id;

                                $oth_opt = array('Others - specify' => 'def_other');

                                if (!empty($checked_normal)) {

                                    if (in_array($dig->id, $checked_normal)) {

                                        $checked[$normal_id] = "checked";

                                        $normal_check = ($dig->birth_effects_title == 'Others - specify') ? 'yes' : '';
                                    }
                                }


                                $normal_check_ids[] = "check_normal_" . $dig->id;
                                ob_start();
                                ?>

                                <div class="display-inline-block width100">

                                    <label for="check_normal_<?php echo $dig->id; ?>" class="chkbox_check">

                                        <input name="check_normal_[]" class="check_input <?php echo $oth_opt[$dig->normal_checkbox_title]; ?>" value="<?php echo $dig->id; ?>" data-errors="{filter_either_or:'should not be blank!'}" id="check_normal_<?php echo $dig->id; ?>" type="checkbox" <?php echo $checked[$normal_id]; ?> tabindex="<?php echo $tab++; ?>"><span class="chkbox_check_holder"></span><?php echo $dig->normal_checkbox_title; ?>


                                    </label>

                                </div>


                                <?php
                                $check_opt[] = ob_get_contents();

                                ob_get_clean();
                            }
                        }


                        $diago_html = join("", $check_opt);

                        echo $html = str_replace("(*:ids:*)", join(",", $normal_check_ids), $diago_html);
                        ?>
                    </div>
                </div>
            </div>
            <div class="width50 float_left">

                <div class="style6"><strong>Diagnosis</strong></div>
                <div class="checkbox_input"></div>

                <div class="hide_screening_checkbox checkbox_div">
                <?php
                $tab = 34;
                $checked_diagnosis = json_decode($screening[0]->diagnosis);
                if (!empty($diagnosis)) {

                    foreach ($diagnosis as $dig) {

                        $diagnosis_id =  $dig->id;
                        $oth_opt = array('Others - specify' => 'def_other');

                        if (!empty($checked_diagnosis)) {

                             if (in_array($dig->id, $checked_diagnosis)) {

                                $checked[$diagnosis_id] = "checked";

                                $diagno = ($dig->birth_effects_title == 'Others - specify') ? 'yes' : '';
                            }
                        }


                        $diago_ids[] = "diagn_" . $dig->id;
                        ob_start();
                        ?>

                        <div class="display-inline-block width100">

                            <label for="diagn_<?php echo $dig->id; ?>" class="chkbox_check">

                                <input name="diagn_[]" class="check_input <?php echo $oth_opt[$dig->diagnosis_title]; ?>" value="<?php echo $dig->id; ?>" data-errors="{filter_either_or:'should not be blank!'}" id="diagn_<?php echo $dig->id; ?>" type="checkbox" <?php echo $checked[$diagnosis_id]; ?> tabindex="<?php echo $tab++; ?>"><span class="chkbox_check_holder"></span><?php echo $dig->diagnosis_title; ?>


                            </label>

                        </div>

                        <?php
                        $diago_opt[] = ob_get_contents();

                        ob_get_clean();
                    }
                }


                $diago_html = join("", $diago_opt);

                echo $html = str_replace("(*:ids:*)", join(",", $diago_ids), $diago_html);
                ?>
                </div>
            </div>

        </div>


    </div>



    <div class="save_btn_wrapper float_left">


        <input type="button" name="accept" value="Accept" class="accept_btn form-xhttp-request" data-href='{base_url}emt/save_student_screening' data-qr="output_position=content"  tabindex="25">


    </div>

    <div class="width100 float_left">
        <br>
    </div>



</form>
<script>

            $("option").each(function() {
            $(this).text($(this).text().charAt(0).toUpperCase() + $(this).text().slice(1));
        });
  
</script>