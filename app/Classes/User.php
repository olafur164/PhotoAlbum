<?php
	class User
	{
		private static $_instance = null;
		private $_db,
				$_data,
				$_sessionName,
				$_isLoggedIn;
		public function __construct($user = null)
		{
			$this->_db = DB::getInstance();


			if(!$user) {

				if(Session::exists($this->_sessionName)) {
					$user = Session::get($this->_sessionName);

					if($this->getUserId($user)) {
						$this->_isLoggedIn = true;
					} else {
						$this->logout();
					}
				}
			} else {
				$this->getUserId($user);
			}
		}
		public static function getInstance() {

			if (!isset(self::$_instance)) {
				self::$_instance = new DB();
			}

			return self::$_instance;
		}
	
		public function login($username = null, $password = null) {
			if(!$username && !$password && $this->exists()) {
				$user = $this->data();
				Session::put($this->_sessionName, $user[0]);
			} else {
				$user = $this->getUser($username);
				if($user) {
					if(password_verify($password, $user[5])) {
						Session::put($this->_sessionName, $user[0]);
						return true;
					}
				}
			}
			
			return false;
		}
		public function logout() {

			Session::delete($this->_sessionName);
		}

		public function newUser($first_name,$last_name,$user_email,$user_name,$user_pass)
		{
			$statement = $this->_db->_pdo->prepare('call NewUser(?,?,?,?,?)');
			$statement->bindParam(1,$first_name);
			$statement->bindParam(2,$last_name);
			$statement->bindParam(3,$user_email);
			$statement->bindParam(4,$user_name);
			$statement->bindParam(5,$user_pass);
			
			try 
			{
				$statement->execute();
				
				return true;
			}
			catch(PDOException $e)
			{
				return false;
			}
		}
		
		public function getUser($user_name)
		{
			$statement = $this->_db->_pdo->prepare('call GetUser(?)');
			$statement->bindParam(1,$user_name);
			
			try 
			{
				$statement->execute();
				
				$row = $statement->fetch(PDO::FETCH_NUM);
				$this->_data = $row;
				return $row;
			}
			catch(PDOException $e)
			{
				return array();
			}
		}
		
		public function getUserId($user_id)
		{
			$statement = $this->_db->_pdo->prepare('call GetUserId(?)');
			$statement->bindParam(1,$user_id);
			
			try 
			{
				$statement->execute();
				
				$row = $statement->fetch(PDO::FETCH_NUM);
				$this->_data = $row;
				return $row;
			}
			catch(PDOException $e)
			{
				return array();
			}
		}
		
		public function userList()
		{
			$statement = $this->connection->prepare('call UserList()');
			
			try 
			{
				$arr = array();
				$statement->execute();
				
				while ($row = $statement->fetch(PDO::FETCH_NUM)) 
				{
					array_push($arr,$row);
				}
				return $arr;
			}
			catch(PDOException $e)
			{
				return array();
			}
		}
	
		public function updateUser($userI_id,$first_name,$last_name,$user_email,$user_name,$user_pass)
		{
			$statement = $this->connection->prepare('call UpdateUser(?,?,?,?,?,?)');
			$statement->bindParam(1,$userI_id);
			$statement->bindParam(2,$first_name);
			$statement->bindParam(3,$last_name);
			$statement->bindParam(4,$user_email);
			$statement->bindParam(5,$user_name);
			$statement->bindParam(6,$user_pass);
			
			try 
			{
				$statement->execute();
				
				return true;
			}
			catch(PDOException $e)
			{
				return false;
			}
		}
	
		public function deleteUser($user_id)
		{
			$statement = $this->connection->prepare('call DeleteUser(?)');
			$statement->bindParam(1,$user_id);
			
			try 
			{
				$statement->execute();
				
				return true;
			}
			catch(PDOException $e)
			{
				return false;
			}
		}
		
		public function resetUser($user_id)
		{
			$statement = $this->connection->prepare('call ResetUser(?)');
			$statement->bindParam(1,$user_id);
			
			try 
			{
				$statement->execute();
				
				return true;
			}
			catch(PDOException $e)
			{
				return false;
			}
		}
		
		public function setAccessLevel($access_level,$user_id,$admin_id)
		{
			$statement = $this->connection->prepare('select SetAccessLevel(?,?,?)');
			$statement->bindParam(1,$access_level);
			$statement->bindParam(2,$user_id);
			$statement->bindParam(3,$admin_id);
			
			try 
			{
				$statement->execute();
				$row = $statement->fetch(PDO::FETCH_NUM);
				
				return $row[0];
			}
			catch(PDOException $e)
			{
				return 0;
			}
		}
	
		public function validateUser($user_name,$user_pass)
		{
			$statement = $this->connection->prepare('select ValidateUser(?,?)');
			$statement->bindParam(1,$user_name);
			$statement->bindParam(2,$user_pass);
			
			$ret = false;
			
			try 
			{
				$statement->execute();
				$row = $statement->fetch(PDO::FETCH_NUM);
				
				if($row[0] == 1)
					$ret = true;
			}
			catch(PDOException $e)
			{
				$ret = false;
			}
			
			return $ret;
		}
		public function data() {

			return $this->_data;
		}
		public function getUserImages($userid)
		{
			$statement = $this->_db->_pdo->prepare('call GetUserImages(?)');
			$statement->bindParam(1,$userid);

			try 
			{
				$arr = array();
				$statement->execute();
				
				while ($row = $statement->fetch(PDO::FETCH_NUM)) 
				{
					array_push($arr,$row);
				}
				return $arr;
			}
			catch(PDOException $e)
			{
				return array();
			}
		}

		public function isLoggedIn(){
			return $this->_isLoggedIn;
		}
		public function exists() {

			return (!empty($this->_data)) ? true : false;
		}
	}
?>