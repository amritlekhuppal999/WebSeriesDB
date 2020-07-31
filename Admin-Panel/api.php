<?php include('../function/function.php');

//LOGIN
if($_POST["action"] == "login"){
	$data = array();

	$email = $_POST['email'];
	$password = md5($_POST['password']);

	record_set('log_in','SELECT id, master_admin, name, admin_img from `admin_table` WHERE email_id="'.$email.'" AND password="'.$password.'"');
	if($totalRows_log_in){
		$rowData = mysqli_fetch_assoc($log_in);
		$_SESSION['user_id'] = $rowData['id'];
		$_SESSION['user_name'] = $rowData['name'];
		$_SESSION['user_img'] = $rowData['admin_img'];
		$_SESSION['master_admin'] = $rowData['master_admin'];
		
		$data['success'] = 1;	
		$data['msg'] = 'login successful !!';
	}
	else{
		$data['msg'] = 'incorrect email or password !!';
		$data['success'] = 0;
	}
	echo json_encode($data,JSON_PRETTY_PRINT);
}

//REGISTER
else if($_POST["action"] == "register"){
	$data = array();

	$name = $_POST["fullName"];
	$email = $_POST["email"];
	$password = md5($_POST["password"]);
	
	record_set('reg','SELECT id from `admin_table` WHERE email_id="'.$email.'"');
	if($totalRows_reg){
		$data['msg'] = 'email id already in use';	
		$data['success'] = 0;
	}
	else{
		$formData = array(
			"name" => $name,
			"email_id" => $email,
			"password" => $password,
			"status" => 1,
			"cip" => getClientIP(),
			"cdate" => DATE("Y-m-d h:i:s")
		);

		$insert = dbRowInsert('admin_table',$formData);
		if($insert){
			$_SESSION['user_id'] = $insert;
			$_SESSION['user_name'] = $name;
			
			$data['msg'] = 'admin added';
			$data['success'] = 1;
		}
		else{
			$data['success'] = 0;
			$data['msg'] = 'something went wrong';
		}
	}
	
	echo json_encode($data,JSON_PRETTY_PRINT);
}
?>