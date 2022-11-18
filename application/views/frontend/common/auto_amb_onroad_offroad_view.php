<?php

$thl = array('dst_code' => $dst_code, 'auto' => $auto, 'rel' => $dt_rel,'amb_type'=>$amb_type);

//var_dump($thl);

echo get_onroad_offroad_ambulance($thl);

?>


