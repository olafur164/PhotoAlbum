<?php

/*
	Config Class sem að sækir config stillingar skilgreindar í inti.php og skilar
	þeim til baka sem fylki
*/

Class Config {

	// Gerir mögulegt að sækja Config stillingar sem að eru í init.php
	public static function get($path = null) {

		if ($path) {
			$config = $GLOBALS['config'];
			$path = explode('/', $path);

			foreach ($path as $bit) {

				if (isset($config[$bit])) {
					$config = $config[$bit];
				}

			}

			return $config;
		}
		return false;
	}

}
