<?php


 function get_lang_data($serialize_data,$lang){
   

    $string = preg_replace_callback(
        '!s:(\d+):"(.*?)";!s',
        function($m){
            $len = strlen($m[2]);
            $result = "s:$len:\"{$m[2]}\";";
            return $result;

        },
        $serialize_data);
   
    $unser_data = unserialize($string);   
        
    if($lang=='hindi'){
        $result = $unser_data['hn'];
    }else if($lang=='Marathi'){
        $result = $unser_data['mh'];
    }else{
        $result = $unser_data['en'];
    }
   
    return $result;

 }