<!-- CSS Link --->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.bootstrap.min.css">
<!-- JS Link --->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
   function display_image(src, width, height, alt) {
       alert(src);
    var a = document.createElement("img");
    a.src = src;
    a.width = width;
    a.height = height;
    a.alt = alt;
    document.body.appendChild(a);
}
$(document).ready(function() {
	//Only needed for the filename of export files.
	//Normally set in the title tag of your page.
	document.title='Emergency Medical Service';
	// DataTable initialisation
	$('#example').DataTable(
	{
			"dom": '<"dt-buttons"Bf><"clear">lirtp',
			"paging": false,
			"autoWidth": true,
			"columnDefs": [
				{ "orderable": false, "targets": 7 }
			],
			"buttons": [
				'colvis',
				'copyHtml5',
        'csvHtml5',
				'excelHtml5',
        'pdfHtml5',
				'print'
			]
	}
);
//Upload Invoice
$('.dt-upload-invoice').each(function () {
		$(this).on('click', function(evt){
      $this = $(this);
			var dtRow = $this.parents('tr');
			var mt_id = dtRow[0].cells[0].innerHTML;
      document.getElementsByName('mt_id_inc')[0].value = mt_id;  
    $('#Invoice_Modal').modal('show');
    $('#Job_Card_Modal').modal('hide');
    $('#myModal').modal('hide');


});
});
//Upload Job Card
$('.dt-upload-job-card').each(function () {
	$(this).on('click', function(evt){
    $this = $(this);
			var dtRow = $this.parents('tr');
			var mt_id = dtRow[0].cells[0].innerHTML;
      document.getElementsByName('mt_id_job')[0].value = mt_id;  
  $('#Job_Card_Modal').modal('show');
  $('#Invoice_Modal').modal('hide');
  $('#myModal').modal('hide');



});
});
//View Info
$('.dt-upload').each(function () {
		$(this).on('click', function(evt){
			$this = $(this);
			var dtRow = $this.parents('tr');
			$('div.modal-body').innerHTML='';
			var mt_id = dtRow[0].cells[0].innerHTML;
            $.post('<?=site_url('ambulance_maintaince/Breakdown_maintaince_view_new')?>',{mt_id},function(data){
                var new_var = JSON.parse(data);
                //alert(new_var.media[0].media_name);
                var media = '';
                $.each(new_var.media,function(){
                    path='<?=base_url('uploads/ambulance/')?>'+this.media_name;
                    media = media+'<img src="'+path+'" alt="" style="width:200px; height:auto;">';
                });
                var vendor_job_card = '';
                $.each(new_var.vendor_job_card,function(){
                    path='<?=base_url('uploads/ambulance/')?>'+this.media_name;
                    vendor_job_card = vendor_job_card+'<img src="'+path+'" alt="" style="width:200px; height:auto;">';
                });
                var vendor_invoice = '';
                $.each(new_var.vendor_invoice,function(){
                    path='<?=base_url('uploads/ambulance/')?>'+this.media_name;
                    vendor_invoice = vendor_invoice+'<img src="'+path+'" alt="" style="width:200px; height:auto;">';
                });

                var raw = '<table class="table table-bordered list_table_amb" id="myTable" style="text-align: left;">'+
                            '<thead class="" style="">'+
                            '<tr class="table-active">'+
                            '<th scope="col">Feild Lable</th>'+
                            '<th scope="col">Value</th>'+
                            '</tr>'+
                            '</thead>'+
                            '<tbody class="" style="">'+
                            
                            '<tr class="table-active">'+
                            '<td scope="col">Media</td>'+
                            '<td scope="col">'+ media +
                            '</tr>'+
                            '<tr class="table-active">'+
                            '<td scope="col">Job Card</td>'+
                            '<td scope="col">'+ vendor_job_card +
                            '</tr>'+
                            '<tr class="table-active">'+
                            '<td scope="col">Other</td>'+
                            '<td scope="col">'+ vendor_invoice +
                            '</tr>'+
                            '</tbody>'+
                    '</table>';
                    $('div.modal-body').append(raw);
            });
			$('#myModal').modal('show');
		});
});
//View row buttons
$('.dt-view').each(function () {
		$(this).on('click', function(evt){
			$this = $(this);
			var dtRow = $this.parents('tr');
			$('div.tableview').innerHTML='';
			var mt_id = dtRow[0].cells[0].innerHTML;
            $.post('<?=site_url('ambulance_maintaince/Breakdown_maintaince_view_new')?>',{mt_id},function(data){
                var new_var = JSON.parse(data);
                //alert(new_var.media[0].media_name);
                var media = '';
                $.each(new_var.media,function(){
                    path='<?=base_url('uploads/ambulance/')?>'+this.media_name;
                    media = media+'<img src="'+path+'" alt="" style="width:200px; height:auto;">';
                });
                var vendor_job_card = '';
                $.each(new_var.vendor_job_card,function(){
                    path='<?=base_url('uploads/ambulance/')?>'+this.media_name;
                    vendor_job_card = vendor_job_card+'<img src="'+path+'" alt="" style="width:200px; height:auto;">';
                });
                var vendor_invoice = '';
                $.each(new_var.vendor_invoice,function(){
                    path='<?=base_url('uploads/ambulance/')?>'+this.media_name;
                    vendor_invoice = vendor_invoice+'<img src="'+path+'" alt="" style="width:200px; height:auto;">';
                });

                var raw = '<table class="table table-bordered list_table_amb" id="myTable" style="text-align: left;">'+
                            '<thead class="" style="">'+
                            '<tr class="table-active">'+
                            '<th scope="col">Feild Lable</th>'+
                            '<th scope="col">Value</th>'+
                            '</tr>'+
                            '</thead>'+
                            '<tbody class="" style="">'+
                            '<tr class="table-active">'+
                            '<td scope="col">Breakdown ID</td>'+
                            '<td scope="col">'+ dtRow[0].cells[1].innerHTML +'</td>'+
                            '</tr>'+
                            '<tr class="table-active">'+
                            '<td scope="col">Ambulance Number</td>'+
                            '<td scope="col">'+ dtRow[0].cells[3].innerHTML +'</td>'+
                            '</tr>'+
                            '</tr>'+
                            '<tr class="table-active">'+
                            '<td scope="col">District</td>'+
                            '<td scope="col">'+ dtRow[0].cells[2].innerHTML +'</td>'+
                            '</tr>'+
                            '<tr class="table-active">'+
                            '<td scope="col">Status</td>'+
                            '<td scope="col">'+ dtRow[0].cells[4].innerHTML +'</td>'+
                            '</tr>'+
                            '<tr class="table-active">'+
                            '<td scope="col">Added Date</td>'+
                            '<td scope="col">'+ dtRow[0].cells[5].innerHTML +'</td>'+
                            '</tr>'+
                            '<tr class="table-active">'+
                            '<td scope="col">Media</td>'+
                            '<td scope="col">'+ media +
                            '</tr>'+
                            '<tr class="table-active">'+
                            '<td scope="col">Job Card</td>'+
                            '<td scope="col" style="width: 100%;">'+ vendor_job_card +
                            '</tr>'+
                            '<tr class="table-active">'+
                            '<td scope="col">Other</td>'+
                            '<td scope="col" style="width: 100%;">'+ vendor_invoice +
                            '</tr>'+
                            '</tbody>'+
                    '</table>';
                    $('div.tableview').append(raw);
            });
			$('#myModal').modal('show');
      $('#Job_Card_Modal').modal('hide');
      $('#Invoice_Modal').modal('hide');


		});
});
//Delete buttons
	$('.dt-delete').each(function () {
		$(this).on('click', function(evt){
			$this = $(this);
			var dtRow = $this.parents('tr');
			if(confirm("Are you sure to delete this row?")){
				var table = $('#example').DataTable();
				table.row(dtRow[0].rowIndex-1).remove().draw( false );
			}
		});
	});
	$('#myModal').on('hidden.bs.modal', function (evt) {
		$('.modal .tableview').empty();
	});
});
</script>
<style>
    body {margin:2em;}
    td:last-child {text-align:center;}
