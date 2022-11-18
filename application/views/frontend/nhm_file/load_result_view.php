<style>
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  width: 100%;
  overflow-x: scroll;
}
.excel_tabs ul{
        list-style-type: none;
    display: table;

}
.excel_tabs ul li{
    display: table-cell;
    white-space: nowrap;
    border-radius: 5px 5px 0px 0px !important;
    border: 1px solid #085b80;

}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 5px 10px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
  
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
#colorbox{
     background: #fff;
}
</style>
</head>

<div class="tab excel_tabs">
    <ul>
    <?php foreach($sheet_names as $sheet){?>
        <li>
    <button class="tablinks" onclick="openCity(event, '<?php echo str_replace(' ', '_', $sheet);?>')"><?php echo $sheet; ?></button>
    <li>
    <?php } ?>
    </ul>
</div>

<?php 
 
foreach($result_data as $key=>$results){
    
    ?>
 
<div id="<?php echo  str_replace(' ', '_',$sheet_names[$key]);?>" class="tabcontent">
   <h3><?php echo $sheet_names[$key];?></h3>
   
   <table style="border-collapse: collapse;">
       <?php 
      
       foreach($results as $keys=>$result){ 
          
        if($keys == '1' || $keys == '2' ){
                   continue;;
               }
           
           ?>
       <tr>
           <?php foreach($result as $key=>$res){ 
               
              
              
               ?>
            <td><?php 
            $float = is_float($res);
            if($float == 1){
                 echo round($res,2);
            }else{
                 echo $res;
            }
           ?></td>
               <?php }  ?>
       </tr>
     
          
 
  <?php
    $count++;
  
            }?>
   </table>
  
 
</div>
<?php } ?>
<script>
    
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>