<?php include('../function/function.php');?>

<!-- Page Header -->
<div class="content-header">
	<!-- <div class="container-fluid">
	  <div class="row mb-2">
	    <div class="col-sm-6">
	      <h1 class="m-0 text-dark">VIEW PLATFORM</h1>
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
		              <h3 class="card-title"><b>View Platform</b></h3>
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
			                  <th>LOGO</th>
			                  <th>Name</th>
			                  <th>Link</th>
			                  <th>Status</th>
			                  <th>Action</th>
			                </tr>
		                </thead>
		                <tbody id="load-record">
		           			<tr>
			                  <td colspan="6"><b>LOADING...</b></td>
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
	$(document).ready(function(){
		LoadPlatform(1);
	});

function LoadPlatform(pageNo){
	var sendData = {
		pageNo: pageNo,
		action: "view-platform"
	};
	
	$.ajax({
		url: 'api-platform.php',
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


<script>
  //DYNAMIC SEARCH
	$("#dy-search").keyup(function(){
		//console.log($(this).val());
		var sendData = {
			search_key: $(this).val(),
			action: "search-platform"
		};

		$.ajax({
			url: "api-platform.php",
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