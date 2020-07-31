<?php include('mysql_function.php');
session_start();

function HomeUrl(){
	return 'http://localhost/ALU/WebSeriesDB/';
}
function AdminHomeUrl(){
    return 'http://localhost/ALU/WebSeriesDB/Admin-Panel/';
}

function ReDirect($location){
	header('location:'.$location);
}

function CheckAdminLogin(){
	if(!empty($_SESSION["user_id"])){
	    //$home_url = AdminHomeUrl();
		ReDirect(AdminHomeUrl());
		//echo 'User is: '.$_SESSION["user_name"];
	}	
}

function IndexAdminLogin(){
	if(empty($_SESSION["user_id"])){
		$home_url = AdminHomeUrl();
		ReDirect($home_url.'login.php');
	}
}

function getClientIP() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


function Genres(){
    return array(
        "1" => "Action",
        "2" => "Comedy",
        "3" => "Crime",
        "4" => "Documentary",
        "5" => "Drama",
        "6" => "Fantasy",
        "7" => "Food & Travel",
        "8" => "History",
        "9" => "Horror",
        "10" => "Kids",
        "11" => "Nature",
        "12" => "Romance",
        "13" => "Science",
        "14" => "Sci-fi",
        "15" => "Teen",
        "16" => "Thriller",
        "17" => "Slice of Life"
    );
}

//List Certificates
function sCertificate(){
    return array(
        "1" => "U - Universal",
        "2" => "UA - Parental Guidence",
        "3" => "A - Adult"
        // "4" => "S",
        // "5" => "V/U|V/UA|V/A"
    );
}
//Get Certificates
function getCertificate($sc){
    $a = sCertificate();
    return $a[$sc];
}

function ImageUpload($filePara, $dest){
    $fileName = $_FILES[$filePara]['name'];
    $tempName = $_FILES[$filePara]['tmp_name'];
    $fileSize = $_FILES[$filePara]['size'];

    //$dir = 'images/'.$dest;
    
    $extension = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));
    $fileName = rand(); $fileName .= '.'.$extension; 
    $targetFile = $dest.$fileName;
    $ext_arr = array("png", "jpeg", "jpg", "gif");
    
    $check = getimagesize($tempName);
    if($check !== false){
        
        if(in_array($extension, $ext_arr)){
            if($fileSize < 2000000){ //2MB or 2000000Byte
               if(!file_exists($targetFile)){
                    if(move_uploaded_file($tempName, $targetFile)){
                        //echo $fileName.' is uploaded';
                        return $targetFile;
                    }
                    //else{ echo 'failed to upload';}
                }
                //else{ echo "file already present"; }
            }
            //else{ echo "file too large"; }
        }
        //else{ echo "file already present"; }
    }
    //else{ echo "file not an image"; }
}
function ImageUpload2($filePara, $dest, $fName){
    $fileName = $_FILES[$filePara]['name'];
    $tempName = $_FILES[$filePara]['tmp_name'];
    $fileSize = $_FILES[$filePara]['size'];

    //$dir = 'images/'.$dest;
    
    $extension = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));
    $fileName = $fName; $fileName .= '.'.$extension; 
    $targetFile = $dest.$fileName;
    $ext_arr = array("png", "jpeg", "jpg", "gif");
    
    $check = getimagesize($tempName);
    if($check !== false){
        
        if(in_array($extension, $ext_arr)){
            if($fileSize < 2000000){ //2MB or 2000000Byte
               if(move_uploaded_file($tempName, $targetFile)){
                    //echo $fileName.' is uploaded';
                    return $targetFile;
                }
                //else{ echo 'failed to upload';}
            }
            //else{ echo "file too large"; }
        }
        //else{ echo "file already present"; }
    }
    //else{ echo "file not an image"; }
}

//Status Option
function Status(){
    return array(
        "0" => "Inactive",
        "1" => "Active"
    );
}
//Get Status
function getStatus($s){
    $a = Status();
    return $a[$s];
}

//Gender Option
function Gender(){
    return array(
        "1" => "Male",
        "2" => "Female",
        "3" => "Other"
    );
}
//Get Gender
function getGender($g){
    $gender = Gender();
    return $gender[$g];
}

?>
