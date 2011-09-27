<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of About
 *
 * @author terryx
 */
class AboutController extends CommonController {

	public function index() {
		$data['baseurl'] = Doo::conf()->APP_URL;
		$data['title'] = "About Terry";
		$data['content'] = 'about';
		$data['nav'] = self::navigation();

		$this->render('template/layout', $data, true);
		
	}
	

}

?>
