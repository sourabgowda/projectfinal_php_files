<?php 

require_once '../includes/DbOperations.php';

$response = array(); 
$array=[];
if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['dept']) and isset($_POST['sem']) and isset($_POST['section'])){
		$db = new DbOperations(); 

		
			$notice = $db->getIndividualStudent($_POST['dept'], $_POST['sem'], $_POST['section']);
			while($user = mysqli_fetch_assoc($notice)){ 
			$response['name'] = $user['name'];
			$array[]=$response;
		}
		
	}else{
		$response['error'] = true; 
		$response['message'] = "Required fields are missing";
	}
}

echo json_encode($array);