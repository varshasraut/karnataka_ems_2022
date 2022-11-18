<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/jquery.barrating.min.js"></script> -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<!-- Google Fonts Name :- Poppins -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
<!-- End Google Fonts Name :- Poppins -->

<!-- Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
</script>
<!-- End Bootstrap -->


<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<style>
@import url(https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);
@import url(http://fonts.googleapis.com/css?family=Calibri:400,300,700);

.ques {
    padding: 0 0 5px;

    margin: 20px 0;
    color: white;
    font-size: 22px;
    font-weight: 20px;
    border-radius: 20px;

}

body {
    font-family: 'Roboto';
    font-style: normal;
    background-color: #e6e6e6;
}

.htext,
#htext11 {
    font-size: 45px;
}

.select {
    padding: 2px;
    border: none;
}

.line {
    line-height: 0px;
    margin-top: -8px;
}

.inc_id {
    margin-top: 30px;
    font-size: 20px;
}

#fname {
    display: block;
    margin: auto;
    width: 35%;
    margin-bottom: 30px;
    border-radius: 10px;
}

#fnameh {
    display: block;
    margin: auto;
    width: 35%;
    margin-bottom: 30px;
    border-radius: 10px;
}

.row1 {
    height: auto;
    background-color: #FFFFFF;
    border-radius: 10px 10px 0 0;
    margin: auto;
    font-size: 20px;
    font-style: normal;
    font-weight: 400;

}

.row2 {
    height: auto;
    border-radius: 0 0 10px 10px;
    background-color: #FFFFFF;
}


.margin {
    margin-left: 60px !important;
    margin-bottom: 20px !important;
}

.button {
    font-family: 'Roboto';
    font-style: normal;
    border-radius: 10px;
    text-align: center;
    margin-top: 20px;
}

.btn {
    background-color: #2F7BBF;
    color: white;
    width: 18%;
    font-size:18px;
    box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    margin: auto;
    display: block;
    margin-top: 20px;
    margin-bottom: 20px;
}

.btn:hover {
    color: white;
}

/* #lang {
    text-align: center;
    width: 10%;
    position: absolute;
    top: 12px;
    right: 10px;
} */

.topcon {
    color: #FFFFFF;
}

.logo {
    position: relative;
}

.img1 {
    height: 80px;
    position: absolute;
    left: 45px;
    top: 15px;
    bottom: 0;
}

.img2 {
    height: 80px;
    position: absolute;
    right: 25px;
    top: 8px;
    bottom: 0;
}
input[type='radio']{
    width: 18px;
    height: 18px;
    cursor:pointer;
}

/*****************************/

#htext11,
#htext21,
#htext31,
#htext41,
#fnameh,
#txt11,
#txt12h,
#txt13h,
#txt2h,
#txt21h,
#txt22h,
#txt23h,
#txt3h,
#txt31h,
#txt32h,
#txt33h,
#txt4h,
#txt41h,
#txt42h,
#txt43h,
#txt44h {
    display: none;
}

