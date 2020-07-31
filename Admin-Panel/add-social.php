<?php include('../function/function.php');?>

<!-- Page Header -->
<div class="content-header">
	<div class="container-fluid">
	  <div class="row mb-2">
	    <div class="col-sm-6">
	      <h1 class="m-0 text-dark">Add Social Accounts</h1>
	    </div>
	  </div>
	</div>
</div>


<section class="content">
	<div class="container-fluid"> 
		<div class="row">
			<div class="col-md-12">
				<div class="card card-default">
					
					<!--Card Body-->
					<div class="card-body">
						<div class="row">

							<!-- Select Category-->
							<div class="col-md-6">
								<label>Select Category</label>
								<select class="form-control select2" style="width: 100%;" id="category">
				                    <option value="0">Select</option>
				                    <option value="1">Series</option>
				                    <option value="2">Actor</option>
				                    <option value="3">Director</option>
				                    <option value="4">Writer</option>
				                    <option value="5">Producer</option>
				                    <option value="6">Platform</option>
		                		</select>
		                	</div>

		                	<!-- Load Category-->
							<div id="load-data"></div>

						</div>
					</div>

					<!-- Rest of the Form -->
					<div id="load-form"></div>
				
				</div>
			</div>

		</div>
	</div>
</section>

<script>

	//RestSpace("#name");
	//RestSpace("#email");


	$("#category").change(function(){
		//alert($("#category option:selected").text());
		
		var opData = { 
			cate_val: $(this).val(),
			cate_text: $("#category option:selected").text(),
			task: "add",
			action: "get-cate-data" 
		}

		$.ajax({
			url: "api-social.php",
			type: "POST",
			data: opData,
			dataType: "JSON",
			encoding: true,
			success: function(response){
						//alert(response.msg);
						$("#load-form").html("");
						$("#load-data").html(response.dat);
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
	$(".select2").select2()

	//Initialize Select2 Elements
	$(".select2bs4").select2({
	  theme: "bootstrap4"
	})

  //Datemask dd/mm/yyyy
  $("#datemask").inputmask("dd/mm/yyyy", { "placeholder": "dd/mm/yyyy" });
  //Datemask2 mm/dd/yyyy
  $("#datemask2").inputmask("mm/dd/yyyy", { "placeholder": "mm/dd/yyyy"});

  //Date mask & Money Euro
  $("[data-mask]").inputmask()
});
</script>