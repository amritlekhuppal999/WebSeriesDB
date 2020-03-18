<?php //include('mysql_function.php');
//session_start();

function LocalHomeUrl(){
	return 'http://localhost/ALU/MyProfile/';
}

function ReDirect($location){
	header('location:'.$location);
}

function CheckLogin(){
	if(!empty($_SESSION["user_id"])){
	    //$home_url = LocalHomeUrl();
		ReDirect(LocalHomeUrl());
		// echo 'User is: '.$_SESSION["user_name"];
	}
}

function IndexCheckLogin(){
	if(empty($_SESSION["user_id"])){
		$home_url = LocalHomeUrl();
		ReDirect($home_url.'login.php');
	}
}

function Content(){
	return array(
		"ABOUT", "PROJECTS", "EXPERIENCE", "EDUCATION", "SKILL SET", "INTERESTS"
	);
}

?>