</style>
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
    <tr>
            <th>Id</th>
            <th>Generated Id</th>
            <th>District</th>
            <th>Ambulance Number</th>
            <th>Request Status</th>
            <th>Added by</th> 
            <th>Added Date</th> 
			<th style="text-align:center;width:200px;">Action</th>
		</tr>
	</thead>
	<tbody>
   
		
		
		<?php
        foreach ($maintance_data as $stat_data) { ?>
        
        <tr>
            <td><?php echo $stat_data->mt_id; ?></td> 
            <td><?php echo $stat_data->mt_breakdown_id; ?></td> 
            <td><?php echo $stat_data->dst_name; ?></td> 
            <td><?php echo $stat_data->mt_amb_no; ?></td>     
            <td><?php echo $stat_data->mt_ambulance_status; ?> </td> 
            <td><?php echo $stat_data->added_by; ?> </td> 
            <td><?php echo $stat_data->added_date; ?></td>
            <td>
				<button type="button" class="btn btn-primary btn-xs dt-view" alt="View Details"  title="View Details" style="margin-right:16px;">
					<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
				</button>
                <?php  if($stat_data->mt_ambulance_status == 'Pending for Job-card and Estimate'){
                    ?>
                    <button type="button" class="btn btn-danger btn-xs dt-upload-job-card" alt="Job-Card Upload"  title="Job-Card Upload" style="margin-right:16px;">
					<span class="glyphicon glyphicon-upload" aria-hidden="true"></span>
				</button>
                    <?php
                } ?>
                <?php if($stat_data->mt_ambulance_status == 'Pending for invoice upload by vendor'){
                    ?>
                    <button type="button" class="btn btn-danger btn-xs dt-upload-invoice" alt="Invoice / Bill Upload" title="Invoice / Bill Upload" style="margin-right:16px;">
					<span class="	glyphicon glyphicon-file  " aria-hidden="true"></span>
				</button>
                    <?php
               } ?>
				
			</td>
        </tr>
    <?php }  ?>
		
		
	</tbody>
