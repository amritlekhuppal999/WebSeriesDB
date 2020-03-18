<?php  include('connection_config.php');


//CRUD FUNCTIONS

function record_set($var1='', $var2=''){	//Read reocrds from database
	$sql = $var2;
	global  $$var1;
	global ${'totalRows_'.$var1};

	$conn = connection();		//To get connection object for database
	$$var1 = mysqli_query($conn,$sql);
	if(mysqli_num_rows($$var1)){
		${'totalRows_'.$var1} = mysqli_num_rows($$var1);
	}
	mysqli_close($conn);
}


function dbRowInsert($table_name,$table_data){		//Row insert function
	$conn = connection();
	$sql = 'INSERT INTO '.$table_name.' (';
	$array_count = count($table_data);
	$count = 0;
	foreach($table_data as $key => $val){ 
		$count++;
		if($count == $array_count){
			$sql .= $key.')';
		}
		else{
			$sql .= $key.',';
		}
	}
	$sql .= ' VALUES (';
	$count = 0;
	foreach($table_data as $key => $val){ 
		$count++;
		if($count == $array_count){
			$sql .= '"'.$val.'")';
		}
		else{
			$sql .= '"'.$val.'",';
		}
	}
	//echo $sql;
	if(mysqli_query($conn,$sql)){
		$insert_id = mysqli_insert_id($conn);
		return $insert_id;
		//echo 'Record Inserted';
	}
	//else {echo 'Error Inserting record';}
	mysqli_close($conn);
}

function dbRowUpdate($table_name, $table_data, $condition){		//Row update function
	$conn = connection();
	$sql = 'UPDATE '.$table_name.' SET ';
	$count = 0;
	$array_count = count($table_data);
	foreach($table_data as $key => $val){ 
		$count++;
		if($count == $array_count){
			$sql .= $key.'= "'.$val.'"';
		}
		else{
			$sql .= $key.'= "'.$val.'", ';
		}
	}
	if (strpos($condition, 'WHERE') !== false || strpos($condition, 'Where') !== false) {
    	$sql .= $condition;
	}
	else{ $sql .= ' WHERE '.$condition; }
	echo $sql;

	if(mysqli_query($conn,$sql)){
		return 1;
		//echo 'Record Inserted';
	}
	else {echo 'Error Inserting record';}
	mysqli_close($conn);
}


function dbRowDelete($table_name, $condition){
	$conn = connection();
	$sql = 'DELETE FROM '.$table_name;
	if (strpos($condition, 'WHERE') !== false || strpos($condition, 'Where') !== false) {
    	$sql .= $condition;
	}
	else{ $sql .= ' WHERE '.$condition; }

	if(mysqli_query($conn,$sql)){
		//return 1;
		echo 'Record deleted';
	}
	else {echo 'error deleting record';}
}

?>