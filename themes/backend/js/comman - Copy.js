// JavaScript Document created by Jolly Shete



/*
 Selectors :
 dblclick-xhttp-request
 click-xhttp-request
 change-xhttp-request
 */



var disableddates = "";
var active_positions = '';
var objarray = new Array();
var xhttprequestpool = new Array();
var requestcnt = 0;
var base_select_cnt = new Array();
var request_setting = {};



var keyboard = 'english';



var active_nav = false;



var keycode = Array();



function xhttprequest(element_obj, rurl, qr) {



    try {



        var xhttprequestid = Math.random().toString(36).slice(2);



        if (qr == "") {



            var qr = element_obj.data('qr');



        }



        var queries = [];



        if ($.type(qr) === "string" && qr != "") {



            $.each(qr.split('&'), function (c, q) {



                var input_field_obj = {};



                var i = q.split('=');



                elm_name = i[0].toString();



                i = i.splice(1, i.length);



                eml_value = i.join('=').toString();



                input_field_obj.name = elm_name;



                input_field_obj.value = unescape(eml_value);



                queries = queries.concat(input_field_obj);



            });



        } else {



            queries = qr;



        }



        queries = queries.concat({'name': 'xhttprequestid', 'value': xhttprequestid});



        queries = queries.concat({'name': 'reqtype', 'value': 'ajax'});



        queries = queries.concat({'name': 'reqfor', 'value': 'data'});



        queries = queries.concat({'name': 'keyboard', 'value': keyboard});



        if (request_setting.showprocess != "no") {



            $('#container').attr('class', request_setting.module_name);



        }



        $('#content').attr('class', request_setting.tool_code);



        $('#rightsidecontent').attr('class', request_setting.tool_code);



        $('#leftsidebar').attr('class', request_setting.tool_code);



        if (rurl == "" && element_obj.attr('href')) {



            rurl = element_obj.attr('href');



        }



        if (rurl == "" && element_obj.data('href')) {



            rurl = element_obj.data('href');



        }



        post_data = {

            url: rurl,

            type: "POST",

            beforeSend: function () {



                if (request_setting.showprocess != "no") {



                    requestcnt++;



                    $('#request').delay(50).fadeIn('fast');



                    $('#mi_loader').fadeIn('fast');



                    ///    $('#request').html("<div class='success'>Processing Your Request...</div>");



                }



            },

            cache: false



        }



        if (request_setting.hasfiles != 'yes') {



            post_data.data = queries;



        } else {



            formdata = {};



            $('#mi_loader').fadeIn('fast');



            if (window.FormData) {



                formdata = new FormData();



                $.each(queries, function (c, q) {



                    var input_field_obj = {};



                    $.each(q, function (c1, q1) {



                        if (c1 == 'name') {



                            input_field_obj.name = q1.toString();



                        }



                        if (c1 == 'value') {



                            input_field_obj.value = unescape(q1.toString());



                        }



                    });



                    formdata.append(input_field_obj.name, input_field_obj.value);



                });



                var files = $("#" + request_setting.formid + " input:file");



                if (files) {



                    $.each(files, function (index, filecontainer) {



                        if (filecontainer.files.length > 0) {



                            for (var fileindex = 0; fileindex < filecontainer.files.length; fileindex++) {



                                file = filecontainer.files[fileindex];// actual file object



                                var filereader = new FileReader();



                                filereader.onload = (function (theFile) {



                                    formdata.append(filecontainer.name, theFile);



                                })(file);



                                filereader.readAsDataURL(file);



                            }



                        }



                    });



                }



            }



            post_data.data = formdata;



            post_data.processData = false;



            post_data.contentType = false;



        }



        xhttprequestpool[xhttprequestid] = $.ajax(post_data).done(function (result) {



            process_output(result);



        });



    } catch (e) {



        alert(e);



    }



    return false;



}



