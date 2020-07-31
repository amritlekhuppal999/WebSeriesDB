<?php include('../function/function.php');

//ADD DIRECTORS
if($_POST['action'] == 'add-director'){
	$data = array();
	$data['dat'] = 0;
	$dob = str_replace('/', '-', $_POST["dob"]);
	$formData = array(
		"name" => $_POST["name"],
		"real_name" => $_POST["real_name"],
		"gender" => $_POST["gender"],
		"about" => $_POST["about"],
		"DOB" => date("Y-m-d", strtotime($dob)),

		"status" => 1,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	$insert = dbRowInsert('director_list',$formData);
	if($insert > 0){
		$data['dat'] = '1';
		if(!empty($_FILES["img"]["name"])){
			$fName = 'director_img_'.$insert;
			$loc = ImageUpload2('img', 'images/director_dp/', $fName);
			//$loc = ImageUpload('img', 'images/director_dp/');
			if(file_exists($loc)){
				$fd = array("director_img" => $loc);
				dbRowUpdate('director_list', $fd, 'WHERE id= '.$insert);
				//$data['msg'] = 'Everything went well & image inserted';
			}
			//else{ $data['msg'] = "error inserting image"; }
		}
	}
	else{ $data['msg'] = 'Error Adding director'; }
	echo json_encode($data,JSON_PRETTY_PRINT);
}

//VIEW DIRECTORS
else if($_POST['action'] == 'view-directors'){
	$data = array();
	//$data['msg'] = 'view-series';
	$data['dat'] = '';

	//Pagination
	$pagn = '';		
	record_set('serRec', 'SELECT id FROM `director_list`');
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
				LoadDirectors($(this).data("page-no"));
			});
		</script>';
	}
	$data["pagn"] = $pagn;

	record_set('getDir', 'SELECT * FROM `director_list` LIMIT '.$startP.', '.$rpp);
	if($totalRows_getDir){
		$count = 0;
		while($rowData = mysqli_fetch_assoc($getDir)){
			if(empty($rowData["DOB"])){
				$dob = 'N/A';
			}else{$dob = date("d-M-Y", strtotime($rowData["DOB"]));}
			$data['dat'] .= '
				<tr>
					<td>'.++$count.'</td>
					<td>'; if(file_exists($rowData["director_img"])){
						$data['dat'] .='<img src="'.$rowData["director_img"].'" height="60" width="60" style="border-radius:4px;" />'; 
						   }else{  $data['dat'] .= 'N/A'; }
					$data['dat'] .= '</td>
                  	<td>'.$rowData["name"].'</td>
                  	<td>'.getGender($rowData["gender"]).'</td>
                  	<td>'.$dob.'</td>';
                  	if($rowData["status"] == 1){
						$data['dat'] .=
					'<td><label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
					else{
						$data['dat'] .=
					'<td><label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
				$data['dat'] .='
					<td><a class="badge badge-primary modify" style="color:white; cursor:pointer" data-id="'.$rowData["id"].'">Modify</a></td>
				</tr>'; 
		}
	}
	else{
		$data["dat"] .='<tr>
			<td colspan="7">No Records Found</td>
		</tr>';
		$data["pagn"] = '';
	}
	$data["dat"] .= '
	<script>
		$(".alt-tog").click(function(){
			//alert($(this).data("status"));
			var curEle = $(this); //get current ele obj;
			var sendData = {
				director_id: $(this).data("id"),
				status_val: $(this).data("status"),
				action: "change-status"
			};
			$.ajax({
				url: "api-director.php",
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
			var id = $(this).data("id");
			//alert(id);
			var formData = {id:id, action:"update-director-form"}
			$.ajax({
				url : "api-director.php",
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
							        scrollTop: $(".upDir").offset().top},
							        "fast");
							});
						 }
			});
		});
	</script>';

	echo json_encode($data, JSON_PRETTY_PRINT);
}

