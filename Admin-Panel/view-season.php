<?php include('../function/function.php');?>

<!-- Page Header -->
<div class="content-header">
	<!-- <div class="container-fluid">
	  <div class="row mb-2">
	    <div class="col-sm-6">
	      <h1 class="m-0 text-dark">VIEW SEASONS</h1>
	    </div>
	  </div>
	</div> -->
</div>


<section class="content">

	<div class="container-fluid">
		<div class="card">
			
			<!--Card Header-->
			<div class="card-header">
				<h3 class="card-title"><b>VIEW SEASONS</b></h3>	
			</div>

			<!--Card Body-->
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<label>Select Series</label>
						<select class="select2 form-control" id="sel_ser">
							<option value="0">Select</option>
				<?php record_set('getSer','SELECT id, title FROM `series_list` WHERE status=1');
                	  if($totalRows_getSer){
                		while($rowData = mysqli_fetch_assoc($getSer)){ ?>
                			<option value="<?php echo $rowData["id"];?>"><?php echo $rowData["title"];?></option>
                <?php }}?>
						</select>
					</div>
				</div>
			</div>

		</div>
	</div>


	<div class="container-fluid" id="dat-table" style="display: none;">
		<div class="row">
			<div class="col-md-12">
				<div class="card">

					<!--Card Header-->
		            <div class="card-header">
		              	<h3 class="card-title"><b>Season List</b></h3>
		              	<div class="card-tools">
		              	  <div class="input-group input-group-sm" style="width: 350px;">
		                    <input type="text" name="table_search" class="form-control float-left" placeholder="Search by Name" id="dy-search">

		                    <!-- <div class="input-group-append">
		                       	<button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
		                    </div> -->
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
			                  <th>POSTER</th>
			                  <th>Name</th>
			                  <th>Trailer</th>
			                  <th>Status</th>
			                  <th>Action</th>
			                </tr>
		                </thead>
		                <tbody id="load-record">
		           			<tr>
			                  <td>S.no</td>
			                  <td>POSTER</td>
			                  <td>Name</td>
			                  <td>Trailer</td>
			                  <td>Status</td>
			                  <td>Action</td>
			                </tr>
			            </tbody>
		              </table>
		            </div>
		            
		            <!-- Table Footer -->
		            <div class="card-footer">
		            	<div class="row">
		            		<!-- PAGINATION -->
		            		<div class="col-md-10">
				              	<div id="load-pagn"></div>	
				            </div>
				        </div>
		            </div>

	            </div>
			</div>

		</div>
	</div>

	<div id="load-sect">
		
	</div>
</section>

<script>
	var series_id;
	//LOAD SEASON
	$("#sel_ser").change(function(){
		var sendData = {
			series_id: $(this).val(),
			action: "view-seasons"
			//ser_key: ""
		};
		$("#dat-table").show();
		series_id = $(this).val();

		$.ajax({
			url: "api-season.php",
			type: "POST",
			data: sendData,
			dataType: 'JSON',
			encoding: true,
			success: function(response){
						//alert(response.msg);
						$("#load-record").html(response.dat);
					 }
		});
	});

	//DYNAMIC SEARCH 
	$("#dy-search").keyup(function(){
		//console.log($(this).val());
		var sendData = {
			series_id: series_id,
			search_key: $(this).val(),
			action: "search-seasons"
		};

		$.ajax({
			url: "api-season.php",
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
  $(function () {
    //Initialize Select2 Elements
	$(".select2").select2()

	//Initialize Select2 Elements
	$(".select2bs4").select2({
	  theme: "bootstrap4"
	})

  });
</script>