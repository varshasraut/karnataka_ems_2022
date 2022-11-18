
<table class="table table-bordered NHM_Dashboard_report" >
<tr>
    <th>Incident ID</th>
    <th>Ambulance No</th>
    <th>Status</th>
    <th>Assign Time</th>
    <th>Start From Base</th>
    <th>At Scene</th>
    <th>From Scene</th>
    <th>At Hospital</th>
    <th>Patient Handover</th>
    <th>Back To Base</th>
</tr>
<tr>
            <td><?php echo $inc_details[0]->inc_id; ?></td>                            
            <td><?php echo $inc_details[0]->amb_rto_register_no;  ?></td> 
            <td><?php if($inc_details[0]->parameter_count == '2'){
                echo 'Start From Base';
            }elseif($inc_details[0]->parameter_count == '3'){
            echo 'At Scene';
            }elseif($inc_details[0]->parameter_count == '4'){
            echo 'From Scene';
            }elseif($inc_details[0]->parameter_count == '5'){
            echo 'At Hospital';
            }elseif($inc_details[0]->parameter_count == '6'){
            echo 'Patient Handover';
            }elseif($inc_details[0]->parameter_count == '7'){
            echo 'Back To Base';
            }else{
            echo 'Call Assigned';
            }  ?></td> 
            <td><?php echo $inc_details[0]->assigned_time; ?></td> 
            <td><?php echo $inc_details[0]->start_from_base_loc; ?></td> 
            <td><?php echo $inc_details[0]->at_scene; ?></td> 
            <td><?php echo $inc_details[0]->from_scene; ?></td> 
            <td><?php echo $inc_details[0]->at_hospital; ?></td> 
            <td><?php echo $inc_details[0]->patient_handover; ?></td> 
            <td><?php echo $inc_details[0]->back_to_base_loc; ?></td> 
</tr>
</table>
