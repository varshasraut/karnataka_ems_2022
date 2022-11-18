Redirecting............
<script>
    sessionStorage.setItem('clg_group', '<?php echo $clg_group; ?>'); 
    sessionStorage.setItem('avaya_agentid', '<?php echo $clg_avaya_agentid; ?>');
    
    sessionStorage.setItem('last_login_ext', '<?php echo $ext_no; ?>'); 
    sessionStorage.setItem('clg_details', '<?php echo $ref_id_encode; ?>');
    window.location = base_url+'dash';
</script>