//Load UPDATE DIRECTOR FROM 
else if($_POST['action'] == 'update-director-form'){
	$data = array();
	$data["msg"] = 'LOAD UPDATE DIRECTOR FROM';
	$id = $_POST["id"];
	$retHtml = '';
	record_set('getDir','SELECT * FROM `director_list` WHERE id='.$id);
	if($totalRows_getDir){
		$rowData = mysqli_fetch_assoc($getDir);
		$dob = date("d-m-Y", strtotime($rowData["DOB"]));
		$retHtml .= '
		<div class="container-fluid upDir">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-default">
						
						<!--Form Start-->
						<form enctype="multipart/form-data">

							<input type="hidden" name="dir_id" id="dir_id" value="'.$id.'">

						<!-- Card Header -->
						<div class="card-header">
							<h3 class="card-title">Modify</h3>
						</div>

			<!--Card Body-->
			<div class="card-body">
				<div class="row">';
					
					if(file_exists($rowData["director_img"])){
						$retHtml .= '
						<!--Director DP-->
						<div class="col-md-12">
							<div style="margin-bottom:10px; ">
								<img class="card-img-top" src="'.$rowData["director_img"].'" alt="Card image cap" style="height:100px; width:100px; border-radius:4px;">
							</div>
						</div>';
					}

					$retHtml .= '<!-- Director Name -->
					<div class="col-md-6">
						<div class="form-group">
							<label>Director Name</label>
							<input type="text" name="name" id="name" class="form-control" placeholder="Director Name" value="'.$rowData["name"].'">
						</div>
					</div>

					<!-- Display Picture -->
					<div class="col-md-6">
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

					<!-- Real Name -->
					<div class="col-md-6">
						<div class="form-group">
							<label>Real Name</label>
							<input type="text" name="real_name" id="real_name" class="form-control" placeholder="Real Name" value="'.$rowData["real_name"].'">
						</div>
					</div>

					<!-- Gender -->
					<div class="col-md-3">
						<label>Gender</label>
						<select class="form-control" id="gender">
							<option value="0">Select</option>';
						$gen = Gender(); $sel='';
						foreach($gen as $key => $val){
							if($rowData["gender"] == $key){
								$sel=' selected ';
							}else{$sel='';}
							$retHtml .= '<option value="'.$key.'" '.$sel.'>'.$val.'</option>';
						}
						$retHtml .= '</select>
					</div>

					<!-- DOB -->
					<div class="col-md-3">
						<div class="form-group">
		                  <label>Date of Birth</label>
		                  <div class="input-group">
		                    <div class="input-group-prepend">
		                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
		                    </div>
		                    <input id="dob" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask value="'.$dob.'">
		                  </div>
		                </div>
					</div>

					<!-- About -->
					<div class="col-md-12">
						<div class="form-group">
							<label>About</label>
							<textarea rows="4" name="about" id="about" class="form-control" placeholder="About...">'.$rowData["about"].'</textarea>
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
			//alert("update");
			var id = $("#dir_id").val();
			var name = $("#name").val();
			var real_name = $("#real_name").val();
			var gender = $("#gender").val();
			var about = $("#about").val();
			var dob = $("#dob").val();
			//alert(id);

			if(name == ""){
				$("#name").focus();
				return false;
			}

			var formData = new FormData();
			var dp = $("#dp")[0].files[0];
			formData.append("img", dp);

			formData.append("id", id);
			formData.append("name", name);
			formData.append("real_name", real_name);
			formData.append("gender", gender);
			formData.append("about", about);
			formData.append("dob", dob);
			formData.append("action", "update-director");

			$.ajax({
				url: "api-director.php",
				type: "POST",
				data: formData,
				dataType: "JSON",
				encoding: true,
				contentType: false,
				processData: false,
				success: function(response){
							//alert(response.msg);
							if(response.dat == 1){
								alert("Director Updated.");
								$("#view-director").click();
							}else{ alert("Error updating director.");}
						}
			});
		});
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

