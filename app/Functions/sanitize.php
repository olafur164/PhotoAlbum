<?php
// Function sem að kemur í veg fyrir XSS árásir
function escape($string) {

	return htmlentities($string, ENT_QUOTES, 'UTF-8');

}
