<?php 
date_default_timezone_set('Asia/Kolkata');

header("Content-Type: text/event-stream");
header('Cache-Control: no-cache');

error_reporting(1);
//echo "hier";
//die();

$counter = rand(1, 10);
while (1) {

	echo "id:".time() . PHP_EOL;
    echo "event:ping".PHP_EOL;
    echo 'data:{"time": "' . time() . '"}'.PHP_EOL;
    echo PHP_EOL;
    
    $resp_data = array();
    $current_time = strtotime(date('Y-m-d H:i:s'));
    
    
    $counter--;

    if (!$counter) {
     
      
          echo "id:".time() . PHP_EOL;
    echo "data: This is a message at time $current_time" . PHP_EOL;
    echo PHP_EOL;
      $counter = rand(1, 10); // reset random counter
    }


    ob_flush();
    flush();

    //usleep(0250000);
    usleep(0500000);
	//break;

}
