var CAItem, NCAItem, MEDItem, EQPItem;


jQuery(document).ready(function () {

    reset_mi_cookie();

    var cur_autocom;


    //$("body").append("<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCVgFhdOAhLy-jj7lDyUDFh0QRwIe6gYo4&libraries=places&callback=init_auto_address&country:in'></script>");


    $login_height =$('.login_wrapper .trans_box').height()/2;
    $l_height = $(window).height()-$login_height;
    //console.log($l_height);
    $('.login_wrapper').css({'padding-top': $l_height + 'px !important'});


    ////////////////////////////////////////////////////////////////////////
    $(document).on("click", ".list_icon", function () {
        $(".header_top_link").css({'display': 'none'});
        $("#home_nav_bar").removeClass('hide');
        $("#home_nav_bar").css({'display': 'block'});
        $(".navigation").css({'display': 'block'});

    });
    $('#container').on("click", ".navigation ul li a", function () {
        $("#home_nav_bar").css({'display': 'none'});
        $(".header_top_link").css({'display': 'block'});
        return false;
    });

    $(document).on("click", ".menu_icon a", function () {
        $(".header_top_link").css({'display': 'block'});
        $(".navigation").css({'display': 'none'});
    });


    $(document).on("blur", "#clg_ref_id", function () {

        var res = xhttprequest($(this), base_url + 'clg/is_exists', 'clg_ref_id=' + $(this).val());


    });
    jQuery('body').on("blur", "#user_name_id",  function(){
        var $user_name_id = $("#user_name_id").val();
        //xhttprequest($(this), base_url + 'clg/show_extenstion', 'user_name_id='+$user_name_id);
        xhttprequest($(this), base_url + 'clg/show_avaya_extenstion', 'user_name_id='+$user_name_id);
    });
     jQuery('body').on("blur", "#user_password_id",  function(){
        var $user_name_id = $("#user_name_id").val();
       // xhttprequest($(this), base_url + 'clg/show_extenstion', 'user_name_id='+$user_name_id);
        xhttprequest($(this), base_url + 'clg/show_avaya_extenstion', 'user_name_id='+$user_name_id);
    });

    $(document).on("blur", "#clg_email", function () {

        var dq = 'clg_email=' + $(this).val();

        if ($('#ud_clg_id').val()) {
            dq = dq + '&ud_clg_id=' + $('#ud_clg_id').val();
        }

        xhttprequest($(this), base_url + 'clg/is_exists', dq);

    });




    ///////////////////////////// Added by MI42 ////////////////////////////



    $(document).on("blur", "#add_caller_details #last_name,#add_caller_details #caller_no", function () {



        if ($(this).attr('id') == 'caller_no') {


            $('#clr_rcl').html('<input type="hidden" name="fcrel" value="yes">');

        } else {

            $('#clr_rcl').html('');

        }

        $("#submit_call").trigger('click');



    });



    ////////////////////// Added by MI42 ( Inv Stock req ) /////////////////////



    var indx, str, url;



    $(document).on("click", ".NCA_more", function () {

        indx = $(".NCA_item > .NCA_blk").size();

        $(".NCA_item").append($("#NCA_tmp").html().replace(/indx/g, indx).replace(/autocls/g, 'mi_autocomplete').replace(/dataurl/g, url));

        init_autocomplete();


    });


    $(document).on("click", ".CA_more", function () {

        indx = $(".CA_item > .CA_blk").size();


        $(".CA_item").append($("#CA_tmp").html().replace(/indx/g, indx).replace(/autocls/g, 'mi_autocomplete'));

        init_autocomplete();

    });



    $(document).on("click", ".MED_more", function () {

        indx = $(".MED_item > .MED_blk").size();

        $(".MED_item").append($("#MED_tmp").html().replace(/indx/g, indx).replace(/autocls/g, 'mi_autocomplete'));

        init_autocomplete();

    });



    $(document).on("click", ".EQP_more", function () {

        indx = $(".EQP_item > .EQP_blk").size();

        $(".EQP_item").append($("#EQP_tmp").html().replace(/indx/g, indx).replace(/autocls/g, 'mi_autocomplete'));

        init_autocomplete();

    });
    $(document).on("click", ".followup_more", function () {

        indx = $(".followup_details_box > .followup_blk").size();

        $(".followup_details_box").append($("#corona_add_more").html().replace(/indx/g, indx).replace(/autocls/g, 'mi_autocomplete'));

      

    });
    $(document).on("click", ".add_patient_more", function () {

   
        var $pnt_cnt_ero = parseInt($("#pt_count_ero_popup").val());
        var $pnt_cnt_dco =parseInt($("#pt_count_popup").val());

        var $pnt_cnt = $pnt_cnt_ero - $pnt_cnt_dco + 5;
        indx = $(".epcr_patient > .patient_blk").size();
        var $total_ptn = indx+1;

//        if($total_ptn >= $pnt_cnt){
//            return false;
//        }
        
        sr_idx = indx +1;
        $(".epcr_patient").append($("#patient_add_more").html().replace(/indx/g, indx).replace(/autocls/g, 'mi_autocomplete').replace(/sr_idx/g,sr_idx).replace(/flt_reg/g, 'filter_required').replace(/fil_wo/g, 'filter_words'));
        
      

    });
    $('#container').on("click", ".remove_button_followup", function () {
        
        $(this).closest('div.followup_class').remove();
        
    });
    $('#container').on("click", ".remove_patient_more", function () {
        
        $(this).closest('div.patient_hide_class').remove();
        
    });
    
     $(document).on("click", ".image_more", function () {

        $(".images_main_block").append('<div class="upload_images_block"><div class="images_upload_block"><input type="file" name="amb_photo[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18" class="files_amb_photo" > </div></div>');

    });






    setTimeout(function () {

        $("#group").trigger('change');

    }, 3000);





    ////////////////////// Added by MI42 ( Error display ) /////////////////////////





    $(document).on("click", ".field_error", function () {



        $(".field_error").removeClass("field_error_show");

        $(this).closest(".field_error").addClass("field_error_show");



    });



    $(document).on("mouseover", ".field_error", function () {



        $(".field_error").removeClass("field_error_show");

        $(this).closest(".field_error").addClass("field_error_show");



    });





    /////////////////////////// Added by MI42 ///////////////////////////////





    $("#colorbox").removeAttr("tabindex");



    $(document).on("keyup", "textarea", function () {



        var len = $(this).attr('data-maxlen');



        $(this).attr('maxlength', len);



    });



    /////////////////////////// Added by MI42 ///////////////////////////////





    $(document).on("change", ".ptn_other_dis", function () {





        if ($(this).is(':checked')) {



            $('.ex_label').remove();



            $('.past_med_his').append(" <div class='field_input'><div class='input'><input name='his_odis' class='filter_required'  value='' tabindex='1' type='text' data-errors=\"{filter_required:'Other should not be blank!'}\" placeholder='Other Specify'></div></div>");



        } else {





            $('.past_med_his .field_input').remove();



            $('.past_med_his').append("<div class='form_field ex_label'><div class='label'>&nbsp;</div></div>");



        }



    });





    $(document).on("change", ".ptn_other_cs", function () {



        if ($(this).is(':checked')) {



            $('.type_case').append("<div class='form_field width50 float_left'><br><div class='input'><input name='his_ocs' class='form_input filter_required' value='' data-errors=\"{filter_required:'Other case should not be blank!'}\" placeholder='Other case type' type='text'></div></div>");



        } else {

            $('.type_case .form_field').remove();

        }



    });





    $(document).on("change", ".ptn_other_cc", function () {



        if ($(this).is(':checked')) {



            $('.cf_comp #get_answer').append("<div class='form_field width50 float_left'><br><div class='input'><input name='his_occ' class='form_input filter_required' value='' data-errors=\"{filter_required:'Chief complaint should not be blank!'}\" placeholder='Other chief complaint' tabindex='32' type='text'></div></div>");



        } else {

            $('.cf_comp #get_answer .form_field').remove();

        }



    });





    $(document).on("change", ".ptn_other_dig", function () {



        if ($(this).is(':checked')) {



            $('.box_type1').append("<div class='form_field width50'><br><div class='input'><input name='add_asst[asst_other_pdignosis]'  class='form_input' value='' placeholder='Other specify'  type='text' tabindex='32'></div></div>");



        } else {

            $('.box_type1 .form_field').remove();

        }



    });



    ////////////////////////// MI42 ( Incident filter errors ) ///////////////////////





    $(document).on("keyup", ".inc_id_filt", function () {



        if ($(this).val() == '') {





            $('.inc_date_filt').parent().parent().find('.label .md_field').html('*');



            $('.inc_date_filt').addClass('filter_required');



            $('.inc_date_filt').removeClass('filter_if_not_blank');



            $('.inc_date_filt').attr("data-errors=\"{filter_required:'Incident date should not be blank',filter_date:'Date format is not valid'}\"");





            $('.inc_time_filt').parent().parent().find('.label .md_field').html('*');



            $('.inc_time_filt').addClass('filter_required');



            $('.inc_time_filt').removeClass('filter_if_not_blank');



            $('.inc_time_filt').attr("data-errors=\"{filter_required:'Incident time should not be blank',filter_time:'Time format is not valid'}\"");



        } else {







            if ($('.inc_date_filt').hasClass('has_error')) {



                $('.inc_date_filt').removeClass('has_error');



                $('.inc_date_filt').parent().removeClass('field_error');



                $('.inc_date_filt').parent().removeClass('field_error_show');



            }



            $('.inc_date_filt').parent().parent().find('.label .md_field').html('&nbsp;');



            $('.inc_date_filt').removeClass('filter_required');



            $('.inc_date_filt').addClass('filter_if_not_blank');



            $('.inc_date_filt').attr("data-errors=\"\"");





            ///////////////////////////////////////////////////////





            if ($('.inc_time_filt').hasClass('has_error')) {



                $('.inc_time_filt').removeClass('has_error');



                $('.inc_time_filt').parent().removeClass('field_error');



                $('.inc_time_filt').parent().removeClass('field_error_show');



            }



            $('.inc_time_filt').parent().parent().find('.label .md_field').html('&nbsp;');



            $('.inc_time_filt').removeClass('filter_required');



            $('.inc_time_filt').addClass('filter_if_not_blank');



            $('.inc_time_filt').attr("data-errors=\"\"");



        }



    });



    /////////////////////////// Added by MI42 ///////////////////////////////





    $(document).on("click", ".cancel_btn", function () {



        $("#cboxClose").click();



    });





    $(document).on("click", ".fbox_close", function () {



        $(".float_box_outer").hide();



    });





    ///////////////////////////// MI44 Enquiry call question cookie/////////////////////////////////

    $(document).on("click", ".checked_que", function () {





        var id = [];

        var d = new Date();

        $('input[type="checkbox"].checked_que:checked').each(function (i, val) {



            id[i] = $(this).val();

        });





        d.setTime(d.getTime() + (7 * 24 * 60 * 60 * 1000));

        var expires = "expires=" + d.toUTCString();

        var cname = 'set_question';

        document.cookie = cname + "=" + id + ";" + expires + ";path=/";



    });







});









