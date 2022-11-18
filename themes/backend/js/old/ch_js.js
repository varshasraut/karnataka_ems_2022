//   var idleTime = 0;
//    $(document).ready(function () {
//        // Increment the idle time counter every minute.
//        var idleInterval = setInterval(timerIncrement, 60000); // 1 minute
//
//        // Zero the idle timer on mouse movement.
//        $(this).mousemove(function (e) {
//            idleTime = 0;
//        });
//        $(this).keypress(function (e) {
//            idleTime = 0;
//        });
//    });
//
//    function timerIncrement() {
//        idleTime = idleTime + 1;
//        console.log(idleTime);
//        if (idleTime > 5) { // 20 minutes
//            console.log()
//            alert("5 minute over");
//        }
//    }            
function open_draggale_window(url){
  myWindow = window.open(url, "", 'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1200,height=600',"replace=true");
  //myWindow = window.open(url, "", "width=1000, height=100");
   myWindow.resizeTo(1200, 600);   
    
    
}
jQuery(document).ready(function () {

    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
    $('audio').bind('contextmenu',function() { return false; });
//    $('body').on("blur", "#manage_team_current_date", function () {
//        var $remark_input = $("#manage_team_current_date").val();
//        if ($remark_input != "") {
//            xhttprequest($(this), base_url + 'shift_roster/load_team_list', "schedule_date="+$remark_input);
//           // xhttprequest($(this), base_url + 'shift_roster/load_team_list', 'data-qr="schedule="'+$remark_input+'"');
//        }else{
//            $("#manage_team_date").html('');
//        }
//    });

    jQuery('body').on("contextmenu", "audio", function () {
        return false;
    });
    jQuery('body').on("blur", "#inc_map_address", function () {
        var $address = $("#inc_map_address").val();
        console.log($address);
        var $district =  $('#incient_dist').find('input').val();

        
        if ($address != "") {
            $('#search_amb').css({'display': 'block'});
            
        } 
    });
   
    jQuery('body').on("blur", "#manage_team_monthly_date", function () {
        //$(document).on("change", "#manage_team_monthly_date", function () {
        console.log($("#manage_team_monthly_date").val());
        var $remark_input = $("#manage_team_monthly_date").val();
        if ($remark_input != "") {
            xhttprequest($(this), base_url + 'shift_roster/load_team_list', "schedule_month=" + $remark_input);
            // xhttprequest($(this), base_url + 'shift_roster/load_team_list', 'data-qr="schedule="'+$remark_input+'"');
        } else {
            jQuery("#manage_team_date").html('');
        }
    });
    
    /*jQuery('body').on("blur", "#caller_no",  function(){
        var caller_no = $("#caller_no").val();
        var stringLength = caller_no.length;
        if(stringLength < 10){
            document.getElementById("caller_no").focus();
        }

    });*/
    jQuery('body').on("blur", "#clg_mobile_no",  function(){
        var $mobile_no= $("#clg_mobile_no").val();
        var $user_group_id= $("#user_group_id").val();
         
          xhttprequest($(this), base_url + 'clg/check_mobile_exist', "mobile_no=" + $mobile_no+'&user_group_id='+$user_group_id);
    });
     jQuery('body').on("blur", "#three_word",  function(){
        var $three_word = $("#three_word").val();
        $.ajax({
            url: base_url + 'inc/load_three_word_validation',
             data: { three_word: $three_word },
             dataType: "text",
             success: function (data) {
            var res = JSON.parse(data);
            //console.log('res',res);
            $('#validation_result').text(res.validation_result);
            var latlng = res.lat+","+res.lang+",250";

            whatthreewordstoaddress(latlng, res.lat, res.lang);
             },
             error: function (data) {
                //alert(data);

             }
         });
         
       // xhttprequest($(this), base_url + 'inc/load_three_word_validation', "three_word=" + $three_word);
    });
    

    jQuery('body').on("blur", ".add_employee #add_team_monthly_date", function () {
        //$(document).on("change", "#manage_team_monthly_date", function () {
        console.log($(".add_employee #add_team_monthly_date").val());
        var $remark_input = $(".add_employee #add_team_monthly_date").val();
        if ($remark_input != "") {
            xhttprequest($(this), base_url + 'schedule_crud/load_team_list', "schedule_month=" + $remark_input);
            // xhttprequest($(this), base_url + 'shift_roster/load_team_list', 'data-qr="schedule="'+$remark_input+'"');
        } else {
            jQuery("#manage_team_date").html('');
        }
    });
    
     jQuery('body').on("blur", "#scene_odometer_pcr", function () {
        
       
       if(document.getElementById("hospital_odometer_pcr").readOnly==false)
       {
            
            document.getElementById("hospital_odometer_pcr").value = "";
       }
       if(document.getElementById("end_odometer_input").readOnly==false)
       {
           
            document.getElementById("end_odometer_input").value = "";
            var v = document.getElementById("end_odometer_input"); 
            $('#end_odometer_input').addClass('filter_required');
            $('#end_odometer_input').addClass('has_error');
       }
       var $scene_odometer_pcr = parseInt($("#scene_odometer_pcr").val());
       var $start_odometer_pcr = parseInt($("#start_odometer_pcr").val());
       if ($start_odometer_pcr <= $scene_odometer_pcr || $("#scene_odometer_pcr").val().length == 0) {

        } else {
            //console.log('hii');
           xhttprequest($(this), base_url + 'job_closer/scene_odometer', "scene_odometer_pcr=" + $scene_odometer_pcr+"start_odometer_pcr="+$start_odometer_pcr);
       }
        
   });

    jQuery('body').on("blur", "#hospital_odometer_pcr", function () {

        if(document.getElementById("end_odometer_input").readOnly==false)
        {
            document.getElementById("end_odometer_input").value = "";
            $('#end_odometer_input').addClass('filter_required');
            $('#end_odometer_input').addClass('has_error');
        }
       
        var $hospital_odometer = parseInt($("#hospital_odometer_pcr").val());
        var $scene_odometer = parseInt($("#scene_odometer_pcr").val());
        var $start_odometer_pcr = parseInt($("#start_odometer_pcr").val());
        if (($("#scene_odometer_pcr").val().length == 0 && ($start_odometer_pcr <= $hospital_odometer )) || $scene_odometer <= $hospital_odometer || $("#hospital_odometer_pcr").val().length == 0) {

       } else {
            //console.log('hiii');
            xhttprequest($(this), base_url + 'job_closer/hospital_odometer', "hospital_odometer=" + $hospital_odometer+"scene_odometer="+$scene_odometer);
        }
    });

    jQuery('body').on("blur", "#end_odometer_input", function () {
        var $start_odometer_pcr = parseInt($("#start_odometer_pcr").val());
        var $scene_odometer = parseInt($("#scene_odometer_pcr").val());
        var $hospital_odometer = parseInt($("#hospital_odometer_pcr").val());
        
        var $end_odometer_input = parseInt($("#end_odometer_input").val());
        
        var $distance_travelled = $end_odometer_input-$start_odometer_pcr;
          $("#distance_travelled_odmeter").val($distance_travelled);
        
        //if (($start_odometer_pcr <= $end_odometer_input) && (($hospital_odometer <= $end_odometer_input) || ($hospital_odometer_pcr==''))) {
//        if($("#hospital_odometer_pcr").val().length == 0 
//                && (($("#scene_odometer_pcr").val().length == 0 && ($start_odometer_pcr <= $end_odometer_input))
//                ||($scene_odometer <= $end_odometer_input))
//         || ($hospital_odometer <= $end_odometer_input )){
//            $("#distance_travelled_odmeter").val($distance_travelled);
//        } else {
//           //xhttprequest($(this), base_url + 'job_closer/end_odometer', "start_odometer_pcr="+$start_odometer_pcr+"&hospital_odometer=" + $hospital_odometer+"&end_odometer_input="+$end_odometer_input);
//        }
   });

    jQuery(document).on("click", ".blue_bar .quality_arrow_back", function () {
        jQuery(this).parents('.open_greet_quality').find('.checkbox_div').slideToggle('slow');
    });
    jQuery(document).on("click", ".blue_bar_new .quality_arrow_back", function () {
        jQuery(this).parents('.open_greet_quality').find('.checkbox_div').slideToggle('slow');
    });
    jQuery(document).on("click", ".green_bar .quality_arrow_back_new", function () {
        jQuery(this).parents('.open_greet_quality_new').find('.checkbox_div_new').slideToggle('slow');
    });
    jQuery("input:checkbox").on('click', function () {
        // in the handler, 'this' refers to the box clicked on
        var $box = jQuery(this);
        if ($box.is(":checked")) {
            // the name of the box is retrieved using the .attr() method
            // as it is assumed and expected to be immutable
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }
    });
    $(document).on("change", "#pcr_pat_id_new", function () {
        close_popup();
        if ($("#pcr_pat_id_new").val() == 0) {

            $(this).find(':eq(0)').prop('selected', true);
            $('#add_button_pt').click();
            return;
        } else {
            var $reopen= $("#reopen").val();
            var $epcr_call_type= $("#epcr_call_type").val();
             var $inc_ref_id= $("#inc_ref_id").val();
            
            xhttprequest($(this), base_url + 'pcr/job_closure_update_patient_details', 'ptn_id=' + $("#pcr_pat_id_new").val()+'&reopen='+$reopen+'&epcr_call_type='+$epcr_call_type+'&inc_ref_id='+$inc_ref_id);
            //xhttprequest($(this),base_url+'pcr/update_patient_details','ptn_id='+$("#pcr_pat_id").val());
        }

    });
    $(document).on("change", "#pcr_pat_id", function () {
        close_popup();
        if ($("#pcr_pat_id").val() == 0) {

            $(this).find(':eq(0)').prop('selected', true);
            $('#add_button_pt').click();
            return;
        } else {
            xhttprequest($(this), base_url + 'pcr/update_patient_details', 'ptn_id=' + $("#pcr_pat_id").val());
            //xhttprequest($(this),base_url+'pcr/update_patient_details','ptn_id='+$("#pcr_pat_id").val());
        }

    });
     $("#container").on("change", ".travel_place", function () {
         
        $call_status = $(this).val();
        $index_no = $(this).attr('data-index');
        
        if($call_status == 'Yes'){
             $('.followup_details_box #travel_place_'+$index_no).removeClass('hide');
        }else{
            $('.followup_details_box #travel_place_'+$index_no).addClass('hide');
        }
    });
    $("#container").on("change", ".current_place", function () {
         
        $call_status = $(this).val();
        $index_no = $(this).attr('data-index');
        
        if($call_status != ''){
             $('.followup_details_box #current_place_'+$index_no).removeClass('hide');
        }else{
            $('.followup_details_box #current_place_'+$index_no).addClass('hide');
        }
    });
    $("#container").on("change", ".treatment_place", function () {
         
        $call_status = $(this).val();
        $index_no = $(this).attr('data-index');
        
        if($call_status != 'Home Isolation/Home Quarantine'){
             $('.followup_details_box #treatment_place_'+$index_no).removeClass('hide');
        }else{
            $('.followup_details_box #treatment_place_'+$index_no).addClass('hide');
        }
    });
    
    $("#container").on("change", ".doctor_consultation", function () {
        $call_status = $(this).val();
        if($call_status == 'Yes'){
             $('#doctor_name').removeClass('hide');
        }else{
            $('#doctor_name').addClass('hide');
        }
    });
    $("#container").on("change", ".corana_call_status", function () {
        $call_status = $(".corana_call_status").val();
        console.log($call_status);
        
        if ($call_status != 'Call Answered' && $call_status != '' ) {
 
            $('.followup_details_box #corona_ero_summary').removeClass('filter_required');
            $('.followup_details_box .current_place').removeClass('filter_required');
            $('.followup_details_box .travel_place').removeClass('filter_required');
            $('.followup_details_box .treatment_place ').removeClass('filter_required');
            $('.followup_details_box .doctor_consultation').removeClass('has_error');
            $('.followup_details_box .current_place').removeClass('has_error');
            $('.followup_details_box .travel_place').removeClass('has_error');
            $('.followup_details_box .treatment_place ').removeClass('has_error');
            $('.followup_details_box .doctor_consultation').removeClass('filter_required');
            $('.followup_details_box .corona_standard_remark ').removeClass('has_error');
            $('.followup_details_box .corona_standard_remark').removeClass('filter_required');
            
            $('.followup_more').css({'display': 'none'});
        } else {
            
           // $('.followup_details_box #corona_ero_summary').addClass('filter_required');
           // $('.followup_details_box #corona_current_place').addClass('filter_required');
           // $('.followup_details_box #corona_travel_history').addClass('filter_required');
          //  $('.followup_details_box #corona_ero_advice').addClass('filter_required');
            $('.followup_details_box .current_place').addClass('filter_required');
            $('.followup_details_box .travel_place').addClass('filter_required');
            $('.followup_details_box .treatment_place ').addClass('filter_required');
            $('.followup_details_box .doctor_consultation').addClass('filter_required');
            $('.followup_details_box .corona_standard_remark').addClass('filter_required');
            $('.followup_more').css({'display': 'block'});
        }
    });

    $(document).on("change", "#ercp_pat_id", function () {

//            close_popup();

        if ($("#ercp_pat_id").val() == '0') {
            $(this).find(':eq(0)').prop('selected', true);
            $('#add_button_ercp').click();
            return;
        } else {
// xhttprequest($(this), base_url + 'medadv/update_ercp_patient_details', 'ptn_id=' + $("#ercp_pat_id").val());
//xhttprequest($(this),base_url+'pcr/update_patient_details','ptn_id='+$("#pcr_pat_id").val());
        }

    });
     $(document).on("change", "#shift_id", function () {
        var $shift_id = $("#shift_id").val();
        if ($shift_id != "") {
            xhttprequest($(this), base_url + 'shift_roster/shift_timing_show', "shift_id=" + $shift_id);
            // xhttprequest($(this), base_url + 'shift_roster/load_team_list', 'data-qr="schedule="'+$remark_input+'"');
        } else {
            $("#shift_time").html('');
        }
    });

    $(document).on("change", "#standard_remark", function () {
        var $remark_input = $("#standard_remark").val();
        if ($remark_input == "other") {
            xhttprequest($(this), base_url + 'fleet/show_other_remark', id = $remark_input);
        } else {
            $("#remark_other_textbox").html('');
        }
    });

    $(document).on("change", "#accidental_type", function () {
        var $remark_input = $("#accidental_type").val();
        if ($remark_input == "Other") {
            xhttprequest($(this), base_url + 'ambulance_maintaince/show_other_remark', id = $remark_input);
        } else {
            $("#remark_other_textbox").html('');
        }
    });

    $(document).on("change", "#break_type", function () {
        var $remark_input = $("#break_type").val();
        if ($remark_input == "Others") {
            xhttprequest($(this), base_url + 'ambulance_maintaince/show_other_break_type', id = $remark_input);
        } else {
            $("#remark_other_textbox").html('');
        }
    });

    $(document).on("change", "#team_schedule_type", function () {
        var $remark_input = $("#team_schedule_type").val();
        if ($remark_input != "") {
            xhttprequest($(this), base_url + 'shift_roster/load_calender_block', "schedule=" + $remark_input);
        } else {
            $("#canlender_div_outer").html('');
        }
    });
    
    $(document).on("change", "#employee_schedule_type", function () {
        var $remark_input = $("#employee_schedule_type").val();
        console.log($remark_input);
        if ($remark_input != "") {
            xhttprequest($(this), base_url + 'schedule_crud/load_calender_block', "schedule=" + $remark_input);
        } else {
            $("#canlender_div_outer").html('');
        }
    });
    
    $(document).on("change", "#police_standard_remark", function () {
        var $remark_input = $("#police_standard_remark").val();
        if ($remark_input == "other") {
            xhttprequest($(this), base_url + 'police_calls/show_other_police_remark', id = $remark_input);
        } else {
            $('#police_remark_other_textbox').html('');
        }
    });
    $(document).on("change", "#fire_standard_remark", function () {
        var $remark_input = $("#fire_standard_remark").val();
        if ($remark_input == "other") {
            xhttprequest($(this), base_url + 'fire_calls/show_other_fire_remark', id = $remark_input);
        } else {
            $('#fire_remark_other_textbox').html('');
        }
    });

    $(document).on("click", "#dialer_close", function () {
        $('#dialerscreen').html('');
    });
    
    $(document).on("click", "#maintance_type", function () {
         var $maintance_type = $("#maintance_type").val();
         var $maintance_type = $("#maintance_type").val();
      
         
         xhttprequest($(this), base_url + 'maintenance_part/maintance_type_change_item_list', 'id='+$maintance_type);
    });
    
    $(document).on("change", "#other_police_type", function () {
        var $remark_input = $("#other_police_type").val();
        if ($remark_input == "other") {
            xhttprequest($(this), base_url + 'fleet/show_other_police_type', id = $remark_input);
        } else {
            $('#other_type_textbox').html('');
        }
    });
    $(document).on("change", "#grivence_complaint", function () {
        var $remark_input = $("#grivence_complaint").val();
        if ($remark_input == "external") {
            xhttprequest($(this), base_url + 'grievance/show_external_complaint_type', 'value=' + $remark_input);
            $('#grivance_inc_filter').html('');
            $('#grivience_info').html('');
        } else if ($remark_input == "internal") {
            xhttprequest($(this), base_url + 'grievance/show_external_complaint_type', 'value=' + $remark_input);
            $('#grivance_inc_filter').html('');
            $('#grivience_info').html('');
        } else if ($remark_input == "e-complaint") {
            xhttprequest($(this), base_url + 'grievance/show_external_complaint_type', 'value=' + $remark_input);
            $('#grivance_inc_filter').html('');
            $('#grivience_info').html('');
        } else if ($remark_input == "negative_news") {
            xhttprequest($(this), base_url + 'grievance/show_external_complaint_type', 'value=' + $remark_input);
            $('#grivance_inc_filter').html('');
            $('#grivience_info').html('');
        } else {
            $('#grivance_inc_filter').html('');
        }

    });
    $(document).on("change", "#gri_complaint_type", function () {
        var $remark_input = $("#gri_complaint_type").val();
        if ($remark_input == "external") {
            xhttprequest($(this), base_url + 'grievance/grievance_manual_call', 'value=' + $remark_input);
            $('#grivance_inc_filter').html('');
            $('#grivience_info').html('');
        } else if ($remark_input == "internal") {
            xhttprequest($(this), base_url + 'grievance/grievance_manual_call', 'value=' + $remark_input);
            $('#grivance_inc_filter').html('');
            $('#grivience_info').html('');
        } else if ($remark_input == "e-complaint") {
            xhttprequest($(this), base_url + 'grievance/grievance_manual_call', 'value=' + $remark_input);
            $('#grivance_inc_filter').html('');
            $('#grivience_info').html('');
        } else if ($remark_input == "negative_news") {
            xhttprequest($(this), base_url + 'grievance/grievance_manual_call', 'value=' + $remark_input);
            $('#grivance_inc_filter').html('');
            $('#grivience_info').html('');
        }
        else if ($remark_input == "government_letter") {
            xhttprequest($(this), base_url + 'grievance/grievance_manual_call', 'value=' + $remark_input);
            $('#grivance_inc_filter').html('');
            $('#grivience_info').html('');
        } else {
            $('#grivance_inc_filter').html('');
        }

    });


    $(document).on("change", ".enq_question", function () {

        var $ques_id = $(this).val();
        var $lang = $("#lang_option option:selected").val();
       // console.log($lang);
        xhttprequest($(this), base_url + 'enquiry/check_question', 'que=' + $ques_id+'&lang='+$lang);
    });
    $(document).on("change", "#higher_authority", function () {
        var $remark_input = $("#higher_authority").val();
        if ($remark_input == "other") {
            xhttprequest($(this), base_url + 'fleet/show_other_higher_authority', id = $remark_input);
        }
    });
    $(document).on("change", "#user_group_id", function () {
        if ($("#user_group_id").val()) {
            xhttprequest($(this), base_url + 'clg/create_user_id', 'user_group=' + $("#user_group_id").val());
        }
    });
//    $(document).on("change", "#rerequest_reset_img", function () {
//        if ($("#rerequest_reset_img").val()) {
//           // xhttprequest($(this), base_url + 'ambulance_maintaince/upload_photo', 'images_name=' + $("#rerequest_reset_img").val());
//        }
//    });
    $(document).on("change", "#update_amb_status", function () {

        $amb_id = $("#amb_reg_no").val();
        $amb_status = $("#update_amb_status").val();
        console.log($amb_status);

        if ($amb_status == 7 || $amb_status == 9 || $amb_status == 8 || $amb_status == 10 || $amb_status == 6  || $amb_status == 13) {

            xhttprequest($(this), base_url + 'calls/show_ambulance_odometer', 'amb_status=' + $amb_status + '&amb_id=' + $amb_id);
        } else {
            //xhttprequest($(this), base_url + 'calls/show_ambulance_change_status', 'amb_status=' + $amb_status + '&amb_id=' + $amb_id);
        }

    });
        
    $(document).on("change", "#update_amb_status_eqp", function () {

        $amb_id = $("#amb_reg_no").val();
        $amb_status = $("#update_amb_status_eqp").val();

            xhttprequest($(this), base_url + 'calls/eqp_break_show_ambulance_odometer', 'amb_status=' + $amb_status + '&amb_id=' + $amb_id);
      

    });
    $(document).on("change", "#break_list", function () {
        $break_id = $("#break_list").val();
        if ($break_id == 6) {

            xhttprequest($(this), base_url + 'clg/other_break_textbox', 'data-qr="output_position=other_break_textbox"');
        } else {
            $('#other_break_textbox').html('');
        }

    });
    $(document).on("change", "#supervisor_list", function () {
        $break_id = $("#supervisor_list").val();
        if ($break_id == 'other') {
            xhttprequest($(this), base_url + 'fleet/other_supervisor_textbox', 'data-qr="output_position=other_supervisor_textbox"');
        }
    });
    $(document).on("blur", "#start_odometer_pcr", function () {

        $previous_odometer_pcr = parseInt($("#previous_odometer_pcr").val()) + 1;
        $start_odometer_pcr = parseInt($("#start_odometer_pcr").val());
        $readonly = $("#start_odometer_pcr").attr("readonly");
        if ($readonly != 'readonly') {
            xhttprequest($(this), base_url + 'bike/show_end_odometer', 'data-qr="output_position=end_odometer_textbox"&start_odo=' + $start_odometer_pcr);
        }
        if ($start_odometer_pcr > $previous_odometer_pcr) {


            xhttprequest($(this), base_url + 'bike/show_remark_odometer', 'data-qr="output_position=remark_textbox"&start_odo=' + $start_odometer_pcr);
        } else {
            $('#remark_textbox').html('');
        }

    });
    $(document).on("blur", "#end_odometer_textbox_odo_change", function () {
        $start_odometer_textbox_odo_change = parseInt($("#start_odometer_textbox_odo_change").val());
        $end_odometer_textbox_odo_change = parseInt($("#end_odometer_textbox_odo_change").val());
        if($end_odometer_textbox_odo_change <= $start_odometer_textbox_odo_change)
        {
            document.getElementById("end_odometer_textbox_odo_change").value = $start_odometer_textbox_odo_change;
        }


    });
    $(document).on("blur", "#end_odometer_input", function () {

        $end_odometer_input = parseInt($("#end_odometer_input").val());
        $start_odometer_pcr = parseInt($("#start_odometer_pcr").val());
        $diff = $end_odometer_input - $start_odometer_pcr;
        $readonly = $("#start_odometer_pcr").attr("readonly");
//            if($readonly != 'readonly' ){
//                xhttprequest($(this),base_url+'bike/show_end_odometer','data-qr="output_position=end_odometer_textbox"&start_odo='+$start_odometer_pcr);
//            }
        if (300 < $diff) {


            xhttprequest($(this), base_url + 'bike/show_remark_end_odometer', 'data-qr="output_position=show_remark_end_odometer"&start_odo=' + $start_odometer_pcr);
        } else {
            $('#show_remark_end_odometer').html('');
        }

    });
    $(document).on("change", "#pcr_amb_id", function () {

        if ($("#pcr_amb_id").val() == 0) {
// $('#add_pcr_amb').click();
        } else {
            xhttprequest($(this), base_url + 'pcr/update_amb_details', 'amb_id=' + $("#pcr_amb_id").val());
        }

    });
    $(document).on("change", "#visitor_amb_id", function () {
        xhttprequest($(this), base_url + 'pcr/update_amb_details', 'amb_id=' + $("#visitor_amb_id").val());
    });
    $(document).on("select", "#tc_dtl_dist .mi_autocomplete_input", function () {

        dist_id = $("#tc_dtl_dist .mi_autocomplete_input").val();
        xhttprequest($(this), base_url + 'auto/get_hospital_with_ambu?dist=' + dist_id, '');
    });
    $('#container').on("focus", "#inc_map_address", function () {
        var target = $('#map_block_outer');
        var $top_space = 250;
        if (target.length) {
            jQuery('html,body').animate({scrollTop: target.offset().top - $top_space}, 'slow');
        }
    });
    $('#container').on("focus", "#inc_map_address", function () {

        //$("#get_ques_ans_details").click();
        $('.question_error_div').css({'display': 'block'});
        $('.questions_row').each(function () {
            if (!($(this).find('input[type = "radio"][value="Y"]').is(':checked')) && !($(this).find('input[type = "radio"][value="N"]').is(':checked'))) {
                $('#inc_map_address').prop('disabled', true);
                $('.question_error_div').css({'display': 'block'});
                return false;
            }
        });
    });
    $('#container').on("click", ".reset_btn", function () {
     
        $('input[readonly]').val('');
        $('input[text],textarea').val('');
        $('select option:first').prop('selected',true);
         $('input').attr('data-value').val('');
        return false;
    });
    $('#container').on("click", "#cluster_list_id", function () {

        $("#get_ques_ans_details").click();
        $('.question_error_div').css({'display': 'block'});
        $('.questions_row').each(function () {
            if (!($(this).find('input[type = "radio"][value="Y"]').is(':checked')) && !($(this).find('input[type = "radio"][value="N"]').is(':checked'))) {
                $('#cluster_list_id').prop('disabled', true);
                $('.question_error_div').css({'display': 'block'});
                return false;
            }

        });
    });
    
    $('#container').on("change", ".questions_row", function () {
        $('.questions_row').each(function () {
            if (!($(this).find('input[type = "radio"][value="Y"]').is(':checked')) && !($(this).find('input[type = "radio"][value="N"]').is(':checked'))) {
                $('#inc_map_address').prop('disabled', true);
                $('.question_error_div').css({'display': 'block'});
                return false;
            } else {
                $('#inc_map_address').prop('disabled', false);
                $('#cluster_list_id').prop('disabled', false);
                $('.question_error_div').css({'display': 'none'});
            }
        });
        $("#get_ques_ans_details").click();
    });


    $('#container').on("change", "#varification_ques_outer input[type='radio']", function () {

        var $total_y_inputs = $('#varification_ques_outer input[type="radio"][value="Y"]').length;
        var $total_y_checked = $('#varification_ques_outer input[type="radio"][value="Y"]:checked').length;
        if ($total_y_inputs == $total_y_checked) {
            $("#ver_matrix_marks").val('10');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        } else {
            $("#ver_matrix_marks").val('0');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);
            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        }

    });

    $('#container').on("change", ".pulse_oxymeter input[type='radio']", function () {
        var $pulse_oxymeter = $('.pulse_oxymeter input[type="radio"][value="yes"]:checked').length;
        $(this).parents('.pulse_oxymeter ').find('.oxygen_saturation_value').addClass('hide');
        
        if($pulse_oxymeter > 0){
            
              $(this).parents('.pulse_oxymeter').find('.oxygen_saturation_value').removeClass('hide');
              
          } else {
               
              $(this).parents('.pulse_oxymeter ').find('.oxygen_saturation_value').addClass('hide');
          }
        console.log($pulse_oxymeter);
        
  });

    $('#container').on("change", "#open_greet_ques_outer input[type='radio']", function () {

        var $total_y_inputs = $('#open_greet_ques_outer input[type="radio"][value="Y"]').length;
        var $total_y_checked = $('#open_greet_ques_outer input[type="radio"][value="Y"]:checked').length;
        if ($total_y_inputs == $total_y_checked) {
            $("#open_greet_marks").val('10');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        } else {
            $("#open_greet_marks").val('0');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        }

    });

    $('#container').on("change", "#complete_call_system input[type='radio']", function () {

        var $total_y_inputs = $('#complete_call_system input[type="radio"][value="Y"]').length;
        var $total_y_checked = $('#complete_call_system input[type="radio"][value="Y"]:checked').length;
        if ($total_y_inputs == $total_y_checked) {
            $("#comp_systm_marks").val('30');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        } else {
            $("#comp_systm_marks").val('0');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        }

    });

    $('#container').on("change", "#notification_outer input[type='radio']", function () {

        var $total_y_inputs = $('#notification_outer input[type="radio"][value="Y"]').length;
        var $total_y_checked = $('#notification_outer input[type="radio"][value="Y"]:checked').length;
        if ($total_y_inputs == $total_y_checked) {
            $("#notification_marks").val('15');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        } else {
            $("#notification_marks").val('0');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        }

    });

    $('#container').on("change", "#complete_call_system input[type='radio']", function () {

        var $total_y_inputs = $('#complete_call_system input[type="radio"][value="Y"]').length;
        var $total_y_checked = $('#complete_call_system input[type="radio"][value="Y"]:checked').length;
        if ($total_y_inputs == $total_y_checked) {
            $("#comp_systm_marks").val('30');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        } else {
            $("#comp_systm_marks").val('0');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        }

    });

    $('#container').on("change", "#hold_procedure_outer input[type='radio']", function () {

        var $total_y_inputs = $('#hold_procedure_outer input[type="radio"][value="Y"]').length;
        var $total_y_checked = $('#hold_procedure_outer input[type="radio"][value="Y"]:checked').length;
        if ($total_y_inputs == $total_y_checked) {
            $("#hold_procedure_marks").val('5');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        } else {
            $("#hold_procedure_marks").val('0');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        }

    });

    $('#container').on("change", "#commu_skill_outer input[type='radio']", function () {

        var $total_y_inputs = $('#commu_skill_outer input[type="radio"][value="Y"]').length;
        var $total_y_checked = $('#commu_skill_outer input[type="radio"][value="Y"]:checked').length;
        if ($total_y_inputs == $total_y_checked) {
            $("#commu_skill_marks").val('20');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        } else {
            $("#commu_skill_marks").val('0');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        }

    });

    $('#container').on("change", "#commu_skill_outer input[type='radio']", function () {

        var $total_y_inputs = $('#commu_skill_outer input[type="radio"][value="Y"]').length;
        var $total_y_checked = $('#commu_skill_outer input[type="radio"][value="Y"]:checked').length;
        if ($total_y_inputs == $total_y_checked) {
            $("#commu_skill_marks").val('20');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        } else {
            $("#commu_skill_marks").val('0');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        }

    });

    $('#container').on("change", "#closing_greeting_outer input[type='radio']", function () {

        var $total_y_inputs = $('#closing_greeting_outer input[type="radio"][value="Y"]').length;
        var $total_y_checked = $('#closing_greeting_outer input[type="radio"][value="Y"]:checked').length;
        if ($total_y_inputs == $total_y_checked) {
            $("#closing_greet_marks").val('10');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }

        } else {
            $("#closing_greet_marks").val('0');
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();
            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }
        }

    });

    $('#container').on("change", "#fetal_indicator_outer input[type='radio']", function () {
       
        var $total_y_inputs = $('#fetal_indicator_outer input[type="radio"][value="Y"]').length;
        var $total_y_checked = $('#fetal_indicator_outer input[type="radio"][value="Y"]:checked').length;
        console.log($total_y_checked);

        if (0 < $total_y_checked) {
            
            $("#quality_score_marks").val('0');
            $("#fatal_error_indicator").show();
            $("#performer_group").val('Outlier');
        } else {
            
            $closing = $("#closing_greet_marks").val();
            $commu = $("#commu_skill_marks").val();
            $hold_procedure = $("#hold_procedure_marks").val();
            $comp_systm = $("#comp_systm_marks").val();
            $notification = $("#notification_marks").val();
            $open_greet = $("#open_greet_marks").val();
            $ver_matrix = $("#ver_matrix_marks").val();

            $tatal_mark = parseInt($closing) + parseInt($commu) + parseInt($hold_procedure) + parseInt($comp_systm) + parseInt($notification) + parseInt($open_greet) + parseInt($ver_matrix);

            $("#quality_score_marks").val($tatal_mark);
             $("#fatal_error_indicator").hide();
            
            if ($tatal_mark >= 91) {
                $("#performer_group").val('Performer');
            }
            if ($tatal_mark <= 90 && $tatal_mark >= 85) {
                $("#performer_group").val('Intermediate');
            }
            if ($tatal_mark <= 84.99 && $tatal_mark >= 75) {
                $("#performer_group").val('Improver');
            }
            if ($tatal_mark <= 74.99) {
                $("#performer_group").val('Outlier');
            }


        }

    });
    $('#container').on("change", ".corona_question_view input", function () {
       // $('.corona_question_view').each(function () {
           // console.log("hi");
            if($(this).parents('.corona_question_view').find('input[type = "radio"][value="Y"]').is(':checked')) {
                $(this).parents('.corona_question_view').find('.feedback_input').removeClass('hide');
            } else {
                 
                $(this).parents('.corona_question_view ').find('.feedback_input').addClass('hide');
            }
        //});

    });
    
     $('#container').on("change", "#send_material_request input", function () {
             var $ambt_name = $("#amb_type_div input" ).val();
             console.log($ambt_name);
             
         
            if($('#send_material_request input[type = "radio"][value="Yes"]').is(':checked')) {
                xhttprequest($(this), base_url + 'ambulance_maintaince/maintance_part_request', 'ambt_name='+$ambt_name);
            } else {
                $('#send_material_request_block').html('');
                $('#hidden_maintence_part').html('');
            }
    });
       $('#container').on("change", "#app_send_material_request input", function () {
             var $ambt_name = $("#amb_type_div input" ).val();
             console.log($ambt_name);
             
         
            if($('#app_send_material_request input[type = "radio"][value="Yes"]').is(':checked')) {
                xhttprequest($(this), base_url + 'ambulance_maintaince/app_maintance_part_request', 'ambt_name='+$ambt_name);
            } else {
                $('#send_material_request_block').html('');
                $('#hidden_maintence_part').html('');
            }
    });
     $('#container').on("change", "#schedule_service_block", function () {
       // $('.corona_question_view').each(function () {
           // console.log("hi");
            $closing = $("#schedule_service_block").val();
            if($closing == 'Other') {
                $('#schedule_service_other').removeClass('hide');
            } else {
                 
                $('#schedule_service_other').addClass('hide');
            }
        //});

    });
    
    

    $('#container').on("change", ".addtess_type", function () {
        $('.addtess_type').each(function () {

            if ($("input[name='addtess_type']:checked").val() == 'manual_address') {
                //$("#get_ambu_details").click();
                $inc_id = $( "input[name*='inc_id']" ).val();
                $('#search_amb').css({'display': 'block'});
                xhttprequest($(this), base_url + 'inc/get_inc_ambu?inc_ref_id='+$inc_id, 'data-qr=""');
                //xhttprequest($(this), base_url + 'calls/show_clusters', 'data-qr="output_position=cluster_view"');
                return false;
            }else{
                $('#inc_map_details').html('');
            }
        });
    });
    $('#container').on("click", "#PCR_STEPS li a", function () {

        $('#PCR_STEPS li').removeClass('active_tab');
        $(this).parent().addClass('active_tab');

    });


    $('#container').on("click", ".save_btn_wrapper .accept_btn,#dialer_box .dialer_connect", function () {

       
        $(".save_btn_wrapper .inc_confirm_button").prop("disabled", true);
    });
    
    $('#container').on("click", ".dispatch_call_forms .accept_btn", function () {

        $followup_reason = $("#followup_reason").val();
        if($followup_reason != ''){
            $(".save_btn_wrapper .inc_confirm_button").prop("disabled", true);
        }
    });
    
    $(document).on("change", "#followup_reason", function () {

        $followup_reason_value = $("#followup_reason").val();
        //console.log($filter_value);
        if ($followup_reason_value == 'Other') {
            $('#followup_reason_other').css({'display': 'block'});
        } else {
            $('#followup_reason_other').css({'display': 'none'});
        }
    });

    $('#container').on("click", ".dispatch_call_forms .accept_btn", function () {

        $termination_reason = $("#termination_reason").val();
        if($termination_reason != ''){
            $(".save_btn_wrapper .inc_confirm_button").prop("disabled", true);
        }
    });
    
    $(document).on("change", "#termination_reason", function () {

        $termination_reason_value = $("#termination_reason").val();
        //console.log($filter_value);
        if ($termination_reason_value == 'Other') {
            $('#termination_reason_other').css({'display': 'block'});
        } else {
            $('#termination_reason_other').css({'display': 'none'});
        }
    });

    
    $('#container').on("click", ".submit_btnt ", function () {

        $("this").prop("disabled", true);
    });

    $('#container').on("click", ".screen_lock_accept_btn .inc_confirm_button", function () {

        $(".screen_lock_accept_btn .inc_confirm_button").prop("disabled", true);
    });

    $('#container').on("blur", ".screen_lock_accept_btn .sl_pwd_field_input", function () {
        $('.screen_lock_accept_btn .inc_confirm_button').removeAttr("disabled");
    });


    $(document).on("change", "#epcr_filter_list", function () {

        $filter_value = $("#epcr_filter_list").val();
        //console.log($filter_value);
        if ($filter_value == 'amb_reg_no') {
            $('#amb_list').css({'display': 'block'});
        } else {
            $('#amb_list').css({'display': 'none'});
        }

        if ($filter_value == 'dst_name') {
            $('#district_list').css({'display': 'block'});
        } else {
            $('#district_list').css({'display': 'none'});
        }

        if ($filter_value == 'hp_name') {
            $('#baselocation_list').css({'display': 'block'});
        } else {
            $('#baselocation_list').css({'display': 'none'});
        }

        if ($filter_value == 'inc_datetime') {
            $('#date_box').css({'display': 'block'});
        } else {
            $('#date_box').css({'display': 'none'});
        }

        if ($filter_value == 'inc_ref_id') {
            $('#inc_id_box').css({'display': 'block'});
        } else {
            $('#inc_id_box').css({'display': 'none'});
        }
        if ($filter_value == 'close_by_emt') {
            $('#district_list').css({'display': 'block'});
            $('#inc_id_box').css({'display': 'block'});
            $('#close_by_emt1').css({'display': 'block'});
            
        } else {
            $('#close_by_emt1').css({'display': 'none'});
        }

    });
    
    $(document).on("change", "#grievance_sub_filter_list", function () {
        $filter_value = $("#grievance_sub_filter_list").val();
        if ($filter_value == 'e_complaint') {
            $('#E_Complaint').css({'display': 'block'});
        } else {
            $('#E_Complaint').css({'display': 'none'});
        }
    });
    $(document).on("change", "#grievance_filter_list", function () {

        $filter_value = $("#grievance_filter_list").val();
        if ($filter_value == 'complaint_type') {
            $('#complaint_list').css({'display': 'block'});
        } else {
            $('#complaint_list').css({'display': 'none'});
        }

        if ($filter_value == 'dst_name') {
            $('#district_list').css({'display': 'block'});
        } else {
            $('#district_list').css({'display': 'none'});
        }

        if ($filter_value == 'status') {
            $('#status_list').css({'display': 'block'});
        } else {
            $('#status_list').css({'display': 'none'});
        }

        if ($filter_value == 'complaint_id') {

            $('#inc_id_box').css({'display': 'block'});
        } else {

            $('#inc_id_box').css({'display': 'none'});
        }
        if ($filter_value == 'incident_id') {

            $('#inc_id_box1').css({'display': 'block'});
        } else {

            $('#inc_id_box1').css({'display': 'none'});
        }

        if ($filter_value == 'Date') {

            $('#gri_date').css({'display': 'block'});
        } else {

            $('#gri_date').css({'display': 'none'});
        }

    });
    
    $(document).on("change", "#feedback_type", function () {
        $filter_value = $("#feedback_type").val();
        if ($filter_value == 'negative_feedback') {
            $('#feedback_button').css({'display': 'block'});
            $('#feed_sub_btn').css({'display': 'none'});
            xhttprequest($(this), base_url + 'feedback/remark_type_feedback', 'data-qr=output_position=show_remark_end_odometer&filter_value='+$filter_value);
        } else {
            $('#feedback_button').css({'display': 'none'});
            $('#feed_sub_btn').css({'display': 'block'});
            xhttprequest($(this), base_url + 'feedback/remark_type_feedback', 'data-qr=output_position=show_remark_end_odometer&filter_value='+$filter_value);
        }
    });
    
    $(document).on("change", "#feedback_filter_list", function () {

        $filter_value = $("#feedback_filter_list").val();
        if ($filter_value == 'call_type') {
            $('#call_list').css({'display': 'block'});
        } else {
            $('#call_list').css({'display': 'none'});
        }


        if ($filter_value == 'date' || $filter_value == 'Reopen_id') {
            $('#inc_date').css({'display': 'block'});
        } else {
            $('#inc_date').css({'display': 'none'});
        }

        if ($filter_value == 'inc_id') {

            $('#inc_id_box').css({'display': 'block'});
        } else {

            $('#inc_id_box').css({'display': 'none'});
        }
        

    });
    $('#container').on("click", ".call_transfer_button", function () { 
        $('.dialer_buttons,.dial_button,.trans_dial_button,.call_hold_button,.make_trans_dial_button').removeClass('hide');
       // $('.dialer_buttons,.trans_dial_button ').removeClass('hide')
        $('.conference_button,.dial_button,.conference_button,.call_transfer_button').addClass('hide')

    });
    $('#container').on("click", ".conference_button", function () {

        $('.dialer_buttons,.call_conference_button,.call_hold_button').removeClass('hide')
        $('.conference_button,.dial_button,.conference_button,.call_transfer_button').addClass('hide')

    });
   
    $('#container').on("click", ".call_hold_button a", function () {
        $('.call_unhold_button').removeClass('hide')
        $('.conference_button,.dial_button,.conference_button,.call_transfer_button,.call_hold_button').addClass('hide');

    });
    
    

