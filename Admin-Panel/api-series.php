<?php include('../function/function.php');

//ADD-SERIES
if($_POST['action'] == 'add-series'){
	$data = array();
	$data['dat'] = 0;

	$m_arr = json_decode($_POST["actor_ids"]);
	$actor_ids = implode("|", $m_arr[0]);

	$m_arr = json_decode($_POST["director_ids"]);
	$director_ids = implode("|", $m_arr[0]);

	$m_arr = json_decode($_POST["platform_ids"]);
	$platform_ids = implode("|", $m_arr[0]);

	$m_arr = json_decode($_POST["genre"]);
	$genre = implode("|", $m_arr[0]);

	$release_date = str_replace('/', '-', $_POST["releaseDate"]);

	$formData = array(
		"title" => $_POST["title"],
		"description" => $_POST["description"],

		"genre" => $genre,
		"actor_id" => $actor_ids,
		"director_id" => $director_ids,
		"platform_id" => $platform_ids,

		"trailer_url" => $_POST["trailer"],
		"release_date" => date("Y-m-d", strtotime($release_date)),
		"certificate" => $_POST["certificate"],
		"imdb_rating" => $_POST["imdb_rating"],
		//"r_tomato_rating" => $_POST["r_tomatoes"],
		"season_count" => $_POST["season_count"],

		"status" => 1,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	$insert = dbRowInsert('series_list',$formData);
	if($insert > 0){
		$data['dat'] = '1';
		if(!empty($_FILES["img"]["name"])){
			$fName = 'series_img_'.$insert;
			$loc = ImageUpload2('img', 'images/poster/', $fName);
			//$loc = ImageUpload('img', 'images/poster/');
			if(file_exists($loc)){
				$fd = array("series_poster_img" => $loc);
				dbRowUpdate('series_list', $fd, 'WHERE id= '.$insert);
				//$data['msg'] = 'Everything went well & image inserted';
			}
			//else{ $data['msg'] = "error inserting image"; }
		}
	}
	//else{ $data['msg'] = 'Error Adding series'; }
	
	echo json_encode($data,JSON_PRETTY_PRINT);
}

//VIEW-SERIES
else if($_POST['action'] == 'view-series'){
	$data = array();
	//$data['msg'] = 'view-series';
	$data['dat'] = '';

	//Pagination
	$pagn = '';		
	record_set('serRec', 'SELECT id FROM `series_list`');
	if($totalRows_serRec){
		$numRec = $totalRows_serRec;
		$rpp = 10;
		$pageNo = $_POST["pageNo"];
		$totalPage = $numRec/$rpp;  //result display page
	    if($totalPage <= 1){
	        $pagn .= '<label class="badge badge-info"><a href="#" class="pageNo" data-page-no="1" style="color:white;">1</a></label> ';
	    }
	    else{
	    	if(is_float($totalPage)){
		        $totalPage+=1;
		    }

		    $pcount = 1;
		    while($pcount <= $totalPage){
		    	if($pcount == $pageNo){
		    		$badge = 'badge-info';	//highlight curr-page
		    	}else{$badge = 'badge-secondary';}

		        $pagn .= '<label class="badge '.$badge.'"><a href="#" class="pageNo" data-page-no="'.$pcount.'" style="color:white;">'.$pcount.'</a></label> ';
		        $pcount++;
		    }
		}

	    if($pageNo > 1){
	        $startP = ($pageNo * $rpp) - $rpp;  
	    }else{ $startP = 0;}

		$pagn .='
		<script>
			$(".pageNo").click(function(){
				//alert($(this).data("page-no"));
				LoadSeries($(this).data("page-no"));
			});
		</script>';
	}
	
	record_set('serRec', 'SELECT id, title, trailer_url, certificate, imdb_rating, genre, status, season_count FROM `series_list` LIMIT '.$startP.', '.$rpp);
	if($totalRows_serRec){
		$count = 0; 
		while($rowData = mysqli_fetch_assoc($serRec)){
			$data['dat'] .= '
				<tr>
					<td>'.++$count.'</td>
					<td class="sTitle" data-id="'.$rowData["id"].'" style="cursor: pointer;">'.$rowData["title"].'</td>

					<td><a href="'.$rowData["trailer_url"].'" target="0_blank"><i class="fa fa-play-circle"></i>  https://</a></td> 

					<td>'.getCertificate($rowData["certificate"]).'</td>
					<td>'.$rowData["imdb_rating"].'</td>';

					if($rowData["status"] == 1){
						$data['dat'] .=
					'<td><label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
					else{ $data['dat'] .=
					'<td><label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
				$data['dat'] .=	'
					<td><a class="badge badge-primary modify" style="color:white; cursor:pointer" data-id="'.$rowData["id"].'">Modify</a></td>
				</tr>'; 
		}
	}
	$data["dat"] .= '
	<script>
		//Change Status
		$(".alt-tog").click(function(){
			//alert($(this).data("status"));
			var curEle = $(this); //get current ele obj;
			var sendData = {
				series_id: $(this).data("id"),
				status_val: $(this).data("status"),
				action: "change-status"
			};
			$.ajax({
				url: "api-series",
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

		$(".sTitle").click(function(){
			alert("Full series description coming soon..");
		});

		//Modify
		$(".modify").click(function(){
			var id = $(this).data("id");
			//alert(id);
			var formData = {id:id, action:"update-form"}
			$.ajax({
				url : "api-series.php",
				type: "POST",
				data: formData,
				dataType: "JSON",
				encryption: true,
				success: function(response){
							//alert(response.msg);
							$("#load-sect").html("Loading...");
							$("#load-sect").html(response.dat);

							//scroll down to the div
							$(function(){ //Smooth Scrolling
							    $("html, body").animate({
							        scrollTop: $(".upSer").offset().top},
							        "fast");
							});
						 }
			});
		});
	</script>';
	$data["pagn"] = $pagn;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//Load SERIES UPDATE Form
else if($_POST["action"] == 'update-form'){
	$data = array();
	$data["msg"] = 'modify';

	$id = $_POST["id"];
	record_set('getRec','SELECT * FROM `series_list` WHERE id='.$id);
	if($totalRows_getRec){
		$rowData = mysqli_fetch_assoc($getRec);
		$poster_loc = $rowData["series_poster_img"];
		$genre_arr = explode("|", $rowData["genre"]);
		$actor_arr = explode("|", $rowData["actor_id"]);
		$director_arr = explode("|", $rowData["director_id"]);
		$platform_arr = explode("|", $rowData["platform_id"]);
		$releaseDate = date("d-m-Y", strtotime($rowData["release_date"]));

		$retHtml = '
		<div class="container-fluid upSer">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-default">

				<!-- Card Header -->
				<div class="card-header">
					<h3 class="card-title">Modify</h3>
				</div>

						<!--Form Start--> 
						<form enctype="multipart/form-data">

				<!--Card Body-->
				<div class="card-body">
					<div class="row">

					<!--Series Id-->
					<input type="hidden" id="ser_id" value="'.$id.'"/>';

					if(file_exists($poster_loc)){
						$retHtml .='
						<!-- Display Poster -->
						<div class="col-md-12">
							<div style="margin-bottom:10px; ">
								<img class="card-img-top" src="'.$poster_loc.'" alt="Card image cap" style="height:150px; width:300px; border-radius:4px;">
							</div>
						</div>';
					}

					$retHtml .=	'<!-- Title -->
						<div class="col-md-6">
							<div class="form-group">
								<label>Title</label>
								<input type="text" name="title" id="title" value="'.$rowData["title"].'" class="form-control" placeholder="Title">
							</div>
						</div>

						<!-- Genre -->
						<div class="col-md-6">
							<div class="form-group">
			                  <label>Genre</label>
			                  <select class="select2 genre" multiple="multiple" data-placeholder="Select Genre" id="genre" style="width: 100%;">';
			                $genre = Genres();
			                foreach($genre as $key =>$val){
			                	if(in_array($key, $genre_arr)){ $sec="selected";}else{ $sec ="";}
			                	$retHtml .='<option value="'.$key.'" '.$sec.'>'.$val.'</option>';
			                }	
			                  $retHtml .='</select>
			                </div>
						</div>

						<!-- Certificate -->
						<div class="col-md-3">
							<label>Certificate</label>
							<select class="form-control" id="certificate">
								<option value="0">Select</option>';
							$cert = sCertificate();
							foreach($cert as $key => $val){
								if($key == $rowData["certificate"] ){ $sec="selected";}else{ $sec ="";}
							$retHtml .='<option value="'.$key.'" '.$sec.' >'.$val.'</option>';
							}
							$retHtml .='</select>
						</div>

						<!-- Release Date -->
						<div class="col-md-3">
							<div class="form-group">
			                  <label>Release Date</label>
			                  <div class="input-group">
			                    <div class="input-group-prepend">
			                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
			                    </div>
			                    <input id="rel-date" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask value="'.$releaseDate.'">
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
				              </div>
				            </div>
						</div>

						<!-- IMDB -->
						<div class="col-md-3">
							<div class="form-group">
								<label>IMDB</label>
								<input type="number" name="imdb_rating" id="imdb_rating" value="'.$rowData["imdb_rating"].'" class="form-control" placeholder="8.1">
							</div>
						</div>

						<!-- Actors -->
						<div class="col-md-6">
							<div class="form-group">
			                  <label>Actors</label>
			                  <select class="select2 actors" multiple="multiple" data-placeholder="Select Actors" id="actor_ids" style="width: 100%;">
			    			<!--<option value="1">Actor 1</option>-->';
			    		record_set('getAct','SELECT id, name FROM `actor_list` WHERE status=1');
			    		if($totalRows_getAct){
			    			$actSel = '';
			    			while($ActRowData = mysqli_fetch_assoc($getAct)){
			    				if(in_array($ActRowData["id"], $actor_arr)){
			    					$actSel = 'selected';
			    				}else{$actSel = '';}
			    				$retHtml .=	'<option value="'.$ActRowData["id"].'" '.$actSel.' >'.$ActRowData["name"].'</option>';
			    		}}			
			            $retHtml .='</select>
			                </div>
						</div>

						<!-- Directors -->
						<div class="col-md-6">
							<div class="form-group">
			                  <label>Directors</label>
			                  <select class="select2 directors" multiple="multiple" data-placeholder="Select Directors" id="director_ids" style="width: 100%;">
			    		<!--<option value="1">Director 1</option>-->';
			    		record_set('getDirct','SELECT id, name FROM `director_list` WHERE status =1');
			    		if($totalRows_getDirct){
			    			$dirSel = '';
			    		  while($dirRowData = mysqli_fetch_assoc($getDirct)){
			    		  		if(in_array($dirRowData["id"], $director_arr)){
			    					$dirSel = 'selected';
			    				}else{$dirSel = '';}
			    		  		$retHtml .='<option value="'.$dirRowData["id"].'" '.$dirSel.'>'.$dirRowData["name"].'</option>';
			    		}}
			    				$retHtml .='	
			                  </select>
			                </div>
						</div>

						<!-- Platform -->
						<div class="col-md-6">
							<div class="form-group">
			                  <label>Platform</label>
			                  <select class="select2 platforms" multiple="multiple" data-placeholder="Select Platform" id="platform_ids" style="width: 100%;">
			    			<!--<option value="1">Platform 1</option>-->';
		    			record_set('getPlat','SELECT id, name FROM `platform` WHERE status=1');	
		    			if($totalRows_getPlat){
		    				$platSel = '';
		    				while($platData = mysqli_fetch_assoc($getPlat)){
		    					if(in_array($platData["id"], $platform_arr)){
			    					$platSel = 'selected';
			    				}else{$platSel = '';}
		    					$retHtml .='<option value="'.$platData["id"].'" '.$platSel.'>'.$platData["name"].'</option>';
		    			}}
		    				  $retHtml .='</select>
			                </div>
						</div>

						<!-- Trailer -->
						<div class="col-md-12">
							<div class="form-group">
								<label>Trailer</label>
								<input type="text" name="trailer" id="trailer" value="'.$rowData["trailer_url"].'" class="form-control" placeholder="trailer">
							</div>
						</div>

						<!-- Description -->
						<div class="col-md-12">
							<div class="form-group">
								<label>Description</label>
								<textarea rows="5" name="description" id="description" class="form-control" placeholder="decrip..">'.$rowData["description"].'</textarea>
							</div>
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
			$("#update").click(function(){
				var ser_id = $("#ser_id").val();
				var title = $("#title").val();
				var genre = JSON.stringify(SelectArray($(".genre")));
				var certificate = $("#certificate").val();
				var releaseDate = $("#rel-date").val();
				var imdb_rating = $("#imdb_rating").val();
				var seasonCount = $("#seasonCount").val();
				var actor_ids = JSON.stringify(SelectArray($(".actors")));
				var director_ids = JSON.stringify(SelectArray($(".directors")));
				var platform_ids = JSON.stringify(SelectArray($(".platforms")));
				var trailer = $("#trailer").val();
				var description = $("#description").val();

				if(title == ""){
					$("#title").focus();
					return false;
				}
				//alert(releaseDate);
				var formData = new FormData();
				var poster = $("#poster")[0].files[0];
				formData.append("img",poster);

				formData.append("id",ser_id);
				formData.append("title",title);
				formData.append("genre",genre);
				formData.append("certificate",certificate);
				formData.append("releaseDate",releaseDate);
				formData.append("imdb_rating",imdb_rating);
				formData.append("season_count",seasonCount);
				formData.append("actor_ids",actor_ids);
				formData.append("director_ids",director_ids);
				formData.append("platform_ids",platform_ids);
				formData.append("trailer",trailer);
				formData.append("description",description);
				formData.append("action","update-series");

				$.ajax({
					url: "api-series.php",
					type: "POST",
					data: formData,
					dataType: "JSON",
					encoding: true,
					contentType: false,
					processData: false,
					success: function(response){
								//alert(response.dat);
								if(response.dat == 1){
									alert("Series Updated");
									$("#view-series").click();
								}else{ alert("Error updating series");}
							}
				});
			});

			/* Convert select to array with values */    
			function SelectArray(select){ 
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
	}

	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//UPDATE SERIES
else if($_POST["action"] == 'update-series'){
	$data = array();
	$data['dat'] = 0;

	$id = $_POST["id"];
	$m_arr = json_decode($_POST["actor_ids"]);
	$actor_ids = implode("|", $m_arr[0]);

	$m_arr = json_decode($_POST["director_ids"]);
	$director_ids = implode("|", $m_arr[0]);

	$m_arr = json_decode($_POST["platform_ids"]);
	$platform_ids = implode("|", $m_arr[0]);

	$m_arr = json_decode($_POST["genre"]);
	$genre = implode("|", $m_arr[0]);

	$release_date = str_replace('/', '-', $_POST["releaseDate"]);

	$formData = array(
		"title" => $_POST["title"],
		"description" => $_POST["description"],

		"genre" => $genre,
		"actor_id" => $actor_ids,
		"director_id" => $director_ids,
		"platform_id" => $platform_ids,

		"trailer_url" => $_POST["trailer"],
		"release_date" => date("Y-m-d", strtotime($release_date)),
		"certificate" => $_POST["certificate"],
		"imdb_rating" => $_POST["imdb_rating"],
		//"r_tomato_rating" => $_POST["r_tomatoes"],
		"season_count" => $_POST["season_count"],

		"status" => 1,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	$update = dbRowUpdate('series_list', $formData, ' WHERE id='.$id);
	if($update){
		//iska js counterpart upar wale action condition me hai.
		$data['dat'] = '1';
		if(!empty($_FILES["img"]["name"])){
			$fName = 'series_img_'.$id;
			$loc = ImageUpload2('img', 'images/poster/', $fName);
			//$loc = ImageUpload('img', 'images/poster/');
			if(file_exists($loc)){
				$fd = array("series_poster_img" => $loc);
				dbRowUpdate('series_list', $fd, 'WHERE id= '.$id);
				//$data['msg']='Everything went well & image inserted';
			}
			//else{ $data['msg'] = "error inserting image"; }
		}
	}
	//else{ $data['msg'] = 'Error Adding series'; }
	
	echo json_encode($data,JSON_PRETTY_PRINT);
}

//CHANGE STATUS
else if($_POST["action"] == 'change-status'){
	$data = array();
	$retHtml = '';
	$series_id = $_POST["series_id"];
	$old_status = $_POST["status_val"];

	if($old_status == 0){
		$new_status = 1;
	}else{ $new_status = 0;}

	$formData = array(
		"status" => $new_status,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	record_Set("getSer","SELECT id FROM `series_list` WHERE id=".$series_id);
	if($totalRows_getSer){
		dbRowUpdate('series_list', $formData, 'WHERE id='.$series_id);
	}

	record_Set("getSer","SELECT status FROM `series_list` WHERE id=".$series_id);
	if($totalRows_getSer){
		$rowData = mysqli_fetch_assoc($getSer);
		if($rowData["status"] == 1){
			$retHtml .= '<label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$series_id.'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label>';
		}else{
			$retHtml .= '<label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$series_id.'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label>';
		}
		$retHtml .= '
		<script>
			$(".alt-tog").click(function(){
				//alert($(this).data("status"));
				var myEle = $(this); //get current ele obj;
				var sendData = {
					series_id: $(this).data("id"),
					status_val: $(this).data("status"),
					action: "change-status"
				};
				$.ajax({
					url: "api-series",
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

//SEARCH SERIES 
else if($_POST['action'] == 'search-series'){
	$data = array();
	//$data['msg'] = $_POST["search_key"];
	
	$search_key = $_POST["search_key"];	

	$retHtml = '';
	record_set('serRec', 'SELECT id, title, trailer_url, certificate, imdb_rating, genre, status, season_count FROM `series_list` WHERE title LIKE "%'.$search_key.'%" LIMIT 7');
	if($totalRows_serRec){
		$count = 0;
		while($rowData = mysqli_fetch_assoc($serRec)){
			$retHtml .= '
				<tr>
					<td>'.++$count.'</td>
					<td class="sTitle" data-id="'.$rowData["id"].'" style="cursor: pointer;">'.$rowData["title"].'</td>

					<td><a href="'.$rowData["trailer_url"].'" target="0_blank"><i class="fa fa-play-circle"></i>  https://</a></td> 

					<td>'.getCertificate($rowData["certificate"]).'</td>
					<td>'.$rowData["imdb_rating"].'</td>';

					if($rowData["status"] == 1){
						$retHtml .=
					'<td><label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
					else{ $retHtml .=
					'<td><label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
				$retHtml .=	'
					<td><a class="badge badge-primary modify" style="color:white; cursor:pointer" data-id="'.$rowData["id"].'">Modify</a></td>
				</tr>'; 
		}
	}
	else{
		$retHtml .='<tr>
			<td colspan="7">No match found.</td>
		</tr>';
	}
	$retHtml .= '
	<script>
		$(".alt-tog").click(function(){
			//alert($(this).data("status"));
			var curEle = $(this); //get current ele obj;
			var sendData = {
				series_id: $(this).data("id"),
				status_val: $(this).data("status"),
				action: "change-status"
			};
			$.ajax({
				url: "api-series",
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

		$(".sTitle").click(function(){
			alert("Full series description coming soon..");
		});

		$(".modify").click(function(){
			var id = $(this).data("id");
			//alert(id);
			var formData = {id:id, action:"update-form"}
			$.ajax({
				url : "api-series.php",
				type: "POST",
				data: formData,
				dataType: "JSON",
				encryption: true,
				success: function(response){
							//alert(response.msg);
							$("#load-sect").html("Loading...");
							$("#load-sect").html(response.dat);

							//scroll down to the div
							$(function(){ //Smooth Scrolling
							    $("html, body").animate({
							        scrollTop: $(".upSer").offset().top},
							        "fast");
							});
						 }
			});
		});
	</script>';

	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}
?>