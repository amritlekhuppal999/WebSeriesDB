<?php include('../function/function.php');

//GET SEASONS
if($_POST["action"] == 'get-seasons'){
	$data = array();
	//$data["msg"] = "kaam kar be";
	$ser_id = $_POST["ser_id"];

	$retHtml = '
	<label>Add</label>
	<div class="form-group">
		<a href="#" data-ser="'.$ser_id.'" class="btn btn-default" id="add-new-season">Add New Season</a>
	</div>
	<script>	
		$("#add-new-season").click(function(){
			var sendData = {
				series_id: $(this).data("ser"),
				action: "add-season-form"
			};
			//alert(sendData.season_no);
			//$("#load-here").html("asasd");
			$.ajax({
				url: "api-season.php",
				type: "POST",
				data: sendData,
				dataType: "JSON",
				encoding: true,
				success: function(response){
							$("#load-here").html(response.dat);
						 }
			});
		});
	</script>';
	
	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//LOAD SEASON FORM
else if($_POST["action"] == 'add-season-form'){
	$data = array();
	$series_id = $_POST["series_id"];
	//$season_no = $_POST["season_no"];
	$data["msg"] = 'load-season-form '.$series_id;

	record_set('serName','SELECT title from `series_list` WHERE id='.$series_id.' AND status=1');
	if($totalRows_serName){
		$rowData = mysqli_fetch_assoc($serName);
		$series_name = $rowData["title"];
	}

	$retHtml = '
	<div class="container-fluid"> 
		<div class="row">
			<div class="col-md-12">
				<div class="card card-default">
					
					<!--Form Start-->
					<form enctype="multipart/form-data">

						<input type="hidden" id="series_id" name="series_id" value="'.$series_id.'">
						
					<!-- Card Header -->
					<div class="card-header">
						<h3 class="card-title">
							<b> Add Season for '.$series_name.' </b>
						</h3>
					</div>

				<!--Card Body-->
				<div class="card-body">
					<div class="row">
						
						<!--Season Name-->
						<div class="col-md-6">
							<div class="form-group">
								<label>Season Name</label>
								<input class="form-control" type="text" name="season_name" id="season_name" placeholder="Season 1, 2.." value="" />
							</div>
						</div>

						<!-- Release Date -->
						<div class="col-md-3">
							<div class="form-group">
			                  <label>Release Date</label>
			                  <div class="input-group">
			                    <div class="input-group-prepend">
			                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
			                    </div>
			                    <input id="rdate" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
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
				                  <label class="custom-file-label" for="exampleInputFile">jpg, png, jpeg, gif</label>
				                </div>
				              </div>
				            </div>
						</div>

						<!--Season Trailer-->
						<div class="col-md-12">
							<div class="form-group">
								<label>Season Trailer</label>
								<input class="form-control" type="text" name="season_trailer" id="season_trailer" placeholder="url" value="" />
							</div>
						</div>

						<!-- Actors -->
						<div class="col-md-6">
							<div class="form-group">
			                  <label>Actors</label>
			                  <select class="select2 actors" multiple="multiple" data-placeholder="Select Actors" id="actor_ids" style="width: 100%;">';
			    			record_set('getAct', 'SELECT id, name FROM `actor_list` WHERE status=1');
		    				if($totalRows_getAct){
		    				  while($rowData = mysqli_fetch_assoc($getAct)){
		    				  $retHtml .= '<option value="'.$rowData["id"].'">'.$rowData["name"].'</option>';
		    			    }} 		
			                  $retHtml .= '</select>
			                </div>
						</div>

						<!-- Directors  -->
						<div class="col-md-6">
							<div class="form-group">
			                  <label>Directors</label>
			                  <select class="select2 directors" multiple="multiple" data-placeholder="Select Directors" id="director_ids" style="width: 100%;">';
			    				
			    			record_set('getDirct','SELECT id, name FROM `director_list` WHERE status=1');
		    				if($totalRows_getDirct){
		    				  while($rowData=mysqli_fetch_assoc($getDirct)){
		    				  $retHtml .= '<option value="'.$rowData["id"].'">'.$rowData["name"].'</option>';
			    			}} 		
			                  $retHtml .= '</select>
			                </div>
						</div>

						<!--Description-->
						<div class="col-md-12">
							<label>Description</label>
							<textarea class="form-control" rows="5" id="description"></textarea>
						</div>

					</div>
				</div>

						<!-- Card Footer -->
						<div class="card-footer">
						  <a id="submit" class="btn btn-default">ADD</a>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
	<script>
		RestSpace("#season_name");
		RestSpace("#season_trailer");
		RestSpace("#description");

		$("#submit").click(function(){
			var season_name = $("#season_name").val();
			if(season_name == ""){
				$("#season_name").focus();
				return false;
			}
			var formData = new FormData();
			var poster = $("#poster")[0].files[0];
			formData.append("img", poster);

			formData.append("actor_ids", JSON.stringify(SelectArray($(".actors"))));
			formData.append("director_ids", JSON.stringify(SelectArray($(".directors"))));

			formData.append("season_name", season_name);
			formData.append("series_id", $("#series_id").val());
			formData.append("releaseDate", $("#rdate").val());
			formData.append("season_trailer", $("#season_trailer").val());
			formData.append("description", $("#description").val());
			formData.append("action", "add-season");

			$.ajax({
				url: "api-season.php",
				type: "POST",
				data: formData,
				dataType: "JSON",
				encoding: true,
				contentType: false,
				processData: false,
				success: function(response){
							//alert(response.msg);
							if(response.dat == 1){
								alert("Season added");
								$("#add-seasons").click();
							}else{
								alert("Error adding season.");
							}
						 }
			});	
		});

		//Restricting Blank Space as first char.
		function RestSpace(field_id){  
			$(field_id).keyup(function(){
				var f_value = $(field_id).val();
				if(f_value[0] === " "){
					$(field_id).val("");
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
	</script>';

	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//ADD SEASON
else if($_POST["action"] == "add-season"){
	$data = array();
	//$data["msg"] = "season add hoga ka?";
	$data['dat'] = 0;

	$m_arr = json_decode($_POST["actor_ids"]);
	$actor_ids = implode("|", $m_arr[0]);

	$m_arr = json_decode($_POST["director_ids"]);
	$director_ids = implode("|", $m_arr[0]);

	$release_date = str_replace('/', '-', $_POST["releaseDate"]);
	
	$formData = array(
		"series_id" => $_POST["series_id"],
		"season_name" => $_POST["season_name"],
		"description" => $_POST["description"],
		"season_trailer_url" => $_POST["season_trailer"],
		"actor_id" => $actor_ids,
		"director_id" => $director_ids,
		"release_date" => date("Y-m-d", strtotime($release_date)),
		
		"status" => 1,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	$insert = dbRowInsert('season_list', $formData);
	if($insert > 0){
		$data['dat'] = 1;
		if(!empty($_FILES["img"]["name"])){
			$fName = 'season_img_'.$insert;
			$loc = ImageUpload2('img', 'images/season_poster/', $fName);
			//$loc = ImageUpload('img', 'images/season_poster/');
			if(file_exists($loc)){
				$fd = array("season_poster_img" => $loc);
				dbRowUpdate('season_list', $fd, 'WHERE id= '.$insert);
				//$data['msg'] = 'Everything went well & image inserted';
			}
			//else{ $data['msg'] = "error inserting image"; }
		}
	}

	echo json_encode($data, JSON_PRETTY_PRINT);
}

//VIEW SEASON
else if($_POST["action"] == "view-seasons"){
	$data = array();
	//$data["msg"] = 'season ka time';
	$retHtml = '';
	$series_id = $_POST["series_id"];

	record_set('getSea','SELECT id, season_name, season_trailer_url, season_poster_img, status FROM `season_list` WHERE series_id='.$series_id);
	if($totalRows_getSea){
		$count = 0;
		while($rowData = mysqli_fetch_assoc($getSea)){
			$imgLoc = $rowData["season_poster_img"];
			$trailer = $rowData["season_trailer_url"];
			$retHtml .='
				<tr>
					<td>'.++$count.'</td>';

					if(file_exists($imgLoc)){
						$retHtml .='<td><img src="'.$imgLoc.'" height="60" width="60" style="border-radius:4px;"/></td>';
					}else{ $retHtml .='<td>N/A</td>'; }

					$retHtml .='<td>'.$rowData["season_name"].'</td>
					<td><a href="'.$trailer.'" target="0_blank"><i class="fa fa-play-circle"></i> https://</a></td>';

					if($rowData["status"] == 1){
						$retHtml .='<td><label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
					else{
						$retHtml .= '<td><label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}

				$retHtml .= '<td><a class="badge badge-primary modify" style="color:white; cursor:pointer" data-id="'.$rowData["id"].'">Modify</a></td>
				</tr>

				<script>
					$(".alt-tog").click(function(){
						//alert($(this).data("status"));
						var curEle = $(this); //get current ele obj;
						var sendData = {
							season_id: $(this).data("id"),
							status_val: $(this).data("status"),
							action: "change-status"
						};
						$.ajax({
							url: "api-season",
							type: "POST",
							data: sendData,
							dataType: "JSON",
							encoding: true,
							success: function(response){
										//alert(response.msg);
										$(curEle).parent().html(response.dat);
									 }
						});
					});

					$(".modify").click(function(){
						var sendData = {
							season_id: $(this).data("id"),
							action: "update-season-form"
						}
						$.ajax({
							url: "api-season.php",
							type: "POST",
							data: sendData,
							dataType: "JSON",
							encoding: true,
							success: function(response){
										$("#load-sect").html(response.dat);
									}
						});
					});
				</script>';
		}
	}
	else{
		$retHtml = '<tr>
			<td colspan="6">No record available.</td>
		</tr>';	
	}
	$data["dat"] = $retHtml;
	
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//LOAD UPDATE FORM FOR SEASON
else if($_POST["action"] == "update-season-form"){
	$data = array();
	//$data["msg"] = '';
	$id = $_POST["season_id"];
	//$series_id = 0; $series_name = 'ss';

	record_set('getSea','SELECT * FROM `season_list` WHERE id='.$id);
	if($totalRows_getSea){
		$rowData = mysqli_fetch_assoc($getSea);

		$actor_arr = explode("|", $rowData["actor_id"]);
		$director_arr = explode("|", $rowData["director_id"]);
		$imgLoc = $rowData["season_poster_img"];
		$trailer = $rowData["season_trailer_url"];
		$season_name = $rowData["season_name"];
		$description = $rowData["description"];
		$series_id = $rowData["series_id"];
		$releaseDate = date("d-m-Y", strtotime($rowData["release_date"]));
	}

	$retHtml = '
	<div class="container-fluid"> 
		<div class="row">
			<div class="col-md-12">
				<div class="card card-default">
					
					<!--Form Start-->
					<form enctype="multipart/form-data">

						<!-- <input type="hidden" id="series_id" name="series_id" value="'.$series_id.'"> -->
						<input type="hidden" id="season_id" name="season_id" value="'.$id.'">
						
					<!-- Card Header -->
					<div class="card-header">
						<h3 class="card-title">
							<b> Update Season </b>
						</h3>
					</div>

				<!--Card Body-->
				<div class="card-body">
					<div class="row">';
						
						if(file_exists($imgLoc)){
							$retHtml .='
							<!-- Display Poster -->
							<div class="col-md-12">
								<div style="margin-bottom:10px; ">
									<img class="card-img-top" src="'.$imgLoc.'" alt="Card image cap" style="height:150px; width:300px; border-radius:4px;">
								</div>
							</div>';
						}

						$retHtml .='<!--Season Name-->
						<div class="col-md-6">
							<div class="form-group">
								<label>Season Name</label>
								<input class="form-control" type="text" name="season_name" id="season_name" placeholder="Season 1, 2.." value="'.$season_name.'" />
							</div>
						</div>

						<!-- Release Date -->
						<div class="col-md-3">
							<div class="form-group">
			                  <label>Release Date</label>
			                  <div class="input-group">
			                    <div class="input-group-prepend">
			                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
			                    </div>
			                    <input id="rdate" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask value="'.$releaseDate.'">
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
				                  <label class="custom-file-label" for="exampleInputFile">jpg, png, jpeg, gif</label>
				                </div>
				              </div>
				            </div>
						</div>

						<!--Season Trailer-->
						<div class="col-md-12">
							<div class="form-group">
								<label>Season Trailer</label>
								<input class="form-control" type="text" name="season_trailer" id="season_trailer" placeholder="url" value="'.$trailer.'" />
							</div>
						</div>

						<!-- Actors -->
						<div class="col-md-6">
							<div class="form-group">
			                  <label>Actors</label>
			                  <select class="select2 actors" multiple="multiple" data-placeholder="Select Actors" id="actor_ids" style="width: 100%;">';
			    			record_set('getAct', 'SELECT id, name FROM `actor_list` WHERE status=1');
		    				if($totalRows_getAct){
		    				  while($rowData = mysqli_fetch_assoc($getAct)){
		    				  	$sel ='';
		    				  	if(in_array($rowData["id"], $actor_arr)){
		    				  		$sel = ' selected ';
		    				  	}else{$sel ='';}
		    				  $retHtml .= '<option value="'.$rowData["id"].'" '.$sel.'>'.$rowData["name"].'</option>';
		    			    }} 		
			                  $retHtml .= '</select>
			                </div>
						</div>

						<!-- Directors  -->
						<div class="col-md-6">
							<div class="form-group">
			                  <label>Directors</label>
			                  <select class="select2 directors" multiple="multiple" data-placeholder="Select Directors" id="director_ids" style="width: 100%;">';
			    				
			    			record_set('getDirct','SELECT id, name FROM `director_list` WHERE status=1');
		    				if($totalRows_getDirct){
		    				  while($rowData=mysqli_fetch_assoc($getDirct)){
		    				  	$sel ='';
		    				  	if(in_array($rowData["id"], $director_arr)){
		    				  		$sel = ' selected ';
		    				  	}else{$sel ='';}
		    				  $retHtml .= '<option value="'.$rowData["id"].'" '.$sel.'>'.$rowData["name"].'</option>';
			    			}} 		
			                  $retHtml .= '</select>
			                </div>
						</div>

						<!--Description-->
						<div class="col-md-12">
							<label>Description</label>
							<textarea class="form-control" rows="5" id="description">'.$description.'</textarea>
						</div>

					</div>
				</div>

						<!-- Card Footer -->
						<div class="card-footer">
						  <a id="update" class="btn btn-default">Update</a>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
	<script>
		RestSpace("#season_name");
		RestSpace("#season_trailer");
		RestSpace("#description");

		$("#update").click(function(){
			var season_name = $("#season_name").val();
			if(season_name == ""){
				$("#season_name").focus();
				return false;
			}
			var formData = new FormData();
			var poster = $("#poster")[0].files[0];
			formData.append("img", poster);

			formData.append("actor_ids", JSON.stringify(SelectArray($(".actors"))));
			formData.append("director_ids", JSON.stringify(SelectArray($(".directors"))));

			formData.append("season_name", season_name);
			formData.append("season_id", $("#season_id").val());
			//formData.append("series_id", $("#series_id").val());
			formData.append("releaseDate", $("#rdate").val());
			formData.append("season_trailer", $("#season_trailer").val());
			formData.append("description", $("#description").val());
			formData.append("action", "update-season");

			$.ajax({
				url: "api-season.php",
				type: "POST",
				data: formData,
				dataType: "JSON",
				encoding: true,
				contentType: false,
				processData: false,
				success: function(response){
							//alert(response.dat);
							if(response.dat == 1){
								alert("Season updated");
								$("#view-seasons").click();
							}else{
								alert("Error updating season.");
							}
						 }
			});	
		});

		//Restricting Blank Space as first char.
		function RestSpace(field_id){  
			$(field_id).keyup(function(){
				var f_value = $(field_id).val();
				if(f_value[0] === " "){
					$(field_id).val("");
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
	</script>';

	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//UPDATE SEASON
else if($_POST["action"] == "update-season"){
	$data = array();
	//$data["msg"] = "season add hoga ka?";
	$data['dat'] = 0;
	$season_id = $_POST["season_id"];
	$m_arr = json_decode($_POST["actor_ids"]);
	$actor_ids = implode("|", $m_arr[0]);

	$m_arr = json_decode($_POST["director_ids"]);
	$director_ids = implode("|", $m_arr[0]);
	$releaseDate = str_replace('/', '-', $_POST["releaseDate"]);
	$formData = array(
		//"series_id" => $_POST["series_id"],
		"season_name" => $_POST["season_name"],
		"description" => $_POST["description"],
		"season_trailer_url" => $_POST["season_trailer"],
		"actor_id" => $actor_ids,
		"director_id" => $director_ids,
		"release_date" => date("Y-m-d", strtotime($releaseDate)),
		
		"status" => 1,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	//$update = dbRowUpdate('season_list', $formData, 'WHERE id='.$season_id);
	if(dbRowUpdate('season_list', $formData, 'WHERE id='.$season_id)){
		$data['dat'] = 1;
		if(!empty($_FILES["img"]["name"])){
			$fName = 'season_img_'.$season_id;
			$loc = ImageUpload2('img', 'images/season_poster/', $fName);
			//$loc = ImageUpload('img', 'images/season_poster/');
			if(file_exists($loc)){
				$fd = array("season_poster_img" => $loc);
				dbRowUpdate('season_list', $fd, 'WHERE id= '.$season_id);
				//$data['msg'] = 'Everything went well & image inserted';
			}
			//else{ $data['msg'] = "error inserting image"; }
		}
	}

	echo json_encode($data, JSON_PRETTY_PRINT);
}

//CHANGE STATUS
else if($_POST["action"] == 'change-status'){
	$data = array();
	$retHtml = '';
	$season_id = $_POST["season_id"];
	$old_status = $_POST["status_val"];

	if($old_status == 0){
		$new_status = 1;
	}else{ $new_status = 0;}

	$formData = array(
		"status" => $new_status,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	record_Set("getSer","SELECT id FROM `season_list` WHERE id=".$season_id);
	if($totalRows_getSer){
		dbRowUpdate('season_list', $formData, 'WHERE id='.$season_id);
	}

	record_Set("getSer","SELECT status FROM `season_list` WHERE id=".$season_id);
	if($totalRows_getSer){
		$rowData = mysqli_fetch_assoc($getSer);
		if($rowData["status"] == 1){
			$retHtml .= '<label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$season_id.'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label>';
		}else{
			$retHtml .= '<label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$season_id.'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label>';
		}
		$retHtml .= '
		<script>
			$(".alt-tog").click(function(){
				//alert($(this).data("status"));
				var curEle = $(this); //get current ele obj;
				var sendData = {
					season_id: $(this).data("id"),
					status_val: $(this).data("status"),
					action: "change-status"
				};
				$.ajax({
					url: "api-season",
					type: "POST",
					data: sendData,
					dataType: "JSON",
					encoding: true,
					success: function(response){
								//alert(response.msg);
								$(curEle).parent().html(response.dat);
							 }
				});
			});
		</script>';
	}

	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//SEARCH SEASONS
else if($_POST["action"] == "search-seasons"){
	$data = array();
	//$data["msg"] = 'season ka time';
	$retHtml = '';
	$series_id = $_POST["series_id"];
	$search_key = $_POST["search_key"];
	record_set('getSea','SELECT id, season_name, season_trailer_url, season_poster_img, status FROM `season_list` WHERE series_id='.$series_id.' AND season_name LIKE "%'.$search_key.'%" LIMIT 7');
	if($totalRows_getSea){
		$count = 0;
		while($rowData = mysqli_fetch_assoc($getSea)){
			$imgLoc = $rowData["season_poster_img"];
			$trailer = $rowData["season_trailer_url"];
			$retHtml .='
				<tr>
					<td>'.++$count.'</td>';

					if(file_exists($imgLoc)){
						$retHtml .='<td><img src="'.$imgLoc.'" height="60" width="60" style="border-radius:4px;"/></td>';
					}else{ $retHtml .='<td>N/A</td>'; }

					$retHtml .='<td>'.$rowData["season_name"].'</td>
					<td><a href="'.$trailer.'" target="0_blank"><i class="fa fa-play-circle"></i> https://</a></td>';

					if($rowData["status"] == 1){
						$retHtml .='<td><label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
					else{
						$retHtml .= '<td><label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}

				$retHtml .= '<td><a class="badge badge-primary modify" style="color:white; cursor:pointer" data-id="'.$rowData["id"].'">Modify</a></td>
				</tr>

				<script>
					$(".alt-tog").click(function(){
						//alert($(this).data("status"));
						var curEle = $(this); //get current ele obj;
						var sendData = {
							season_id: $(this).data("id"),
							status_val: $(this).data("status"),
							action: "change-status"
						};
						$.ajax({
							url: "api-season",
							type: "POST",
							data: sendData,
							dataType: "JSON",
							encoding: true,
							success: function(response){
										//alert(response.msg);
										$(curEle).parent().html(response.dat);
									 }
						});
					});

					$(".modify").click(function(){
						var sendData = {
							season_id: $(this).data("id"),
							action: "update-season-form"
						}
						$.ajax({
							url: "api-season.php",
							type: "POST",
							data: sendData,
							dataType: "JSON",
							encoding: true,
							success: function(response){
										$("#load-sect").html(response.dat);
									}
						});
					});
				</script>';
		}
	}
	else{
		$retHtml .='<tr>
			<td colspan="6">No match found.</td>
		</tr>';
	}
	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}
?>