$.fn.validate = function () {



    try {



        var self = $(this);



        if (!$(this).attr('class')) {



            return false;



        }



        if ($(this).attr('data-for')) {



            $("[name='" + $(this).attr('data-for') + "']").validate();



            return false;



        }



        classes = $(this).attr('class').split(' ');



        $.is_error = 0;



        var filter_required_drag = 0;



        var filter_required_select_area = 0;



        if ($(this).hasClass("filter_if_not_blank") && $(this).val() == "") {



            return true;



        }



        //var element_val = $(this).val().replace(/(<([^>]+)>)/ig,"");



        var element_val = $(this).val() ? String($(this).val()).replace(/(<([^>]+)>)/ig, "") : "";

		
		




        var comp_attr = $(this).attr('data-exists') ? $(this).attr('data-exists') : "";



		element_val = element_val.replace(/^\s\s*/,'');



        for (var it = 0; it < classes.length; it++) {



            selector = classes[it].replace('\r\n', '', 'g').split(/[\[\]]/g);



            switch (selector[0]) {



                case "filter_if_not_empty":



                    var otherselctor = selector[1].replace('\r\n', '', 'g');



                    if (otherselctor) {



                        if ($('#' + otherselctor).val().replace('\r\n', '', 'g') == "") {



                            return true;



                        }



                    }



                    break;



                case "filter_required":



                    if (($(this).attr('type') == 'checkbox' || $(this).attr('type') == 'radio')) {



                        element_name = $(this).attr('name').split('[');



                        if (element_name.length == 2) {



                            var selected_cnt = 0;



                            $('input[name*="' + element_name[0] + '["]').each(function (index) {



                                if ($(this).prop('checked')) {



                                    selected_cnt = 1;



                                }



                            });



                            if (selected_cnt == 0) {



                                $.is_error = 1;



                            }



                        } else if (!$(this).prop('checked')) {



                            $.is_error = 1;



                        }



                    } else if (element_val == "") {



                        $.is_error = 1;



                    }



                    break;



                case "filter_either_or" :



                    /// alert($(this).attr('name'));



                    classes1 = $(this).attr('class').split(' ');



                    for (var it = 0; it < classes1.length; it++) {



                        selector1 = classes1[it].replace('\r\n', '', 'g').split(/[\[\]]/g);



                        if (selector1[0] == "filter_either_or") {



                            ids = selector1[1].split(',')



                        }



                    }



                    var selected_cnt = 0;



                    var filter_either_or = 0;



                    if (ids !== "") {



                        for ($i = 0; $i < ids.length; $i++) {



                            if (($(this).attr('type') == 'checkbox' || $(this).attr('type') == 'radio')) {



                                if ($('#' + ids[$i]).prop('checked')) {



                                    selected_cnt = 1;



                                    filter_either_or = 1;



                                    break;



                                }



                            } else {



                                if ($('#' + ids[$i]).val()) {



                                    selected_cnt = 1;



                                    filter_either_or = 1;



                                    break;



                                }



                            }



                        }



                    }



                    if (selected_cnt == 0) {



                        $.is_error = 1;



                    }



                    break;



                case "filter_no_whitespace":



                    whitespace = new RegExp("\\s", "gi");



                    if (whitespace.test(element_val)) {



                        $.is_error = 1;



                    }



                    break;



                case "filter_time_hms":



                    element_val = element_val.replace(/\s+/g, '');



                    var time_string = "^(2[0-3]|1[0-9]|0[0-9]|[^0-9][0-9]):([0-5][0-9]|[0-9]):([0-5][0-9]|[0-9])$";



                    var regstring = new RegExp(time_string, "gi");



                    if (!regstring.test(element_val)) {



                        $.is_error = 1;



                    }



                    break;
                    
                 case "filter_time_hm":



                    element_val = element_val.replace(/\s+/g, '');



                    var time_string = "^(2[0-3]|1[0-9]|0[0-9]|[^0-9][0-9]):([0-5][0-9]|[0-9])$";



                    var regstring = new RegExp(time_string, "gi");



                    if (!regstring.test(element_val)) {



                        $.is_error = 1;



                    }



                    break;



                case "filter_email":



                    regstring = new RegExp("^[a-zA-Z0-9]+[a-zA-Z0-9_-ॐ]*(_a-z0-9-]+)*@[a-z0-9]+([-_a-z0-9]+)*(ॐ[a-z]{2,4})$", "gi");



                    regstringsecond = new RegExp("^[a-zA-Z0-9]+[a-zA-Z0-9_-ॐ]*([_a-z0-9-]+)*@[a-z0-9]+([-_a-z0-9]+)*(ॐ[a-z]{2})ॐ([a-z]{2})$", "gi");



                    replacedot = new RegExp("\\.", "gi");



                    testemail = element_val;



                    if (element_val) {



                        if (regstring.test(element_val.replace(replacedot, "ॐ"))) {



                        } else if (regstringsecond.test(element_val.replace(replacedot, "ॐ"))) {



                        } else {



                            $.is_error = 1;



                        }



                    }



                    break;



                case "filter_number": //if(!/[0-9]/.test(element_val)){ $.is_error = 1;}



                    if (!/^\d+$/.test(element_val)) {



                        $.is_error = 1;



                    }else{
						
						$(this).val(element_val);
						
					}



                    break;



                case "filter_float": //if(!/[0-9]/.test(element_val)){ $.is_error = 1;}



                    if (!/^\d+(\.\d{0,2})?$/.test(element_val)) {



                        $.is_error = 1;



                    }



                    break;



                case "filter_time":



                    element_val = element_val.replace(/\s+/g, '');



                    var time_string = "^((0[0-9])|(1[0-2])|([1-9]))(AM|PM){1}-((0[0-9])|(1[0-2])|([1-9]))(AM|PM){1}$";



                    var regstring = new RegExp(time_string, "gi");



                    if (!regstring.test(element_val)) {



                        $.is_error = 1;



                    }



                    break;



                case "filter_greater_than_zero":



                    if (element_val <= 0) {



                        $.is_error = 1;



                    }



                    break;



                case "filter_csn":// comma seprated numers



                    field_val = element_val.split(",");



                    for (var nIt = 0; nIt < field_val.length; nIt++) {



                        if (!/\d/.test(field_val[nIt])) {



                            $.is_error = 1;



                        }



                    }



                    break;



                case "filter_string":



                    if (!/^[a-zA-Z0-9_\- ]+$/.test(element_val)) {



                        $.is_error = 1;



                    }



                    break;



                case "filter_word":



                    if (!/^[a-zA-Z]+$/.test(element_val)) {



                        $.is_error = 1;



                    }



                    break;



                case "filter_text":



                    if (!/^[A-Za-z0-9\s!@#$%^&*()_+=-`~\\\]\[{}|';:\.,?><  ]+$/.test(element_val)) {



                        $.is_error = 1;



                    }



                    break;



                case "filter_words":



                    if (!/^[a-zA-Z ]+$/.test(element_val)) {



                        $.is_error = 1;



                    }



                    break;



                case "filter_agree":



                    if (($(this).attr('type') == 'checkbox' || $(this).attr('type') == 'radio')) {



                        if (!$(this).prop('checked')) {



                            $.is_error = 1;



                        }



                    }



                    break;



                case "filter_minlength":



                    if (parseInt(selector[1]) >= 0) {



                        if (element_val.length <= parseInt(selector[1])) {



                            $.is_error = 1;



                        }



                    }



                    break;



                case "filter_maxlength":



                    if (parseInt(selector[1]) >= 0) {



                        if (element_val.length >= parseInt(selector[1])) {



                            $.is_error = 1;



                        }



                    }



                    break;



                case "filter_rangelength":



                    range = selector[1].split('-');



                    if (element_val >= parseInt(range[0]) && element_val <= parseInt(range[1])) {



                    } else {



                        $.is_error = 1;



                    }



                    break;
                    
                 case "filter_valuegreaterthan":

                 

                    range = selector[1];
                 



                    if (element_val >= parseInt(range)) {



                    } else {



                        $.is_error = 1;



                    }



                    break;



                case "filter_equalto":



                    if (parseInt(selector[1]) >= 0) {



                        if (element_val != parseInt(selector[1])) {



                            $.is_error = 1;



                        }



                    } else {



                        otherselctor = selector[1].replace('\r\n', '', 'g');



                        if (element_val != $('#' + otherselctor).val()) {



                            $.is_error = 1;



                        }



                    }



                    break;



                case "filter_lessthan":



                    if (selector[1].replace('\r\n', '', 'g').split("-").length >= 2) {



                        var cw_date = selector[1].replace('\r\n', '', 'g').split("-");



                        var check_with_date = new Date(cw_date[2] + '-' + cw_date[1] + '-' + cw_date[0]);



                        var c_date = element_val.replace('\r\n', '', 'g').split("-");



                        var check_date = new Date(c_date[2] + '-' + c_date[1] + '-' + c_date[0]);



                        if (check_date > check_with_date) {



                            $.is_error = 1;



                        }



                    } else if (element_val.split("-").length >= 2) {



                        otherselctor = selector[1].replace('\r\n', '', 'g');



                        var check_with_date = new Date($('#' + otherselctor).val());



                        var check_date = new Date(element_val);



                        if (check_date > check_with_date) {



                            $.is_error = 1;



                        }



                    } else if (parseInt(selector[1]) >= 0) {



                        if (element_val > parseInt(selector[1])) {



                            $.is_error = 1;



                        }



                    } else {



                        otherselctor = selector[1].replace('\r\n', '', 'g');



                        if (parseInt(element_val) > $('#' + otherselctor).val()) {



                            $.is_error = 1;



                        }



                    }



                    break;



                case "filter_gretherthan":



                    if (selector[1].replace('\r\n', '', 'g').split("-").length >= 2) {



                        var check_with_date = new Date(selector[1].replace('\r\n', '', 'g'));



                        var check_date = new Date(element_val);



                        if (check_date < check_with_date) {



                            $.is_error = 1;



                        }



                    } else if (element_val.split("-").length >= 2) {



                        var check_with_date = new Date($('#' + otherselctor).val());



                        var check_date = new Date(element_val);



                        if (check_date < check_with_date) {



                            $.is_error = 1;



                        }



                    } else if (parseInt(selector[1]) >= 0) {



                        if (element_val < parseInt(selector[1])) {



                            $.is_error = 1;



                        }



                    } else {



                        otherselctor = selector[1].replace('\r\n', '', 'g');



                        if (element_val < $('#' + otherselctor).val()) {



                            $.is_error = 1;



                        }



                    }



                    break;



                case "filter_url":



                    urlregexp = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/



                    if (!urlregexp.test(element_val)) {



                        $.is_error = 1;



                    }



                    break;



                case "filter_date":



                    date_format = "d-m-Y";



                    dateFormat = date_format.split(/[/.-]/g);



                    if (dateFormat[0] == "Y" && dateFormat[1] == "m" && dateFormat[2] == "d") {



                        date_string = "^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$";



//                                            date_string = "([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})";



                    } else if (dateFormat[0] == "m" && dateFormat[1] == "d" && dateFormat[2] == "Y") {



                        date_string = "([0-9]{1,2})-([0-9]{1,2}-[0-9]{4})";



                    } else if (dateFormat[0] == "d" && dateFormat[1] == "m" && dateFormat[2] == "Y") {



                        date_string = "^([0-9]{1,2})-([0-9]{1,2})-([0-9]{4})$";



                    }



                    var regstring = new RegExp(date_string, "gi");



                    if ((element_val != " ") && (regstring.test(element_val))) {



                    } else {



                        $.is_error = 1;



                    }



                    break;



                case "filter_percentage":



                    if (!/^[a-zA-Z0-9_\- %]+$/.test(element_val)) {



                        $.is_error = 1;



                    }



                    break;



                case "filter_required_drag":



                    if (element_val == "") {



                        filter_required_drag = 1;



                    }



                    break;



                case "filter_required_select_area":



                    if (element_val == "") {



                        filter_required_select_area = 1;



                    }



                    break;



                case "filter_is_exists":

                    if (comp_attr == 'yes') {

                        $.is_error = 1;

                    }

                    break;



            }



            if (filter_required_select_area == 1) {



                $(this).addClass('has_error');



                var message = eval("(" + $(this).data('errors') + ")");



                $(this).parent().parent().attr('data-activeerror', message[selector[0]]);



                $(this).parent().parent().addClass('field_error');



            }



            if (filter_required_drag == 1)



            {



                var message = eval("(" + $(this).data('errors') + ")");



                $(this).addClass('has_error');



                return false;



            }



            if ($.is_error == 1) {



                ///alert('error');



                if ($(this).hasClass('mi_autocomplete')) {



                    auto_element = $("input[data-for='" + $(this).attr('name').trim() + "']");



                    auto_element.addClass('has_error');



                }



                $(this).addClass('has_error');



                var message = eval("(" + $(this).data('errors') + ")");



                //// $('html,body').clearQueue().animate({scrollTop: $(this).offset().top - 110});



                if ($(this).hasClass("mi_editor")) {



                    $(this).closest(".jqte").parent().attr('data-activeerror', message[selector[0]]);



                    $(this).closest(".jqte").parent().addClass('field_error');



                } else {



                    $(this).parent().attr('data-activeerror', message[selector[0]]);



                    $(this).parent().addClass('field_error');



                }



                return false;



            }



        }



        if ($.is_error == 0) {



            // alert('no error');



            if ($(this).hasClass("mi_editor")) {



                $(this).closest(".jqte").parent().attr('data-activeerror', "");



                $(this).closest(".jqte").parent().removeClass('field_error');



            } else {



                $(this).parent().attr('data-activeerror', "");



                $(this).parent().removeClass('field_error');



                $(this).parent().removeClass('field_error_show');



            }



            if ($(this).hasClass('mi_autocomplete')) {



                auto_element = $("input[data-for='" + $(this).attr('name').trim() + "']");



                auto_element.removeClass('has_error');



            }



            $(this).removeClass('has_error');



            //////////////// Added by MI42 //////////////////



            if ($(this).attr('type') == 'radio') {



                var rdnm1 = ($(this).attr('name'));



                $("input[type='radio']").each(function () {



                    var rdnm2 = ($(this).attr('name'));



                    if (rdnm1 == rdnm2) {



                        rdnm2 = 'input[name="' + rdnm2 + '"]';



                        $(rdnm2).removeClass('has_error');



                        $(rdnm2).parent().attr('data-activeerror', "");



                        $(rdnm2).parent().removeClass('field_error');



                        $(rdnm2).parent().removeClass('field_error_show');



                    }



                });



            } else if ($(this).attr('type') == 'checkbox') {



                var cbnm = ($(this).attr('name')).split("[");



                $("input[type='checkbox']").each(function () {



                    var cbnm1 = ($(this).attr('name')).split("[");



                    if (cbnm[0] == cbnm1[0]) {



                        $(this).removeClass('has_error');



                        $(this).parent().attr('data-activeerror', "");



                        $(this).parent().removeClass('field_error');



                        $(this).parent().removeClass('field_error_show');



                    }



                });



            }



            ////////////////////////////////////////////////////////



            return true;



        }



        if (filter_required_select_area == 0) {



            $(this).parent().parent().attr('data-activeerror', "");



            $(this).parent().parent().removeClass('field_error');



            $(this).parent().parent().removeClass('field_error_show');



        }



    } catch (e) {



        alert(e);



    }



    return true;



}



function expired_session_cleanup() {



    alert("Session expired: Please login again");



}



function createCookie(name, value, days) {



    if (days) {



        var date = new Date();



        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));



        var expires = "; expires=" + date.toGMTString();



    } else

        var expires = "";



    document.cookie = name.trim() + "=" + value + expires + ";domain=''; path=/";



}



