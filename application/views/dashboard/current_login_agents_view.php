<div class="container">
<div class="col_md_12 text_center justify-content-center">
<h2 class="">Login Agent List</h2>
</div>
            <?php ?>
            <div class="d-inline-block width13">
                <div class="statistic__item">
                    <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-ERO"><span id="ero"></span></a>
                    <br>ERO    
                </div>           
            </div>
            <div class="d-inline-block width13">
                <div class="statistic__item">
                    <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-DCO"><span id="dco"></span></a>
                    <br>DCO              
                </div>
            </div>
            <div class="d-inline-block width13">
                <div class="statistic__item">
                    <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-PDA"><span id="pda"></span></a>
                    <br>PDA                
                </div>
            </div>
            <div class="d-inline-block width13">
                <div class="statistic__item">
                    <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-FDA"><span id="fda"></span></a>
                    <br>FDA                
                </div>
            </div>
            <div id="ercp1" class="d-inline-block width13">
                <div class="statistic__item">
                    <span id="ercp"></span>
                    <br>ERCP                
                </div>
            </div>
            <div id="grievance1" class="d-inline-block width13">
                <div class="statistic__item">
                    <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-Grievance"><span id="grievance"></span></a>
                    <br>Grievance                
                </div>
            </div>
            <div class="d-inline-block width13">
                <div class="statistic__item">
                    <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-Feedback"><span id="feedback"></span></a>
                    <br>Feedback                
                </div>
            </div>
    </div>
    <div class="col-md-12 col-lg-12 ">  
        <div class="d-inline-block width13">
                <div class="statistic__item">
                    <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-EROSupervisor"><span id="ero_tl"></span></a>
                    <br>ERO Supervisor  
                </div>              
        </div>
        <div class="d-inline-block width13">
                <div class="statistic__item">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-DCOSupervisor"><span id="dco_tl"></span></a>
                <br>DCO Supervisor  
                </div>
        </div>
        <div class="d-inline-block width13">
            <div class="statistic__item">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-PDASupervisor"><span id="pda_tl"></span></a>
                <br>PDA Supervisor 
                </div>               
        </div>
        <div class="d-inline-block width13">
            <div class="statistic__item">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-FDASupervisor"><span  id="fda_tl"></span></a>
                <br>FDA Supervisor  
                </div>              
        </div>
        <div class="d-inline-block width13">
            <div class="statistic__item">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-ERCPSupervisor"><span id="ercp_tl"></span></a>
                <br>ERCP Supervisor    
                </div>           
        </div>
        <div class="d-inline-block width13">
            <div class="statistic__item">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-GrievianceManager"><span id="grievance_tl"></span></a>
                <br>Grievance Manager   
                </div>         
        </div>
        <div class="d-inline-block width13">
            <div class="statistic__item">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-FeedbackManager"><span id="feedback_tl"></span></a>
                <br>Feedback Manager   
                </div>           
        </div>
    </div> 
    
</div>

<div class="row justify-content-center" id="p1">

    <div><?php echo "ercp"; ?></div>

</div>

</div>

<script>
$(document).ready(function(){
    $("#p1").hide();
  $("#ercp1").click(function(){
    //alert("hi");
    $("#p1").show();
  });
  $("#grievance1").click(function(){
    //alert("hi");
    $("#p1").show();
  });
  $("#ercp1").click(function(){
    //alert("hi");
    $("#p1").show();
  });
  $("#ercp1").click(function(){
    //alert("hi");
    $("#p1").show();
  });
  $("#ercp1").click(function(){
    //alert("hi");
    $("#p1").show();
  });
  $("#ercp1").click(function(){
    //alert("hi");
    $("#p1").show();
  });
  $("#show").click(function(){
    $("#p1").hide();
  });
});
</script>