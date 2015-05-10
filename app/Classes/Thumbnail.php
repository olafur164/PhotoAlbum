<?php 
require_once('Upload.php');
class Thumbnail {
	protected $_original;
	protected $_originalwidth;
	protected $_originalheight;
	protected $_thumbwidth;
	protected $_thumbheight;
	protected $_maxSize = 120;
	protected $_canProcess = false;
	protected $_imageType; 
	protected $_destination;
 	protected $_name;
 	protected $_suffix = '_thb';
 	protected $_messages = array(); 

 	public function __construct($image) {
	 	if (is_file($image) && is_readable($image)) {
	 		$details = getimagesize($image);
	 	} else {
	 		$details = null;
	 		$this->_messages[] = "Cannot open $image.";
	 	}
	 	// if getimagesize() returns an array, it looks like an image
	 	if (is_array($details)) {
	 		$this->_original = $image;
			$this->_originalwidth = $details[0];
			$this->_originalheight = $details[1];
	 		// check the MIME type
	 		$this->checkType($details['mime']);
	 	} else {
	 		$this->_messages[] = "$image doesn't appear to be an image.";
	 	}
 	}
 	protected function checkType($mime) {
 		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
 		if (in_array($mime, $mimetypes)) {
 			$this->_canProcess = true;
 			// extract the characters after 'image/'
 			$this->_imageType = substr($mime, 6);
 		}
 	}
 	public function test() {
 		echo 'File: ' . $this->_original . '<br>';
 		echo 'Original width: ' . $this->_originalwidth . '<br>';
 		echo 'Original height: ' . $this->_originalheight . '<br>';
 		echo 'Image type: ' . $this->_imageType . '<br>';
 		echo 'Destination: ' . $this->_destination . '<br>';
 		echo 'Max size: ' . $this->_maxSize . '<br>';
 		echo 'Suffix: ' . $this->_suffix . '<br>'; 
 		echo 'Thumb width: ' . $this->_thumbwidth . '<br>';
		echo 'Thumb height: ' . $this->_thumbheight . '<br>';
 		echo 'Base name: ' . $this->_name . '<br>'; 
 		if ($this->_messages) {
 			print_r($this->_messages);
 		} 
 	} 
 	public function setDestination($destination) {
 		if (is_dir($destination) && is_writable($destination)) {
 			// get last character
 			$last = substr($destination, -1);
 			// add a trailing slash if missing
 			if ($last == '/') {
 				$this->_destination = $destination;
 			} else {
 				$this->_destination = $destination . DIRECTORY_SEPARATOR;
 			}
 		} else {
 			$this->_messages[] = "Cannot write to $destination.";
 		}
 	} 
 	public function setMaxSize($size) {
 		if (is_numeric($size) && $size > 0) {
 			$this->_maxSize = abs($size);
 		} else {
 			$this->_messages[] = 'The value for setMaxSize() must be a positive number.';
 			$this->_canProcess = false;
 		}
 	} 
 	public function setSuffix($suffix) {
 		if (preg_match('/^\w+$/', $suffix)) {
 			if (strpos($suffix, '_') !== 0) {
 				$this->_suffix = '_' . $suffix;
 			} else {
 				$this->_suffix = $suffix;
 			}
 		} else {
 			$this->_suffix = '';
 		}
 	} 
 	protected function calculateSize($width, $height) {
 		if ($width <= $this->_maxSize && $height <= $this->_maxSize) {
 			$ratio = 1;
 		} elseif ($width > $height) {
 			$ratio = $this->_maxSize/$width;
 		} else {
 			$ratio = $this->_maxSize/$height;
 		}
 		$this->_thumbwidth = round($width * 0.2);
 		$this->_thumbheight = round($height * 0.2);
 	} 
 	protected function getName() { 
 		$extensions = array('/\.jpg$/i', '/\.jpeg$/i', '/\.png$/i', '/\.gif$/i');
 		$this->_name = preg_replace($extensions, '', basename($this->_original));
 	} 
 	public function create() {
 		if ($this->_canProcess && $this->_originalwidth != 0) {
 			$this->calculateSize($this->_originalwidth, $this->_originalheight);
 			$this->getName();
 			$this->createThumbnail(); 
 		} elseif ($this->_originalwidth == 0) {
 			$this->_messages[] = 'Cannot determine size of ' . $this->_original;
 		}
 	} 
 	protected function createImageResource() {
 		if ($this->_imageType == 'jpeg') {
 			return imagecreatefromjpeg($this->_original);
 		} elseif ($this->_imageType == 'png') {
 			return imagecreatefrompng($this->_original);
 		} elseif ($this->_imageType == 'gif') {
 			return imagecreatefromgif($this->_original);
 		}
 	} 
 	protected function createThumbnail() {
 		$resource = $this->createImageResource();
 		$thumb = imagecreatetruecolor($this->_thumbwidth, $this->_thumbheight);
 		imagecopyresampled($thumb, $resource, 0, 0, 0, 0, $this->_thumbwidth,
 		$this->_thumbheight, $this->_originalwidth, $this->_originalheight); 
 		$newname = $this->_name . $this->_suffix;
 		$name = $this->_name;
 		if ($this->_imageType == 'jpeg') {
 			$newname .= '.jpg';
 			$name .= '.jpg';
 			$success = imagejpeg($thumb, $this->_destination . $newname, 100);
 		} elseif ($this->_imageType == 'png') {
 			$newname .= '.png';
 			$name .= '.png';
 			$success = imagepng($thumb, $this->_destination . $newname, 0);
 		} elseif ($this->_imageType == 'gif') {
 			$newname .= '.gif';
 			$name .= '.gif';
 			$success = imagegif($thumb, $this->_destination . $newname);
 		}
 		if ($success) {
		 	$this->insert($name, $newname, $this->_name);
 			$this->_messages[] = "$newname created successfully.";
 		} else {
 			$this->_messages[] = "Couldn't create a thumbnail for " .
 			basename($this->_original);
 		}
 		imagedestroy($resource); 
 		imagedestroy($thumb); 
 	} 
 	public function insert($fileName, $fileThb, $imgname) {
 		$user = new User();
 		$userData = $user->data();
 		$data = new DB();
		$data->newImage($fileName,
						$fileThb,
						$imgname,
						1,
						$userData[0]
						);

 	}
 	public function getMessages() {
 		return $this->_messages;
 	} 
}