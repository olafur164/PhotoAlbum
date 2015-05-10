<?php

/*
	Öryggisklasi sem að dulkóðar lykilrð fyrir notandi, erum ekki að nota
	saltið vegna þess að það var ekki að virka næginlega vel, ekki gekk að bæta
	því við í gagnagrunninn af eitthveri ástæðu
*/

Class Hash {

	// Dulkóðar strenginn sem er settur með
	public static function make($string) {
		return password_hash($string, PASSWORD_DEFAULT);
		//return hash('sha256', $string);
	}

	// Býr til nýtt salt fyrir notanda
	public static function salt($length) {
		return mcrypt_create_iv($length);
	}

	// Býr til einstakt hash frá uniqid functioni
	public static function unique() {
		return self::make(uniqid());
	}
}