/////////////////// Added by MI42 ( Active PCR steps tab ) /////////////////





function cur_pcr_step(step) {



    $('#PCR_STEPS li').removeClass('pcr_active_tab');



    $("[data-pcr_step='" + step + "'").parent('li').addClass('pcr_active_tab');



}





/////////////////// Added by MI42 ( load feedback que/ans ) /////////////////





function get_fque(ft) {



    xhttprequest($(this), base_url + 'feedback/qa_list', 'ft_id=' + ft['id']);



}



/////////////////// Added by MI42 ( load MADV ans ) /////////////////





function get_madv_ans(ft) {
    //console.log(ft['id']);
    if (ft['id'] == '243') {
        $('#madv_other').removeClass('hide');
        $('#madv_ans').html('');

    } else {
        $('#madv_other').addClass('hide');
        xhttprequest($(this), base_url + 'Ercpcall/get_madv_ans', 'que_id=' + ft['id']);
    }
}




/////////////////// Added by MI42 /////////////////





function get_ca_item(ft) {



    xhttprequest($(this), base_url + 'inv_stock/get_con_item', 'inv_id=' + ft['id'] + '&inv_type=CA');



}





function get_nca_item(ft) {



    xhttprequest($(this), base_url + 'inv_stock/get_con_item', 'inv_id=' + ft['id'] + '&inv_type=NCA');



}



