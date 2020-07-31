<?php include('../function/function.php');

//LOAD SEASON LIST
if($_POST["action"] == 'get-season'){
	$data = array();
	$series_id = $_POST["series_id"];
	$series_name = $_POST["series_name"];

	$retHtml = '<label>Select Season</label>
	<select class="form-control select2" style="width:100%;" id="getSeason">
		<option value="0">Select</option>';
	
	record_set('getSea','SELECT id, season_name FROM `season_list` WHERE series_id='.$series_id.' AND status=1');
	if($totalRows_getSea){
		while($rowData = mysqli_fetch_assoc($getSea)){
			$retHtml .='<option value="'.$rowData["id"].'">'.$rowData["season_name"].'</option>';
		}
	}
	$retHtml .= '</select>
		<script>
			$("#getSeason").change(function(){
				$("#ep-form").hide();
				//golbData is defined in the add-episode page.
				globData.season_id = $(this).val();
				globData.season_name = $("#getSeason option:selected").text();
				$("#add-btn").show();
				$("#ser_sea").html("Episode list for "+globData.season_name+" of "+globData.series_name);

				//Load Episode List
				$.ajax({
					url: "api-episode.php",
					type: "POST",
					data: globData,
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
			$(function(){
				//Initialize Select2 Elements
				$(".select2").select2()

				//Initialize Select2 Elements
				$(".select2bs4").select2({
				  theme: "bootstrap4"
				})
			})
		</script>
	';
	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//LOAD ADD EPISODE FORM
else if($_POST["action"] == "load-episode-form"){
	$data = array();
	$data["msg"] = 'load-episode-form working';
	$series_id = $_POST["series_id"];
	$series_name = $_POST["series_name"];
	$season_id = $_POST["season_id"];
	$season_name = $_POST["season_name"];

	$retHtml = '
	<div class="container-fluid" id="ep-form">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-default">
					
					<!--Form Start-->
					<form enctype="multipart/form-data">

						<input type="hidden" id="series_id" name="series_id" value="'.$series_id.'">
						<input type="hidden" id="season_id" name="season_id" value="'.$season_id.'">
						
					<!-- Card Header -->
					<div class="card-header">
						<h3 class="card-title">
							<b> Add Episode for '.$season_name.' of '.$series_name.' </b>
						</h3>
					</div>

				<!--Card Body-->
				<div class="card-body">
					<div class="row">
						
						<!--Episode Name-->
						<div class="col-md-12">
							<div class="form-group">
								<label>Episode Name</label>
								<input class="form-control" type="text" name="ep_name" id="ep_name" placeholder="Ep-1 Rebirth" value="" />
							</div>
						</div>

						<!--Episode Sequence-->
						<div class="col-md-3">
							<div class="form-group">
								<label>Episode Sequence</label>
								<input class="form-control" type="number" name="ep_seq" id="ep_seq" placeholder="1,2,.." value="" />
							</div>
						</div>

						<!--Episode Duration-->
						<div class="col-md-3">
							<div class="form-group">
								<label>Episode Duration</label>
								<input class="form-control" type="text" name="ep_dur" id="ep_dur" placeholder="1hr 90 mins.." value="" />
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

						<!--Episode Trailer-->
						<div class="col-md-12">
							<div class="form-group">
								<label>Episode Trailer</label>
								<input class="form-control" type="text" name="ep_trailer" id="ep_trailer" placeholder="url" value="" />
							</div>
						</div>

						<!--Description-->
						<div class="col-md-12">
							<label>Description</label>
							<textarea class="form-control" rows="5" id="description" placeholder="Details about the episode."></textarea>
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
		RestSpace("#ep_name");
		RestSpace("#ep_trailer");
		RestSpace("#description");

		$("#submit").click(function(){
			var ep_name = $("#ep_name").val();

			if(ep_name == ""){
				$("#ep_name").focus();
				return false;
			}
			
			var formData = new FormData();
			var poster = $("#poster")[0].files[0];
			formData.append("img", poster);

			formData.append("ep_name", ep_name);
			formData.append("ep_seq", $("#ep_seq").val());
			formData.append("ep_dur", $("#ep_dur").val());
			formData.append("releaseDate", $("#rdate").val());
			formData.append("series_id", $("#series_id").val());
			formData.append("season_id", $("#season_id").val());
			formData.append("ep_trailer", $("#ep_trailer").val());

			formData.append("description", $("#description").val());
			formData.append("action", "add-episode");

			$.ajax({
				url: "api-episode.php",
				type: "POST",
				data: formData,
				dataType: "JSON",
				encoding: true,
				contentType: false,
				processData: false,
				success: function(response){
							//alert(response.msg);
							if(response.dat == 1){
								alert("Episode added.");
								$("#add-new-ep").click();
							}else{
								alert("Error adding episode.");
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
		// function SelectArray(select){ //serealizeSelects(select) 
		//     var array = [];
		//     select.each(function(){ array.push($(this).val()) });
		//     return array;
		// }
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
		  	$("[data-mask]").inputmask()

		  	//Timepicker
		    // $("#timepicker").datetimepicker({
		    //   format: "LT"
		    // })
		});
	</script>';
	if($season_id == 0){
		$data["dat"] = '';
	}
	else{
		$data["dat"] = $retHtml;
	}
	
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//ADD EPISODE
else if($_POST["action"] == 'add-episode'){
	$data = array();
	//$data["msg"] = 'add-episode';

	$data['dat'] = 0;
	$releaseDate = str_replace('/', '-', $_POST["releaseDate"]);
	$formData = array(
		"series_id" => $_POST["series_id"],
		"season_id" => $_POST["season_id"],

		"episode_no" => $_POST["ep_seq"],
		"episode_name" => $_POST["ep_name"],
		"episode_duration" => $_POST["ep_dur"],

		"episode_trailer_url" => $_POST["ep_trailer"],
		"description" => $_POST["description"],
		"release_date" => date("Y-m-d", strtotime($releaseDate)),

		"status" => 1,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	$insert = dbRowInsert('episode_list', $formData);
	if($insert > 0){
		$data['dat'] = 1;
		if(!empty($_FILES["img"]["name"])){
			$fName = 'episode_img_'.$insert;
			$loc = ImageUpload2('img', 'images/episode_poster/', $fName);
			//$loc = ImageUpload('img', 'images/episode_poster/');
			if(file_exists($loc)){
				$fd = array("episode_poster_img" => $loc);
				dbRowUpdate('episode_list', $fd, 'WHERE id= '.$insert);
				$data['msg'] = 'Everything went well & image inserted';
			}
			//else{ $data['msg'] = "error inserting image"; }
		}
	}
	//else{ $data['msg'] = "error adding episode"; }

	echo json_encode($data, JSON_PRETTY_PRINT);
}

//VIEW EPISODE
else if($_POST["action"] == 'view-episode'){
	$data = array();
	$data["msg"] = 'view-episode';
	$series_id = $_POST["series_id"];
	$season_id = $_POST["season_id"];
	$season_name = $_POST["season_name"];
	$series_name = $_POST["series_name"];

	$retHtml = '';

	record_set('getEp', 'SELECT id, episode_name, episode_trailer_url, status FROM `episode_list` WHERE season_id='.$season_id.' AND series_id='.$series_id);
	if($totalRows_getEp){
		$count = 0;
		while($rowData = mysqli_fetch_assoc($getEp)){

			$retHtml .= '
			<tr>
				<td>'.++$count.'</td>
				<td>'.$rowData["episode_name"].'</td>
				<td><a href="'.$rowData["episode_trailer_url"].'" target="0_blank"><i class="fa fa-play-circle"></i> https://</a></td>';
				if($rowData["status"] == 1){
					$retHtml .='<td><label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
				}
				else{
					$retHtml .= '<td><label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
				}
				$retHtml .= '<td><a class="badge badge-primary modify" style="color:white; cursor:pointer" data-id="'.$rowData["id"].'" data-ser="'.$series_name.'" data-sea="'.$season_name.'" data-toggle="modal" data-target="#exampleModal">Modify</a></td>
			</tr>';
		}
		$retHtml .= '
		<script>
			$(".alt-tog").click(function(){
				//alert($(this).data("status"));
				var curEle = $(this); //get current ele obj;
				var sendData = {
					episode_id: $(this).data("id"),
					status_val: $(this).data("status"),
					action: "change-status"
				};
				$.ajax({
					url: "api-episode",
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
				//alert($(this).data("ser"));
				var sendData = {
					series_name: $(this).data("ser"),
					season_name: $(this).data("sea"),
					episode_id: $(this).data("id"),
					action: "episode-update-form"
				};
				$.ajax({
					url: "api-episode.php",
					type: "POST",
					data: sendData,
					dataType: "JSON",
					encoding: true,
					success: function(response){
								//alert(response.msg);
								$("#update-form").html(response.dat);
							 }
				});
			});
		</script>';
	}
	else{
		$retHtml .= '<tr>
			<td colspan="5">No episodes added for '.$season_name.'  of '.$series_name.'</td>
		</tr>';
	}

	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//LOAD UPDATE FORM
else if($_POST["action"] == 'episode-update-form'){
	$data = array();
	$data["msg"] = 'update-form';
	$retHtml = '';

	$season_name = $_POST["season_name"];
	$series_name = $_POST["series_name"];
	$id = $_POST["episode_id"];

	record_set('getEp','SELECT episode_no, episode_name, description, episode_trailer_url, episode_poster_img, episode_duration, release_date FROM `episode_list` WHERE id='.$id);
	if ($totalRows_getEp) {
		$rowData = mysqli_fetch_assoc($getEp);
		$imgLoc = $rowData["episode_poster_img"];
		$releaseDate = date("d-m-Y", strtotime($rowData["release_date"]));
		
		$retHtml .= '
		<div class="container-fluid" id="ep-form">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-default">
						
						<!--Form Start-->
						<form enctype="multipart/form-data">

							<!-- <input type="hidden" id="series_id" name="series_id" value=""> -->
							<!-- <input type="hidden" id="season_id" name="season_id" value=""> -->
							<input type="hidden" id="episode_id" name="episode_id" value="'.$id.'">
							
						<!-- Card Header -->
						<div class="card-header">
							<h3 class="card-title">
								<b> Update Episode for '.$season_name.' of '.$series_name.' </b>
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
							
							$retHtml .='<!--Episode Name-->
							<div class="col-md-6">
								<div class="form-group">
									<label>Episode Name</label>
									<input class="form-control" type="text" name="ep_name" id="ep_name" placeholder="Ep-1 Rebirth" value="'.$rowData["episode_name"].'" />
								</div>
							</div>

							<!--Episode Trailer-->
							<div class="col-md-6">
								<div class="form-group">
									<label>Episode Trailer</label>
									<input class="form-control" type="text" name="ep_trailer" id="ep_trailer" placeholder="url" value="'.$rowData["episode_trailer_url"].'" />
								</div>
							</div>

							<!--Episode Sequence-->
							<div class="col-md-3">
								<div class="form-group">
									<label>Episode Sequence</label>
									<input class="form-control" type="number" name="ep_seq" id="ep_seq" placeholder="1,2,.." value="'.$rowData["episode_no"].'" />
								</div>
							</div>

							<!--Episode Duration-->
							<div class="col-md-3">
								<div class="form-group">
									<label>Episode Duration</label>
									<input class="form-control" type="text" name="ep_dur" id="ep_dur" placeholder="1hr 90 mins.." value="'.$rowData["episode_duration"].'" />
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
				                    <input id="rdate" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask value="'.$releaseDate.'" >
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

							<!--Description-->
							<div class="col-md-12">
								<label>Description</label>
								<textarea class="form-control" rows="5" id="description" placeholder="Details about the episode.">'.$rowData["description"].'</textarea>
							</div>

						</div>
					</div>

							<!-- Card Footer -->
							<div class="card-footer">
							  <a id="submit" class="btn btn-default">UPDATE</a>
							</div>
						</form>
					</div>
				</div>

			</div>

		</div>

		<script>
			RestSpace("#ep_name");
			RestSpace("#ep_trailer");
			RestSpace("#description");

			$("#submit").click(function(){
				var ep_name = $("#ep_name").val();

				if(ep_name == ""){
					$("#ep_name").focus();
					return false;
				}
				
				var formData = new FormData();
				var poster = $("#poster")[0].files[0];
				formData.append("img", poster);

				formData.append("ep_name", ep_name);
				formData.append("ep_seq", $("#ep_seq").val());
				formData.append("ep_dur", $("#ep_dur").val());
				formData.append("episode_id", $("#episode_id").val());
				formData.append("releaseDate", $("#rdate").val());
				//formData.append("series_id", $("#series_id").val());
				//formData.append("season_id", $("#season_id").val());
				formData.append("ep_trailer", $("#ep_trailer").val());

				formData.append("description", $("#description").val());
				formData.append("action", "update-episode");

				$.ajax({
					url: "api-episode.php",
					type: "POST",
					data: formData,
					dataType: "JSON",
					encoding: true,
					contentType: false,
					processData: false,
					success: function(response){
								//alert(response.msg);
								if(response.dat == 1){
									alert("Episode updated.");
									$(".close").click();
								}else{
									alert("Error updating episode.");
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
			// function SelectArray(select){ //serealizeSelects(select) 
			//     var array = [];
			//     select.each(function(){ array.push($(this).val()) });
			//     return array;
			// }
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
			  	$("[data-mask]").inputmask()

			  	//Timepicker
			    // $("#timepicker").datetimepicker({
			    //   format: "LT"
			    // })
			});
		</script>
		';
	}


	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//UPDATE EPISODE
else if($_POST["action"] == 'update-episode'){
	$data = array();
	$data["msg"] = 'update-episode';
	$data["dat"] = 0;
	$id = $_POST["episode_id"];
	$releaseDate = str_replace('/', '-', $_POST["releaseDate"]);
	$formData = array(
		// "series_id" => $_POST["series_id"],
		// "season_id" => $_POST["season_id"],

		"episode_no" => $_POST["ep_seq"],
		"episode_name" => $_POST["ep_name"],
		"episode_duration" => $_POST["ep_dur"],

		"episode_trailer_url" => $_POST["ep_trailer"],
		"description" => $_POST["description"],
		"release_date" => date("Y-m-d", strtotime($releaseDate)),

		"status" => 1,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	$update = dbRowUpdate('episode_list', $formData, 'WHERE id='.$id);
	if($update > 0){
		$data['dat'] = 1;
		if(!empty($_FILES["img"]["name"])){
			$fName = 'episode_img_'.$id;
			$loc = ImageUpload2('img', 'images/episode_poster/', $fName);
			//$loc = ImageUpload('img', 'images/episode_poster/');
			if(file_exists($loc)){
				$fd = array("episode_poster_img" => $loc);
				dbRowUpdate('episode_list', $fd, 'WHERE id= '.$id);
				$data['msg'] = 'Everything went well & image inserted';
			}
			//else{ $data['msg'] = "error inserting image"; }
		}
	}
	//else{ $data['msg'] = "error adding episode"; }
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//CHANGE STATUS
else if($_POST["action"] == 'change-status'){
	$data = array();
	$retHtml = '';
	$episode_id = $_POST["episode_id"];
	$old_status = $_POST["status_val"];

	if($old_status == 0){
		$new_status = 1;
	}else{ $new_status = 0;}

	$formData = array(
		"status" => $new_status,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	record_Set("getSer","SELECT id FROM `episode_list` WHERE id=".$episode_id);
	if($totalRows_getSer){
		dbRowUpdate('episode_list', $formData, 'WHERE id='.$episode_id);
	}

	record_Set("getEp","SELECT status FROM `episode_list` WHERE id=".$episode_id);
	if($totalRows_getEp){
		$rowData = mysqli_fetch_assoc($getEp);
		if($rowData["status"] == 1){
			$retHtml .= '<label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$episode_id.'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label>';
		}else{
			$retHtml .= '<label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$episode_id.'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label>';
		}
		$retHtml .= '
		<script>
			$(".alt-tog").click(function(){
				//alert($(this).data("status"));
				var myEle = $(this); //get current ele obj;
				var sendData = {
					episode_id: $(this).data("id"),
					status_val: $(this).data("status"),
					action: "change-status"
				};
				$.ajax({
					url: "api-episode",
					type: "POST",
					data: sendData,
					dataType: "JSON",
					encoding: true,
					success: function(response){
								//alert(response.msg);
								$(myEle).parent().html(response.dat);
							 }
				});
			});
		</script>';
	}

	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//SEARCH EPISODE
else if($_POST["action"] == 'search-episode'){
	$data = array();
	$data["msg"] = 'view-episode';
	$series_id = $_POST["series_id"];
	$season_id = $_POST["season_id"];
	$season_name = $_POST["season_name"];
	$series_name = $_POST["series_name"];

	$search_key = $_POST["search_key"];
	$retHtml = '';

	record_set('getEp', 'SELECT id, episode_name, episode_trailer_url, status FROM `episode_list` WHERE season_id='.$season_id.' AND series_id='.$series_id.' AND episode_name LIKE "%'.$search_key.'%"');
	if($totalRows_getEp){
		$count = 0;
		while($rowData = mysqli_fetch_assoc($getEp)){

			$retHtml .= '
			<tr>
				<td>'.++$count.'</td>
				<td>'.$rowData["episode_name"].'</td>
				<td><a href="'.$rowData["episode_trailer_url"].'" target="0_blank"><i class="fa fa-play-circle"></i> https://</a></td>';
				if($rowData["status"] == 1){
					$retHtml .='<td><label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
				}
				else{
					$retHtml .= '<td><label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
				}
				$retHtml .= '<td><a class="badge badge-primary modify" style="color:white; cursor:pointer" data-id="'.$rowData["id"].'" data-ser="'.$series_name.'" data-sea="'.$season_name.'" data-toggle="modal" data-target="#exampleModal">Modify</a></td>
			</tr>';
		}
		$retHtml .= '
		<script>
			$(".alt-tog").click(function(){
				//alert($(this).data("status"));
				var curEle = $(this); //get current ele obj;
				var sendData = {
					episode_id: $(this).data("id"),
					status_val: $(this).data("status"),
					action: "change-status"
				};
				$.ajax({
					url: "api-episode",
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
				//alert($(this).data("ser"));
				var sendData = {
					series_name: $(this).data("ser"),
					season_name: $(this).data("sea"),
					episode_id: $(this).data("id"),
					action: "episode-update-form"
				};
				$.ajax({
					url: "api-episode.php",
					type: "POST",
					data: sendData,
					dataType: "JSON",
					encoding: true,
					success: function(response){
								//alert(response.msg);
								$("#update-form").html(response.dat);
							 }
				});
			});
		</script>';
	}
	else{
		$retHtml .= '<tr>
			<td colspan="5">No Match Found.</td>
		</tr>';
	}

	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}
?>