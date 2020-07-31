<?php include('../function/function.php');

// ADD WRITER
if($_POST["action"] == 'add-writer'){
	$data = array();
	//$data["msg"] = 'add-writer';
	$data['dat'] = 0;
	$dob = str_replace('/', '-', $_POST["dob"]);
	$formData = array(
		"name" => $_POST["name"],
		"gender" => $_POST["gender"],
		"about" => $_POST["about"],
		"DOB" => date("Y-m-d", strtotime($dob)),

		"status" => 1,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	$insert = dbRowInsert('writer_list', $formData);
	if($insert > 0){
		$data['dat'] = 1;
		if(!empty($_FILES["img"]["name"])){
			$fName = 'writer_img_'.$insert;
			$loc = ImageUpload2('img', 'images/writer_dp/', $fName);
			//$loc = ImageUpload('img', 'images/writer_dp/');
			if(file_exists($loc)){
				$fd = array("writer_img" => $loc);
				dbRowUpdate('writer_list', $fd, 'WHERE id= '.$insert);
				$data['msg'] = 'Everything went well & image inserted';
			}
			//else{ $data['msg'] = "error inserting image"; }
		}
	}
	//else{ $data['msg'] = "error adding writer"; }

	echo json_encode($data, JSON_PRETTY_PRINT);
}

//VIEW WRITER
else if($_POST["action"] == 'view-writer'){
	$data = array();
	//$data["msg"] = '<tr><td colspan="7">sss</td></tr>';
	$retHtml = '';

	//Pagination
	$pagn = '';		
	record_set('serRec', 'SELECT id FROM `writer_list`');
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
				ViewWriters($(this).data("page-no"));
			});
		</script>';
	}
	$data["pagn"] = $pagn;

	record_set('getWrite', 'SELECT * FROM `writer_list` LIMIT '.$startP.', '.$rpp);
	if($totalRows_getWrite){
		$count = 0;
		while($rowData = mysqli_fetch_assoc($getWrite)){
			if(empty($rowData["DOB"])){
				$dob = 'N/A'; 
			}else{ $dob = date("d-M-Y", strtotime($rowData["DOB"])); }
			$retHtml .= '
			<tr>
				<td>'.++$count.'</td>
					<td>'; if(file_exists($rowData["writer_img"])){
						$retHtml .='<img src="'.$rowData["writer_img"].'" height="60" width="60"/>'; 
						   }else{  $retHtml .= 'N/A'; }
					$retHtml .= '</td>
                  	<td>'.$rowData["name"].'</td>
                  	<td>'.getGender($rowData["gender"]).'</td>
                  	<td>'.$dob.'</td>';
                  	if($rowData["status"] == 1){
						$retHtml .=
					'<td><label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
					else{ $retHtml .=
					'<td><label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
				$retHtml .='
					<td><a class="badge badge-primary modify" style="color:white; cursor:pointer" data-id="'.$rowData["id"].'" data-toggle="modal" data-target="#exampleModal">Modify</a></td>
			</tr>';
		}
		$retHtml .= '
		<script>
			$(".alt-tog").click(function(){
				//alert($(this).data("status"));
				var curEle = $(this); //get current ele obj;
				var sendData = {
					writer_id: $(this).data("id"),
					status_val: $(this).data("status"),
					action: "change-status"
				};
				$.ajax({
					url: "api-writer",
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
				//alert($(this).data("id"));
				var sendData = {
					writer_id: $(this).data("id"),
					action: "load-update-form"
				};

				$.ajax({
					url: "api-writer.php",
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
		$retHtml = '<tr>
			<td colspan="7">No records found.</td>
		</tr>';
		$data["pagn"] = '';
	}
	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//LOAD UPDATE FORM
else if($_POST["action"] == 'load-update-form'){
	$data = array();
	//$data["msg"] = 'load-update-form';
	$retHtml = '';
	$id = $_POST["writer_id"];

	record_set('getWrite', 'SELECT * FROM `writer_list` WHERE id='.$id);
	if($totalRows_getWrite){
		$rowData = mysqli_fetch_assoc($getWrite);
		$dob = date("d-m-Y", strtotime($rowData["DOB"]));
		$retHtml .= '
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-default">
						
						<!--Form Start-->
						<form enctype="multipart/form-data">
							<input type="hidden" name="writer_id" id="writer_id" value="'.$id.'">
						<!-- Card Header -->
						<!-- <div class="card-header"></div> -->

			<!--Card Body-->
			<div class="card-body">
				<div class="row">';
					
					if(file_exists($rowData["writer_img"])){
						$retHtml .= '
						<!--Producer DP-->
						<div class="col-md-3">
							<div style="margin-bottom:10px; ">
								<img class="card-img-top" src="'.$rowData["writer_img"].'" alt="Card image cap" style="height:100px; width:100px; border-radius:4px;">
							</div>
						</div>';
					}

					$retHtml .= '<!-- Writer Name -->
					<div class="col-md-9">
						<div class="form-group">
							<label>Writer Name</label>
							<input type="text" name="name" id="name" class="form-control" placeholder="Writer Name" value="'.$rowData["name"].'">
						</div>
					</div>

					<!-- Display Picture -->
					<div class="col-md-4">
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
					<div class="col-md-4">
						<label>Gender</label>
						<select class="form-control" id="gender">';
						$gen = Gender(); $sel='';
						foreach($gen as $key => $val){
							if($rowData["gender"] == $key)
							{$sel='selected';}
							else{$sel='';}
							$retHtml .='<option value="'.$key.'" '.$sel.'>'.$val.'</option>';
						}
						$retHtml .='</select>
					</div>

					<!-- DOB -->
					<div class="col-md-4">
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
			RestSpace("#name");
			RestSpace("#description");

			$("#update").click(function(){
				//alert($("#name").val());
				var name = $("#name").val();
				if(name == ""){
					$("#name").focus();
					return false;
				}

				var formData = new FormData();
				var dp = $("#dp")[0].files[0];
				formData.append("img", dp);

				formData.append("name", name);
				formData.append("writer_id", $("#writer_id").val());
				formData.append("gender", $("#gender").val());
				formData.append("about", $("#about").val());
				formData.append("dob", $("#dob").val());
				formData.append("action", "update-writer");

				$.ajax({
					url: "api-writer.php",
					type: "POST",
					data: formData,
					dataType: "JSON",
					encoding: true,
					contentType: false,
					processData: false,
					success: function(response){
								//alert(response.msg);
								if(response.dat == 1){
									alert("Writer Updated.");
									$(".close").click();
									ViewWriters(1);
								}else{ alert("Error updating writer.");}
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

//UPDATE WRITER
else if($_POST["action"] == 'update-writer'){
	$data = array();
	//$data["msg"] = 'update-writer';
	$id = $_POST["writer_id"];
	$data['dat'] = 0;
	$dob = str_replace('/', '-', $_POST["dob"]);
	$formData = array(
		"name" => $_POST["name"],
		"gender" => $_POST["gender"],
		"about" => $_POST["about"],
		"DOB" => date("Y-m-d", strtotime($dob)),

		"status" => 1,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	$update = dbRowUpdate('writer_list', $formData, 'WHERE id='.$id);
	if($update > 0){
		$data['dat'] = 1;
		if(!empty($_FILES["img"]["name"])){
			$fName = 'writer_img_'.$id;
			$loc = ImageUpload2('img', 'images/writer_dp/', $fName);
			//$loc = ImageUpload('img', 'images/writer_dp/');
			if(file_exists($loc)){
				$fd = array("writer_img" => $loc);
				dbRowUpdate('writer_list', $fd, 'WHERE id= '.$id);
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
	$writer_id = $_POST["writer_id"];
	$old_status = $_POST["status_val"];

	if($old_status == 0){
		$new_status = 1;
	}else{ $new_status = 0;}

	$formData = array(
		"status" => $new_status,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	record_Set("getWr","SELECT id FROM `writer_list` WHERE id=".$writer_id);
	if($totalRows_getWr){
		dbRowUpdate('writer_list', $formData, 'WHERE id='.$writer_id);
	}

	record_Set("getWr","SELECT status FROM `writer_list` WHERE id=".$writer_id);
	if($totalRows_getWr){
		$rowData = mysqli_fetch_assoc($getWr);
		if($rowData["status"] == 1){
			$retHtml .= '<label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$writer_id.'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label>';
		}else{
			$retHtml .= '<label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$writer_id.'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label>';
		}
		$retHtml .= '
		<script>
			$(".alt-tog").click(function(){
				//alert($(this).data("status"));
				var myEle = $(this); //get current ele obj;
				var sendData = {
					writer_id: $(this).data("id"),
					status_val: $(this).data("status"),
					action: "change-status"
				};
				$.ajax({
					url: "api-writer",
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

//SEARCH WRITER
else if($_POST["action"] == 'search-writer'){
	$data = array();
	//$data["msg"] = '<tr><td colspan="7">sss</td></tr>';
	$retHtml = '';

	if(strlen($_POST["search_key"]) != 0){
		$search_key =' WHERE name LIKE "%'.$_POST["search_key"].'%" LIMIT 7';
	}
	else{ $search_key = ' LIMIT 7'; }

	record_set('getWrite', 'SELECT * FROM `writer_list` '.$search_key);
	if($totalRows_getWrite){
		$count = 0;
		while($rowData = mysqli_fetch_assoc($getWrite)){
			if(empty($rowData["DOB"])){
				$dob = 'N/A'; 
			}else{ $dob = date("d-M-Y", strtotime($rowData["DOB"])); }
			$retHtml .= '
			<tr>
				<td>'.++$count.'</td>
					<td>'; if(file_exists($rowData["writer_img"])){
						$retHtml .='<img src="'.$rowData["writer_img"].'" height="60" width="60"/>'; 
						   }else{  $retHtml .= 'N/A'; }
					$retHtml .= '</td>
                  	<td>'.$rowData["name"].'</td>
                  	<td>'.getGender($rowData["gender"]).'</td>
                  	<td>'.$dob.'</td>';
                  	if($rowData["status"] == 1){
						$retHtml .=
					'<td><label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
					else{ $retHtml .=
					'<td><label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$rowData["id"].'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label></td>';
					}
				$retHtml .='
					<td><a class="badge badge-primary modify" style="color:white; cursor:pointer" data-id="'.$rowData["id"].'" data-toggle="modal" data-target="#exampleModal">Modify</a></td>
			</tr>';
		}
		$retHtml .= '
		<script>
			$(".alt-tog").click(function(){
				//alert($(this).data("status"));
				var curEle = $(this); //get current ele obj;
				var sendData = {
					writer_id: $(this).data("id"),
					status_val: $(this).data("status"),
					action: "change-status"
				};
				$.ajax({
					url: "api-writer",
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
				//alert($(this).data("id"));
				var sendData = {
					writer_id: $(this).data("id"),
					action: "load-update-form"
				};

				$.ajax({
					url: "api-writer.php",
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
			<td colspan="7">No match found.</td>
		</tr>';
	}
	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}
?>