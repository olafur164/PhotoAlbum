<?php

/*
		Session Class sér um að búa til, sækja og eyða sessions.
*/

Class Session {

	// Athugar hvort að session sé til, t.d. þegar notandi kemur á
	// síðuna og verið er að athuga hvort að hann sé innskráður
	public static function exists($name) {

		return (isset($_SESSION[$name])) ? true : false;
	}

	// Býr til nýtt Session
	public static function put($name, $value) {

		return $_SESSION[$name] = $value;
	}

	// Nær í ákveðið Session, yfirleitt þá eftir að hafa athuga
	// með Session::exists hvort að það sé til.
	public static function get($name) {

		return $_SESSION[$name];
	}

	// Eyðir ákveðnu sessioni, athugar fyrst með exists
	// function hér fyrir ofan hvort að það sé til með self::exists
	public static function delete($name) {

		if(self::exists($name)) {
			unset($_SESSION[$name]);
		}

	}

	// Býr til flash skilaboð fyrir notandann sem birtast um leið og hann
	// er redirectaður eitthvað eða han skiptir um síðu. Þessi skilaboð
	// byrtast aðeins einu sinni og við næsta refresh hverfa þau.
	// Erum að nota þetta t.d. til þess að láta notanda vita hvort að það
	// sem að hann hafi verið að gera hafi virkað eða ekki
	public static function flash($name, $string = null) {

		if(self::exists($name)) {

			$session = self::get($name);
			self::delete($name);
			return $session;

		} else {

			self::put($name, $string);
		}

		return '';
	}

}
