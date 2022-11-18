<?php $CI = EMS_Controller::get_instance();

//$quality_marks = array();
//$quality_marks['quality_score'] = 0;
//$quality_marks['fetal_indicator'] =0;
//$quality_count =0;
//
//if($audit_details){
//    $quality_count = count($audit_details);
//
//
//    foreach($audit_details as $quality){
//
//        $quality_marks['quality_score'] = $quality->quality_score + $quality_marks['quality_score'];
//
//        $fetal_indicator = json_decode($quality->fetal_indicator);
//        if($quality->quality_score == '0' || $quality->quality_score == 0){
//            $quality_marks['fetal_indicator'] =  $quality_marks['fetal_indicator']  + 1;
//        }
//
//        //$quality_marks['fetal_indicator'] = $quality->quality_score + $quality_marks['quality_score'];
//    }
//}
?>

<!--<h3 class="txt_clr5 width2 float_left">ERO Dashboard</h3><br>-->
        <form method="post" action="#" name="quality_forms" class="quality_forms">  

            <div id="clg_filters">

                <div class="filters_groups">                   

                    <div class="search">
                        <div class="row list_actions clg_filt">

                            <div class="search_btn_width">
                                
                                
                                <div class="filed_input float_left width_10">
                                    <select id="team_type" name="team_type"  class="" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7"  <?php echo $view; ?>>

                                        <option value="">Select Team Type</option>
                                        <option value="all">All</option>
                                        <!-- <option value="UG-ERO-102">ERO 102</option> -->
                                        <option value="UG-ERO">ERO 108</option>
                                        <!-- <option value="UG-DCO-102">DCO 102</option> -->
                                        <option value="UG-DCO">DCO 108</option>

<!--                                         <option value="ERO-102">ERO-102</option>
                                        <option value="DCO-102">DCO-102</option>-->
                                        <!-- <option value="ERCP">ERCP</option>
                                        <option value="Grieviance">GRIEVIANCE</option>
                                        <option value="FEEDBACK">FEEDBACK</option>
                                        <option value="FDA">FIRE</option>
                                        <option value="PDA">POLICE</option> -->
                                    </select>
                                </div> 
                                <div class="float_left width_20" id="ero_list_outer_qality">   
                    
                                    <select name="user_id" id="ero_list_qality">
                                    <option value="">Select ERO</option>
                                    <option value='all'>All Colleague</option>
                                    
                                    </select>
                                </div>
                                <div class="float_left width_10" >   
                    
                                    <select name="qa_id">
                                    <option value="">Select Quality</option>
                                    <option value='all'>All</option>
                                    <?php


                                                        foreach ($qa as $qa) {
                                                            echo "<option value='" . $qa->clg_ref_id . "'  ";
                                                          
                                                            echo" >" . $qa->clg_first_name." ". $qa->clg_last_name;
                                                            echo "</option>";
                                                        }
                                                        ?>
                                    </select>
                                </div>
                                <div class="width_10 drg float_left">
                                    <div class="width100 float_left">
  
                                        <input name="from_date" tabindex="1" class="form_input" placeholder="From Date" type="text" value="" readonly="readonly" id="from_date">
                                    </div>
                                </div>
                                
                            <div class="width_10 drg float_left">
                                <div class="width100 float_left">
                                
                                    <input name="to_date" tabindex="2" class="form_input" placeholder="To Date" type="text" data-base="search_btn"  value="" readonly="readonly" id="to_date">
                                </div>
                            </div>  
                            <div class="filed_input float_left width_25">  
                                  
                                  <input type="button" name="search_btn" value="Search" class="btn clg_search form-xhttp-request float_left mt-0" data-href="{base_url}quality_forms/quality_score" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" style="float:left !important;" >
                                  <input class="search_button click-xhttp-request mt-0" style="" name="" value="Reset Filters" data-href="{base_url}quality_forms/quality_score" data-qr="output_position=content&amp;filters=reset" type="button" tabindex="8" autocomplete="off">
                            </div>

                            </div>


                        </div>


                    </div>

                </div>

            </div>
        </form>
