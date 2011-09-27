<?php

class HomeController extends CommonController {

	public function signin() {
		if (isset($_SESSION['user']) && $_SESSION['user']['is_logged_in'] === true) {
			$this->redirect('home');
		}

		$data = self::assignNavigation();
		$this->renderc('signin', $data);
	}

	public function index() {
		$data['baseurl'] = Doo::conf()->APP_URL;
		$data['title'] = "Life Shackle";
		$data['content'] = 'index';
		$data['nav'] = self::navigation();
		$data['customscript'] = "global/js/ori/index.js?v1";

		$this->render('template/layout', $data, true);
		
	}

}
?>
