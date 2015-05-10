<?php
require_once 'init.php';

if (Input::exists()) {

	// Skilgreini þær reglur sem að username
	// og password þurfa að standast
	$validate = new Validate();
	$validation = $validate->check($_POST, array(
		'username'	=> array('required' => true),
		'password' => array('required' => true)

	));

	// Athuga hvort að notandinn hafi staðist reglurnar
	if ($validation->passed()) {

		// Bý til afrit af user clasanum
		$user = new User();

		// Skrái notandann inn
		$login = $user->login(Input::get('username'), Input::get('password'));

		// Athuga hvort að innskráning hafi heppnast og læt notanda þá vita með
		// flash skilaboðum á index
		if ($login) {

			Session::flash('success', 'Innskráning tókst');
			Redirect::to('../index.php');

		// Læt notanda vita að lykilorð eða notandanafn hafi ekki verið rétt með
		// villumeldingu á index
		} else {

			Session::flash('danger', 'Innskráning mistókst. Vinsamlegast reyndu aftur. Notendanafn eða lykilorð er rangt.');
			Redirect::to('../index.php');

		}

	} else {

		// Notandi stóðst ekki reglurnar um lykilorð og fær villumeldingar
		// um það sem að hann gerði vitlaust í flash skilaboðum.
		$errors = '';
		foreach ($validation->errors() as $error) {
			$errors .= $error . '<br/>';
		}
		Session::flash('danger', $errors);
		Redirect::to('../index.php');

	}

}
