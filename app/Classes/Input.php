<?php

/*
	Input Class sem að sér um að athuga hvort að notandi hafi skilað
	inn gögnum úr formi.
*/

Class Input {

	// Athugar hvort að notandi hafi skrifað inn í input field
	public static function exists($type = 'post') {

		switch ($type) {

			case 'post':
				return (!empty($_POST)) ? true : false;
				break;

			case 'get':
				return (!empty($_GET)) ? true : false;
				break;

			default:
				return false;
				break;
		}

	}

	// Nær í það sem að notandinn skrifaði
	public static function get($item) {

		if(isset($_POST[$item])) {

			return $_POST[$item];
		}

		elseif (isset($_GET[$item])) {

			return $_GET[$item];
		}

		return '';
	}
}