</table>

<!-- Modal -->
<div id="myModal" class="modal fade"  role="dialog">
  <div class="modal-dialog" style="width:70%">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Breakdown Information</h4>
      </div>
      <div class="modal-body tableview">
     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- Job upload Modal -->
<div id="Job_Card_Modal" class="modal fade"  role="dialog">
<form enctype="multipart/form-data" action="<?php echo base_url(); ?>Ambulance_maintaince/upload_job_card" method="post" style="position: relative;">
  <div class="modal-dialog" style="width:70%">
  <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Job Card Information</h4>
    </div>
    <div class="modal-body">
      <div class="images_main_block width1" id="images_main_block">
          <div class="upload_images_block">
            <div class="images_upload_block job_card_upload">
              <input hidden id="mt_id_job" name="mt_id_job">
              <input multiple="multiple"   type="file" name="vendor_job_card[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"   class="files_amb_photo">
            </div>
          </div>
        </div>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-success"  >Submit</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </div>
  </div>
</form>
</div>


<!-- Invoce upload Modal -->
<div id="Invoice_Modal" class="modal fade"  role="dialog">
<form enctype="multipart/form-data" action="<?php echo base_url(); ?>Ambulance_maintaince/upload_invoice_bill" method="post"  style="position: relative;"  >
<div class="modal-dialog" style="width:70%">
<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title">Upload Invoice Photo</h4>
  </div>
  <div class="modal-body">
      <div class="images_main_block width1" id="images_main_block">
        <div class="upload_images_block">
          <div class="images_upload_block">
            <input hidden id="mt_id_inc" name="mt_id_inc">  
            <input multiple="multiple"  type="file" name="vendor_invoice[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"    class="files_amb_photo">
          </div>
        </div>
      </div>
               
  </div>
  <div class="modal-footer">
      <button type="submit" class="btn btn-success">Submit</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>
</div>
</form>
</div>
