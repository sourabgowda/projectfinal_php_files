<?php 

require_once '../includes/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['name']) and isset($_POST['mobileno']) and isset($_POST['sem']) and isset($_POST['section']) and isset($_POST['usn'])){
		$db = new DbOperations(); 

		if($db->updateStudent($_POST['mobileno'], $_POST['sem'], $_POST['section'], $_POST['usn'])){
			$user = $db->getStudentByUsername($_POST['name']);
			$response['error'] = false; 
			$response['name'] = $user['name'];
			$response['email'] = $user['email'];
			$response['mobileno'] = $user['mobileno'];
			$response['dept'] = $user['dept'];
			$response['sem'] = $user['sem'];
			$response['usn'] = $user['usn'];
			$response['section']=$user['section'];
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