//        
//        $('#container').on("click", ".extend_map", function() {
//                $('#INCIDENT_MAP').addClass('open_map_popup');
//            
//        });

    // $('.extend_map').colorbox();

    $('#container').on("click", "#unit_other", function () {

        xhttprequest($(this), base_url + 'bike/show_unit_other', 'data-qr="output_position=show_other_unit"');
    });
    $('#container').on("click", "#non_unit_other", function () {

        xhttprequest($(this), base_url + 'bike/show_non_unit_other', 'data-qr="output_position=show_non_unit_other"');
    });
    $(document).on("change", "#at_scene", function () {
        $at_scene = $("#at_scene").val();
        $amb_category = $("#amb_category").val();
        $dispatch_dateime = $("#incident_datetime_res_remark").val();
        var d1 = new Date($dispatch_dateime);
        var d2 = new Date($at_scene);
        $time_diff = (d2.getTime() - d1.getTime()) / 60 / 1000;
        console.log($at_scene);
        console.log($dispatch_dateime);
        console.log($time_diff);
        console.log($amb_category);
        if($amb_category == 'Rural')
        {
            if ($time_diff >= 30) {
                $('#responce_time_remark').removeClass('hide');
                $('#responce_remark').parent().find('input').addClass('filter_required');
                $('#responce_remark').parent().find('input').addClass('has_error');
                //$('#responce_remark').addClass('filter_required');
               // $('#responce_remark').addClass('has_error');
            } else {
                $('#responce_remark').parent().find('input').removeClass('filter_required');
                $('#responce_remark').parent().find('input').removeClass('has_error');
                $('#responce_time_remark').addClass('hide');
            }
        }else{
            if ($time_diff >= 20) {
                $('#responce_time_remark').removeClass('hide');
                $('#responce_remark').parent().find('input').addClass('filter_required');
                $('#responce_remark').parent().find('input').addClass('has_error');
                //$('#responce_remark').addClass('filter_required');
               // $('#responce_remark').addClass('has_error');
            } else {
                $('#responce_remark').parent().find('input').removeClass('filter_required');
                $('#responce_remark').parent().find('input').removeClass('has_error');
                $('#responce_time_remark').addClass('hide');
            } 
        }
        /*
        if($amb_category == 'Urban')
       {
        console.log($time_diff);
            if ($time_diff >= 20) {
                $('#responce_time_remark').addClass('hide');
                $('#responce_remark').addClass('filter_required');
                $('#responce_remark').addClass('has_error');
            } else {
                $('#responce_time_remark').removeClass('filter_required');
                $('#responce_time_remark').removeClass('has_error');
                $('#responce_time_remark').addClass('hide');
            }
        }*/

    });
    $('#container').on("click", ".dialer_numbers .click_number", function () {
        $number = $(this).attr('data-number');
//            if($(this).attr('data-number').length > 1){
//                return true;
//            }
        $dial_no_box = $("#dial_no_box .no").val();
        $dial_no_box_html = $dial_no_box + $number;
        $("#dial_no_box .no").val($dial_no_box_html);
        $(".dialer_numbers .dialer_connect").attr('data-qr', 'position=content&mobile_no=' + $dial_no_box_html);
    });
    $("#container").on("click", "#dial_no_box .dialer_delete", function () {

        $dial_no_box = $("#dial_no_box .no").val();
        $new_no = $dial_no_box.substr(0, $dial_no_box.length - 1);
        $("#dial_no_box .no").val($new_no);
        $(".dialer_numbers .dialer_connect").attr('data-qr', 'position=content&mobile_no=' + $new_no);
    });
    $("#container").on("click", ".show_table_row", function () {

        $('table.drugs_table').removeClass('show_table');
        $days = $(this).attr('data-day');
        $("#day_" + $days).slideToggle();
    });
    
    $("#container").on("change", "#rcl_standard", function () {

        $rcl_standard = $("#rcl_standard").val();
       console.log($rcl_standard);
        
        if ($rcl_standard == '69') {
            $("#sum").val("Caller wants to complaint against the J & K  EMS services, call transferred to Grievance Desk");
            $('#problem_reporting_call .forward_button').removeClass('hide');
            $('#problem_reporting_call .save_button').addClass('hide');
        } else {
            $("#sum").val("Caller complaint has been resolved as per information available, Caller satisfied with information hence call closed");
            $('#problem_reporting_call .save_button').removeClass('hide');
            $('#problem_reporting_call .forward_button').addClass('hide');
        }
    });
    
    $("#container").on("change", "#pda_standard", function () {
        $rcl_standard = $("#pda_standard").val();
        console.log($rcl_standard);
        
        if ($rcl_standard == 'forword_to_pda') {
          $("#sum").val("call transferred to PDA Desk");
            $('#problem_reporting_call .forward_button').removeClass('hide');
            $('#problem_reporting_call .save_button').addClass('hide');
        } else {
            $("#sum").val("Caller complaint has been resolved as per information available, Caller satisfied with information hence call closed");
            $('#problem_reporting_call .save_button').removeClass('hide');
            $('#problem_reporting_call .forward_button').addClass('hide');
        }
    });
    $("#container").on("change", "#fleet_standard", function () {
        $pda_standard = $("#fleet_standard").val();
         console.log($pda_standard);
        
        if ($pda_standard == 'forword_to_fleet') {
            $("#sum").val("call transferred to fleet Desk");
            $('#problem_reporting_call .forward_button').removeClass('hide');
            $('#problem_reporting_call .save_button').addClass('hide');
        } else {
            $("#sum").val("Caller complaint has been resolved as per information available, Caller satisfied with information hence call closed");
            $('#problem_reporting_call .save_button').removeClass('hide');
            $('#problem_reporting_call .forward_button').addClass('hide');
        }
    });
    $("#container").on("change", "#situational_standard", function () {
        $pda_standard = $("#situational_standard").val();
         console.log($pda_standard);
        
        if ($pda_standard == 'forword_to_situational') {
            $("#sum").val("call transferred to Situational Desk");
            $('#problem_reporting_call .forward_button').removeClass('hide');
            $('#problem_reporting_call .save_button').addClass('hide');
        } else {
            $("#sum").val("Caller complaint has been resolved as per information available, Caller satisfied with information hence call closed");
            $('#problem_reporting_call .save_button').removeClass('hide');
            $('#problem_reporting_call .forward_button').addClass('hide');
        }
    });
    $("#container").on("change", "#tdd_standard", function () {
        $pda_standard = $("#tdd_standard").val();
         console.log($pda_standard);
        
        if ($pda_standard == 'forword_to_tdd') {
            $("#sum").val("call transferred to TDD Desk");
            $('#problem_reporting_call .forward_button').removeClass('hide');
            $('#problem_reporting_call .save_button').addClass('hide');
        } else {
            $("#sum").val("Caller complaint has been resolved as per information available, Caller satisfied with information hence call closed");
            $('#problem_reporting_call .save_button').removeClass('hide');
            $('#problem_reporting_call .forward_button').addClass('hide');
        }
    });
    $("#container").on("change", "#bike_standard", function () {
        $pda_standard = $("#bike_standard").val();
         console.log($pda_standard);
        
        if ($pda_standard == 'forword_to_bike') {
            $("#sum").val("call transferred to Bike Desk");
            $('#problem_reporting_call .forward_button').removeClass('hide');
            $('#problem_reporting_call .save_button').addClass('hide');
        } else {
            $("#sum").val("Caller complaint has been resolved as per information available, Caller satisfied with information hence call closed");
            $('#problem_reporting_call .save_button').removeClass('hide');
            $('#problem_reporting_call .forward_button').addClass('hide');
        }
    });
    $("#container").on("change", "#fda_standard", function () {
        $pda_standard = $("#fda_standard").val();
         console.log($pda_standard);
        
        if ($pda_standard == 'forword_to_fda') {
            $("#sum").val("call transferred to FDA Desk");
            $('#problem_reporting_call .forward_button').removeClass('hide');
            $('#problem_reporting_call .save_button').addClass('hide');
        } else {
            $("#sum").val("Caller complaint has been resolved as per information available, Caller satisfied with information hence call closed");
            $('#problem_reporting_call .save_button').removeClass('hide');
            $('#problem_reporting_call .forward_button').addClass('hide');
        }
    });
    
    
    $('body').on("focus", "select", function () {
        $(this).find('option').each(function () {
            $(this).text($(this).text().charAt(0).toUpperCase() + $(this).text().slice(1));
        });
    });
    $('#container').on("click", ".checkbox_input", function () {

        $(this).parent().find('.checkbox_div').toggleClass('hide_screening_checkbox');
        $(this).toggleClass('checkbox_up_arrow_input');
    });

    $('#container').on("click", "#fetal_question_div .check_input", function () {

        var $total_checked = $(this).parent().find("input[type='checkbox']:checked").val();
        if ($total_checked == 'ohter') {
            $(this).parents('.main_input_box').find('.other_div').removeClass('hide');
        } else {
            $(this).parents('.main_input_box').find('.other_div').addClass('hide');
        }

    });

    $('#container').on("click", ".vaccine_list .add_more_vaccine_filed", function () {

        $given = $(this).parent().find('.hide .vacine_given').html();
        $(this).parents('.vacine_row').find('.given div').append($given);
    });
    $('#container').on("click", ".intra_hospital .add_more_button", function () {

        $given = $('.intra_hospital .hide').html();
        $given = '<tr>' + $given + '</tr>';
        $('.intra_hospital tr:last-child').after($given);
    });
    $('#container').on("click", ".intra_hospital .remove_add_more_button", function () {

        $(this).closest('tr').remove();
    });
    $('#container').on("click", ".investigation .add_more_investigation", function () {
        var test_id = $(this).find(".test_id").val();
        xhttprequest($(this), base_url + 'emt/get_selected_test', 'test_id=' + test_id);
    });
    $('#container').on("click", ".investigation_test .remove_button", function () {
        var test_id = $(this).attr("id");
        var test_ids = test_id.split('_');
        xhttprequest($(this), base_url + 'emt/remove_test', 'test_id=' + test_ids[1]);
    });
    $(document).on("change", "#visual_perimetry_value", function () {

        $perimetry_value = $("#visual_perimetry_value").val();
        if ($perimetry_value == 'other') {
            $(this).parents('.on_click_show_input').find('.hidden_input').removeClass('hide');
        } else {
            $(this).parents('.on_click_show_input').find('.hidden_input').addClass('hide');
        }

    });
    $(document).on("change", "#reproductive_value", function () {

        $reproductive_value = $("#reproductive_value").val();
        if ($reproductive_value == 'calender') {
            $(this).parents('.on_click_show_input').find('.hidden_input').removeClass('hide');
        } else {
            $(this).parents('.on_click_show_input').find('.hidden_input').addClass('hide');
        }

    });
    $(document).on("change", "#break_is_amb_offroad", function () {

        $amb_reg_no = $("#visitor_amb_id").val();
        if ($("#break_is_amb_offroad #yes").is(':checked')) {
            xhttprequest($(this), base_url + 'biomedical/change_status', 'position=change_maintance_status&amb_reg_no=' + $amb_reg_no);
        } else {
            $("#change_maintance_status").html('');
        }

    });
    $(document).on("change", "#ptn_dob", function () {

        $ptn_dob = $("#ptn_dob").val();
        $ptn_field = $(this).attr("data-fname");
        console.log($ptn_field);
        xhttprequest($(this), base_url + 'inc/inc_age_calculator', 'ptn_dob=' + $ptn_dob + '&ptn_field=' + $ptn_field);
    });


    $('#container').on("change", ".feedback_question input[type='radio']", function () {
        if (($('.feedback_question #ques_245_yes').is(':checked')) && ($('.feedback_question #ques_246_gd').is(':checked') || $('.feedback_question #ques_246_ex').is(':checked'))) {
            //console.log('+ve');
             $('#feedback_button').css({'display': 'none'});
            $('#feed_sub_btn').css({'display': 'block'});
            $('#feedback_type').find(':eq(2)').prop('selected', true);
 
        }else{
           // console.log('-ve');
             $('#feedback_button').css({'display': 'block'});
            $('#feed_sub_btn').css({'display': 'none'});
            $('#feedback_type').find(':eq(1)').prop('selected', true);
        }
        $filter_value = $("#feedback_type").val();
        xhttprequest($(this), base_url + 'feedback/remark_type_feedback', 'data-qr=output_position=show_remark_end_odometer&filter_value='+$filter_value);
    });

    $(document).on("blur", "#stud_scr_height,#stud_scr_weight", function () {

        $height = $("#stud_scr_height").val() / 100;
        $weight = $("#stud_scr_weight").val();
        $bmi_value = $weight / ($height * $height);
        $bmi_value = $bmi_value.toFixed(2);
        $("#stud_scr_bmi").val($bmi_value);
    });

    $('#container').on("click", "#mt_atnd_calls,.incoming_call_anchor", function () {
        $('#refresh_button').css({'display': 'none'});
//        $('.break_lnk').css({'display': 'none'});
//        $('#mt_atnd_calls').css({'display': 'none'});
        $('.dash_lnk').css({'display': 'none'});
        $('#mt_atnd_calls').css({'display': 'none'});
        
         setInterval(function(){
            //photo_notification(); 
        }, 15000);
        $AVAYA_INCOMING_CALL_FLAG = 0;
    });
    
    var window_height = $(window).height() - 75;
    var content_height = $(window).height() - 50;
    $('.left_side_menu_scroll').css({'height': window_height + 'px'});
    $('#rightsidecontent #content').css({'min-height': content_height + 'px'});
