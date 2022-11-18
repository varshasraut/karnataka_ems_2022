<?php

$username='admin';
$password='Mems@123$';
set_time_limit(0);
date_default_timezone_set('Asia/Kolkata');
$hours = date('H');
$minutes = date('i');;


//if($hours == '3' && $minutes < '55'){

//$remote_file = 'https://www.mhems.in/backup/db_backup/mhems_2020.sql';
$remote_file = 'http://10.108.1.67/mhems/backup/db_backup/mhems_2020.sql';
$local_file = getcwd().'/temp/database/';

$fp = fopen ($local_file, 'w+');
$ch = curl_init($remote_file);
curl_setopt($ch, CURLOPT_TIMEOUT, 500000);
curl_setopt($ch, CURLOPT_FILE, $fp); 
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_exec($ch);
curl_close($ch);
fclose($fp);



system("mysqldump --add-drop-table -u  -p'$password' mhems_2020 | grep 'DROP TABLE' | mysql -u newuser -p'$password' mhems_2020");
system("mysql -u $username -p'$password' mhems_2020 < ".$local_file."mhems_2020.sql");

$group_permission_file = getcwd().'/temp/database/ems_group_permissions.sql';
system("mysql -u $username -p'$password' mhems_2020 < ".$group_permission_file);

}
//die();