<?php 

require_once '../includes/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['password']) and isset($_POST['email'])){
		$db = new DbOperations(); 

		if($db->updateFacultyPassword($_POST['password'], $_POST['email'])){
			
					}else{
			$response['error'] = false; 
			$response['message'] = "Password updated was successfully";			
		}

	}else{
		$response['error'] = true; 
		$response['message'] = "Required fields are missing";
	}
}

echo json_encode($response);