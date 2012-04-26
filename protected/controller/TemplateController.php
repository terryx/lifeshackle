<?php

class TemplateController extends SessionController {

	private $data;
	private $version = 19;

	private function generate($file) {

		//before generate, check role
		$session = new SessionController();
		$role = $session->checkRole();

		if ($role === 'master') {
			$data = array(
				'title'		=> 'Master of Life',
				'baseurl'	=> Doo::conf()->APP_URL,
				'version'	=> $this->version,
				'header'	=> 'template/header',
				'nav'		=> 'template/nav-master',
				'content'	=> file_get_contents(Doo::conf()->SITE_PATH . 'protected/view/' . $file . '.html'),
				'footer'	=> 'template/footer'
			);
		} else {
			$data = array(
				'title'		=> 'Life \'s Shackle',
				'baseurl'	=> Doo::conf()->APP_URL,
				'version'	=> $this->version,
				'header'	=> 'template/header',
				'nav'		=> 'template/nav-visitor',
				'content'	=> file_get_contents(Doo::conf()->SITE_PATH . 'protected/view/' . $file . '.html'),
				'footer'	=> 'template/footer'
			);
		}
		
		$this->render('main', $data, true);
	}

	public function homepage() {
		//check role
		$this->generate('index');
	}

	public function login() {
		$this->generate('login');
	}

	public function article() {
		$this->generate('article');
	}

	public function video() {
		$this->generate('video');
	}

	public function profile() {
		$this->generate('profile');
	}

	public function master() {
		$this->generate('index');
	}
	
	public function master_article(){
		$this->generate('master/article');
	}
	
	public function master_video(){
		$this->generate('master/video');
	}
}

?>
