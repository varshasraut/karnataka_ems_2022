<?php
function mi_curl_request( $url, $atts = array() ){
    
    $args = array(
        'data'        => array(),
        'method'      => 'GET',
        'referer_url' => '',
        'http_header' => array(),
        'header'      => false,
        'timeout'     => 0
    );
    
    $args = array_merge( $args, $atts );
    
    set_time_limit( $args['timeout'] );
    
    if (function_exists("curl_init") && $url) {
        
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_USERAGENT, $user_agent );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_HEADER, $args['header'] );
        curl_setopt( $ch, CURLOPT_TIMEOUT, $args['timeout'] );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $args['timeout'] );

        if ( strtolower( $args['method'] ) == "post" ) {
            curl_setopt( $ch, CURLOPT_POST, true );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $args['data'] );
        } else {
            curl_setopt( $ch, CURLOPT_HTTPGET, 1);
            $query_string = http_build_query( $args['data'] );
            if ( $query_string != '' ) {
                $url = trim( $url, "?" ) . "?" . $query_string;
            }
        }

        if ( $args['referer_url'] != '' ) { 
            curl_setopt( $ch, CURLOPT_REFERER, $args['referer_url'] );
        }

        if ( !empty( $args['http_header'] ) ) {
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $args['http_header'] );
        }

        curl_setopt( $ch, CURLOPT_URL, $url );
        
        $resp = curl_exec($ch);
        $info = curl_getinfo($ch);
        
        curl_close($ch);
        
        return array( 
            'resp' => $resp,
            'info' => $info
        );
        
    }
    
}

$url = "http://mulikas4/bvg/api/receiver";

 $data = '{"erouser":"poonam","token":"4b128c26f9757ecaa07c688d9c5b71aa70c060bf2e3a16d70838442cf963cf1f","type":"call","event_id":"201807181000059","caller":"9619612127","caller_name":"Ram Yadhav","call_type":"Emergency call","chief_complaint":"Unconscious","inc_state":"Maharashtra","inc_district":"Mumbai","inc_thasil":"Mumbai","inc_city_villege_town":"Mumbai","locality":"Mahalakshmi","lane_street":"Sat Rasta BST Bus Chocky","landmark":"Mahalaxmi Railway Station East","ero_summary":"Dispatched Successfully,,,Call To \r\n Nagpada Police Station Conference Done,,Call To Mahalaxmi Railway Station (West) Conference Done,","patient_info":[{"patient_mobile_no":"9999999999","patient_name":"sudakar kusawaney","patient_age":"41 years 11 mons 25 days","patient_gender":"Male"}],"ambulance_information":[{"base_location":"Mahalaxmi Railway Station (West)","vehicle":"MH14 CL 0630-BLS","emso":"7875771371","pilot":"7028006935"},{"base_location":"Nagpada Police Station","vehicle":"MH 12 PK 8517-First Responder","emso":"7410046504","pilot":"7410046514"}]}';
 
 $atts = array(
    'data'        => $data, // GET/POST Data
    'method'      => 'POST',   // GET/POST Method
    'http_header' => array('Content-Type: application/json'), // Send Row HTTP header
);

 
echo "<pre>";
$out = mi_curl_request($url, $atts);
print_r($out['resp']);
