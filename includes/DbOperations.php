<?php 

	class DbOperations{

		private $con; 

		function __construct(){

			require_once dirname(__FILE__).'/DbConnect.php';

			$db = new DbConnect();

			$this->con = $db->connect();

		}

		/*CRUD -> C -> CREATE */

		//To Insert Principal
		public function createUser($name, $email, $pass, $mobileno){
			if($this->isUserExist($name,$mobileno)){
				return 0; 
			}else{
				$password = $pass;
				$stmt = $this->con->prepare("INSERT INTO `principal` (`name`, `email`, `password`, `mobileno`) VALUES (?, ?, ?, ?);");
				$stmt->bind_param("ssss",$name,$email,$password,$mobileno);

				if($stmt->execute()){
					return 1; 
				}else{
					return 2; 
				}
			}
		}


//TO Insert Student
		public function createStudent($name, $usn, $mobileno, $email, $dept, $sem, $section){
			if($this->isStudentExist($name,$usn)){
				return 0; 
			}else{

				
				$stmt = $this->con->prepare("INSERT INTO `student` (`name`, `usn`, `mobileno`, `email`, `dept`, `sem`, `section`) VALUES (?, ?, ?, ?, ?, ?, ?);");
				$stmt->bind_param("sssssss",$name, $usn, $mobileno, $email, $dept, $sem, $section);

				if($stmt->execute()){
					return 1; 
				}else{
					return 2; 
				}
			}
		}

//To Insert Faculty
		public function createFaculty($name, $mobileno, $email, $pass, $dept, $designation){
			if($this->isFacultyExist($name,$mobileno)){
				return 0; 
			}
			elseif($designation=="HOD")
			{
				if($this->isHodExist($designation))
					return 0;

			}elseif($designation=="Dean")
			{
				if($this->isDeanExist($designation))
					return 0;

			}
			elseif($designation=="COE")
			{
				if($this->isCoeExist($designation))
					return 0;

			}
			else
			{
				$password = $pass;
				$stmt = $this->con->prepare("INSERT INTO `faculty` (`name`, `mobileno`, `email`, `password`, `dept`, `designation`) VALUES (?, ?, ?, ?, ?, ?);");
				$stmt->bind_param("ssssss",$name, $mobileno, $email, $password, $dept, $designation);

				if($stmt->execute()){
					return 1; 
				}else{
					return 2; 
				}
			}
		}


//To Insert Faculty Notice
		public function createFacultyNotice($title, $content, $sender, $sendermail, $receiver, $type, $dept, $designation){
				$stmt = $this->con->prepare("INSERT INTO `facultynotice` (`datetime`, `title`, `content`, `sender`, `sendermail`, `receiver`, `type`, `dept`, `designation`) VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?);");
				$stmt->bind_param("ssssssss",$title, $content, $sender, $sendermail, $receiver, $type, $dept, $designation);

				if($stmt->execute()){
					return 1; 
				}else{
					return 2; 
				}
			
		}

//To Insert Student Notice
		public function createStudentNotice($title, $content, $sender, $sendermail, $receiver, $type, $dept, $sem, $section){
				$stmt = $this->con->prepare("INSERT INTO `studentnotice` (`datetime`, `title`, `content`, `sender`, `sendermail`, `receiver`, `type`, `dept`, `sem`, `section`) VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
				$stmt->bind_param("sssssssss",$title, $content, $sender, $sendermail, $receiver, $type, $dept, $sem, $section);

				if($stmt->execute()){
					return 1; 
				}else{
					return 2; 
				}
			
		}





//Principal Login
		public function userLogin($name, $pass){
			$password = $pass;
			$stmt = $this->con->prepare("SELECT email FROM principal WHERE name = ? AND password = ?");
			$stmt->bind_param("ss",$name,$password);
			$stmt->execute();
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
		}

		public function getUserByUsername($name){
			$stmt = $this->con->prepare("SELECT * FROM principal WHERE name = ?");
			$stmt->bind_param("s",$name);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}


//Faculty Login
		public function facultyLogin($name, $pass){
			$password = $pass;
			$stmt = $this->con->prepare("SELECT email FROM faculty WHERE name = ? AND password = ?");
			$stmt->bind_param("ss",$name,$password);
			$stmt->execute();
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
		}

		public function getFacultyByUsername($name){
			$stmt = $this->con->prepare("SELECT * FROM faculty WHERE name = ?");
			$stmt->bind_param("s",$name);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}

//Student Login
		public function studentLogin($name, $pass){
			$password = $pass;
			$stmt = $this->con->prepare("SELECT email FROM student WHERE name = ? AND usn = ?");
			$stmt->bind_param("ss",$name,$password);
			$stmt->execute();
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
		}

		public function getStudentByUsername($name){
			$stmt = $this->con->prepare("SELECT * FROM student WHERE name = ?");
			$stmt->bind_param("s",$name);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}		

		
//USER EXISTENCE
		private function isUserExist($name, $mobileno){
			$stmt = $this->con->prepare("SELECT email FROM principal WHERE name = ? OR mobileno = ?");
			$stmt->bind_param("ss", $name, $mobileno);
			$stmt->execute(); 
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
		}
		private function isStudentExist($name, $usn){
			$stmt = $this->con->prepare("SELECT usn FROM student WHERE name = ? OR usn = ?");
			$stmt->bind_param("ss", $name, $usn);
			$stmt->execute(); 
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
		}

		private function isFacultyExist($name, $mobileno){
			$stmt = $this->con->prepare("SELECT email FROM faculty WHERE name = ? OR mobileno = ?");
			$stmt->bind_param("ss", $name, $email);
			$stmt->execute(); 
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
		}
		
		private function isHodExist($designation){
			$stmt = $this->con->prepare("SELECT email FROM faculty WHERE designation=? ");
			$stmt->bind_param("s", $designation);
			$stmt->execute(); 
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
		}

		private function isDeanExist($designation){
			$stmt = $this->con->prepare("SELECT email FROM faculty WHERE designation=?");
			$stmt->bind_param("s", $designation);
			$stmt->execute(); 
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
		}
		
		
		private function isCoeExist($designation){
			$stmt = $this->con->prepare("SELECT email FROM faculty WHERE designation=? ");
			$stmt->bind_param("s", $designation);
			$stmt->execute(); 
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
		}
		

		public function getAllStudentNotice($receiver, $type, $dept, $sem, $section){
			$stmt = $this->con->prepare("SELECT * FROM `studentnotice` WHERE `receiver` IN (?,'All') AND `type` IN (?,'All') AND `dept` IN (?,'All') AND `sem` IN (?,'All') AND `section` IN (?,'All');
");
			$stmt->bind_param("sssss",$receiver, $type, $dept, $sem, $section);
			$stmt->execute();
			return $stmt->get_result();


		}

		public function getAllSentStudentNotice($sendermail){
			$stmt = $this->con->prepare("SELECT * FROM `studentnotice` WHERE sendermail = ? ");
			$stmt->bind_param("s",$sendermail);
			$stmt->execute();
			return $stmt->get_result();


		}

		public function getAllFacultyNotice($receiver, $type, $dept, $designation){
			$stmt = $this->con->prepare("SELECT * FROM `facultynotice` WHERE `receiver` IN (?,'All') AND `type` IN (?,'All') AND `dept` IN (?,'All') AND `designation` IN (?,'All');");
			$stmt->bind_param("ssss",$receiver, $type, $dept, $designation);
			$stmt->execute();
			return $stmt->get_result();


		}

		public function getAllSentFacultyNotice($sendermail){
			$stmt = $this->con->prepare("SELECT * FROM `facultynotice` WHERE sendermail = ? ");
			$stmt->bind_param("s",$sendermail);
			$stmt->execute();
			return $stmt->get_result();


		}


	public function getIndividualFaculty($dept, $designation){
			$stmt = $this->con->prepare("SELECT name FROM `faculty` WHERE dept = ? and designation = ? ");
			$stmt->bind_param("ss",$dept, $designation);
			$stmt->execute();
			return $stmt->get_result();
		
		}

	public function getIndividualStudent($dept, $sem, $section){
			$stmt = $this->con->prepare("SELECT name FROM `student` WHERE dept = ? and sem = ? and section = ?");
			$stmt->bind_param("sss",$dept, $sem, $section);
			$stmt->execute();
			return $stmt->get_result();
		
		}



public function getIndividualStudentNotice($receiver, $type, $dept, $sem, $section){
			$stmt = $this->con->prepare("SELECT * FROM `studentnotice` WHERE receiver = ? AND type = ? AND dept = ? AND sem = ? AND section = ?");
			$stmt->bind_param("sssss",$receiver, $type, $dept, $sem, $section);
			$stmt->execute();
			return $stmt->get_result();


		}

public function getIndividualFacultyNotice($receiver, $type, $dept, $designation){
			$stmt = $this->con->prepare("SELECT * FROM `facultynotice` WHERE receiver = ? AND type = ? AND dept = ? AND designation = ? order by datetime desc;");
			$stmt->bind_param("ssss",$receiver, $type, $dept, $designation);
			$stmt->execute();
			return $stmt->get_result();


		}

public function updateStudent($mobileno, $sem, $section, $usn){
			$stmt = $this->con->prepare("UPDATE `student` SET mobileno = ? , sem = ?, section = ? WHERE usn = ? ");
			$stmt->bind_param("ssss",$mobileno, $sem, $section, $usn);
			$stmt->execute();
			return $stmt->get_result();
		
		}

public function updateFaculty($mobileno, $email){
			$stmt = $this->con->prepare("UPDATE `faculty` SET mobileno = ? WHERE email = ? ");
			$stmt->bind_param("ss",$mobileno, $email);
			$stmt->execute();
			return $stmt->get_result();
		
		}

public function updateFacultyPassword($password, $email){
			$stmt = $this->con->prepare("UPDATE `faculty` SET password = ? WHERE email = ? ");
			$stmt->bind_param("ss",$password, $email);
			$stmt->execute();
			return $stmt->get_result();
		
		}

public function updatePrincipalPassword($password, $email){
			$stmt = $this->con->prepare("UPDATE `principal` SET password = ? WHERE email = ? ");
			$stmt->bind_param("ss",$password, $email);
			$stmt->execute();
			return $stmt->get_result();
		
		}

public function getHierarchy($designation){
			$stmt = $this->con->prepare("SELECT * FROM `hierarchy` WHERE designation = ?;");
			$stmt->bind_param("s",$designation);
			$stmt->execute();
			return $stmt->get_result();


		}


	}