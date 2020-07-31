<?php include('../function/function.php');

// ADD ADMIN
if($_POST["action"] == "add-admin"){
	$data = array();
	//$data["msg"] = 'add-writer';
	$data['dat'] = 0;
	$dob = str_replace('/', '-', $_POST["dob"]);
	
	if(!empty($_POST["email"])){
		record_set('getAdm',' SELECT id FROM `admin_table` WHERE email_id="'.$_POST["email"].'"');
		if($totalRows_getAdm){
			$data["msg"] = 'Email already in use.';
			echo json_encode($data, JSON_PRETTY_PRINT);
			exit(0);
		}
	}

	if(!empty($_POST["phone"])){
		record_set('getAdm',' SELECT id FROM `admin_table` WHERE phone="'.$_POST["phone"].'"');
		if($totalRows_getAdm){
			$data["msg"] = 'Phone no. already in use.';
			echo json_encode($data, JSON_PRETTY_PRINT);
			exit(0);
		}
	}	

	$formData = array(
		"name" => $_POST["name"],
		"email_id" => $_POST["email"],
		"phone" => $_POST["phone"],

		"gender" => $_POST["gender"],
		"address" => $_POST["address"],
		"DOB" => date("Y-m-d", strtotime($dob)),
		"password" => md5($_POST["password"]),

		"status" => $_POST["status"],
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	$insert = dbRowInsert('admin_table', $formData);
	if($insert > 0){
		$data['dat'] = 1;
		if(!empty($_FILES["img"]["name"])){
			$fName = 'admin_img_'.$insert;
			$loc = ImageUpload2('img', 'images/admin_dp/', $fName);
			//$loc = ImageUpload('img', 'images/admin_dp/');
			if(file_exists($loc)){
				$fd = array("admin_img" => $loc);
				dbRowUpdate('admin_table', $fd, ' WHERE id='.$insert);
				$data['msg'] = 'Everything went well & image inserted';
			}
			else{ $data['msg'] = "error inserting image"; }
		}
	}
	//else{ $data['msg'] = "error adding admin"; }

	echo json_encode($data, JSON_PRETTY_PRINT);
}

// VIEW ADMIN
else if($_POST["action"] == "view-admin"){
	$data = array();
	//$data["msg"] = '<tr><td colspan="7">sss</td></tr>';
	$retHtml = '';

	//Pagination
	$pagn = '';		
	record_set('serRec', 'SELECT id FROM `admin_table`');
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
				ViewAdmin($(this).data("page-no"));
			});
		</script>';
	}
	$data["pagn"] = $pagn;

	record_set('getAdmin', 'SELECT * FROM `admin_table` LIMIT '.$startP.', '.$rpp);
	if($totalRows_getAdmin){
		$count = 0;
		while($rowData = mysqli_fetch_assoc($getAdmin)){
			if(empty($rowData["DOB"])){
				$dob = 'N/A';
			}else{ $dob = date("d-M-Y", strtotime($rowData["DOB"]));}
			$retHtml .= '
			<tr>
				<td>'.++$count.'</td>
					<td>'; if(file_exists($rowData["admin_img"])){
						$retHtml .='<img src="'.$rowData["admin_img"].'" height="60" width="60"/>'; 
						   }else{  $retHtml .= 'N/A'; }
					$retHtml .= '</td>
                  	<td>'.$rowData["name"].'</td>
                  	<td>'.$rowData["email_id"].'</td>
                  	<td>'.$rowData["phone"].'</td>
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
					admin_id: $(this).data("id"),
					status_val: $(this).data("status"),
					action: "change-status"
				};
				$.ajax({
					url: "api-admin",
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
					admin_id: $(this).data("id"),
					action: "load-update-form"
				};

				$.ajax({
					url: "api-admin.php",
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
			<td colspan="8">No Records found.</td>
		</tr>';
	}

	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//LOAD UPDATE FORM
else if($_POST["action"] == "load-update-form"){
	$data = array();
	//$data["msg"] = "load-update-form";
	$id = $_POST["admin_id"];
	$retHtml = '';

	record_set('getAdmin','SELECT * FROM `admin_table` WHERE id='.$id);
	if($totalRows_getAdmin){
		$rowData = mysqli_fetch_assoc($getAdmin);
		$dob = date("d-m-Y", strtotime($rowData["DOB"]));
		$retHtml .= '
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-default">
						
						<!--Form Start-->
						<form enctype="multipart/form-data">
							<input type="hidden" id="admin_id" value="'.$id.'">

						<!-- Card Header -->
						<!-- <div class="card-header"></div> -->

			<!--Card Body-->
			<div class="card-body">
				<div class="row">
					
					<!-- Admin Name -->
					<div class="col-md-6">
						<div class="form-group">
							<label>Admin Name</label>
							<input type="text" name="name" id="name" class="form-control" placeholder="Admin Name" value="'.$rowData["name"].'">
						</div>
					</div>

					<!-- Email -->
					<div class="col-md-6">
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" id="email" class="form-control" placeholder="xyz@yahoo.com" value="'.$rowData["email_id"].'">
						</div>
					</div>

					<!-- Phone no. -->
					<div class="col-md-3">
						<div class="form-group">
							<label>Phone no.</label>
							<input type="number" name="phone" id="phone" class="form-control" placeholder="7999945555" value="'.$rowData["phone"].'">
						</div>
					</div>

					<!-- Display Picture -->
					<div class="col-md-3">
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
					<div class="col-md-3">
						<label>Gender</label>
						<select class="form-control" id="gender">';
						$gen = Gender(); $sel='';
						foreach($gen as $key => $val){
							if($rowData["gender"] == $key){$sel='selected';}
							else{$sel='';}
							$retHtml .='<option value="'.$key.'" '.$sel.' >'.$val.'</option>';
						}
						$retHtml .='</select>
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

					<!-- Password & Status -->
					<div class="col-md-4">
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" id="password" class="form-control" placeholder="****">
						</div>
						<div class="form-group">
							<label>Status</label>
							<select class="form-control" id="status">';
						$stat = Status(); $sel='';
						  foreach($stat as $key=> $val){
						  	if($rowData["status"] == $key){$sel='selected';}
							else{$sel='';}
						  	$retHtml .='<option value="'.$key.'" '.$sel.' >'.$val.'</option>';
						  }
							$retHtml .='</select>
						</div>
					</div>

					<!-- Address -->
					<div class="col-md-8">
						<div class="form-group">
							<label>Address</label>
							<textarea rows="5" name="address" id="address" class="form-control" placeholder="address...">'.$rowData["address"].'</textarea>
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

			$("#update").click(function(){
				//alert("update");
				var name = $("#name").val();
				var password = $("#password").val();
				var email = $("#email").val();
				var phone = $("#phone").val();

				if(name == ""){
					$("#name").focus();
					return false;
				}
				// if(password == ""){
				// 	$("#password").focus();
				// 	return false;
				// }
				if(email == "" && phone == ""){
					alert("Please enter either phone or email !!");
					return false;
				}

				var formData = new FormData();
				var dp = $("#dp")[0].files[0];
				formData.append("img", dp);

				formData.append("name", name);
				formData.append("password", password);
				formData.append("email", email);
				formData.append("phone", phone);
				formData.append("admin_id", $("#admin_id").val());
				formData.append("gender", $("#gender").val());
				formData.append("status", $("#status").val());
				formData.append("address", $("#address").val());
				formData.append("dob", $("#dob").val());
				formData.append("action", "update-admin");

				$.ajax({
					url: "api-admin.php",
					type: "POST",
					data: formData,
					dataType: "JSON",
					encoding: true,
					contentType: false,
					processData: false,
					success: function(response){
								//alert(response.msg);
								if(response.dat == 1){
									alert("Admin updated.");
									$(".close").click();
									ViewAdmin();
								}else{ alert("Error updating admin. "+response.msg);}
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

// UPDATE ADMIN
else if($_POST["action"] == "update-admin"){
	$data = array();
	//$data["msg"] = 'update-admin';
	$data['dat'] = 0;
	$id = $_POST["admin_id"];
	$dob = str_replace('/', '-', $_POST["dob"]);

	if(!empty($_POST["email"])){
		record_set('getAdm',' SELECT id FROM `admin_table` WHERE email_id="'.$_POST["email"].'" AND id!='.$id);
		if($totalRows_getAdm){
			$data["msg"] = 'Email already in use.';
			echo json_encode($data, JSON_PRETTY_PRINT);
			exit(0);
		}
	}

	if(!empty($_POST["phone"])){
		record_set('getAdm',' SELECT id FROM `admin_table` WHERE phone="'.$_POST["phone"].'" AND id!='.$id);
		if($totalRows_getAdm){
			$data["msg"] = 'Phone no. already in use.';
			echo json_encode($data, JSON_PRETTY_PRINT);
			exit(0);
		}
	}	

	$formData = array(
		"name" => $_POST["name"],
		"email_id" => $_POST["email"],
		"phone" => $_POST["phone"],

		"gender" => $_POST["gender"],
		"address" => $_POST["address"],
		"DOB" => date("Y-m-d", strtotime($dob)),
		//"password" => md5($_POST["password"]),

		"status" => $_POST["status"],
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	if(!empty($_POST["password"])){
		$formData["password"] = md5($_POST["password"]);
	}

	$update = dbRowUpdate('admin_table', $formData, 'WHERE id='.$id);
	if($update > 0){
		$data['dat'] = 1;
		if($id == $_SESSION['user_id']){
			$_SESSION['user_name'] = $_POST['name'];
		}
		
		if(!empty($_FILES["img"]["name"])){
			$fName = 'admin_img_'.$id;
			$loc = ImageUpload2('img', 'images/admin_dp/', $fName);
			//$loc = ImageUpload('img', 'images/admin_dp/');
			if(file_exists($loc)){
				$fd = array("admin_img" => $loc);
				dbRowUpdate('admin_table', $fd, ' WHERE id='.$id);
				$data['msg'] = 'Everything went well & image inserted';
			}
			//else{ $data['msg'] = "error inserting image"; }
		}
	}
	//else{ $data['msg'] = "error adding admin"; }

	echo json_encode($data, JSON_PRETTY_PRINT);
}

//CHANGE STATUS
else if($_POST["action"] == 'change-status'){
	$data = array();
	$retHtml = '';
	$admin_id = $_POST["admin_id"];
	$old_status = $_POST["status_val"];

	if($old_status == 0){
		$new_status = 1;
	}else{ $new_status = 0;}

	$formData = array(
		"status" => $new_status,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	record_Set("getAdmin","SELECT id FROM `admin_table` WHERE id=".$admin_id);
	if($totalRows_getAdmin){
		dbRowUpdate('admin_table', $formData, 'WHERE id='.$admin_id);
	}

	record_Set("getAdmin","SELECT status FROM `admin_table` WHERE id=".$admin_id);
	if($totalRows_getAdmin){
		$rowData = mysqli_fetch_assoc($getAdmin);
		if($rowData["status"] == 1){
			$retHtml .= '<label class="badge badge-success btn-sm alt-tog" style="cursor:pointer" title="turn inactive" data-id="'.$admin_id.'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label>';
		}else{
			$retHtml .= '<label class="badge badge-danger btn-sm alt-tog" style="cursor:pointer" title="turn active" data-id="'.$admin_id.'" data-status="'.$rowData["status"].'">'.getStatus($rowData["status"]).'</label>';
		}
		$retHtml .= '
		<script>
			$(".alt-tog").click(function(){
				//alert($(this).data("status"));
				var myEle = $(this); //get current ele obj;
				var sendData = {
					admin_id: $(this).data("id"),
					status_val: $(this).data("status"),
					action: "change-status"
				};
				$.ajax({
					url: "api-admin",
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

// VIEW ADMIN
else if($_POST["action"] == "search-admin"){
	$data = array();
	//$data["msg"] = '<tr><td colspan="7">sss</td></tr>';
	$retHtml = '';

	if(strlen($_POST["search_key"]) != 0){
		$search_key =' WHERE name LIKE "%'.$_POST["search_key"].'%" LIMIT 7';
	}
	else{ $search_key = ' LIMIT 7'; }

	record_set('getAdmin', 'SELECT * FROM `admin_table` '.$search_key);
	if($totalRows_getAdmin){
		$count = 0;
		while($rowData = mysqli_fetch_assoc($getAdmin)){
			if(empty($rowData["DOB"])){
				$dob = 'N/A';
			}else{ $dob = date("d-M-Y", strtotime($rowData["DOB"]));}
			$retHtml .= '
			<tr>
				<td>'.++$count.'</td>
					<td>'; if(file_exists($rowData["admin_img"])){
						$retHtml .='<img src="'.$rowData["admin_img"].'" height="60" width="60"/>'; 
						   }else{  $retHtml .= 'N/A'; }
					$retHtml .= '</td>
                  	<td>'.$rowData["name"].'</td>
                  	<td>'.$rowData["email_id"].'</td>
                  	<td>'.$rowData["phone"].'</td>
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
					admin_id: $(this).data("id"),
					status_val: $(this).data("status"),
					action: "change-status"
				};
				$.ajax({
					url: "api-admin",
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
					admin_id: $(this).data("id"),
					action: "load-update-form"
				};

				$.ajax({
					url: "api-admin.php",
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
			<td colspan="8">No match found.</td>
		</tr>';
	}

	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}
?>