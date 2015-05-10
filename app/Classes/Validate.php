<?php

/*
	Validation Class fyrir bakenda validation, ef eitthvað skildi sleppa í gegnum
	front end validationið þá tekur þessi classi á því
*/

Class Validate {
	private $_passed = false,
			$_errors = array();

	// Smiðurinn, sækir tengingu við gagnagrunn

	// Athugar hvort að notandi standist tiltekinn skylirði
	public function check($source, $items = array()) {
		$user = new User();

		// Loopar í gegnum allar reglurnar og athugar hvort að notandin standist
		// þær. Ef hann stenst þær ekki þá er skráð error og haldið áfram. Í lokinn
		// er notanda svo skilað saman öllum villunum sem komu og hann fær ekki að
		// halda áfram
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {

				$value = trim($source[$item]);
				$item = escape($item);

				// Athugar hvort að input sem má ekki vera tómt sé tómt
				if($rule === 'required' && empty($value)) {

					$this->addError("{$item} is necessary");

				} else if (!empty($value)) {

					switch ($rule) {

						// Athugar hvort notandi hafi ekki skrifað inn lágmarks stafabil, ef þess
						// er krafists
						case 'min':
							if(strlen($value) < $rule_value) {
								$this->addError("{$item} has to be minimum of {$rule_value} spaces.");
							}
							break;

						// Athugar hvort að notandi hafi staðist hámarks stafabil
						case 'max':
							if(strlen($value) > $rule_value) {
								$this->addError("{$item} has to be at most or less than {$rule_value} spaces.");
							}
							break;

						// Athugar hvort að input sé það sama og annað ákveðið input
						case 'matches':
							if($value != $source[$rule_value]) {
								$this->addError("{$rule_value} has the be the same has {$item}");
							}
							break;

						// Athugar hvort að það sem slegið er í input sé nokkuð til annarstaðar
						// í gagnagrunninum, t.d. einstakt username
						case 'unique':
							$check = $user->getUser($value);
							if($check == 1){
								$this->addError("{$item} already exists!.");
							}
							break;
					}
				}
			}
		}

		// Athugar hvort að notandi hafi staðist
		if (empty($this->_errors)) {
			$this->_passed = true;
		}

		return $this;
	}

	// Bætir við villu
	private function addError($error) {
		$this->_errors[] = $error;
	}

	// Skilar öllum villinum
	public function errors() {
		return $this->_errors;
	}

	// Skilar til baka hvort að notandinn hafi staðist
	public function passed() {
		return $this->_passed;
	}
}
