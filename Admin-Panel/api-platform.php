<?php include('../function/function.php');

//ADD PLATFORM
if($_POST["action"] == 'add-platform'){
	$data = array();
	$data["msg"] = 'add-platform';
	$data['dat'] = 0;

	$formData = array(
		"name" => $_POST["name"],
		"url" => $_POST["plat_url"],
		"about" => $_POST["about"],
		
		"status" => 1,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	$insert = dbRowInsert('platform', $formData);
	if($insert > 0){
		$data['dat'] = 1;
		if(!empty($_FILES["img"]["name"])){
			$fName = 'platform_img_'.$insert;
			$loc = ImageUpload2('img', 'images/platform_logo/', $fName);
			//$loc = ImageUpload('img', 'images/platform_logo/');
			if(file_exists($loc)){
				$fd = array("logo" => $loc);
				dbRowUpdate('platform', $fd, 'WHERE id= '.$insert);
				//$data['msg'] = 'Everything went well & image inserted';
			}
			//else{ $data['msg'] = "error inserting image"; }
		}
	}
	//else{ $data['msg'] = 'Error adding platform'; }
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//VIEW PLATFORM
else if($_POST['action'] == 'view-platform'){
	$data = array();
	//$data['msg'] = 'view-series';
	$retHtml = '';

	//Pagination
	$pagn = '';		
	record_set('serRec', 'SELECT id FROM `platform`');
	if($totalRows_serRec){
		$numRec = $totalRows_serRec;
		$rpp = 5;
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
				LoadPlatform($(this).data("page-no"));
			});
		</script>';
	}
	$data["pagn"] = $pagn;

	record_set('serPlat', 'SELECT * FROM `platform` LIMIT '.$startP.', '.$rpp);
	if($totalRows_serPlat){
		$count = 0;
		while($rowData = mysqli_fetch_assoc($serPlat)){
			$retHtml .= '
				<tr>
					<td>'.++$count.'</td>
					<td>'; if(file_exists($rowData["logo"])){
						$retHtml .='<img src="'.$rowData["logo"].'" height="60" width="60"/>'; 
						   }else{  $retHtml .= 'N/A'; }
					$retHtml .= '</td>
                  	<td>'.$rowData["name"].'</td>
                  	<td><a href="'.$rowData["url"].'" target="0_blank">https://</a></td>';
                  	if($rowData["status"] == 1){
						$retHtml .=
					'<td><label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
					else{ $retHtml .=
					'<td><label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
				$retHtml .='
					<td><a class="badge badge-primary modify" style="color:white; cursor:pointer" data-id="'.$rowData["id"].'">Modify</a></td>
				</tr>'; 
		}
	}
	else{
		$retHtml = '<tr>
			<td colspan="6">No records found.</td>
		</tr>';
		$data["pagn"] = '';
	}
	$retHtml .= '
	<script>
		$(".alt-tog").click(function(){
			//alert($(this).data("status"));
			var curEle = $(this); //get current ele obj;
			var sendData = {
				platform_id: $(this).data("id"),
				status_val: $(this).data("status"),
				action: "change-status"
			};
			$.ajax({
				url: "api-platform",
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
			var formData = {id:id, action:"update-platform-form"}
			$.ajax({
				url : "api-platform.php",
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
							        scrollTop: $(".upPlat").offset().top},
							        "fast");
							});
						 }
			});
		});
	</script>';
	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//Load UPDATE PLATFORM Form
else if($_POST['action'] == 'update-platform-form'){
	$data = array();
	//$data["msg"] = 'update-platform-form';
	$id = $_POST["id"];
	$retHtml = '';
	record_set('getPlat','SELECT * FROM `platform` WHERE id='.$id);
	if($totalRows_getPlat){
		$rowData = mysqli_fetch_assoc($getPlat);
		$retHtml .= '
		<div class="container-fluid upPlat">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-default">
						
						<!--Form Start-->
						<form enctype="multipart/form-data">

						<input type="hidden" name="plat_id" id="plat_id" value="'.$rowData["id"].'"/>

						<!-- Card Header -->
						<div class="card-header"><h3 class="card-title">Modify</h3>
						</div> 

			<!--Card Body-->
			<div class="card-body">
				<div class="row">';

					if(file_exists($rowData["logo"])){
						$retHtml .= '
						<!--LOGO-->
						<div class="col-md-12">
							<div style="margin-bottom:10px; ">
								<img class="card-img-top" src="'.$rowData["logo"].'" alt="Card image cap" style="height:100px; width:100px; border-radius:4px;">
							</div>
						</div>';
					}
					
					$retHtml .= '<!-- Platform Name -->
					<div class="col-md-6">
						<div class="form-group">
							<label>Platform Name</label>
							<input type="text" name="name" id="name" class="form-control" placeholder="Platform Name" value="'.$rowData["name"].'">
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
							<input type="text" name="plat_url" id="plat_url" class="form-control" placeholder="Platform URL" value="'.$rowData["url"].'">
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
			var id = $("#plat_id").val();
			var name = $("#name").val();
			var plat_url = $("#plat_url").val();
			var about = $("#about").val();
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
			formData.append("url", plat_url);
			formData.append("about", about);
			formData.append("action", "update-platform");

			$.ajax({
				url: "api-platform.php",
				type: "POST",
				data: formData,
				dataType: "JSON",
				encoding: true,
				contentType: false,
				processData: false,
				success: function(response){
							//alert(response.msg);
							if(response.dat == 1){
								alert("Platform Updated.");
								$("#view-platforms").click();
							}else{ alert("Error updating platform.");}
						}
			});
		});
		</script>';
	}
	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//UPDATE PLATFORM