function get_med_item(ft) {



    xhttprequest($(this), base_url + 'inv_stock/get_med_item', 'med_id=' + ft['id']);



}



/////////////////// Added by MI42 /////////////////





function load_auto_amb_district(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_district', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }

}

function load_auto_clo_comp_amb_district(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_closer_district', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }

}
function load_auto_break_amb_district(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_break_maint_district', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }

}
function load_auto_preventive_amb_district(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_preventive_district', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
}
function load_auto_onroad_offroad_maint(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_onroad_offroad_district', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);

}
function load_auto_fuel_amb_district(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_fuel_closer_district', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }

}
function load_auto_oxygen_amb_district(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_oxygen_closer_district', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);

}
function load_auto_vahicle_amb_district(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_vahicle_closer_district', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);

}
function load_auto_demo_amb_district(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_demo_closer_district', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);

}
function load_auto_acc_amb_district(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_acc_closer_district', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }

}
function load_auto_inspection_amb_district(ft, data_auto, rel, tab){
    xhttprequest($(this), base_url + 'auto/auto_inspection_closer_district', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }
}
function load_auto_accident_amb_district(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_accident_closer_district', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }

}
function load_auto_tyre_amb_district(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_tyre_closer_district', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }

}


function load_auto_police_district(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_police_district', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
}