//google.load("elements", "1", {



//	packages: "transliteration"



//});



function init_autocomplete() {



    var autocnt = 0;

    var autofileds = new Array();

    $('#container .mi_autocomplete').each(function (index) {



        $(this).hide();



        var elementvalue = "";



        var placeholder = "";



        var marathi_keyboard = "";



        var sel_filter_required = "";



        var dataerrors = "";



        var tabindex = "";



        var time_filter = "";



        var mapcanvas = "";



        var controls = "";



        var disabled = "";



        if ($(this).attr('data-value')) {



            elementvalue = $(this).attr('data-value');



        }



        if ($(this).attr('name')) {



            elementname = $(this).attr('name').trim();



        }



        if ($(this).attr('disabled')) {



            disabled = $(this).attr('disabled');



        }



        if ($(this).attr('placeholder')) {



            placeholder = $(this).attr('placeholder');



        }



        if ($(this).attr('tabindex')) {



            tabindex = $(this).attr('tabindex');



        }



        if ($(this).attr('data-errors')) {



            dataerrors = $(this).attr('data-errors');



        }



        if ($(this).hasClass('mi_set_keyboard')) {



            marathi_keyboard = "mi_set_keyboard";



        }



        if ($(this).hasClass('filter_required')) {



            sel_filter_required = "filter_required";



        }



        if ($(this).hasClass('inc_time_filt')) {



            time_filter = "inc_time_filt";



        }



        if ($(this).hasClass('map_canvas')) {



            mapcanvas = "map_canvas";



        }



        if ($(this).hasClass('controls')) {



            controls = "controls";



        }



        if ($(this).parent().find('.mi_autocomplete_input').length <= 0) {



            $(this).parent().append('<input type="text" class="mi_autocomplete_input ' + sel_filter_required + ' ' + marathi_keyboard + ' ' + time_filter + ' ' + mapcanvas + ' ' + controls + '" data-href="' + $(this).attr('data-href') + '" data-for="' + elementname + '"  data-errors="' + dataerrors + '" value="' + elementvalue + '"  placeholder="' + placeholder + '"  tabindex="' + tabindex + '" ' + disabled + ' ></input>');



            /**********************************/





            autofileds[autocnt] = $(this).parent().find('.mi_autocomplete_input');



            //////////////////////// Added by MI42 /////////////////////////////


            var auto_addr;



            ///alert(kcode);



            var ele_name = $('input[name="' + $(this).attr('data-for') + '"]');


			

            if (ele_name.attr('data-autocom') == 'yes') {

                $(this).val($(this).val().replace(/^\s\s*/, ''));

            }





            var dq = "";



            var src = autofileds[autocnt].data('href') + dq;



            autofileds[autocnt].autocomplete({

                source: src,

                autoFocus: true,

                minLength: 0,

                focus: function () {



                    return false;



                },

                create: function (event, ui) {},

                search: function (event, ui) {



                    var kcode = event.keyCode || event.which;



                    if (kcode == 40) { // 40 down down arraow

                        event.preventDefault();

                        $(this).trigger("click");







                    }



                },

                select: function (event, ui) {



                    if ($(this).parent().find('.mi_autocomplete').length > 0) {



                        $(this).parent().find('.mi_autocomplete').val(ui.item.id);



                        if ($(this).parent().find('.mi_autocomplete').data('callback-href')) {



                            var qr = $(this).parent().find('.mi_autocomplete').attr("name") + "=" + ui.item.id;



                            if ($(this).parent().find('.mi_autocomplete').data('qr')) {



                                qr = qr + "&" + $(this).parent().find('.mi_autocomplete').data('qr');



                                $.each(qr.split('&'), function (c, q) {



                                    var i = q.split('=');



                                    request_setting[i[0].toString()] = i[1].toString();



                                });



                            }



                            xhttprequest($(this).parent().find('.mi_autocomplete'), $(this).parent().find('.mi_autocomplete').data('callback-href'), qr);



                        }



                    }





                    if ($(this).parent().find('.mi_autocomplete').data('callback-funct')) {



                        callback_function_name = $(this).parent().find('.mi_autocomplete').data('callback-funct');



                        var data_auto = $(this).parent().find('.mi_autocomplete').data('auto');



                        var rel = $(this).parent().find('.mi_autocomplete').data('rel');



                        var tab = $(this).parent().find('.mi_autocomplete').attr('tabindex');



                        window[callback_function_name](ui.item, data_auto, rel, tab);



                    }



                },

                change: function (event, ui) {
					
					
					
				var ele_name = $('input[name="' + $(this).attr('data-for') + '"]');
					
				
				if(ui.item==null && ele_name.attr('data-autocom') == 'yes'){
					
					$(this).parent().find('.mi_autocomplete').val($(this).val().replace(/^\s\s*/,''));;
					
				}else if(ui.item==null){
					
					$(this).parent().find('.mi_autocomplete').val('');
					
					if(ele_name.attr('data-nonedit')=='yes'){
						
						$(this).val('');  
						
					}
					
					
					
				}
				
				
                },
			 blur: function (event, ui) {
					
				var ele_name = $('input[name="' + $(this).attr('data-for') + '"]');
					
				
				if(ui.item==null && ele_name.attr('data-autocom') == 'yes'){
					
					$(this).parent().find('.mi_autocomplete').val($(this).val().replace(/^\s\s*/,''));;
					
				}else if(ui.item==null){
					
					$(this).parent().find('.mi_autocomplete').val('');
					
					
					if(ele_name.attr('data-nonedit')=='yes'){
						
						$(this).val('');  
						
					}
					
					
					
				}
				
				
                }
				



            }).click(function () {



                $(this).autocomplete("search", "  ");

            });







            /************************************/

            autocnt++





        }



    });



}



