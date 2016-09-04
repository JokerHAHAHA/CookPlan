<?php

namespace CookPlan\Model;
use CookPlan\Model\Database;

 /**
  * 
  */
 class User
 {	

 	private $conn;

 	public function __construct()
 	{
 		$database = new Database();
 		$db = $database->dbConnection();
 		$this->conn = $db;
 	}

 	public static function findOne($user)
 	{
 		$conn = new Database();
 		$conn = $conn->dbConnection();
 		$sql = "SELECT * FROM users WHERE user_id=:user";
 		$stmt = $conn->prepare($sql);
 		$stmt->execute(array(":user"=>$user));
 		return $stmt->fetch(\PDO::FETCH_ASSOC);
 	}

 	public function register($login,$email,$password)
 	{

 		try
 		{
 			$conn = new Database();
 			$conn = $conn->dbConnection();
 			$sql = "SELECT user_name, user_email FROM users WHERE user_name=:login OR user_email=:email";
 			$stmt = $conn->prepare($sql);
 			$stmt->execute(array(':login'=>$login, ':email'=>$email));
 			$row=$stmt->fetch(\PDO::FETCH_ASSOC);

 			// verify if already existe
 			if($row['user_name']==$login || $row['user_email']==$email)
 			{
 				$error = array();
 				if($row['user_name']==$login)
 				{
 					$error['login'] = "désolé mais ce login est déjà utilisé";
 				}
 				if($row['user_email']==$email)
 				{
 					$error['email'] = "vous avez déjà un compte chez Cook Plan avec cette adresse e-mail";
 				}
 				return $error;
 			}
	 		// create new user
 			else
 			{
 				try
 				{
 					$new_password = password_hash($password, PASSWORD_DEFAULT);
 					$sql = "INSERT INTO users(user_name,user_email,user_pass) 
 					VALUES(:login, :email, :password)";
 					$stmt = $conn->prepare($sql);

 					$stmt->bindparam(":login", $login);
 					$stmt->bindparam(":email", $email);
 					$stmt->bindparam(":password", $new_password);										  

 					$stmt->execute();

 					return $stmt;	
 				}
 				catch(PDOException $e)
 				{
 					echo $e->getMessage();
 				}
 			}
 		}
 		catch(PDOException $e)
 		{
 			echo $e->getMessage();
 		}
	}//end resgistrer


 	public function doLogin($uname,$umail,$upass)
 	{
 		try
 		{
 			$stmt = $this->conn->prepare("SELECT user_id, user_name, user_email, user_pass FROM users WHERE user_name=:uname OR user_email=:umail ");
 			$stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
 			$userRow=$stmt->fetch(\PDO::FETCH_ASSOC);
 			if($stmt->rowCount() == 1)
 			{
 				if(password_verify($upass, $userRow['user_pass']))
 				{
 					$_SESSION['user_session'] = $userRow['user_id'];
 					return true;
 				}
 				else
 				{
 					return false;
 				}
 			}
 		}
 		catch(PDOException $e)
 		{
 			echo $e->getMessage();
 		}
 	}

 	public function is_loggedin()
 	{
 		if(isset($_SESSION['user_session']))
 		{
 			return true;
 		}
 	}

 	public function redirect($url)
 	{
 		header("Location: $url");
 	}

 	public function doLogout()
 	{
 		session_destroy();
 		unset($_SESSION['user_session']);
 		return true;
 	}

 }


