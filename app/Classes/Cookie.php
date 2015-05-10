<?php

/*
	Class sem að býr til nýja köku fyrir notanda, sækir kökur frá notanda
	eyðir kökum. Átti að nota fyrir remember me hlutann en kom upp villa
	þegar það átti að reyna á það þannig að þessi Class er ónotaður eins
	og er en möguleiki að nota hann seinna ef við höldum áfram með verkefnið
*/

Class Cookie {

	// Athugar hvort að kakan $name sé til
	public static function exists($name) {

		return (isset($_COOKIE[$name])) ? true : false;
	}

	// Sækir kökuna $name
	public static function get($name) {

		return $_COOKIE[$name];
	}

	// Býr til kökuna $name, með $value og $expiry tíma
	public static function put($name, $value, $expiry) {

		if(setcookie($name, $value, time() + $expiry, '/')) {

			return true;
		} else {

			return false;
		}
	}

	// Eyðir kökunni $name
	public static function delete($name) {

		self::put($name, '', time() -1);
	}

}
