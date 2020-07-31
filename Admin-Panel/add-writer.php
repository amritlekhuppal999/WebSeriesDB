<?php include('../function/function.php');?>
<!-- Page Header -->
<div class="content-header">
	<div class="container-fluid">
	  <div class="row mb-2">
	    <div class="col-sm-6">
	      <h1 class="m-0 text-dark">ADD WRITER</h1>
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
				
				<!-- Writer Name -->
				<div class="col-md-6">
					<div class="form-group">
						<label>Writer Name</label>
						<input type="text" name="name" id="name" class="form-control" placeholder="Writer Name">
					</div>
				</div>

				<!-- Display Picture -->
				<div class="col-md-2">
				  	<div class="form-group">
		              <label for="exampleInputFile">Display Picture</label>
		              <div class="input-group">
		                <div class="custom-file">
		                  <input type="file" name="dp" class="custom-file-input" id="dp">
		                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
		                </div>
		              </div>
		            </div>
				</div>

				<!-- Gender -->
				<div class="col-md-2">
					<label>Gender</label>
					<select class="form-control" id="gender">
						<!-- <option value="0">Select</option> -->
					<?php $gen = Gender();
					foreach($gen as $key => $val){?> 
						<option value="<?php echo $key;?>"><?php echo $val;?></option>
					<?php }?>
					</select>
				</div>

				<!-- DOB -->
				<div class="col-md-2">
					<div class="form-group">
	                  <label>Date of Birth</label>
	                  <div class="input-group">
	                    <div class="input-group-prepend">
	                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
	                    </div>
	                    <input id="dob" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
	                  </div>
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
	RestSpace("#description");

	$("#submit").click(function(){
		//alert("submit");
		var name = $("#name").val();
		
		if(name == ''){
			$("#name").focus();
			return false;
		}

		var formData = new FormData();
		var dp = $("#dp")[0].files[0];
		formData.append('img', dp);

		formData.append('name', name);
		formData.append('gender', $("#gender").val());
		formData.append('about', $("#about").val());
		formData.append('dob', $("#dob").val());
		formData.append('action', 'add-writer');

		$.ajax({
			url: 'api-writer.php',
			type: 'POST',
			data: formData,
			dataType: 'JSON',
			encoding: true,
			contentType: false,
			processData: false,
			success: function(response){
						//alert(response.msg);
						if(response.dat == 1){
							alert("Writer Added.");
							$("#add-writer").click();
						}else{ alert("Error adding writer.");}
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