function init_editor() {



    $('#container .mi_editor').each(function (index) {



        var editorid = "";



        if ($(this).attr('id')) {



            editorid = $(this).attr('id');



        } else {



            editorid = Math.random().toString(36).slice(2);



            $(this).attr('id', editorid);



        }



        if ($('#' + editorid).closest(".jqte").length != 1) {



            $('#' + editorid).jqte();



        }



    });



}



function  close_popup() {



    $('#mi_global_popup').empty();



    $('#mi_global_popup').html('<div></div>');



    $('#mipopup').colorbox.close();



    $('#mipopup').colorbox.remove();



}



function set_focus(element) {

	

    element = element.trim();



    if (element != "") {



        if ($('#' + element).hasClass('mi_autocomplete')) {



            if ($('#' + element).parent().find('.mi_autocomplete_input').length > 0) {



                $('#' + element).parent().find('.mi_autocomplete_input').focus();



            }



        } else {



            $('#' + element).focus();



        }



    }



}



function update_tabindex(set_focus) {



    var tabindex = 1;



    $('input,select,textarea').each(function () {



        if (this.type != "hidden") {



            var $input = $(this);



            $input.attr("tabindex", tabindex);



            $input.attr("autocomplete", 'off');



            if (set_focus == true) {



                if ($input.attr("data-setfocus") == 'true') {



                    if ($input.hasClass('mi_autocomplete')) {



                        if ($input.parent().find('.mi_autocomplete_input').length > 0) {



                            $input.parent().find('.mi_autocomplete_input').focus();



                        }



                    } else {



                        $input.focus();



                    }



                }



            }



            tabindex++;



        }



    });



}



