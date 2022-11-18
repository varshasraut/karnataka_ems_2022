<?php  

 function send_curl_request($url, $parameter = '', $method = "get") {

        set_time_limit(0);

        if (function_exists("curl_init") && $url) {

            $user_agent = $_SERVER['HTTP_USER_AGENT'];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);

            if (is_array($parameter)) {

                //$query_string = http_build_query($parameter);
				$query_string = array();
				
				foreach($parameter as $key => $value){
					
					$query_string []= $key."=".$value;
				
				}
				$query_string = join("&",$query_string);
				
            } else {

                $query_string = $parameter;
            }
             echo $query_string;
            curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookiesjar.txt');

           
          
           curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);

            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

           /// curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

            if ($method == "post") {

                curl_setopt($ch, CURLOPT_POST, 1);

                if ($parameter != "") {

                    curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
                }
            } else {

                curl_setopt($ch, CURLOPT_HTTPGET, 1);

                if ($parameter != "") {

                    $url = trim($url, "?") . "?" . urlencode($query_string);
                }
            }
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $document = curl_exec($ch);

            echo "error>". curl_error($ch);
            print_r($document);

            curl_close($ch);

            return $document;
        }
    }
	
	
	
	///$url = "http://server/ems/api/receiver";
$url = "http://mulikas4/bvg/api/receiver";
	

$pr= array();
$pr['type'] = 'call';
$pr['token'] = '9b3e00840e4a60766ff331f2efb23e7a';
$pr['ref_number'] = '895689652387412';
$pr['caller_mobile_number'] = '7758071902';///9860562808,7758071902,9561771450
$pr['caller_first_name'] = 'Jolly';
$pr['caller_middle_name'] = '';
$pr['caller_last_name'] = 'Shete';
$pr['inc_no_of_patient'] = '1';
$pr['inc_note'] = 'This is emergency call';
$pr['patient_first_name'] = 'Jali';
$pr['patient_middle_name'] = '';
$pr['patient_last_name'] = 'Shete';
$pr['patient_age'] = '45';
$pr['patient_gender'] = 'Male';
$pr['inc_state'] = 'Maharashtra';
$pr['inc_district'] = 'Pune';
$pr['inc_tahsil'] = 'Shirur';
$pr['inc_city_villege_town'] = 'Shirur';
$pr['inc_area_location'] = 'Khara Mala';
$pr['inc_landmark'] = 'Near Bhise Hospital';
$pr['inc_lane_street'] = 'Nagar Road';
$pr['inc_house_number'] = '';
$pr['inc_pin_code'] = '412210';

 $data = '{"erouser":"poonam","token":"4b128c26f9757ecaa07c688d9c5b71aa70c060bf2e3a16d70838442cf963cf1f","type":"call","event_id":"201807181000059","caller":"9619612127","caller_name":"Ram Yadhav","call_type":"Emergency call","chief_complaint":"Unconscious","inc_state":"Maharashtra","inc_district":"Mumbai","inc_thasil":"Mumbai","inc_city_villege_town":"Mumbai","locality":"Mahalakshmi","lane_street":"Sat Rasta BST Bus Chocky","landmark":"Mahalaxmi Railway Station East","ero_summary":"Dispatched Successfully,,,Call To \r\n Nagpada Police Station Conference Done,,Call To Mahalaxmi Railway Station (West) Conference Done,","patient_info":[{"patient_mobile_no":"9999999999","patient_name":"sudakar kusawaney","patient_age":"41 years 11 mons 25 days","patient_gender":"Male"}],"ambulance_information":[{"base_location":"Mahalaxmi Railway Station (West)","vehicle":"MH14 CL 0630-BLS","emso":"7875771371","pilot":"7028006935"},{"base_location":"Nagpada Police Station","vehicle":"MH 12 PK 8517-First Responder","emso":"7410046504","pilot":"7410046514"}]}';

 


///$pr['concat'] = '1';
echo "<pre>";
$out = send_curl_request($url, $data, "post");
//echo  "<br\>";
//print_r(json_decode($data));
//print_r($out);