function load_auto_fire_district(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_fire_district', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
}
function load_auto_tahsil_police_station(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_police_station', 'dst_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
   //console.log(ft['id']);
    //xhttprequest($(this), base_url + 'auto/auto_police_tahsil', 'dst_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
}

function load_auto_police_station(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_police_station', 'dst_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    //xhttprequest($(this), base_url + 'auto/auto_fire_tahsil', 'dst_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
}

function load_auto_fire_tahsil(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_fire_station', 'dst_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    // xhttprequest($(this), base_url + 'auto/auto_fire_tahsil', 'dst_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
}

function load_auto_fire_station(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_fire_station', 'dst_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    // xhttprequest($(this), base_url + 'auto/auto_fire_tahsil', 'dst_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
}

function load_auto_police_info(ft, data_auto, rel, tab) {

    xhttprequest($(this), base_url + 'police_calls/get_police_station_information', 'p_id=' + ft['id']);

}

function load_auto_fire_info(ft, data_auto, rel, tab) {

    xhttprequest($(this), base_url + 'fire_calls/get_fire_station_information', 'f_id=' + ft['id']);

}



function load_auto_dist_tahsil(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_dist_tahsil', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }
}

function load_auto_dist(ft, data_auto, rel, tab) {
    //console.log("Hi", base_url);
    xhttprequest($(this), base_url + 'auto/auto_dist', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
	//console.log(jQuery('#add_inc_details_block').length);
    if (jQuery('#add_inc_details_block').length > 0) {
        //console.log("Test",ft['value']);
         //get_location_by_address(ft['value']);
    }
}


function load_auto_dist_amb(ft, data_auto, rel, tab) {
 console.log(ft['id']);
    xhttprequest($(this), base_url + 'auto/auto_dist_ambulance/'+ ft['id'], 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
         get_location_by_address(ft['value']);
    }
}
function load_div_district(ft, data_auto, rel, tab){

    xhttprequest($(this), base_url + 'auto/get_district_by_div', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
}
function load_district_on_div(ft){
    
     xhttprequest($(this), base_url + 'clg/get_district_by_div', 'div_code=' + ft['id']);
}

function load_auto_tahsil(ft, data_auto, rel, tab) {
 
    xhttprequest($(this), base_url + 'auto/auto_tal', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    console.log(jQuery('#inc_temp_hospital').length);

    if (jQuery('#get_ambu_details').length > 0) {
        
        $inc_type = $('#inc_type').val();
        
        $('#get_ambu_details').attr('href',base_url+'inc/get_inc_ambu?district_id='+ft['id']+'&inc_type='+$inc_type);
        $("#get_ambu_details").click();
//          var $Url =  "https://places.ls.hereapi.com/places/v1/discover/search?in=19.0760%2C72.8777%3Br%3D4717093&recd=false&size=100&tf=html&X-Mobility-Mode=drive&Accept-Language=en&app_id=hSm0zJfek39BQxeXGRYZ&app_code=46aPkrbrHTb7tEdxSzLMiA"
//    
//    $.get($Url,function($data){
//        console.log($data);
//    });
    }
	if (jQuery('#inc_temp_hospital').length > 0) {
        
        xhttprequest($(this), base_url + 'inc/inc_temp_hospital', 'dist_code=' + ft['id']);
    }
        
    if (jQuery('#add_inc_details_block').length > 0) {
        if (typeof google != 'undefined') {
            //get_location_by_address(ft['value']);
        }
    }
}

function load_auto_ambulance(ft, data_auto, rel, tab) {

    xhttprequest($(this), base_url + 'auto/auto_amb', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        if (typeof google != 'undefined') {
            get_location_by_address(ft['value']);
        }
    }
}

function load_auto_closer_comp_ambulance(ft, data_auto, rel, tab) {

    xhttprequest($(this), base_url + 'auto/auto_closer_amb', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }
}
function load_auto_closer_comp_ambulance_gri(ft, data_auto, rel, tab) {

    xhttprequest($(this), base_url + 'auto/auto_closer_amb_gri', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }
}

function load_auto_preventive_ambulance(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_preventive_amb', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
}
function load_auto_onroad_offroad_ambulance(ft, data_auto, rel, tab) {

    xhttprequest($(this), base_url + 'auto/auto_onroad_offroad_amb', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }
}
function load_auto_acc_comp_ambulance(ft, data_auto, rel, tab) {

    xhttprequest($(this), base_url + 'auto/auto_acc_amb', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }
}
function load_auto_inspection_comp_ambulance(ft, data_auto, rel, tab){
    xhttprequest($(this), base_url + 'auto/auto_inspection_amb', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }
}
function load_auto_accidental_comp_ambulance(ft, data_auto, rel, tab) {

    xhttprequest($(this), base_url + 'auto/auto_accidental_amb', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }
}
function load_auto_tyre_comp_ambulance(ft, data_auto, rel, tab) {

    xhttprequest($(this), base_url + 'auto/auto_tyre_amb', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }
}
function load_auto_closer_fuel_ambulance(ft, data_auto, rel, tab) {

    xhttprequest($(this), base_url + 'auto/auto_fuel_closer_amb', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }
}
function load_auto_closer_oxygen_ambulance(ft, data_auto, rel, tab) {

    xhttprequest($(this), base_url + 'auto/auto_oxygen_closer_amb', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }
}
function load_auto_vahicle_ambulance(ft, data_auto, rel, tab) {

    xhttprequest($(this), base_url + 'auto/auto_vahicle_closer_amb', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }
}
function load_auto_demo_ambulance(ft, data_auto, rel, tab) {

    xhttprequest($(this), base_url + 'auto/auto_demo_clo_amb', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }
}
function load_auto_break_ambulance(ft, data_auto, rel, tab) {

    xhttprequest($(this), base_url + 'auto/auto_break_clo_amb', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        get_location_by_address(ft['value']);
    }
}
function get_base_location(ft) {

    xhttprequest($(this), base_url + 'shift_roster/district_base_location', 'district_id=' + ft['id']);

    var $schedule_week = $("#schedule_week").val();
    var $schedule_end_week = $("#schedule_end_week").val();
    var $schedule_start_week = $("#schedule_start_week").val();
    var $schedule_month = $("#schedule_month").val();

    xhttprequest($(this), base_url + 'shift_roster/load_district_wise_team_list', 'district_id=' + ft['id'] + '&schedule_week=' + $schedule_week + '&schedule_end_week=' + $schedule_end_week + '&schedule_start_week=' + $schedule_start_week + '&schedule_month=' + $schedule_month);

}

function shift_timeinterval(ft) {


    var $valuestart = $("#shift_from_time").val();
    var $valuestop = $("#shift_to_time").val();


    //create date format          
    var timeStart = new Date("01/01/2007 " + $valuestart).getHours();
    var timeEnd = new Date("01/01/2007 " + $valuestop).getHours();

    var $hourDiff = timeEnd - timeStart;

    $("#shift_total_hours_time").val($hourDiff);

}

function update_base_location(ft) {


    xhttprequest($(this), base_url + 'fleet/update_amb_base_location', 'amb_id=' + ft['id']);

}
function update_onroad_offroad_base_location(ft) {


    xhttprequest($(this), base_url + 'fleet/update_onroad_offroad_base_location', 'amb_id=' + ft['id']);

}

function update_base_location_fuel(ft) {

    $fuel_filling_type = $(".radio_check_input:checked").val();
    xhttprequest($(this), base_url + 'fleet/update_amb_base_location_fuel_filling', 'amb_id=' + ft['id']+'&fuel_filling_type='+$fuel_filling_type);

}
function update_base_location_oxygen(ft) {


    xhttprequest($(this), base_url + 'fleet/update_amb_base_location_oxygen', 'amb_id=' + ft['id']);

}
function update_base_location_vahicle(ft) {


    xhttprequest($(this), base_url + 'fleet/update_amb_base_location_vahicle', 'amb_id=' + ft['id']);

}
function update_base_location_demo(ft) {


    xhttprequest($(this), base_url + 'fleet/update_amb_base_location_demo', 'amb_id=' + ft['id']);

}
function update_base_location_break(ft) {


    xhttprequest($(this), base_url + 'fleet/update_amb_base_location_break', 'amb_id=' + ft['id']);

}
function update_base_location_acc(ft) {


    xhttprequest($(this), base_url + 'fleet/update_amb_base_location_acc', 'amb_id=' + ft['id']);

}
function update_base_location_inspection(ft){
    xhttprequest($(this), base_url + 'inspection/update_base_location_inspection', 'amb_id=' + ft['id']);
}
function update_base_location_accidental(ft) {


    xhttprequest($(this), base_url + 'fleet/update_base_location_accidental', 'amb_id=' + ft['id']);

}
function update_base_location_tyre(ft) {


    xhttprequest($(this), base_url + 'fleet/update_base_location_tyre', 'amb_id=' + ft['id']);

}
function update_preventive_location(ft) {


    xhttprequest($(this), base_url + 'fleet/update_base_location_preventive', 'amb_id=' + ft['id']);

}
function get_fuel_station_data(ft) {

    xhttprequest($(this), base_url + 'fleet/get_fuel_station_address', 'f_id=' + ft['id']);

}




function load_auto_city(ft, data_auto, rel, tab) {
    xhttprequest($(this), base_url + 'auto/auto_tal', 'st_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    xhttprequest($(this), base_url + 'auto/auto_city', 'dst_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    
      if (jQuery('#get_ambu_details').length > 0 && rel != 'home_dtl') {
        $inc_id = $( "input[name*='inc_id']" ).val();
        
         $inc_type = $('#inc_type').val();
         
          var $chief_complete = $("#chief_complete_outer .mi_autocomplete").val();
          
        $('#get_ambu_details').attr('href',base_url+'inc/get_inc_ambu?district_id='+ft['id']+'&inc_ref_id='+$inc_id+'&inc_type='+$inc_type+'&chief_complete='+$chief_complete);
        $("#get_ambu_details").click();
    }
      if (jQuery('#inc_temp_hospital').length > 0) {
        
        xhttprequest($(this), base_url + 'inc/inc_temp_hospital', 'dist_code=' + ft['id']);
    }
        
    
    //console.log(ft['value']);
    if (jQuery('#add_inc_details_block').length > 0) {
        //get_location_by_address(ft['value']);
    }
}
function load_auto_inc_tahsil(ft, data_auto, rel, tab) {

    xhttprequest($(this), base_url + 'auto/auto_city_tahsil', 'thshil_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
//    if(jQuery('#add_inc_details_block').length > 0){
//        get_location_by_address_tahsil(ft['value']);
//    }
}
function load_auto_inc_city(ft, data_auto, rel, tab) {

    // xhttprequest($(this), base_url + 'auto/auto_city_tahsil', 'thshil_code=' + ft['id'] + '&auto=' + data_auto + '&dt_rel=' + rel + '&tab=' + tab);
    if (jQuery('#add_inc_details_block').length > 0) {
        if (typeof google != 'undefined') {
            //get_location_by_address_city(ft['value']);
        }
    }

}





/////////////////// Added by MI42 ( Get autocomplete address details ) /////////////////





function init_auto_address($input) {

    if (typeof $input == 'undefined') {
        $input = 'pac-input';
    }

    $("#pac-input").autocomplete({
        select: function( event, ui ) {
          
            $.get(ui.item.href,function($data){
                //console.log($data);
                var $place_details = $data.location;
                auto_fill($place_details);
                
                
                //set_inc_main_pin($place_details);
                //set_inc_add_details($place_details);
            });

       // console.log(  ui.item );
        },
         source: function (request, response) {
             //console.log(response);
             $.ajax({
                //url: "https://places.ls.hereapi.com/places/v1/autosuggest?in=34.083813%2C74.809463%3Br%3D5000000&size=1000&tf=plain&addressFilter=stateCode%3DMH&X-Mobility-Mode=drive&X-Political-View=IND&Accept-Language=en&app_id=hSm0zJfek39BQxeXGRYZ&app_code=46aPkrbrHTb7tEdxSzLMiA&apiKey=yrjPrIYd0xU9KJpe1xlaR1_K1wFrwc9U-_-99n040JQ",
                url: "https://places.ls.hereapi.com/places/v1/discover/search?in=19.0760%2C72.8777%3Br%3D4717093&recd=false&size=100&tf=html&X-Mobility-Mode=drive&Accept-Language=en&app_id=hSm0zJfek39BQxeXGRYZ&app_code=46aPkrbrHTb7tEdxSzLMiA",
                 data: { q: request.term },
                 dataType: "json",
                 success: function ($data) {
                     
                     

//                    var $items = $data.results;
//                    $.each($items,function(){
//                        this.label = this.title;
//                    });
                   // console.log($data);
                   // response($items);
                    //return $items;
                       var $items = $data.results.items;
                    $.each($items,function(){
                        
                        this.title = this.title.replace('<br/>',' ');
                        this.vicinity = this.vicinity.replace('<br/>',' ');
                        this.label = this.title+' '+this.vicinity;
                        var $inc_type = $('#inc_type').val();
                        if($inc_type == 'PICK_UP'){
                         $inc_map_address = $("#inc_map_address").val(this.label);
                     }
                    });
                    
                    response($items);
                 },
                 error: function () {
                     response([]);
                 }
             });
         }
    });            

//    var input = document.getElementById($input);
//
//    var options = {
//        //types: ['geocode'],
//        types: ['geocode'],
//        componentRestrictions: {country: 'IN'}
//
//    };
//    
//    $autoplace  = new google.maps.places.SearchBox(input, options);
//    $autoplace.addListener('places_changed', auto_fill_address);



}

function auto_fill_address(){
    
   var places = $autoplace.getPlaces();
    if (places.length > 0) {
        auto_fill(places[0]);
    }
    
}

//function init_auto_address($input) {
//
//    if (typeof $input == 'undefined') {
//        $input = 'pac-input';
//    }         

//    var input = document.getElementById($input);
//
//    var options = {
//        //types: ['geocode'],
//        types: ['geocode'],
//        componentRestrictions: {country: 'in'}
//
//    };
//
//
//
//    $autoplace = new google.maps.places.Autocomplete(input, options);
//
//
//
//    cur_autocom = $(input).attr('data-rel');
//
//    //console.log(cur_autocom);
//
//    $autoplace.addListener('place_changed', auto_fill);



//}



function auto_fill($place_details) {


 var input = document.getElementById('pac-input');
 cur_autocom = $(input).attr('data-rel');


    var auto = $('.' + cur_autocom);
     // console.log(auto);




    //////////////////////////////////////////////////////////////////////



    var dt_rel, dt_auto_addr, dt_state, dt_dist, dt_city, dt_area, dt_lmark, dt_lane, dt_pin, loc_state, loc_dist, loc_city, loc_area, loc_pin, data_qr, tab, loc_thl, dt_thl, dt_lat, dt_log;



    tab = auto.attr('tabindex');



    dt_rel = auto.attr('data-rel');
   
    if(typeof dt_rel == 'undefined'){
        dt_rel = 'incient';
    }


    dt_auto_addr = auto.attr('data-auto');



    dt_state = auto.attr('data-state');



    dt_dist = auto.attr('data-dist');

    dt_thl = auto.attr('data-thl');



    dt_city = auto.attr('data-city');



    dt_area = auto.attr('data-area');



    dt_pin = auto.attr('data-pin');

    dt_lat = auto.attr('data-lat');

    dt_log = auto.attr('data-log');




    ////////////////////////////////////////////////////////////////





    var place = $place_details;



    var map_obj = document.getElementById('googleMap');


    var p_lat = place.position[0];
    var p_lng = place.position[1];



   // initMap({lat: p_lat, lng: p_lng}, map_obj);
    
    loc_dist = place.address.county;
    loc_city =  place.address.district;
    loc_state = place.address.state;
    loc_area =  place.address.area;
    loc_pin = place.address.postalCode;
    loc_thl = place.address.city;






    /////////////////////////////////////////////////////////////////////



    data_qr = "dt_auto_addr=" + dt_auto_addr + "&dt_rel=" + dt_rel + "&dt_state=" + dt_state + "&dt_dist=" + dt_dist + "&dt_thl=" + dt_thl + "&dt_city=" + dt_city + "&dt_area=" + dt_area + "&dt_pin=" + dt_pin + "&loc_state=" + loc_state + "&loc_dist=" + loc_dist + "&loc_city=" + loc_city + "&loc_area=" + loc_area + "&loc_thl=" + loc_thl + "&loc_pin=" + loc_pin + "&dt_lat=" + p_lat + "&dt_log=" + p_lng + "&tab=" + tab;







    xhttprequest($(this), base_url + 'auto/manage_addr', data_qr);



}



//////////////////////////////////////////////////

function reset_mi_cookie() {

    var ck = ['CAitems', 'NCAitems', 'MEDitems', 'EQPitems'];

    ck.forEach(function (element) {
        mi_set_cookie(element, '', -1);
    });

}

function mi_set_cookie(cname, cvalue, exdays) {

    var d = new Date();

    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));

    var expires = "expires=" + d.toUTCString();

    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";

    localStorage.setItem(cname, cvalue);

}
function forceReq(ft) {
    
    if (jQuery.cookie("CAitems") == '') {
        mi_set_cookie('CAitems', ft['id'], 5);
    } else {

        CAItem = jQuery.cookie("CAitems");
        CAItem = CAItem + ',' + ft['id'];
        mi_set_cookie('CAitems', CAItem, 5);
    }
    
//    $remove_item = $('.CA_blk').closest('div.forcecode').attr('id');
//    console.log($remove_item);
    
    $('.non_consumable_drugs,.medicine_drugs,.consumables_drugs').removeClass('filter_required');
    $('.non_consumable_drugs,.medicine_drugs,.consumables_drugs').removeClass('has_error');

}

function CAReq(ft) {
    if (jQuery.cookie("CAitems") == '') {

        mi_set_cookie('CAitems', ft['id'], 5);


    } else {

        CAItem = jQuery.cookie("CAitems");

        CAItem = CAItem + ',' + ft['id'];

        mi_set_cookie('CAitems', CAItem, 5);

    }
     //console.log($(this).val());
    $('.non_consumable_drugs,.medicine_drugs,.consumables_drugs').removeClass('filter_required');
    $('.non_consumable_drugs,.medicine_drugs,.consumables_drugs').removeClass('has_error');

}

function NCAReq(ft) {

    if (jQuery.cookie("NCAitems") == '') {

        mi_set_cookie('NCAitems', ft['id'], 5);


    } else {

        NCAItem = jQuery.cookie("NCAitems");

        NCAItem = NCAItem + ',' + ft['id'];

        mi_set_cookie('NCAitems', NCAItem, 5);

    }
    //  console.log($(this).val());
    $('.non_consumable_drugs,.medicine_drugs,.consumables_drugs').removeClass('filter_required');
    $('.non_consumable_drugs,.medicine_drugs,.consumables_drugs').removeClass('has_error');
}

function MEDReq(ft) {



    if (jQuery.cookie("MEDitems") == '') {

        mi_set_cookie('MEDitems', ft['id'], 5);


    } else {

        MEDItem = jQuery.cookie("MEDitems");

        MEDItem = MEDItem + ',' + ft['id'];

        mi_set_cookie('MEDitems', MEDItem, 5);

    }
    $('.non_consumable_drugs,.medicine_drugs,.consumables_drugs').removeClass('filter_required');
    $('.non_consumable_drugs,.medicine_drugs,.consumables_drugs').removeClass('has_error');
}
function load_auto_ward(ft) {
    xhttprequest($(this), base_url + 'auto/auto_ward', 'dst_code=' + ft['id'] );
   
}


function EQPReq(ft) {

    if (jQuery.cookie("EQPitems") == '') {

        mi_set_cookie('EQPitems', ft['id'], 5);


    } else {

        EQPItem = jQuery.cookie("EQPitems");

        EQPItem = EQPItem + ',' + ft['id'];

        mi_set_cookie('EQPitems', EQPItem, 5);

    }
}