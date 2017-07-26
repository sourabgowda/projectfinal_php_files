<?php 

require_once '../includes/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['mobileno']) and isset($_POST['email'])){
		$db = new DbOperations(); 

		if($db->updateFaculty($_POST['mobileno'], $_POST['email'])){
			
					}else{
			$response['error'] = false; 
			$response['message'] = "Update was successful";			
		}

	}else{
		$response['error'] = true; 
		$response['message'] = "Required fields are missing";
	}
}

echo json_encode($response);