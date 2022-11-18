<?php $CI = EMS_Controller::get_instance(); ?>
<div class="head_outer"><h3 class="txt_clr2 width1">  <?php echo $report_name ?> </h3> </div>
<div class="width100">

    <form enctype="multipart/form-data" action="<?php echo base_url(); ?>erc_reports/amb_district_onroad_offroad_report" method="post" method="post">
    <?php if($clg_group != "UG-NHM"){ ?>
    <div class="width_10 drg float_left">
                <div class="width100 float_left">
                    <div class="style6 float_left">Select Zonewise : </div>
                </div>
                <div class="width100 float_left">  
                    <select name="onroad_report_type_divs" id="divs" class="change-base-xhttp-request"  data-href="{base_url}erc_reports/load_onroad_offroad_form" data-qr="output_position=content">
                    <option value="">All</option>
                        <?php foreach($zones as $dvs){ ?>  
                        <option value="<?php echo $dvs->div_code; ?>"><?php echo $dvs->div_name;?></option>
                        <?php } ?>
                    </select>
                </div>
        </div> 
        <div class="width_10 input float_left">
            <div class="width100 ">
                <div class="style6 ">Select District : </div>
            </div>
            <div class="width100 ">  
                <select name="onroad_report_type_dist" id="dist" class="change-base-xhttp-request" data-qr="output_position=content">
                <option value="">All</option>
                </select>
            </div>
        </div> 
        <?php } ?>
        <div class="width_10 float_left ">
            <div class="filed_select width100">
                <div class="width100 field_row">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Report : </div>
                    </div>
                    <div class="width100">  
                        <select name="onroad_report_type"  class="change-base-xhttp-request"  data-href="{base_url}erc_reports/load_onroad_offroad_form" data-qr="output_position=content">
                            <option value="">Select Report</option>
                            <?php if($clg_group != "UG-NHM"){ ?>
                            <option value="1">Detailed Report</option>
                            <option value="2">Final Report</option>
                            <?php } ?>
                            <option value="3">On-Road/Off-Road Report</option>
                         </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="width_50 float_left ">
            <div class="width100 field_row" id="Sub_report_block_fields">
                <div class="width100 field_row" >
               <!--  <div class="width100 float_left"  >
                </div>  -->
                </div> 
            </div>
        </div>
        <div class="width_50 float_left">
            <div class="width100 filed_select">
                <div class="width_100 field_row drg float_left" id="Sub_date_report_block_fields">
                    <!-- <div class="float_left" >  
                        
                    </div> -->
                </div>
            </div>
        </div>
        <!-- <div class="width_16 float_left" >
            <div >
            </div>
        </div>
        <div class="width50  float_left">
            <div id="Sub_date_report_block_fields" >
            </div>
        </div> -->
        
    </form>
</div>
<div class="box3">    

    <div class="permission_list group_list">
        <div id="list_table" >


        </div>
    </div>
</div>

<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
<script type="text/javascript">
    $("#divs").on('change', function postinput(){
        var dist = $(this).val(); // this.value
        // $('#dist').val('');
        $.ajax({
        url:"<?= site_url('Erc_reports/get_district_list') ?>",
        datatype:'jsonp',
        type:"POST",
        data : {'dist': dist},
        
        success: function(data){
            $('#dist').html('');
          var obj = (data);
         
        //   console.log(obj)
        //   console.log(JSON.stringify(responseData));
            html = JSON.parse(data);
            // document.getElementById("dist").setTextValue() = "";
            // console.log(html);
            var selOpts = "";
            selOpts += "<option value=''>All</option>";
            for (i=0;i<html.length;i++)
            {
                // console.log();
                var id = html[i]['dst_code'];
                var val = html[i]['dst_name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('#dist').html(selOpts);
        }
    })
    });
   
</script>