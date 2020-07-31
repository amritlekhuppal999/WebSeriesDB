<?php include('../function/function.php');?>

<!-- Page Header -->
<div class="content-header">
	<div class="container-fluid">
	  <div class="row mb-2">
	    <div class="col-sm-6">
	      <h1 class="m-0 text-dark">ADD EPISODES</h1>
	    </div>
	  </div>
	</div>
</div>

<section>
	<!--Series & Season selection Tab-->
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

							<!-- SELECT SEASON-->
							<div class="col-md-3" id="load-season">
								
							</div>

							<div class="col-md-3" id="add-btn" style="display:none;">
								<label>Add Episode</label>
								<div class="form-group">
									<a href="#" class="btn btn-primary" id="add-new-ep">Add New</a>
								</div>
							</div>

						</div>
					</div>

				</div>
			</div>

		</div>
	</div>

	<!-- Load form here -->
	<div id="load-form">
		
	</div>

</section>

<script>
	var globData = {
		series_id: "", series_name: "", season_name: "",
		season_id: "", action: "load-episode-form"
	};

	$("#ser_id").change(function(){
		var sendData = {
			series_id : $(this).val(),
			series_name : $("#ser_id option:selected").html(),
			action: "get-season"
		}
		globData.series_id = sendData.series_id;
		globData.series_name = sendData.series_name;

		//Hide Episode form and add button.
		$("#ep-form").hide();
		$("#add-btn").hide();
		
		$.ajax({
			url: "api-episode.php",
			type: "POST",
			data: sendData,
			dataType: "JSON",
			encoding: true,
			success: function(response){
						$("#load-season").html(response.dat);
					 }
		});
	});

	//Some JS is in the api page.

	$("#add-new-ep").click(function(){

		$.ajax({
			url: "api-episode.php",
			type: "POST",
			data: globData,
			dataType: "JSON",
			encoding: true,
			success: function(response){
						//console.log(response.msg);
						$("#load-form").html(response.dat);
					 }
		});
		
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

  	//Timepicker
    // $("#timepicker").datetimepicker({
    //   format: "LT"
    // })
})
</script>