<div class="width100 margin_auto text_align_center">
    <div class="width100 float_left">
        <h3 class="txt_clr2 float_left">Quality Score</h3>
                <div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>quality_forms/quality_score_download" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="<?php echo $from_date; ?>" name="from_date">
                        <input type="hidden" value="<?php echo $to_date; ?>" name="to_date">
                        <input type="hidden" value="<?php echo $child_ero; ?>" name="user_id">
                        <input type="hidden" value="<?php echo $team_type; ?>" name="team_type">
                        <input type="hidden" value="<?php echo $qa_id; ?>" name="qa_id">
                        <input type="hidden" value="<?php echo $base_month; ?>" name="base_month">

                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>

            </div>
        </div> 
    </div>
    

    <table>
        <tr>
            <th>Sr.No</th>
            <th>ERO ID</th>
            <th>ERO Name</th>
            <th>Audit Count</th>
            <th>Quality Score</th>
            <th>Fatal Call</th>
            <th>Fatal Score</th>
        
        </tr>
        <?php 
        $counter = 0;
        if($quality_score){
        foreach($quality_score as $quality_marks){ ?>
        <?php //var_dump($quality_marks); ?>
        <tr>
            <td style="text-align: left;"><?php echo ++$counter; ?></td>
            <td style="text-align: left;"><?php 
            $clg_data = get_clg_data_by_ref_id( $quality_marks['ero_id']);
            $clg_id=ucwords(strtolower($quality_marks['ero_id']));
            echo $clg_id;
            ?></td>
            <td style="text-align: left;"> <?php 
            $clg_name = ucwords(strtolower($clg_data[0]->clg_first_name.' '.$clg_data[0]->clg_last_name));
            echo $clg_name; ?></td>
            <td style="text-align: left;"><?php echo $quality_marks['quality_call'];?></td>
            <td style="text-align: left;"><?php if($quality_marks['quality_call'] > 0){ echo number_format($quality_marks['quality_score']/$quality_marks['quality_call'],2); }else{ echo "0"; } ?>%</td>
            <td style="text-align: left;"><?php echo $quality_marks['fetal_indicator']?$quality_marks['fetal_indicator']:0;?></td>
            <td style="text-align: left;"><?php if($quality_marks['quality_call'] > 0){ $quality_percent = ($quality_marks['fetal_indicator']/$quality_marks['quality_call'])*100; echo number_format($quality_percent,2);  }else{ echo "0"; } ?>%</td>
           
        </tr>
        <?php } } else{ ?>
                <tr><td colspan="13" class="text_align_center"> No record found</td></tr> 
              <?php  }
            ?> 
    </table>
    <span><?php //echo $audit_details[0]->quality_score;?></span>
</div>
<div class="bottom_outer">

<div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php
                    if (@$data) {
                        echo $data;
                    }
                    ?>">

<div class="width38 float_right">

<div class="record_per_pg">

    <div class="per_page_box_wrapper">

        <span class="dropdown_pg_txt float_left"> Records per page : </span>

        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}quality_forms/quality_score" data-qr="output_position=content&amp;flt=true&ref_id=<?php echo $ref_id; ?>&team_type=<?php echo $team_type; ?>&to_date=<?php echo $to_date; ?>&from_date=<?php echo $from_date; ?>&pg_rec=<?php echo $pg_rec; ?>">

            <?php echo rec_perpg($pg_rec); ?>

        </select>

    </div>

    <div class="float_right">
        <span> Total records: <?php
                                if (@$total_count) {
                                    echo $total_count;
                                } else {
                                    echo "0";
                                }
                                ?> </span>
    </div>

</div>

</div>

                </div>
  <script>
    

    jQuery(document).ready(function(){  
    
    var dateFormat = "mm/dd/yy",
      from = jQuery( "#from_date" )
        .datepicker({
          defaultDate: new Date(),
          changeMonth: true,
          numberOfMonths: 2
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = jQuery( "#to_date" ).datepicker({
        defaultDate: new Date(),
        changeMonth: true,
        numberOfMonths: 2
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
      function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
      return date;
    }
    });
 

</script>