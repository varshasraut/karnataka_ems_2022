<?php 
//            $driver            = "fulesh";
//            $sms_driver        = "Fulesh shete";
//            $sms_driver_contact_no = "9730200665";
//            $inc_id = 'INC-111';
//            $amb_url = "https://dev.mulikainfotech.com/ems/inc?inc=INC-111";
//            
//            $sms_api_username = "SperocHL";
//            $sms_api_password = "SpeRo@12";
//            $sms_from = "EMS";
//            
//            $patient_name = "chaitali";
//            $sms_amb = "1212";
//            
//            $patient_sms_text = "Dear $patient_name, "
//                               . " Following ambulance is dispathced to your location Ambulance No: $sms_amb, Driver: $sms_driver Contact No $sms_driver_contact_no Chief complete- ,Incident Id-$inc_id, $amb_url";
//            $patient_sms_to = '9730015484';             
//            
//            $patient_sms_body = "<MESSAGE VER='1.2'> <USER USERNAME='$sms_api_username PASSWORD='$sms_api_password' DLR='0'/> <SMS TEXT='$patient_sms_text ID='1'> <ADDRESS FROM='$sms_from' TO='$patient_sms_to' SEQ='1'/></SMS></MESSAGE>";
//            
//            $curl_url = "http://www.unicel.in/servxml/XML_parse_API.php?action=send& data=".urlencode($patient_sms_body);
            //echo $curl_url;
            
            //$location_data =  $this->_send_curl_request($curl_url,'','get');
        
           // $location_data = json_decode($location_data);
          //  echo $location_data;

            $sms_api_username = "SperocHL";
            $sms_api_password = "SpeRo@12";
            $msg_body = '<MESSAGE VER="1.2"> '
                . '<USER USERNAME="'.$sms_api_username.'" PASSWORD="'.$sms_api_password.'" DLR="0"/> '
                . '<SMS TEXT="This is first sms" ID="1">'
                . ' <ADDRESS FROM="SperocHL" TO="919730015484" SEQ="2"/> '
                . '</SMS> '
                . '</MESSAGE>';
           $curl_url1 =  'http://www.unicel.in/servxml/XML_parse_API.php?action=send&data='.urlencode($msg_body);
            echo $curl_url1;