<?php

require_once 'init.php';

if(Input::exists()) {
	$validate = new Validate();
	$validation = $validate->check($_POST, array(
		'newName' => array(
			'required' 	=> true
			),
	));
	// Athuga hvort að notandinn stóðst reglurnar, ef ekki þá fær hann
	// villumeldingu um það
	if($validation->passed()) {
		try {
			$data = new DB();
			$data->updateImageInfo(
					Input::get('id'),
					Input::get('newName')
					);
			// Læt notanda vita að allt hafi gengið upp.
			Session::flash('success', 'Edit was succesful');
			Redirect::to('../myImages.php');		
		} catch (Exception $e) {
			// Sendi notandann til baka á index með villumeldingu
			Session::flash('danger', $e->getMessage());
			Redirect::to('../myImages.php');
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