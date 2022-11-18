<style>
    .width_26
    {
        width:9% !important;
    }
</style>
<?php
$CI = EMS_Controller::get_instance();
?>

<!--<div class="msg"><?php echo $res; ?></div>-->
<div class="breadcrumb float_left">
    <ul>

        <li><span>Login/Logout</span></li>
    </ul>
</div>

<br>

<div class="box3">    

    <div class="permission_list group_list">

        <form method="post" action="#" name="login_form" class="login_form">  

            <div id="clg_filters">

                <div class="filters_groups">                   

                    <div class="search">
                        <div class="row list_actions clg_filt">

                            <div class="search_btn_width">
                        
                                <div class="filed_input float_left width_16">
                                    <select id="team_type" name="team_type"  class="filter_required" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7"  <?php echo $view; ?>>
                                        <option value="">Select Team Type</option>
                                        <?php if($gr !='UG-QualityManager' && $gr !='UG-Quality'){  ?>
                                        <option value="all">All</option>
                                        
                                        <?php }if($gr=='UG-EROSupervisor'){  ?>
                                        
                                        <option value="UG-ERO">ERO</option>
                                        <!--<option value="UG-ERO-102">ERO-102</option>-->
                                    <?php }elseif($gr=='UG-DCOSupervisor'){  ?>
                                        <option value="UG-DCO">DCO</option>
                                        <!--<option value="UG-DCO-102">DCO-102</option>-->
                                    <?php }elseif($gr=='UG-ERCPSupervisor'){ ?>
                                        <option value="UG-ERCP">ERCP</option>
                                    <?php }elseif($gr=='UG-GrievianceManager'){ ?>    
                                        <option value="UG-GRIVIANCE">GRIEVANCE</option>
                                    <?php }elseif($gr=='UG-FeedbackManager'){ ?>
                                        <option value="UG-FEEDBACK">FEEDBACK</option>
                                    <?php }elseif($gr=='UG-FDASupervisor'){ ?>
                                        <option value="UG-FDA">FIRE</option>
                                    <?php }elseif($gr=='UG-PDASupervisor'){ ?>
                                        <option value="UG-PDA">POLICE</option>
                                        <?php }elseif($gr=='UG-QualityManager'){ ?>
                                        <option value="UG-Quality">Quality</option>
                                        <?php }elseif($gr=='UG-EROSupervisor-104'){ ?>
                                        <option value="UG-ERO-104">ERO - 104</option>
                                        <?php }elseif($gr=='UG-Quality'){ ?>
                                        <option value="UG-Quality">Quality</option>
                                        <!-- <option value="UG-QualityManager">Quality Manager</option> 
                                        <option value="UG-ERO">ERO-108</option>
                                        <option value="UG-ERO-102">ERO-102</option>
                                        <option value="UG-DCO">DCO</option>
                                        <option value="UG-DCO-102">DCO-102</option>
                                        <option value="UG-ERCP">ERCP</option>
                                        <option value="UG-GRIVIANCE">GRIEVANCE</option>
                                        <option value="UG-FEEDBACK">FEEDBACK</option>
                                        <option value="UG-FDA">FIRE</option>
                                        <option value="UG-PDA">POLICE</option>     -->
                                        <!--  //}elseif($gr=='UG-Quality'){  -->
                                        <!-- <option value="UG-ERO">ERO-108</option>
                                        <option value="UG-ERO-102">ERO-102</option> -->
                                        <!-- <option value="UG-DCO">DCO-108</option>
                                        <option value="UG-DCO-102">DCO-102</option>
                                        <option value="UG-ERCP">ERCP</option>
                                        <option value="UG-GRIVIANCE">GRIVIANCE</option>
                                        <option value="UG-FEEDBACK">FEEDBACK</option>
                                        <option value="UG-FDA">FIRE</option>
                                        <option value="UG-PDA">POLICE</option>  -->
                                        <!-- <option selected value="">Select Team Type</option> -->
                                        <!-- <option value="UG-Quality">Quality</option>    -->
                                        
                                    <?php }else if($gr=='UG-ShiftManager'){ ?>
                                           <option value="UG-ERO">ERO-108</option>
                                        <option value="UG-ERO-102">ERO-102</option>
                                        <option value="UG-DCO">DCO-108</option>
                                        <option value="UG-DCO-102">DCO-102</option>
                                        <option value="UG-ERCP">ERCP</option>
                                        <option value="UG-GRIVIANCE">GRIEVANCE</option>
                                        <option value="UG-FEEDBACK">FEEDBACK</option>
                                        <option value="UG-FDA">FIRE</option>
                                        <option value="UG-PDA">POLICE</option>
                                        
                                    <?php }else{ ?>
                              
                                        <option value="UG-ERO">ERO-108</option>
                                        <option value="UG-ERO-102">ERO-102</option>
                                        <option value="UG-DCO">DCO-108</option>
                                        <option value="UG-DCO-102">DCO-102</option>
                                        <option value="UG-ERCP">ERCP</option>
                                        <option value="UG-GRIVIANCE">GRIEVANCE</option>
                                        <option value="UG-FEEDBACK">FEEDBACK</option>
                                        <option value="UG-FDA">FIRE</option>
                                        <option value="UG-PDA">POLICE</option>
                                        <option value="UG-Quality">Quality</option> 
                                        <option value="UG-QualityManager">Quality Manager</option> 
                                        
                                        
                                        <?php }  ?>
                                    </select>
                                </div>    
                                <div class="float_left width_26" id="ero_list_outer_qality">   
                    
                                    <select name="user_id" id="ero_list_qality">
                                    <option value="">Select ERO</option>
                                    <option value='all'>All</option>
                                    
                                    </select>
                                </div>
                                <div class="float_left width_16">
                                    <input name="from_date" tabindex="20"  class="form_input mi_calender filter_required" placeholder="From Date"  type="text"  data-errors="{filter_required:'Date should not be blank!'}" >
                                </div>
                                 <div class="float_left width_16">
                                    <input name="to_date" tabindex="20"  class="form_input mi_calender filter_required" placeholder="To Date"  type="text"  data-errors="{filter_required:'Date should not be blank!'}" >
                                </div>
                                <div class="float_left width_16" id="login_logout_load">   
                    
                                    <select name="function_name" class="filter_required" data-errors="{filter_required:'type should not blank'}" >
                                        <option value="">Select</option>
                                        <option value='view_login_details'>View Login</option>
                                        <option value='view_break_details'>View Break</option>
                                    
                                    </select>
                                </div>
                                <div class="filed_input float_left width_25" id="login_logout_search_btn">  
                                  
                                    <input type="button" name="search_btn" value="Search" class="btn clg_search form-xhttp-request float_left width40 mt-0" data-href="{base_url}shiftmanager/show_user_data" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" style="float:left !important;" >
                                    <input class="search_button click-xhttp-request float_right mt-0" name="" value="Reset Filters" data-href="{base_url}shiftmanager/login" data-qr="filters=reset" type="button">

                                </div>
                            </div>


                        </div>


                    </div>

                </div>

            </div>
        </form>
            <div id="list_user_table">



            </div>
        
    </div>
</div>