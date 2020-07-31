<?php include('../function/function.php');?>

<!-- Page Header -->
<div class="content-header">
	<div class="container-fluid">
	  <div class="row mb-2">
	    <div class="col-sm-6">
	      <h1 class="m-0 text-dark">VIEW EPISODES</h1>
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

							<!-- <div class="col-md-3" id="add-btn" style="display:none;">
								<label>Add Episode</label>
								<div class="form-group">
									<a href="#" class="btn btn-primary" id="show-ep">View All</a>
								</div>
							</div> -->

							


						</div>
					</div>

				</div>
			</div>

		</div>
	</div>

	<!--Data Table-->
	<div class="container-fluid" id="dat-table">
		<div class="row">
			<div class="col-md-12">
				<div class="card">

					<!--Card Header-->
		            <div class="card-header">
		              <h3 class="card-title">
		              	<span id="ser_sea"></span>
		              </h3>
		              <div class="card-tools">
		              	  <div class="input-group input-group-sm" style="width: 350px;">
		                    <input type="text" name="table_search" class="form-control float-left" placeholder="Search by Title" id="dy-search">
		                  </div>		
		              </div>
		            </div>
		            
		            <!--Card Body-->
		            <div class="card-body">
		              <!--Table-->
		              <table id="example1" class="table table-bordered table-striped text-center">
		                <thead>
			                <tr>
			                  <th>S.no</th>
			                  <!-- <th>POSTER</th> -->
			                  <th>Ep Title</th>
			                  <th>Trailer</th>
			                  <th>Status</th>
			                  <th>Action</th>
			                </tr>
		                </thead>
		                <tbody id="load-record">
		           			<tr>
			                  <td colspan="5">Select series & season.</td>
			                </tr>
			            </tbody>
		              </table>
		            </div>
		            
	            </div>
			</div>

		</div>
	</div>

	<!-- Button trigger modal -->
	<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
	  Launch demo modal
	</button> -->

	<!-- Update Form (Modal) -->
	<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <!-- CLOSE BTN -->
	      <button style="display: none;" type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
	      <!-- BODY -->
	      <div class="modal-body" id="update-form">
	        ...
	      </div>
	    </div>
	  </div>
	</div>

</section>

<script>
	var globData = {
		series_id: "", series_name: "", season_name: "",
		season_id: "", action: "view-episode"
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

	//Search
	$("#dy-search").keyup(function(){
		//console.log($(this).val());
		var sendData = {
			series_id: globData.series_id,
			season_id: globData.season_id,
			series_name: globData.series_name,
			season_name: globData.season_name,
			search_key: $(this).val(),
			action: "search-episode"
		};

		$.ajax({
			url: "api-episode.php",
			type: "POST",
			data: sendData,
			dataType: "JSON",
			encoding: true,
			success: function(response){
						//alert(response.msg);
						$("#load-record").html(response.dat);
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
