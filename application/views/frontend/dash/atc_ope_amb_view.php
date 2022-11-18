<?php $CI = EMS_Controller::get_instance();?>
  

<div class="breadcrumb float_left">
        <ul>
            <li class="sms">
                <a class="click-xhttp-request" data-href="{base_url}dash" data-qr="output_position=content&amp;filters=reset">Dashboard</a>
            </li>
            <li>
                <a class="click-xhttp-request" data-href="{base_url}dash/total_ope_amb" data-qr="output_position=content">Total Operational Ambulance</a>
            </li>
             <li>
                <span>ATC</span>
            </li>

        </ul>
</div>
<br><br>
 <h2>Total Operational Ambulance</h2><br>
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
                        <th nowrap>Sr No</th>
                        <th nowrap>ATC</th>
                        <th nowrap>Total Ambulances</th>
                        <th nowrap>Total On-road Ambulances</th>
                        <th nowrap>% On-road Ambulances</th>
                        
                    </tr>
                     <?php  foreach($atc_screening as $key=>$screning){?>
                    <tr>
                        
                        
                        <td><?php echo $key;?></td>                            
                        <td><a class="click-xhttp-request" data-href="{base_url}dash/<?php echo $atc_po_linke;?>" data-qr="output_position=content&atc=<?php echo $screning['atc_id'];?>"><?php echo $screning['atc_name'];?> ATC</a></td> 
                           <td>26</td>  
                        <td>25</td>   
                        <td>96%</td>    
                    </tr>
                    
                    <?php    
                    }
                    ?>

<!--                    <tr>
                        
                        
                        <td>1</td>                            
                        <td> <a class="click-xhttp-request" data-href="{base_url}dash/po_ope_amb" data-qr="output_position=content&atc=nashik_atc">Nashik ATC</a></td>    
                        <td>26</td>  
                        <td>25</td>   
                        <td>96%</td>   
                    </tr>
                    <tr>
                        
                        
                        <td>2</td>                            
                        <td><a class="click-xhttp-request" data-href="{base_url}dash/po_ope_amb" data-qr="output_position=content&atc=amravati_atc">Amravati ATC</a></td>    
                        <td>12</td>  
                        <td>12</td>
                        <td>100%</td>
                    </tr>
                    <tr>
                        
                        
                        <td>3</td>                            
                        <td><a class="click-xhttp-request" data-href="{base_url}dash/po_ope_amb" data-qr="output_position=content&atc=nagpur_atc">Nagpur ATC</a></td>    
                        <td>10</td>  
                        <td>9</td>  
                        <td>90%</td>  
                    </tr>-->
                    
               
                    
        

                </table>

            </div>
        </form>
    </div>
</div>