@media only screen and (max-width: 768px) {
    .row1 {
        width: 95% !important;
    }

    .headtxt {
        margin-top: 15px;
    }

    .htext,
    #htext11 {
        font-size: 27px;
    }

    #htext3,
    #htext31 {
        font-size: 15px;
    }

    #fname {
        width: 50%;
    }

    #fnameh {
        width: 50%;
    }

    #lang {
        width: 30%;
    }

    .line {
        line-height: 15px;
        margin-top: -8px;
    }

    #txt1,
    #txt11,
    #txt2e,
    #txt2h,
    #txt3e,
    #txt3h,
    #txt4e,
    #txt4h {
        font-size: 18px;
        margin: 0;
        margin-top: 20px;
    }

    #txt12e,
    #txt13e,
    #txt12h,
    #txt13h,
    #txt21e,
    #txt21h,
    #txt22e,
    #txt22h,
    #txt23e,
    #txt23h,
    #txt31e,
    #txt31h,
    #txt32e,
    #txt32h,
    #txt33e,
    #txt33h,
    #txt41e,
    #txt41h,
    #txt42e,
    #txt42h,
    #txt43e,
    #txt43h,
    #txt44e,
    #txt44h {
        font-size: 18px;
    }

    .top {
        margin-top: 0 !important;
    }

    .between {
        margin-top: -15 !important;
    }

    .margin {
        margin-left: 30px !important;
        margin-bottom: 20px !important;
    }

    .btn {
        width: 50%;
    }

    .img1 {
        height: 60px;
        position: absolute;
        left:20px;
        top: 2px;
        bottom: 0;
    }

    .img2 {
        height: 60px;
        position: absolute;
        right: 0px;
        top:-9px;
        bottom: 0;
    }
}
</style>
<form method="post" action="{base_url}feedback/save_pt_feedback" name="feedback_list_form" id="feedback_list">

    <input type="hidden" name="feedback[fc_inc_ref_id]" value="<?php echo $inc_ids['inc_ref_id']; ?>" id="inc_id">
    <input type="hidden" name="feedback[fc_inc_type]" value="<?php echo $inc_ids['inc_type'] ?>" id="inc_type">


    <!--incident details -->
    <?php 
    foreach ($epcr_inc_details as $epcr) {
        if ($epcr->epcr_call_type == '1' ) {
            $Pt_available = 'Not-Available';
        }else{
            $Pt_available = 'Available';
        }
    }      
        
    if($clg_user_group!='UG-FeedbackManager'){
        if($Pt_available == 'Available'){
    ?>
    <div class="container-fluid">
        <div class="row topcon" style="text-align:center;background-color:#2F7BBF;">
            <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
                <div style="padding-top:20px;" class="headtxt"><span align="center" id="htext1" class="htext">Patient
                        Feedback Form</span>
                    <!-- <p align="center" id="htext11">रोगी प्रतिक्रिया प्रपत्र</p> -->
                    <!-- <select class="select" id="lang" aria-label="Default select example" onchange="language();">
                                <option value="English"  selected>English</option>
                                <option value="Hindi">हिंदी</option>
                                    
                </select> -->
                </div>
                <p id="head"><b id="htext2">Please answer below questions</b>
                    <!-- <b id="htext21">कृपया नीचे दिए गए सवालों के जवाब दें</b> -->
                </p>
                <p class="line"><b id="htext3">We will work towards making your experience better.</b>
                    <!-- <b id="htext31">हम आपके अनुभव को बेहतर बनाने की दिशा में काम करेंगे।.</b> -->
                </p>
                <p class="inc_id">
                <h4 id="htext4"><span>Incident ID: <?php echo $inc_ids['inc_ref_id'] ?></span></h4>
                <!-- <h4 id="htext41"><span>घटना आईडी: 2022081700001</span></h4> -->
                </p>
            </div>
            <div class="col-lg-12 col-md-12">
                <input type="text" id="fname" name="firstname" placeholder="Your Name" class="form-control" required pattern="[A-Za-z].{1,}" title="Please Enter Valid Name">
                <!-- <input type="text" id="fnameh" name="firstname" placeholder="आपका नाम" class="form-control"> -->
            </div>
        </div>
        <!--<div class="label blue">Questions <span class="md_field">*</span></div>-->
        <?php
        
        if ($ques) {
            $count=1;
            foreach ($ques as $key => $question) {
                ?>
        <div class="width97 questions_row feedback_question">
            <div class="width33 float_left row1 mt-4 p-2 pl-4" ><?php echo $count++.'.  '.$question->que_question;?></div>

            <?php if ($question->que_id == 191) { ?>
            <div class="width_60 hide1 row1 row2">
                <div class="width33 float_left">
                    <label for="ques_<?php echo $question->que_id ?>_dis" class="radio_check width100 float_left">
                        <input id="ques_<?php echo $question->que_id ?>_dis" type="radio"
                            name="feedback[ques][<?php echo $question->que_id ?>]"
                            class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_dis,ques_<?php echo $question->que_id ?>_tret,ques_<?php echo $question->que_id ?>_dead] ml-5"
                            value="discharge" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn"
                            tabindex="16" autocomplete="off">
                        <span class="radio_check_holder ml-1"></span> Discharge/ Recovered
                    </label>
                </div>
                <div class="width33 float_left">
                    <label for="ques_<?php echo $question->que_id ?>_tret" type="radio"
                        name="feedback[ques][<?php echo $question->que_id ?>]" class="radio_check width100 float_left">
                        <input id="ques_<?php echo $question->que_id ?>_tret" type="radio"
                            name="feedback[ques][<?php echo $question->que_id ?>]" type="radio"
                            name="feedback[ques][<?php echo $question->que_id ?>]"
                            class="radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_dis,ques_<?php echo $question->que_id ?>_tret,ques_<?php echo $question->que_id ?>_dead] ml-5"
                            value="treatment_inprogress" data-errors="{filter_either_or:'Answer is required'}"
                            data-base="ques_btn" tabindex="17" autocomplete="off">
                        <span class="radio_check_holder ml-1"></span>Treatment Inprogress
                    </label>
                </div>
                <div class="width33 float_left">
                    <label for="ques_<?php echo $question->que_id ?>_dead" type="radio"
                        name="feedback[ques][<?php echo $question->que_id ?>]" class="radio_check width100 float_left">
                        <input id="ques_<?php echo $question->que_id ?>_dead" type="radio"
                            name="feedback[ques][<?php echo $question->que_id ?>]" type="radio"
                            name="feedback[ques][<?php echo $question->que_id ?>]"
                            class="radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_dis,ques_<?php echo $question->que_id ?>_tret,ques_<?php echo $question->que_id ?>_dead] ml-5"
                            value="dead" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn"
                            tabindex="17" autocomplete="off">
                        <span class="radio_check_holder ml-1"></span>Passed Away
                    </label>
                </div>
            </div>

            <?php } ?>
            <?php if ($question->que_id == 193) { ?>
            <div class="width_60  hide2 row1 row2">
                <div class="width33 float_left">
                    <label for="ques_<?php echo $question->que_id ?>_tl" class="radio_check width100 float_left">
                        <input id="ques_<?php echo $question->que_id ?>_tl" type="radio"
                            name="feedback[ques][<?php echo $question->que_id ?>]"
                            class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_tl,ques_<?php echo $question->que_id ?>_ne,ques_<?php echo $question->que_id ?>_fr,ques_<?php echo $question->que_id ?>_de,ques_<?php echo $question->que_id ?>_ad,ques_<?php echo $question->que_id ?>_ot] ml-5"
                            value="television" data-errors="{filter_either_or:'Answer is required'}"
                            data-base="ques_btn" tabindex="16" autocomplete="off">
                        <span class="radio_check_holder ml-1"></span>News/Television
                    </label>

                </div>
                <div class="width33 float_left">

                    <label for="ques_<?php echo $question->que_id ?>_ne" class="radio_check width100 float_left">
                        <input id="ques_<?php echo $question->que_id ?>_ne" type="radio"
                            name="feedback[ques][<?php echo $question->que_id ?>]"
                            class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_tl,ques_<?php echo $question->que_id ?>_ne,ques_<?php echo $question->que_id ?>_fr,ques_<?php echo $question->que_id ?>_de,ques_<?php echo $question->que_id ?>_ad,ques_<?php echo $question->que_id ?>_ot] ml-5"
                            value="news" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn"
                            tabindex="16" autocomplete="off">
                        <span class="radio_check_holder ml-1"></span>Advertisement
                    </label>


                </div>
                <div class="width33 float_left">
                    <label for="ques_<?php echo $question->que_id ?>_fr" class="radio_check width100 float_left">
                        <input id="ques_<?php echo $question->que_id ?>_fr" type="radio"
                            name="feedback[ques][<?php echo $question->que_id ?>]"
                            class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_tl,ques_<?php echo $question->que_id ?>_ne,ques_<?php echo $question->que_id ?>_fr,ques_<?php echo $question->que_id ?>_de,ques_<?php echo $question->que_id ?>_ad,ques_<?php echo $question->que_id ?>_ot] ml-5"
                            value="friends" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn"
                            tabindex="16" autocomplete="off">
                        <span class="radio_check_holder ml-1"></span>Friends/Family
                    </label>



                </div>
                <div class="width33 float_left">

                    <label for="ques_<?php echo $question->que_id ?>_ot" class="radio_check width100 float_left">
                        <input id="ques_<?php echo $question->que_id ?>_ot" type="radio"
                            name="feedback[ques][<?php echo $question->que_id ?>]"
                            class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_tl,ques_<?php echo $question->que_id ?>_ne,ques_<?php echo $question->que_id ?>_fr,ques_<?php echo $question->que_id ?>_de,ques_<?php echo $question->que_id ?>_ad,ques_<?php echo $question->que_id ?>_ot] ml-5"
                            value="other" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn"
                            tabindex="16" autocomplete="off">
                        <span class="radio_check_holder ml-1"></span>Other
                    </label>


                </div>
            </div>
            <?php } ?>

            <?php if ($question->que_id == 192) { ?>
            <div class="width_60  hide3 row1 row2">
                <div class="width33 float_left">
                    <label for="ques_<?php echo $question->que_id ?>_ex" class="radio_check width100 float_left">
                        <input id="ques_<?php echo $question->que_id ?>_ex" type="radio"
                            name="feedback[ques][<?php echo $question->que_id ?>]"
                            class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_ex,ques_<?php echo $question->que_id ?>_gd,ques_<?php echo $question->que_id ?>_av] ml-5"
                            value="excellent" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn"
                            tabindex="16" autocomplete="off">
                        <span class="radio_check_holder ml-1"></span>Excellent
                    </label>
                </div>
                <div class="width33 float_left">

                    <label for="ques_<?php echo $question->que_id ?>_gd" class="radio_check width100 float_left">
                        <input id="ques_<?php echo $question->que_id ?>_gd" type="radio"
                            name="feedback[ques][<?php echo $question->que_id ?>]"
                            class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_ex,ques_<?php echo $question->que_id ?>_gd,ques_<?php echo $question->que_id ?>_av] ml-5"
                            value="good" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn"
                            tabindex="16" autocomplete="off">
                        <span class="radio_check_holder ml-1" ></span>Good
                    </label>

                </div>
                <div class="width33 float_left">
                    <label for="ques_<?php echo $question->que_id ?>_av" class="radio_check width100 float_left">
                        <input id="ques_<?php echo $question->que_id ?>_av" type="radio"
                            name="feedback[ques][<?php echo $question->que_id ?>]"
                            class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_ex,ques_<?php echo $question->que_id ?>_gd,ques_<?php echo $question->que_id ?>_av] ml-5"
                            value="average" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn"
                            tabindex="16" autocomplete="off">
                        <span class="radio_check_holder ml-1"></span>Average
                    </label>
                </div>
            </div>
            <?php } ?>

            <?php if ($question->que_id == 190) { ?>
            <div class="width_60 row1 row2">
                <div class="width33 float_left">
                    <label for="ques_<?php echo $question->que_id ?>_yes" class=" radio_check width100 float_left">
                        <input id="ques_<?php echo $question->que_id ?>_yes" type="radio"
                            name="feedback[ques][<?php echo $question->que_id ?>]"
                            class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_yes,ques_<?php echo $question->que_id ?>_no] ml-5 "
                            value="yes" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn"
                            tabindex="16" autocomplete="off">
                        <span class="radio_check_holder ml-1"></span> Yes
                    </label>
                    <!-- </div>
                            <div class="width33 float_left">    -->
                    <label for="ques_<?php echo $question->que_id ?>_no" class="radio_check width100 float_left">
                        <input id="ques_<?php echo $question->que_id ?>_no" type="radio"
                            name="feedback[ques][<?php echo $question->que_id ?>]"
                            class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_yes,ques_<?php echo $question->que_id ?>_no]  ml-4"
                            value="no" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn"
                            tabindex="16" autocomplete="off"> 
                        <span class="radio_check_holder ml-1"></span> No
                    </label>

                </div>

            </div>

            <?php } ?>


        </div>
        <?php
            }
        }
        ?>
   

    <?php } }?>
    <div class="float_left width100">

        <input type="submit" id="submit" name="submit" value="Submit" class=" btn" >
       
    </div>
    <div class="row logo">
        <div class="col-md-6 col-lg-6"><img src="<?php echo base_url(); ?>assets/images/Spero_logo1.png" class="img1"></div>
        <div class="col-md-6 col-lg-6"><img src="<?php echo base_url(); ?>assets/images/jaes_logo.png" class="img2"></div>
    </div>
</form>
</div>
<script>
    $('#ques_190_no').click(function() {
    $('.hide1').hide();
    $('.hide2').hide();
    $('.hide3').hide();
    $('input').removeClass('has_error');
    $('input').removeClass('filter_either_or[ques_191_dis,ques_191_tret,ques_191_dead]');
    $('input').removeClass('filter_either_or[ques_192_ex,ques_192_gd,ques_192_av]');
    $('input').removeClass(
        'filter_either_or[ques_193_tl,ques_193_ne,ques_193_fr,ques_193_de,ques_193_ad,ques_193_ot]');
});
$('#ques_190_yes').click(function() {
    $('.hide1').show();
    $('.hide2').show();
    $('.hide3').show();
    //  $('input').addClass('has_error');
    $('input').addClass('filter_either_or[ques_191_dis,ques_191_tret,ques_191_dead]');
    $('input').addClass('filter_either_or[ques_192_ex,ques_192_gd,ques_192_av]');
    $('input').addClass(
        'filter_either_or[ques_193_tl,ques_193_ne,ques_193_fr,ques_193_de,ques_193_ad,ques_193_ot]');
});
</script>