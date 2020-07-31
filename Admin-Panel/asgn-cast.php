<?php include('../function/function.php');?>
<!-- Page Header -->
<div class="content-header">
	<div class="container-fluid">
	  <div class="row mb-2">
	    <div class="col-sm-6">
	      <h1 class="m-0 text-dark">ASSIGN CAST</h1>
	    </div>
	  </div>
	</div>
</div>



<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-default">
					
					<!--Form Start-->
					<form enctype="multipart/form-data">

					<!-- Card Header -->
					<div class="card-header">
						<h3 class="card-title">Assign Cast</h3>
					</div>

		<!--Card Body-->
		<div class="card-body">
			<div class="row">
				
	<div class="col-md-12">
		<!-- <h4>Assign Cast</h4> -->
		<ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
			<li class="nav-item">
            	<a class="nav-link active" 
            	 id="custom-content-below-actors-tab" 
            	 data-toggle="pill" 
            	 href="#custom-content-below-actors" role="tab" 
            	 aria-controls="custom-content-below-actors" 
            	 aria-selected="true">Actors</a>
            </li>
            <li class="nav-item">
            	<a class="nav-link"
            	 id="custom-content-below-directors-tab" 
            	 data-toggle="pill" 
            	 href="#custom-content-below-directors" role="tab" 
            	 aria-controls="custom-content-below-directors" 
            	 aria-selected="false">Directors</a>
          	</li>
          	<li class="nav-item">
            	<a class="nav-link" 
            	 id="custom-content-below-platforms-tab" 
            	 data-toggle="pill" 
            	 href="#custom-content-below-platforms" role="tab" 
            	 aria-controls="custom-content-below-platforms"
            	 aria-selected="false">Platforms</a>
            </li>
		</ul> 

		<div class="tab-content" id="custom-content-below-tabContent">
			<!-- ACTORS -->
			<div class="tab-pane fade show active" id="custom-content-below-actors" role="tabpanel" aria-labelledby="custom-content-below-actors-tab">
     			<style>
					.ser-div{ max-height:200px; width: 97%;
						background-color:white;
						overflow-y: auto;
						position: absolute;
						z-index: 1;
					}
				</style>
     			<br /> 
     			<form enctype="multipart/form-data">
	     			<div class="row">
	     				<div class="col-md-6">
	     					<input class="form-control" type="text" name="act-ser" id="act-ser" placeholder="Search Actor">
	     					<div class="ser-div" id="act-load">
	     						
	     					</div>
	     				</div> 
	     				<!-- <div class="col-md-6">
	     					<button class="btn btn-primary">Submit</button>
	     				</div> -->
	     				
			<div class="col-md-12">
			    <!-- checkbox -->
                <div class="form-group">
	                <div class="custom-control custom-checkbox">
	                  <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="option1">
	                  <label for="customCheckbox1" class="custom-control-label">Custom Checkbox</label>
	                </div>
	                <div class="custom-control custom-checkbox">
	                  <input class="custom-control-input" type="checkbox" id="customCheckbox2" checked>
	                  <label for="customCheckbox2" class="custom-control-label">Custom Checkbox checked</label>
	                </div>
	            </div>
			</div>
	     			</div>
		     	</form>
	     	</div>

	     	<!-- DIRECTORS -->
  			<div class="tab-pane fade" id="custom-content-below-directors" role="tabpanel" aria-labelledby="custom-content-below-directors-tab">
     			
     			<br /> 
     			<form enctype="multipart/form-data">
	     			<div class="row">
	     				<div class="col-md-6">
	     					<input class="form-control" type="text" name="dirct-ser" id="dirct-ser" placeholder="Search Director">
	     					<div class="ser-div" id="dirct-load">
	     						
	     					</div>
	     				</div> 
	     				<!-- <div class="col-md-6">
	     					<button class="btn btn-primary">Submit</button>
	     				</div> -->
	     			</div>
		     	</form>
  			</div>

  			<!-- PLATFORMS -->
  			<div class="tab-pane fade" id="custom-content-below-platforms" role="tabpanel" aria-labelledby="custom-content-below-platforms-tab">
     			
     			<br /> 
     			<form enctype="multipart/form-data">
	     			<div class="row">
	     				<div class="col-md-6">
	     					<input class="form-control" type="text" name="plat-ser" id="plat-ser" placeholder="Search Platform">
	     					<div class="ser-div" id="plat-load">
	     						
	     					</div>
	     				</div> 
	     				<!-- <div class="col-md-6">
	     					<button class="btn btn-primary">Submit</button>
	     				</div> -->
	     			</div>
		     	</form>
  			</div>

		</div>
	</div>
			</div>
		</div>

						<!-- Card Footer -->
						<div class="card-footer">
						  <a id="submit" class="btn btn-default">Submit</a>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</section>

<script>

	$("#act-ser").keyup(function(){
		LoadCast($(this).val(), "list-actors", "#act-load");
	});
	$("#dirct-ser").keyup(function(){
		//LoadCast($(this).val(), "list-director", "#dirct-load");
	});
	$("#plat-ser").keyup(function(){
		//LoadCast($(this).val(), "list-platform", "#plat-load");
	});
	
//Search Result List for Actor/Director/Platform.//
function LoadCast(ser_key, action, retPos){
	if(ser_key == ""){
		return false;
	}
	var formData = { search: ser_key, action: action };
	$.ajax({
		url: "api.php",
		type: "POST",
		data: formData,
		dataType: "JSON",
		encryption: true,
		success: function(response){
					//alert(response.msg);
					$(retPos).html(response.dat);
			}
	});
}

//Restricting Blank Space as first char.
// function RestSpace(field_id){  
// 	$(field_id).keyup(function(){
// 		var f_value = $(field_id).val();
// 		if(f_value[0] === ' '){
// 			$(field_id).val('');
// 			return false;
// 		}
// 	});
// }

/* Convert select to array with values */    
// function SelectArray(select){ //serealizeSelects(select) 
//     var array = [];
//     select.each(function(){ array.push($(this).val()) });
//     return array;
// }

</script>

<script>
$(function () {
	//Initialize Select2 Elements
	$('.select2').select2()

	//Initialize Select2 Elements
	$('.select2bs4').select2({
	  theme: 'bootstrap4'
	})

  //Datemask dd/mm/yyyy
  $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
  //Datemask2 mm/dd/yyyy
  $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy'});

  //Date mask & Money Euro
  $('[data-mask]').inputmask()
});
</script>