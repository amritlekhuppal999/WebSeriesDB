<?php include('../function/function.php');?>

<!-- Page Header -->
<div class="content-header">
	<!-- <div class="container-fluid">
	  <div class="row mb-2">
	    <div class="col-sm-6">
	      <h1 class="m-0 text-dark">VIEW PRODUCERS</h1>
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
		              <h3 class="card-title"><b>View Producer</b></h3>
		              <div class="card-tools">
		              	  <div class="input-group input-group-sm" style="width: 350px;">
		                    <input type="text" name="table_search" class="form-control float-left" placeholder="Search by Name" id="dy-search">
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
			                  <th>DP</th>
			                  <th>Name</th>
			                  <th>Gender</th>
			                  <th>DOB</th>
			                  <th>Status</th>
			                  <th>Action</th>
			                </tr>
		                </thead>
		                <tbody id="load-record">
		           			<tr>
			                  <td colspan="7">Loading...</td>
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

	<div id="load-sect"></div>

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
	$(document).ready(function(){
		ViewProducers(1);
	});

	// $(".pageNo").click(function(){
	// 	//alert($(this).data("page-no"));
	// 	LoadSeries($(this).data("page-no"));
	// });
	
function ViewProducers(pageNo){
	var sentData = {
		pageNo: pageNo,
		action : "view-producer",
	}
		
	$.ajax({
		url: 'api-producer.php',
		type: 'POST',
		data: sentData,
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
			action: "search-producer"
		};

		$.ajax({
			url: "api-producer.php",
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