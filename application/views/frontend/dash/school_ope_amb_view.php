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
                <a class="click-xhttp-request" data-href="{base_url}dash/po_ope_amb" data-qr="output_position=content&po=<?php echo $po;?>"><?php echo $po_name;?> PO</a>
            </li>
            <li>
                <a class="click-xhttp-request" data-href="{base_url}dash/po_ope_amb" data-qr="output_position=content&po=<?php echo $po;?>&cluster=<?php echo $cluster;?>">Cluster</a>
            </li>
              <li>
                <span>School</span>
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
                        <th nowrap>School Name</th>
                        <th nowrap>Today</th>
                        <th nowrap>Month Till Date</th>
                        <th nowrap>Year Till Date</th>
                        
                    </tr>
                    <?php if($cluster == '1'){?>
                  <tr><td>Loy Government Ashram School	</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Kothali Government Ashram School	</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Bhaler Government Ashram School		</td> <td> </td><td> </td><td> </td></tr>
                    <tr><td>Waghale Government Ashram School	</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Khokrale Government Ashram School	</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Thanepada Government Ashram School		</td> <td> </td><td> </td><td> </td></tr>
                    <tr><td>GAS Nandurbar Government Ashram School	</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>EMRS Nandurbar Government Ashram School		</td> <td> </td><td> </td><td> </td></tr>
                    <tr><td> Government Ashram School</td> <td> </td><td> </td><td> </td></tr>
 
                  
                    <?php } else if($cluster == '2'){ ?>
                    <tr><td>Devmogara Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>	
                    <tr><td>Nizampur Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>		
                    <tr><td>Borchak Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>			
                    <tr><td>Bhadwad Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>		
                    <tr><td>(Dhong) Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>		
                    <tr><td>sagali Government Ashram School	</td> <td> </td><td> </td><td> 	</td></tr>	
                    <tr><td>Khadki Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>	
                    <tr><td> Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>			
                    <tr><td>Panbaara Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>			
                    <tr><td>Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>			
                    <tr><td>Aamsarpada Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>			
                    <tr><td>Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>			
                    <tr><td>Navali Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>		
                    <tr><td>Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>	
        

                    <?php } else if($cluster == '3'){?>
                        
                    <tr><td>Bandhare Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>			
                    <tr><td>Dhanrat Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>			
                    <tr><td>Kolde Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>		
                    <tr><td>Vadkalambi Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>		
                    <tr><td>Khekada Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>		
                    <tr><td>Navapur Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>		
                    <tr><td>Government Ashram School</td> <td> </td><td> </td><td> 	</td></tr>	
                        
                   <?php  } else if($cluster == '4'){?>
                         
                    <tr><td>Rampur Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Navalpur Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Shahada Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td> Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Chandsaili Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td> Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Malgaon Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td> Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Chirkhan Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td> Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Shahane Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Sultanpur Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        
                 <?php }else if($cluster == '5'){ ?>


                         <tr><td>Shirve Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Lobhani Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Salasadi Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Amoni Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Ranipur Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Borad Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Jambhai Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Ichhagavhan Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Alivihir Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Nala Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        
                 <?php }elseif($cluster == '6'){ ?>

                        <tr><td>Dab Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td> Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Bhangrapani Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Bardi Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Bhagdari Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Wadphali Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Sari Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Jangathi Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Gaman Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Dahel Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        
                 <?php }else if($cluster == '7') { ?>
                        <tr><td>Talamba Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                         <tr><td>Kumbharkhan Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                         <tr><td>Kankalamal Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                         <tr><td>Moramba Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                         <tr><td>Khadakapani Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                         <tr><td>Horaphali Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>

                    <?php } else if($cluster == '8'){?>
                        
                        <tr><td>Mandavi Bk Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Kakarda Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Valval Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Telkhadi Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Trishul Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>

                    <?php } else if($cluster == '9'){?>
                        
                         <tr><td>Toranmal Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Japi Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Shindidigar Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Ranipur (Nandubar PO) Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Ganor ( Nandubar PO) Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>

                    <?php } else if($cluster == '10'){?>

                        <tr><td>Mojara Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Shelgada Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td> Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Hatdhui Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td> Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Son Kh Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td> Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Roshamal Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td> Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>

                    <?php } else if($cluster == '11'){?>
                         <tr><td>Bijari Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Asali Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Chulvad Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Talai Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>


                    <?php } else if($cluster == '12'){?>

                    <tr><td>Haranbari Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Dodheshwar Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Tataani Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Dahindule Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Bhilwad Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Salher Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Manur Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Waghamba Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Talwade Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>

                    <?php } else if($cluster == '13'){?>
 
                        <tr><td>Kanashi Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Chankapur Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Dalvat Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Mohandari Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Gopalkhadi Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Narul Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Paregaon Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>

                    <?php } else if($cluster == '14'){?>
                        <tr><td>Bapkheda Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Kathare Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Kharde Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Desgaon Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Sarad Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Palsan Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Khirad Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>

                    <?php }else if($cluster == '15'){ ?>
                        
                        <tr><td>Bubli Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Aambupada# Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Dolhaare Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Salbhoye Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Khuntvihir Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Bhormal Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Karanjul (Su) Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Karanjul(Ka) Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Borpada  Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Mani Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        
                    <?php }else if($cluster == '16'){ ?>
                        <tr><td>EMRS Ajmer Saundane Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Virgaonpade Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Rameshwar Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Pandharun Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Garbad# Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Deopurpada Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Ganore Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                        <tr><td>Visapur Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <?php } else if($cluster == '17'){?>
                        
                    <tr><td>Maveshi Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Aadarsh Maveshi Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>EMRS Maveshi Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Rajur Maveshi Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Sirpunje Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Mutkhel Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Ghatghar Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Kelikotul Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Paithan Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Sawarchol Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Kohne Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td>Palsunde Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
                    <tr><td> Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>

                    <?php } else if($cluster == '18'){ ?>
 
 

<tr><td>Aklapur Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Jawale Baleshawar Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Mhaswandi Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Kolewadi Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Sakur Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Palashi Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>


                    <?php } else if($cluster == '19'){?>



<tr><td>Kelirumhanwadi Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Tirde Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Khirvire Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Pimparkane Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>
        
                    <?php } else if($cluster == '20'){?>
        
        <tr><td>Bopkhel Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>EMRS Pimpalner Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Sukapur Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Shevge Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Warse Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Umarpata Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Charanmal Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>


 <?php } else if($cluster == '21'){?>

Rainpada Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Rohod Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Shirsole Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Vihirgaon Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Pangan Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Nawapada Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>


 <?php } else if($cluster == '22'){?>


<tr><td>Lauki Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Hivarkheda Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Kodid Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td> Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td> Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Umarda Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Arthe Kh Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td> Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Sulwade Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Shirpur Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Akkalkos Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Mhalsar Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td>Jamnyapada Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
<tr><td> Government Ashram School		</td> <td> </td><td> </td><td> 	</td></tr>
 <?php } else if($cluster == '23'){?>
 <?php } else if($cluster == '20'){?>
 <?php } ?>
                </table>

            </div>
        </form>
    </div>
</div>