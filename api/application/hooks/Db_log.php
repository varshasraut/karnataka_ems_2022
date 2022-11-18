<?php 

class Db_log {

    function __construct() {
        
    }


    function logQueries(){
      
        $CI = & get_instance();
        $filepath =  'logs/Query_log/App-Query-log-' . date('Y-m-d') . '.php'; 
        
        $handle = fopen($filepath, "a+");                        

        $times = $CI->db->query_times;
            
        foreach ($CI->db->queries as $key => $query) 
        { 
          
           // if (strstr($query, 'UPDATE')) { 

            $sql = $query . " \n Execution Time:" . $times[$key].' time:'.date('Y-m-d H:i:s') ; 
            fwrite($handle, $sql . "\n\n");   
            
            //}
        }

        fclose($handle);  
    }

}