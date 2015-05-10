<?php
include_once 'init.php';
$data = new DataManager();
$user = new User();
$error;
if ($user->isLoggedIn()) {
	if (Input::exists()) {
		$userData = $user->getUser(Session::get('userId'));
		$name = $_POST['name'];
		$description = $_POST['description'];
		$path = $_POST['imagePath'];

		$data->newAlbum($userData[0], $name, $description, $path);
		Session::flash('success', "You have created new album");
		redirect::to('../newalbum.php');
	}
	else {
		Session::flash('danger', "Error");
		redirect::to('../newalbum.php');
	}
}
else {
	echo 'No Access!';
}
?>