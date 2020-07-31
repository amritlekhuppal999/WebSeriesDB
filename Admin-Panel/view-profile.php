<?php include('../function/function.php');?>
<!-- Page Header -->
<div class="content-header">
	<div class="container-fluid">
	  <div class="row mb-2">
	    <div class="col-sm-6">
	      <!-- <h1 class="m-0 text-dark">PROFILE</h1> -->
	    </div>
	  </div>
	</div>
</div>

<?php 
	$admin_id = $_SESSION['user_id'];
	record_set('getProf', 'SELECT * FROM `admin_table` WHERE id='.$admin_id);
	if($totalRows_getProf){
		$rowData = mysqli_fetch_assoc($getProf);
		$name = $rowData["name"];
		$email_id = $rowData["email_id"];
		$phone = $rowData["phone"];
		$dob = date("d-M-Y", strtotime($rowData["DOB"]));
		$address = $rowData["address"];

		if(!empty($rowData["gender"]) || $rowData["gender"]!=0){
			$gender = getGender($rowData["gender"]);
		}else{
			$gender = 'N/A';
		}
		
		if(file_exists($rowData["admin_img"])){
			$admin_img = $rowData["admin_img"];
		}else{
			if($gender == 1){
				$admin_img = '../images/in_design/male-avtar.jpg';
			}else{ 
				$admin_img = '../images/in_design/female-avtar.jpg';
			}
		}
	}
?>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-default">
					
					<!-- Card Header -->
					<div class="card-header">
						<h3 class="card-title"><b>ADMIN PROFILE</b></h3>
					</div>

		<!--Card Body-->
		<div class="card-body">
			<div class="row">

				<!-- PROFILE CARD -->
				<div class="col-md-4">
					<div class="card"> <!-- style="width:400px" -->
					  <img class="card-img-top" src="<?php echo $admin_img;?>" alt="Card image">
					  <div class="card-body">
					    <h4 class="card-title" style="font-size: 25px;"><b><?php echo $name;?></b></h4>
					    <p class="card-text" style="font-size: 25px;">
					    	<?php echo $email_id.'<br/>'.$phone.'<br/>';?>
					    	<?php echo '<b>Gender</b>: '.$gender.'<br/>';?>
					    	<?php echo '<b>Date of Birth</b>: '.$dob.'<br/>';?> <br>
					    	<?php echo '<b>Address</b>: <br/>'.$address.'<br/>';?>
					    </p>
					  </div>
					</div>
				</div>

				<!--UPDATE FORM-->
				<div class="col-md-8">
					<div class="card card-default">
						
						<!--Form Start-->
						<form enctype="multipart/form-data">
							<input type="hidden" id="admin_id" value="<?php echo $admin_id;?>">

						<!-- Card Header -->
						<!-- <div class="card-header"></div> -->

			<!--Card Body-->
			<div class="card-body">
				<div class="row">
					
					<!-- Admin Name -->
					<div class="col-md-6">
						<div class="form-group">
							<label>Admin Name</label>
							<input type="text" name="name" id="name" class="form-control" placeholder="Admin Name" value="<?php echo $name;?>">
						</div>
					</div>

					<!-- Email -->
					<div class="col-md-6">
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" id="email" class="form-control" placeholder="xyz@yahoo.com" value="<?php echo $email_id;?>">
						</div>
					</div>

					<!-- Phone no. -->
					<div class="col-md-3">
						<div class="form-group">
							<label>Phone no.</label>
							<input type="number" name="phone" id="phone" class="form-control" placeholder="7999945555" value="<?php echo $phone;?>">
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
						<?php $gen = Gender();
						foreach($gen as $key => $val){ ?>
							<option value="<?php echo $key;?>" <?php if($rowData["gender"] == $key){echo 'selected';}?>><?php echo $val;?></option>
						<?php } ?>
						</select>
					</div>

					<!-- DOB -->
					<div class="col-md-3">
						<div class="form-group">
		                  <label>Date of Birth</label>
		                  <div class="input-group">
		                    <div class="input-group-prepend">
		                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
		                    </div>
		                    <input id="dob" type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask value="<?php echo date("d-m-Y", strtotime($dob));?>">
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
						<?php $stat = Status();
						  foreach($stat as $key=> $val){?>
						  	<option value="<?php echo $key;?>" <?php if($rowData["status"] == $key){echo 'selected';}?>><?php echo $val;?></option>
						<?php  } ?>
							</select>
						</div>
					</div>

					<!-- Address -->
					<div class="col-md-8">
						<div class="form-group">
							<label>Address</label>
							<textarea rows="5" name="address" id="address" class="form-control" placeholder="address..."><?php echo $address;?></textarea>
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

						<!-- Card Footer -->
						<!-- <div class="card-footer">
						  <a id="edit" data-id="<?php echo $admin_id;?>" data-toggle="modal" data-target="#exampleModal"class="btn btn-default">Edit</a>
						</div> -->
				</div>
			</div>

		</div>
	</div>



</section>

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
							alert("Profile updated.");
							LoadPage("view-profile.php");
						}else{ alert("Error updating profile. "+response.msg);}

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
</script>


<script>
	$(function () {
		//Initialize Select2 Elements
		$('.select2').select2()

		//Initialize Select2 Elements
		$('.select2bs4').select2({
		  theme: 'bootstrap4'
		})

	  //Datemask dd/mm/yyyy
	  $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
	  //Datemask2 mm/dd/yyyy
	  $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy'});

	  //Date mask & Money Euro
	  $('[data-mask]').inputmask()
	});
</script>