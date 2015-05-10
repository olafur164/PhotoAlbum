<?php
	class User_old
	{
		private $_db;
		public function __construct()
		{
			$this->_db = DB::getInstance();
		}
		public function getCurrentUser($user_name, $user_pass)
		{
			$statement = $this->_db->_pdo->prepare('call GetCurrentUser(?,?)');
			$statement->bindParam(1,$user_name);
			$statement->bindParam(2,$user_pass);
			
			try 
			{
				$statement->execute();
				
				$row = $statement->fetch(PDO::FETCH_NUM);
				return $row;
			}
			catch(PDOException $e)
			{
				return array();
			}
		}
		/*
		** User functions 
		*/


		/**
		 * The function validate user
		 *
		 * @param string $user_name
		 * @param string $user_pass
		 *
		 * @return boolean
		 */
		public function validateUser($user_name, $user_pass)
		{
			$statement = $this->_db->_pdo->prepare("select ValidateUser(?,?)");
			$statement->bindParam(1,$user_name);
			$statement->bindParam(2,$user_pass);
			
			try 
			{
				$statement->execute();
				
				$row = $statement->fetch(PDO::FETCH_NUM);
				return $row[0];
			}
			catch(PDOException $e)
			{
				return -1;
			}
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
		public function getUserAlbumList($userid)
		{
			$statement = $this->_db->_pdo->prepare('call GetUserAlbumList(?)');
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
		
		/**
		 * The function inserts new user into the database
		 *
		 * @param string $firstName
		 * @param string $lastName
		 * @param string $userEmail
		 * @param string $userName
		 * @param string $userPassword
		 *
		 * @return boolean
		 */
		public function newUser( $firstName, $lastName, $userEmail, $userName, $userPassword, $referrer)
		{
			$statement = $this->_db->_pdo->prepare('call NewUser(?,?,?,?,?,?)');
			$statement->bindParam(1,$firstName);
			$statement->bindParam(2,$lastName);
			$statement->bindParam(3,$userEmail);
			$statement->bindParam(4,$userName);
			$statement->bindParam(5,$userPassword);
			$statement->bindParam(6,$referrer);
			
			
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

		/**
		 * The function deletes an user from the database
		 *
		 * @param string $user_id
		 *
		 * @return boolean
		 */
		public function deleteUser($user_id)
		{
			$statement = $this->_db->_pdo->prepare('call DeleteUser(?)');
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
		
		/**
		 * The function gets information about a single image
		 *
		 * @param string $user_id
		 * @return one dimensional array
		 */
		public function getUser($user_id)
		{
			$statement = $this->_db->_pdo->prepare('call GetUser(?)');
			$statement->bindParam(1,$user_id);
			
			try 
			{
				$statement->execute();
				
				$row = $statement->fetch(PDO::FETCH_NUM);
				return $row;
			}
			catch(PDOException $e)
			{
				return array();
			}
		}

		
		/**
		 * The function updates a user in the database
		 *
		 * @param string $userID
		 * @param string $firstName
		 * @param string $lastName
		 * @param string $userEmail
		 * @param string $userName
		 * @param string $userPassword
		 * @param string $accessLevel
		 * @param string $activity
		 *
		 * @return boolean
		 */
		public function updateUser($userID, $firstName, $lastName, $userEmail, $userName, $userPassword, $accessLevel, $activity)
		{
			$statement = $this->_db->_pdo->prepare('call UpdateUser(?,?,?,?,?,?,?,?)');
			$statement->bindParam(1,$userID);
			$statement->bindParam(2,$firstName);
			$statement->bindParam(3,$lastName);
			$statement->bindParam(4,$userEmail);
			$statement->bindParam(5,$userName);
			$statement->bindParam(6,$userPassword);
			$statement->bindParam(7,$accessLevel);
			$statement->bindParam(8,$activity);
			
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
		
		/**
		 * The function returns a list of all users
		 *
		 * @return two dimensional array
		 */
		public function userList()
		{
			$statement = $this->_db->_pdo->prepare('call UserList()');
			
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
		
		/**
		 * The function resets user
		 *
		 * @param string $user_id
		 *
		 * @return boolean
		 */
		public function resetUser($user_id)
		{
			$statement = $this->_db->_pdo->prepare('call ResetUser(?)');
			$statement->bindParam(1,$user_id);
			
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
		
		/**
		 * The function set user access level
		 *
		 * @param string $access_level
		 * @param string $user_id
		 * @param string $admin_id
		 *
		 * @return boolean
		 */

		public function setAccessLevel($access_level, $user_id, $admin_id)
		{
			$statement = $this->_db->_pdo->prepare('select SetAccessLevel(?,?,?)');
			$statement->bindParam(1,$access_level);
			$statement->bindParam(2,$user_id);
			$statement->bindParam(3,$admin_id);
			
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
			if (Session::exists('loggedIn')) {
				return true;
			}
			else
			{
				return false;
			}
		}
		public function hasPermission() {
			if (Session::exists('hasPermission')) {
				return true;
			}
			else {
				return false;
			}
		}
		public function getUserLoginInfo($user_name)
		{
			$statement = $this->_db->_pdo->prepare('call GetLogin(?)');
			$statement->bindParam(1,$user_name);
			try 
			{
				$statement->execute();
				
				$row = $statement->fetch(PDO::FETCH_NUM);
				return $row;
			}
			catch(PDOException $e)
			{
				return array();
			}
		}

		public function login($username, $password)
		{
			// Athugar hvort einstaklingur sé skráður inn
			if ($this->isLoggedIn()) {
				Session::flash('danger', "You're already logged in");
				redirect::to('../index.php');
			}
			else {
				$check = $this->_db->checkUser($username);
				if ($check == 1) {
					$getUser = $this->getUserLoginInfo($username);
					$hash = $getUser[5];
					if (password_verify($password, $hash) == 1)  {
						Session::put('loggedIn', true);
						Session::put('userId', $getUser[0]);
						if ($getUser[6] == 3) {
							Session::put('hasPermission');
						}
						return true;
					}
				}
				else {
					Session::flash('danger', "This user doesn't exist ");
					redirect::to('../index.php');
				}

			}
			return false;		
		}
		public function logout()
		{
			if (Session::exists('loggedIn')) {
				Session::delete('userId');
				Session::delete('hasPermission');
				Session::delete('loggedIn');
					Session::flash('success', 'Logout was succesful');
				redirect::to('../index.php');
			}
			else
			{
			}
		}		
	}
?>