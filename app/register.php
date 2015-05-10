<?php

require_once 'init.php';

if(Input::exists()) {
	$validate = new Validate();
	$validation = $validate->check($_POST, array(
		'firstname' => array(
			'required' 	=> true,
			'min'		=> 2,
			'max' 		=> 55
			),
		'lastname' => array(
			'required' 	=> true,
			'min'		=> 2,
			'max' 		=> 55
			),
		'username' => array(
			'required'	=> true,
			'min'		=> 5,
			'max'		=> 15,
			'unique' 	=> 'users'
			),
		'password' => array(
			'required'	=> true,
			'min'		=> 5,
			'max'		=> 15
			),
		'passwordAgain' => array(
			'matches' => 'password'
		),
		'email' => array(
			'required' 	=> true,
			'min' 		=> 5,
			'max' 		=> 255
		)
	));
	// Athuga hvort að notandinn stóðst reglurnar, ef ekki þá fær hann
	// villumeldingu um það
	if($validation->passed()) {
		try {
			$user = new User();
			$user->newUser(
				Input::get('firstname'),
				Input::get('lastname'),
				Input::get('email'),
				Input::get('username'),
				password_hash(Input::get('password'), PASSWORD_DEFAULT)
				);
			// Læt notanda vita að allt hafi gengið upp.
			Session::flash('success', 'Registration was a success');
			Redirect::to('../index.php');		
		} catch (Exception $e) {
			// Sendi notandann til baka á index með villumeldingu
			Session::flash('danger', $e->getMessage());
			Redirect::to('../index.php');
		}	
	}

	// Notandi stóðst ekki þær reglur og fær því villumeldingu
	else {
		$errors = '';
		foreach ($validation->errors() as $error) {
			$errors .= $error . '<br/>';
		}
		Session::flash('danger', $errors);
		Redirect::to('../index.php');
	}
}
?>