//        $('#container').on("click",".left_side_menu_scroll .navigation ul li",function(){   
//            $('.navigation ul li > ul ').css({'display': 'none'});
//            console.log('hi');
//            $(this).find('ul ').css({'display': 'block'});
//        });


    $('#container').on("click", ".remove_button_ind", function () {
        
       $remove_item = $(this).closest('div.ind_class').find('.mi_autocomplete').val();
        $item_type = $(this).closest('div.stock_req_form').find('.item_type').val();

        $CAItem = jQuery.cookie($item_type+"items");

        $Items = $CAItem.split(',');
        $item_l =$Items.length;
        a = [];

        if($item_l > 0){
            for(var i=0; i<$item_l; i++) {
              if($Items[i] != $remove_item){
                a.push($Items[i]);
              }
            }

           mi_set_cookie($item_type+'items', a, 5);
       }

        $(this).closest('div.ind_class').remove();
        
    });
    
    $('#container').on("change", "#service_2", function () {

        if ($(this).is(':checked')) {
            jQuery("#police_cheif").removeClass("hide");
        } else {
            jQuery("#police_cheif").addClass("hide");
        }

    });
    $('#container').on("change", "#service_3", function () {
        if ($(this).is(':checked')) {
            jQuery("#fire_cheif").removeClass("hide");
        } else {
            jQuery("#fire_cheif").addClass("hide");
        }

    });
    
      $('#container').on("change", "#login_logout_load", function () {
        var $login_logout_load = $("#login_logout_load select").val();
        xhttprequest($(this), base_url + 'shiftmanager/show_user_data', 'data-qr=output_position=login_logout_search_btn&login_logout_load='+$login_logout_load);
    });


    if ((jQuery('#job_closer_inc_list').length > 0) && (jQuery('#cboxContent #cboxLoadedContent').length == 0)) {

        setInterval(function () {

            if ((jQuery('#job_closer_inc_list').length > 0) && (jQuery('#cboxContent #cboxLoadedContent').length == 0) && ($("#epcr_filter_list").val() == '')) {

                //xhttprequest($(this),base_url+'job_closer',"output_position=content"); 
                //$('#job_closer_autoload').click();

            }
        }, 10000);
    }

    if ((jQuery('#supervisor_medicle').length > 0) && (jQuery('#cboxContent #cboxLoadedContent').length == 0)) {

        setInterval(function () {
            if ((jQuery('#supervisor_medicle').length > 0) && (jQuery('#cboxContent #cboxLoadedContent').length == 0)) {
                //xhttprequest($(this),base_url+'job_closer',"output_position=content"); 
                // $('#superAdmin_medicle_disptched_link').click();

            }
        }, 5000);
    }
});

jQuery(document).ready(function () {
    jQuery(".navigation ul li").on("click", function () {
        //jQuery(".navigation ul li").removeClass("active_nav");
        $(this).toggleClass("active_nav");
//        jQuery(".navigation ul li").removeClass("active_nav");
//        jQuery(this).addClass("active_nav");
    });
});

jQuery(document).ready(function () {

    jQuery("#amb_filters .sub_header_top_link #sub_incedence_steps li ").on("change", function () {


        jQuery("#amb_filters .sub_header_top_link #sub_incedence_steps li ").removeClass("active_sub_supervisor_nav");
        jQuery(this).addClass("active_sub_supervisor_nav");
    });
});
jQuery(document).ready(function () {

    jQuery(".header_top_link #incedence_steps li ").on("click", function () {



        jQuery(".header_top_link #incedence_steps li ").removeClass("active_supervisor_nav");
        jQuery(this).addClass("active_supervisor_nav");
    });



    jQuery(".header_top_link #ambulance_steps li ").on("click", function () {

        jQuery(".header_top_link #ambulance_steps li ").removeClass("active_supervisor_nav");
        jQuery(this).addClass("active_supervisor_nav");
    });
    


});

$(window).on('resize', function () {
// Do something.
    var window_width = $(window).width() + 2;
    $('.call_bx').css({'width': window_width + 'px !important'});
});

function other_workshop(ft){
    if(ft['id'] == '0'){
        $('#other_workshop').removeClass('hide');
    }else{
        $('#other_workshop').addClass('hide');
    }
}
function app_other_workshop(ft){
    if(ft['id'] == '0'){
        $('#app_other_workshop').removeClass('hide');
    }else{
        $('#app_other_workshop').addClass('hide');
    }
}
function show_unit_box() {
    $('#show_unit_box_selected').click();
    //   xhttprequest($(this),base_url+'pcr/show_unit_drugs','data-qr="output_position=show_selected_unit_item"');          
}
function show_intervention_box() {
    $('#show_intervention_box_selected').click();
    //   xhttprequest($(this),base_url+'pcr/show_unit_drugs','data-qr="output_position=show_selected_unit_item"');          
}
function show_injury_box() {
    $('#show_injury_box_selected').click();         
}
function show_non_unit_box() {
    $('#show_non_unit_drugs_box').click();
    //  xhttprequest($(this),base_url+'pcr/get_drugs_non_items','data-qr="output_position=non_unit_drugs_box"');          
}
function show_ca_unit_box(){
    $('#show_unit_box_selected_ca').click();
}

