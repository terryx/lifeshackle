<?php

class TemplateController extends DooController {
	
	//init function defined basic data object of html
	//render the page using the data object
	public function init($page, $title='Life Shackle') {
		$data['title'] = $title;
		$data['baseurl'] = Doo::conf()->APP_URL;
		$data['version'] = '12';
		$data['header'] = 'template/header';
		$data['nav'] = $this->navigation();
		$data['footer'] = 'template/footer';
		$data['content'] = $page;
		
		$this->render($data['content'], $data, true);
	}
	
	//navigation for visitor or admin
	protected function navigation(){
		Doo::loadController('SessionController');
		$session = new SessionController();
		$user_type = $session->checkRole();
		
		return $navbar = 'template/nav-' . $user_type;
		
	}
	
}

?>
