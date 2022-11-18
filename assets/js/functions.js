
$(document).ready(function() {
   
  
          window.onload=display_ct();
          window.onload=chart_diaplay();
           
          
        });
          
   
   
 	function display_c(){

      var refresh=1000; // Refresh rate in milli seconds

      mytime=setTimeout('display_ct()',refresh)

      }

      function display_ct() {

      var x = new Date()

      var x1=x.toLocaleString();// changing the display to Local time string

      document.getElementById('ct').innerHTML = x1;

      tt=display_c();

       }
       
  function ajaxcall() { 
  
         $.ajax({

         type: 'GET',

         data: 'id=ss',

         cache: false,

         dataType: 'json',

         url: base_url+'Dashboard/view',

         success: function(result){
            //alert(result);
            
            $("#total_calls_td").text(result.total_calls_td);
            $("#total_calls_tm").text(result.total_calls_tm);
            $("#total_calls_to").text(result.total_calls_to);

            $("#eme_calls_td").text(result.eme_calls_td);
            $("#eme_calls_tm").text(result.eme_calls_tm);
            $("#eme_calls_to").text(result.eme_calls_to);
            $("#non_eme_td").text(result.non_eme_td);
            $("#non_eme_tm").text(result.non_eme_tm);
            $("#non_eme_to").text(result.non_eme_to);

            $("#available_agents").text(result.available_agents);
            $("#oncall_agents").text(result.oncall_agents);
            $("#break_agents").text(result.break_agents);

            $("#total_calls_this_month").html(result.total_calls_this_month);

            $("#total_calls_today").text(result.total_calls_today);

            $("#total_calls_today_108").text(result.total_calls_today_108);

            $("#total_calls_today_102").text(result.total_calls_today_102);

            $("#total_calls_to_108").text(result.total_calls_to_108);

            $("#total_calls_to_102").text(result.total_calls_to_102);

            $("#total_calls_tm_108").text(result.total_calls_tm_108);

            $("#total_calls_tm_102").text(result.total_calls_tm_102);

            $("#total_calls_emps_td").text(result.total_calls_emps_td);

            $("#total_calls_emps_td_108").text(result.total_calls_emps_td_108);

            $("#total_calls_emps_td_102").text(result.total_calls_emps_td_102);

            $("#total_calls_emps_tm").text(result.total_calls_emps_tm);

            $("#total_calls_emps_tm_108").text(result.total_calls_emps_tm_108);

            $("#total_calls_emps_tm_102").text(result.total_calls_emps_tm_102);

            $("#total_calls_emps_to").text(result.total_calls_emps_to);

            $("#total_calls_emps_to_108").text(result.total_calls_emps_to_108);

            $("#total_calls_emps_to_102").text(result.total_calls_emps_to_102);

            $("#total_calls_handled").text(result.total_calls_handled);
            
            $("#total_dispatch_all").text(result.total_dispatch_all);

            $("#total_dispatch_tm").text(result.total_dispatch_tm);

            $("#total_dispatch_108").text(result.total_dispatch_108);

            $("#total_dispatch_102").text(result.total_dispatch_102);

            $("#agents_available").text(result.agents_available);

            $("#agents_available_108").text(result.agents_available_108);

            $("#agents_available_102").text(result.agents_available_102);

           // $("#onRoad_ambulace").text(result.onRoad_ambulace);

           // $("#offRoad_ambulace").html(result.offRoad_ambulace);

            $("#eme_calls").html(result.eme_calls);

            $("#non_eme_calls").text(result.non_eme_calls);

            $("#total_closed_call_108").text(result.closed_calls_108);

            $("#total_closed_call_102").text(result.closed_calls_102);

            $("#total_calls_108").text(result.total_calls_108);

            $("#total_calls_102").text(result.total_calls_102);

            $("#all_amb").text(result.all_amb);
            
            $("#avail_amb").text(result.avail_amb);
            
            $("#busy_amb").text(result.busy_amb);

            //current login agents
            $("#ero").text(result.ero);
            $("#dco").text(result.dco);
            $("#pda").text(result.pda);
            $("#fda").text(result.fda);
            $("#ercp").text(result.ercp);
            $("#grievance").text(result.grievance);
            $("#feedback").text(result.feedback);
            $("#ero_tl").text(result.ero_tl);
            $("#dco_tl").text(result.dco_tl);
            $("#pda_tl").text(result.pda_tl);
            $("#fda_tl").text(result.fda_tl);
            $("#ercp_tl").text(result.ercp_tl);
            $("#grievance_tl").text(result.grievance_tl);
            $("#feedback_tl").text(result.feedback_tl);
            $("#sm").text(result.sm);
            $("#qualty").text(result.qualty);
            $("#qualty_tl").text(result.qualty_tl);
            $("#helpdesk").text(result.helpdesk);
            $("#superadmin").text(result.superadmin);
            $("#operation_hr").text(result.operation_hr);
      

         }
         
         
         });
         
         }
     
         function nhm_dispatch() { 
  
            $.ajax({
   
            type: 'POST',
   
            data: 'id=ss',
   
            cache: false,
   
            dataType: 'json',
   
            url: base_url+'Dashboard/nhm_data/',
   
            success: function(data){
               $('#nhm108').html('<tr></tr>');
               $('#nhm102').html('<tr></tr>');
               var dispatch_today_108_total = 0;
               var patient_served_tm_total = 0;
               var patient_served_td_total = 0;

               var dispatch_today_102_total = 0;
               var dispatch_tm_total = 0;
               var dispatch_td_total = 0;
            for (var i = 0; i < 22; i ++) {
               //alert(data[i].dst_name);
                  var row = '<tr>'+
                  '<td>'+data[i].dst_name+'</td>'+
                  '<td>'+data[i].dispatch_today_108+'</td>'+
                  '<td>'+data[i].patient_served_tm+'</td>'+
                  '<td>'+data[i].patient_served_td+'</td>'+
                  '</tr>';
                   
                  var dispatch_today_108_total = parseInt(dispatch_today_108_total) + parseInt(data[i].dispatch_today_108);
                  var patient_served_tm_total = parseInt(patient_served_tm_total) + parseInt(data[i].patient_served_tm);
                  var patient_served_td_total = parseInt(patient_served_td_total) + parseInt(data[i].patient_served_td);

                  var row1 = '<tr>'+
                  '<td><b>Total</b></td>'+
                  '<td><b>'+dispatch_today_108_total+'</td>'+
                  '<td><b>'+patient_served_tm_total+'</td>'+
                  '<td><b>'+patient_served_td_total+'</b></td>'+
                  '</tr>';

                  $("#nhm108 tr:last").after(row);
                  }
                  $("#nhm108 tr:last").after(row1);
                  //alert (temp);
                  for (var i = 0; i < 22; i ++) {
               //alert(data[i].dst_name);
                  var row = '<tr >'+
                  '<td>'+data[i].dst_name+'</td>'+
                  '<td>'+data[i].dispatch_today_102+'</td>'+
                  '<td>'+data[i].dispatch_tm+'</td>'+
                  '<td>'+data[i].dispatch_td+'</td>'+
                  '</tr>';

                  var dispatch_today_102_total = parseInt(dispatch_today_102_total) + parseInt(data[i].dispatch_today_102);
                  var dispatch_tm_total = parseInt(dispatch_tm_total) + parseInt(data[i].dispatch_tm);
                  var dispatch_td_total = parseInt(dispatch_td_total) + parseInt(data[i].dispatch_td);

                  var row1 = '<tr>'+
                  '<td><b>Total</b></td>'+
                  '<td><b>'+dispatch_today_102_total+'</td>'+
                  '<td><b>'+dispatch_tm_total+'</td>'+
                  '<td><b>'+dispatch_td_total+'</b></td>'+
                  '</tr>';
                  $("#nhm102 tr:last").after(row);
                  }    
                  $("#nhm102 tr:last").after(row1);
             /// });
               //console.log(row);
               
                  //alert(data[index].dst_name);
                  //alert(data[index].TEST2);
              

               //108
            //    $("#to108").text(result.temp_to_1);
            //    $("#tm108").text(result.temp_tm_1);
            //    $("#td108").text(result.temp_td_1);
            //    //102
            //    $("#to102").text(result.cnt_td_1);
            //    $("#tm102").text(result.cnt_tm_1);
            //    $("#td102").text(result.cnt_td_1);
            //   //108 dispatch today
            //    $("#Anantnag").text(result.disto.Anantnag.to);
            //    $("#Budgam").text(result.disto.Budgam.to);
            //    $("#Bandipora").text(result.disto.Bandipora.to);
            //    $("#Baramulla").text(result.disto.Baramulla.to);
            //    $("#Doda").text(result.disto.Doda.to);
            //    $("#Ganderbal").text(result.disto.Ganderbal.to);
            //    $("#Jammu").text(result.disto.Jammu.to);
            //    $("#Kargil").text(result.disto.Kargil.to);
            //    $("#Kathua").text(result.disto.Kathua.to);
            //    $("#Kishtwar").text(result.disto.Kishtwar.to);
            //    $("#Kulgam").text(result.disto.Kulgam.to);
            //    $("#Kupwara").text(result.disto.Kupwara.to);
            //    $("#Leh").text(result.disto.Leh.to);
            //    $("#Pulwama").text(result.disto.Pulwama.to);
            //    $("#Poonch").text(result.disto.Poonch.to);
            //    $("#Rajouri").text(result.disto.Rajouri.to);
            //    $("#Ramban").text(result.disto.Ramban.to);
            //    $("#Reasi").text(result.disto.Reasi.to);
            //    $("#Samba").text(result.disto.Samba.to);
            //    $("#Shopian").text(result.disto.Shopian.to);
            //    $("#Srinagar").text(result.disto.Srinagar.to);
            //    $("#Udhampur").text(result.disto.Udhampur.to);
            //    //102 dispatch today
            //    $("#102Anantnag").text(result.disto102.Anantnag.to);
            //    $("#102Budgam").text(result.disto102.Budgam.to);
            //    $("#102Bandipora").text(result.disto102.Bandipora.to);
            //    $("#102Baramulla").text(result.disto102.Baramulla.to);
            //    $("#102Doda").text(result.disto102.Doda.to);
            //    $("#102Ganderbal").text(result.disto102.Ganderbal.to);
            //    $("#102Jammu").text(result.disto102.Jammu.to);
            //    $("#102Kargil").text(result.disto102.Kargil.to);
            //    $("#102Kathua").text(result.disto102.Kathua.to);
            //    $("#102Kishtwar").text(result.disto102.Kishtwar.to);
            //    $("#102Kulgam").text(result.disto102.Kulgam.to);
            //    $("#102Kupwara").text(result.disto102.Kupwara.to);
            //    $("#102Leh").text(result.disto102.Leh.to);
            //    $("#102Pulwama").text(result.disto102.Pulwama.to);
            //    $("#102Poonch").text(result.disto102.Poonch.to);
            //    $("#102Rajouri").text(result.disto102.Rajouri.to);
            //    $("#102Ramban").text(result.disto102.Ramban.to);
            //    $("#102Reasi").text(result.disto102.Reasi.to);
            //    $("#102Samba").text(result.disto102.Samba.to);
            //    $("#102Shopian").text(result.disto102.Shopian.to);
            //    $("#102Srinagar").text(result.disto102.Srinagar.to);
            //    $("#102Udhampur").text(result.disto102.Udhampur.to);
            //    //102 dispatch this month
            //    $("#distmAnantnag").text(result.distm.Anantnag.tm);
            //    $("#distmBudgam").text(result.distm.Budgam.tm);
            //    $("#distmBandipora").text(result.distm.Bandipora.tm);
            //    $("#distmBaramulla").text(result.distm.Baramulla.tm);
            //    $("#distmDoda").text(result.distm.Doda.tm);
            //    $("#distmGanderbal").text(result.distm.Ganderbal.tm);
            //    $("#distmJammu").text(result.distm.Jammu.tm);
            //    $("#distmKargil").text(result.distm.Kargil.tm);
            //    $("#distmKathua").text(result.distm.Kathua.tm);
            //    $("#distmKishtwar").text(result.distm.Kishtwar.tm);
            //    $("#distmKulgam").text(result.distm.Kulgam.tm);
            //    $("#distmKupwara").text(result.distm.Kupwara.tm);
            //    $("#distmLeh").text(result.distm.Leh.tm);
            //    $("#distmPulwama").text(result.distm.Pulwama.tm);
            //    $("#distmPoonch").text(result.distm.Poonch.tm);
            //    $("#distmRajouri").text(result.distm.Rajouri.tm);
            //    $("#distmRamban").text(result.distm.Ramban.tm);
            //    $("#distmReasi").text(result.distm.Reasi.tm);
            //    $("#distmSamba").text(result.distm.Samba.tm);
            //    $("#distmShopian").text(result.distm.Shopian.tm);
            //    $("#distmSrinagar").text(result.distm.Srinagar.tm);
            //    $("#distmUdhampur").text(result.distm.Udhampur.tm);
            //    //102 dispatch tilldate
            //    $("#distdAnantnag").text(result.distd.Anantnag.tm);
            //    $("#distdBudgam").text(result.distd.Budgam.tm);
            //    $("#distdBandipora").text(result.distd.Bandipora.tm);
            //    $("#distdBaramulla").text(result.distd.Baramulla.tm);
            //    $("#distdDoda").text(result.distd.Doda.tm);
            //    $("#distdGanderbal").text(result.distd.Ganderbal.tm);
            //    $("#distdJammu").text(result.distd.Jammu.tm);
            //    $("#distdKargil").text(result.distd.Kargil.tm);
            //    $("#distdKathua").text(result.distd.Kathua.tm);
            //    $("#distdKishtwar").text(result.distd.Kishtwar.tm);
            //    $("#distdKulgam").text(result.distd.Kulgam.tm);
            //    $("#distdKupwara").text(result.distd.Kupwara.tm);
            //    $("#distdLeh").text(result.distd.Leh.tm);
            //    $("#distdPulwama").text(result.distd.Pulwama.tm);
            //    $("#distdPoonch").text(result.distd.Poonch.tm);
            //    $("#distdRajouri").text(result.distd.Rajouri.tm);
            //    $("#distdRamban").text(result.distd.Ramban.tm);
            //    $("#distdReasi").text(result.distd.Reasi.tm);
            //    $("#distdSamba").text(result.distd.Samba.tm);
            //    $("#distdShopian").text(result.distd.Shopian.tm);
            //    $("#distdSrinagar").text(result.distd.Srinagar.tm);
            //    $("#distdUdhampur").text(result.distd.Udhampur.tm);
            //    //108 patients served this month
            //    $("#distmptAnantnag").text(result.distmpt.Anantnag.tm);
            //    $("#distmptBudgam").text(result.distmpt.Budgam.tm);
            //    $("#distmptBandipora").text(result.distmpt.Bandipora.tm);
            //    $("#distmptBaramulla").text(result.distmpt.Baramulla.tm);
            //    $("#distmptDoda").text(result.distmpt.Doda.tm);
            //    $("#distmptGanderbal").text(result.distmpt.Ganderbal.tm);
            //    $("#distmptJammu").text(result.distmpt.Jammu.tm);
            //    $("#distmptKargil").text(result.distmpt.Kargil.tm);
            //    $("#distmptKathua").text(result.distmpt.Kathua.tm);
            //    $("#distmptKishtwar").text(result.distmpt.Kishtwar.tm);
            //    $("#distmptKulgam").text(result.distmpt.Kulgam.tm);
            //    $("#distmptKupwara").text(result.distmpt.Kupwara.tm);
            //    $("#distmptLeh").text(result.distmpt.Leh.tm);
            //    $("#distmptPulwama").text(result.distmpt.Pulwama.tm);
            //    $("#distmptPoonch").text(result.distmpt.Poonch.tm);
            //    $("#distmptRajouri").text(result.distmpt.Rajouri.tm);
            //    $("#distmptRamban").text(result.distmpt.Ramban.tm);
            //    $("#distmptReasi").text(result.distmpt.Reasi.tm);
            //    $("#distmptSamba").text(result.distmpt.Samba.tm);
            //    $("#distmptShopian").text(result.distmpt.Shopian.tm);
            //    $("#distmptSrinagar").text(result.distmpt.Srinagar.tm);
            //    $("#distmptUdhampur").text(result.distmpt.Udhampur.tm);
            //    //108 patients served tilldate
            //    $("#distdptAnantnag").text(result.distdpt.Anantnag.tm);
            //    $("#distdptBudgam").text(result.distdpt.Budgam.tm);
            //    $("#distdptBandipora").text(result.distdpt.Bandipora.tm);
            //    $("#distdptBaramulla").text(result.distdpt.Baramulla.tm);
            //    $("#distdptDoda").text(result.distdpt.Doda.tm);
            //    $("#distdptGanderbal").text(result.distdpt.Ganderbal.tm);
            //    $("#distdptJammu").text(result.distdpt.Jammu.tm);
            //    $("#distdptKargil").text(result.distdpt.Kargil.tm);
            //    $("#distdptKathua").text(result.distdpt.Kathua.tm);
            //    $("#distdptKishtwar").text(result.distdpt.Kishtwar.tm);
            //    $("#distdptKulgam").text(result.distdpt.Kulgam.tm);
            //    $("#distdptKupwara").text(result.distdpt.Kupwara.tm);
            //    $("#distdptLeh").text(result.distdpt.Leh.tm);
            //    $("#distdptPulwama").text(result.distdpt.Pulwama.tm);
            //    $("#distdptPoonch").text(result.distdpt.Poonch.tm);
            //    $("#distdptRajouri").text(result.distdpt.Rajouri.tm);
            //    $("#distdptRamban").text(result.distdpt.Ramban.tm);
            //    $("#distdptReasi").text(result.distdpt.Reasi.tm);
            //    $("#distdptSamba").text(result.distdpt.Samba.tm);
            //    $("#distdptShopian").text(result.distdpt.Shopian.tm);
            //    $("#distdptSrinagar").text(result.distdpt.Srinagar.tm);
            //    $("#distdptUdhampur").text(result.distdpt.Udhampur.tm);
               
            }
            
            
            });
            
            }
         function ajaxcall_nhm() { 
  
            $.ajax({
   
            type: 'POST',
   
            data: 'id=ss',
   
            cache: false,
   
            dataType: 'json',
   
            url: base_url+'Dashboard/nhm_data/',
   
            success: function(data){
               $('#nhm108').html('<tr></tr>');
               $('#nhm102').html('<tr></tr>');
               var dispatch_today_108_total = 0;
               var patient_served_tm_total = 0;
               var patient_served_td_total = 0;

               var dispatch_today_102_total = 0;
               var dispatch_tm_total = 0;
               var dispatch_td_total = 0;
            for (var i = 0; i < 22; i ++) {
               //alert(data[i].dst_name);
                  var row = '<tr style="line-height: 6px; height: 6px;">'+
                  '<td><b>'+data[i].dst_name+'</b></td>'+
                  '<td>'+data[i].dispatch_today_108+'</td>'+
                  '<td>'+data[i].patient_served_tm+'</td>'+
                  '<td>'+data[i].patient_served_td+'</td>'+
                  '</tr>';
                   
                  var dispatch_today_108_total = parseInt(dispatch_today_108_total) + parseInt(data[i].dispatch_today_108);
                  var patient_served_tm_total = parseInt(patient_served_tm_total) + parseInt(data[i].patient_served_tm);
                  var patient_served_td_total = parseInt(patient_served_td_total) + parseInt(data[i].patient_served_td);

                  var row1 = '<tr style="line-height: 8px; height: 8px;">'+
                  '<td><b>Total</b></td>'+
                  '<td><b>'+dispatch_today_108_total+'</td>'+
                  '<td><b>'+patient_served_tm_total+'</td>'+
                  '<td><b>'+patient_served_td_total+'</b></td>'+
                  '</tr>';

                  $("#nhm108 tr:last").after(row);
                  }
                  $("#nhm108 tr:last").after(row1);
                  //alert (temp);
                  for (var i = 0; i < 22; i ++) {
               //alert(data[i].dst_name);
                  var row = '<tr style="line-height: 6px; height: 6px;">'+
                  '<td><b>'+data[i].dst_name+'</b></td>'+
                  '<td>'+data[i].dispatch_today_102+'</td>'+
                  '<td>'+data[i].dispatch_tm+'</td>'+
                  '<td>'+data[i].dispatch_td+'</td>'+
                  '</tr>';

                  var dispatch_today_102_total = parseInt(dispatch_today_102_total) + parseInt(data[i].dispatch_today_102);
                  var dispatch_tm_total = parseInt(dispatch_tm_total) + parseInt(data[i].dispatch_tm);
                  var dispatch_td_total = parseInt(dispatch_td_total) + parseInt(data[i].dispatch_td);

                  var row1 = '<tr style="line-height: 8px; height: 8px; ">'+
                  '<td><b>Total</b></td>'+
                  '<td><b>'+dispatch_today_102_total+'</td>'+
                  '<td><b>'+dispatch_tm_total+'</td>'+
                  '<td><b>'+dispatch_td_total+'</b></td>'+
                  '</tr>';
                  $("#nhm102 tr:last").after(row);
                  }    
                  $("#nhm102 tr:last").after(row1);
             /// });
               //console.log(row);
               
                  //alert(data[index].dst_name);
                  //alert(data[index].TEST2);
              

               //108
            //    $("#to108").text(result.temp_to_1);
            //    $("#tm108").text(result.temp_tm_1);
            //    $("#td108").text(result.temp_td_1);
            //    //102
            //    $("#to102").text(result.cnt_td_1);
            //    $("#tm102").text(result.cnt_tm_1);
            //    $("#td102").text(result.cnt_td_1);
            //   //108 dispatch today
            //    $("#Anantnag").text(result.disto.Anantnag.to);
            //    $("#Budgam").text(result.disto.Budgam.to);
            //    $("#Bandipora").text(result.disto.Bandipora.to);
            //    $("#Baramulla").text(result.disto.Baramulla.to);
            //    $("#Doda").text(result.disto.Doda.to);
            //    $("#Ganderbal").text(result.disto.Ganderbal.to);
            //    $("#Jammu").text(result.disto.Jammu.to);
            //    $("#Kargil").text(result.disto.Kargil.to);
            //    $("#Kathua").text(result.disto.Kathua.to);
            //    $("#Kishtwar").text(result.disto.Kishtwar.to);
            //    $("#Kulgam").text(result.disto.Kulgam.to);
            //    $("#Kupwara").text(result.disto.Kupwara.to);
            //    $("#Leh").text(result.disto.Leh.to);
            //    $("#Pulwama").text(result.disto.Pulwama.to);
            //    $("#Poonch").text(result.disto.Poonch.to);
            //    $("#Rajouri").text(result.disto.Rajouri.to);
            //    $("#Ramban").text(result.disto.Ramban.to);
            //    $("#Reasi").text(result.disto.Reasi.to);
            //    $("#Samba").text(result.disto.Samba.to);
            //    $("#Shopian").text(result.disto.Shopian.to);
            //    $("#Srinagar").text(result.disto.Srinagar.to);
            //    $("#Udhampur").text(result.disto.Udhampur.to);
            //    //102 dispatch today
            //    $("#102Anantnag").text(result.disto102.Anantnag.to);
            //    $("#102Budgam").text(result.disto102.Budgam.to);
            //    $("#102Bandipora").text(result.disto102.Bandipora.to);
            //    $("#102Baramulla").text(result.disto102.Baramulla.to);
            //    $("#102Doda").text(result.disto102.Doda.to);
            //    $("#102Ganderbal").text(result.disto102.Ganderbal.to);
            //    $("#102Jammu").text(result.disto102.Jammu.to);
            //    $("#102Kargil").text(result.disto102.Kargil.to);
            //    $("#102Kathua").text(result.disto102.Kathua.to);
            //    $("#102Kishtwar").text(result.disto102.Kishtwar.to);
            //    $("#102Kulgam").text(result.disto102.Kulgam.to);
            //    $("#102Kupwara").text(result.disto102.Kupwara.to);
            //    $("#102Leh").text(result.disto102.Leh.to);
            //    $("#102Pulwama").text(result.disto102.Pulwama.to);
            //    $("#102Poonch").text(result.disto102.Poonch.to);
            //    $("#102Rajouri").text(result.disto102.Rajouri.to);
            //    $("#102Ramban").text(result.disto102.Ramban.to);
            //    $("#102Reasi").text(result.disto102.Reasi.to);
            //    $("#102Samba").text(result.disto102.Samba.to);
            //    $("#102Shopian").text(result.disto102.Shopian.to);
            //    $("#102Srinagar").text(result.disto102.Srinagar.to);
            //    $("#102Udhampur").text(result.disto102.Udhampur.to);
            //    //102 dispatch this month
            //    $("#distmAnantnag").text(result.distm.Anantnag.tm);
            //    $("#distmBudgam").text(result.distm.Budgam.tm);
            //    $("#distmBandipora").text(result.distm.Bandipora.tm);
            //    $("#distmBaramulla").text(result.distm.Baramulla.tm);
            //    $("#distmDoda").text(result.distm.Doda.tm);
            //    $("#distmGanderbal").text(result.distm.Ganderbal.tm);
            //    $("#distmJammu").text(result.distm.Jammu.tm);
            //    $("#distmKargil").text(result.distm.Kargil.tm);
            //    $("#distmKathua").text(result.distm.Kathua.tm);
            //    $("#distmKishtwar").text(result.distm.Kishtwar.tm);
            //    $("#distmKulgam").text(result.distm.Kulgam.tm);
            //    $("#distmKupwara").text(result.distm.Kupwara.tm);
            //    $("#distmLeh").text(result.distm.Leh.tm);
            //    $("#distmPulwama").text(result.distm.Pulwama.tm);
            //    $("#distmPoonch").text(result.distm.Poonch.tm);
            //    $("#distmRajouri").text(result.distm.Rajouri.tm);
            //    $("#distmRamban").text(result.distm.Ramban.tm);
            //    $("#distmReasi").text(result.distm.Reasi.tm);
            //    $("#distmSamba").text(result.distm.Samba.tm);
            //    $("#distmShopian").text(result.distm.Shopian.tm);
            //    $("#distmSrinagar").text(result.distm.Srinagar.tm);
            //    $("#distmUdhampur").text(result.distm.Udhampur.tm);
            //    //102 dispatch tilldate
            //    $("#distdAnantnag").text(result.distd.Anantnag.tm);
            //    $("#distdBudgam").text(result.distd.Budgam.tm);
            //    $("#distdBandipora").text(result.distd.Bandipora.tm);
            //    $("#distdBaramulla").text(result.distd.Baramulla.tm);
            //    $("#distdDoda").text(result.distd.Doda.tm);
            //    $("#distdGanderbal").text(result.distd.Ganderbal.tm);
            //    $("#distdJammu").text(result.distd.Jammu.tm);
            //    $("#distdKargil").text(result.distd.Kargil.tm);
            //    $("#distdKathua").text(result.distd.Kathua.tm);
            //    $("#distdKishtwar").text(result.distd.Kishtwar.tm);
            //    $("#distdKulgam").text(result.distd.Kulgam.tm);
            //    $("#distdKupwara").text(result.distd.Kupwara.tm);
            //    $("#distdLeh").text(result.distd.Leh.tm);
            //    $("#distdPulwama").text(result.distd.Pulwama.tm);
            //    $("#distdPoonch").text(result.distd.Poonch.tm);
            //    $("#distdRajouri").text(result.distd.Rajouri.tm);
            //    $("#distdRamban").text(result.distd.Ramban.tm);
            //    $("#distdReasi").text(result.distd.Reasi.tm);
            //    $("#distdSamba").text(result.distd.Samba.tm);
            //    $("#distdShopian").text(result.distd.Shopian.tm);
            //    $("#distdSrinagar").text(result.distd.Srinagar.tm);
            //    $("#distdUdhampur").text(result.distd.Udhampur.tm);
            //    //108 patients served this month
            //    $("#distmptAnantnag").text(result.distmpt.Anantnag.tm);
            //    $("#distmptBudgam").text(result.distmpt.Budgam.tm);
            //    $("#distmptBandipora").text(result.distmpt.Bandipora.tm);
            //    $("#distmptBaramulla").text(result.distmpt.Baramulla.tm);
            //    $("#distmptDoda").text(result.distmpt.Doda.tm);
            //    $("#distmptGanderbal").text(result.distmpt.Ganderbal.tm);
            //    $("#distmptJammu").text(result.distmpt.Jammu.tm);
            //    $("#distmptKargil").text(result.distmpt.Kargil.tm);
            //    $("#distmptKathua").text(result.distmpt.Kathua.tm);
            //    $("#distmptKishtwar").text(result.distmpt.Kishtwar.tm);
            //    $("#distmptKulgam").text(result.distmpt.Kulgam.tm);
            //    $("#distmptKupwara").text(result.distmpt.Kupwara.tm);
            //    $("#distmptLeh").text(result.distmpt.Leh.tm);
            //    $("#distmptPulwama").text(result.distmpt.Pulwama.tm);
            //    $("#distmptPoonch").text(result.distmpt.Poonch.tm);
            //    $("#distmptRajouri").text(result.distmpt.Rajouri.tm);
            //    $("#distmptRamban").text(result.distmpt.Ramban.tm);
            //    $("#distmptReasi").text(result.distmpt.Reasi.tm);
            //    $("#distmptSamba").text(result.distmpt.Samba.tm);
            //    $("#distmptShopian").text(result.distmpt.Shopian.tm);
            //    $("#distmptSrinagar").text(result.distmpt.Srinagar.tm);
            //    $("#distmptUdhampur").text(result.distmpt.Udhampur.tm);
            //    //108 patients served tilldate
            //    $("#distdptAnantnag").text(result.distdpt.Anantnag.tm);
            //    $("#distdptBudgam").text(result.distdpt.Budgam.tm);
            //    $("#distdptBandipora").text(result.distdpt.Bandipora.tm);
            //    $("#distdptBaramulla").text(result.distdpt.Baramulla.tm);
            //    $("#distdptDoda").text(result.distdpt.Doda.tm);
            //    $("#distdptGanderbal").text(result.distdpt.Ganderbal.tm);
            //    $("#distdptJammu").text(result.distdpt.Jammu.tm);
            //    $("#distdptKargil").text(result.distdpt.Kargil.tm);
            //    $("#distdptKathua").text(result.distdpt.Kathua.tm);
            //    $("#distdptKishtwar").text(result.distdpt.Kishtwar.tm);
            //    $("#distdptKulgam").text(result.distdpt.Kulgam.tm);
            //    $("#distdptKupwara").text(result.distdpt.Kupwara.tm);
            //    $("#distdptLeh").text(result.distdpt.Leh.tm);
            //    $("#distdptPulwama").text(result.distdpt.Pulwama.tm);
            //    $("#distdptPoonch").text(result.distdpt.Poonch.tm);
            //    $("#distdptRajouri").text(result.distdpt.Rajouri.tm);
            //    $("#distdptRamban").text(result.distdpt.Ramban.tm);
            //    $("#distdptReasi").text(result.distdpt.Reasi.tm);
            //    $("#distdptSamba").text(result.distdpt.Samba.tm);
            //    $("#distdptShopian").text(result.distdpt.Shopian.tm);
            //    $("#distdptSrinagar").text(result.distdpt.Srinagar.tm);
            //    $("#distdptUdhampur").text(result.distdpt.Udhampur.tm);
               
            }
            
            
            });
            
            }
            
            function ajaxcall_home() { 
  
               $.ajax({
      
               type: 'POST',
      
               data: 'id=ss',
      
               cache: false,
      
               dataType: 'json',
      
               url: base_url+'Dashboard/dash_data/',
      
               success: function(data){
                  $('#nhm108').html('<tr></tr>');
                  $('#nhm102').html('<tr></tr>');
                  var dispatch_today_108_total = 0;
                  var patient_served_tm_total = 0;
                  var patient_served_td_total = 0;
   
                  var dispatch_today_102_total = 0;
                  var dispatch_tm_total = 0;
                  var dispatch_td_total = 0;
               for (var i = 0; i < 22; i ++) {
                  //alert(data[i].dst_name);
                     var row = '<tr style="color: #212529">'+
                     '<td><b>'+data[i].dst_name+'</b></td>'+
                     '<td>'+data[i].dispatch_today_108+'</td>'+
                     '<td>'+data[i].patient_served_tm+'</td>'+
                     '<td>'+data[i].patient_served_td+'</td>'+
                     '</tr>';
                      
                     var dispatch_today_108_total = parseInt(dispatch_today_108_total) + parseInt(data[i].dispatch_today_108);
                     var patient_served_tm_total = parseInt(patient_served_tm_total) + parseInt(data[i].patient_served_tm);
                     var patient_served_td_total = parseInt(patient_served_td_total) + parseInt(data[i].patient_served_td);
   
                     var row1 = '<tr style="color: #212529">'+
                     '<td><b>Total</b></td>'+
                     '<td><b>'+dispatch_today_108_total+'</td>'+
                     '<td><b>'+patient_served_tm_total+'</td>'+
                     '<td><b>'+patient_served_td_total+'</b></td>'+
                     '</tr>';
   
                     $("#nhm108 tr:last").after(row);
                     }
                     $("#nhm108 tr:last").after(row1);
                     //alert (temp);
                     for (var i = 0; i < 22; i ++) {
                  //alert(data[i].dst_name);
                     var row = '<tr style="color: #212529">'+
                     '<td><b>'+data[i].dst_name+'</b></td>'+
                     '<td>'+data[i].dispatch_today_102+'</td>'+
                     '<td>'+data[i].dispatch_tm+'</td>'+
                     '<td>'+data[i].dispatch_td+'</td>'+
                     '</tr>';
   
                     var dispatch_today_102_total = parseInt(dispatch_today_102_total) + parseInt(data[i].dispatch_today_102);
                     var dispatch_tm_total = parseInt(dispatch_tm_total) + parseInt(data[i].dispatch_tm);
                     var dispatch_td_total = parseInt(dispatch_td_total) + parseInt(data[i].dispatch_td);
   
                     var row1 = '<tr style="color: #212529 ">'+
                     '<td><b>Total</b></td>'+
                     '<td><b>'+dispatch_today_102_total+'</td>'+
                     '<td><b>'+dispatch_tm_total+'</td>'+
                     '<td><b>'+dispatch_td_total+'</b></td>'+
                     '</tr>';
                     $("#nhm102 tr:last").after(row);
                     }    
                     $("#nhm102 tr:last").after(row1);
               
               }
               
               
               });
               
               }
               

         function chart_diaplay() { 

         $.ajax({

         type: "GET",

         data: "id=testdata11",

         cache: false,

         dataType: 'json',

         url: base_url+'Dashboard/chartdata',

         success: function(res){

            Morris.Bar({

            element: 'graph',

            data: res.chart,

            xkey: 'year',

            ykeys: ['emergency_calls', 'mas_cas_calls', 'medical_advice','hosp_to_hosp','non_emergency_calls'],

            labels: ['Emergency Calls', 'Mass Casualty Calls', 'Medical Advice Calls', 'Hospital To Hospital Call', 'Non Emergency Calls']

            });

         }

         });

         }
         
