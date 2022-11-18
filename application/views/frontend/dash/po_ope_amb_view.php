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
                <a class="click-xhttp-request" data-href="{base_url}dash/ope_amb_atc" data-qr="output_position=content&atc=<?php echo $atc;?>"><?php echo $atc_name;?> ATC</a>
            </li>
              <li>
                <span>PO</span>
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
                        <th nowrap>PO Name</th>
                        <th nowrap>Total Ambulances</th>
                        <th nowrap>Total On-Road Ambulances</th>
                        <th nowrap>% On-Road Ambulances</th>
                        
                    </tr>
                    <?php if($atc == 'nashik_atc'){?>
                <tr>
                                            
                    <td><a class="click-xhttp-request" data-href="{base_url}dash/cluster_ope_amb" data-qr="output_position=content&atc=nashik_atc&po=nandurbar_po">Nandurbar PO</a></td>    
                        <td>4</td>    
                        <td>	3</td>    
                        <td>	75%</td>
                    </tr>
                    <tr>

                        <td><a class="click-xhttp-request" data-href="{base_url}dash/cluster_ope_amb" data-qr="output_position=content&atc=nashik_atc&po=taloda_po">Taloda PO</a></td>    
                        <td>	7</td>    
                        <td>	6</td>    
                        <td>	86%</td>
                    </tr>
                    <tr>

                        <td><a class="click-xhttp-request" data-href="{base_url}dash/cluster_ope_amb" data-qr="output_position=content&atc=nashik_atc&po=dhule_po">Dhule PO</a></td>    
                        <td>	3</td>    
                        <td>	3</td>    
                        <td>	100%</td>
                    </tr>
                    <tr>

                        <td><a class="click-xhttp-request" data-href="{base_url}dash/cluster_ope_amb" data-qr="output_position=content&atc=nashik_atc&po=yaval_po">Yaval PO</a></td>    
                        <td>	4</td>    
                        <td>	4</td>    
                        <td>	100%</td>
                    </tr>
                    <tr>

                        <td><a class="click-xhttp-request" data-href="{base_url}dash/cluster_ope_amb" data-qr="output_position=content&atc=nashik_atc&po=kalwan_po">Kalwan PO</a></td>    
                        <td>	5	</td>    
                        <td>5	</td>    
                        <td>100%</td>
                    </tr>
                    <tr>

                        <td><a class="click-xhttp-request" data-href="{base_url}dash/cluster_ope_amb" data-qr="output_position=content&atc=nashik_atc&po=rajur_po">Rajur PO</a></td>    
                        <td>	3</td>    
                        <td>	2</td>    
                        <td>	67%</td>
                    </tr>
                    <tr>

                        <td>Total</td>    
                        <td>	26</td>    
                        <td>	23</td>    
                        <td>	88%</td>
                    </tr>
 
                    </tr>
                    <?php } else if($atc == 'amravati_atc') { ?>
                    <tr>
                                            
                        <td><a class="click-xhttp-request" data-href="{base_url}dash/cluster_ope_amb" data-qr="output_position=content&atc=amravati_atc&po=pandhrkawda_po">Pandharkawda PO</a></td>    
                        <td>3</td>  
                        <td>2</td>   
                        <td>67%</td>   
                    </tr>
                    <tr>
                        
                                                
                        <td><a class="click-xhttp-request" data-href="{base_url}dash/cluster_ope_amb" data-qr="output_position=content&atc=amravati_atc&po=kinwat_po">Kinwat PO</a></td>    
                        <td>3</td>  
                        <td>2</td>   
                        <td>67%</td>
                    </tr>
                    <tr>
                                                
                        <td><a class="click-xhttp-request" data-href="{base_url}dash/cluster_ope_amb" data-qr="output_position=content&atc=amravati_atc&po=dharni_po">Dharni PO</a></td>    
                        <td>5</td>  
                        <td>5</td>  
                        <td>100%</td>  
                    </tr>
                    <tr>
                                                 
                        <td><a class="click-xhttp-request" data-href="{base_url}dash/cluster_ope_amb" data-qr="output_position=content&atc=amravati_atc&po=kalamnoori_po">Kalamnoori PO</a></td>    
                        <td>1</td>  
                        <td>1</td>  
                        <td>100%</td>  
                    </tr>
                    <tr>
                                                   
                        <td>Total</td>    
                        <td>12</td>  
                        <td>12</td>  
                        <td>83%</td>  
                    </tr>
                    <?php } else{?>
                    <tr>
                                                   
                        <td><a class="click-xhttp-request" data-href="{base_url}dash/cluster_ope_amb" data-qr="output_position=content&atc=nagpur_atc&po=nagpur_po">Nagpur PO</a></td>    
                        <td>	2</td>    
                        <td>	2</td>    
                        <td>	100%</td>    
                    </tr>
<tr>
                                                   
    <td><a class="click-xhttp-request" data-href="{base_url}dash/cluster_ope_amb" data-qr="output_position=content&atc=nagpur_atc&po=gadchiroli_po">Gadchiroli PO</a></td>    
                        <td>	4</td>    
                        <td>	3</td>    
                        <td>	75%</td>  
                    </tr>
<tr>
                                                   
    <td><a class="click-xhttp-request" data-href="{base_url}dash/cluster_ope_amb" data-qr="output_position=content&atc=nagpur_atc&po=aheri_po">Aheri PO</a></td>    
                        <td>	2</td>    
                        <td>	2</td>    
                        <td>	100%</td>  
                    </tr>
<tr>
                                                   
    <td><a class="click-xhttp-request" data-href="{base_url}dash/cluster_ope_amb" data-qr="output_position=content&atc=nagpur_atc&po=bhamragad_po">Bhamragad PO</a></td>    
                        <td>	2</td>    
                        <td>	1</td>    
                        <td>	50%</td>  
                    </tr>
<tr>
                                                   
                        <td>Total</td>    
                        <td>	10</td>    
                        <td>	8</td>    
                        <td>	80%</td>  
                    </tr>

                    <?php } ?>
                    
               
                    
        

                </table>

            </div>
        </form>
    </div>
</div>