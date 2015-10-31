<?php
	class DB
	{
		private static $_instance = null;
		/* settings */
		
		// Gagnagrunns tenginginn - host - dbname - user - pass
		private $_host 		= 'localhost',
				$_dbname   	= 'Photobase',
				$_user 		= 'root',
				$_pass 		= '';
		public 	$_pdo,
				$_count = 0;
				
		// Þetta er smiðurinn - hann býr til tenginuna og notar til þess stillingarnar hér að ofan.
		public function __construct()
		{
			try
			{
				$this->_pdo = new PDO('mysql:host=' . $this->_host . ';dbname='. $this->_dbname, $this->_user, $this->_pass);
				$this->_pdo->exec('SET NAMES "utf8"');
			}
			catch (PDOException $e)
			{
				die($e->getMessage());
			}
		}
		// Býr til nýtt afrit af gagnagrunnstengingunni og
		// kemur í veg fyrir að margar tengingar séu opnar
		public static function getInstance() {

			if (!isset(self::$_instance)) {
				self::$_instance = new DB();
			}

			return self::$_instance;
		}
		
		// Þetta er demo function sem sækjir í gagnagrunn
		public function getAllDatesFromMonth($month)
		{
			$statement = $this->_pdo->prepare('call getCategory()'); // Þetta kallar er í stored procedure sem geymt er í gagnagrunni
			// Skoðaðu mysql stored procedures.
			$statement->bindParam(1,$month);
			
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
		
		// Hér að neðan eru fullt af functions sem gera eithvað með gagnagrunninn, setja inn í gagnagrunn, uppfæra, sækja og eyða.
	
		/**
		 * The function inserts a new category into the image database
		 *
		 * @param string $category_name
		 * @return boolean
		 */
		public function newCategory($category_name)
		{
			$statement = $this->_pdo->prepare('call NewCategory(?)');
			$statement->bindParam(1,$category_name);
			
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
		 * The function gets information about a single category item
		 *
		 * @param string $category_id
		 * @return one dimensional array
		 */
		public function getCategory($category_id)
		{
			$statement = $this->_pdo->prepare('call GetCategory(?)');
			$statement->bindParam(1,$category_id);
			
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
		 * The function updates a category in the database
		 *
		 * @param string $category_name
		 * @param string $category_id
		 * @return boolean
		 */
		public function updateCategory($category_name,$category_id)
		{
			$statement = $this->_pdo->prepare('call UpdateCategory(?,?)');
			$statement->bindParam(1,$category_name);
			$statement->bindParam(2,$category_id);
			
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
		 * The function deletes a category from the database
		 *
		 * @param string $category_id
		 * @return boolean
		 */
		public function deleteCategory($category_id)
		{
			$statement = $this->_pdo->prepare('call DeleteCategory(?)');
			$statement->bindParam(1,$category_id);
			
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
		 * The function returns a list of all categories
		 *
		 * @return two dimensional array
		 */
		public function categoryList()
		{
			$statement = $this->_pdo->prepare('call CategoryList()');
			
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
		 * The function inserts new image info into the database
		 *
		 * @param string $name
		 * @param string $path
		 * @param string $text
		 * @param string $category
		 *
		 * @return boolean
		 */
		public function newImage($name,$path,$text,$category, $user)
		{
			$statement = $this->_pdo->prepare('call NewImage(?,?,?,?,?)');
			$statement->bindParam(1,$name);
			$statement->bindParam(2,$path);
			$statement->bindParam(3,$text);
			$statement->bindParam(4,$category);
			$statement->bindParam(5,$user);
			
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
		 * @param string $image_id
		 * @return one dimensional array
		 */
		public function getImageInfo($image_id, $user_id)
		{
			$statement = $this->_pdo->prepare('call GetImage(?,?)');
			$statement->bindParam(1,$image_id);
			$statement->bindParam(2,$user_id);
			
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
		 * The function updates an image in the database
		 *
		 * @param string $id
		 * @param string $name
		 * @param string $path
		 * @param string $text
		 * @param string $category
		 *
		 * @return boolean
		 */
		public function updateImageInfo($id,$name)
		{
			$statement = $this->_pdo->prepare('call UpdateImage(?,?)');
			$statement->bindParam(1,$id);
			$statement->bindParam(2,$name);
			
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
		 * The function deletes an image from the database
		 *
		 * @param string $image_id
		 *
		 * @return boolean
		 */
		public function deleteImageInfo($image_id)
		{
			$statement = $this->_pdo->prepare('call DeleteImage(?)');
			$statement->bindParam(1,$image_id);
			
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
		 * The function returns a list of all images
		 *
		 * @return two dimensional array
		 */
		public function imageList()
		{
			$statement = $this->_pdo->prepare('call ImageList()');
			
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
	}
?>
