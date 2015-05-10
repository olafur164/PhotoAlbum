<?php
session_start();
/**
 * These are the database login details
 */  

/*
$GLOBALS['config'] = array(
	'remember' 	=> array(
		'cookie_name' 	=> 'hash',
		'cookie_expiry' => '604800',
	),
	'session' 	=> array(
		'session_name' 	=> 'user',
		'token_name' 	=> 'token'
	)
);
*/

// autoloader inn öllum klösunum
spl_autoload_register(function($class) {
	require_once 'Classes/' . $class . '.php';
});

// Tekur inn sanitize functionið sem blockar XSS hack
require_once 'Functions/sanitize.php';
$data = new DB();
$user = new User();
$images = new DB();
if ($user->isLoggedIn()) {
	$userData = $user->data();
	$userImage = $user->getUserImages($userData[0]);
}
$imageList = $data->imageList();
?>