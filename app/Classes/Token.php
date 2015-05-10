<?php

/*
	Býr til token sem að er notað til þess að athuga hvort að notandinn hafi
	sjálfur útfyllt formið sem hann var að senda inn en ekki róbot eða
	verið að villa fyrir honum með url inputi.
	Eitthvað sem að Hringdu ætti að taka sér til fyrirmyndar svo til að koma
	í veg fyrir að fólk sé að misnota sér SMS formið þeirra eins og við erum
	að gera :)
*/

Class Token {

	// Býr til nýtt token og vistar það sem Session
	public static function generate() {
		return Session::put(Config::get('session/token_name'), md5(uniqid()));
	}

	// Athugar hvort að notandinn sé með token í session hjá sér og það passi
	// við tokenið sem er í hidden input á forminu
	public static function check($token) {

		// nær í token nafnið úr Confignum
		$tokenName = Config::get('session/token_name');

		// athuga hvort að allt stemmi ekki ef allt stemmir þá er Sessioninu deletað
		// og skilað true og notandi fær því að halda áfram.
		// Ef ekki er skilað false og notandi stoppaður
		if(Session::exists($tokenName) && $token === Session::get($tokenName)) {

			Session::delete($tokenName);
			return true;

		}

		return false;
	}
}