function show_popup(htmltext, ppwidth, ppheight, ismessage) {



    if (!ppwidth || ppwidth <= 0) {



        ppwidth = 400;



    }



    if (!ppheight || ppheight <= 0) {



        ppheight = 250;



    }



    if (!ismessage) {



        ismessage = false;



    }



    msgtype = "";



    if ($('#container').find('#mi_global_popup').length <= 0) {



        $('#popupconitainer').append('<div id="mi_global_popup"   data-popupwidth="' + ppwidth + '" data-popupheight="' + ppheight + '">Loding...</div>');



    } else {



        $('#mi_global_popup').attr('data-popupwidth', ppwidth);



        $('#mi_global_popup').attr('data-popupheight', ppheight);



    }



    if ($('#container').find('#mipopup').length <= 0) {



        $('#container').append("<a id='mipopup' href='#mi_global_popup'></a>");



    }



    if ($('#container').find('#mipopup').length <= 0) {



        return false;



    }



    if (ismessage) {



        var msg = $("<div>" + htmltext + "</div>");



        if (msg.find('.error').length > 0) {



            msgtype = "Error";



        }



        if (msg.find('.success').length > 0) {



            msgtype = "Success";



        }



        if (msgtype != "") {



            msgtype = '<div align="center" style="clear:both; width:100%"><div class="box_head text_align_center"><h3>' + msgtype + '</h3></div><br/></div>';



        }



        msg = htmltext;



        htmltext = msgtype + '<div align="center"  style="clear:both; width:100%">' + msg + '</div>';



        htmltext = htmltext + '<div align="center"  style="clear:both; width:100%"><br/><br/><input name="btnclosebox" value="Ok" class="btnclosemipopup"  type="button"></div>';



    }



    if ($("#colorbox").css("display") == "block") {



        $('#mi_global_popup').html(htmltext);



        $('#mipopup').colorbox.resize({

            width: parseInt(ppwidth) + 'px',

            height: parseInt(ppheight) + 'px'



        });



    }



    if ($("#colorbox").css("display") != "block") {



        $('#mipopup').colorbox({

            inline: true,

            width: ppwidth,

            height: ppheight,

            open: true,

            trapFocus: true,

            onLoad: function () {



                $('#mi_global_popup').html(htmltext);



                $('#mipopup').colorbox.resize({

                    width: parseInt(ppwidth) + 'px',

                    height: parseInt(ppheight) + 'px'



                });



            },

            onClosed: function () {



                $('#mi_global_popup').empty();



                $('#mi_global_popup').html('<div></div>');



                ///alert("standard popup closed");



            },

              onComplete: function () {                



                mi_popup_width = $(window).width() <= parseInt(ppwidth)?$(window).width()-54:parseInt(ppwidth);

                

                mi_popup_height = $(window).height() <= parseInt(ppheight)?$(window).height()-54:parseInt(ppheight);

                

                $('#colorbox').colorbox.resize({width:mi_popup_width+'px',

                                                 height:mi_popup_height+'px'

                                               });



////                $('#'+box_position).resize({width:mi_popup_width-10+'px',

//                                            height:(parseInt(mi_popup_height)-10)+'px'

//                                               });												

//                mi_popup_slimscroll_height = $(window).height() < 600?$(window).height()-98:600;

//

//                mi_popup_slimscroll_height = mi_popup_height - 50;

//

//                $("#cboxLoadedContent .perfect_scroll").css({"height": mi_popup_slimscroll_height+"px"});



            }



        });



        ///  $('#mipopup').trigger("click");



    }



    ///  alert("hi"); 



}



var SUCCESS_NOTIFATION_FLAG = 0;



function process_output(result) {



    if (result != '') {



        var pos = JSON.parse(result);



        if (pos.moveto == 'top') {



            $('html, body').animate({scrollTop: 0}, '6000');



        }



    }



    try {



        var res = eval("(" + result + ")");



        //return false;



        var xhttprequestid = res.xhttprequestid;



        $('#usrresponse').clearQueue();



        $('#request').clearQueue();



        $('#mi_loader').clearQueue();



        if (res.closepopup == 'yes') {



            $($('#micolorbox').attr('href')).empty();



            $($('#micolorbox').attr('href')).html('<div></div>');



            $('#micolorbox').colorbox.close();



            $('#micolorbox').colorbox.remove();



            close_popup();



        }



        if (res.showprocess != "no") {



            requestcnt--;



        }


        if (requestcnt <= 0) {



            //$('#request').fadeOut('slow');



            $('#request').delay(5000).fadeOut('fast');



            $('#mi_loader').fadeOut('fast');



        } else {



            ///  $('#request').html("<div class='success'>Processing Your Request...</div>");



            $('#mi_loader').fadeIn('fast');



        }



        if (SUCCESS_NOTIFATION_FLAG == 0) {



            SUCCESS_NOTIFATION_FLAG = 1;



            // console.log(res.status);



            // console.log(res.showprocess );



            if (res.message != "" && res.showprocess != "no") {



                //alert('Message='+res.message);



                close_popup();



                setTimeout(function () {



                    show_popup(res.message, 400, 200, true);



                }



                , 10);



                ///  $('#usrresponse').html(res.message);



                ///$('#usrresponse').clearQueue();



                /// $('#usrresponse').fadeIn('slow');



                if (res.status == 2) {



                    expired_session_cleanup();



                    SUCCESS_NOTIFATION_FLAG = 0;



                } else if (res.showprocess != "no") {



                    $('#mi_loader').fadeOut('slow');



                    setTimeout(function () {



                        /// alert("close initiated");



                        close_popup();



                        ///  $('#usrresponse').fadeOut('slow');



                        SUCCESS_NOTIFATION_FLAG = 0;



                    }



                    , 5000);



                }



            } else {



///                $('#usrresponse').html("");



                SUCCESS_NOTIFATION_FLAG = 0;



            }



        }



//					  alert(res.popup);



        if (res.popup != "" && res.popup != "false") {



            ///  alert("opening standard poup"); 



            show_popup(res.popup.html, res.popup.width, res.popup.height, false);



        }



        if (res.position != "") {



            request_setting.output_position = request_setting.output_position || 'content';



            $.each(res.position, function (resposition, respositionhtml) {



                if (resposition == 'content' && request_setting.output_position != "") {



                    if ($('#' + request_setting.output_position).is("input")) {



                        $('#' + request_setting.output_position).val(respositionhtml);



                    } else {



                        $('#' + request_setting.output_position).html(respositionhtml);



                    }



                } else {



                    if ($('#' + resposition).is("input")) {



                        $('#' + resposition).val(respositionhtml);



                    } else {



                        $('#' + resposition).html(respositionhtml);



                    }



                }



            });



        }



        if (res.notifications != "" && res.notifications != "false") {



            if (notify.isSupported === true && notify.permissionLevel() === notify.PERMISSION_GRANTED) {



                desktop_notification(res.notifications);



            } else {



                notify.requestPermission(function () {



                    desktop_notification(res.notifications);



                })



            }



        }



        init_editor();



        init_autocomplete();



        delete xhttprequestpool[xhttprequestid];



        // $( "#results" ).append( html );						$.each($('input, select ,textarea'), function (e) {			alert(1);		            $(this).focus();            return false;        });



    } catch (err) {



        ///alert(err)



    }



    update_tabindex();



    if (res.set_focus_to != "") {



        set_focus(res.set_focus_to);



    }



}



