<?php 

require_once '../includes/DbOperations.php';

$response = array(); 
$array=[];
if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['designation'])){
		$db = new DbOperations(); 

		
			$notice = $db->getHierarchy($_POST['designation']);
			while($user = mysqli_fetch_assoc($notice)){
			$response['value'] = $user['value'];
			
		}
		
	}else{
		$response['error'] = true; 
		$response['message'] = "Required fields are missing";
	}
}

echo json_encode($response);