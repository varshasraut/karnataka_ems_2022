<?php 
date_default_timezone_set('Asia/Kolkata');

header("Content-Type: text/event-stream");
header('Cache-Control: no-cache');

error_reporting(1);
//echo "hier";
//die();

//if(!session_id()){ session_start(); }


$call_clg_group = array('UG-ERO', 'UG-ERO-102', 'UG-ERO-HD');
$agent_id   = $_GET['avaya_agentid'];
$clg_group  = $_GET['clg_group'];

if( empty($agent_id) || !in_array($clg_group, $call_clg_group) ) {
    exit();
}

file_put_contents('./logs/avaya_calls/'.$agent_id.'.json','');

$avaya_call_flag=json_encode(array('incoming_calls_event'=>1));
file_put_contents('./logs/avaya_calls/'.$agent_id.'_flag.json',$avaya_call_flag);

while (1) {

	echo "id:".time() . PHP_EOL;
    echo "event:ping".PHP_EOL;
    echo 'data:{"time": "' . time() . '"}'.PHP_EOL;
    echo PHP_EOL;
    
    $resp_data = array();
    $current_time = strtotime(date('Y-m-d H:i:s'));
    
    $avaya_flag = file_get_contents('./logs/avaya_calls/'.$agent_id.'_flag.json');
    $avaya_flag_data = json_decode($avaya_flag);
    $flag= $avaya_flag_data->incoming_calls_event;
    
    //$incoming_calls_event = $_SESSION['incoming_calls_event'];
    if ( connection_aborted() || connection_status() != CONNECTION_NORMAL || $flag == 0 ){   
        exit();
    }
    $avaya_call = file_get_contents('./logs/avaya_calls/'.$agent_id.'.json');
    //var_dump($avaya_call);
    
    if(trim($avaya_call) != ""){
        $avaya_call = json_decode($avaya_call);
    }
    
    if ( !empty($avaya_call) && !json_last_error() && ($avaya_call->callstate == 'R') && ($avaya_call->calleddevice != $agent_id)) {
        
        $resp_data['m_no'] = $avaya_call->calleddevice;
        $resp_data['ext_no'] = $avaya_call->deviceid;
        $resp_data['CallUniqueID'] = $avaya_call->sessionuuid;
        $resp_data["mobile_no"] = $avaya_call->calleddevice;
        $resp_data["action"] = 'open_dialer';
        $resp_data["data_qr"] = "output_position=content&tool_code=mt_atnd_calls&m_no={$avaya_call->calleddevice}&ext_no={$avaya_call->deviceid}&CallUniqueID={$avaya_call->sessionuuid}";

        $resp_data = json_encode($resp_data);

        echo "id:".time() . PHP_EOL;
        echo "data:$resp_data" . PHP_EOL;
        echo PHP_EOL;
        
        file_put_contents('./logs/avaya_calls/'.$agent_id.'.json','');

    }

        while (ob_get_level() > 0) {
          ob_end_flush();
        }
        flush();
//    ob_flush();
//    flush();

    usleep(0250000);
	//break;

}