function show_spare_part_box(){
    $('#show_unit_box_selected_ca').click();
}
function show_part_box(){
    $('#show_part_selected').click();
}
function GetCheckedUnit(this_obj) {

    var isChecked = this_obj.checked;
    isChecked = (isChecked) ? "checked" : "not checked";
    
    if (isChecked == 'checked') {
        $(this_obj).parents('li.unit_block').find('.unit_div').show(0);
    } else {
        $(this_obj).parents('li.unit_block').find('.unit_div').hide(0);
        $(this_obj).parents('li.unit_block').find('.unit_div input').val('');
    }
    
}

function load_next_prev_step(step) {
    $('#PCR_STEPS li').removeClass('active_tab')
    $('#PCR_STEPS a[data-pcr_step=' + step + ']').click();
    $('#PCR_STEPS a[data-pcr_step=' + step + ']').parent().addClass('active_tab')
}

function load_front_injury(this_obj) {

    var $selected_value = $("#front_id option:selected").text();
    $("#front_injury_name").text($selected_value);
    $(this_obj).parents('#Front_detail_block').find('#Front_detail').show(0);
}

function load_back_injury(this_obj) {

    var $selected_value = $("#back_id option:selected").text();
    $("#back_injury_name").text($selected_value);
    $(this_obj).parents('#back_detail_block').find('#back_detail').show(0);
}

function load_side_injury(this_obj) {

    var $selected_value = $("#side_id option:selected").text();
    $("#side_injury_name").text($selected_value);
    $(this_obj).parents('#side_detail_block').find('#side_detail').show(0);
}

function show_other_odometer() {
    var $remark_input = $("#remark_input").val();
    if ($remark_input == 13) {
        xhttprequest($(this), base_url + 'calls/show_other_odometer', 'output_position=odometer_remark_other_textbox');
    } else {
        $('#odometer_remark_other_textbox').html('');
    }
}
function show_equipments_by_type(ft){
    $type_id = ft['id'];
     xhttprequest($(this), base_url + 'biomedical/show_equipments_by_type', 'data-qr=output_position=show_equipments_by_type&id='+$type_id);
}
function equipments_by_type(){
    
    var $equipments_name = $("#equipments_name").val();
    let $type_id = $equipments_name.join('_');
    
    xhttprequest($(this), base_url + 'biomedical/equipments_by_type', 'data-qr=output_position=show_breakdown_type&id='+$type_id);
}
function show_end_other_odometer() {
    var $remark_input = $("#end_remark_input").val();
    if ($remark_input == 13) {
        xhttprequest($(this), base_url + 'bike/show_remark_other_odometer', 'output_position=end_odometer_remark_other_textbox');
    } else {
        $('#odometer_remark_other_textbox').html('');
    }
}
$(document).on("change", "#fatal_group", function () {
    var $provider = $("#fatal_group").val();

    if ($provider == 'other') {

        xhttprequest($(this), base_url + 'quality_forms/other_fatal_indicator', 'output_position=other_fatal_indicator');
    } else {

        $('#other_fatal_indicator').html('');
    }
});


$(document).on("change", "#shift_to_time", function () {
    //get values
    var valuestart = $("select[name='form_shift']").val();
    var valuestop = $("select[name='to_shift']").val();

    //create date format          
    var timeStart = new Date("01/01/2007 " + valuestart).getHours();
    var timeEnd = new Date("01/01/2007 " + valuestop).getHours();

    var $hourDiff = timeEnd - timeStart;

//    $("p").html("<b>Hour Difference:</b> " + hourDiff)

    $("#shift_total_hours_time").val($hourDiff);
});
$(document).on("focus", "#to_date", function () {
    
    var $st_base_dateime = $("#from_date").val();
    //console.log($st_base_dateime)
        var $stdate = new Date($st_base_dateime);
        
        $( ".StartDate" ).datepicker( "destroy" );
        $('.StartDate').last().datepicker('refresh');
        $('.StartDate').datetimepicker({
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            minDate: $stdate,
            maxDate: (30 - (Math.floor((Math.floor(new Date().getTime() - $stdate.getTime()))/(1000 * 60 * 60 * 24)))),

        });
    });

$(document).on("focus", "#inc_datetime", function () {
    

   
        
        $("#inc_datetime" ).datepicker( "destroy" );
        $('#inc_datetime').last().datepicker('refresh');
        $('#inc_datetime').datetimepicker({
             dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            minDate: "2021-10-18",
            maxDate: 0,

        });
    });

$(document).on("focus", "#at_scene", function () {

        var $st_base_dateime = $("#start_from_base").val();

        var $stdate = new Date($st_base_dateime);

        $( ".StartDate" ).datepicker( "destroy" );
        $('.StartDate').last().datepicker('refresh');
        $('.StartDate').datetimepicker({
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            minDate: $stdate,
            maxDate: 0

        });
    });


    $(document).on("focus", "#from_scene", function () {

        var $fm_scene_dateime = $("#at_scene").val();

        var $fmdate = new Date($fm_scene_dateime);

        $(".FromDate" ).datepicker( "destroy" );
        $('.FromDate').last().datepicker('refresh');
        $('.FromDate').datetimepicker({
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            minDate: $fmdate,
            maxDate: 0
            // minTime: jsDate[1],

        });
    });

    $(document).on("focus", "#at_hospitals_ambulance1", function () {

        var $at_hosp_dateime = $(".FromDate").val();

        var $athospdate = new Date($at_hosp_dateime);
        
        $("#at_hospitals_ambulance1" ).datepicker( "destroy" );  
        $('#at_hospitals_ambulance1').last().datepicker('refresh');
        
        $('#at_hospitals_ambulance1').datetimepicker({
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            minDate: $athospdate,
            maxDate: 0
            // minTime: jsDate[1],

        });
    });

    $(document).on("focus", "#hand_over", function () {

        var $hand_over_dateime = $("#at_hospitals_ambulance1").val();

        var $handoverdate = new Date($hand_over_dateime);
        $(".HandoverDate" ).datepicker( "destroy" );
        $('.HandoverDate').last().datepicker('refresh');
        $('.HandoverDate').datetimepicker({
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            minDate: $handoverdate,
            maxDate: 0
            // minTime: jsDate[1],

        });
    });

    $(document).on("focus", "#back_to_base", function () {

        var $back_to_base_dateime = $("#hand_over").val();

        var $backtobasedate = new Date($back_to_base_dateime);
        $(".BacktobaseDate" ).datepicker( "destroy" );
        $('.BacktobaseDate').last().datepicker('refresh');
        $('.BacktobaseDate').datetimepicker({
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            minDate: $backtobasedate,
            maxDate: 0
            // minTime: jsDate[1],

        });
    });

    $(document).on("change", "#sm_list",function(){
        var clg_ref_id= $("#sm_list option:selected").val();
        var report_type= $("#report_type option:selected").val();
        var data = "clg_ref_id="+clg_ref_id+"&report_type="+report_type;
        //':clg_ref_id,'report_type':report_type}
         xhttprequest($(this), base_url + 'quality_forms/tl_by_shiftmanager', data);
    });

    $(document).on("change", "#tl_list",function(){
        var tl_list= $("#tl_list option:selected").val();
        var report_type= $("#report_type option:selected").val();
        var data = "tl_list="+tl_list+"&report_type="+report_type;
           xhttprequest($(this), base_url + 'quality_forms/get_system_report_data_qality', data);
        //alert(tl_id);
    });
    $(document).on("change", "#system_type",function(){
        var system_type= $("#system_type option:selected").val();  
        var tl_list= $("#tl_list option:selected").val(); 
        var data = "tl_list="+tl_list+"&system_type="+system_type;
           xhttprequest($(this), base_url + 'quality_forms/get_ero_report_data_qality', data);
    });

    $(document).on("change", "#system",function(){
        var $system=   ft['id'];
        xhttprequest($(this), base_url + 'erc_reports/load_employee_calls_report', 'output_position=content&clg_user_type=' + $system);
    });

    $(document).on("change", "#team_type",function(){
        var team_type= $("#team_type option:selected").val();      
           xhttprequest($(this), base_url + 'quality_forms/get_ero_data_qality', 'team_type='+team_type);
    });
    function epcr_view_change(){
        var $epcr_call_type = $("#epcr_call_type").val();
        var $inc_ref_id = $("#inc_ref_id").val();
        var $reopen = $("#reopen").val();
        xhttprequest($(this), base_url + 'Job_closer/epcr_view_change', 'epcr_call_type='+$epcr_call_type + '&inc_ref_id=' + $inc_ref_id+'&reopen='+$reopen);
        
    }
    function remove_mandatory_fields_new(){
        var $provider = $("#provider_casetype").val();
        
         if ($provider == '24') {
               $('#provider_casetype_other').removeClass('hide');
               
         }else{
             $('#provider_casetype_other').addClass('hide');
         }
        if ($provider == '31' || $provider == '26' || $provider == '16' || $provider == '25') {
            $('#patient_gender').removeClass('filter_required');
            $('#ptn_fname').removeClass('filter_required');
            $('#amb_category').removeClass('filter_required');
            $('#pcr_amb_id').removeClass('filter_required');
            $('#emt_list').addClass('filter_required');
            $('#pilot_list').addClass('filter_required');
            $('#ercp_advice_input').removeClass('filter_required');
            $('#inc_area_type').removeClass('filter_required');

            $('#loc').parent().find('input').removeClass('filter_required');
            $('#baseline_con_airway').parent().find('input').removeClass('filter_required');
            $('#baseline_con_circulation_radial').parent().find('input').removeClass('filter_required');
            $('#baseline_con_circulation_carotid').parent().find('input').removeClass('filter_required');
            $('#baseline_con_temp').removeClass('filter_required');
            $('#baseline_con_osat').removeClass('filter_required');
            $('#baseline_con_rr').removeClass('filter_required');
            $('#baseline_con_gcs').parent().find('input').removeClass('filter_required');
            $('#baseline_con_bp_syt').removeClass('filter_required');
            $('#baseline_con_bp_dia').removeClass('filter_required');
            $('#baseline_con_skin').parent().find('input').removeClass('filter_required');
            $('#baseline_con_pupils').parent().find('input').removeClass('filter_required');
            
            $('#loc_handover').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_airway').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_breathing').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_circulation_radial').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_circulation_carotid').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_temp').removeClass('filter_required');
            $('#pt_con_handover_osat').removeClass('filter_required');
            $('#pt_con_handover_rr').removeClass('filter_required');
            $('#pt_con_handover_gcs').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_bp_syt').removeClass('filter_required');
            $('#pt_con_handover_bp_dia').removeClass('filter_required');
            $('#pt_con_handover_skin').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_pupils').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_pt_status_during_status').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_cardiac').parent().find('input').addClass('filter_required');
            
            $('#receiving_host').removeClass('filter_required');
            $('#pcr_district').removeClass('filter_required');
            $('#pcr_pat_id').removeClass('filter_required');
            $('#other_provider_impression').html('');
        }else if($provider == '6' || $provider == '7' || $provider == '8' || $provider == '19' || $provider == '20'){
        $('#patient_gender').addClass('filter_required');
        $('#ptn_fname').addClass('filter_required');
        
        $('#amb_category').addClass('filter_required');
        $('#pcr_amb_id').addClass('filter_required');
        $('#emt_list').addClass('filter_required');
        $('#pilot_list').addClass('filter_required');
        
        $('#ercp_advice_input').addClass('filter_required');
        $('#inc_area_type').removeClass('filter_required');

        $('#loc').parent().find('input').addClass('filter_required');
        $('#baseline_con_airway').parent().find('input').addClass('filter_required');
        $('#baseline_con_breathing').parent().find('input').addClass('filter_required');
        $('#baseline_con_circulation_radial').parent().find('input').addClass('filter_required');
        $('#baseline_con_circulation_carotid').parent().find('input').addClass('filter_required');
        $('#baseline_con_temp').addClass('filter_required');
        $('#baseline_con_osat').addClass('filter_required');
        $('#baseline_con_rr').addClass('filter_required');
        $('#baseline_con_gcs').parent().find('input').addClass('filter_required');
        $('#baseline_con_bp_syt').addClass('filter_required');
        $('#baseline_con_bp_dia').addClass('filter_required');
        $('#baseline_con_skin').parent().find('input').addClass('filter_required');
        $('#baseline_con_pupils').parent().find('input').addClass('filter_required');

        $('#loc_handover').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_airway').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_breathing').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_circulation_radial').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_circulation_carotid').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_temp').addClass('filter_required');
        $('#pt_con_handover_osat').addClass('filter_required');
        $('#pt_con_handover_rr').addClass('filter_required');
        $('#pt_con_handover_gcs').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_bp_syt').addClass('filter_required');
        $('#pt_con_handover_bp_dia').addClass('filter_required');
        $('#pt_con_handover_skin').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_pupils').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_pt_status_during_status').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_cardiac').parent().find('input').addClass('filter_required');
        
        $('#receiving_host').addClass('filter_required');
        $('#pcr_district').addClass('filter_required');
        $('#pcr_pat_id').addClass('filter_required');
        $('#other_provider_impression').html('');

       // $('#non_unit_drags').removeClass('filter_required');
       // $('#non_unit_drags_intervenrion').addClass('filter_required');
      //  $('#unit_drags').addClass('filter_required');
     //   $('#unit_drags_consum').addClass('filter_required');

        $('#base_location').addClass('filter_required');
        $('#start_from_base').addClass('filter_required');
        $('#back_to_base').addClass('filter_required');
        $('#start_odometer_pcr').addClass('filter_required');
        $('#end_odometer_input').addClass('filter_required');
        $('#at_scene').addClass('filter_required');
         }
       else if($provider == '9'){
        $('#patient_gender').addClass('filter_required');
        $('#ptn_fname').addClass('filter_required');
        
        $('#amb_category').addClass('filter_required');
        $('#pcr_amb_id').addClass('filter_required');
        $('#emt_list').addClass('filter_required');
        $('#pilot_list').addClass('filter_required');
        
        $('#ercp_advice_input').addClass('filter_required');
        $('#inc_area_type').removeClass('filter_required');

        $('#loc').parent().find('input').addClass('filter_required');
        $('#baseline_con_airway').parent().find('input').addClass('filter_required');
        $('#baseline_con_circulation_radial').parent().find('input').addClass('filter_required');
        $('#baseline_con_circulation_carotid').parent().find('input').addClass('filter_required');
        $('#baseline_con_temp').addClass('filter_required');
        $('#baseline_con_osat').addClass('filter_required');
        $('#baseline_con_rr').addClass('filter_required');
        $('#baseline_con_gcs').parent().find('input').addClass('filter_required');
        $('#baseline_con_bp_syt').addClass('filter_required');
        $('#baseline_con_bp_dia').addClass('filter_required');
        $('#baseline_con_skin').parent().find('input').addClass('filter_required');
        $('#baseline_con_pupils').parent().find('input').addClass('filter_required');

        $('#loc_handover').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_airway').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_breathing').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_circulation_radial').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_circulation_carotid').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_temp').addClass('filter_required');
        $('#pt_con_handover_osat').addClass('filter_required');
        $('#pt_con_handover_rr').addClass('filter_required');
        $('#pt_con_handover_gcs').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_bp_syt').addClass('filter_required');
        $('#pt_con_handover_bp_dia').addClass('filter_required');
        $('#pt_con_handover_skin').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_pupils').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_pt_status_during_status').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_cardiac').parent().find('input').addClass('filter_required');
        
        $('#receiving_host').addClass('filter_required');
        $('#pcr_district').addClass('filter_required');
        $('#pcr_pat_id').addClass('filter_required');
        $('#other_provider_impression').html('');

         // $('#non_unit_drags').removeClass('filter_required');
       // $('#non_unit_drags_intervenrion').addClass('filter_required');
      //  $('#unit_drags').addClass('filter_required');
     //   $('#unit_drags_consum').addClass('filter_required');

        $('#base_location').addClass('filter_required');
        $('#start_from_base').addClass('filter_required');
        $('#back_to_base').addClass('filter_required');
        $('#start_odometer_pcr').addClass('filter_required');
        $('#end_odometer_input').addClass('filter_required');
        $('#at_scene').addClass('filter_required');     
        }else if($provider == '30'){
            $('#patient_gender').addClass('filter_required');
        $('#ptn_fname').addClass('filter_required');
        
        $('#amb_category').addClass('filter_required');
        $('#pcr_amb_id').addClass('filter_required');
        $('#emt_list').addClass('filter_required');
        $('#pilot_list').addClass('filter_required');
        
        $('#ercp_advice_input').addClass('filter_required');
        $('#inc_area_type').removeClass('filter_required');

        $('#loc').parent().find('input').addClass('filter_required');
        $('#baseline_con_airway').parent().find('input').addClass('filter_required');
        $('#baseline_con_circulation_radial').parent().find('input').addClass('filter_required');
        $('#baseline_con_circulation_carotid').parent().find('input').addClass('filter_required');
        $('#baseline_con_temp').addClass('filter_required');
        $('#baseline_con_osat').addClass('filter_required');
        $('#baseline_con_rr').addClass('filter_required');
        $('#baseline_con_gcs').addClass('filter_required');
        $('#baseline_con_bp_syt').addClass('filter_required');
        $('#baseline_con_bp_dia').addClass('filter_required');
        $('#baseline_con_skin').addClass('filter_required');
        $('#baseline_con_pupils').addClass('filter_required');

        $('#loc_handover').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_airway').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_breathing').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_circulation_radial').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_circulation_carotid').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_temp').addClass('filter_required');
        $('#pt_con_handover_osat').addClass('filter_required');
        $('#pt_con_handover_rr').addClass('filter_required');
        $('#pt_con_handover_gcs').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_bp_syt').addClass('filter_required');
        $('#pt_con_handover_bp_dia').addClass('filter_required');
        $('#pt_con_handover_skin').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_pupils').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_pt_status_during_status').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_cardiac').parent().find('input').addClass('filter_required');
        
        $('#receiving_host').addClass('filter_required');
        $('#pcr_district').addClass('filter_required');
        $('#pcr_pat_id').addClass('filter_required');
        $('#other_provider_impression').html('');

         // $('#non_unit_drags').removeClass('filter_required');
       // $('#non_unit_drags_intervenrion').addClass('filter_required');
      //  $('#unit_drags').addClass('filter_required');
     //   $('#unit_drags_consum').addClass('filter_required');
        $('#base_location').addClass('filter_required');
        $('#start_from_base').addClass('filter_required');
        $('#back_to_base').addClass('filter_required');
        $('#start_odometer_pcr').addClass('filter_required');
        $('#end_odometer_input').addClass('filter_required');
        $('#at_scene').addClass('filter_required');  
        }
        else{
            $('#patient_gender').addClass('filter_required');
            $('#ptn_fname').addClass('filter_required');
            
            $('#amb_category').addClass('filter_required');
            $('#pcr_amb_id').addClass('filter_required');
            $('#emt_list').addClass('filter_required');
            $('#pilot_list').addClass('filter_required');
            
            $('#ercp_advice_input').addClass('filter_required');
            $('#inc_area_type').removeClass('filter_required');

            $('#loc').parent().find('input').addClass('filter_required');
            $('#baseline_con_airway').parent().find('input').addClass('filter_required');
            $('#baseline_con_circulation_radial').parent().find('input').addClass('filter_required');
            $('#baseline_con_circulation_carotid').parent().find('input').addClass('filter_required');
            $('#baseline_con_temp').addClass('filter_required');
            $('#baseline_con_osat').addClass('filter_required');
            $('#baseline_con_rr').addClass('filter_required');
            $('#baseline_con_gcs').parent().find('input').addClass('filter_required');
            $('#baseline_con_bp_syt').addClass('filter_required');
            $('#baseline_con_bp_dia').addClass('filter_required');
            $('#baseline_con_skin').parent().find('input').addClass('filter_required');
            $('#baseline_con_pupils').parent().find('input').addClass('filter_required');

            $('#loc_handover').parent().find('input').addClass('filter_required');
            $('#pt_con_handover_airway').parent().find('input').addClass('filter_required');
            $('#pt_con_handover_breathing').parent().find('input').addClass('filter_required');
            $('#pt_con_handover_circulation_radial').parent().find('input').addClass('filter_required');
            $('#pt_con_handover_circulation_carotid').parent().find('input').addClass('filter_required');
            $('#pt_con_handover_temp').addClass('filter_required');
            $('#pt_con_handover_osat').addClass('filter_required');
            $('#pt_con_handover_rr').addClass('filter_required');
            $('#pt_con_handover_gcs').parent().find('input').addClass('filter_required');
            $('#pt_con_handover_bp_syt').addClass('filter_required');
            $('#pt_con_handover_bp_dia').addClass('filter_required');
            $('#pt_con_handover_skin').parent().find('input').addClass('filter_required');
            $('#pt_con_handover_pupils').parent().find('input').addClass('filter_required');
            $('#pt_con_handover_pt_status_during_status').parent().find('input').addClass('filter_required');
            $('#pt_con_handover_cardiac').parent().find('input').addClass('filter_required');
            
            $('#receiving_host').addClass('filter_required');
            $('#pcr_district').addClass('filter_required');
            $('#pcr_pat_id').addClass('filter_required');
            $('#other_provider_impression').html('');

             // $('#non_unit_drags').removeClass('filter_required');
       // $('#non_unit_drags_intervenrion').addClass('filter_required');
      //  $('#unit_drags').addClass('filter_required');
     //   $('#unit_drags_consum').addClass('filter_required');
            $('#base_location').addClass('filter_required');
        $('#start_from_base').addClass('filter_required');
        $('#back_to_base').addClass('filter_required');
        $('#start_odometer_pcr').addClass('filter_required');
        $('#end_odometer_input').addClass('filter_required');
        $('#at_scene').addClass('filter_required');
            
        }
    }
