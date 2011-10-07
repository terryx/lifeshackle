<?php

/**
 * Description of About
 *
 * @author terryx
 */
class AboutController extends CommonController {

	public function index() {
		$data['baseurl'] = Doo::conf()->APP_URL;
		$data['version'] = Doo::conf()->version;
		$data['title'] = "About Terry";
		$data['content'] = 'about';
		$data['nav'] = self::navigation();
		
		$this->render('template/layout', $data, true);
		
	}
}

?>
