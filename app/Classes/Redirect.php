<?php

/*
	Redirect Class sér um að senda notanda á skylgreindan stað með
	static function, gerir kóðann læsilegri í staðinn fyrir að vera
	að nota header function aftur og aftur.
*/

Class Redirect {

	// Sendir notanda á ákveðinn stað á vefsíðunni, gerir líka auðveldara
	// fyrir að senda hann á error síður sem eru vistaðar í template
	public static function to($location = null) {

		if($location) {

			if(is_numeric($location)) {

				switch ($location) {
					case 404:
						header('HTTP/1.0 404 Not Found');
						include '404.php';
						exit();
						break;
				}

			}

			header('Location: ' . $location);
			exit();

		}
	}
}
