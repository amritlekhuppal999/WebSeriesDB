<?php include('../function/function.php');?>
<!-- Page Header -->
<div class="content-header">
	<div class="container-fluid">
	  <div class="row mb-2">
	    <div class="col-sm-6">
	      <h1 class="m-0 text-dark">ADD PLATFORM</h1>
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
					<!-- <div class="card-header"></div> -->

		<!--Card Body-->
		<div class="card-body">
			<div class="row">
				
				<!-- Platform Name -->
				<div class="col-md-6">
					<div class="form-group">
						<label>Platform Name</label>
						<input type="text" name="name" id="name" class="form-control" placeholder="Platform Name">
					</div>
				</div>

				<!-- Platform Logo -->
				<div class="col-md-6">
				  	<div class="form-group">
		              <label for="exampleInputFile">Platform Logo</label>
		              <div class="input-group">
		                <div class="custom-file">
		                  <input type="file" name="dp" class="custom-file-input" id="dp">
		                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
		                </div>
		              </div>
		            </div>
				</div>

				<!-- Platform URL -->
				<div class="col-md-6">
					<div class="form-group">
						<label>Platform URL</label>
						<input type="text" name="plat_url" id="plat_url" class="form-control" placeholder="Platform URL">
					</div>
				</div>

				<!-- About -->
				<div class="col-md-12">
					<div class="form-group">
						<label>About</label>
						<textarea rows="4" name="about" id="about" class="form-control" placeholder="About..."></textarea>
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

	RestSpace("#name");
	//RestSpace("#real_name");
	//RestSpace("#description");

	$("#submit").click(function(){
		//alert("submit");
		var name = $("#name").val();
		var plat_url = $("#plat_url").val();
		var about = $("#about").val();
		//alert(name+' '+plat_url+' '+about);

		if(name == ''){
			$("#name").focus();
			return false;
		}

		var formData = new FormData();
		var dp = $("#dp")[0].files[0];
		formData.append('img',dp);

		formData.append('name', name);
		formData.append('plat_url', plat_url);
		formData.append('about', about);
		formData.append('action', 'add-platform');

		$.ajax({
			url: 'api-platform.php',
			type: 'POST',
			data: formData,
			dataType: 'JSON',
			encoding: true,
			contentType: false,
			processData: false,
			success: function(response){
						//alert(response.msg);
						if(response.dat == 1){
							alert("Platform Added.");
							$("#add-platforms").click();
						}else{ alert("Error adding platform.");}
					}
		});
	});

//Restricting Blank Space as first char.
function RestSpace(field_id){  
	$(field_id).keyup(function(){
		var f_value = $(field_id).val();
		if(f_value[0] === ' '){
			$(field_id).val('');
			return false;
		}
	});
}

/* Convert select to array with values */    
// function SelectArray(select){ //serealizeSelects(select) 
//     var array = [];
//     select.each(function(){ array.push($(this).val()) });
//     return array;
// }

</script>

<!--isko hatana hai-->
<script>
	// $(function () {
	// 	//Initialize Select2 Elements
	// 	$('.select2').select2()

	// 	//Initialize Select2 Elements
	// 	$('.select2bs4').select2({
	// 	  theme: 'bootstrap4'
	// 	})

	//   //Datemask dd/mm/yyyy
	//   $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
	//   //Datemask2 mm/dd/yyyy
	//   $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy'});

	//   //Date mask & Money Euro
	//   $('[data-mask]').inputmask()
	// });
</script>