function remove_mandatory_fields() {
    var $provider = $("#provider_impressions").val();
    //console.log($provider);
    if ($provider == '45' || $provider == '35') {

        xhttprequest($(this), base_url + 'bike/other_provider_impression', 'output_position=other_provider_impression');
    } else if ($provider == '21') {
        $('#loc').removeClass('filter_required');
        //$('#loc').removeClass('has_error');
        $('#locality').removeClass('filter_required');
        //$('#locality').removeClass('has_error');
        $('#receiving_host').removeClass('filter_required');
        //$('#receiving_host').removeClass('has_error');
        $('#pcr_pat_id').removeClass('filter_required');
        //$('#pcr_pat_id').removeClass('has_error');
        $('#patient_gender').removeClass('filter_required');
        //$('#patient_gender').removeClass('has_error');
        $('#ptn_fname').removeClass('filter_required');
        //$('#ptn_fname').removeClass('has_error');
        $('#pcr_district').removeClass('filter_required');
        //$('#pcr_district').removeClass('has_error');  
        $('#amb_category').removeClass('filter_required');
        //$('#amb_category').removeClass('has_error');   
        $('#base_location').removeClass('filter_required');
        //$('#base_location').removeClass('has_error');     
        $('#start_from_base').removeClass('filter_required');
        //$('#start_from_base').removeClass('has_error');
        $('#back_to_base').removeClass('filter_required');
        //$('#back_to_base').removeClass('has_error');
        //$('#start_odometer_pcr').removeClass('filter_required');
        //$('#start_odometer_pcr').removeClass('has_error');
       // $('#end_odometer_input').removeClass('filter_required');
        //$('#end_odometer_input').removeClass('has_error');
        $('#at_scene').removeClass('filter_required');
        //$('#at_scene').removeClass('has_error');
        $('#pilot_list').removeClass('filter_required');
        //$('#pilot_list').removeClass('has_error');
        $('#forwording_feedback').removeClass('filter_required');
        //$('#forwording_feedback').removeClass('has_error');
        $('#other_provider_impression').html('');
    }  else if ($provider == '22') {

        xhttprequest($(this), base_url + 'bike/obious_death_popup', 'output_position=popup_div');
    } else if ($provider == '11' || $provider == '12') {

        xhttprequest($(this), base_url + 'bike/delivery_at_scene_popup', 'output_position=popup_div');
    } else if ($provider == '41' ||$provider == '42' || $provider == '43' || $provider == '44' || $provider == '52' || $provider == '53') {
        $('#patient_gender').removeClass('filter_required');
            $('#ptn_fname').removeClass('filter_required');
            $('#amb_category').removeClass('filter_required');
            $('#pcr_amb_id').removeClass('filter_required');
            $('#emt_list').addClass('filter_required');
            $('#pilot_list').addClass('filter_required');
            $('#ercp_advice_input').removeClass('filter_required');
            $('#inc_area_type').removeClass('filter_required');

            $('#loc').parent().find('input').removeClass('filter_required');
            $('#baseline_con_airway').parent().find('input').removeClass('filter_required');
            //$('#baseline_con_airway').find('input').removeClass('has_error');
            
            $('#baseline_con_circulation_radial').parent().find('input').removeClass('filter_required');
            $('#baseline_con_circulation_carotid').parent().find('input').removeClass('filter_required');
            $('#baseline_con_temp').removeClass('filter_required');
            $('#baseline_con_osat').removeClass('filter_required');
            $('#baseline_con_rr').removeClass('filter_required');
            $('#baseline_con_gcs').parent().find('input').removeClass('filter_required');
            $('#baseline_con_bp_syt').removeClass('filter_required');
            $('#baseline_con_bp_dia').removeClass('filter_required');
            $('#baseline_con_skin').parent().find('input').removeClass('filter_required');
            $('#baseline_con_pupils').parent().find('input').removeClass('filter_required');
            
            $('#loc_handover').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_airway').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_breathing').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_circulation_radial').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_circulation_carotid').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_temp').removeClass('filter_required');
            $('#pt_con_handover_osat').removeClass('filter_required');
            $('#pt_con_handover_rr').removeClass('filter_required');
            $('#pt_con_handover_gcs').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_bp_syt').removeClass('filter_required');
            $('#pt_con_handover_bp_dia').removeClass('filter_required');
            $('#pt_con_handover_skin').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_pupils').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_pt_status_during_status').parent().find('input').removeClass('filter_required');
            $('#pt_con_handover_cardiac').parent().find('input').addClass('filter_required');
            
            $('#receiving_host').removeClass('filter_required');
            $('#pcr_district').removeClass('filter_required');
            $('#pcr_pat_id').removeClass('filter_required');
            $('#other_provider_impression').html('');
    } else {
        $('#patient_gender').addClass('filter_required');
        $('#ptn_fname').addClass('filter_required');
        
        $('#amb_category').addClass('filter_required');
        $('#pcr_amb_id').addClass('filter_required');
        $('#emt_list').addClass('filter_required');
        $('#pilot_list').addClass('filter_required');
        
        $('#ercp_advice_input').addClass('filter_required');
        $('#inc_area_type').removeClass('filter_required');

        $('#loc').parent().find('input').addClass('filter_required');
        /*$('#baseline_con_airway').parent().find('input').addClass('filter_required');
        //$('#baseline_con_airway').find('input').addClass('has_error');
        $('#baseline_con_circulation_radial').parent().find('input').addClass('filter_required');
        $('#baseline_con_circulation_carotid').parent().find('input').addClass('filter_required');
        $('#baseline_con_temp').addClass('filter_required');
        $('#baseline_con_osat').addClass('filter_required');
        $('#baseline_con_rr').addClass('filter_required');
        $('#baseline_con_gcs').parent().find('input').addClass('filter_required');
        $('#baseline_con_bp_syt').addClass('filter_required');
        $('#baseline_con_bp_dia').addClass('filter_required');
        $('#baseline_con_skin').parent().find('input').addClass('filter_required');
        $('#baseline_con_pupils').parent().find('input').addClass('filter_required');

        $('#loc_handover').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_airway').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_breathing').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_circulation_radial').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_circulation_carotid').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_temp').addClass('filter_required');
        $('#pt_con_handover_osat').addClass('filter_required');
        $('#pt_con_handover_rr').addClass('filter_required');
        $('#pt_con_handover_gcs').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_bp_syt').addClass('filter_required');
        $('#pt_con_handover_bp_dia').addClass('filter_required');
        $('#pt_con_handover_skin').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_pupils').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_pt_status_during_status').parent().find('input').addClass('filter_required');
        $('#pt_con_handover_cardiac').parent().find('input').addClass('filter_required');
        */
        $('#receiving_host').addClass('filter_required');
        $('#pcr_district').addClass('filter_required');
        $('#pcr_pat_id').addClass('filter_required');
        $('#other_provider_impression').html('');

         // $('#non_unit_drags').removeClass('filter_required');
       // $('#non_unit_drags_intervenrion').addClass('filter_required');
      //  $('#unit_drags').addClass('filter_required');
     //   $('#unit_drags_consum').addClass('filter_required');

        $('#base_location').addClass('filter_required');
        //$('#base_location').addClass('has_error');     
        $('#start_from_base').addClass('filter_required');
        //$('#start_from_base').addClass('has_error');
        $('#back_to_base').addClass('filter_required');
        //$('#back_to_base').addClass('has_error');
        $('#start_odometer_pcr').addClass('filter_required');
        //$('#start_odometer_pcr').addClass('has_error');
        $('#end_odometer_input').addClass('filter_required');
        //$('#end_odometer_input').addClass('has_error');
        $('#at_scene').addClass('filter_required');
        //$('#at_scene').addClass('has_error');
        $('#forwording_feedback').addClass('filter_required');
        //$('#forwording_feedback').addClass('has_error');
        $('#other_provider_impression').html('');
    }
    

}
function chief_comp_fields(){
        var $chief_comp =  $('#pt_con_ongoing_chief_comp').parent().find('input').val();
    console.log($chief_comp);
    if($chief_comp == '52'){
         $('#ongoing_chief_comp_other').removeClass('hide');
    }else{
         $('#ongoing_chief_comp_other').addClass('hide');
    }
}
function hospital_other_textbox() {
    var $receiving_host = $("#receiving_host").val();
   
    if ($receiving_host == 'Other' || $receiving_host == 0) {

        xhttprequest($(this), base_url + 'bike/other_hospital_textbox', 'output_position=other_hospital_textbox');
    } else {
        $('#other_hospital_textbox').html('');
    }

}
function ercp_advice_taken() {
    var $ercp_advice = $("#ercp_advice_input").val();
   console.log($ercp_advice);
    if ($ercp_advice == 'advice_Yes') {

        $('#ercp_advice').removeClass('hide');
    } else {
        $('#ercp_advice').addClass('hide');
    }

}
function serch_by_amb_no(ft){
    $ft_id = ft['id'];
    var $lat = $("#lat").val();
    console.log($lat);
    var $lng = $("#lng").val();
    
    var $amb_type = [];
    $('input[name="amb_type[]"]:checked').each(function() {
         $amb_type.push($(this).val());
    });
    $inc_type = $('#inc_type').val();
    var $dist_id = $("#incient_dist .mi_autocomplete").val();
    //console.log($lng);
   // xhttprequest($(this), base_url + 'inc/get_inc_ambu?amb_id=' + $ft_id + '&lat=' + $lat + '&lng='+ $lng+')', 'output_position=content&amb_id=' + $ft_id + '&lat' + $lat ,'&lng'+ $lng);
  // xhttprequest($(this), base_url + 'inc/get_inc_ambu?amb_id=' + $ft_id,'output_position=content&amb_id=' + $ft_id );
    $('#get_ambu_details').attr('href',base_url+'inc/get_inc_ambu?amb_id=' +$ft_id+ '&showprocess=yes&inc_type='+$inc_type+'&amb_tp='+$amb_type+'&lat='+$lat+'&lng='+$lng);
    $("#get_ambu_details").click();
}
function single_ambulance_load(){
    var $amb_id = $("#amb_id").val();
    xhttprequest($(this), base_url + 'amb/load_single_amb', 'output_position=content&amb_id=' + $amb_id);
    
}
function hospital_avaibility(){
    var $host = $("#host").val();
    console.log($host);
    if ($host == 'Other' || $host == 0) {

        xhttprequest($(this), base_url + 'hp/ero_other_hospital', 'output_position=hospital_details');
    } else {
        xhttprequest($(this), base_url + 'hp/ero_hospital', 'output_position=hospital_details&host='+$host);
    }
}
function pt_handover_issue_change(){
    var pt_con_handover_issue = $("#pt_con_handover_issue").val();
    console.log(pt_con_handover_issue);
    if(pt_con_handover_issue == 'Yes')
    {
        $("#handover_issue_yes").show();
        $("#handover_issue_no").hide();
        
    }else{
        $("#handover_issue_no").show();
        $("#handover_issue_yes").hide();
    } 
}
function cardiact_change(){
    var pt_con_handover_cardiac = $("#pt_con_handover_cardiac").val();
    console.log(pt_con_handover_cardiac);
    if(pt_con_handover_cardiac == 'Yes')
    {
        $("#Cardiact_time_div").show();
        $('#Cardiact_time_div input').addClass('filter_required');
        $('#Cardiact_time_div input').addClass('has_error');
    }else{
        $('#Cardiact_time_div input').removeClass('filter_required');
        $('#Cardiact_time_div input').removeClass('has_error');
        $("#Cardiact_time_div").hide();
    }
}
function show_emso_id() {
   // var $emt_ref_id = $("#emt_list").val();
    //xhttprequest($(this), base_url + 'bike/show_emso_id', 'output_position=show_emso_id&emt_id=' + $emt_ref_id);
    var $emt_ref_id = $("#emt_list").val();
    if ($emt_ref_id == 'Other' || $emt_ref_id == 0) {
       // document.getElementById("emt_id_new").value = 'NA';
       $("#show_emso_name").hide();
       $("#emt_other_textbox").show();
        xhttprequest($(this), base_url + 'bike/other_emt_textbox', 'output_position=emt_other_textbox');
        
    }else {
        $("#show_emso_name").show();
       $("#emt_other_textbox").hide();
        xhttprequest($(this), base_url + 'bike/show_emso_id', 'output_position=show_emso_id&emt_id=' + $emt_ref_id);
    }
}
function single_ambulance_load_dash(){
    var $amb_id = $("#ambulance_id").val();
    // console.log($amb_id);
    xhttprequest($(this), base_url + 'dashboard/load_single_amb_dash', 'output_position=content&amb_id=' + $amb_id);
}

function show_emso_name(){
    var $emso_name = $("#emso_name").val();
    if ($emso_name == 'Other' || $emso_name == 0) {
       xhttprequest($(this), base_url + 'bike/other_emt_textbox_gri', 'output_position=pilot_other_textbox');
       $("#emt_other_textbox").show();
    }
    else{
        console.log('jjj');
        $("#emt_other_textbox").hide();
    }
}
function show_sub_type_gri(){
    var $chief_complete = $("#Gri_sub_type").val();
    if ($chief_complete != '') {
        xhttprequest($(this), base_url + 'Grievance/show_gri_sub_type', 'output_position=gri_sub_type&chief_complete=' + $chief_complete);
       //xhttprequest($(this), base_url + 'bike/other_emt_textbox_gri', 'output_position=pilot_other_textbox');
      // $("#emt_other_textbox").show();
    }
    else{
        console.log('jjj');
       // $("#emt_other_textbox").hide();
    }
}
function show_pilot_name(){
    var $pilot_name = $("#pilot_name").val();
    if ($pilot_name == 'Other' || $pilot_name == 0) {
       xhttprequest($(this), base_url + 'bike/other_pilot_textbox_gri', 'output_position=pilot_other_textbox');
       $("#pilot_other_textbox").show();  
    }
    else{
        console.log('hiii');
        $("#pilot_other_textbox").hide();
    }
}
function show_pilot_idnew() {
    //var $pilot_ref_id = $("#pilot_list").val();
   // xhttprequest($(this), base_url + 'bike/show_pilot_idnew', 'output_position=show_pilot_idnew&pilot_id=' + $pilot_ref_id);
   var $pilot_ref_id = $("#pilot_list").val();
    if ($pilot_ref_id == 'Other' || $pilot_ref_id == 0) {
       // document.getElementById("pilot_id_new").value = 'NA';
        $("#show_pilot_name").hide();
       $("#pilot_other_textbox").show();
       
        $('#pilot_id_new').removeClass('filter_required');
        $('#pilot_id_new').removeClass('has_error');
        xhttprequest($(this), base_url + 'bike/other_pilot_textbox', 'output_position=pilot_other_textbox');
        
    }else {
        $("#show_pilot_name").show();
       $("#pilot_other_textbox").hide();
        xhttprequest($(this), base_url + 'bike/show_pilot_idnew', 'output_position=show_pilot_idnew&pilot_id=' + $pilot_ref_id);
    }
}

function show_all_emso_id() {
    var $emt_ref_id = $("#emt_list").val();
    xhttprequest($(this), base_url + 'bike/show_all_emso_id', 'output_position=show_emso_id&emt_id=' + $emt_ref_id);
}
function show_all_user_data() {
    var $user_ref_id = $("#emt_list").val();
    xhttprequest($(this), base_url + 'schedule_crud/show_all_user_data', 'output_position=show_all_user_data&user_id=' + $user_ref_id);
}
function load_po_by_atc(ft) {
    $act_id = ft['id'];
    xhttprequest($(this), base_url + 'cluster/get_auto_po', 'atc_id=' + $act_id);
}

function load_dash_po_by_atc(ft) {
    $act_id = ft['id'];
    xhttprequest($(this), base_url + 'dash/get_dash_auto_po', 'atc_id=' + $act_id);
}
function load_cluster_by_po(ft) {
    $po_id = ft['id'];
    xhttprequest($(this), base_url + 'dash/get_auto_cluster', 'po_id=' + $po_id);
}
function load_po_by_atc_clg(ft) {
    $act_id = ft['id'];
    xhttprequest($(this), base_url + 'dash/get_dash_auto_po_clg', 'atc_id=' + $act_id);
}
function load_cluster_by_po_clg(ft) {
    $po_id = ft['id'];
    xhttprequest($(this), base_url + 'dash/get_auto_cluster_clg', 'po_id=' + $po_id);
}
function show_pilot_id() {
    var $ref_id = $("#pilot_name_list").val();
    xhttprequest($(this), base_url + 'bike/show_pilot_id', 'output_position=show_pilot_id&ref_id=' + $ref_id);
}
function show_pilot_id_name() {
    var $ref_id = $("#pilot_name_list").val();
    xhttprequest($(this), base_url + 'bike/show_pilot_name', 'output_position=show_pilot_id&ref_id=' + $ref_id);
}
function show_pilot_data() {
    var $ref_id = $("#pilot_name_list").val();
    xhttprequest($(this), base_url + 'bike/show_pilot_data', 'output_position=show_pilot_id&id=' + $ref_id);
}

function get_caller_details() {
    var $caller_no = $("#caller_no").val();
    xhttprequest($(this), base_url + 'calls/get_caller_details', 'output_position=content&m_no="' + $caller_no + '"');
}
function cluster_schools_list() {
    var $clusterid = $("#clusterid").val();
    xhttprequest($(this), base_url + 'schedule/cluster_schools', 'output_position=schedule_clusterid&cluster_id=' + $clusterid);
}
function get_student_by_school(ft) {
    var $school_id = $("#school_id").val();
    xhttprequest($(this), base_url + 'sickroom/get_student_by_school', 'school_id=' + $school_id);
}
function student_check_list() {
    var $school_id = $("#school_id").val();
    xhttprequest($(this), base_url + 'schedule/student_checklist', 'output_position=student_check_list&school_id=' + $school_id);
}
function load_ero_by_supervisor() {
    var $ero_supervisor = $("#ero_supervisor input").val();
    xhttprequest($(this), base_url + 'quality/get_ero_list', 'output_position=ERO_list&ero_supervisor=' + $ero_supervisor);
}
function load_dco_by_supervisor() {
    var $ero_supervisor = $("#ero_supervisor input").val();
    xhttprequest($(this), base_url + 'quality/get_dco_list', 'output_position=ERO_list&ero_supervisor=' + $ero_supervisor);
}
function load_ercp_by_supervisor() {
    var $ero_supervisor = $("#ero_supervisor input").val();
    xhttprequest($(this), base_url + 'quality/get_ercp_list', 'output_position=ERO_list&ero_supervisor=' + $ero_supervisor);
}
function load_griviance_by_supervisor() {
    var $ero_supervisor = $("#ero_supervisor input").val();
    xhttprequest($(this), base_url + 'quality/get_griviance_list', 'output_position=ERO_list&ero_supervisor=' + $ero_supervisor);
}
function load_feedback_by_supervisor() {
    var $ero_supervisor = $("#ero_supervisor input").val();
    xhttprequest($(this), base_url + 'quality/get_feedback_list', 'output_position=ERO_list&ero_supervisor=' + $ero_supervisor);
}
function load_pda_by_supervisor() {
    var $ero_supervisor = $("#ero_supervisor input").val();
    xhttprequest($(this), base_url + 'quality/get_police_list', 'output_position=ERO_list&ero_supervisor=' + $ero_supervisor);
}
function load_fire_by_supervisor() {
    var $ero_supervisor = $("#ero_supervisor input").val();
    xhttprequest($(this), base_url + 'quality/get_fire_list', 'output_position=ERO_list&ero_supervisor=' + $ero_supervisor);
}
function district_wise_hospital(ft) {
    
    var $district_id =   ft['id'];;
    xhttprequest($(this), base_url + 'hp/district_wise_hospital', 'output_position=current_facility_box&district_id=' + $district_id);
}
function drop_district_wise_hospital(ft) {
    
    var $district_id =   ft['id'];;
    xhttprequest($(this), base_url + 'hp/drop_district_wise_hospital', 'output_position=current_facility_box&district_id=' + $district_id);
}
function district_wise_hospital_new(ft) {
    
    var $district_id =   ft['id'];;
    xhttprequest($(this), base_url + 'hp/district_wise_hospital_new', 'output_position=new_facility_box&district_id=' + $district_id);
}
function district_wise_hospital_epcr(ft) {

    var $district_id =   ft['id'];;
    xhttprequest($(this), base_url + 'hp/district_wise_hospital_epcr', 'output_position=new_facility_box&district_id=' + $district_id);
}
function chief_complete_change(ft) {
    if (ft['id'] == 52) {
        console.log('hi');
        $('#chief_complete_other').removeClass('hide');
        $('#chief_complete_other_text').addClass('filter_required');
        $('#chief_complete_other_text').addClass('has_error');
    } else {
        $('#chief_complete_other').addClass('hide');
        $('#chief_complete_other_text').removeClass('filter_required');
        $('#chief_complete_other_text').removeClass('has_error');
    }
    xhttprequest($(this), base_url + 'inc/get_chief_complete_service', 'cm_id=' + ft['id']);
}
function police_chief_complete_change(ft) {

    if (ft['id'] == 30) {
        $('#police_chief_complete_other').removeClass('hide');
    } else {
        $('#police_chief_complete_other').addClass('hide');
    }
}