else if($_POST["action"] == 'update-platform'){
	$data = array();
	//$data["msg"] = 'update-platform';
	$id = $_POST["id"];
	$formData = array(
		"name" => $_POST["name"],
		"url" => $_POST["url"],
		"about" => $_POST["about"],
		
		"status" => 1,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);
	$update = dbRowUpdate('platform', $formData, ' WHERE id='.$id);
	if($update){
		$data['dat'] = '1';
		if(!empty($_FILES["img"]["name"])){
			$fName = 'platform_img_'.$id;
			$loc = ImageUpload2('img', 'images/platform_logo/', $fName);
			//$loc = ImageUpload('img', 'images/platform_logo/');
			if(file_exists($loc)){
				$fd = array("logo" => $loc);
				dbRowUpdate('platform', $fd, 'WHERE id='.$id);

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
	$platform_id = $_POST["platform_id"];
	$old_status = $_POST["status_val"];

	if($old_status == 0){
		$new_status = 1;
	}else{ $new_status = 0;}

	$formData = array(
		"status" => $new_status,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	record_Set("getPlat","SELECT id FROM `platform` WHERE id=".$platform_id);
	if($totalRows_getPlat){
		dbRowUpdate('platform', $formData, 'WHERE id='.$platform_id);
	}

	record_Set("getPlat","SELECT status FROM `platform` WHERE id=".$platform_id);
	if($totalRows_getPlat){
		$rowData = mysqli_fetch_assoc($getPlat);
		if($rowData["status"] == 1){
			$retHtml .= '<label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$platform_id.'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label>';
		}else{
			$retHtml .= '<label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$platform_id.'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label>';
		}
		$retHtml .= '
		<script>
			$(".alt-tog").click(function(){
				//alert($(this).data("status"));
				var myEle = $(this); //get current ele obj;
				var sendData = {
					platform_id: $(this).data("id"),
					status_val: $(this).data("status"),
					action: "change-status"
				};
				$.ajax({
					url: "api-platform",
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

//SEARCH PLATFORM
else if($_POST['action'] == 'search-platform'){
	$data = array();
	//$data['msg'] = 'view-series';
	$retHtml = '';

	if(strlen($_POST["search_key"]) != 0){
		$search_key =' WHERE name LIKE "%'.$_POST["search_key"].'%" LIMIT 7';
	}
	else{ $search_key = ' LIMIT 7'; }

	record_set('serRec', 'SELECT * FROM `platform` '.$search_key);
	if($totalRows_serRec){
		$count = 0;
		while($rowData = mysqli_fetch_assoc($serRec)){
			$retHtml .= '
				<tr>
					<td>'.++$count.'</td>
					<td>'; if(file_exists($rowData["logo"])){
						$retHtml .='<img src="'.$rowData["logo"].'" height="60" width="60"/>'; 
						   }else{  $retHtml .= 'N/A'; }
					$retHtml .= '</td>
                  	<td>'.$rowData["name"].'</td>
                  	<td><a href="'.$rowData["url"].'" target="0_blank">https://</a></td>';
                  	if($rowData["status"] == 1){
						$retHtml .=
					'<td><label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
					else{ $retHtml .=
					'<td><label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
				$retHtml .='
					<td><a class="badge badge-primary modify" style="color:white; cursor:pointer" data-id="'.$rowData["id"].'">Modify</a></td>
				</tr>'; 
		}
	}
	else{
		$retHtml .= '<tr>
			<td colspan="6">No match found.</td>
		</tr>';
	}
	$retHtml .= '
	<script>
		$(".alt-tog").click(function(){
			//alert($(this).data("status"));
			var curEle = $(this); //get current ele obj;
			var sendData = {
				platform_id: $(this).data("id"),
				status_val: $(this).data("status"),
				action: "change-status"
			};
			$.ajax({
				url: "api-platform",
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
			var formData = {id:id, action:"update-platform-form"}
			$.ajax({
				url : "api-platform.php",
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
							        scrollTop: $(".upPlat").offset().top},
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