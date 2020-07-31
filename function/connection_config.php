<?php 

function connection(){

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'web_series_db';

	$conn= mysqli_connect($servername, $username, $password, $dbname);

	if($conn){
		return $conn;
	}
	else{
		die("Connection failed: " . mysqli_connect_error());
	}
}



//echo 'connected successfully';
?>