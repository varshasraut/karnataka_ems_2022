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
               //'info' => $info
            );

        }

    }
$serverName = $_SERVER['HTTP_HOST'];
	
	    if($serverName == '10.108.1.64'){
                $NeousURL = 'http://10.108.1.85/api/ERCDash/PostData';
            }else if($serverName == '210.212.165.119'){
                $NeousURL = 'http://210.212.165.118/api/ERCDash/PostData';
            }
            
            
            $data = '{"Data":[{"pilotId":0,"pilotName":"","pilotMbNo":0,"emsoId":73,"emsoName":"Dr.Suhas  Deshmukh","emsoMbNo":9850840562,"ambNo":"DM 00 CL 0000","ambBaseloc":"TEST Base Location","ambStatus":"Available","ambType":"BLS","distName":"Pune","incidenceId":20000000000,"ignition":0,"speed":10,"gpsStatus":1,"latitude":21.55295,"longitude":73.85252,"packetdatetime":"2022-01-31 13:46:21"}]}';
            
$http_header = array('Content-Type:application/json');
 
$args = array(
            'data'        => $data,
            'method'      => 'POST',
            'referer_url' => '',
            'http_header' => $http_header,
            'header'      => false,
            'timeout'     => 0
        );

$out = mi_curl_request($NeousURL, $args);
var_dump($out);
die();