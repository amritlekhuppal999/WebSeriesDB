<?php include('../function/function.php');?>

<!-- Page Header -->
<div class="content-header">
	<!-- <div class="container-fluid">
	  <div class="row mb-2">
	    <div class="col-sm-6">
	      <h1 class="m-0 text-dark">VIEW SERIES</h1>
	    </div>
	  </div>
	</div> -->
</div>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">

				<div class="card">

					<!--Card Header-->
		            <div class="card-header">
		              <h3 class="card-title"><b>VIEW SERIES</b></h3>

		              <div class="card-tools">

		              	  <div class="input-group input-group-sm" style="width: 350px;">
		                    <input type="text" name="table_search" class="form-control float-left" placeholder="Search by Title" id="dy-search">

		                    <!-- <div class="input-group-append">
		                       	<button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
		                    </div> -->
		                  </div>		
		              </div>
		            </div>
		            
		            <!--RESULT LIST BODY-->
		            <div class="card-body">
		              <!--Table-->
		              <table id="example1" class="table table-bordered table-striped text-center">
		                <thead>
			                <tr>
			                  <th>S.no</th>
			                  <th>Title</th>
			                  <th>Trailer</th>
			                  <th>Certificate</th>
			                  <th>IMDB</th>
			                  <th>Status</th>
			                  <th>Action</th>
			                </tr>
		                </thead>
		                <tbody id="load-record">
		           			<tr>
			                  <td colspan="7">LOADING....</td>
			                </tr>
			            </tbody>
		              </table>
		            </div>
		            
		            <!-- Card Footer -->
		            <div class="card-footer">
		            	<div class="row">
		            		<!-- PAGINATION -->
		            		<div class="col-md-10">
				              	<div id="load-pagn"></div>	
				            </div>

				            <!-- Records Per Page -->
				            <!-- <div class="col-md-2">
				            	<select id="rpp" class="custom-select" title="records per page">
				            		<option value="2">2</option>
					              	<option value="4">4</option>
					              	<option value="10">10</option>
					              	<option value="25">25</option>
					              	<option value="100">100</option>
					            </select>
				            </div> -->
		            	</div>
		            </div>

	            </div>
			</div>

		</div>
	</div>

	<!-- LOAD UPDATE FORM -->
	<div id="load-sect"></div>

</section>

<script>
	$(document).ready(function(){
		LoadSeries(1);
	});

	// $(".pageNo").click(function(){
	// 	//alert($(this).data("page-no"));
	// 	LoadSeries($(this).data("page-no"));
	// });

	// $("#rpp").change(function(){
	// 	LoadSeries(1, $("#rpp").val());
	// });

function LoadSeries(pageNo){
	var sendData = { 
		pageNo: pageNo,
		//rpp: rpp,
		action: "view-series"
	};
	
	$.ajax({
		url: 'api-series.php',
		type: 'POST',
		data: sendData,
		dataType: 'JSON',
		encoding: true,
		success: function(response){
					//alert(response.msg);
					$("#load-record").html(response.dat);
					$("#load-pagn").html(response.pagn);
				 }
	});
}
</script>

<!-- DYNAMIC SEARCH -->
<script>
	//Search
	$("#dy-search").keyup(function(){
		//console.log($(this).val());
		var sendData = {
			search_key: $(this).val(),
			action: "search-series"
		};

		$.ajax({
			url: "api-series.php",
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