//UPDATE DIRECTOR
else if($_POST["action"] == 'update-director'){
	$data = array();
	$data["msg"] = 'update-director';
	$id = $_POST["id"];
	$dob = str_replace('/', '-', $_POST["dob"]);
	$formData = array(
		"name" => $_POST["name"],
		"real_name" => $_POST["real_name"],
		"gender" => $_POST["gender"],
		"about" => $_POST["about"],
		"DOB" => date("Y-m-d", strtotime($dob)),

		"status" => 1,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);
	$update = dbRowUpdate('director_list', $formData, ' WHERE id='.$id);
	if($update){
		$data['dat'] = '1';
		if(!empty($_FILES["img"]["name"])){
			$fName = 'director_img_'.$id;
			$loc = ImageUpload2('img', 'images/director_dp/', $fName);
			//$loc = ImageUpload('img', 'images/director_dp/');
			if(file_exists($loc)){
				$fd = array("director_img" => $loc);
				dbRowUpdate('director_list', $fd, 'WHERE id='.$id);

				// record_set('getImg','SELECT series_poster_img FROM `series_list` WHERE id='.$id);
				// if($totalRows_getImg){
				// 	$rowData = mysqli_fetch_assoc($getImg);
				// 	chmod($rowData["series_poster_img"], 0644);
				// 	unlink($rowData["series_poster_img"]);
				// }

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
	$director_id = $_POST["director_id"];
	$old_status = $_POST["status_val"];

	if($old_status == 0){
		$new_status = 1;
	}else{ $new_status = 0;}

	$formData = array(
		"status" => $new_status,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	record_Set("getDir","SELECT id FROM `director_list` WHERE id=".$director_id);
	if($totalRows_getDir){
		dbRowUpdate('director_list', $formData, 'WHERE id='.$director_id);
	}

	record_Set("getDir","SELECT status FROM `director_list` WHERE id=".$director_id);
	if($totalRows_getDir){
		$rowData = mysqli_fetch_assoc($getDir);
		if($rowData["status"] == 1){
			$retHtml .= '<label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$director_id.'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label>';
		}else{
			$retHtml .= '<label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$director_id.'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label>';
		}
		$retHtml .= '
		<script>
			$(".alt-tog").click(function(){
				//alert($(this).data("status"));
				var myEle = $(this); //get current ele obj;
				var sendData = {
					director_id: $(this).data("id"),
					status_val: $(this).data("status"),
					action: "change-status"
				};
				$.ajax({
					url: "api-director",
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

//SEARCH DIRECTORS
else if($_POST['action'] == 'search-director'){
	$data = array();
	//$data['msg'] = 'view-series';
	if(strlen($_POST["search_key"]) != 0){
		$search_key =' WHERE name LIKE "%'.$_POST["search_key"].'%" LIMIT 7';
	}
	else{ $search_key = ' LIMIT 7'; }
	
	$data['dat'] = '';
	record_set('getDir', 'SELECT * FROM `director_list` '.$search_key);
	if($totalRows_getDir){
		$count = 0;
		while($rowData = mysqli_fetch_assoc($getDir)){
			if(empty($rowData["DOB"])){
				$dob = 'N/A';
			}else{$dob = date("d-M-Y", strtotime($rowData["DOB"]));}
			$data['dat'] .= '
				<tr>
					<td>'.++$count.'</td>
					<td>'; if(file_exists($rowData["director_img"])){
						$data['dat'] .='<img src="'.$rowData["director_img"].'" height="60" width="60" style="border-radius:4px;" />'; 
						   }else{  $data['dat'] .= 'N/A'; }
					$data['dat'] .= '</td>
                  	<td>'.$rowData["name"].'</td>
                  	<td>'.getGender($rowData["gender"]).'</td>
                  	<td>'.$dob.'</td>';
                  	if($rowData["status"] == 1){
						$data['dat'] .=
					'<td><label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
					else{
						$data['dat'] .=
					'<td><label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
				$data['dat'] .='
					<td><a class="badge badge-primary modify" style="color:white; cursor:pointer" data-id="'.$rowData["id"].'">Modify</a></td>
				</tr>'; 
		}
	}
	else{
		$data["dat"] .= '<tr>
			<td colspan="7">No match found.</td>
		</tr>';
	}
	$data["dat"] .= '
	<script>
		$(".alt-tog").click(function(){
			//alert($(this).data("status"));
			var curEle = $(this); //get current ele obj;
			var sendData = {
				director_id: $(this).data("id"),
				status_val: $(this).data("status"),
				action: "change-status"
			};
			$.ajax({
				url: "api-director.php",
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
			var id = $(this).data("id");
			//alert(id);
			var formData = {id:id, action:"update-director-form"}
			$.ajax({
				url : "api-director.php",
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
							        scrollTop: $(".upDir").offset().top},
							        "fast");
							});
						 }
			});
		});
	</script>';

	echo json_encode($data, JSON_PRETTY_PRINT);
}
?>