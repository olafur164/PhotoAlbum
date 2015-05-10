<?php
	class Images
	{
		private $_db;
		public function __construct()
		{
			$this->_db = DB::getInstance();
		}
		
		public function newImage($ImagePath, $ImageName, $ImageText, $ImageOwner, $ImageAlbum, $ImageSize, $ImageType)
		{
			$statement = $this->_db->_pdo->prepare('call NewImage(?,?,?,?,?,?,?)');
			$statement->bindParam(1,  $ImagePath);
			$statement->bindParam(2,  $ImageName);
			$statement->bindParam(3,  $ImageText);
			$statement->bindParam(4,  $ImageOwner);
			$statement->bindParam(5,  $ImageAlbum);
			$statement->bindParam(6,  $ImageSize);
			$statement->bindParam(7,  $ImageType);
			
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
		public function updateImage($ImageName, $newImageName, $ImageText)
		{
			$statement = $this->_db->_pdo->prepare('call UpdateImage(?,?,"",?,1)');
			$statement->bindParam(1,  $ImageName);
			$statement->bindParam(2,  $newImageName);
			$statement->bindParam(3,  $ImageText);
			
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
	}
?>