<?php
	class DataManager
	{
		private $_db;
		public function __construct()
		{
			$this->_db = DB::getInstance();
		}
		public function insertData($procedure, $attr = array())
		{

		}
		public function deleteData($procedure, $attr = array())
		{

		}
		public function updateData($procedure, $attr = array())
		{

		}
		public function getData($procedure, $attr = array())
		{

		}
		public function listData($procedure, $attr = array())
		{

		}
		
		/**
		 * The function inserts a new category into the image database
		 *
		 * @param string $category_name
		 * @return boolean
		 */
		public function newCategory($category_name)
		{
			$statement = $this->_db->_pdo->prepare('call NewCategory(?)');
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
			$statement = $this->_db->_pdo->prepare('call GetCategory(?)');
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
			$statement = $this->_db->_pdo->prepare('call UpdateCategory(?,?)');
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
			$statement = $this->_db->_pdo->prepare('call DeleteCategory(?)');
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
			$statement = $this->_db->_pdo->prepare('call CategoryList()');
			
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
		
		public function categoryCount()
		{
			$statement = $this->_db->_pdo->prepare("select counter('categories')");
			
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
		
		public function newImageInfo($category, $userid, $name, $path, $text, $album)
		{
			$statement = $this->_db->_pdo->prepare('call NewImage(?,?,?,?,?,?)');
			$statement->bindParam(6,$category);
			$statement->bindParam(5,$userid);
			$statement->bindParam(1,$name);
			$statement->bindParam(2,$path);
			$statement->bindParam(3,$text);
			$statement->bindParam(4,$album);
			
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
		public function getImageInfo($image_id)
		{
			$statement = $this->_db->_pdo->prepare('call GetImage(?)');
			$statement->bindParam(1,$image_id);
			
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
		public function updateImageInfo($id,$name,$path,$text,$category)
		{
			$statement = $this->_db->_pdo->prepare('call UpdateImage(?,?,?,?,?)');
			$statement->bindParam(1,$id);
			$statement->bindParam(2,$name);
			$statement->bindParam(3,$path);
			$statement->bindParam(4,$text);
			$statement->bindParam(5,$category);
			
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
			$statement = $this->_db->_pdo->prepare('call DeleteImage(?)');
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
			$statement = $this->_db->_pdo->prepare('call ImageList()');
			
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
		public function imageCatList($category_id)
		{
			$statement = $this->_db->_pdo->prepare('call ImageCatList(?)');
			$statement->bindParam(1,$category_id);
			
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
		
		public function imageCount()
		{
			$statement = $this->_db->_pdo->prepare("select counter('Images')");
			
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
		public function landingCount()
		{			
			$statement = $this->_db->_pdo->prepare("select counter('Landing')");
			
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
		public function getLandingImage($image_id)
		{
			$statement = $this->_db->_pdo->prepare('call GetLanding(?)');
			$statement->bindParam(1,$image_id);
			
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
		public function newAlbum($user_id, $name, $description, $albumImage)
		{
			$statement = $this->_db->_pdo->prepare('call NewAlbum(?,?,?,?)');
			$statement->bindParam(1,$user_id);
			$statement->bindParam(2,$name);
			$statement->bindParam(3,$description);
			$statement->bindParam(4,$albumImage);
			
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
		public function getAlbumList()
		{			
			$statement = $this->_db->_pdo->prepare('call AlbumList()');
			
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
		public function getImagesInAlbum($albumID)
		{			
			$statement = $this->_db->_pdo->prepare('call AlbumImages(?)');
			$statement->bindParam(1,$albumID);
			
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