function generate_element_id() {



    var text = "";



    var possible = "ABCDEFGHIMHLMNOPQRSTUVWXYZabcdefghiMHlmnopqrstuvwxyz0123456789";



    for (var i = 0; i < 6; i++)

        text += possible.charAt(Math.floor(Math.random() * possible.length));



    return text;



}



function desktop_notification(notifications) {



    var beepit = 0;



    if (notifications) {



        $.each(notifications, function (noteit, notification) {



            $.each(notification, function (notificationit, notification_instance) {



                beepit = 1;



                notify.createNotification(notification_instance.atitle.replace(/(<([^>]+)>)/ig, ""), {

                    body: notification_instance.amsg.replace(/(<([^>]+)>)/ig, ""),

                    icon: base_url + "html5-desktop-notifications/ico/" + notification_instance.aicon + ".png?t"



                });



            });



            if (beepit == 1) {



                var beep = new Audio(base_url + 'html5-desktop-notifications/beep1.mp3');



                if (typeof beep.loop == 'boolean')



                {



                    beep.loop = false;



                }



                beep.play();



                beepit = 0;



            }



        });



    }



}



$(window).on("load", function () {



    update_tabindex(true);



    $('#mi_loader').fadeOut('slow');



    init_autocomplete();



    if ($.cookie("keyboard")) {



        keyboard = $.cookie("keyboard");



    }



    $(document).on('keypress', "input,select", function (event) {



        if (event.which == 13) {



            event.preventDefault();



//



//            $(this).closest('form').find('input.form-xhttp-request').trigger('click');



//



//            $(this).closest('form').find('input.validate-form').trigger('click');



            var ignore = $(this).data('ignore');



            if (ignore == 'ignore') {



                return false;



            } else {



                $(this).closest('form').find('input.form-xhttp-request').trigger('click');



                $(this).closest('form').find('input.validate-form').trigger('click');



            }



        }



    });



    $('#container').on('click', '.btnclosemipopup', function () {



        close_popup();



    });



    $('#container').on('blur', "input[class*='filter_'],select[class*='filter_'],textarea[class*='filter_']", function () {



        $(this).validate();



    });



    $('#container').on('keyup', '.has_error', function () {



        $(this).validate();



    });



    $('#container').on('change', '.has_error', function () {



        $(this).validate();



    });



    $('#container').on('click', '.click-xhttp-request', function () {



//    alert($(this).closest('.active_nav').length);



        if ($(this).data('confirm') == 'yes') {



            if (window.confirm($(this).data('confirmmessage'))) {



            } else {



                return false;



            }



        }



        var qr = $(this).data('qr');



        if (qr != "") {



            $.each(qr.split('&'), function (c, q) {



                var i = q.split('=');



                //queries[i[0].toString()] = i[1].toString();



                request_setting[i[0].toString()] = i[1].toString();



            });



        }



        /// $('#'+queries.module_name+'_position').attr('class',queries.tool_code);	 



        $('#content').attr('class', request_setting.tool_code);



        $('#leftsidebar').attr('class', request_setting.tool_code);



        if (request_setting.showprocess != "no") {



            $('#container').attr('class', request_setting.module_name);



            if (active_nav) {



                active_nav.closest("li[class^='module']").removeClass('active_nav');



                active_nav.removeClass('active_nav');



            }



            active_nav = $(this);



            $("li[class^='module']").removeClass('active_nav');



            $(this).closest("li[class^='module']").addClass('active_nav');



            $(this).addClass('active_nav');



        }



        xhttprequest($(this), '', '');



        return false;



    });



    $('#container').on('change', '.change-xhttp-request', function () {



        $(".search_city").val("");



        var qr = $(this).data('qr');



        if ($(this).data('confirm') == 'yes') {



            if (window.confirm($(this).data('confirmmessage'))) {



            } else {



                return false;



            }



        }



        if (qr != "") {



            qr = qr + "&" + $(this).attr('name') + "=" + $(this).val();



            $.each(qr.split('&'), function (c, q) {



                var i = q.split('=');



                request_setting[i[0].toString()] = i[1].toString();



            });



        }



        xhttprequest($(this), $(this).data('href'), qr);



        return false;



    });



    $('#container').on('change', '.change-base-xhttp-request', function () {



        var tag;



        var qr = $(this).data('qr');



        errorcnt = 0;



        if ($(this).data('confirm') == 'yes') {



            if (window.confirm($(this).data('confirmmessage'))) {



            } else {



                return false;



            }



        }



        if (qr != "") {



            tag = $(this)[0].tagName;



            tag = tag.toLowerCase();



            if ($(this)[0].tagName != 'a') {



                qr = qr + "&" + $(this).attr('name') + "=" + $(this).val();



            } else



            {



                qr = qr + "&" + $(this).attr('id') + "=" + $(this).val();



            }



        }



        $('input[data-base*="' + $(this).attr('name') + '"],select[data-base*="' + $(this).attr('name') + '"],textarea[data-base*="' + $(this).attr('name') + '"],input[data-base*="' + $(this).attr('id') + '"],select[data-base*="' + $(this).attr('id') + '"],textarea[data-base*="' + $(this).attr('id') + '"]').each(function (index) {



            if (($(this).attr('type') == 'checkbox' || $(this).attr('type') == 'radio')) {



                if ($(this).is(':checked')) {



                    qr = qr + "&" + $(this).attr('name') + "=" + $(this).val();



                }



            } else {



                qr = qr + "&" + $(this).attr('name') + "=" + $(this).val();



            }



            $(this).validate();



            if ($(this).hasClass('has_error')) {



                errorcnt++;



            }



            ;



        });



        if (errorcnt == 0) {



            if (qr != "") {



                $.each(qr.split('&'), function (c, q) {



                    var i = q.split('=');



                    request_setting[i[0].toString()] = i[1].toString();



                });



            }

			console.log($(this).data('href')+' '+qr);
            


            xhttprequest($(this), $(this).data('href'), qr);



        }



        return false;



    });



    $('#container').on('click', '.validate-form', function () {



        var self = $(this);



        if (self.data('confirm') == 'yes') {



            if (window.confirm(self.data('confirmmessage'))) {



            } else {



                self.closest("form").submit(function (e) {



                    e.preventDefault();



                    e.stopPropagation();



                    return  false;



                });



                return  false;



            }



        }



        if (self.closest("form")) {



            errorcnt = 0;



            $.each($('input, select ,textarea', self.closest("form")), function (index) {



                if ($(this).attr('type') != "submit" && $(this).attr('type') != "button") {



                    $(this).validate();



                    if ($(this).hasClass('has_error')) {



                        errorcnt++;



                    }



                    ;



                }



            });



            ///  alert('hi>'+errorcnt);



            console.log("Errors:" + errorcnt);



            if (errorcnt == 0) {



                console.log("Submit" + self.closest("form").attr('action'));



                self.closest("form").submit();



            } else {



                /* self.closest("form").submit(function (e) {

                 

                 e.preventDefault();

                 

                 e.stopPropagation();

                 

                 return  false;

                 });*/



                return  false;



            }



        }



        return false;



    });



    $('#container').on('click', '.form-xhttp-request', function () {



        if ($(this).data('confirm') == 'yes') {



            if (window.confirm($(this).data('confirmmessage'))) {



            } else {



                return false;



            }



        }



        var qr = $(this).data('qr');



        request_setting = {};                  //add 44



        formdata = [];



        if ($(this).closest("form")) {



            if ($(this).closest("form").has("input:file").length > 0) {



                current_form = $(this).closest("form").attr('id');



                qr += "&hasfiles=yes&formid=" + current_form;



            }



            if ($.type(qr) == "string" && qr != "") {



                $.each(qr.split('&'), function (c, q) {



                    var input_field_obj = {};



                    var i = q.split('=');



                    elm_name = i[0].toString();



                    i = i.splice(1, i.length);



                    eml_value = i.join('=').toString();



                    input_field_obj.name = elm_name;



                    input_field_obj.value = unescape(eml_value);



                    formdata = formdata.concat(input_field_obj);



                    request_setting[elm_name] = eml_value;



                });



            }



            errorcnt = 0;



            arrayindex = 0;



            $.each($('input, select ,textarea', $(this).closest("form")), function (index) {



                $(this).validate();



                if ($(this).hasClass('has_error')) {



                    errorcnt++;



                }



                ;



            });



            if (errorcnt == 0) {



                formdata = formdata.concat($(this).closest("form").serializeArray());



                xhttprequest($(this), $(this).data('href'), formdata);



                if ($(this).data('changecolor') == 'yes') {



                    $(".ms_admin_action_btn").css({"background-color": "#ed5565"});



                }



            }



        }



        return false;



    });



    $('#container').on('click', '.base-xhttp-request', function () {



        if ($(this).data('confirm') == 'yes') {



            if (window.confirm($(this).data('confirmmessage'))) {



            } else {



                return false;



            }



        }



        errorcnt = 0;



        var qr = $(this).data('qr');



        $('input[data-base*="' + $(this).attr('name') + '"],select[data-base*="' + $(this).attr('name') + '"],textarea[data-base*="' + $(this).attr('name') + '"]').each(function (index) {



            if (($(this).attr('type') == 'checkbox' || $(this).attr('type') == 'radio')) {



                if ($(this).is(':checked')) {



                    qr = qr + "&" + $(this).attr('name') + "=" + $(this).val();



                }



            } else {



                qr = qr + "&" + $(this).attr('name') + "=" + $(this).val();



            }



            $(this).validate();



            if ($(this).hasClass('has_error')) {



                errorcnt++;



            }



            ;



        });



        if (errorcnt == 0) {



            if (qr != "") {



                $.each(qr.split('&'), function (c, q) {



                    var i = q.split('=');



                    request_setting[i[0].toString()] = i[1].toString();



                });



            }



            xhttprequest($(this), $(this).data('href'), qr);



        }



        return false;



    });





    $('#container').on('click', '.base-select', function () {



        if ($(this).data('type') == 'toggle') {



            $('input[data-base*="' + $(this).attr('name') + '"]').each(function (index) {



                if ($(this).prop('checked')) {



                    $(this).prop('checked', false);



                } else {



                    $(this).prop('checked', true);



                }



            });



        } else {



            var parent_status = $(this).prop('checked');



            $('input[data-base*="' + $(this).attr('name') + '"]').each(function (index) {



                $(this).prop('checked', parent_status);



            });



        }



        return true;



    });



    $('#container').on('click', '.remove-element', function () {



        $('#' + $(this).data('target')).remove();



        return false;



    });



    $('#container').on('click', '.expand_button', function () {



        $('.expand_pan').each(function () {



            if (!$(this).is(':hidden')) {



                $(this).animate({height: "toggle"},

                        {duration: 500,

                            specialEasing: {height: "swing"},

                            complete: function () { }



                        });



            }



            /// $(this).hide();



        });



        $('#' + $(this).data('target')).toggle();

//        $('#' + $(this).data('target')).animate({height: "toggle"},
//                {duration: 1000,
//                    specialEasing: {height: "swing"},
//                    complete: function () { }
//                });



        if ($(this).is('a')) {



            return false;



        }



    });



    $('#container').on('focus', '.mi_calender', function () {



        $(this).datepicker({

            changeMonth: true,

            changeYear: true,

            showAnim: 'slideDown',

            dateFormat: 'dd-mm-yy',

            yearRange: "-100:+10"
        });

        return false;

    });
    



    $('#container').on('focus', '.mi_timecalender', function () {



        $(this).datetimepicker({

            changeMonth: true,

            changeYear: true,

            showAnim: 'slideDown',

            dateFormat: 'yy-mm-dd',

            timeFormat: "hh:mm tt"



        });



        return false;



    });
    
    




    $('#container').on('focus', '.mi_timepicker', function () {



        $(this).timepicker({

           timeFormat: "HH:mm"



        });



        return false;



    });



    $('#container').on('click', '.onpage_popup', function () {



        var qr = $(this).data('qr');



        if ($('#container').find('#micolorbox').length <= 0) {



            $('#popupconitainer').append("<a id='micolorbox'  href='#popup_div'>.</a>");



        }



        if ($('#container').find('#popup_div').length <= 0) {



            $('#popupconitainer').append('<div id="popup_div">Loding...</div>');



        }



        if (qr != "") {



            $.each(qr.split('&'), function (c, q) {



                var input_field_obj = {};



                var i = q.split('=');



                elm_name = i[0].toString();



                i = i.splice(1, i.length);



                eml_value = i.join('=').toString();



                request_setting[elm_name] = eml_value;



            });



        }



        self = $(this);



        request_setting.output_position = 'popup_div';



        box_position = request_setting.output_position;



        $('#micolorbox').colorbox({inline: true, width: "50%", height: "50%", trapFocus: true,

            onOpen: function () {



                ///   alert('hi');



                ///	alert($('#popup_div').html());



                xhttprequest(self, '', '');



            },

            onLoad: function () {



                ///   alert('hi');



                ///	alert($('#popup_div').html());



                /// xhttprequest(self, '', '');



            },

            onClosed: function () {



                $('#' + box_position).empty();



            },

              onComplete:function(){

            

            if(self.data('popupwidth') && self.data('popupheight')){



                mi_popup_width = $(window).width() <= parseInt(self.data('popupwidth'))?$(window).width()-54:parseInt(self.data('popupwidth'));

                



                mi_popup_height = $(window).height() <= parseInt(self.data('popupheight'))?$(window).height()-54:parseInt(self.data('popupheight'));

                



                $('#micolorbox').colorbox.resize({width:mi_popup_width+'px',

                                                 height:mi_popup_height+'px'

                                               });



                $('#'+box_position).resize({width:mi_popup_width-10+'px',

                                            height:(parseInt(mi_popup_height)-10)+'px'

                                               });												

                mi_popup_slimscroll_height = $(window).height() < 600?$(window).height()-98:600;



                mi_popup_slimscroll_height = mi_popup_height - 50;



                $("#cboxLoadedContent .perfect_scroll").css({"height": mi_popup_slimscroll_height+"px"});



            }



        } 







        });





        $('#micolorbox').trigger("click");



        return false;



    });



    $('#container').on('click', '.changeuser', function () {



        if (window.confirm("Do you want to change user?")) {



            localStorage.removeItem("authorised_user");



            $.cookie('authorised_user', '');



            window.location = base_url + 'users/users/first_login';



        }



    });



    $('#container').on('click', '.groupcheck', function () {



        element_name = $(this).attr('name').split('[');



        if (element_name.length >= 2) {

            element_name = element_name[0] + "[";

        } else {

            element_name = $(this).attr('name');

        }



        $('input[name*="' + element_name + '"]').each(function (index) {

            $(this).prop('checked', false);

        });



        $(this).prop('checked', true);



    });





    $('#container').on('click', '.leftsidebar .navigation li', function () {



        crnt_index = $(this).data('index');



        $('#container .leftsidebar .navigation li').each(function (index) {



            if (crnt_index < $(this).data('index')) {



                $(this).removeClass('active_nav');



            }



        });



        $(this).addClass('active_nav');



        return false;



    });



    $('#container').on('click', '.collapse_button, .hide_button ', function () {



        // var hidden = $('.leftsidebar ').is(':visible');



        var hidden = $('.leftsidebar').hasClass("collapse");



        if (hidden) {



            $('.leftsidebar').removeClass('collapse');



            $('#rightsidecontent').css({'margin-left': '240px'});



            $('.hide_button ').removeClass('show_button');



            $('.hide_button').css({left: 240});



        } else {



            $('.hide_button ').addClass('show_button');



            $('.hide_button').css({left: 53});



            $('.leftsidebar ').addClass('collapse');



            $('#rightsidecontent').css({'margin-left': '50px'});



        }



    });



    $('#container').on('mousedown', '.minimize_scroll_menu , ul.incoming_calls li', function () {



        $('#incoming_call_nav').toggleClass('isOut');



        var isOut = $('#incoming_call_nav').hasClass('isOut');



        $('#incoming_call_nav').animate({

            right: isOut ? '-123' : '0'



        }, 300);



        $('#incoming_call_nav .minimize_scroll_menu .head').toggleClass('head_revers');



    });



//jqte();



    init_editor();



    tm = setInterval(function () {



        $("#desktop_notification").trigger("click");



    }, 7000); // each 5 sec 10000



});// end of window load



