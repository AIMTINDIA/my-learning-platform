<?php

include '../components/connect.php';

if($_GET['type'] == 'studentname'){
	$result = $conn->prepare("SELECT name,contact_no FROM `users` where balance>0 and (name LIKE '%".$_GET['name_startsWith']."%' or contact_no LIKE '%".$_GET['name_startsWith']."%')");
    $result->execute();
	#$result = $conn->query("SELECT name,contact_no FROM users where balance>0 and (name LIKE '%".$_GET['name_startsWith']."%' or contact_no LIKE '%".$_GET['name_startsWith']."%')   ");	
	$data = array();
	#while ($row = $result->fetch_assoc())
    while($row = $result->fetch(PDO::FETCH_ASSOC))		{
		//array_push($data, $row['sname'].'-'.$row['contact']);	
		array_push($data, $row['name']);	
	}	
	echo json_encode($data);
}


if($_GET['type'] == 'report'){
	$result = $conn->prepare("SELECT name,contact_no FROM `users` where (name LIKE '%".$_GET['name_startsWith']."%' or contact_no LIKE '%".$_GET['name_startsWith']."%')   ");
	$result->execute();
	#$result = $conn->query("SELECT name,contact_no FROM users where (name LIKE '%".$_GET['name_startsWith']."%' or contact_no LIKE '%".$_GET['name_startsWith']."%')   ");	
	$data = array();
	#while ($row = $result->fetch_assoc()) 
	while($row = $result->fetch(PDO::FETCH_ASSOC)){
		//array_push($data, $row['sname'].'-'.$row['contact']);	
		array_push($data, $row['name']);	
	}	
	echo json_encode($data);
}


?>