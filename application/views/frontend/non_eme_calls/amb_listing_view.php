     <!-- jQuery library -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->

<!-- JS & CSS library of MultiSelect plugin -->
<script src="<?php echo base_url(); ?>assets/js/jquery.multiselect.js"></script> 
<!-- <script src="<?php echo base_url(); ?>assets/js/multiselect-dropdown.js"></script>  -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/multiselect-dropdown.css">
<style>
    .multiselect {
  width: 200px;
}

.selectBox {
  position: relative;
}

.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

#checkboxes {
  display: none;
  border: 1px #dadada solid;
  height: 100px;
  overflow-y: scroll;
}

#checkboxes label {
  display: block;
  
}

#checkboxes label:hover {
  background-color: #1e90ff;
}

</style>
        <div class="selectBox" id="selectbox" ">
        <!-- <input name="inc_district_id" id="inc_district"  tabindex="9" class="form_input mi_autocomplete" placeholder="Select Ambulance" type="text"> -->
        <!-- <div class="overSelect"> -->
          <!-- <input type="text" id="userInput"> -->
        <!-- </div> -->
        </div>
        <select name="langOpt[]" multiple id="langOpt"">
        <div id="checkboxes">
        <?php foreach ($amb as $row) { ?>
          <option  id="inc_amb_not_assgn_ambulances[]" name="inc_amb_not_assgn_ambulances[]" value="<?php echo $row->amb_rto_register_no ;?>"><?php echo $row->amb_rto_register_no?></option>
        <!-- <input type="checkbox" onchange="checkboxes()" id="inc_amb_not_assgn_ambulances[]" name="inc_amb_not_assgn_ambulances[]" value="<?php echo $row->amb_rto_register_no ;?>"><?php echo $row->amb_rto_register_no?><br> -->
        <?php } ?> 
        </div>
        </select>
      
        
    
<script type="text/javascript">
   
    function BindTable() {
        $('#table tbody').empty();
      }
    $('select[multiple]').multiselect();
    $('#langOptgroup').multiselect({
      columns: 4,
      placeholder: 'Select Languages',
      search: true,
      selectAll: true
  });
 
</script>