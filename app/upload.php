<?php 

require_once 'init.php';
$uploadSuccess = false;


	$destination = "c:/WebHost/htdocs/skolaverkefni/PhotoBase/uploads/";
	try {
		$upload = new ThumbnailUpload($destination);
		$upload->setThumbDestination('c:/WebHost/htdocs/skolaverkefni/PhotoBase/uploads/thumbnails/'); 
		$upload->move();
		$result = $upload->getMessages();
	} catch (Exception $e) {
		echo $e->getMessages();
	}
	if (isset($result)) {
		$errors = '';
		foreach ($result as $error) {
			$errors .= $error . '<br/>';
		}
		if (strpos($errors, 'uploaded successfully') !== false) {
			Session::flash('success', $errors);
			Redirect::to('../myImages.php');
		}
		else {
			Session::flash('danger', $errors);
			Redirect::to('../myImages.php');
		}
		
 	}

?>
