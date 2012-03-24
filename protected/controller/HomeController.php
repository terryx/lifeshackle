<?php

//homecontroller control all public pages for non-register user
class HomeController extends SessionController {
	
	private $template;
	
	public function __construct() {
		Doo::loadController('TemplateController');
		$this->template = new TemplateController();
	}
	
	public function index() {
		//set templates
		$data = $this->template->init('index');
	}


	public function article() {
		
		$this->render('article');
	}


	public function profile() {
		$data = $this->templateData(__FUNCTION__);
		
		Doo::loadController('ProfileController');
		$profile = new ProfileController();
		
		$data['profile_content'] = $profile->fetchContent();
		$profile_picture = $profile->getCurrent();
		$data['profile_img_link'] = $profile_picture[0];
		$data['profile_img_src'] = $profile_picture[1];
		
		$this->render('template/layout', $data, true);
	}
	
	public function store() {
		$data = $this->templateData(__FUNCTION__);
		$this->render('template/layout', $data, true);
	}

	public function contact(){
		$data = $this->templateData(__FUNCTION__);
		
		//Chat module
		$data['chatuser'] = isset($_COOKIE['lfshackschatuser']) ? $_COOKIE['lfshackschatuser'] : '';
		$data['chatemail'] = isset($_COOKIE['lfshackschatemail']) ? $_COOKIE['lfshackschatemail'] : '';
		
		$this->render('template/layout', $data, true);
	}
	
	public function login() {
		$this->template->init('login');
	}
}

?>