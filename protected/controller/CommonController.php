<?php

//handle session data and other common handy methods
class CommonController extends DooController {

	public function xss($str, $striptags=true) {
		if ($striptags) {
			$str = strip_tags($str);
		}

		if (!isset(Doo::conf()->xssFilter)) {
			Doo::loadClass('htmlpurifier/library/HTMLPurifier.auto');
			$purifyconfig = HTMLPurifier_Config::createDefault();
			$purifyconfig->set('Core.Encoding', 'UTF-8');
			$purifier = new HTMLPurifier($purifyconfig);
			Doo::conf()->xssFilter = $purifier;
			$str = htmlentities($str, ENT_COMPAT, 'UTF-8');
			return str_replace('&amp;', '&', $purifier->purify($str));
		}

		$str = htmlentities($str, ENT_COMPAT, 'UTF-8');
		return str_replace('&amp;', '&', Doo::conf()->xssFilter->purify($str));
	}

	public function escape_val($val) {

		if (get_magic_quotes_gpc()) {
			$val = stripcslashes($val);
		}
		return $val;
	}

}

?>
