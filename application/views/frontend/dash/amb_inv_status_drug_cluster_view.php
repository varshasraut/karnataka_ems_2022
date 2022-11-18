<?php $CI = EMS_Controller::get_instance();?>
  

<div class="breadcrumb float_left">
        <ul>
            <li class="sms">
                <a class="click-xhttp-request" data-href="{base_url}dash" data-qr="output_position=content&amp;filters=reset">Dashboard</a>
            </li>
            <li>
                    <a class="click-xhttp-request" data-href="{base_url}dash/<?php echo $bread_title_link;?>" data-qr="output_position=content"><?php echo $bread_title;?></a>
            </li>
             <li>
                <a class="click-xhttp-request" data-href="{base_url}dash/<?php echo $bread_title_link_atc;?>" data-qr="output_position=content&atc=<?php echo $atc;?>"><?php echo $atc_name;?> ATC</a>
            </li>
            <li>
                <a class="click-xhttp-request" data-href="{base_url}dash/<?php echo $bread_title_link_po;?>" data-qr="output_position=content&atc=<?php echo $atc;?>&po=<?php echo $po;?>"><?php echo $po_name;?> PO</a>
            </li>
              <li>
                <span>Cluster</span>
            </li>

        </ul>
</div>
<br><br>
 <h2>Cluster</h2><br>
<!--<div class="filters_groups">                   

    <div class="search">

        <div class="row list_actions">


            <div class="grp_actions_width float_left">

                <div class="width30 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">From: </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="from_date" tabindex="1" class="form_input mi_calender filter_required" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly">
                    </div>
                </div>
                 <div class="width30 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">To : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="to_date" tabindex="2" class="form_input mi_calender filter_required" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" >
                    </div>
                </div>
                <div class="width30 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left"></div>
                    </div>
                    <div class="width100 float_left" style="margin-top: 16px;">
                         <input type="button" class="search_button float_left form-xhttp-request" name="" value="Search" data-href="#" data-qr="output_position=content&amp;flt=true" />
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>-->

<div class="box3">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="amb_form" id="amb_list">  
        
        <div id="dash_filters"></div>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                     <tr>                                      
                        <th nowrap rowspan="2">Sr No</th>
                        <th nowrap rowspan="2">Cluster Name</th>
                        <th nowrap colspan="2" style="text-align:center;">Unit</th>
                        <th nowrap colspan="2" style="text-align:center;">Non Unit</th>
                        
                    </tr>
                     <tr>                                      
                        <th nowrap>Minimum Quantity</th>
                        <th nowrap>Available Quantity</th>
                        <th nowrap>Minimum Quantity</th>
                        <th nowrap>Available Quantity</th>
                        
                    </tr>
                    <?php if($cluter_data){
                        foreach($cluter_data as $cluster){ ?>
                        <tr>
                            <td><?php echo $key+1;?></td>  
                            <td><a class="click-xhttp-request" data-href="{base_url}dash/<?php echo $school_link;?>" data-qr="output_position=content&atc=<?php echo $atc;?>&po=<?php echo $po;?>&cluster_id=<?php echo $cluster->cluster_id;?>"><?php echo $cluster->cluster_name;?></a></td>  
                            <td>1</td>  
                            <td></td>  
                            <td></td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                      <?php  }?>
                          <tr>

                              <td>Total</td>  
                            <td>4</td>  
                            <td></td>  
                            <td></td> 
                            <td></td>  
                            <td></td> 
                        </tr>
                        <?php
                        
                    }?>

                    
               
                    
        

                </table>

            </div>
        </form>
    </div>
</div>