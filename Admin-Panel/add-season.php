<?php include('../function/function.php');?>

<!-- Page Header -->
<div class="content-header">
	<div class="container-fluid">
	  <div class="row mb-2">
	    <div class="col-sm-6">
	      <h1 class="m-0 text-dark">ADD SEASONS</h1>
	    </div>
	  </div>
	</div>
</div>

<section>
	<div class="container-fluid"> 
		<div class="row">
			<div class="col-md-12">
				<div class="card card-default">
					
					<!--Card Body-->
					<div class="card-body">
						<div class="row">

							<!-- SELECT SERIES-->
							<div class="col-md-6">
								<label>Select Series</label>
								<select class="form-control select2" style="width: 100%;" id="ser_id">
				                    <option value="0">Select</option>
		                <?php record_set('getSer','SELECT id, title FROM `series_list` WHERE status=1');
		                	if($totalRows_getSer){
		                		while($rowData = mysqli_fetch_assoc($getSer)){ ?>
		                			<option value="<?php echo $rowData["id"];?>"><?php echo $rowData["title"];?></option>
		                <?php }}?>
				                </select>
							</div>

							<div class="col-md-6" id="load-seas">
								
							</div>


						</div>
					</div>

				</div>
			</div>

		</div>
	</div>

	<div id="load-here">
		
	</div>

</section>

<script>
	$("#ser_id").change(function(){
		
		var sendData = {
			ser_id: $(this).val(),
			action: "get-seasons"
		}
		//alert(sendData.ser_id);	
		$.ajax({
			url: "api-season.php",
			type: "POST",
			data: sendData,
			dataType: "JSON",
			encoding: true,
			success: function(response){
						//alert(response.msg);
						//$(response.dat).insertAfter("#sel_ser")
						$("#load-seas").html(response.dat);
					 }
		});
		// $.ajax({
		// 	url: "api.php",
		// 	type: "POST",
		// 	data: sendData,
		// 	dataType: "JSON",
		// 	encoding: true,
		// 	success: function(response){
		// 				//alert(response.msg);
		// 				$("#load-here").html(response.dat);
		// 				//console.log(response.dat);
		// 			 }
		// });
	});
</script>

<script>
$(function(){
	//Initialize Select2 Elements
	$(".select2").select2()

	//Initialize Select2 Elements
	$(".select2bs4").select2({
	  theme: "bootstrap4"
	})

	//Datemask dd/mm/yyyy
	$("#datemask").inputmask("dd/mm/yyyy", { "placeholder": "dd/mm/yyyy" })

	//Datemask2 mm/dd/yyyy
	$("#datemask2").inputmask("mm/dd/yyyy", { "placeholder": "mm/dd/yyyy" })

	//Date mask & Money Euro
  	$('[data-mask]').inputmask()
})
</script>