function fire_chief_complete_change(ft) {
    if (ft['id'] == 1) {
        $('#fire_chief_complete_other').removeClass('hide');
    } else {
        $('#fire_chief_complete_other').addClass('hide');
    }
}


function ero_standard_summary_change_followup(ft){
    if(ft['id'] == 14){
        $('#followup_reason_other').css({'display': 'block'});
    } else {
        $('#followup_reason_other').css({'display': 'none'});
    }
}
/*function vehical_no(){
    var str = document.getElementById('amb_validation').value;
   // str = "MH/14/AA/2000";                                                             
    var pattern = /^[A-Z]{2}[ -][0-9]{1,2}(?: [A-Z])?(?: [A-Z]*)? [0-9]{4}$/i;
    var result = str.match(pattern);                    
    if(!result)
    {
     
        $('#amb_validation').addClass('filter_required');
        $('#amb_validation').addClass('has_error'); 
    }else{
   
        $('#amb_validation').removeClass('filter_required');
        $('#amb_validation').removeClass('has_error');
   }
   
}*/
function ero_standard_summary_change(ft) {
//alert(ft);
//    if(ft['id'] == 16){
//        $('#ero_summary_other').removeClass('hide');
//    }else{
//        $('#ero_summary_other').addClass('hide');
//    }

       // console.log(ft['id']);
        if (ft['id'] == '69') {    
           // console.log(ft['id']);

            $("#sum").val("Caller wants to complaint against the Maharashtra  EMS services, call transferred to Grievance Desk");
            $('#problem_reporting_call .forward_button').removeClass('hide');
            $('#problem_reporting_call .save_button').addClass('hide');
        }else if (ft['id'] == '70') {
            $("#sum").val("call transferred to FDA Desk");
            $('#problem_reporting_call .forward_button').removeClass('hide');
            $('#problem_reporting_call .save_button').addClass('hide');
        }else  if (ft['id'] == '72') {
          $("#sum").val("call transferred to PDA Desk");
            $('#problem_reporting_call .forward_button').removeClass('hide');
            $('#problem_reporting_call .save_button').addClass('hide');
        }  else {    
           // console.log(ft['id']);
            
            $("#sum").val("Caller complaint has been resolved as per information available, Caller satisfied with information hence call closed");
            $('#problem_reporting_call .save_button').removeClass('hide');
            $('#problem_reporting_call .forward_button').addClass('hide');
        }
        
//        if (ft['id'] == '70') {
//            $("#sum").val("call transferred to FDA Desk");
//            $('#problem_reporting_call .forward_button').removeClass('hide');
//            $('#problem_reporting_call .save_button').addClass('hide');
//        } else {
//            $("#sum").val("Caller complaint has been resolved as per information available, Caller satisfied with information hence call closed");
//            $('#problem_reporting_call .save_button').removeClass('hide');
//            $('#problem_reporting_call .forward_button').addClass('hide');
//        }


//        if (ft['id'] == '72') {
//          $("#sum").val("call transferred to PDA Desk");
//            $('#problem_reporting_call .forward_button').removeClass('hide');
//            $('#problem_reporting_call .save_button').addClass('hide');
//        } else {
//            $("#sum").val("Caller complaint has been resolved as per information available, Caller satisfied with information hence call closed");
//            $('#problem_reporting_call .save_button').removeClass('hide');
//            $('#problem_reporting_call .forward_button').addClass('hide');
//        }
}
function load_inspection_ambulance_main_type(ft){
    var $type = ft['id'];
    xhttprequest($(this), base_url + 'inspection/load_inspection_ambulance_main', 'output_position=maintaince_ambulance&type=' +$type);
    
}
function load_baselocation_ambulance(ft){
    var $baselocation = ft['id'];
    xhttprequest($(this), base_url + 'ambulance_maintaince/load_baselocation_ambulance', 'output_position=maintaince_ambulance&base_location=' +$baselocation);
    
}
function load_baselocation_address(ft){
    var $baselocation = ft['id'];
   // console.log($baselocation);
    var a = document.getElementById("load_baselocation_address");
    a.style.display = "block";
    xhttprequest($(this), base_url + 'amb/load_baselocation_address', 'output_position=load_baselocation_address&base_location=' +$baselocation);
}
function get_previous_incident(ft) {
    $("#get_previous_inc_details").click();
}
function responce_remark_change() {
    var $responce_remark = $("#responce_remark").val();
    if ($responce_remark == 5) {
        $('#responce_time_remark_other').removeClass('hide');
    } else {
        $('#responce_time_remark_other').addClass('hide');
    }
}
function load_wardlocation_address(ft){
    var $wardlocation = ft['id'];
  // console.log($baselocation);
    var a = document.getElementById("load_baselocation_address");
    a.style.display = "block";
    xhttprequest($(this), base_url + 'amb/load_wardlocation_address', 'output_position=load_baselocation_address&wardlocation=' +$wardlocation);
    //xhttprequest($(this), base_url + 'amb/load_wardlocation_address_view', 'output_position=load_baselocation_address&base_location=' +$baselocation);
}
function Odometer_change_display(){
    var $odometer_change_type = $("#odometer_change_type").val();
    var $amb = document.getElementById("amb").value;
   // var submit_amb = document.getElementById("submit_amb");
  //  var date = document.getElementById("date");
    if ($odometer_change_type == '1') {
        xhttprequest($(this), base_url + 'amb/load_case_closure_odo', 'output_position=load_baselocation_address&amb='+$amb);
        /*  $('.onpage_popup').addClass('filter_required');
        $('.onpage_popup').addClass('has_error');
        a.style.display = "block";
        b.style.display = "none";
        */
    }
    else if ($odometer_change_type == '2') {
        xhttprequest($(this), base_url + 'amb/load_new_fitted_odo', 'output_position=load_baselocation_address&amb='+$amb);
        /*
        $('.onpage_popup').removeClass('filter_required');
        $('.onpage_popup').removeClass('has_error');
        b.style.display = "block";
        a.style.display = "none";
        */
    }
}
function display_wrd_bl_new(){
    var $amb_cat = $("#amb_cat").val();
   /* if(ft['id'] == 14){
        $('#followup_reason_other').css({'display': 'block'});
    } else {
        $('#followup_reason_other').css({'display': 'none'});
    }*/
    var z = document.getElementById("ward_div");
        var b = document.getElementById("base_location_div");
        var a = document.getElementById("load_baselocation_address");
        
    if ($amb_cat == '5') {
        z.style.display = "block";
        b.style.display = "none";
        a.style.display = "none";
        
        $('#wrd_district').addClass('filter_required');
        $('#wrd_district').addClass('has_error');
         
    }else{
        b.style.display = "block";
        z.style.display = "none";
        $('#ward_div').removeClass('hide');
        $('#baselocation_address').addClass('filter_required');
        $('#baselocation_address').addClass('has_error');
        $('#wrd_district').removeClass('filter_required');
        $('#wrd_district').removeClass('has_error');
    }
}
 function display_wrd_bl(){
        var amb_cat = $('#amb_cat').val();
        var z = document.getElementById("ward_div");
        var b = document.getElementById("base_location_div");
        var a = document.getElementById("load_baselocation_address");
        if (amb_cat == '3' || amb_cat == '4') {
            z.style.display = "block";
            b.style.display = "none";
            a.style.display = "none";
            
            $('#wrd_district').addClass('filter_required');
            $('#wrd_district').addClass('has_error');
             
        }
        else if(amb_cat == '1' || amb_cat == '2' ){
             b.style.display = "block";
            z.style.display = "none";
            $('#ward_div').removeClass('hide');
            $('#baselocation_address').addClass('filter_required');
            $('#baselocation_address').addClass('has_error');
            $('#wrd_district').removeClass('filter_required');
            $('#wrd_district').removeClass('has_error');
        }
    }

function covid_status_change(){
    var covid_status = $('#covid_status').val();
    var z = document.getElementById("covide_div");
    if (covid_status == 'Yes') {
        z.style.display = "block";
    }
    else{
        z.style.display = "none";
    }
}
function shatplus_change(){
    //console.log("hiii");
    var Shatplus_status = $('#Shatplus_status').val();
    var x = document.getElementById("Shatplus_div");
    if (Shatplus_status == 'Yes') {
        x.style.display = "block";
    }
    else{
        x.style.display = "none";
    }
}
function arsenicum_change(){
    var Arsenicum_status = $('#Arsenicum_status').val();
    var y = document.getElementById("Arsenicum_div");
   // console.log("Arsenicum_status");
    if (Arsenicum_status == 'Yes') {
        y.style.display = "block";
    }
    else{
        y.style.display = "none";
    }
}
function get_amb_by_distance() {

//var href_data = $('#get_ambu_details').attr('href');
    var p_lat = $('#add_inc_details #lat').val();
    var p_lng = $('#add_inc_details #lng').val();
    var min_distance = $('#inc_min_distance').val();
    var $amb_type = '';
    if ($('#inc_ambu_type_details').length >= 1) {
        $amb_type = $('#amb_type').val();
    }
    var $inc_type = $('#inc_type').val();
    $('#get_ambu_details').attr('href', base_url + 'inc/get_inc_ambu?inc_type=' + $inc_type + '&amb_tp=' + $amb_type + '&lat=' + p_lat + '&lng=' + p_lng + '&min_distance=' + min_distance);
    // $('#get_ambu_details').attr('href',href_data+'&min_distance='+ft['value']);
    $("#get_ambu_details").click();
}


function submit_caller_form() {
//$("#caller_details_form").click();
    var $patient_gender = $("#patient_gender").val();
   // console.log($patient_gender);
    // $('#responce_remark').parent().find('input')
    $('#chief_complete').parent().find('input').attr('data-href',base_url+'auto/get_chief_complete?patient_gender='+$patient_gender);
    $("#submit_call").trigger('click');
}
function submit_caller_non_eme_form() {
    console.log("submit_caller_non_eme_form");
    $("#submit_non_call").trigger('click');
}
function change_purpose_call(){
    var $parent_purpose = $("#parent_call_purpose").val();
    var $caller_no = $("#caller_no").val();
    var $caller_call_id = $("#caller_call_id").val();

    xhttprequest($(this), base_url + 'calls/load_child_purpose', "parent_purpose=" + $parent_purpose);
    if($caller_no != ''){
        console.log($caller_call_id);
        xhttprequest($(this), base_url + 'calls/update_call_details', "parent_purpose=" + $parent_purpose + '&caller_call_id=' + $caller_call_id );
    }
}

var lock_screen_flag = 0;
var LOCK_SCREEN_FLAG = 0;
var LOCK_SCREEN_TIMER = new Date().getTime();
var TIME_LIMIT = 3600 * 1000;
var $ck_timer_obj;
jQuery(document).ready(function () {
    $ck_timer_obj = setInterval(check_timer, 1000);
    jQuery("#lock_screen_btn").on('click', lock_screen);
});
function update_timer() {

    if (LOCK_SCREEN_FLAG == 0) {
        LOCK_SCREEN_TIMER = new Date().getTime();
    }

}

function check_timer() {

    if (LOCK_SCREEN_FLAG == 0) {

        var CURR_LIMIT = new Date().getTime();
        var time_diff = CURR_LIMIT - LOCK_SCREEN_TIMER;
        if (time_diff > TIME_LIMIT) {
// lock_screen();
        }

    }

}

function lock_screen() {

    LOCK_SCREEN_FLAG = 1;
   
    $.ajax({

        url: base_url + "clg/user_screen_lock",
        data: {
            LOCK_STATUS: '1'
        },
        type: 'POST'

    }).done(function (data) {
        var data = JSON.parse(data);
        jQuery(".lock_screen_page_container").fadeIn('slow');
        jQuery(".lock_screen_page_container").addClass('lock_screen');
        clock_timer(data.div_id, data.start_time, '');
        break_total_timer(data.break_total_time);
        $("#session_break_type").val(data.break_type);
        $("#break_name_id").html(data.break_type_name);
       
    });
    $(".sl_pwd_field_input").val("");
     stop_incoming_call_event();
}

function unlock_screen() {
    LOCK_SCREEN_FLAG = 0;
    LOCK_SCREEN_TIMER = new Date().getTime();
    jQuery(".lock_screen_page_container").fadeOut('slow');
    jQuery(".lock_screen_page_container").removeClass('lock_screen');
    StopTimerFunction();
}

var timer_countdown;
function clock_timer(id, start_time, current_time) {
    
    StopTimerFunction();
    var start_time = parseInt(start_time);
    if (current_time != '') {
        var countDownDate = parseInt(current_time);
    } else {

        var countDownDate = parseInt(start_time);
    }
    timer_countdown = setInterval(function () {

        countDownDate++;
        // Find the distance between now and the count down date
        var distance = countDownDate - start_time;
        // Time calculations for days, hours, minutes and seconds
        var hours = Math.floor((distance % (60 * 60 * 24)) / (60 * 60));
        var minutes = Math.floor((distance % (60 * 60)) / (60));
        var seconds = Math.floor((distance % (60)));
        hours = (hours <= 9) ? '0' + hours : hours;
        minutes = (minutes <= 9) ? '0' + minutes : minutes;
        seconds = (seconds <= 9) ? '0' + seconds : seconds;
        // minutes = minutes.push((minutes + '').padStart(2, 0));
        // seconds = seconds.push((seconds + '').padStart(2, 0));

        $('#' + id).val(hours + ":" + minutes + ":" + seconds);
        if ($('#caller_dis_timer').length >= 1) {
            $('#caller_dis_timer').val(hours + ":" + minutes + ":" + seconds);
        }

    }, 1000);
}

function StopTimerFunction() {

    clearTimeout(timer_countdown);
}

   
         
function break_total_timer(break_total_time){

            //countDownDate++;
            // Find the distance between now and the count down date
           var distance = break_total_time;
            
        timer_countdown = setInterval(function () {
            distance++;
            
            // Time calculations for days, hours, minutes and seconds
            var hours1 = Math.floor((distance % (60 * 60 * 24)) / (60 * 60));
            var minutes1 = Math.floor((distance % (60 * 60)) / (60));
            var seconds1 = Math.floor((distance % (60)));
            hours1 = (hours1 <= 9) ? '0' + hours1 : hours1;
            minutes1 = (minutes1 <= 9) ? '0' + minutes1 : minutes1;
            seconds1 = (seconds1 <= 9) ? '0' + seconds1 : seconds1;
            // minutes = minutes.push((minutes + '').padStart(2, 0));
            // seconds = seconds.push((seconds + '').padStart(2, 0));

            $('#break_total_timer_clock').val(hours1 + ":" + minutes1 + ":" + seconds1);
         }, 1000); 

}
function printElem(divId) {
    var content = document.getElementById(divId).innerHTML;
    var mywindow = window.open('', 'Print', 'height=600,width=800');
    console.log('<link rel="stylesheet" href=' + base_url + 'themes/backend/css/print_style.css" type="text/css" />');
    mywindow.document.write('<html><head><title>Print</title>');
    // mywindow.document.write('<link rel="stylesheet" href="'+base_url+'themes/backend/css/print_style.css" type="text/css" />');
    mywindow.document.write('</head><body >');
    mywindow.document.write(content);
    mywindow.document.write('</body></html>');
    mywindow.document.close();
    mywindow.focus()
    mywindow.print();
    mywindow.close();
    return true;
}

var $AVAYA_INCOMING_CALL_FLAG = 1;
var $Avaya_Incoming_Call_Timer = null;
$(window).load(function () {
    $Avaya_Incoming_Call_Timer = setInterval(avaya_change_incoming_call, 5000);
});
function avaya_change_incoming_call() {
    if ($AVAYA_INCOMING_CALL_FLAG == 1) {
//        $.get( base_url+'calls/avaya_get_incoming_calls',function($data){
//            $data = JSON.parse($data);
//            if($data.length != 0){
//                
//                $('a#mt_atnd_calls').click();
//                setTimeout(function(){
//                     console.log($data);
//                     $('#caller_no').val($data.m_no);
//                     $('#clr_ext_no_val').val($data.ext_no);
//                },1000);
//                 $AVAYA_INCOMING_CALL_FLAG = 0;
//            }
//        });
//        
//                      
       // $('a.avaya_incoming_call_refresh').click();
    }
}

function avaya_start_incoming_call() {
    $AVAYA_INCOMING_CALL_FLAG = 1;
}

function keep_alive_clg() {
    //xhttprequest($(this), base_url+'clg/keep_alive_clg','output_position=content&module_name=clg&amp;showprocess=no');
    $('a.keep_alive_button').click();
    setTimeout(function () {
        keep_alive_clg();
    }, 60000);
}

function is_clg_login() {

    var $ref_no = sessionStorage.getItem("clg_details");

    if (typeof $ref_no == 'undefined' || $ref_no == '' || $ref_no == null) {
        $ref_id = $.cookie("username");

        document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "user_logged_in=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        xhttprequest($(this), base_url + 'clg/is_login_set_no', 'output_position=content&ref_id=' + $ref_id);
        return false;
    }

    return true;


}

$(document).on("click", "#attend_dialer_box .dialer_close", function () {
    $('#attend_dialer_box').hide(0);
    sessionStorage.setItem('avaya_dialer_popup',0);
});

jQuery(document).ready(function () {
$('#container').on("click", "#attend_call_btn", function () {
    console.log('hi');
    $('#refresh_button').css({'display': 'none'});
    $('.dash_lnk').css({'display': 'none'});
    $('#mt_atnd_calls').css({'display': 'none'});
    
    //recieve_avaya_call();
    sessionStorage.setItem('avaya_dialer_popup',0);
});
});

$(document).on("change", "#crud_user_group_id", function () {
    var group_id = $('#crud_user_group_id').val();
    xhttprequest($(this), base_url + 'schedule_crud/load_user_by_group', 'output_position=load_user_by_group&clg_group='+group_id);
});

$(document).keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    var $avaya_dialer_popup = sessionStorage.getItem('avaya_dialer_popup');  
    
    if(keycode == '13' && $avaya_dialer_popup == 1){
       // recieve_avaya_call();
//        $("#attend_dialer_box #attend_call_btn").click();
//        $('#attend_dialer_box').css({'display': 'none'});
//        sessionStorage.setItem('avaya_dialer_popup',0);  
    }
});


