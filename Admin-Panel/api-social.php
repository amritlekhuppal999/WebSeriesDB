<?php include('../function/function.php');

//THIS ORDER MUST BE MAINTAINED !
// 1 => SERIES
// 2 => ACTOR
// 3 => DIRECTOR
// 4 => WRITER
// 5 => PRODUCER
// 6 => PLATFORM

//LOAD SELECTED CATEGORY OPTIONS
if($_POST["action"] == "get-cate-data"){
	$data = array();
	//$data["msg"] = "get-cate-data";
	
	$retHtml = '';

	if(!empty($_POST["cate_val"])){
		$retHtml .= '<input type="hidden" id="cat_type" value="'.$_POST["cate_val"].'">
		<label>'.$_POST["cate_text"].'</label>
		<select class="form-control select2" id="op-dat">
			<option value="0">Select</option>';

		switch($_POST["cate_val"]){
			case 1: record_set('getSer','SELECT id,title FROM `series_list`');
					if($totalRows_getSer){
						while($rowData = mysqli_fetch_assoc($getSer)){
							$retHtml .='<option value="'.$rowData["id"].'">'.$rowData["title"].'</option>';
						}
					}
					break;

			case 2: record_set('getAct','SELECT id,name FROM `actor_list`');
					if($totalRows_getAct){
						while($rowData = mysqli_fetch_assoc($getAct)){
							$retHtml .='<option value="'.$rowData["id"].'">'.$rowData["name"].'</option>';
						}
					}
					break;

			case 3: record_set('getDir','SELECT id,name FROM `director_list`');
					if($totalRows_getDir){
						while($rowData = mysqli_fetch_assoc($getDir)){
							$retHtml .='<option value="'.$rowData["id"].'">'.$rowData["name"].'</option>';
						}
					}
					break;

			case 4: record_set('getWrite','SELECT id,name FROM `writer_list`');
					if($totalRows_getWrite){
						while($rowData = mysqli_fetch_assoc($getWrite)){
							$retHtml .='<option value="'.$rowData["id"].'">'.$rowData["name"].'</option>';
						}
					}
					break;

			case 5: record_set('getPro','SELECT id,name FROM `producer_list`');
					if($totalRows_getPro){
						while($rowData = mysqli_fetch_assoc($getPro)){
							$retHtml .='<option value="'.$rowData["id"].'">'.$rowData["name"].'</option>';
						}
					}
					break;

			case 6: record_set('getPlat','SELECT id,name FROM `platform`');
					if($totalRows_getPlat){
						while($rowData = mysqli_fetch_assoc($getPlat)){
							$retHtml .='<option value="'.$rowData["id"].'">'.$rowData["name"].'</option>';
						}
					}
					break;

			default: $retHtml .='<option value="0">Select</option>';
		}

		$retHtml .= '</select>
		<script>
			$("#op-dat").change(function(){
				//alert($(this).val());
				var sendData = {
					cat_type_id: $("#cat_type").val(),
					option_id: $(this).val(),
					option_text: $("#op-dat option:selected").html(),';

					if($_POST["task"] == "add"){
						$retHtml .= 'action: "load-form"';
					}else if($_POST["task"] == "update"){
						$retHtml .= 'action: "load-update-form"';
					}

					$retHtml .= '
				};
				$.ajax({
					url: "api-social.php",
					type: "POST",
					data: sendData,
					dataType: "JSON",
					encoding: true,
					success: function(response){
								//alert(response.msg);
								$("#load-form").html(response.dat);
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

//LOAD FORM
else if($_POST["action"] == "load-form"){
	$data = array();
	//$data["msg"] = "";

	$retHtml = '';

	$cat_type_id = $_POST["cat_type_id"];
	$option_id = $_POST["option_id"];
	$option_text = $_POST["option_text"];

	$retHtml .= '
	<form>
		<!--Card Header-->
        <div class="card-footer">
          <h3 class="card-title">Add Social Media Accounts</h3>
        </div>

        <input type="hidden" name="cat_type_id" id="cat_type_id" value="'.$cat_type_id.'"/>
        <input type="hidden" name="opt_id" id="opt_id" value="'.$option_id.'"/>

		<!--Card Body-->
		<div class="card-body">
			<div class="row">
				
				<!-- Insta Handle -->
				<div class="col-md-12">
					<div class="form-group">
						<h2>'.$option_text.'</h2>
					</div>
				</div>

				<!-- Insta Handle -->
				<div class="col-md-6">
					<div class="form-group">
						<label>Insta Handle</label>
						<input type="text" name="insta_link" id="insta_link" class="form-control" placeholder="Insta Handle">
					</div>
				</div>

				<!-- FB Handle -->
				<div class="col-md-6">
					<div class="form-group">
						<label>Facebook Handle</label>
						<input type="text" name="fb_link" id="fb_link" class="form-control" placeholder="Facebook Handle">
					</div>
				</div>

				<!-- Snapchat Handle -->
				<div class="col-md-6">
					<div class="form-group">
						<label>Snapchat Handle</label>
						<input type="text" name="snap_link" id="snap_link" class="form-control" placeholder="Snapchat Handle">
					</div>
				</div>

				<!-- Youtube Handle -->
				<div class="col-md-6">
					<div class="form-group">
						<label>Youtube Handle</label>
						<input type="text" name="yt_link" id="yt_link" class="form-control" placeholder="Youtube Handle">
					</div>
				</div>

				<!-- Twitter Handle -->
				<div class="col-md-6">
					<div class="form-group">
						<label>Twitter Handle</label>
						<input type="text" name="twt_link" id="twt_link" class="form-control" placeholder="Twitter Handle">
					</div>
				</div>

				<!-- TikTok Handle -->
				<div class="col-md-6">
					<div class="form-group">
						<label>TikTok Handle</label>
						<input type="text" name="tt_link" id="tt_link" class="form-control" placeholder="TikTok Handle">
					</div>
				</div>
			</div>
		</div>

		<!-- Card Footer -->
		<div class="card-footer">
		  <a id="submit" class="btn btn-default">Submit</a>
		</div>
	</form>

	<script>
		$("#submit").click(function(){

			var sendData = {
				cat_type_id: $("#cat_type_id").val(),
				option_id: $("#opt_id").val(),

				insta_link: $("#insta_link").val(),
				fb_link: $("#fb_link").val(),
				snap_link: $("#snap_link").val(),
				yt_link: $("#yt_link").val(),
				twt_link: $("#twt_link").val(),
				tt_link: $("#tt_link").val(),
				action: "add-social-acc"
			};

			//alert(sendData.fb_link); 

			if(sendData.insta_link == "" && sendData.fb_link == "" && sendData.snap_link == "" && sendData.yt_link == "" && sendData.twt_link == "" && sendData.tt_link == ""){

				$("#insta_link").focus()
				alert("Add at least one account.");
				return false;
			}

			$.ajax({
				url: "api-social.php",
				type: "POST",
				data: sendData,
				dataType: "JSON",
				encoding: true,
				success: function(response){
							//alert(response.msg);
							if(response.dat==1){
								alert("Social Account Added");
								$("#add-social").click();
							}
							else{ alert("Error adding account. "+response.msg); }
						 }
			});
		});
	</script>';
 
	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//ADD SOCIAL ACCOUNT
else if($_POST["action"] == "add-social-acc"){
	$data = array();
	//$data["msg"] = "add accounts";

	$cat_type_id = $_POST["cat_type_id"];
	$option_id = $_POST["option_id"];

	//check weather the respective actor/series/writer is already added or not.
	switch($cat_type_id){
		case 1: record_set('getSer','SELECT id FROM `series_social_account` WHERE series_id='.$option_id);
				if($totalRows_getSer){
					$data["msg"] = "Social account for this series has already been added. Cannot add more than one.";
					echo json_encode($data, JSON_PRETTY_PRINT);
					exit(0);
				}
				break;

		case 2: record_set('getAct','SELECT id FROM `actor_social_account` WHERE actor_id='.$option_id);
				if($totalRows_getAct){
					$data["msg"] = "Social account for this actor has already been added. Cannot add more than one.";
					echo json_encode($data, JSON_PRETTY_PRINT);
					exit(0);
				}
				break;

		case 3: record_set('getDir','SELECT id FROM `director_social_account` WHERE director_id='.$option_id);
				if($totalRows_getDir){
					$data["msg"] = "Social account for this director has already been added. Cannot add more than one.";
					echo json_encode($data, JSON_PRETTY_PRINT);
					exit(0);
				}
				break;

		case 4: record_set('getWr','SELECT id FROM `writer_social_account` WHERE writer_id='.$option_id);
				if($totalRows_getWr){
					$data["msg"] = "Social account for this writer has already been added. Cannot add more than one.";
					echo json_encode($data, JSON_PRETTY_PRINT);
					exit(0);
				}
				break;

		case 5: record_set('getProd','SELECT id FROM `producer_social_account` WHERE producer_id='.$option_id);
				if($totalRows_getProd){
					$data["msg"] = "Social account for this producer has already been added. Cannot add more than one.";
					echo json_encode($data, JSON_PRETTY_PRINT);
					exit(0);
				}
				break;

		case 6: record_set('getPlat','SELECT id FROM `platform_social_account` WHERE platform_id='.$option_id);
				if($totalRows_getPlat){
					$data["msg"] = "Social account for this platform has already been added. Cannot add more than one.";
					echo json_encode($data, JSON_PRETTY_PRINT);
					exit(0);
				}
				break;
		default: "";
	}

	$formData = array(
		"insta_link" => $_POST["insta_link"],
		"fb_link" => $_POST["fb_link"],
		"snapchat_link" => $_POST["snap_link"],
		"youtube_link" => $_POST["yt_link"],
		"twitter_link" => $_POST["twt_link"],
		"tiktok_link" => $_POST["tt_link"],

		"status" => 1,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	$data['dat'] = 0;
	switch($cat_type_id){

		case 1: $formData["series_id"] = $option_id;
				$insert = dbRowInsert('series_social_account', $formData);
				if($insert > 0){
					$data['dat'] = 1;
				}else{ $data['msg'] = "error adding social acc."; }
				break;

		case 2: $formData["actor_id"] = $option_id;
				$insert = dbRowInsert('actor_social_account', $formData);
				if($insert > 0){
					$data['dat'] = 1;
				}else{ $data['msg'] = "error adding social acc."; }
				break;

		case 3: $formData["director_id"] = $option_id;
				$insert = dbRowInsert('director_social_account', $formData);
				if($insert > 0){
					$data['dat'] = 1;
				}else{ $data['msg'] = "error adding social acc."; }
				break;

		case 4: $formData["writer_id"] = $option_id;
				$insert = dbRowInsert('writer_social_account', $formData);
				if($insert > 0){
					$data['dat'] = 1;
				}else{ $data['msg'] = "error adding social acc."; }
				break;

		case 5: $formData["producer_id"] = $option_id;
				$insert = dbRowInsert('producer_social_account', $formData);
				if($insert > 0){
					$data['dat'] = 1;
				}else{ $data['msg'] = "error adding social acc."; }
				break;

		case 6: $formData["platform_id"] = $option_id;
				$insert = dbRowInsert('platform_social_account', $formData);
				if($insert > 0){
					$data['dat'] = 1;
				}else{ $data['msg'] = "error adding social acc."; }
				break;

		default: $data['msg'] = "What did you enter?";;
	}
	
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//LOAD UPDATE FORM
else if($_POST["action"] == "load-update-form"){
	$data = array();
	//$data["msg"] = "";

	$retHtml = '';

	$cat_type_id = $_POST["cat_type_id"];
	$option_id = $_POST["option_id"];
	$option_text = $_POST["option_text"];

	$insta=''; $fb=''; $snap=''; $tiktok=''; $youtube=''; $twitter='';
	switch($cat_type_id){
		case 1: record_set('getSer','SELECT id, insta_link, fb_link, snapchat_link, tiktok_link, youtube_link, twitter_link FROM `series_social_account` WHERE series_id='.$option_id);
				if($totalRows_getSer){
					$rowData = mysqli_fetch_assoc($getSer);
					$insta = $rowData["insta_link"];
					$fb = $rowData["fb_link"];
					$snap = $rowData["snapchat_link"];
					$tiktok = $rowData["tiktok_link"];
					$youtube = $rowData["youtube_link"];
					$twitter = $rowData["twitter_link"];
				}
				else{
					$data["dat"] = '
					<div class="card-footer">
			          <h3 class="card-title">No Records Found.</h3>
			        </div>';
					echo json_encode($data, JSON_PRETTY_PRINT);
					exit();
				}
				break;

		case 2: record_set('getAct','SELECT id, insta_link, fb_link, snapchat_link, tiktok_link, youtube_link, twitter_link FROM `actor_social_account` WHERE actor_id='.$option_id);
				if($totalRows_getAct){
					$rowData = mysqli_fetch_assoc($getAct);
					$insta = $rowData["insta_link"];
					$fb = $rowData["fb_link"];
					$snap = $rowData["snapchat_link"];
					$tiktok = $rowData["tiktok_link"];
					$youtube = $rowData["youtube_link"];
					$twitter = $rowData["twitter_link"];
				}
				else{
					$data["dat"] = '
					<div class="card-footer">
			          <h3 class="card-title">No Records Found.</h3>
			        </div>';
					echo json_encode($data, JSON_PRETTY_PRINT);
					exit();
				}
				break;

		case 3: record_set('getDir','SELECT id, insta_link, fb_link, snapchat_link, tiktok_link, youtube_link, twitter_link FROM `director_social_account` WHERE director_id='.$option_id);
				if($totalRows_getDir){
					$rowData = mysqli_fetch_assoc($getDir);
					$insta = $rowData["insta_link"];
					$fb = $rowData["fb_link"];
					$snap = $rowData["snapchat_link"];
					$tiktok = $rowData["tiktok_link"];
					$youtube = $rowData["youtube_link"];
					$twitter = $rowData["twitter_link"];
				}
				else{
					$data["dat"] = '
					<div class="card-footer">
			          <h3 class="card-title">No Records Found.</h3>
			        </div>';
					echo json_encode($data, JSON_PRETTY_PRINT);
					exit();
				}
				break;

		case 4: record_set('getWr','SELECT id, insta_link, fb_link, snapchat_link, tiktok_link, youtube_link, twitter_link FROM `writer_social_account` WHERE writer_id='.$option_id);
				if($totalRows_getWr){
					$rowData = mysqli_fetch_assoc($getWr);
					$insta = $rowData["insta_link"];
					$fb = $rowData["fb_link"];
					$snap = $rowData["snapchat_link"];
					$tiktok = $rowData["tiktok_link"];
					$youtube = $rowData["youtube_link"];
					$twitter = $rowData["twitter_link"];
				}
				else{
					$data["dat"] = '
					<div class="card-footer">
			          <h3 class="card-title">No Records Found.</h3>
			        </div>';
					echo json_encode($data, JSON_PRETTY_PRINT);
					exit();
				}
				break;

		case 5: record_set('getProd','SELECT id, insta_link, fb_link, snapchat_link, tiktok_link, youtube_link, twitter_link FROM `producer_social_account` WHERE producer_id='.$option_id);
				if($totalRows_getProd){
					$rowData = mysqli_fetch_assoc($getProd);
					$insta = $rowData["insta_link"];
					$fb = $rowData["fb_link"];
					$snap = $rowData["snapchat_link"];
					$tiktok = $rowData["tiktok_link"];
					$youtube = $rowData["youtube_link"];
					$twitter = $rowData["twitter_link"];
				}
				else{
					$data["dat"] = '
					<div class="card-footer">
			          <h3 class="card-title">No Records Found.</h3>
			        </div>';
					echo json_encode($data, JSON_PRETTY_PRINT);
					exit();
				}
				break;

		case 6: record_set('getPlat','SELECT id, insta_link, fb_link, snapchat_link, tiktok_link, youtube_link, twitter_link FROM `platform_social_account` WHERE platform_id='.$option_id);
				if($totalRows_getPlat){
					$rowData = mysqli_fetch_assoc($getPlat);
					$insta = $rowData["insta_link"];
					$fb = $rowData["fb_link"];
					$snap = $rowData["snapchat_link"];
					$tiktok = $rowData["tiktok_link"];
					$youtube = $rowData["youtube_link"];
					$twitter = $rowData["twitter_link"];
				}
				else{
					$data["dat"] = '
					<div class="card-footer">
			          <h3 class="card-title">No Records Found.</h3>
			        </div>';
					echo json_encode($data, JSON_PRETTY_PRINT);
					exit();
				}
				break;

		default: $data["msg"] = 'What did you select?';
	}

	$retHtml .= '
	<form>
		<!--Card Header-->
        <div class="card-footer">
          <h3 class="card-title">Update Social Media Accounts</h3>
        </div>

        <input type="hidden" name="cat_type_id" id="cat_type_id" value="'.$cat_type_id.'"/>
        <input type="hidden" name="opt_id" id="opt_id" value="'.$option_id.'"/>

		<!--Card Body-->
		<div class="card-body">
			<div class="row">
				
				<!-- Insta Handle -->
				<div class="col-md-12">
					<div class="form-group">
						<h2>'.$option_text.'</h2>
					</div>
				</div>

				<!-- Insta Handle -->
				<div class="col-md-6">
					<div class="form-group">
						<label>Insta Handle</label>
						<input type="text" name="insta_link" id="insta_link" class="form-control" placeholder="Insta Handle" value="'.$insta.'">
					</div>
				</div>

				<!-- FB Handle -->
				<div class="col-md-6">
					<div class="form-group">
						<label>Facebook Handle</label>
						<input type="text" name="fb_link" id="fb_link" class="form-control" placeholder="Facebook Handle" value="'.$fb.'">
					</div>
				</div>

				<!-- Snapchat Handle -->
				<div class="col-md-6">
					<div class="form-group">
						<label>Snapchat Handle</label>
						<input type="text" name="snap_link" id="snap_link" class="form-control" placeholder="Snapchat Handle" value="'.$snap.'">
					</div>
				</div>

				<!-- Youtube Handle -->
				<div class="col-md-6">
					<div class="form-group">
						<label>Youtube Handle</label>
						<input type="text" name="yt_link" id="yt_link" class="form-control" placeholder="Youtube Handle" value="'.$youtube.'">
					</div>
				</div>

				<!-- Twitter Handle -->
				<div class="col-md-6">
					<div class="form-group">
						<label>Twitter Handle</label>
						<input type="text" name="twt_link" id="twt_link" class="form-control" placeholder="Twitter Handle" value="'.$twitter.'">
					</div>
				</div>

				<!-- TikTok Handle -->
				<div class="col-md-6">
					<div class="form-group">
						<label>TikTok Handle</label>
						<input type="text" name="tt_link" id="tt_link" class="form-control" placeholder="TikTok Handle" value="'.$tiktok.'">
					</div>
				</div>
			</div>
		</div>

		<!-- Card Footer -->
		<div class="card-footer">
		  <a id="submit" class="btn btn-default">Update</a>
		</div>
	</form>

	<script>
		$("#submit").click(function(){

			var sendData = {
				cat_type_id: $("#cat_type_id").val(),
				option_id: $("#opt_id").val(),

				insta_link: $("#insta_link").val(),
				fb_link: $("#fb_link").val(),
				snap_link: $("#snap_link").val(),
				yt_link: $("#yt_link").val(),
				twt_link: $("#twt_link").val(),
				tt_link: $("#tt_link").val(),
				action: "update-social-acc"
			};

			//alert(sendData.fb_link); 

			if(sendData.insta_link == "" && sendData.fb_link == "" && sendData.snap_link == "" && sendData.yt_link == "" && sendData.twt_link == "" && sendData.tt_link == ""){

				$("#insta_link").focus()
				alert("Add at least one account.");
				return false;
			}

			$.ajax({
				url: "api-social.php",
				type: "POST",
				data: sendData,
				dataType: "JSON",
				encoding: true,
				success: function(response){
							//alert(response.msg);
							if(response.dat==1){
								alert("Social Account updated");
								//$("#view-social").click();
							}
							else{ alert("Error updating account. "+response.msg); }
						 }
			});
		});
	</script>';
 
	$data["dat"] = $retHtml;
	echo json_encode($data, JSON_PRETTY_PRINT);
}

//UPDATE SOCIAL ACCOUNT
else if($_POST["action"] == "update-social-acc"){
	$data = array();
	//$data["msg"] = "add accounts";

	$cat_type_id = $_POST["cat_type_id"];
	$option_id = $_POST["option_id"];

	$formData = array(
		"insta_link" => $_POST["insta_link"],
		"fb_link" => $_POST["fb_link"],
		"snapchat_link" => $_POST["snap_link"],
		"youtube_link" => $_POST["yt_link"],
		"twitter_link" => $_POST["twt_link"],
		"tiktok_link" => $_POST["tt_link"],

		"status" => 1,
		"cip" => getClientIP(),
		"cdate" => DATE("Y-m-d h:i:s")
	);

	$data['dat'] = 0;
	switch($cat_type_id){

		case 1: 
				if(dbRowUpdate('series_social_account', $formData, 'WHERE series_id='.$option_id)){
					$data['dat'] = 1;
				}else{ $data['msg'] = "error updating social acc."; }
				break;

		case 2: 
				if(dbRowUpdate('actor_social_account', $formData, 'WHERE actor_id='.$option_id)){
					$data['dat'] = 1;
				}else{ $data['msg'] = "error updating social acc."; }
				break;

		case 3: if(dbRowUpdate('director_social_account', $formData, 'WHERE director_id='.$option_id)){
					$data['dat'] = 1;
				}else{ $data['msg'] = "error updating social acc."; }
				break;

		case 4: if(dbRowUpdate('writer_social_account', $formData, 'WHERE writer_id='.$option_id)){
					$data['dat'] = 1;
				}else{ $data['msg'] = "error updating social acc."; }
				break;

		case 5: if(dbRowUpdate('producer_social_account', $formData, 'WHERE producer_id='.$option_id)){
					$data['dat'] = 1;
				}else{ $data['msg'] = "error updating social acc."; }
				break;

		case 6: if(dbRowUpdate('platform_social_account', $formData, 'WHERE platform_id='.$option_id)){
					$data['dat'] = 1;
				}else{ $data['msg'] = "error updating social acc."; }
				break;

		default: $data['msg'] = "What did you enter?";
	}
	
	echo json_encode($data, JSON_PRETTY_PRINT);
}

// switch(){
// 	case 1: #series
// 			break;
// 	case 2: 
// 			break;
// 	case 3: 
// 			break;
// 	case 4: 
// 			break;
// 	case 5: 
// 			break;
// 	case 6: 
// 			break;
// }
?>