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
                <a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&atc=<?php echo $atc;?>&po=<?php echo $po;?>"><?php echo $po_name;?> PO</a>
            </li>
              <li>
                <span>Cluster</span>
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
                        <th nowrap>Cluster Name</th>
                        <th nowrap>Total Ambulances</th>
                        <th nowrap>Total On-road Ambulances</th>
                        <th nowrap>% On-road Ambulances</th>
                        
                    </tr>
                    <?php if($po == 'nandurbar_po'){?>
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=nandurbar_po&cluster=1">Nandurbar Government Ashram School</a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>	
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=nandurbar_po&cluster=2">Devmogara Government Ashram School</a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                            <td>
                        </tr>	
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=nandurbar_po&cluster=3">Bandhare Government Ashram School</a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>	
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=nandurbar_po&cluster=4">Rampur Government Ashram School </a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <tr><td>Total</td>  
                            <td>	4	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>

 
                  
                    <?php } else if($po == 'taloda_po'){ ?>
                    <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=taloda_po&cluster=5">Shirve Government Ashram School </a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=taloda_po&cluster=6">Boys Hostel Molgi </a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=taloda_po&cluster=7">Talamba Government Ashram School </a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=taloda_po&cluster=8">Mandavi Government Ashram School </a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=taloda_po&cluster=9">Toranmal Government Ashram School </a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=taloda_po&cluster=10">Son Kh (Temporary arrangement for 3 months at Govt Hostel, Survani)</a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=taloda_po&cluster=11">SChulvad Government Ashram School </a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                          <tr>

                            <td>Total</td>  
                            <td>	7		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>


                    <?php } else if($po == 'kalwan_po'){?>
                        

 



                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=kalwan_po&cluster=12">Haranbari  Government Ashram School </a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>	
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=kalwan_po&cluster=13">Kanashi Government Ashram School </a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>	
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=kalwan_po&cluster=14">Sarad Government Ashram School  </a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>	
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=kalwan_po&cluster=15">Bhormal Government Ashram School</a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>	
                         
                           <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=kalwan_po&cluster=16">Pandharun Government Ashram School </a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>	
                        
                        
                        
                        
                        
                   <?php  } else  if($po == 'rajur_po'){ ?>



                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=rajur_po&cluster=17">Government Ashram School, Maveshi</a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=rajur_po&cluster=18">Government Ashram School, Aklapur</a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=rajur_po&cluster=19">Government Ashram School, Kelirumanwadi</a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                         <tr>

                            <td>Total</td>  
                            <td> 	3	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <tr>

                            <td>Total</td>  
                            <td> 	4	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                     
                 <?php }else if($po == 'dhule_po'){?>
                         
 

                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=dhule_poo&cluster=20">Bopkhel Government Ashram School</a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=dhule_poo&cluster=21">Shirsole Government Ashram School</a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=dhule_poo&cluster=22">Lauki Government Ashram School</a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <tr>

                            <td>Total</td>  
                            <td> 	3	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        
                 <?php }else if($po == 'yaval_po'){ ?>


                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">VaijapurGovernment Ashram School </a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Dahiwad Government Ashram School</a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Palaskheda Government Ashram School</a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Dongar Kathora Government Ashram School </a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <tr>

                            <td>Total</td>  
                            <td> 	4	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                     
                 <?php }else if($po == 'nagpur_po') { ?>
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Government Ashram School, Kavlas, Hingana </a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>	
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Government Ashram School, Belda, Ramtek</a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <tr><td>Total</td>  
                            <td>	4	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                    <?php } else if($po == 'gadchiroli_po'){?>
                        
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Talamba Government Ashram School </a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>	
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Government Ashram School, Ramgad</a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Government Ashram School, Murumgaon</a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>	
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Government Ashram School,  Markhandadev</a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <tr><td>Total</td>  
                            <td>	4	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>

                    <?php } else if($po == 'aheri_po'){?>
                        
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Government English medium School Aheri</a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>	
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Government Ashram School, Bamani</a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <tr><td>Total</td>  
                            <td>	4	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>

                    <?php } else if($po == 'bhamragad_po'){?>
                        


                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Government Boys / Girls Hostel, Etapalli</a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>	
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Government Boys / Girls Hostel, Bhamragad</a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <tr><td>Total</td>  
                            <td>	4	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>

                    <?php } else if($po == 'pandhrkawda_po'){?>
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Hivri Government Ashram School </a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>	
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Matharjun Government Ashram School</a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Jambh Government Ashram School </a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <tr><td>Total</td>  
                            <td>	4	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>

                    <?php } else if($po == 'kinwat_po'){?>

                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po"> Umri Government Ashram School  </a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>	
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Bodhdi Government Ashram School </a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Dudhad Government Ashram School </a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                        <tr><td>Total</td>  
                            <td>	4	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>

                    <?php } else if($po == 'dharni_po'){?>
 
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Manikpur Government Ashram School</a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>	
                        <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Jarida Government Ashram School </a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                          <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Tembru Sonda Government Ashram School </a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                          <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Tembli Government Ashram School </a></td>  
                            <td>	1		</td>  
                            <td></td>  
                            <td></td>  
                        </tr>
                       
                        <tr><td>Total</td>  
                            <td>	4	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>

                    <?php } else if($po == 'kalamnoori_po'){?>
                         <tr>

                            <td><a class="click-xhttp-request" data-href="{base_url}dash/school_ope_amb" data-qr="output_position=content&po=pandhrkawda_po">Jamgavhan Government Ashram School </a></td>  
                            <td> 	1	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>	
                        <tr><td>Total</td>  
                            <td>	4	</td>  
                            <td></td>  
                            <td></td>  
                        </tr>

                    <?php } ?>
                    
               
                    
        

                </table>

            </div>
        </form>
    </div>
</div>