var $incoming_call_event_source = null;
function start_incoming_call_event(){
    
   $clg_group = sessionStorage.getItem('clg_group'); 
   $avaya_agentid = sessionStorage.getItem('avaya_agentid');

    
    $incoming_call_event_source = new EventSource(base_url+'incoming_call_event.php?clg_group='+$clg_group+'&avaya_agentid='+$avaya_agentid);
    // $incoming_call_event_source = new EventSource('http://localhost/mhems/incoming_call_event.php?clg_group='+$clg_group+'&avaya_agentid='+$avaya_agentid);
    
    $incoming_call_event_source.onmessage = function(e) {
        
        var $event_data = JSON.parse(e.data);
        console.log($event_data.action);
        
        if($event_data.action == 'open_dialer'){
          
            $('#attend_dialer_box .dial_no_box input').val($event_data.mobile_no);
            $('#attend_dialer_box .click-xhttp-request').attr('data-qr',$event_data.data_qr);
            $('#attend_dialer_box').css({'display': 'block'}); 
            sessionStorage.setItem('avaya_dialer_popup',0);
                
        }else if($event_data.action == 'open_attend_call'){
            
            $("#attend_dialer_box #attend_call_btn").click();
            sessionStorage.setItem('avaya_dialer_popup',1);
            
        }else if($event_data.action == 'hide_dialer'){
            
            $('#attend_dialer_box').css({'display': 'none'});
            $('#attend_dialer_box .dial_no_box input').val('');
            $('#attend_dialer_box .click-xhttp-request').attr('data-qr','');
            sessionStorage.setItem('avaya_dialer_popup',0);
            
        }

    };
    
    $incoming_call_event_source.onerror = function(err) {
        console.error("EventSource failed:", err);
    };
    
}
function facility_details(ft) {



       // if (ft['id'] == 0) {

           // $("#add_button_hp").click();

      //  } else {



            xhttprequest($(this), base_url + 'inc/get_facility_details', 'hp_id=' + ft['id']);

    //    }



    }
   
    function load_auto_ward(ft) {
        xhttprequest($(this), base_url + 'auto/auto_ward', 'dst_code=' + ft['id'] );
       
    }
function stop_incoming_call_event(){
    console.log('Connection closed');
    $('#attend_dialer_box').css({'display': 'none'});
    $incoming_call_event_source.close();
    var $avaya_agentid = sessionStorage.getItem('avaya_agentid');
    $.get(base_url+'calls/avaya_end_incoming_calls_event',{'agentid':$avaya_agentid});
}

function quality_filter_report(ft) {
  //  alert(ft);
    var $shiftmanger=   ft['id'];;
    xhttprequest($(this), base_url + 'quality_forms/quality_filter_report', 'output_position=content&clg_ref_id=' + $shiftmanager);
}
function single_ambulance_load(){
    var $amb_id = $("#amb_id").val();
    xhttprequest($(this), base_url + 'amb/load_single_amb', 'output_position=content&amb_id=' + $amb_id);
    
}
function single_ambulance_load_dash(){
    var $amb_id = $("#ambulance_id").val();
    // console.log($amb_id);
    xhttprequest($(this), base_url + 'dashboard/load_single_amb_dash', 'output_position=content&amb_id=' + $amb_id);
}
function ambulance_typewise_load(){
    var $amb_type = $("#amb_type").val();
    xhttprequest($(this), base_url + 'dashboard/load_ambulance_typewise', 'output_position=content&amb_type=' + $amb_type);
}
function amb_typewise_load(){
    var $amb_id = $("#amb_id").val();
   
      var $amb_district = $("#amb_district").val();
   if($amb_id=='single_amb')
   {
        var z = document.getElementById("single_amb");
        z.style.display = "block";
   }
   else{
    xhttprequest($(this), base_url + 'dashboard/load_amb_typewise', 'output_position=content&amb_id=' + $amb_id+'&amb_district=' + $amb_district);
   }
   
    
    
}
function show_other_offroad_standard_remark(ft){

    var $standard_remark_id = ft['id'];

    if ($standard_remark_id == '27') {
        $('#show_other_offroad_standard_remark').removeClass('hide');
    } else {
        $('#show_other_offroad_standard_remark').addClass('hide');
    }

}
function show_onroad_standard_remark_other(ft){

}

function show_onroad_standard(ft){
    var $standard_remark_id = ft['id'];
         console.log($standard_remark_id);
    if ($standard_remark_id == '28') {
        $('#resolve_issue_block').removeClass('hide');
        $('#show_onroad_standard_remark_other').addClass('hide');
        $('#pending_block').addClass('hide');
    }else if($standard_remark_id == '29'){
        $('#show_onroad_standard_remark_other').addClass('hide');
        $('#pending_block').removeClass('hide');
        $('#resolve_issue_block').addClass('hide');
    }else if($standard_remark_id == '30') {
        $('#resolve_issue_block').addClass('hide');
         $('#pending_block').addClass('hide');
        $('#show_onroad_standard_remark_other').removeClass('hide');
    }else{
            $('#resolve_issue_block').addClass('hide');
         $('#pending_block').addClass('hide');
        $('#show_onroad_standard_remark_other').addClass('hide');
    }
}
function show_pending_Reason(){
    var pending_Reason = $("#pending_Reason").val();
    if (pending_Reason == '1') {
        $('#Required_Spare_from_HQ_block').removeClass('hide');
        $('#System_send_to_HQ_for_further_repair_block').addClass('hide');
        $('#Inverter_Issue_block').addClass('hide');
    }else if(pending_Reason == '2'){
        $('#Required_Spare_from_HQ_block').addClass('hide');
        $('#System_send_to_HQ_for_further_repair_block').removeClass('hide');
        $('#Inverter_Issue_block').addClass('hide');
    }else if(pending_Reason == '3') {
        $('#Required_Spare_from_HQ_block').addClass('hide');
        $('#System_send_to_HQ_for_further_repair_block').addClass('hide');
        $('#Inverter_Issue_block').removeClass('hide');
    }
   
}

function recieve_avaya_call(){
    
    var $avaya_agentid = sessionStorage.getItem('avaya_agentid');
    var $last_login_ext = sessionStorage.getItem('last_login_ext');

    var $dialer_details = {"ActionID":$.now(),
    "AgentID":$avaya_agentid,
    "AgentExtension":$last_login_ext,
    "Destination" : ""};

    $.ajax({
        url: 'http://10.108.1.57:8061/pbx/callcenter/v1/autopickupphone',
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        success: function (data) {
            //console.log(data);
        },
        data: JSON.stringify($dialer_details),
        crossDomain: true
    });

   
    
}

$(document).ready(function() {
    

if (window.File && window.FileList && window.FileReader) {

$("#rerequest_reset_img").on("change", function(e) {
    //alert();
  var files = e.target.files,
    filesLength = files.length;
  for (var i = 0; i < filesLength; i++) {
    var f = files[i]
    var fileReader = new FileReader();
    fileReader.onload = (function(e) {
      var file = e.target;
      $("<span class=\"pip\">" +
        "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
       // "<div class=\"remove_images\"></div>" +
        "</span>").insertAfter("#rerequest_reset_img");
        $("#remove_reset_img").click(function(){
        $("#rerequest_reset_img").val("");
        $("span[class=pip]").remove();
});
      $(".remove").click(function(){
        
      });
      
      
      // Old code here
      /*$("<img></img>", {
        class: "imageThumb",
        src: e.target.result,
        title: file.name + " | Click to remove"
      }).insertAfter("#files").click(function(){$(this).remove();});*/
      
    });
    fileReader.readAsDataURL(f);
  }
});
} else {
alert("Your browser doesn't support to File API")
}    

  if (window.File && window.FileList && window.FileReader) {

    $("body").on("change",'.files_amb_photo', function(e) {
  
    var $this_obj = this;
    
    

      var files = e.target.files,
        filesLength = files.length;
      
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          
            
           $("<span class=\"pip\">" +
            "<div class=\"remove_images\"></div>" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "</span>").insertAfter($this_obj);
            
            $("#reset_img").click(function(){
                $("#files").val("");
                $("span[class=pip]").remove();
            });
            $(".remove_images").click(function(){
                  //$("#files").val());
                 $(this).parents(".upload_images_block").remove();
            });
          
          
          // Old code here
          /*$("<img></img>", {
            class: "imageThumb",
            src: e.target.result,
            title: file.name + " | Click to remove"
          }).insertAfter("#files").click(function(){$(this).remove();});*/
          
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});

jQuery(document).ready(function () {
    
    function updateTotalBed(){
        
        document.getElementById("C19_Total_Beds").value = parseInt(isNaN(parseInt($("#ICUWoVenti_Total_Beds").val())) ? 0 : parseInt($("#ICUWoVenti_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#ICUwithVenti_Total_Beds").val())) ? 0 : parseInt($("#ICUwithVenti_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#ICUwithdialysisBed_Total_Beds").val())) ? 0 : parseInt($("#ICUwithdialysisBed_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#C19Positive_Total_Beds").val())) ? 0 : parseInt($("#C19Positive_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#central_oxygen_Total_Beds").val())) ? 0 : parseInt($("#central_oxygen_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#SspectC19_Total_Beds").val())) ? 0 : parseInt($("#SspectC19_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#SspectSymptWoComorbid_Total_Beds").val())) ? 0 : parseInt($("#SspectSymptWoComorbid_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#SspectASymptWoComorbid_Total_Beds").val())) ? 0 : parseInt($("#SspectASymptWoComorbid_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#PositiveSymptWoComorbid_Total_Beds").val())) ? 0 : parseInt($("#PositiveSymptWoComorbid_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#PositiveASymptWoComorbid_Total_Beds").val())) ? 0 : parseInt($("#PositiveASymptWoComorbid_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#ASymptC19SspectwithComorbidStable_Total_Beds").val())) ? 0 : parseInt($("#ASymptC19SspectwithComorbidStable_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#SymptC19SspectwithComorbidStable_Total_Beds").val())) ? 0 : parseInt($("#SymptC19SspectwithComorbidStable_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#ASymptPositivewithComorbidStable_Total_Beds").val())) ? 0 : parseInt($("#ASymptPositivewithComorbidStable_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#SymptPositivewithComorbidStable_Total_Beds").val())) ? 0 : parseInt($("#SymptPositivewithComorbidStable_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#ASymptC19SspectwithComorbidCritical_Total_Beds").val())) ? 0 : parseInt($("#ASymptC19SspectwithComorbidCritical_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#SymptC19SspectwithComorbidCritical_Total_Beds").val())) ? 0 : parseInt($("#SymptC19SspectwithComorbidCritical_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#ASymptC19PositivewithComorbidCritical_Total_Beds").val())) ? 0 : parseInt($("#ASymptC19PositivewithComorbidCritical_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#SymptC19PositivewithComorbidCritical_Total_Beds").val())) ? 0 : parseInt($("#SymptC19PositivewithComorbidCritical_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#MorturyBeds_Total_Beds").val())) ? 0 : parseInt($("#MorturyBeds_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#Others_Total_Beds").val())) ? 0 : parseInt($("#Others_Total_Beds").val())) +
                parseInt(isNaN(parseInt($("#C19Ward_Total_Beds").val())) ? 0 : parseInt($("#C19Ward_Total_Beds").val())) ;
        //console.log($total);
    }
    
    function updateOccupied(){
        document.getElementById("C19_Occupied").value = parseInt(isNaN(parseInt($("#ICUWoVenti_Occupied").val())) ? 0 : parseInt($("#ICUWoVenti_Occupied").val())) +
                parseInt(isNaN(parseInt($("#ICUwithVenti_Occupied").val())) ? 0 : parseInt($("#ICUwithVenti_Occupied").val())) +
                parseInt(isNaN(parseInt($("#ICUwithdialysisBed_Occupied").val())) ? 0 : parseInt($("#ICUwithdialysisBed_Occupied").val())) +
                parseInt(isNaN(parseInt($("#C19Positive_Occupied").val())) ? 0 : parseInt($("#C19Positive_Occupied").val())) +
                parseInt(isNaN(parseInt($("#central_oxygen_Occupied").val())) ? 0 : parseInt($("#central_oxygen_Occupied").val())) +
                parseInt(isNaN(parseInt($("#SspectC19_Occupied").val())) ? 0 : parseInt($("#SspectC19_Occupied").val())) +
                parseInt(isNaN(parseInt($("#SspectSymptWoComorbid_Occupied").val())) ? 0 : parseInt($("#SspectSymptWoComorbid_Occupied").val())) +
                parseInt(isNaN(parseInt($("#SspectASymptWoComorbid_Occupied").val())) ? 0 : parseInt($("#SspectASymptWoComorbid_Occupied").val())) +
                parseInt(isNaN(parseInt($("#PositiveSymptWoComorbid_Occupied").val())) ? 0 : parseInt($("#PositiveSymptWoComorbid_Occupied").val())) +
                parseInt(isNaN(parseInt($("#PositiveASymptWoComorbid_Occupied").val())) ? 0 : parseInt($("#PositiveASymptWoComorbid_Occupied").val())) +
                parseInt(isNaN(parseInt($("#ASymptC19SspectwithComorbidStable_Occupied").val())) ? 0 : parseInt($("#ASymptC19SspectwithComorbidStable_Occupied").val())) +
                parseInt(isNaN(parseInt($("#SymptC19SspectwithComorbidStable_Occupied").val())) ? 0 : parseInt($("#SymptC19SspectwithComorbidStable_Occupied").val())) +
                parseInt(isNaN(parseInt($("#ASymptPositivewithComorbidStable_Occupied").val())) ? 0 : parseInt($("#ASymptPositivewithComorbidStable_Occupied").val())) +
                parseInt(isNaN(parseInt($("#SymptPositivewithComorbidStable_Occupied").val())) ? 0 : parseInt($("#SymptPositivewithComorbidStable_Occupied").val())) +
                parseInt(isNaN(parseInt($("#ASymptC19SspectwithComorbidCritical_Occupied").val())) ? 0 : parseInt($("#ASymptC19SspectwithComorbidCritical_Occupied").val())) +
                parseInt(isNaN(parseInt($("#SymptC19SspectwithComorbidCritical_Occupied").val())) ? 0 : parseInt($("#SymptC19SspectwithComorbidCritical_Occupied").val())) +
                parseInt(isNaN(parseInt($("#ASymptC19PositivewithComorbidCritical_Occupied").val())) ? 0 : parseInt($("#ASymptC19PositivewithComorbidCritical_Occupied").val())) +
                parseInt(isNaN(parseInt($("#SymptC19PositivewithComorbidCritical_Occupied").val())) ? 0 : parseInt($("#SymptC19PositivewithComorbidCritical_Occupied").val())) +
                parseInt(isNaN(parseInt($("#MorturyBeds_Occupied").val())) ? 0 : parseInt($("#MorturyBeds_Occupied").val())) +
                parseInt(isNaN(parseInt($("#Others_Occupied").val())) ? 0 : parseInt($("#Others_Occupied").val())) +
                parseInt(isNaN(parseInt($("#C19Ward_Occupied").val())) ? 0 : parseInt($("#C19Ward_Occupied").val())) ;
    }
    function updateVacant(){
        document.getElementById("C19_Vacant").value = parseInt(isNaN(parseInt($("#ICUWoVenti_Vacant").val())) ? 0 : parseInt($("#ICUWoVenti_Vacant").val())) +
                parseInt(isNaN(parseInt($("#ICUwithVenti_Vacant").val())) ? 0 : parseInt($("#ICUwithVenti_Vacant").val())) +
                parseInt(isNaN(parseInt($("#ICUwithdialysisBed_Vacant").val())) ? 0 : parseInt($("#ICUwithdialysisBed_Vacant").val())) +
                parseInt(isNaN(parseInt($("#C19Positive_Vacant").val())) ? 0 : parseInt($("#C19Positive_Vacant").val())) +
                parseInt(isNaN(parseInt($("#SspectC19_Vacant").val())) ? 0 : parseInt($("#SspectC19_Vacant").val())) +
                parseInt(isNaN(parseInt($("#SspectSymptWoComorbid_Vacant").val())) ? 0 : parseInt($("#SspectSymptWoComorbid_Vacant").val())) +
                parseInt(isNaN(parseInt($("#SspectASymptWoComorbid_Vacant").val())) ? 0 : parseInt($("#SspectASymptWoComorbid_Vacant").val())) +
                parseInt(isNaN(parseInt($("#PositiveSymptWoComorbid_Vacant").val())) ? 0 : parseInt($("#PositiveSymptWoComorbid_Vacant").val())) +
                parseInt(isNaN(parseInt($("#PositiveASymptWoComorbid_Vacant").val())) ? 0 : parseInt($("#PositiveASymptWoComorbid_Vacant").val())) +
                parseInt(isNaN(parseInt($("#ASymptC19SspectwithComorbidStable_Vacant").val())) ? 0 : parseInt($("#ASymptC19SspectwithComorbidStable_Vacant").val())) +
                parseInt(isNaN(parseInt($("#SymptC19SspectwithComorbidStable_Vacant").val())) ? 0 : parseInt($("#SymptC19SspectwithComorbidStable_Vacant").val())) +
                parseInt(isNaN(parseInt($("#ASymptPositivewithComorbidStable_Vacant").val())) ? 0 : parseInt($("#ASymptPositivewithComorbidStable_Vacant").val())) +
                parseInt(isNaN(parseInt($("#SymptPositivewithComorbidStable_Vacant").val())) ? 0 : parseInt($("#SymptPositivewithComorbidStable_Vacant").val())) +
                parseInt(isNaN(parseInt($("#ASymptC19SspectwithComorbidCritical_Vacant").val())) ? 0 : parseInt($("#ASymptC19SspectwithComorbidCritical_Vacant").val())) +
                parseInt(isNaN(parseInt($("#SymptC19SspectwithComorbidCritical_Vacant").val())) ? 0 : parseInt($("#SymptC19SspectwithComorbidCritical_Vacant").val())) +
                parseInt(isNaN(parseInt($("#ASymptC19PositivewithComorbidCritical_Vacant").val())) ? 0 : parseInt($("#ASymptC19PositivewithComorbidCritical_Vacant").val())) +
                parseInt(isNaN(parseInt($("#SymptC19PositivewithComorbidCritical_Vacant").val())) ? 0 : parseInt($("#SymptC19PositivewithComorbidCritical_Vacant").val())) +
                parseInt(isNaN(parseInt($("#MorturyBeds_Vacant").val())) ? 0 : parseInt($("#MorturyBeds_Vacant").val())) +
                parseInt(isNaN(parseInt($("#Others_Vacant").val())) ? 0 : parseInt($("#Others_Vacant").val())) +
                parseInt(isNaN(parseInt($("#C19Ward_Vacant").val())) ? 0 : parseInt($("#C19Ward_Vacant").val())) ;
    }
    function updateindividusalvacant(id)
    {
          //console.log("without id : " + parseInt(isNaN($("#ICUWoVenti_Occupied").val()) ? 0 : $("#ICUWoVenti_Occupied").val()));

       //console.log("with id : "+ id + " Value : " + parseInt($("#"+id+"_Total_Beds").val()));
       //console.log("SymptC19SspectwithComorbidStable : "+parseInt($("#SymptC19SspectwithComorbidStable_Occupied").val()))
       // console.log("occuoied : "+parseInt($("#"+id+"_Occupied").val()));
        document.getElementById(id+"_Vacant").value = (parseInt(isNaN(parseInt($("#"+id+"_Total_Beds").val())) ? 0 : parseInt($("#"+id+"_Total_Beds").val()))) -
        (parseInt(isNaN(parseInt($("#"+id+"_Occupied").val())) ? 0 : parseInt($("#"+id+"_Occupied").val())))
    }

    function updateTotalVacant(){
        document.getElementById("C19_Vacant").value = (parseInt(isNaN(parseInt($("#C19_Total_Beds").val())) ? 0 : parseInt($("#C19_Total_Beds").val()))) -
        (parseInt(isNaN(parseInt($("#C19_Occupied").val())) ? 0 : parseInt($("#C19_Occupied").val())));
     }
    function updateTotalBedVacant(id){
       document.getElementById(id+"_Occupied").value = "0";
   }

    jQuery('body').on("blur", "#ICUWoVenti_Total_Beds",  function(){
        updateTotalBedVacant('ICUWoVenti');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('ICUWoVenti');
         
    });
    jQuery('body').on("blur", "#ICUwithVenti_Total_Beds", function () {
        updateTotalBedVacant('ICUwithVenti');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('ICUwithVenti');
    });
    jQuery('body').on("blur", "#ICUwithdialysisBed_Total_Beds", function () {
        updateTotalBedVacant('ICUwithdialysisBed');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('ICUwithdialysisBed');
    });
    jQuery('body').on("blur", "#C19Positive_Total_Beds", function () {
        updateTotalBedVacant('C19Positive');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('C19Positive');
    });
    jQuery('body').on("blur", "#central_oxygen_Total_Beds", function () {
        updateTotalBedVacant('central_oxygen');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('central_oxygen');
    });
    jQuery('body').on("blur", "#SspectC19_Total_Beds", function () {
        updateTotalBedVacant('SspectC19');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('SspectC19');
    });
    jQuery('body').on("blur", "#SspectSymptWoComorbid_Total_Beds", function () {
        updateTotalBedVacant('SspectSymptWoComorbid');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('SspectSymptWoComorbid');
    });
    jQuery('body').on("blur", "#SspectASymptWoComorbid_Total_Beds", function () {
        updateTotalBedVacant('SspectASymptWoComorbid');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('SspectASymptWoComorbid');
    });
    jQuery('body').on("blur", "#PositiveSymptWoComorbid_Total_Beds", function () {
        updateTotalBedVacant('PositiveSymptWoComorbid');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('PositiveSymptWoComorbid');
    });
    jQuery('body').on("blur", "#PositiveASymptWoComorbid_Total_Beds", function () {
        updateTotalBedVacant('PositiveASymptWoComorbid');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('PositiveASymptWoComorbid');
    });
    jQuery('body').on("blur", "#ASymptC19SspectwithComorbidStable_Total_Beds", function () {
        updateTotalBedVacant('ASymptC19SspectwithComorbidStable');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('ASymptC19SspectwithComorbidStable');
    });
                              //  SymptC19SspectwithComorbidStable_Occupied
    jQuery('body').on("blur", "#SymptC19SspectwithComorbidStable_Total_Beds", function () {
        updateTotalBedVacant('SymptC19SspectwithComorbidStable');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('SymptC19SspectwithComorbidStable');
    });
    jQuery('body').on("blur", "#ASymptPositivewithComorbidStable_Total_Beds", function () {
        updateTotalBedVacant('ASymptPositivewithComorbidStable');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('ASymptPositivewithComorbidStable');
    });
    jQuery('body').on("blur", "#SymptPositivewithComorbidStable_Total_Beds", function () {
        updateTotalBedVacant('SymptPositivewithComorbidStable');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('SymptPositivewithComorbidStable');
    });
    jQuery('body').on("blur", "#ASymptC19SspectwithComorbidCritical_Total_Beds", function () {
        updateTotalBedVacant('ASymptC19SspectwithComorbidCritical');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('ASymptC19SspectwithComorbidCritical');
    });
    jQuery('body').on("blur", "#SymptC19SspectwithComorbidCritical_Total_Beds", function () {
        updateTotalBedVacant('SymptC19SspectwithComorbidCritical');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('SymptC19SspectwithComorbidCritical');
    });
    jQuery('body').on("blur", "#ASymptC19PositivewithComorbidCritical_Total_Beds", function () {
        updateTotalBedVacant('ASymptC19PositivewithComorbidCritical');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('ASymptC19PositivewithComorbidCritical');
    });
    jQuery('body').on("blur", "#SymptC19PositivewithComorbidCritical_Total_Beds", function () {
        updateTotalBedVacant('SymptC19PositivewithComorbidCritical');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('SymptC19PositivewithComorbidCritical');
    });
    jQuery('body').on("blur", "#MorturyBeds_Total_Beds", function () {
        updateTotalBedVacant('MorturyBeds');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('MorturyBeds');
    });
    jQuery('body').on("blur", "#Others_Total_Beds", function () {
        updateTotalBedVacant('Others');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('#Others');
    });
    jQuery('body').on("blur", "#C19Ward_Total_Beds", function () {
        updateTotalBedVacant('C19Ward');
        updateTotalBed();
        updateTotalVacant();
        updateindividusalvacant('C19Ward');
    });

    // Occupied
    jQuery('body').on("blur", "#ICUWoVenti_Occupied",  function(){
        updateOccupied();
        updateTotalVacant();
        updateindividusalvacant('ICUWoVenti');
    });
   jQuery('body').on("blur", "#ICUwithVenti_Occupied", function () {
    updateOccupied();
    updateTotalVacant();
    updateindividusalvacant('ICUwithVenti');
   });
   jQuery('body').on("blur", "#ICUwithdialysisBed_Occupied", function () {
       console.log('hii');
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('ICUwithdialysisBed');
   });
   jQuery('body').on("blur", "#C19Positive_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('C19Positive');
   });
   jQuery('body').on("blur", "#central_oxygen_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('central_oxygen');
   });
   jQuery('body').on("blur", "#SspectC19_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('SspectC19');
   });
   jQuery('body').on("blur", "#SspectSymptWoComorbid_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('SspectSymptWoComorbid');
   });
   jQuery('body').on("blur", "#SspectASymptWoComorbid_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('SspectASymptWoComorbid');
   });
   jQuery('body').on("blur", "#PositiveSymptWoComorbid_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('PositiveSymptWoComorbid');
   });
   jQuery('body').on("blur", "#PositiveASymptWoComorbid_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('PositiveASymptWoComorbid');
   });
   jQuery('body').on("blur", "#ASymptC19SspectwithComorbidStable_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('ASymptC19SspectwithComorbidStable');
   });
                               //SymptC19SspectwithComorbidStable_Occupied
   jQuery('body').on("blur", "#SymptC19SspectwithComorbidStable_Occupied", function () {
       console.log('hii1111111');
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('SymptC19SspectwithComorbidStable');
    //updateTotalVacant();
   });
   jQuery('body').on("blur", "#ASymptPositivewithComorbidStable_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('ASymptPositivewithComorbidStable');
   });
   jQuery('body').on("blur", "#SymptPositivewithComorbidStable_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('SymptPositivewithComorbidStable');
   });
   jQuery('body').on("blur", "#ASymptC19SspectwithComorbidCritical_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('ASymptC19SspectwithComorbidCritical');
   });
   jQuery('body').on("blur", "#SymptC19SspectwithComorbidCritical_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('SymptC19SspectwithComorbidCritical');
   });
   jQuery('body').on("blur", "#ASymptC19PositivewithComorbidCritical_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('ASymptC19PositivewithComorbidCritical');
   });
   jQuery('body').on("blur", "#SymptC19PositivewithComorbidCritical_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('SymptC19PositivewithComorbidCritical');
   });
   jQuery('body').on("blur", "#MorturyBeds_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('MorturyBeds');
   });
   jQuery('body').on("blur", "#Others_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('Others');
   });
   jQuery('body').on("blur", "#C19Ward_Occupied", function () {
    updateOccupied();
updateTotalVacant();
    updateindividusalvacant('C19Ward');
   });

   // Vacant
 /*  jQuery('body').on("blur", "#ICUWoVenti_Vacant",  function(){
    updateVacant();
    //updateVacant(ICUWoVenti_Vacant);
});
jQuery('body').on("blur", "#ICUwithVenti_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#ICUwithdialysisBed_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#C19Positive_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#central_oxygen_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#SspectC19_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#SspectSymptWoComorbid_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#SspectASymptWoComorbid_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#PositiveSymptWoComorbid_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#PositiveASymptWoComorbid_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#ASymptC19SspectwithComorbidStable_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#SymptC19SspectwithComorbidStable_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#ASymptPositivewithComorbidStable_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#SymptPositivewithComorbidStable_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#ASymptC19SspectwithComorbidCritical_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#SymptC19SspectwithComorbidCritical_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#ASymptC19PositivewithComorbidCritical_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#SymptC19PositivewithComorbidCritical_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#MorturyBeds_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#Others_Vacant", function () {
   updateVacant();
});
jQuery('body').on("blur", "#C19Ward_Vacant", function () {
   updateVacant();
});*/
// Non Covid validation 
//Total bed
jQuery('body').on("blur", "#NonC19ICUWoVenti_Total_Beds",  function(){
    NonC19updateTotalBedVacant('NonC19ICUWoVenti');
    NonC19updateTotalBed();
    NonC19updateTotalVacant();
    NonC19updateindividusalvacant('NonC19ICUWoVenti');
     
});
jQuery('body').on("blur", "#NonC19ICUwithVenti_Total_Beds",  function(){
    NonC19updateTotalBedVacant('NonC19ICUwithVenti');
    NonC19updateTotalBed();
    NonC19updateTotalVacant();
    NonC19updateindividusalvacant('NonC19ICUwithVenti');
     
});
jQuery('body').on("blur", "#NonC19ICUwithdialysisBed_Total_Beds",  function(){
    NonC19updateTotalBedVacant('NonC19ICUwithdialysisBed');
    updateTotalBed();
    NonC19updateTotalVacant();
    NonC19updateindividusalvacant('NonC19ICUwithdialysisBed');
     
});
jQuery('body').on("blur", "#NonC19Ward_Total_Beds",  function(){
    NonC19updateTotalBedVacant('NonC19Ward');
    NonC19updateTotalBed();
    NonC19updateTotalVacant();
    NonC19updateindividusalvacant('NonC19Ward');
     
});
//Occupied
jQuery('body').on("blur", "#NonC19ICUWoVenti_Occupied",  function(){
    NonC19updateOccupied();
    NonC19updateTotalVacant();
    NonC19updateindividusalvacant('NonC19ICUWoVenti');
});
jQuery('body').on("blur", "#NonC19ICUwithVenti_Occupied",  function(){
    NonC19updateOccupied();
    NonC19updateTotalVacant();
    NonC19updateindividusalvacant('NonC19ICUwithVenti');
});
jQuery('body').on("blur", "#NonC19ICUwithdialysisBed_Occupied",  function(){
    NonC19updateOccupied();
    NonC19updateTotalVacant();
    NonC19updateindividusalvacant('NonC19ICUwithdialysisBed');
});
jQuery('body').on("blur", "#NonC19Ward_Occupied",  function(){
    NonC19updateOccupied();
    NonC19updateTotalVacant();
    NonC19updateindividusalvacant('NonC19Ward');
});

