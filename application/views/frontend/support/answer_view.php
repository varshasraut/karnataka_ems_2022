<h4 class="ans_headings">Answer:</h4>

  <table class="table report_table">
<?php  
        $lng_array=get_lang();
        
    if(count($answer)>0){
   
        foreach($answer as $ans){ 
            
             $serialize_data =  $ans->ans_answer;
             $answer = get_lang_data($serialize_data,$lng_array[$lang]);
             setcookie('set_answer',$answer, time() + (86400 * 30), "/");
            
            ?>
    
            <tr>
                <td><?php echo nl2br($answer);?></td>
            </tr>
          <?php
        }
   
        }else{  ?>
            
            <div class="filed_textarea">
                <textarea class="text_area" name="other_que" rows="5" cols="30" tabindex="18" Placeholder="To write Other Question"></textarea>
            </div>
       
    <?php } ?>

      
  </table>
            
            

