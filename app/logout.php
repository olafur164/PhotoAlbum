<?php
include_once 'init.php';
$user = new User();
if ($user->isLoggedIn()) {
	$user->logout();
	Session::flash('success', 'Útskráning Tókst');
	Redirect::to('../index.php');
}
else {
	Session::flash('warning', 'Þú ert ekki skráður inn');
	Redirect::to('../index.php');
}
?>