function NonC19updateTotalBedVacant(id){
    document.getElementById(id+"_Occupied").value = "0";
}
function NonC19updateTotalBed(){
        
    document.getElementById("NonC19_Total_Beds").value = parseInt(isNaN(parseInt($("#NonC19ICUWoVenti_Total_Beds").val())) ? 0 : parseInt($("#NonC19ICUWoVenti_Total_Beds").val())) +
            parseInt(isNaN(parseInt($("#NonC19ICUwithVenti_Total_Beds").val())) ? 0 : parseInt($("#NonC19ICUwithVenti_Total_Beds").val())) +
            parseInt(isNaN(parseInt($("#NonC19ICUwithdialysisBed_Total_Beds").val())) ? 0 : parseInt($("#NonC19ICUwithdialysisBed_Total_Beds").val())) +
            parseInt(isNaN(parseInt($("#NonC19Ward_Total_Beds").val())) ? 0 : parseInt($("#NonC19Ward_Total_Beds").val()))  ;
    //console.log($total);
}
function NonC19updateTotalVacant(){
    document.getElementById("NonC19_Vacant").value = (parseInt(isNaN(parseInt($("#NonC19_Total_Beds").val())) ? 0 : parseInt($("#NonC19_Total_Beds").val()))) -
    (parseInt(isNaN(parseInt($("#NonC19_Occupied").val())) ? 0 : parseInt($("#NonC19_Occupied").val())));
 }
 function NonC19updateindividusalvacant(id)
 {
       //console.log("without id : " + parseInt(isNaN($("#ICUWoVenti_Occupied").val()) ? 0 : $("#ICUWoVenti_Occupied").val()));

    //console.log("with id : "+ id + " Value : " + parseInt($("#"+id+"_Total_Beds").val()));
    //console.log("SymptC19SspectwithComorbidStable : "+parseInt($("#SymptC19SspectwithComorbidStable_Occupied").val()))
     //console.log("occuoied : "+parseInt($("#"+id+"_Occupied").val()));
     document.getElementById(id+"_Vacant").value = (parseInt(isNaN(parseInt($("#"+id+"_Total_Beds").val())) ? 0 : parseInt($("#"+id+"_Total_Beds").val()))) -
     (parseInt(isNaN(parseInt($("#"+id+"_Occupied").val())) ? 0 : parseInt($("#"+id+"_Occupied").val())))
 }
 function NonC19updateOccupied(){
    document.getElementById("NonC19_Occupied").value = parseInt(isNaN(parseInt($("#NonC19ICUWoVenti_Occupied").val())) ? 0 : parseInt($("#NonC19ICUWoVenti_Occupied").val())) +
            parseInt(isNaN(parseInt($("#NonC19ICUwithVenti_Occupied").val())) ? 0 : parseInt($("#NonC19ICUwithVenti_Occupied").val())) +
            parseInt(isNaN(parseInt($("#NonC19ICUwithdialysisBed_Occupied").val())) ? 0 : parseInt($("#NonC19ICUwithdialysisBed_Occupied").val())) +
            parseInt(isNaN(parseInt($("#NonC19Ward_Occupied").val())) ? 0 : parseInt($("#NonC19Ward_Occupied").val()))  ;
}


});

function maintananace_part_search(){
     var x = $("#maintananace_part_input").val(); 
     var ud_mt_id = $("#ud_mt_id").val(); 
     
      xhttprequest($(this), base_url + 'ambulance_maintaince/load_maintananace_part_search', 'output_position=content&term=' + x+'&mt_id='+ud_mt_id);
}

function pauseOthers(ele) {
                $("audio").not(ele).each(function (index, audio) {
                    audio.pause();
                });
 }
 
function photo_notification() {
    // Get the JSON
    var x = $("#caller_no").val(); 
    xhttprequest($(this), base_url + 'calls/show_photo_notification', 'output_position=show_photo_notification&caller_no='+x);
}
function police_cheif_complaint_filter(){
    var $police_chief_comp =  $('#standard_remark').parent().find('input').val();
   

    if($police_chief_comp == '19' || $police_chief_comp == '9' || $police_chief_comp == '17' || $police_chief_comp == '8' || $police_chief_comp == '12' || $police_chief_comp == '11' || $police_chief_comp == '14'){
        console.log($police_chief_comp);
        $('#pc_assign_time').addClass('filter_required');
        $('#incient_police').parent().find('input').addClass('filter_required');
        $('#pc_mobile_no').addClass('filter_required');
        $('#service').addClass('filter_required');
        

         
    }else{
          console.log($police_chief_comp);
        $('#pc_assign_time').removeClass('filter_required');
        $('#incient_police').parent().find('input').removeClass('filter_required');
        $('#pc_mobile_no').removeClass('filter_required');
        $('#service').removeClass('filter_required');
        
        $('#pc_assign_time').removeClass('has_error');
        $('#pc_mobile_no').removeClass('has_error');
        $('#service').removeClass('has_error');
        
        $('#incient_police').parent().find('input').removeClass('has_error');
       
    }
}
 function denialamb(amb_no, amb_district, hp_name, amb_default_mobile, amb_pilot_mobile) {
        $('#amb_no').val(amb_no);
        $('#amb_district').val(amb_district);
        $('#hp_name').val(hp_name);
        $('#hp_name').html(hp_name);
        $('#amb_default_mobile').val(amb_default_mobile);
        $('#amb_pilot_mobile').val(amb_pilot_mobile);
        $('#denial_remark').addClass('filter_required');
        
       

        $("#savereason").show();
        $("#erc").hide();
        $("#prc").hide();
        $("#eqrc").hide();
        $("#trc").hide();
        $("#erc_emso").hide();
        $("#erc_pilot").hide();

        $('input:checkbox').removeAttr('checked');
        $(this).val('check all');
        $("option:selected").removeAttr("selected");

    }

function show_conv(){
    $conv_done = $('#conversation_done').val();
    if($conv_done == 'pilot'){
   
        $('#conversation_name').addClass('mi_autocomplete');
        $('#conversation_name').attr('data-href',base_url+'auto/get_all_user');
        $('#conversation_name').attr('data-qr','output_position=previous_incident_details&clg_group=UG-Pilot');
    }else if($conv_done == 'emso'){
        $('#conversation_name').addClass('mi_autocomplete');
        $('#conversation_name').attr('data-href',base_url+'auto/get_all_user');
        $('#conversation_name').attr('data-qr','output_position=previous_incident_details&clg_group=UG-EMT');
    }else{
        $ambulance_input = '<input type="type" name="conversation_name" id="conversation_name"  value="" class="width100" data-errors="{filter_required:\'Conversation Done With should not be blank!\'}">';
            
            $('#conversation_emso').html($ambulance_input);
     
    }
   
}
    
    


    $(document).ready(function() {
        $("#savereason").hide();
        $("#erc").hide();
        $("#prc").hide();
        $("#eqrc").hide();
        $("#trc").hide();
    });

    function hidepopup() {
        $("#savereason").hide();
        $('#denial_remark').removeClass('filter_required');
        $('#denial_remark').removeClass('has_error');
    }

    function showerc() {
        $("#erc").show();
        $("#erc_emso").show();
        $("#erc_pilot").hide();
        $("#prc").hide();
        $("#eqrc").hide();
        $("#trc").hide();
        //$("#erc option:selected").removeAttr("selected");

    }

    function showprc() {
        $("#erc").hide();
        $("#erc_emso").hide();
        $("#erc_pilot").show();
        $("#prc").show();
        $("#eqrc").hide();
        $("#trc").hide();
       // $("option:selected").removeAttr("selected");
    }

    function showeqrc() {
        $("#erc").hide();
        $("#erc_emso").hide();
        $("#erc_pilot").hide();
        $("#prc").hide();
        $("#eqrc").show();
        $("#trc").hide();
        //$("option:selected").removeAttr("selected");
    }

    function showtrc() {
        $("#erc").hide();
        $("#prc").hide();
        $("#erc_emso").hide();
        $("#erc_pilot").hide();
        $("#eqrc").hide();
        $("#trc").show();
        //$("option:selected").removeAttr("selected");
    }

    $(document).ready(function() {
        $(document).on('change', ".check_class", function() {
            $(".check_class").prop("checked", false);
            $(this).prop("checked", true);
        });
        
//        $(document).on('change', ".denial_block select", function() {
//           // $remark = $(this).text();
//           $remark= $(this).children("option:selected").text();
//          $('#denial_remark').val($remark);
//        });
        
        
    });
    
         function submit_denial() {
        jQuery(window).off('beforeunload');
        var amb_no = $('#amb_no').val();
        var amb_district = $('#amb_district').val();
        var hp_name = $('#hp_name').val();
        var amb_default_mobile = $('#amb_default_mobile').val();
        var amb_pilot_mobile = $('#amb_pilot_mobile').val();
        // alert(amb_pilot_mobile);

        var challenge_val = $('#checkedValue').find(':checked').val();



        //  alert(challenge_val);

        var emso_challenge = $('#emso_challenge').val();
        var pilot_challenge = $('#pilot_challenge').val();
        var equipment_challenge = $('#equipment_challenge').val();
        var tech_challenge = $('#tech_challenge').val();
        var denial_remark = $('#denial_remark').val();
        var pilot_id = $('#pilot_id').parent().find('input').val();
        var emso_id = $('#emso_id').parent().find('input').val();
        var conversation_done = $('#conversation_done_emso select').val();
        console.log(conversation_done);
        if(conversation_done == 'other'){
             var conversation_name = $('#conversation_name').val();
        }else{
             var conversation_name = $('#conversation_name').parent().find('input').val();
        }
        console.log(conversation_name);
     

        //var checked = $('#checkedValue input').find(':checked').length;
        if ( emso_challenge == '' && pilot_challenge == '' && equipment_challenge == '' && tech_challenge == '') {
            alert('Please Select Reason');
            return false;
        } else {
            $('input[type=button]').prop('disabled',true);
            $.post(base_url+'inc/save_denial_reason', {
                    amb_district,
                    amb_no,
                    hp_name,
                    amb_default_mobile,
                    amb_pilot_mobile,
                    challenge_val,
                    emso_challenge,
                    pilot_challenge,
                    equipment_challenge,
                    tech_challenge,
                    denial_remark,
                    emso_id,
                    pilot_id,
                    conversation_done,
                    conversation_name
                    
                },               
               function(data) {
                 
                     
                   if(data != ''){
                        $('#savereason').hide();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Denial Reason Submitted..!!',
                            showConfirmButton: false,
                            timer: 2000

                        });
                        $('input[type=button]').prop('disabled',false);
                    }
                }
                
            );
        }
    }
   