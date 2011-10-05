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
		$data['version'] = Doo::conf()->version;
		$data['title'] = "Life Shackle";
		$data['content'] = 'index';
		$data['nav'] = self::navigation();

		if (isset($_SESSION['user']['role'])) {

			$data['customscript'] =  Doo::conf()->APP_URL."global/js/" . $_SESSION['user']['role'] . "/index.js?".Doo::conf()->version;
		} else {

			$data['customscript'] =  Doo::conf()->APP_URL."global/js/index.js?".Doo::conf()->version;
		}
		
		$this->render('template/layout', $data, true);
	}
}

?>