var INCOMING_CALL_FLAG = 1;
var AUTO_CALL_PICKUP = 0;

$(window).load(function () {
    $('a.incoming_call_refresh').click();
    incoming_call_timer = setInterval(change_incoming_call, 5000);
    $('#container').on('click', '.incoming_call_anchor', function () {
        AUTO_CALL_PICKUP = 1;
        INCOMING_CALL_FLAG = 0;
    });
});

function change_incoming_call() {
    if (INCOMING_CALL_FLAG == 1) {
        $('a.incoming_call_refresh').click();
    }
}

function start_incoming_call() {
    INCOMING_CALL_FLAG = 1;
}



function get_browser() {



    var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;



    if (isOpera) {



        return "opera";



    }



    var isFirefox = typeof InstallTrigger !== 'undefined';



    if (isFirefox) {



        return "firefox";



    }



    var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;



    if (isSafari) {



        return "safari";



    }



    var isIE = /*@cc_on!@*/false || !!document.documentMode;



    if (isIE) {



        return "ie";



    }



    var isEdge = !isIE && !!window.StyleMedia;



    if (isEdge) {



        return "edge";



    }



    var isChrome = !!window.chrome && !!window.chrome.webstore;



    if (isChrome) {



        return "chrome";



    }



    var isBlink = (isChrome || isOpera) && !!window.CSS;



    if (isBlink) {



        return "blink";



    }



}



