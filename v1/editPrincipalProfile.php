<?php 

require_once '../includes/DbOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['mobileno']) and isset($_POST['email'])){
		$db = new DbOperations(); 

		if($db->editPrincipalProfile($_POST['mobileno'], $_POST['email'])){
			
			$response['error'] = false; 
			$response['message'] = "Profile Updated Successfully";			
		
			}
				else{
			$response['error'] = true; 
			$response['message'] = "Profile couldn't be updated";			
		}

	}else{
		$response['error'] = true; 
		$response['message'] = "Required fields are missing";
	}
}

echo json_encode($response);