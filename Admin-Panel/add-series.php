<?php include('../function/function.php');?>
<!-- Page Header -->
<div class="content-header">
	<!-- <div class="container-fluid">
	  <div class="row">
	    <div class="col-sm-6">
	      <h1 class=" text-dark">SERIES</h1>
	    </div>
	  </div>
	</div> -->
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
						<h3 class="card-title"><b>Add Series</b></h3>
					</div>

		<!--Card Body-->
		<div class="card-body">
			<div class="row">
				
				<!-- Title -->
				<div class="col-md-6">
					<div class="form-group">
						<label>Title</label>
						<input type="text" name="title" id="title" class="form-control" placeholder="Title">
					</div>
				</div>

				<!-- Genre -->
				<div class="col-md-6">
					<div class="form-group">
	                  <label>Genre</label>
	                  <select class="select2 genre" multiple="multiple" data-placeholder="Select Genre" id="genre" style="width: 100%;">
	                <?php $genre = Genres();
	                	foreach($genre as $key =>$val){?>
	                	<option value="<?php echo $key;?>"><?php echo $val;?></option>
	                <?php }?> 	
	                  </select>
	                </div>
				</div>

				<!-- Certificate -->
				<div class="col-md-3">
					<label>Certificate</label>
					<select class="form-control" id="certificate">
						<option value="0">Select</option>
					<?php $cert = sCertificate();
					foreach($cert as $key => $val){?> 
						<option value="<?php echo $key;?>"><?php echo $val;?></option>
					<?php }?>
					</select>
				</div>

				<!-- Release Date -->
				<div class="col-md-3">
					<div class="form-group">
	                  <label>Release Date</label>
	                  <div class="input-group">
	                    <div class="input-group-prepend">
	                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
	                    </div>
	                    <input id="rel-date" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
	                  </div>
	                </div>
				</div>

				<!-- Poster -->
				<div class="col-md-3">
				  	<div class="form-group">
		              <label for="exampleInputFile">POSTER</label>
		              <div class="input-group">
		                <div class="custom-file">
		                  <input type="file" name="poster" class="custom-file-input" id="poster">
		                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
		                </div>
		                <!-- <div class="input-group-append">
		                  <span class="input-group-text" id="">Upload</span>
		                </div> -->
		              </div>
		            </div>
				</div>

				<!-- IMDB -->
				<div class="col-md-3">
					<div class="form-group">
						<label>IMDB</label>
						<input type="number" name="imdb_rating" id="imdb_rating" class="form-control" placeholder="8.1">
					</div>
				</div>

				<!-- Rotten Tomatoes -->
				<!-- <div class="col-md-4">
					<div class="form-group">
						<label>Rotten Tomatoes</label>
						<input type="number" name="r_tomatoes" id="r_tomatoes" class="form-control" placeholder="5">
					</div>
				</div> -->

				<!-- Actors -->
				<div class="col-md-6">
					<div class="form-group">
	                  <label>Actors</label>
	                  <select class="select2 actors" multiple="multiple" data-placeholder="Select Actors" id="actor_ids" style="width: 100%;">
	    				<!-- <option value="0">SELECT</option> -->
	    			<?php record_set('getAct', 'SELECT id, name FROM `actor_list` WHERE status=1');
	    				if($totalRows_getAct){
	    					while($rowData = mysqli_fetch_assoc($getAct)){ ?>
	    				<option value="<?php echo $rowData["id"];?>"><?php echo $rowData["name"];?></option>	
	    			<?php }} ?>		
	                  </select>
	                </div>
				</div>

				<!-- Directors -->
				<div class="col-md-6">
					<div class="form-group">
	                  <label>Directors</label>
	                  <select class="select2 directors" multiple="multiple" data-placeholder="Select Directors" id="director_ids" style="width: 100%;">
	    				<!-- <option value="1">Director 1</option> -->
	    			<?php record_set('getDirct','SELECT id, name FROM `director_list` WHERE status=1');
	    				if($totalRows_getDirct){
	    				  while($rowData = mysqli_fetch_assoc($getDirct)){?>
	    				  <option value="<?php echo $rowData["id"];?>"><?php echo $rowData["name"];?></option>
	    			<?php }} ?>		
	                  </select>
	                </div>
				</div>

				<!-- Platform -->
				<div class="col-md-6">
					<div class="form-group">
	                  <label>Platform</label>
	                  <select class="select2 platforms" multiple="multiple" data-placeholder="Select Platform" id="platform_ids" style="width: 100%;">
	    				<!-- <option value="1">Platform 1</option> -->
	    			<?php record_set('getPlat','SELECT id, name FROM `platform` WHERE status=1');
	    				if($totalRows_getPlat){
	    					while($rowData = mysqli_fetch_assoc($getPlat)){?>
	    				<option value="<?php echo $rowData["id"];?>"><?php echo $rowData["name"];?></option>
	    			<?php }}?>		
	                  </select>
	                </div>
				</div>

				<!-- Trailer -->
				<div class="col-md-12">
					<div class="form-group">
						<label>Trailer</label>
						<input type="text" name="trailer" id="trailer" class="form-control" placeholder="trailer">
					</div>
				</div>

				<!-- Description -->
				<div class="col-md-12">
					<div class="form-group">
						<label>Description</label>
						<textarea rows="5" name="description" id="description" class="form-control" placeholder="decrip.."></textarea>
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

			<!-- <div class="col-md-6">
				<div class="card card-default">
					<div class="card-body">
						<h4>coming soon..</h4>
					</div>
				</div>
			</div> -->

		</div>
	</div>
</section>

<script>

	RestSpace("#title");
	RestSpace("#trailer");
	RestSpace("#description");

	$("#submit").click(function(){
		//alert("submit");
		var title = $("#title").val();
		var genre = JSON.stringify(SelectArray($(".genre")));
		var certificate = $("#certificate").val();
		var releaseDate = $("#rel-date").val();
		var imdb_rating = $("#imdb_rating").val();
		//var r_tomatoes = $("#r_tomatoes").val();
		var seasonCount = $("#seasonCount").val();
		var actor_ids = JSON.stringify(SelectArray($(".actors")));
		var director_ids = JSON.stringify(SelectArray($(".directors")));
		var platform_ids = JSON.stringify(SelectArray($(".platforms")));
		var trailer = $("#trailer").val();
		var description = $("#description").val();

		//alert(releaseDate); return false;

		if(title == ''){
			$("#title").focus();
			return false;
		}

		var formData = new FormData();
		var poster = $("#poster")[0].files[0];
		formData.append('img',poster);

		formData.append('title',title);
		formData.append('genre',genre);
		formData.append('certificate',certificate);
		formData.append('releaseDate',releaseDate);
		formData.append('imdb_rating',imdb_rating);
		//formData.append('r_tomatoes',r_tomatoes);
		formData.append('season_count',seasonCount);
		formData.append('actor_ids',actor_ids);
		formData.append('director_ids',director_ids);
		formData.append('platform_ids',platform_ids);
		formData.append('trailer',trailer);
		formData.append('description',description);
		formData.append('action','add-series');

		$.ajax({
			url: 'api-series.php',
			type: 'POST',
			data: formData,
			dataType: 'JSON',
			encoding: true,
			contentType: false,
			processData: false,
			success: function(response){
						//alert(response.dat);
						if(response.dat == 1){
							alert("Series Added");
							location.reload();
						}else{ alert("Error adding series");}
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

// Convert select to array with values.
function SelectArray(select){ //serealizeSelects(select) 
    var array = [];
    select.each(function(){ array.push($(this).val()) });
    return array;
}
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
})
</script>